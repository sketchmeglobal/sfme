<?php
class Export_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function offer_comments() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Offer/offer_comments'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Comments');
            $crud->set_table('offer_comments');

            $crud->unset_read();
            $crud->unset_clone();

            $state_code = $crud->getState();

            if($user_id != 1){
                $crud->where('offer_comments.resource_id', $user_id);
                $crud->where('offer_comments.type', 'comment');
                $crud->unset_delete();
            }

            $crud->set_relation('offer_id','offers','{offer_name} - {offer_number}');
            
            $crud->display_as('offer_id','Offer');
            $crud->display_as('action','State');

            $crud->columns('offer_id','comment', 'action');
            $crud->fields('offer_id','resource_id', 'comment', 'type', 'action', 'status');
            $crud->field_type('resource_id', 'hidden', $this->session->user_id);
            $crud->field_type('type', 'hidden', 'comment');
            $crud->field_type('status', 'hidden', 0);
            
            if($state_code == 'edit') {

                $crud->required_fields('comment', 'action');
                // $crud->change_field_type('offer_id', 'readonly');

            } else {

                $crud->required_fields('offer_id','comment', 'action');

            }

            $this->table_name = 'offer_comments';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $output = $crud->render();
            
            //rending extra value to $output
            $output->tab_title = 'Offer Comments';
            $output->section_heading = 'Offer Comments <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Offer Comments';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
            
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }


    function comment_insert($post_array) {
        
        $new_array = array('resource_id' => $this->session->user_id);
        $post_array = array_merge($post_array, $new_array);
        // print_r($post_array); die;
        return $post_array;

    }   
    
     public function log_before_update($post_array,$primary_key){
        $insertArray = array(
            'table_name' => $this->table_name,
            'pk_id' => $primary_key,
            'action_taken'=>'edit', 
            'old_data' => json_encode($post_array),
            'user_id' => $this->session->user_id,
            'comment' => '-'
        );
        if($this->db->insert('user_logs', $insertArray)){
            return true;
        }else{
            return false;
        }
    }

    public function export() {

        $data["insert"] = '';

        if($this->input->post("template_assign_insert")){

            if(count((array)$this->input->post('marketing_id[]')) > 0){
                $mrk = join(',',$this->input->post('marketing_id[]'));
            }else{
                $mrk = '';
            }
            
            if(count((array)$this->input->post('resource_id[]')) > 0){
                $res = join(',',$this->input->post('resource_id[]'));
            }else{
                $res = '';
            }

            $insertArray = array(
                'offer_id' => $this->input->post('template_offer_id'),
                'vt_id' => $this->input->post('vt_id'),
                'marketing_id' => $mrk,
                'resource_id' => $res,
                'user_id' => $this->session->user_id
            );

            if($this->db->insert('assigned_templates', $insertArray)){

                $data["insert"] = 'Template Added Successfully';

            }

        }else if($this->input->post("template_assign_update") == "Update"){

            if(count((array)$this->input->post('marketing_id[]')) > 0){
                $mrk = join(',',$this->input->post('marketing_id[]'));
            }else{
                $mrk = '';
            }
            
            if(count((array)$this->input->post('resource_id[]')) > 0){
                $res = join(',',$this->input->post('resource_id[]'));
            }else{
                $res = '';
            }

            $at_id = $this->input->post('assigned_template_id');

            $updateArray = array(
                'at_id' => $this->input->post('assigned_template_id'),
                'vt_id' => $this->input->post('vt_id'),
                'resource_id' => $res,
                'marketing_id' => $mrk,
                'user_id' => $this->session->user_id
            );

            // print_r($updateArray); die;

            if($this->db->update('assigned_templates', $updateArray, array('at_id' => $at_id))){

                $data["insert"] = 'Template Updated Successfully'; 
                // . $this->db->last_query();

            }

        }else if($this->input->post("template_assign_update") == "Finalise"){

            $offer_id = $this->input->post('template_offer_id');

            $updateArray = array(
                'marketing_edit_status' => 1
            );

            if($this->db->update('assigned_templates', $updateArray, array('offer_id' => $offer_id))){

                $data["insert"] = 'Offer sent to marketing personnel'; 

            }
            
            if(count((array)$this->input->post('marketing_id[]')) > 0){
                $mrk = join(',',$this->input->post('marketing_id[]'));
            }else{
                $mrk = '';
            }
            ##PROBLEM IF MULTIPLE##
            // print_r($mrk); die;
            ##PROBLEM IF MULTIPLE##
            $to = $this->db->get_where('users', array('user_id' => $mrk))->result()[0]->email;
            $offer_name = $this->db->get_where('offers', array('offer_id' => $offer_id))->result()[0]->offer_name;
            $offer_no = $this->db->get_where('offers', array('offer_id' => $offer_id))->result()[0]->offer_number;
            $content = '<b>' . $offer_name . ' (' . $offer_no . ')</b> is finalized by the Trader. Please review at your earliest.';
            $this->sendmail($to, $content, 'STS - Offer Finalized by Trader!'); 
        }
        $data['title'] = 'Offer Lists';
        $data['menu'] = 'Offers';
        $data['mar_users'] = $this->db->get_where('users', array('usertype' => 3))->result();
        $data['res_users'] = $this->db->get_where('users', array('usertype' => 2))->result();
        $data['view_templates'] = $this->db->get_where('view_templates', array('status' => 1))->result();
        return array('page'=>'export/export_list_v', 'data'=>$data);
    }


    public function get_offer_list($user_id)
    {
       //return $this->db->get_where('users', array('user_id' => $user_id))->result()[0]->row()->offer_ids;

        $this->db->where('user_id', $user_id);
        $res = $this->db->get('users')->result();
        // echo '<pre>', print_r($res), '</pre>'; die;
        if(isset($res[0])){
            return $res[0]->offer_ids;    
        }else{
            return;
        }

       /* $sql = "SELECT offer_id, offer_name FROM offers 
         WHERE offer_id IN ($r1)";
       $offers = $this->db->query($sql);
       $offersval=  $offers->result_array();
       $offerarr = [];
       foreach ($offersval as $key => $value) {
          $offerarr[$value['offer_id']] = $value['offer_name'];
       }

       return $offerarr;*/


    }



    public function export_list()
    {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            // $crud->set_crud_url_path(base_url('admin_panel/Master/units'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Export Data');
            $crud->set_table('exportdata');
            
            $crud->unset_read();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_clone();

            $crud->add_action('Edit Export Data', '', '', 'fa fa-edit editex',array($this,'_callback_editpage_url'));
            $crud->add_action('View Offer', '', '', 'fa fa-eye vewofr',array($this,'_callback_webpage_url'));
            
            $offers =  $this->get_offer_list($user_id);
            
            $this->table_name = 'Export List';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->callback_column('freight',array($this,'_callback_freight'));
            $crud->callback_column('rlink_for_bl_to_appear',array($this,'_callback_rlink_for_bl_to_appear'));
            
            if(isset($_GET['dt'])){
                
                if($_GET['dt'] == 'cf'){
                $crud->columns('company','offer_id','fz_ref_no','country_id','supplier_id','partial_reference','sr_date','vend_pi', 'vend_inv_amt', 'vend_inv_amt_currency', 'vend_po_conf', 
                'cust_inco_id','pymt_terms_cust_id','responsible_purchase_id','responsible_sale_id','responsible_logistics_id');    
                }
                else if($_GET['dt'] == 'con'){
                    $crud->columns('offer_id','cust_po_no','cust_pi_conf','latest_dos','created_at','created_by','no_of_container');    
                }
                else if($_GET['dt'] == 'sd'){
                    $crud->columns('offer_id','etd','eta','final_clearance_date','freight','insurance','insurance_currency','rlink_for_bl_to_appear','besc_applied','bl_no','corrc_appr_by_cust','corrc_appr_cust_date','corrc_appr_to_vend','correc_appr_vend_date',
                    'docs_sent_to_sgs_for_clean_cer','draft_docs_recd','draft_docs_recd_date','draft_docs_sent','draft_docs_sent_date','final_docs_submitted','final_copy_cust','final_copy_cust_date','final_copy_vend',
                    'final_copy_vend_date','freight_agent','freight_invoice_no','insp_license_number','label_appr_cust','label_appr_vend','org_docs_cust','org_docs_cust_date','org_docs_vend','org_docs_vend_date','sale_contract','sc_qty','pi_sales_amt',
                    'pi_sales_amt_currency','po_purch_amt','c_id','qty_loaded','insp_aoc_coc','aoc_coc_date','dayes_delayed','rem_dayes_for_shipt','besc_others_no','check_list_applied','doc_courier_no_incoming','doc_courier_no_outgoing','container_discharge_date','doc_recd','svd');    
                }
                else if($_GET['dt'] == 'df'){
                    $crud->columns('offer_id','insp_sr_applied','insp_sr_number','packing_list_file','health_cer_file','bill_of_leading','sgs_cert','feri_cert','insp_report_file','besc_cert_file','appr_label_file',
                    'confirmed_po_file','confirmed_pi_file','micrbiology_report_file','other_export_report_file','any_other_quality_report_file');    
                }
                else if($_GET['dt'] == 'pay'){
                    $crud->columns('offer_id','adv_paid_to_vendor','adv_amt_cust_currency','advise_received_from_bank','adv_paid_to_vendor','adv_paid_vend_currency','adv_amt_to_vendor','adv_amt_vend_currency','adv_paid_to_vendor',
                    'adv_recd_from_cust_currency','cr_note_to_cust','cr_note_to_supp','dbt_note_to_cust','dbt_note_to_supp','dbt_note_cust_comm','lc_amt_recd','lc_amd_reqd','lc_amd_transfer','lc_critical_condition','lc_doc_submission_date','lc_expiry_date','lc_recd_cust','latest_doc_lc');    
                }
                else if($_GET['dt'] == 'info'){
                    $crud->columns('offer_id','actual_sale_amt','actual_sales_amt_currency','admin_appr','last_remark','mrktng_appr','resource_appr','remark_for_outstation','remark_from_outstation','remark_admin_rp','remark_finan_rp','remark_purch_rp',
                    'remark_sales_rp','think','dox_remark','shipt_remark','payment_remark','collect_remark','general_remark','accounts_appr','export_appr','finance_appr','last_edited_by','last_updated_at');    
                }
                
            }else {
                $crud->unset_columns('user_id', 'c_id');
                // $crud->columns('row_colour');
            }
            
            $crud->set_relation('offer_id','offers','offer_name','offer_id IN ('.$offers.')');
            $crud->set_relation('customer','acc_master','name');
            $crud->set_relation('supplier_id','acc_master','name');
            $crud->set_relation('vend_inv_amt_currency','currencies','currency');
            $crud->set_relation('cust_inco_id','incoterms','incoterm');
            $crud->set_relation('responsible_purchase_id','responsible_purchase','name');
            $crud->set_relation('responsible_sale_id','responsible_sales','name');
            $crud->set_relation('responsible_logistics_id','responsible_logistic','name');
            $crud->set_relation('pi_sales_amt_currency','currencies','currency');
            $crud->set_relation('adv_amt_cust_currency','currencies','currency');
            $crud->set_relation('adv_paid_vend_currency','currencies','currency');
            $crud->set_relation('adv_amt_vend_currency','currencies','currency');
            $crud->set_relation('adv_recd_from_cust_currency','currencies','currency');
            $crud->set_relation('actual_sales_amt_currency','currencies','currency');
            $crud->set_relation('insurance_currency','currencies','currency');
            $crud->set_relation('country_id','countries','name');
            $crud->set_relation('created_by','users','username');
            $crud->set_relation('last_edited_by','users','username');
            $crud->set_relation('row_colour','colors','color_hex_code');
            
            $crud->set_field_upload('packing_list_file','upload/export');
            $crud->set_field_upload('health_cer_file','upload/export');
            $crud->set_field_upload('bill_of_leading','upload/export');
            $crud->set_field_upload('sgs_cert','upload/export');
            $crud->set_field_upload('feri_cert','upload/export');
            $crud->set_field_upload('insp_report_file','upload/export');
            $crud->set_field_upload('besc_cert_file','upload/export');
            $crud->set_field_upload('appr_label_file','upload/export');
            $crud->set_field_upload('confirmed_po_file','upload/export');
            $crud->set_field_upload('confirmed_pi_file','upload/export');
            $crud->set_field_upload('micrbiology_report_file','upload/export');
            $crud->set_field_upload('any_other_quality_report_file','upload/export');
            

            // display field like

            $crud->display_as('offer_id', 'Offer');
            $crud->display_as('fz_ref_no', 'FZ No.');
            $crud->display_as('customer', 'Customers');
            $crud->display_as('actual_sale_amt', 'Actual Ammount (sale)');
            $crud->display_as('admin_appr', 'Admin Appear');

            //$crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->title = 'Export Data';
            $output->section_heading = 'Export Data <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Export Data';
            $output->add_button = '';
            $output->word_colour = $this->db->select('word, color_hex_code')->join('colors','colors.color_id = word_colors.color_id','left')->get('word_colors')->result();
            return array('page'=>'export/export_list', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }
    
    public function export_list_segment($sn)
    {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            // $crud->set_crud_url_path(base_url('admin_panel/Master/units'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Export Data');
            $crud->set_table('exportdata');
            
            $crud->unset_read();
            $crud->unset_add();
            $crud->unset_edit();
            $crud->unset_clone();

            $crud->add_action('Edit Export Data', '', '', 'fa fa-edit editex',array($this,'_callback_editpage_url'));
            $crud->add_action('View Offer', '', '', 'fa fa-eye vewofr',array($this,'_callback_webpage_url'));
            
            $offers =  $this->get_offer_list($user_id);
            
            $this->table_name = 'Export List';
            
            if($sn == 'cf'){
                $crud->columns('company','offer_id','fz_ref_no','country_id','customer','supplier_id','partial_reference','sr_date');    
            }
            else if($sn == 'con'){
                $crud->columns('offer_id','cust_po_no','cust_pi_conf','latest_dos','created_at','created_by','no_of_container','vend_pi', 'vend_inv_amt', 'vend_inv_amt_currency', 'vend_po_conf', 
                'cust_inco_id','pymt_terms_cust_id','responsible_purchase_id','responsible_sale_id','responsible_logistics_id');    
            }
            else if($sn == 'sd'){
                $crud->columns('offer_id','etd','eta','final_clearance_date','freight','insurance','insurance_currency','rlink_for_bl_to_appear','besc_applied','bl_no','corrc_appr_by_cust','corrc_appr_cust_date','corrc_appr_to_vend','correc_appr_vend_date',
                'docs_sent_to_sgs_for_clean_cer','draft_docs_recd','draft_docs_recd_date','draft_docs_sent','draft_docs_sent_date','final_docs_submitted','final_copy_cust','final_copy_cust_date','final_copy_vend',
                'final_copy_vend_date','freight_agent','freight_invoice_no','insp_license_number','label_appr_cust','label_appr_vend','org_docs_cust','org_docs_cust_date','org_docs_vend','org_docs_vend_date','sale_contract','sc_qty','pi_sales_amt',
                'pi_sales_amt_currency','po_purch_amt','c_id','qty_loaded','insp_aoc_coc','aoc_coc_date','dayes_delayed','rem_dayes_for_shipt','besc_others_no','check_list_applied','doc_courier_no_incoming','doc_courier_no_outgoing','container_discharge_date','doc_recd','svd');    
            }
            else if($sn == 'sub-sts'){
                $crud->columns('offer_id','svd','sta??','etd','atd','eta','ata','dayes_delayed','rem_dayes_for_shipt','container_discharge_date',
                'doc_courier_no_incoming','doc_courier_no_outgoing','bl_no');
            }
            else if($sn == 'sub-aod'){
                $crud->columns('offer_id');    
            }
            else if($sn == 'sub-psap'){
                $crud->columns('offer_id','insp_license_number','3rd_insp_upload','besc_others_no','insp_aoc_coc','aoc_coc_date',
                'docs_sent_to_sgs_for_clean_cer','besc_others_no','general_remark');    
            }
            else if($sn == 'sub-psd'){
                $crud->columns('offer_id','label_appr_cust','label_appr_vend');    
            }
            else if($sn == 'sub-psp'){
                $crud->columns('offer_id','draft_docs_recd','draft_docs_recd_date','draft_docs_sent','draft_docs_sent_date',
                'final_copy_cust','final_copy_cust_date','final_copy_vend_date','freight_agent','freight_invoice_no','freight',
                'org_docs_cust','org_docs_cust_date','org_docs_vend','org_docs_vend_date');    
            }
            else if($sn == 'df'){
                $crud->columns('offer_id','insp_sr_applied','insp_sr_number','packing_list_file','health_cer_file','bill_of_leading','sgs_cert','feri_cert','insp_report_file','besc_cert_file','appr_label_file',
                'confirmed_po_file','confirmed_pi_file','micrbiology_report_file','other_export_report_file','any_other_quality_report_file');    
            }
            else if($sn == 'pay'){
                $crud->columns('offer_id','adv_paid_to_vendor','adv_amt_cust_currency','advise_received_from_bank','adv_paid_to_vendor','adv_paid_vend_currency','adv_amt_to_vendor','adv_amt_vend_currency','adv_paid_to_vendor',
                'adv_recd_from_cust_currency','cr_note_to_cust','cr_note_to_supp','dbt_note_to_cust','dbt_note_to_supp','dbt_note_cust_comm','lc_amt_recd','lc_amd_reqd','lc_amd_transfer','lc_critical_condition','lc_doc_submission_date','lc_expiry_date','lc_recd_cust','latest_doc_lc');    
            }
            else if($sn == 'info'){
                $crud->columns('offer_id','actual_sale_amt','actual_sales_amt_currency','admin_appr','last_remark','mrktng_appr','resource_appr','remark_for_outstation','remark_from_outstation','remark_admin_rp','remark_finan_rp','remark_purch_rp',
                'remark_sales_rp','think','dox_remark','shipt_remark','payment_remark','collect_remark','general_remark','accounts_appr','export_appr','finance_appr','last_edited_by','last_updated_at','check_list_applied','no_of_container');    
            }
            
            $crud->set_relation('offer_id','offers','offer_name','offer_id IN ('.$offers.')');
            $crud->set_relation('customer','acc_master','name');
            $crud->set_relation('supplier_id','acc_master','name');
            $crud->set_relation('vend_inv_amt_currency','currencies','currency');
            $crud->set_relation('cust_inco_id','incoterms','incoterm');
            $crud->set_relation('responsible_purchase_id','responsible_purchase','name');
            $crud->set_relation('responsible_sale_id','responsible_sales','name');
            $crud->set_relation('responsible_logistics_id','responsible_logistic','name');
            $crud->set_relation('pi_sales_amt_currency','currencies','currency');
            $crud->set_relation('adv_amt_cust_currency','currencies','currency');
            $crud->set_relation('adv_paid_vend_currency','currencies','currency');
            $crud->set_relation('adv_amt_vend_currency','currencies','currency');
            $crud->set_relation('adv_recd_from_cust_currency','currencies','currency');
            $crud->set_relation('actual_sales_amt_currency','currencies','currency');
            $crud->set_relation('insurance_currency','currencies','currency');
            $crud->set_relation('country_id','countries','name');
            $crud->set_relation('created_by','users','username');
            $crud->set_relation('last_edited_by','users','username');
            
            $crud->set_field_upload('packing_list_file','upload/export');
            $crud->set_field_upload('health_cer_file','upload/export');
            $crud->set_field_upload('bill_of_leading','upload/export');
            $crud->set_field_upload('sgs_cert','upload/export');
            $crud->set_field_upload('feri_cert','upload/export');
            $crud->set_field_upload('insp_report_file','upload/export');
            $crud->set_field_upload('besc_cert_file','upload/export');
            $crud->set_field_upload('appr_label_file','upload/export');
            $crud->set_field_upload('confirmed_po_file','upload/export');
            $crud->set_field_upload('confirmed_pi_file','upload/export');
            $crud->set_field_upload('micrbiology_report_file','upload/export');
            $crud->set_field_upload('any_other_quality_report_file','upload/export');
            

            // display field like

            $crud->display_as('offer_id', 'Offer');
            $crud->display_as('fz_ref_no', 'FZ No.');
            $crud->display_as('customer', 'Customers');
            $crud->display_as('actual_sale_amt', 'Actual Ammount (sale)');
            $crud->display_as('admin_appr', 'Admin Appear');

            //$crud->field_type('user_id', 'hidden', $user_id);
            $crud->callback_before_update(array($this,'log_before_update'));
            $crud->callback_column('freight',array($this,'_callback_freight'));
            // $crud->callback_column('vendors',array($this,'_callback_vendors'));
            
            $output = $crud->render();
            //rending extra value to $output
            $output->title = 'Export Data';
            $output->section_heading = 'Export Data <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Export Data';
            $output->add_button = '';

            return array('page'=>'export/export_list', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function _callback_webpage_url($value, $row){
      return site_url('admin/export-report-list/'.$row->export_id);
    }

    public function _callback_editpage_url($value, $row){
        return site_url('admin/export-edit/'.$row->export_id);
    }
    
    public function _callback_rlink_for_bl_to_appear($value, $row) {
        return "<a href=$value target='_new'>$value</a>";
    }
    
    public function _callback_freight($value, $row) {
        
        $sql = "SELECT CONCAT(freight, ' ', currency) AS freight_value FROM `offer_details` 
        LEFT JOIN selling_price on selling_price.od_id=offer_details.od_id 
        LEFT JOIN sell_price_details on selling_price.sp_id=sell_price_details.sp_id
        LEFT JOIN currencies ON sell_price_details.currency_id = currencies.c_id
        WHERE offer_details.offer_id =".$row->offer_id;
        
        $spd = $this->db->query($sql)->row()->freight_value;
        
        return $spd;
        
    }
    
    public function _callback_vendors($value, $row) {
        
        $sql = "SELECT
        GROUP_CONCAT(t2.name) as name
        FROM
            `offers` AS t1
        LEFT JOIN acc_master AS t2
        ON
            FIND_IN_SET(t2.am_id, t1.am_id) > 0
        WHERE offer_id = $row->offer_id
        GROUP BY
            t1.offer_id";
        
        $vendors = $this->db->query($sql)->row()->name;
        
        return $vendors;
        
    }

    public function ajax_export_table_data() {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;

        //actual db table column names
        $column_orderable = array(
            0 => 'offer_name',
            1 => 'offer_date',
            2 => 'offers.am_id',
            4 => 'offers.resource_id'
        );
        // Set searchable column fields
        $column_search = array('offer_name','acc_master.name');
        // $column_search = array('co_no');

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $rs = $this->_offer_common_query($usertype, $user_id);


        //echo $user_id."<pre>"; print_r($rs); die();

        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $rs = $this->_offer_common_query($usertype, $user_id);
        }
        //if searching for something
        else {
            //$this->db->start_cache();
            // loop searchable columns
            
            $i = 0;
            foreach($column_search as $item){
                // first loop
                if($i===0){
                    //$this->db->group_start(); //open bracket
                    $this->db->where("(OR ".$item." LIKE '%".$search."%')");
                }else{
                    $this->db->where("(OR ".$item." LIKE '%".$search."%' OR)");
                }

                // last loop
               /* if(count((array)$column_search) - 1 == $i){
                    $this->db->group_end(); //close bracket
                }*/
                $i++;
            }
            //$this->db->stop_cache();

             $rs = $this->_offer_common_query($usertype, $user_id);
             /*echo $this->db->last_query();
             die();*/

            $totalFiltered = count((array)$rs);

            return  $rs = $this->_offer_common_query($usertype, $user_id);

            $this->db->flush_cache();
        }

        $data = array();

        foreach ($rs as $val) {

            // if($val->img){$img='<img src="'.base_url('assets/admin_panel/img/article_img/'.$val->img).'" width="50">';} else{$img='';}
            if($val->status == '1'){$status='Enable';} else{$status='Disable';}
            $wip = ($val->resource_edit_status == 0) ? 'Not finalised' : 'Finalised';
            $today = date('d-m-Y');
            $date1 = new DateTime($val->offer_date);
            $date2 = new DateTime($today);
            $diff = $date1->diff($date2);
            if($diff->y == 0 and $diff->m != 0){
                $age = $diff->m . ' months and ' . $diff->d . ' days';
            }else if($diff->y == 0 and $diff->m == 0){
                $age = $diff->d . ' days';
            }else{
                $age = $diff->y . ' year ' . $diff->m . ' months and ' . $diff->d . ' days';
            }
            // print_r($diff->d);die;

            $nestedData['offer_name'] = $val->offer_name;
            $nestedData['offer_no'] = $val->offer_number;
            $nestedData['offer_date'] = $val->offer_date;
            $nestedData['offer_age'] = $age;
            $nestedData['supplier_name'] = $val->supplier_name . ' ['.$val->supplier_code.']';
            $nestedData['country'] = $val->name . ' ['.$val->iso.']';
            $nestedData['currency'] = $val->currency . ' ['.$val->currency_code.']';
            
            $nestedData['action'] = $this->_offer_common_actions($usertype, $val->resource_edit_status, $val->at_id, $val->offer_id, $val->offer_name, $val->offer_number);

            // $this->_offer_common_actions($usertype, $val->resource_edit_status, $val->at_id, $val->offer_id, $val->offer_name, $val->offer_number)

            $data[] = $nestedData;

            // echo '<pre>', print_r($rs), '</pre>'; 
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return $json_data;
    } 



    public function ajax_get_offer_data(){
        $offer_id = $this->input->post('offer_id');

        $data = array();
        $offer_sql = $this->db->get_where('offers', array('offer_id' => $offer_id))->row();
        $sale_contract = $this->db->get_where('proforma_invoices', array('offer' => $offer_id))->row();
        $this->db->select('sum(quantity_offered) as sc_qty');
        $sc_qty = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();

        $customer = $this->db->get_where('sell_price_details', array('offer_id' => $offer_id))->result();

        foreach ($customer as $key => $value) {
           $data['customers'][] = $value->am_id;
        }

        if (empty($sc_qty[0]->sc_qty)) {
             $data['sc_qty'] = $sc_qty[0]->sc_qty;
        }else{
             $data['sc_qty'] = $sc_qty[0]->sc_qty;
        }

        if (empty($sale_contract->pi_number)) {
            $data['sale_contract_no'] = "N/A";
        }else{
            $data['sale_contract_no'] = $sale_contract->pi_number;
        }

        $vendor = array();    
        $data['am_id'] = explode(',',$offer_sql->am_id);
        foreach($data['am_id'] as $key=>$dv){
            $vendor[] = array(
                'am_id' => $dv,
                'name' => $this->db->get_where('acc_master',array('am_id' => $dv))->row()->name
            );
        }

        $data['vendors'] = $vendor;
        
        // print_r($data['vendors']); die;
        
        if(empty($offer_sql->offer_fz_number)){
            $data['fz_number'] = "N/A";
        }else{
            $data['fz_number'] = $offer_sql->offer_fz_number;
        }

        return $data;


    }


    private function _offer_common_query($usertype, $user_id){


        #for export
       // $id = array();

         $query0 = 'SELECT * FROM users WHERE user_id ='.$user_id;

         $offer_id = $this->db->query($query0)->result();


         $offer_id =  $offer_id[0]->offer_ids;


         /*if($offer_id[0]){
         
            $offer_id = $offer_id[0]->offer_ids;
            //$offer_id = explode(",",$offer_ids);

         }else{
            $offer_id = '';
         }*/

          //$offer_list = $this->db->where_in('offers.offer_id', $offer_id)->get('offers')->result();

         $query1 = 'SELECT `offers`.*, `assigned_templates`.`at_id`, `acc_master`.`name` as `supplier_name`, `acc_master`.`am_code` as `supplier_code`, DATE_FORMAT(offers.offer_date, "%d-%m-%Y") as offer_date, `currencies`.`currency`, `currencies`.`code` as `currency_code`, `users`.`username`, `firstname`, `lastname`, `countries`.`country_id`, `countries`.`iso`, `countries`.`name`, `remark1_offer_validity`.`remark`
            FROM `offers`
            LEFT JOIN `acc_master` ON `acc_master`.`am_id` = `offers`.`am_id`
            LEFT JOIN `currencies` ON `currencies`.`c_id` = `offers`.`c_id`
            LEFT JOIN `countries` ON `countries`.`country_id` = `offers`.`country_id`
            LEFT JOIN `users` ON `users`.`user_id` = `offers`.`resource_id`
            LEFT JOIN `user_details` ON `users`.`user_id` = `user_details`.`user_id`
            LEFT JOIN `remark1_offer_validity` ON `remark1_offer_validity`.`rov_id` = `offers`.`remarks_1`
            LEFT JOIN `assigned_templates` ON `assigned_templates`.`offer_id` = `offers`.`offer_id`
            WHERE `offers`.`status` = 1 AND `offers`.`offer_id`  IN('.$offer_id.')';



         //IN(134,137,198)

         $offer_list = $this->db->query($query1);

         return $offer_list->result();

        //return $offer_id = array_push($id,$offer_id);
        // $this->db->select('*');
        /*$this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
        $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
        $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
        $this->db->join('users', 'users.user_id = offers.resource_id', 'left');
        $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
        $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');
        $this->db->join('assigned_templates', 'assigned_templates.offer_id = offers.offer_id', 'left');
        $this->db->where_in('offer_id', $offer_id)->get('offers');*/
        
        /* echo $this->db->last_query();
        exit();*/

         //return $rs;
        
    }

    private function _offer_common_actions($usertype, $edit_status, $at_id, $offer_id, $offer_name, $offer_number){


         $nestedData = '
            <a href="'. base_url('admin/view-offer/'.$offer_id) .'/comp1" target="_blank" class="btn bg-yellow"><i class="fa fa-eye"></i> View</a>
            <a href="'. base_url('admin/export-edit/'.$offer_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>';


        return $nestedData;

        if($edit_status == 0 and $usertype == 2){
            # resource is still working
            $nestedData = '
            <a href="'. base_url('admin/view-offer/'.$offer_id) .'/comp1" class="btn bg-yellow"><i class="fa fa-eye"></i> View</a>
            <a href="'. base_url('admin/edit-offer/'.$offer_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-primary finalise"><i class="fa fa-check"></i> Finalise</a>
            <a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';
        }else if($edit_status == 1 and $usertype == 2){
            # resource not working
            $nestedData = '
            <a href="'. base_url('admin/view-offer/'.$offer_id) .'/comp1" class="btn bg-yellow"><i class="fa fa-eye"></i> View</a>
            <button data-offer_id="'.$offer_id.'" class="btn bg-beige clone"><i class="fa fa-refresh"></i> Clone</button>
            <a data-toggle="modal" data-target="#myModal" data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn bg-green request"><i class="fa fa-universal-access"></i> Request Access</a>';
        } else if($edit_status == 0 and $usertype == 1){
            # trader working
            $nestedData = '
            <a href="'. base_url('admin/view-offer/'.$offer_id) .'/comp1" class="btn bg-yellow"><i class="fa fa-eye"></i> View</a>
            <a href="'. base_url('admin/edit-offer/'.$offer_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';
        }else if($edit_status == 1 and $usertype == 1){
            /* href="'. base_url('admin/view-offer/'.$offer_id) .'"  */
            # trader not working -> ALREADY FINALISED
            $nestedData = '
            <button data-toggle="modal" data-at_id="'.$at_id.'" data-offer_id="'.$offer_id.'" data-offer_name="'.$offer_name.'" data-offer_number="'.$offer_number.'" data-target="#statusModal" class="btn statusModal" style="background:#795548; color:#fff"><i class="fa fa-clock-o"></i> Status </button> 
            <button data-toggle="modal" data-at_id="'.$at_id.'" data-offer_id="'.$offer_id.'" data-offer_name="'.$offer_name.'" data-offer_number="'.$offer_number.'" data-target="#settingsModal" class="btn settingsModal" style="background:#607d8b; color:#fff"><i class="fa fa-eye"></i> Template </button> 
            <a href="'. base_url('admin/view-offer/'.$offer_id) .'/comp1" class="btn bg-yellow"><i class="fa fa-eye"></i> View</a>
            <a href="'. base_url('admin/edit-offer/'.$offer_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <button data-toggle="modal" data-target="#commentModal" data-offer_id="'.$offer_id.'" href="" class="btn btn-warning all_comments"><i class="fa fa-check"></i> Request Access</button>
            <a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';
        }
        return $nestedData;

    }

    public function ajax_update_offer_wip(){
        $updateArray = array(
            'resource_edit_status' => 1
        );
        $offer_id = $this->input->post('offer_id');
        $this->db->update('offers', $updateArray, array('offer_id' => $offer_id));
        $data['type'] = 'success';
        $data['msg'] = 'Offer sucessfully sent to Trader'; 
        
        /*send mail to trader about the offer*/
        
        $to = $this->db->get_where('users', array('user_id' => 1))->result()[0]->email;
        $offer_name = $this->db->get_where('offers', array('offer_id' => $offer_id))->result()[0]->offer_name;
        $offer_no = $this->db->get_where('offers', array('offer_id' => $offer_id))->result()[0]->offer_number;
        $content = '<b>' . $offer_name . ' (' . $offer_no . ')</b> is finalized by the resource developer. Please review at your earliest.';
        
        $this->sendmail($to, $content, 'STS - Offer Finalized by Resource Developer!');            

        return $data;
    }

    public function ajax_show_all_comments(){
        $offer_id = $this->input->post('offer_id');
        $rs = $this->db
            ->select('users.username, offer_comments.*, offers.offer_name')
            ->join('offers','offers.offer_id = offer_comments.offer_id','left')
            ->join('users','users.user_id = offer_comments.resource_id','left')
            ->get_where('offer_comments', array('offer_comments.offer_id' => $offer_id))
            ->result();
            // echo $this->db->last_query();
             // echo $this->db->get_compiled_select('offer_comments');
        return $rs;     
    }

    public function ajax_update_offer_comments(){
        
        if($this->input->post('permission') == 'deny'){
            
            $updateCommentArray = array(
                'status' => 0
            );
            $oc_id = $this->input->post('oc_id');
            $this->db->update('offer_comments', $updateCommentArray, array('oc_id' => $oc_id));
    
            $data['type'] = 'warning';
            $data['msg'] = 'Edit permission denied!';
            
        }else{
            
            $updateCommentArray = array(
                'status' => 0
            );
            $oc_id = $this->input->post('oc_id');
            $this->db->update('offer_comments', $updateCommentArray, array('oc_id' => $oc_id));
    
            // fetch offer id
            $offer_id = $this->db->get_where('offer_comments', array('oc_id' => $oc_id))->result()[0]->offer_id;
            $updateOfferArray = array(
                'resource_edit_status' => 0
            );        
            $this->db->update('offers', $updateOfferArray, array('offer_id' => $offer_id));
    
            $data['type'] = 'success';
            $data['msg'] = 'Edit permission activated!';    
            
        }
        
        return $data;
    }
// ADD Offer 

    public function add_export() {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;

        $data['title'] = 'New Offer Lists';
        
        $data['menu'] = 'Offers';
        /*if($usertype == 1){
            # if admin
            $data['resources'] = $this->db->select('users.user_id, users.username, firstname, lastname')->join('user_details', 'users.user_id = user_details.user_id', 'left')->get_where('users', array('users.verified' => 1, 'users.blocked' => 0, 'users.usertype' => 2))->result();
        }else{
            # if others
            $data['resources'] = $this->db->select('users.user_id, users.username, firstname, lastname')->join('user_details', 'users.user_id = user_details.user_id', 'left')->get_where('users', array('users.verified' => 1, 'users.blocked' => 0, 'users.usertype' => 2, 'users.user_id' => $user_id))->result();
        } */
        $offers =  $this->get_offer_list($user_id);
        //print_r($offers); die();

        $data['offers'] = $this->db->query("SELECT * FROM offers WHERE offer_id IN ($offers)")->result();

        $data['incoterms'] = $this->db->query("SELECT * FROM incoterms WHERE status=1")->result();

        $data['currencies'] = $this->db->query("SELECT * FROM currencies WHERE status=1")->result();
        $data['colours'] = $this->db->query("SELECT * FROM colors")->result();
        $data['customers'] = $this->db->query("SELECT * FROM acc_master WHERE status=1 AND supplier_buyer=1")->result();
        $data['responsible_purchase'] = $this->db->query("SELECT * FROM responsible_purchase WHERE status=1")->result();

        $data['responsible_sales'] = $this->db->query("SELECT * FROM responsible_sales WHERE status=1")->result();

        /*$data['responsible_sales'] = $this->db->query("SELECT * FROM responsible_sales WHERE status=1")->result();
*/
        $data['responsible_logistic'] = $this->db->query("SELECT * FROM responsible_logistic WHERE status=1")->result();


        //echo $this->db->last_query();
        

        //print_r($data['offers']); die();
        $data['offer_name'] = 'OFFER/'. date('dmY/his');

        return array('page'=>'export/export_add_v', 'data'=>$data);
    }

    public function ajax_unique_offer_number() {
        $offer_number = $this->input->post('offer_number');
        $rs = $this->db->get_where('offers', array('offer_number' => $offer_number))->num_rows();
        // echo $this->db->last_query();die;
        
        if($rs != '0') {
            $data = 'Offer no. already exists.';
        }else{
            $data='true';
        }

        return $data;
    }

    public function request_offer(){

        $offer_id = $this->input->post('offer_id');
        $user_id = $this->session->user_id;

        // check if previous request is pending

        $pr = $this->db->get_where('offer_comments', array('offer_id' => $offer_id,'resource_id' => $user_id,'status' => 1))->num_rows();

        if($pr > 0){
            $data['type'] = 'warning';
            $data['title'] = 'Error!';
            $data['msg'] = 'Previous request is pending. Contact admin.';
        }else{
            $insertArray = array(
                'offer_id' => $offer_id,
                'resource_id' => $user_id,
                'comment' => $this->input->post('comment'),
                'type' => 'request'
            );
            $this->db->insert('offer_comments', $insertArray);
            $data['type'] = 'success';
            $data['msg'] = 'Request is successfully sent to Admin';  
        }
        return $data;   
    }

    public function form_add_export(){


        date_default_timezone_set("Asia/Dubai"); 

        error_reporting(E_ALL);

        $user_id = $this->session->user_id;

        $insertArray = array();
        $data = array();
        foreach ($this->input->post() as $key => $value) {
            if($key != "submit"){
                $insertArray[$key] = $value;
            }
        }
        
        // echo '<pre>', print_r($insertArray), '</pre>'; die;
        
        /* Rem. Days for Shipt Calculation */
        $date1 = new DateTime($this->input->post('etd'));
        $date2 = new DateTime();
        $remdays = $date1->diff($date2);
        $remdays = $remdays->days . " days ";
        $insertArray['rem_dayes_for_shipt'] = $remdays;
        /* Rem. Days for Shipt Calculation */

        /* Days Delayed  Calculation */
        $date1 = new DateTime($this->input->post('etd'));
        $date2 = new DateTime($this->input->post('latest_dos'));
        $dayes_delayed = $date1->diff($date2);
        $dayes_delayed = $dayes_delayed->days . " days ";
        $insertArray['dayes_delayed'] = $dayes_delayed;
        /* Days Delayed Calculation */


        $insertArray['created_by'] = $user_id;
        $insertArray['created_at'] = date('Y-m-d H:i:s');

        $return_data = array(); 

        $upload_path = './upload/export/' ; 
        $file_type = 'jpg|jpeg|png|doc|docx|pdf';

        $user_file_name = 'invoice_file';
        $return_data = $this->_upload_files($_FILES['invoice_file'], $upload_path, $file_type, $user_file_name);

         if($return_data['status'] == 'success'){
           $insertArray['invoice_file'] = $return_data['filename']; 
         }else{
            $return_data['msg'];
         }


        $user_file_name = 'packing_list_file';
        $return_data = $this->_upload_files($_FILES['packing_list_file'], $upload_path, $file_type, $user_file_name);

         if($return_data['status'] == 'success'){
           $insertArray['packing_list_file'] = $return_data['filename']; 
         }else{
            $return_data['msg'];
         }

        $user_file_name = 'health_cer_file';
        $return_data = $this->_upload_files($_FILES['health_cer_file'], $upload_path, $file_type, $user_file_name);

         if($return_data['status'] == 'success'){
           $insertArray['health_cer_file'] = $return_data['filename']; 
         }else{
            $return_data['msg'];
         }
         
        $user_file_name = 'cert_of_origin';
        $return_data = $this->_upload_files($_FILES['cert_of_origin'], $upload_path, $file_type, $user_file_name);

         if($return_data['status'] == 'success'){
           $insertArray['cert_of_origin'] = $return_data['filename']; 
         }else{
            $return_data['msg'];
         }

        $user_file_name = 'bill_of_leading';
        $return_data = $this->_upload_files($_FILES['bill_of_leading'], $upload_path, $file_type, $user_file_name);

         if($return_data['status'] == 'success'){
           $insertArray['bill_of_leading'] = $return_data['filename']; 
         }else{
            $return_data['msg'];
         }

        $user_file_name = 'sgs_cert';
        $return_data = $this->_upload_files($_FILES['sgs_cert'], $upload_path, $file_type, $user_file_name);

         if($return_data['status'] == 'success'){
           $insertArray['sgs_cert'] = $return_data['filename']; 
         }else{
            $return_data['msg'];
         }


        $user_file_name = 'besc_cert_file';
        $return_data = $this->_upload_files($_FILES['besc_cert_file'], $upload_path, $file_type, $user_file_name);
        if($return_data['status'] == 'success'){
           $insertArray['besc_cert_file'] = $return_data['filename']; 
         }else{
            $return_data['msg'];
         }


        $user_file_name = 'feri_cert';
        $return_data = $this->_upload_files($_FILES['feri_cert'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['feri_cert'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }


        $user_file_name = 'appr_label_file';
        $return_data = $this->_upload_files($_FILES['appr_label_file'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['appr_label_file'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }

        $user_file_name = 'confirmed_po_file';
        $return_data = $this->_upload_files($_FILES['confirmed_po_file'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['confirmed_po_file'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }


        $user_file_name = 'confirmed_pi_file';
        $return_data = $this->_upload_files($_FILES['confirmed_pi_file'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['confirmed_pi_file'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }

        $user_file_name = 'micrbiology_report_file';
        $return_data = $this->_upload_files($_FILES['micrbiology_report_file'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['micrbiology_report_file'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }

        $user_file_name = 'insp_report_file';
        $return_data = $this->_upload_files($_FILES['insp_report_file'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['insp_report_file'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }

        $user_file_name = 'other_export_report_file';
        $return_data = $this->_upload_files($_FILES['other_export_report_file'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['other_export_report_file'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }

        $user_file_name = 'any_other_quality_report_file';
        $return_data = $this->_upload_files($_FILES['any_other_quality_report_file'], $upload_path, $file_type, $user_file_name);

        if($return_data['status'] == 'success'){
            $insertArray['any_other_quality_report_file'] = $return_data['filename']; 
        }else{
            $return_data['msg'];
        }
    
         
        /* For Testing */
        //echo '<pre>', print_r($insertArray), '</pre>'; 
        /*$arr1  = $this->db->list_fields('exportdata');
         echo "Input Field ". count($data);
        echo '<pre>', print_r($arr1), '</pre>'; */       
       /* foreach ($arr1 as $key => $value) {
            if (!in_array($value, $data)) {
                echo $value . "<br>";
            }
        }*/
        /* For Testing End */ //die;

         $this->db->insert('exportdata', $insertArray);



         redirect('admin/export-list');
    }




    private function _upload_files($files, $upload_path, $file_type, $user_file_name){

        // date_default_timezone_set("Asia/Kolkata");  

        $uploadedFileData = array();

        $config = array(
            'upload_path'   => $upload_path,
            'allowed_types' => $file_type,
            'overwrite'     => 1,                       
        );

        $this->load->library('upload', $config);

        //foreach ($files['name'] as $key => $image) {

            $_FILES['file']['name']       = rand(1000,9999).$_FILES[$user_file_name]['name'];
            $_FILES['file']['type']       = $_FILES[$user_file_name]['type'];
            $_FILES['file']['tmp_name']   = $_FILES[$user_file_name]['tmp_name'];
            $_FILES['file']['error']      = $_FILES[$user_file_name]['error'];
            $_FILES['file']['size']       = $_FILES[$user_file_name]['size'];

            // $config['file_name'] = date('His') .'_'. $image;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {
                
                $imageData = $this->upload->data();

                $new_array = array(
                    'filename' => $imageData['file_name'], 
                    'status' => 'success',
                    'msg' => 'OK'
                );

                $final_array = array_merge($uploadedFileData, $new_array);

            } else {
                $new_array = array(
                    'filename' => null, 
                    'status' => 'error',
                    'msg' => 'Type or Size Mismatch'
                );

                $final_array = array_merge($uploadedFileData, $new_array);
            }
        //}

        return $final_array;
    }

    public function export_edit($export_id) {
       
       $usertype = $this->session->usertype;
       $user_id = $this->session->user_id;

        $data['title'] = 'Edit Export';
        $data['menu'] = 'Export';

        $offers =  $this->get_offer_list($user_id);
        $data['offers'] = $this->db->query("SELECT * FROM offers WHERE offer_id IN ($offers)")->result();
        $data['incoterms'] = $this->db->query("SELECT * FROM incoterms WHERE status=1")->result();

        $data['currencies'] = $this->db->query("SELECT * FROM currencies WHERE status=1")->result();
        $data['colours'] = $this->db->query("SELECT * FROM colors")->result();
        $data['customers'] = $this->db->query("SELECT * FROM acc_master WHERE status=1 AND supplier_buyer=1")->result();
        $data['suppliers'] = $this->db->query("SELECT * FROM acc_master WHERE status=1 AND supplier_buyer=0")->result();
        $data['responsible_purchase'] = $this->db->query("SELECT * FROM responsible_purchase WHERE status=1")->result();
        $data['responsible_sales'] = $this->db->query("SELECT * FROM responsible_sales WHERE status=1")->result();
        $data['responsible_sales'] = $this->db->query("SELECT * FROM responsible_sales WHERE status=1")->result();
        $data['responsible_logistic'] = $this->db->query("SELECT * FROM responsible_logistic WHERE status=1")->result();

        $data['export_details'] = $this->db
            ->join('colors','colors.color_id=exportdata.row_colour','left')
            ->join('acc_master','acc_master.am_id=exportdata.supplier_id','left')
            ->get_where('exportdata', array('export_id' => $export_id))->row();

        $offer_id = $data['export_details']->offer_id;



        $this->db->where('export_id',$export_id);
        $data['loaded_qty1'] = $this->db->get('export_details ')->result_array();




        $this->db->select('od_id, product_name, pieces, grade, quantity_offered , symbol, currency, packing_sizes.packing_size , offer_details.quantity_offered, offer_details.cartons_offered');

        /*c_id*/


        $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');

        $this->db->join('offers', 'offers.offer_id = offer_details.offer_id', 'left');

        $this->db->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left');


        $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');

        $data['export_details_products'] = $this->db->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result_array();


        //$data['export_details_product'] = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result_array();

        /*
        echo "<pre>";

        print_r($data['export_details_products']);

        die();*/

        return array('page'=>'export/export_edit_v', 'data'=>$data);
    }



    public function get_price_details()
    {
        $data = array();

        $pid = $this->input->post('pid');

        /*buying price data*/

                                $this->db->select('buying_price, final_buying_price');
        $data['buying_price'] = $this->db->get_where('buying_price', array('od_id' => $pid))->result_array();


        /* selling price */


        $this->db->select('final_selling_price');
        $data['selling_price'] = $this->db->get_where('selling_price', array('od_id' => $pid))->result_array();


        return $data;


    }

    public function add_export_product_qty()
    {
        /*echo "<pre>";

        print_r($this->input->post());

        die();*/

        $this->db->where('export_id',$this->input->post('export_id'));
        $count = $this->db->get('export_details')->num_rows();

        if($count != 0){
            $this->db->where('export_id', $this->input->post('export_id'))->delete('export_details');

        }

    $insertArray = array();
    $data = array();
    for ($i=0; $i <= $this->input->post('product_count') ; $i++) {

        $insertArray['export_id'] = $this->input->post('export_id');

        $insertArray['offer_id'] = $this->input->post('offer_id_pd');        

        $insertArray['od_id'] = $this->input->post('od_id_'.$i);

        $insertArray['qty_loaded'] = $this->input->post('qty_loaded_'.$i);

        $insertArray['qty_loaded_date'] = date('Y-m-d', strtotime($this->input->post('qty_loaded_date_'.$i)));

        $this->db->insert('export_details', $insertArray);

    }

     $data['type'] = 'success';
     $data['msg'] = 'Export quantity save successfully.';

    return $data;



        
    }

    public function ajax_unique_offer_number_edit() {
        $offer_number = $this->input->post('offer_number');
        $offer_id = $this->input->post('offer_id');

        $rs = $this->db->where('offer_id !=', $offer_id)->get_where('offers', array('offer_number' => $offer_number))->num_rows();
        // echo $this->db->last_query();die;
        
        if($rs != 0) {
            $data = 'Offer no. already exists.';
        }else{
            $data='true';
        }

        return $data;
    }

    public function form_edit_export(){
       
        try {

        date_default_timezone_set("Asia/Dubai"); 

        //error_reporting(E_ALL);

        $user_id = $this->session->user_id;

        $updateArray = array();
        $data = array();
        foreach ($this->input->post() as $key => $value) {
            if($key != "submit" && $key != "export_id"){
            $updateArray[$key] = $value;
            }
        }
        /* Rem. Days for Shipt Calculation */
        $date1 = new DateTime($this->input->post('etd'));
        $date2 = new DateTime();
        $remdays = $date1->diff($date2);

        if($remdays->days == 0){
        $remdays = "";
        }else{
            $remdays = $remdays->days . " days ";
        }


        $updateArray['rem_dayes_for_shipt'] = $remdays;
        /* Rem. Days for Shipt Calculation */

        /* Days Delayed  Calculation */
        $date1 = new DateTime($this->input->post('etd'));
        $date2 = new DateTime();
        $dayes_delayed = $date1->diff($date2);

        if($dayes_delayed->days == 0){
            $dayes_delayed = "";
        }else{
           $dayes_delayed = $dayes_delayed->days . " days "; 
        }
        


        $updateArray['dayes_delayed'] = $dayes_delayed;
        /* Days Delayed Calculation */


        $updateArray['user_id'] = $user_id;
        $updateArray['last_edited_by'] = $user_id;
        $updateArray['last_updated_at'] = date('Y-m-d H:i:s');

        $export_details_file = $this->db->get_where('exportdata', array('export_id' => $this->input->post('export_id')))->row();
        
        $return_data = array(); 

        $upload_path = './upload/export/' ; 
        $file_type = 'jpg|jpeg|png|doc|docx|pdf';

            if (!empty($_FILES['invoice_file'])) {
                $user_file_name = 'invoice_file';
                $return_data = $this->_upload_files($_FILES['invoice_file'], $upload_path, $file_type, $user_file_name);

                 if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->invoice_file);
                   $updateArray['invoice_file'] = $return_data['filename'];
                 }else{
                    $return_data['msg'];
                 }
            }


            if (!empty($_FILES['packing_list_file'])) {
                $user_file_name = 'packing_list_file';
                $return_data = $this->_upload_files($_FILES['packing_list_file'], $upload_path, $file_type, $user_file_name);

                 if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->packing_list_file);
                   $updateArray['packing_list_file'] = $return_data['filename']; 
                 }else{
                    $return_data['msg'];
                 }
            }

            if (!empty($_FILES['health_cer_file'])) {
                $user_file_name = 'health_cer_file';
                $return_data = $this->_upload_files($_FILES['health_cer_file'], $upload_path, $file_type, $user_file_name);

                 if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->health_cer_file);
                   $updateArray['health_cer_file'] = $return_data['filename']; 
                 }else{
                    $return_data['msg'];
                 }
            }
             
            if (!empty($_FILES['cert_of_origin'])) {
                $user_file_name = 'cert_of_origin';
                $return_data = $this->_upload_files($_FILES['cert_of_origin'], $upload_path, $file_type, $user_file_name);

                 if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->cert_of_origin);
                   $updateArray['cert_of_origin'] = $return_data['filename']; 
                 }else{
                    $return_data['msg'];
                 }
            }

            if (!empty($_FILES['bill_of_leading'])) {
                $user_file_name = 'bill_of_leading';
                $return_data = $this->_upload_files($_FILES['bill_of_leading'], $upload_path, $file_type, $user_file_name);

                 if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->bill_of_leading);
                   $updateArray['bill_of_leading'] = $return_data['filename']; 
                 }else{
                    $return_data['msg'];
                 }
            }

            if (!empty($_FILES['sgs_cert'])) {
                $user_file_name = 'sgs_cert';
                $return_data = $this->_upload_files($_FILES['sgs_cert'], $upload_path, $file_type, $user_file_name);

                 if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->sgs_cert);
                   $updateArray['sgs_cert'] = $return_data['filename']; 
                 }else{
                    $return_data['msg'];
                 }
            }

            if (!empty($_FILES['besc_cert_file'])) {
                $user_file_name = 'besc_cert_file';
                $return_data = $this->_upload_files($_FILES['besc_cert_file'], $upload_path, $file_type, $user_file_name);
                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->besc_cert_file);
                   $updateArray['besc_cert_file'] = $return_data['filename']; 
                 }else{
                    $return_data['msg'];
                 }
            }


            if (!empty($_FILES['feri_cert'])) {
                $user_file_name = 'feri_cert';
                $return_data = $this->_upload_files($_FILES['feri_cert'], $upload_path, $file_type, $user_file_name);

                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->feri_cert);
                    $updateArray['feri_cert'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }


            if (!empty($_FILES['appr_label_file'])) {
                $user_file_name = 'appr_label_file';
                $return_data = $this->_upload_files($_FILES['appr_label_file'], $upload_path, $file_type, $user_file_name);

                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->appr_label_file);
                    $updateArray['appr_label_file'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }

            if (!empty($_FILES['confirmed_po_file'])) {
                $user_file_name = 'confirmed_po_file';
                $return_data = $this->_upload_files($_FILES['confirmed_po_file'], $upload_path, $file_type, $user_file_name);

                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->confirmed_po_file);
                    $updateArray['confirmed_po_file'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }


            if (!empty($_FILES['confirmed_pi_file'])) {
                $user_file_name = 'confirmed_pi_file';
                $return_data = $this->_upload_files($_FILES['confirmed_pi_file'], $upload_path, $file_type, $user_file_name);

                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->confirmed_pi_file);
                    $updateArray['confirmed_pi_file'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }

            if (!empty($_FILES['micrbiology_report_file'])) {
                $user_file_name = 'micrbiology_report_file';
                $return_data = $this->_upload_files($_FILES['micrbiology_report_file'], $upload_path, $file_type, $user_file_name);

                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->micrbiology_report_file);
                    $updateArray['micrbiology_report_file'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }

            if (!empty($_FILES['insp_report_file'])) {
                $user_file_name = 'insp_report_file';
                $return_data = $this->_upload_files($_FILES['insp_report_file'], $upload_path, $file_type, $user_file_name);

                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->insp_report_file);
                    $updateArray['insp_report_file'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }

            if (!empty($_FILES['other_export_report_file'])) {
                $user_file_name = 'other_export_report_file';
                $return_data = $this->_upload_files($_FILES['other_export_report_file'], $upload_path, $file_type, $user_file_name);

                if($return_data['status'] == 'success'){
                    @unlink($upload_path.$export_details_file->other_export_report_file);
                    $updateArray['other_export_report_file'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }

            if (!empty($_FILES['any_other_quality_report_file']['name'])) {

                $user_file_name = 'any_other_quality_report_file';
                $return_data = $this->_upload_files($_FILES['any_other_quality_report_file'], $upload_path, $file_type, $user_file_name);
                if($return_data['status'] == 'success'){

                    @unlink($upload_path.$export_details_file->any_other_quality_report_file); 

                    $updateArray['any_other_quality_report_file'] = $return_data['filename']; 
                }else{
                    $return_data['msg'];
                }
            }
            //echo $this->input->post('export_id');
            //echo '<pre>', print_r($updateArray), '</pre>';die;
            $export_id = $this->input->post('export_id');

             if($this->db->update('exportdata', $updateArray, array('export_id' => $export_id))){


                //redirect('admin/export-edit/'.$export_id);

                redirect('admin/export-list');
             }else{
                redirect('admin/export-edit/'.$export_id);
             }
            
        } catch (Exception $e) {
            echo $e;
        }

         

    }

    public function ajax_offer_details_table_data() {
        $offer_id = $this->input->post('offer_id');
        //actual db table column names
        $column_orderable = array(
            0 => 'offer_details.product_id'
        );
        // Set searchable column fields
        $column_search = array('product_name');
        // $column_search = array('co_no');

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $this->db->select('offer_details.od_id, offer_details.offer_id, quantity_offered, product_price, product_name, scientific_name');
        $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
        $rs = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();
        
        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);
            
            $this->db->select('offer_details.od_id, offer_details.offer_id, quantity_offered, product_price, product_name, scientific_name');
        $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
        $rs = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();
        }
        //if searching for something
        else {
            $this->db->start_cache();
            // loop searchable columns
            $i = 0;
            foreach($column_search as $item){
                // first loop
                if($i===0){
                    $this->db->group_start(); //open bracket
                    $this->db->like($item, $search);
                }else{
                    $this->db->or_like($item, $search);
                }
                // last loop
                if(count((array)$column_search) - 1 == $i){
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }
            $this->db->stop_cache();

            $this->db->select('offer_details.od_id, offer_details.offer_id, quantity_offered, product_price, product_name, scientific_name');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $rs = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();      

            $totalFiltered = count((array)$rs);

            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $this->db->select('offer_details.od_id, offer_details.offer_id, quantity_offered, product_price, product_name, scientific_name');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $rs = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();

            $this->db->flush_cache();
        }

        $data = array();
        

        foreach ($rs as $val) {
            
            $nestedData['name'] = $val->product_name;
            $nestedData['scientific_name'] = $val->scientific_name;
            $nestedData['quantity'] = $val->quantity_offered;
            $nestedData['price'] = $val->product_price;
            $nestedData['total_price'] = $val->product_price * $val->quantity_offered;

            if($this->session->usertype == 1){

                $nestedData['action'] = '<a href="javascript:void(0)" data-od_id="'.$val->od_id.'" class="offer_details_edit_btn btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                <a title="Intra-Copy (Current Offer Details)" href="javascript:void(0)" data-od_id="'.$val->od_id.'" class="offer_details_clone_btn btn bg-beige"><i class="fa fa-clone"></i> Clone</a>
                <a title="Inter-Copy (Other Offer Details)" href="javascript:void(0)" data-od_id="'.$val->od_id.'" class="offer_details_export_btn btn bg-yellow"><i class="fa fa-clone"></i> Export</a>
                <a href="javascript:void(0)" data-offer_id="'.$val->offer_id.'" data-od_id="'.$val->od_id.'" class="offer_details_pricing_btn btn bg-green1"><i class="fa fa-clone"></i> Pricing</a>
                <a data-tab="offer_details" data-pk="'.$val->od_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';

            }else{

                $nestedData['action'] = '<a href="javascript:void(0)" data-od_id="'.$val->od_id.'" class="offer_details_edit_btn btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                <a title="Intra-Copy (Current Offer Details)" href="javascript:void(0)" data-od_id="'.$val->od_id.'" class="offer_details_clone_btn btn bg-beige"><i class="fa fa-clone"></i> Clone</a>
                <a title="Inter-Copy (Other Offer Details)" href="javascript:void(0)" data-od_id="'.$val->od_id.'" class="offer_details_export_btn btn bg-yellow"><i class="fa fa-clone"></i> Export</a>
                <a data-tab="offer_details" data-pk="'.$val->od_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';

            }
            
            $data[] = $nestedData;

            // echo '<pre>', print_r($rs), '</pre>'; 
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return $json_data;
    }  


    public function ajax_fetch_assigned_templates($offer_id){
        
        $rs = $this->db
            ->select('template_name, view_templates.vt_id,assigned_templates.marketing_id, assigned_templates.resource_id')
            // ->join('users','users.user_id = marketing_id','left')
            // ->join('user_details','users.user_id = user_details.user_id','left')
            ->join('view_templates','view_templates.vt_id = assigned_templates.vt_id','left')
            ->where(array('assigned_templates.offer_id' => $offer_id))
            ->get('assigned_templates')
            ->result();

        return $rs;    

        // echo $this->db->get_compiled_select('assigned_templates');
        // exit();        

    }
    
    
    public function ajax_fetch_offer_status($offer_id){
        
        $data["offer_resource_headers"] = $this->db
            ->select('offer_name,DATE_FORMAT(offer_date, "%d-%b-%Y") as offer_date,firstname,lastname, offers_resource.created_date')
            ->join('users','users.user_id = offers_resource.resource_id','left')
            ->join('user_details','users.user_id = user_details.user_id','left')
            ->where(array('offers_resource.offer_id' => $offer_id))
            ->get('offers_resource')
            ->result();
    
        $data["offer_headers"] = $this->db
            ->select('resource_edit_status,final_marketing_approval_status')
            ->where(array('offers.offer_id' => $offer_id))
            ->get('offers')
            ->result();
    
        $data["rd_product_count"] = $this->db
            ->where(array('offer_details_resource.offer_id' => $offer_id))
            ->get('offer_details_resource')
            ->num_rows();
    
        $data["rd_access"] = $this->db
            ->where(array('offer_id' => $offer_id, 'status' => 1))
            ->get('offer_comments')
            ->num_rows();
            
        $data["trader_product_count"] = $this->db
            ->where(array('offer_details.offer_id' => $offer_id))
            ->get('offer_details')
            ->num_rows();    
            
        $data["trader_buying_pricing_count"] = $this->db
            ->join('buying_price','buying_price.od_id = offer_details.od_id', 'left')
            ->where(array('offer_details.offer_id' => $offer_id, 'buying_price.status' => 1))
            ->group_by('buying_price.od_id')
            ->get('offer_details')
            ->num_rows();      
        
        $data["trader_selling_pricing_count"] = $this->db
            ->join('selling_price','selling_price.od_id = offer_details.od_id', 'left')
            ->where(array('offer_details.offer_id' => $offer_id, 'selling_price.status' => 1))
            ->group_by('selling_price.od_id')
            ->get('offer_details')
            ->num_rows(); 
            
        $data["template_assign_count"] = $this->db
            ->where(array('assigned_templates.offer_id' => $offer_id))
            ->get('assigned_templates')
            ->num_rows();     
        
        $data["template_finalise_count"] = $this->db
            ->where(array('assigned_templates.offer_id' => $offer_id, 'marketing_edit_status' => 1))
            ->get('assigned_templates')
            ->num_rows();    
            
        return $data;    

        // echo $this->db->get_compiled_select('assigned_templates');
        // exit();        

    }

    public function form_add_offer_details(){
        
        $insertArray = array(
            'offer_id' => $this->input->post('offer_id'),
            'product_id' => $this->input->post('product_id'),
            'product_description' => $this->input->post('product_description'),
            'freezing_method_id' => $this->input->post('freezing_method_id'),
            'primary_packing_type_id' => $this->input->post('primary_packing_type_id'),
            'secondary_packing_type_id' => $this->input->post('secondary_packing_type_id'),
            'packing_size_id' => $this->input->post('packing_size_id'),

            'glazing_id' => $this->input->post('glazing_id'),
            'block_id' => $this->input->post('block_id'),
            'size_id' => $this->input->post('size_id'),
            'size_before_glaze' => $this->input->post('size_before_glaze'),
            'size_after_glaze' => $this->input->post('size_after_glaze'),
            'quantity_offered' => $this->input->post('quantity_offered'),

            'unit_id' => $this->input->post('unit_id'),
            'pieces' => $this->input->post('pieces'),
            'grade' => $this->input->post('grade'),
            'cartons_offered' => $this->input->post('cartons_offered'),
            'product_price' => $this->input->post('product_price'),
            'comment' => $this->input->post('comment'),
            'user_id' => $this->session->user_id
        );
        // echo '<pre>', print_r($insertArray), '</pre>';die;
        $this->db->insert('offer_details', $insertArray);
        
        if($this->db->insert_id() > 0){

            $original_offer_details_id = $this->db->insert_id();
            $data['insert_id'] = $original_offer_details_id;
            
            $this->db->insert('offer_details_resource', $insertArray);
            $resource_offer_details_id = $this->db->insert_id();
            
            // Update resource offer id with current offer ID
            
            $updateArray = array(
                'od_id' => $original_offer_details_id
            );
        
            $this->db->update('offer_details_resource', $updateArray, array('odr_id' => $resource_offer_details_id));
            
            $data['type'] = 'success';
            $data['msg'] = 'Offer details added successfully.';
            
        }else{
            
            $data['type'] = 'error';
            $data['msg'] = 'Offer not added. Contact Admin';
            
        }
        // $data['insert_id'] = $this->db->insert_id();
        
         
        return $data;
    }
    
    public function fetch_offer_details_on_pk(){
        $od_id = $this->input->post('pk');
        return $rs = $this->db->get_where('offer_details', array('od_id' => $od_id))->result();
        
    }

    public function form_edit_offer_details(){
        
        $updateArray = array(
            'offer_id' => $this->input->post('offer_id_edit'),
            'product_id' => $this->input->post('product_id_edit'),
            'freezing_id' => $this->input->post('freezing_id_edit'),
            'freezing_method_id' => $this->input->post('freezing_method_edit'),
            'primary_packing_type_id' => $this->input->post('primary_packing_type_id_edit'),
            'secondary_packing_type_id' => $this->input->post('secondary_packing_type_id_edit'),
            'packing_size_id' => $this->input->post('packing_size_id_edit'),

            'glazing_id' => $this->input->post('glazing_id_edit'),
            'block_id' => $this->input->post('block_id_edit'),
            'size_id' => $this->input->post('size_id_edit'),
            'size_before_glaze' => $this->input->post('size_before_glaze_edit'),
            'size_after_glaze' => $this->input->post('size_after_glaze_edit'),
            'quantity_offered' => $this->input->post('quantity_offered_edit'),

            'grade' => $this->input->post('grade_edit'),
            'pieces' => $this->input->post('pieces_edit'),
            'unit_id' => $this->input->post('unit_id_edit'),
            'cartons_offered' => $this->input->post('cartons_offered_edit'),
            'product_price' => $this->input->post('product_price_edit'),
            'comment' => $this->input->post('comment_edit'),
            'user_id' => $this->session->user_id
        );
        $od_id = $this->input->post('offer_details_id_edit');
        
        // echo '<pre>', print_r($updateArray), '</pre>';die;
        $this->db->update('offer_details', $updateArray, array('od_id' => $od_id));
        // echo $this->db->last_query();die;


        $data['type'] = 'success';
        $data['msg'] = 'Offer details updated successfully.';
        return $data;
    }

    public function form_export_offer_details(){
        
        $insertArray = array(
            'offer_id' => $this->input->post('offer_id_export'),
            'product_id' => $this->input->post('product_id_export'),
            'freezing_id' => $this->input->post('freezing_id_export'),
            'primary_packing_type_id' => $this->input->post('primary_packing_type_id_export'),
            'secondary_packing_type_id' => $this->input->post('secondary_packing_type_id_export'),
            'packing_size_id' => $this->input->post('packing_size_id_export'),

            'glazing_id' => $this->input->post('glazing_id_export'),
            'block_id' => $this->input->post('block_id_export'),
            'size_id' => $this->input->post('size_id_export'),
            'size_before_glaze' => $this->input->post('size_before_glaze_export'),
            'size_after_glaze' => $this->input->post('size_after_glaze_export'),
            'quantity_offered' => $this->input->post('quantity_offered_export'),

            'grade' => $this->input->post('grade_export'),
            'pieces' => $this->input->post('pieces_export'),
            'unit_id' => $this->input->post('unit_id_export'),
            'cartons_offered' => $this->input->post('cartons_offered_export'),
            'product_price' => $this->input->post('product_price_export'),
            'comment' => $this->input->post('comment_export'),
            'user_id' => $this->session->user_id
        );
        
        // echo '<pre>', print_r($insertArray), '</pre>';die;
        
        if($this->session->usertype == 1){
            $this->db->insert('offer_details', $insertArray);    
        }else{
            $this->db->insert('offer_details_resource', $insertArray);
        }
        
        

        // echo $this->db->last_query();die;

        $data['insert_id'] = $this->db->insert_id();
        $data['type'] = 'success';
        $data['msg'] = 'Offer Exported Successfully.';
         
        return $data;
    }

    public function ajax_unique_offer_no(){
        $offer_id = $this->input->post('offer_id');
        $order_no = $this->input->post('order_no');

        $rs = $this->db->get_where('offer', array('co_no' => $order_no, 'co_id <>' => $offer_id))->num_rows();
        if($rs != '0') {
            $data = 'Order no. already exists.';
        }else{
            $data='true';
        }
        // echo $this->db->last_query();
        return $data;
    }

    // OFFER CLONING

    public function ajax_offer_clone($offer_id){
        
        // Insert into offer header table

        $on = '"OFFER/'.date('dmY').'/'.date('his').'"';
        
        if($this->session->usertype == 1){
        
            $query = "
                INSERT INTO offers(
                    `offer_name`,`offer_number`,`offer_date`,`am_id`,`destination_c_id`,
                    `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,`resource_edit_status`,`resource_id`
                )
                SELECT
                    `offer_name`,$on,`offer_date`,`am_id`,`destination_c_id`, `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,0,1
                FROM
                    offers
                WHERE
                    offer_id = $offer_id
            ";
        
        }else{
            
            $query = "
                INSERT INTO offers_resource(
                    `offer_name`,`offer_number`,`offer_date`,`am_id`,`destination_c_id`,
                    `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,`resource_edit_status`,`resource_id`
                )
                SELECT
                    `offer_name`,$on,`offer_date`,`am_id`,`destination_c_id`, `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,0,1
                FROM
                    offers
                WHERE
                    offer_id = $offer_id
            ";
            
        }
        
        
        // echo $query; die;
        if($this->db->query($query)){

            $new_offer_id = $this->db->insert_id();
            
            // Update cloned offer id
            $updateArray=array(
                'cloned_offer_id' => $offer_id                    
            );
            
            if($this->session->usertype == 1){
                
                $this->db->update('offers',$updateArray, array('offer_id' => $new_offer_id));   
                
                // Insert to details table
                $query1="
                    INSERT INTO offer_details(
                    `offer_id`,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,`user_id`)
                    SELECT 
                    $new_offer_id,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,1
                    FROM
                        offer_details
                    WHERE
                        offer_id = $offer_id
                ";
                
            }else{
                
                $this->db->update('offers_resource',$updateArray, array('offer_id' => $new_offer_id));    
                
                // Insert to details table
                $query1="
                    INSERT INTO offer_details_resource(
                    `offer_id`,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,`user_id`)
                    SELECT 
                    $new_offer_id,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,1
                    FROM
                        offer_details
                    WHERE
                        offer_id = $offer_id
                ";
                
            }
            
            

            if($this->db->query($query1)){

                // insert buying pricing - Only if it is told

                $data['type'] = 'success';
                $data['msg'] = 'Offer Cloned Successfully. Redirecting to Edit Page';

            }else{

                $data['title'] = 'Issue-Detected';
                $data['type'] = 'error';
                $data['msg'] = 'Offer Not Cloned<hr>Contact Admin';

            }
        } 

        $data['insert_id'] = $new_offer_id;
        return $data;

    }

    

    // DELETE Offer

    public function ajax_delete_offer(){

        $offer_id = $this->input->post('offer_id');
       
        $this->db->where('offer_id', $offer_id)->delete('offer_comments');
        $this->db->where('offer_id', $offer_id)->delete('offer_details');
        $this->db->where('offer_id', $offer_id)->delete('offer_files');
        $this->db->where('offer_id', $offer_id)->delete('offers');

        $data['title'] = 'Deleted!';
        $data['type'] = 'success';
        $data['msg'] = 'Entire Offer Successfully Deleted';
        return $data;
    }

    public function delete_offer_files(){

        $op_id = $this->input->post('pk');

        if($this->session->usertype == 1){
            $this->db->where('op_id', $op_id)->delete('offer_files');    
        }else{
            $this->db->where('op_id', $op_id)->delete('offer_files_resource');
        }

        $data['title'] = 'Deleted!';
        $data['type'] = 'success';
        $data['msg'] = 'Uploaded File Successfully Deleted. <hr>Refresh to Update';
        return $data;
    }

    public function del_row_offer_details(){

        $od_id = $this->input->post('pk');
        
        $this->db->where('od_id', $od_id)->delete('offer_details');

        $data['title'] = 'Deleted!';
        $data['type'] = 'success';
        $data['msg'] = 'Offer Details Row Successfully Deleted';
        return $data;
    }


    
    // REPORT 




    public function report()
    {
        $data = $this->db
                ->select('vt_id,template_name')
                ->get_where('view_templates_report',array('user_id'=>$this->session->user_id,'status' => 1))->result();

        return $data;
    }

    public function generate_report($report_temp)
    {
        $user_id = $this->session->user_id;


        $data = array();
        $data['template'] = $this->db
                ->select('export_header_fields')
                ->get_where('view_templates_report',array('vt_id' => $report_temp))->row();

                // `status` = 1
         $offers =  $this->get_offer_list($user_id);

         $offers = explode(',', $offers);

/*
         echo "<pre>";
         echo $report_temp;
         print_r($data['template']);
         die();*/

            $this->db->select('exportdata.*,
                            
                                CONCAT("(<span class=d-none>",UNIX_TIMESTAMP(exportdata.ata), "</span>) ", DATE_FORMAT(exportdata.ata, "%d-%m-%Y")) as ata,
                                CONCAT("(<span class=d-none>",UNIX_TIMESTAMP(exportdata.atd), "</span>) ", DATE_FORMAT(exportdata.atd, "%d-%m-%Y")) as atd,
                                CONCAT("(<span class=d-none>",UNIX_TIMESTAMP(exportdata.eta), "</span>) ", DATE_FORMAT(exportdata.eta, "%d-%m-%Y")) as eta,
                                CONCAT("(<span class=d-none>",UNIX_TIMESTAMP(exportdata.etd), "</span>) ", DATE_FORMAT(exportdata.etd, "%d-%m-%Y")) as etd,
                                CONCAT("(<span class=d-none>",UNIX_TIMESTAMP(exportdata.draft_docs_recd_date), "</span>) ", DATE_FORMAT(exportdata.draft_docs_recd_date, "%d-%m-%Y")) as draft_docs_recd_date,
                                CONCAT("(<span class=d-none>",UNIX_TIMESTAMP(exportdata.draft_docs_sent_date), "</span>) ", DATE_FORMAT(exportdata.draft_docs_sent_date, "%d-%m-%Y")) as draft_docs_sent_date,
                                
                               offers.offer_name, 
                               offers.shipping_line,  
                               countries.name as product_origin, 
                               acc_master.name, 
                               offers.offer_id as cusname, 
                               sup.name as supplier_id,
                               actual_sale.currency as actual_sale_currency, 
                               actual_sale.symbol as actual_sale_symbol, 

                               insurance_currency_tbl.currency as insurance_currency, 
                               insurance_currency_tbl.symbol as insurance_currency_symbol,

                               frieght_currency_tbl.currency as frieght_currency, 
                               frieght_currency_tbl.symbol as frieght_currency_symbol,

                               pi_sales_amt_currency_tbl.currency as pi_sales_currency, 
                               pi_sales_amt_currency_tbl.symbol as pi_sales_currency_symbol,

                               po_purch_amt_currency_tbl.currency as po_purch_currency, 
                               po_purch_amt_currency_tbl.symbol as po_purch_currency_symbol,

                               vend_inv_amt_currency_tbl.currency as vend_inv_currency, 
                               vend_inv_amt_currency_tbl.symbol as vend_inv_currency_symbol,

                               adv_amt_vend_currency_tbl.currency as adv_vend_currency, 
                               adv_amt_vend_currency_tbl.symbol as adv_vend_currency_symbol,

                               adv_paid_vend_currency_tbl.currency as adv_paid_vend_currency, 
                               adv_paid_vend_currency_tbl.symbol as adv_paid_vend_currency_symbol,

                               adv_amt_cust_currency_tbl.currency as adv_amt_cust_currency, 
                               adv_amt_cust_currency_tbl.symbol as adv_amt_cust_currency_symbol,
                               
                               adv_recd_from_cust_currency_tbl.currency as adv_recd_from_cust_currency, 
                               adv_recd_from_cust_currency_tbl.symbol as adv_recd_from_cust_currency_symbol');
            
            $this->db->join('offers', 'exportdata.offer_id = offers.offer_id', 'left');

            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');

            $this->db->join('acc_master cu', 'cu.am_id = exportdata.customer', 'left');

            $this->db->join('acc_master sup', 'sup.am_id = exportdata.supplier_id', 'left');

            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');

            $this->db->join('currencies actual_sale', 'actual_sale.c_id = exportdata.actual_sales_amt_currency', 'left');

            $this->db->join('currencies insurance_currency_tbl', 'insurance_currency_tbl.c_id = exportdata.insurance_currency', 'left');

            $this->db->join('currencies frieght_currency_tbl', 'frieght_currency_tbl.c_id = exportdata.frieght_currency', 'left');

            $this->db->join('currencies pi_sales_amt_currency_tbl', 'pi_sales_amt_currency_tbl.c_id = exportdata.pi_sales_amt_currency', 'left');

            $this->db->join('currencies po_purch_amt_currency_tbl', 'po_purch_amt_currency_tbl.c_id = exportdata.po_purch_amt_currency', 'left');

            $this->db->join('currencies vend_inv_amt_currency_tbl', 'vend_inv_amt_currency_tbl.c_id = exportdata.vend_inv_amt_currency', 'left');

            $this->db->join('currencies adv_amt_vend_currency_tbl', 'adv_amt_vend_currency_tbl.c_id = exportdata.adv_amt_vend_currency', 'left');

            $this->db->join('currencies adv_paid_vend_currency_tbl', 'adv_paid_vend_currency_tbl.c_id = exportdata.adv_paid_vend_currency', 'left');

            $this->db->join('currencies adv_amt_cust_currency_tbl', 'adv_amt_cust_currency_tbl.c_id = exportdata.adv_paid_vend_currency', 'left');

            $this->db->join('currencies adv_recd_from_cust_currency_tbl', 'adv_recd_from_cust_currency_tbl.c_id = exportdata.adv_recd_from_cust_currency', 'left');

            // $this->db->where('cu.supplier_buyer', 1);

            $this->db->where_in('exportdata.offer_id', $offers);
            
            /*$this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left');
            $this->db->join('users', 'users.user_id = offers.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('ports', 'ports.p_id = offers.port_of_loading', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');*/

            $data['export_data'] = $this->db->get('exportdata')->result();

            //echo $this->db->last_query(); 
            
            // echo "<pre>"; print_r($data['export_data']); die();

            $dArray = array();
            foreach ($data['export_data'] as $key => $export_data_value) {

                  $this->db->select('products.*, sizes.*, offer_details.pieces, offer_details.grade');

                  $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');

                  $this->db->join('sizes', 'sizes.size_id = offer_details.size_id', 'left');

                   $this->db->where('offer_details.offer_id', $export_data_value->offer_id);

                  $dArray[$key] = $this->db->get('offer_details')->result();


                 // echo $export_data_value->offer_id.'<br>';
                 // echo $this->db->last_query();
            }


            $data['products'] = $dArray;




// echo $this->db->last_query();
            // die();
           /* echo "<pre>";
            print_r($data['export_data']);
            die();*/
        // $data['export_data'] = $this->db->query($query)->result();


         //echo $this->db->last_query();




/*echo "<pre>";
         print_r($dArray);


         die();
*/
       

        return $data;
    }

    public function view_offer($report_id){

        $data = [];
        
        if($this->session->usertype == 1){
            
            $this->db->select('offers.*, DATE_FORMAT(offers.offer_date, "%d-%m-%Y") as offer_date,acc_master.name as supplier_name, acc_master.am_code as supplier_code, currencies.currency, currencies.symbol as currency_code, users.username, firstname, lastname, countries.iso, countries.name, incoterms.incoterm, ports.port_name,remark1_offer_validity.remark');
            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left');
            $this->db->join('users', 'users.user_id = offers.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('ports', 'ports.p_id = offers.port_of_loading', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');
            $data['offer'] = $this->db->get_where('offers', array('offers.offer_id' => $report_id))->result();    
            
        }else{
            
            $this->db->select('exportdata.*, offers.offer_name,offers.offer_number, offers.offer_fz_number');
            $this->db->join('offers', 'exportdata.offer_id = offers.offer_id', 'left');
            $data['offer'] = $this->db->get_where('exportdata', array('exportdata.export_id' => $report_id))->result();
            
        }


        /*if($this->session->usertype == 1){
            
            $this->db->select('offer_details.od_id,quantity_offered, cartons_offered, product_price, product_name, scientific_name, f1.freezing_type,f2.freezing_type as freezing_method, ptp.packing_type, pts.packing_type as pts, packing_size, glazing, block_size,sizes.size,units.unit, size_before_glaze, size_after_glaze');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $this->db->join('freezing f1', 'f1.ft_id = offer_details.freezing_id', 'left');
            $this->db->join('freezing f2', 'f2.ft_id = offer_details.freezing_method_id', 'left');
            $this->db->join('packing_types ptp', 'ptp.pt_id = offer_details.primary_packing_type_id', 'left');
            $this->db->join('packing_types pts', 'pts.pt_id = offer_details.secondary_packing_type_id', 'left');
            $this->db->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left');
            $this->db->join('glazing', 'glazing.gl_id = offer_details.glazing_id', 'left');
            $this->db->join('blocks', 'blocks.block_id = offer_details.block_id', 'left');
            $this->db->join('sizes', 'sizes.size_id = offer_details.size_id', 'left');
            $this->db->join('units', 'units.u_id = sizes.unit_id', 'left');
            $data['offer_details'] = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();
            
        }else{
            
            $this->db->select('offer_details_resource.od_id,quantity_offered, cartons_offered, product_price, product_name, scientific_name, f1.freezing_type,f2.freezing_type as freezing_method, ptp.packing_type, pts.packing_type as pts, packing_size, glazing, block_size,sizes.size,units.unit, size_before_glaze, size_after_glaze');
            $this->db->join('products', 'products.pr_id = offer_details_resource.product_id', 'left');
            $this->db->join('freezing f1', 'f1.ft_id = offer_details_resource.freezing_id', 'left');
            $this->db->join('freezing f2', 'f2.ft_id = offer_details_resource.freezing_method_id', 'left');
            $this->db->join('packing_types ptp', 'ptp.pt_id = offer_details_resource.primary_packing_type_id', 'left');
            $this->db->join('packing_types pts', 'pts.pt_id = offer_details_resource.secondary_packing_type_id', 'left');
            $this->db->join('packing_sizes', 'packing_sizes.ps_id = offer_details_resource.packing_size_id', 'left');
            $this->db->join('glazing', 'glazing.gl_id = offer_details_resource.glazing_id', 'left');
            $this->db->join('blocks', 'blocks.block_id = offer_details_resource.block_id', 'left');
            $this->db->join('sizes', 'sizes.size_id = offer_details_resource.size_id', 'left');
            $this->db->join('units', 'units.u_id = sizes.unit_id', 'left');
            $data['offer_details'] = $this->db->get_where('offer_details_resource', array('offer_details_resource.offer_id' => $offer_id))->result();
            */
        //}
        
        $data['templates'] = $this->db
            ->select('export_header_fields')
            ->join('assigned_templates_report','view_templates_report.vt_id = assigned_templates_report.vt_id','left')
            ->get_where('view_templates_report',array('assigned_templates_report.export_id' => $report_id))->result();

        if(count($data['templates']) == 0){
            $data['templates'] = $this->db
                ->select('export_header_fields')
                ->get_where('view_templates_report',array('vt_category' => 'DT'))->result();
        }

        // echo count($data['templates']) . '<hr>' . '<pre>',print_r($data),'</pre>';

        return $data;
    }

    public function view_export_report_list($export_id){

        $data = array();
        $this->db->select('offers.no_of_container,products.product_name, sizes.size,  u1.unit as  sizeUnit, offer_details.pieces, offer_details.cartons_offered, offer_details.quantity_offered, u2.unit as  prddtlUnit, export_details.qty_loaded');


        $this->db->join('offer_details', 'offer_details.od_id = export_details.od_id', 'left');

        $this->db->join('offers', 'offers.offer_id = offer_details.offer_id', 'left');

        $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
        $this->db->join('sizes', 'sizes.size_id = offer_details.size_id', 'left');


        $this->db->join('units as u1', 'u1.u_id = sizes.unit_id', 'left');
        $this->db->join('units as u2', 'u2.u_id = offer_details.unit_id', 'left');
        //$this->db->group_by('product_name'); 
        $data['export_product_details'] = $this->db->get_where('export_details', array('export_details.export_id' => $export_id))->result_array();
      
        //echo '<pre>',print_r($data),'</pre>';

        $data['export_data'] = $this->db->get_where('exportdata', array('export_id' => $export_id))->row();

        //echo $this->db->last_query() die;
        return $data;
    }

    public function upgrade_selling_rate($updateArray, $sp_id){
        
        if($this->db->update('selling_price', $updateArray, array('sp_id' => $sp_id))){

            return;

        }else{
            return false;
        }

    }

    // public function upgrade_selling_rate_approval($updateArray, $sp_id){
        
    //     if($this->db->update('selling_price', $updateArray, array('sp_id' => $sp_id))){

    //         return true;

    //     }else{
    //         return false;
    //     }

    // }

    public function offers_marketing(){
        
        $data['title'] = 'Offer Lists';
        $data['menu'] = 'Offers';
        $data['insert'] = '';
        // $data['mar_users'] = $this->db->get_where('users', array('usertype' => 3))->result();
        // $data['view_templates'] = $this->db->get_where('view_templates', array('status' => 1))->result();
        return array('page'=>'offer/offer_marketing_list_v', 'data'=>$data);

    }

    public function ajax_offer_marketing_table_data() {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;

        //actual db table column names
        $column_orderable = array(
            0 => 'offer_name',
            1 => 'offer_date',
            2 => 'offers.am_id',
            4 => 'offers.resource_id'
        );
        // Set searchable column fields
        $column_search = array('offer_name','acc_master.name');
        // $column_search = array('co_no');

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $rs = $this->_offer_marketing_common_query($usertype, $user_id);

        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $rs = $this->_offer_marketing_common_query($usertype, $user_id);
        }
        //if searching for something
        else {
            $this->db->start_cache();
            // loop searchable columns
            $i = 0;
            foreach($column_search as $item){
                // first loop
                if($i===0){
                    $this->db->group_start(); //open bracket
                    $this->db->like($item, $search);
                }else{
                    $this->db->or_like($item, $search);
                }
                // last loop
                if(count((array)$column_search) - 1 == $i){
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }
            $this->db->stop_cache();

            $rs = $this->_offer_marketing_common_query($usertype, $user_id);

            $totalFiltered = count((array)$rs);

            $rs = $this->_offer_marketing_common_query($usertype, $user_id);

            $this->db->flush_cache();
        }

        $data = array();

        foreach ($rs as $val) {

            // if($val->img){$img='<img src="'.base_url('assets/admin_panel/img/article_img/'.$val->img).'" width="50">';} else{$img='';}

            if($val->status == '1'){$status='Enable';} else{$status='Disable';}
            $wip = ($val->resource_edit_status == 0) ? 'Not finalised' : 'Finalised';
            $today = date('d-m-Y');
            $date1 = new DateTime($val->offer_date);
            $date2 = new DateTime($today);
            $diff = $date1->diff($date2);

            if($diff->y == 0 and $diff->m != 0){
                $age = $diff->m . ' months and ' . $diff->d . ' days';
            }else if($diff->y == 0 and $diff->m == 0){
                $age = $diff->d . ' days';
            }else{
                $age = $diff->y . ' year ' . $diff->m . ' months and ' . $diff->d . ' days';
            }
            
            $link = base_url('admin/view-offer') .'/' . $val->offer_id . '/comp1';

            $nestedData['offer_name'] = $val->offer_name;
            $nestedData['offer_no'] = $val->offer_number;
            $nestedData['offer_date'] = $val->offer_date;
            $nestedData['offer_age'] = $age;
            $nestedData['supplier_name'] = $val->supplier_name . ' ['.$val->supplier_code.']';
            $nestedData['country'] = $val->name . ' ['.$val->iso.']';
            $nestedData['currency'] = $val->currency . ' ['.$val->currency_code.']';
            $nestedData['resource_developer'] = $val->username . ' ('. $val->firstname . ' ' . $val->lastname .')';
            $nestedData['remark1'] = $val->remark;
            $nestedData['inspection_clause'] = '<label>'.substr($val->inspection_clause, 0, 10) . '</label><span class="full hidden">'.$val->inspection_clause.'</span>';
;
            $nestedData['wip'] = $wip;
            $nestedData['coi'] = $val->cloned_offer_id;
            $nestedData['action'] = '<a class="btn btn-warning" href="'.$link.'">View (Comp1)</a>';

            $data[] = $nestedData;

            // echo '<pre>', print_r($rs), '</pre>'; 
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return $json_data;
    } 


    private function _offer_marketing_common_query($usertype, $user_id){

           
            
            $this->db->select('offers.*, acc_master.name as supplier_name, acc_master.am_code as supplier_code, DATE_FORMAT(offers.offer_date, "%d-%m-%Y") as offer_date, currencies.currency, currencies.code as currency_code, users.username, firstname, lastname, countries.country_id, countries.iso, countries.name,remark1_offer_validity.remark');
            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
            $this->db->join('users', 'users.user_id = offers.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');
            $this->db->join('assigned_templates', 'assigned_templates.offer_id = offers.offer_id', 'left');
            $this->db->where('find_in_set("'.$user_id.'", marketing_id) <> 0');
            $rs = $this->db->get_where('offers', array('offers.status' => 1, 'marketing_edit_status' => 1))->result();

        return $rs;
        // echo $this->db->get_compiled_select('offer');
        // exit();
    }


    public function update_final_marketing_approval_status($offer){
        
        // update offer status details
        $fmas = $this->db->get_where('offers', array('offer_id' => $offer))->result()[0]->final_marketing_approval_status;
        
        if($fmas == 0){

            $updateArray = array(
                'final_marketing_approval_status' => 1
            );

        }else{

            $updateArray = array(
                'final_marketing_approval_status' => 0
            );

        }

        $this->db->update('offers', $updateArray, array('offer_id' => $offer));
        $this->db->update('offers_resource', $updateArray, array('offer_id' => $offer));

        return true;

    }


    public function sendmail($mail_to,$msg,$mail_sub='',$mail_from='',$mailer_name='',$smtp_host='',$smtp_port='',$smtp_user='',$smtp_pass='') {

        if($mail_from == '') $mail_from=default_mail_from; else $mail_from=$mail_from;
        if($mailer_name == '') $mailer_name=default_mailer_name; else $mailer_name=$mailer_name;
        if($mail_sub == '') $mail_sub=default_mail_sub; else $mail_sub=$mail_sub;
        if($smtp_host == '') $smtp_host=default_smtp_host; else $smtp_host=$smtp_host;
        if($smtp_port == '') $smtp_port=default_smtp_port; else $smtp_port=$smtp_port;
        if($smtp_user == '') $smtp_user=default_smtp_user; else $smtp_user=$smtp_user;
        if($smtp_pass == '') $smtp_pass=default_smtp_pass; else $smtp_pass=$smtp_pass;

        $config = Array(

            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_user' => $smtp_user,
            'smtp_pass' => $smtp_pass,
            'protocol' => 'smtp',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE

        );

        $this->load->library('email', $config);
        $this->email->from($mail_from, $mailer_name);
        $this->email->to($mail_to);
        $this->email->subject($mail_sub);
        $this->email->message($msg);
        $this->email->send();

        return true;

    }

// Offer ENDS 

}
