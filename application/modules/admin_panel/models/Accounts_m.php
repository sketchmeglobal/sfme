<?php
class Accounts_m extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->library('user_agent');
        $this->db->query("SET sql_mode = ' ' ");

    }

    public function account_dashboard(){
        
        $data = array();
        $data['title'] = 'Dashboard - Account';
        $data['payment_bill'] =  $this->db
            ->select('offers.offer_name,offers.offer_fz_number,supplier.name as supllier_name,vendor.name as vendor_name,users.username,payment_bill.*')
            // ->join('payment_bill_details','payment_bill_details.payment_bill_id=pb_id','left')
            ->join('offers','payment_bill.offer_id = offers.offer_id','left')
            ->join('acc_master AS supplier','supplier.am_id = payment_bill.customer_id','left')
            ->join('acc_master AS vendor','vendor.am_id = payment_bill.vendor_id','left')
            ->join('users','payment_request_initiator = users.user_id','left')
            ->get('payment_bill')->result();
        
        $data['payment_bill_ntrade'] =  $this->db
            ->join('acc_master AS vendor','vendor.am_id = payment_bill_ntrade.vendor','left')
            ->join('users','payment_request_initiator = users.user_id','left')
            ->get('payment_bill_ntrade')->result();    
        return array('page' => 'accounts/account_dashboard', 'data' => $data);
    }

    public function proforma_invoice() {
        $user_id = $this->session->user_id;

        try {
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Accounts/proforma_invoice'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Sale Contract');
            $crud->set_table('proforma_invoices');

            $crud->unset_read();
            $crud->unset_clone();

            $crud->unset_add();

            $crud->unset_edit();
            $crud->add_action('Edit Sale Contract', '', '', 'fa fa-pencil vewofr',array($this,'_callback_webpage_url_edit_sale_contract'));
            $crud->set_relation('offer', 'offers', '{offer_name} - {offer_number}');
            $crud->set_relation('sold_to_party', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
            $crud->set_relation('consignee_name', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
            $crud->set_relation('destination_port', 'ports', 'port_name');
            $crud->set_relation('port_of_shipment', 'ports', 'port_name');

            $crud->columns('pi_number', 'pi_date', 'offer', 'sold_to_party');
            $crud->unset_fields('status', 'created_date', 'modified_date');


                
            $crud->add_action('Print Sale Contract', '', '', 'fa fa-print p_modal', array($this, '_callback_webpage_url_print_sale_contract'));

            $this->table_name = 'proforma_invoices';
            $crud->callback_before_update(array($this, 'log_before_update'));

            $output = $crud->render();

            //rending extra value to $output
            $output->tab_title = 'Sale Contract';
            $output->section_heading = 'Sale Contract <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Offer Proforma';
            $output->add_button = '<a href="'.base_url('admin/add_sale_contract').'" class="btn btn-success ">Add Sale Contarct</a>';

            return array('page' => 'accounts/sale_contract_list_v', 'data' => $output); //loading common view page

        } catch (Exception $e) {
            show_error($e->getMessage() . '<br>' . $e->getTraceAsString());
        }
    }


    public function purchase_order() {
        $user_id = $this->session->user_id;

        try {
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Accounts/purchase_order'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Purchase Order');
            $crud->set_table('purchase_order');

            $crud->unset_read();
            $crud->unset_clone();

            $crud->unset_add();

            $crud->unset_edit();
            $crud->add_action('Edit PO', '', '', 'fa fa-pencil vewofr',array($this,'_callback_webpage_url_edit_purchase_order'));
            $crud->set_relation('offer', 'offers', '{offer_name} - {offer_number}');
            $crud->set_relation('sold_to_party_id', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
            $crud->set_relation('order_to_id', 'acc_master', '{name} - {am_code}');
            $crud->set_relation('consignee_id', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
            $crud->set_relation('destination_port', 'ports', 'port_name');
            $crud->set_relation('port_of_shipment', 'ports', 'port_name');

            $crud->columns('po_number', 'po_date', 'offer', 'sold_to_party_id','order_to_id');
            $crud->unset_fields('status', 'created_date', 'modified_date');
            
            $crud->add_action('Print PO', '', '', 'fa fa-print vewofr', array($this, '_callback_webpage_url_print_purchase_order'));
            
            $crud->display_as('sold_to_party_id' , 'Sold To Party');
            $crud->display_as('order_to_id' , 'Order To');

            $this->table_name = 'purchase_order';
            $crud->callback_before_update(array($this, 'log_before_update'));

            $output = $crud->render();

            //rending extra value to $output
            $output->tab_title = 'Purchase Order';
            $output->section_heading = 'Purchase Order <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Purchase Order';
            $output->add_button = '<a href="'.base_url('admin/purchase_order_add').'" class="btn btn-success ">Add Purchase Order</a>';

            return array('page' => 'accounts/purchase_order_list_v', 'data' => $output); //loading common view page

        } catch (Exception $e) {
            show_error($e->getMessage() . '<br>' . $e->getTraceAsString());
        }
    }


    public function _callback_webpage_url_edit_purchase_order($value, $row){
        return site_url('admin/edit_purchase_order/' . $row->po_id);
    }

    
    public function _callback_webpage_url_edit_sale_contract($value, $row) {
        return site_url('admin/edit_sale_contract/' . $row->pi_id);
    }

    public function _callback_webpage_url_print_sale_contract($value, $row) {
        return site_url('admin/show_sc_template/' . $row->pi_id);
    }


    public function _callback_webpage_url_print_purchase_order($value, $row){
        return site_url('admin/show_po_template/' . $row->po_id);
    }


    public function add_sale_contract(){

        $data = array();
        $data['title'] = 'Add Sale Contract';
        $data['offer_list'] = $this->db->get('offers')->result();
        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['port_list'] = $this->db->get('ports')->result();
        $data['company'] = $this->db->get('company')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();
        $data['payment_terms'] = $this->db->get('payment_terms')->result();
        // $data['all_clauses'] = $this->db->where('clause_segment', 'PI')->or_where('clause_segment', 'COMMON')->get('all_clauses')->result();
        $data['pin'] = $this->db->query("select * from proforma_invoices order BY created_date desc")->row()->pi_number;
        
        // print_r($data['all_clauses']);
        
        return array('page' => 'accounts/sale_contract_form', 'data' => $data);
    }

    public function form_add_sale_contract(){

        //return $this->input->post();
        $data = array();
        $bank_id = join(",",$this->input->post('bank_id[]'));

        $lab_report_clauses = json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 
        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 

        $insertArray = array(
            'company_id' => $this->input->post('company_id'),
            'pi_number' => $this->input->post('pi_number'),
            'pi_date' => $this->input->post('pi_date'),
            'offer' => $this->input->post('offer_id'),
            'sold_to_party' => $this->input->post('sold_to_party_id'),
            'order_to_id' => $this->input->post('order_to_id'),
            'order_to_contact' => $this->input->post('order_to_contact'),
            'consignee_name' => $this->input->post('consignee_name'),
            'destination_port' => $this->input->post('destination_port'),
            'port_of_shipment' => $this->input->post('port_of_shipment'),
            'transhipment' => $this->input->post('transhipment'),
            'partial_shipment' => $this->input->post('partial_shipment'),
            'label_document' => $this->input->post('label_document'),
            'bank_id' => $bank_id,
            'lab_report_clauses' => $lab_report_clauses,
            'label' => $lbl,
            'payment_terms' => $this->input->post('payment_terms'),
            'your_ref' => $this->input->post('your_ref'),
            'add_info' => $this->input->post('add_info'),
            'add_info2' => $this->input->post('add_info2'),
            'authorised_signatory' => $this->input->post('authorised_signatory'),
            'accepted_by' => $this->input->post('accepted_by'),
            'tax' => $this->input->post('tax')
        );
    
        if ($this->db->insert('proforma_invoices', $insertArray)) {
            $data['type'] = 'success';
            $data['msg'] = 'Data added successfully';
        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Oops! somthing went wrong. Please try again' . $this->db->last_query();
        }

        return $data;
    }

    public function purchase_order_add(){

        $data = array();


        $data['title'] = 'Add Purchase Order';
        $data['offer_list'] = $this->db->get('offers')->result();
        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to'] = $this->db->select('am_id, name, am_code')->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 0))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        
        $data['port_list'] = $this->db->get('ports')->result();
        $data['company'] = $this->db->get('company')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();
        $data['pon'] = $this->db->query("select * from purchase_order order BY created_date desc")->row()->po_number;
        $data['payment_terms'] = $this->db->get('payment_terms')->result();

        return array('page' => 'accounts/purchase_order_add_v', 'data' => $data);
    }
    
    public function form_add_purchase_order(){

        $data = array();
        //$bank_id = join(",",$this->input->post('bank_id[]'));

        $lab_report_clauses =  json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG);

        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG);

        $insertArray = array(
                'company_id' => $this->input->post('company_id'),
                'po_number' => $this->input->post('po_number'),
                'po_date' => $this->input->post('po_date'),
                'offer' => $this->input->post('offer_id'),
                'tax' => $this->input->post('tax'),
                'your_ref' => $this->input->post('your_ref'),
                'order_to_id' => $this->input->post('order_to_id'),
                'order_to_contact' => $this->input->post('order_to_contact'),
                'sold_to_party_id' => $this->input->post('sold_to_party_id'),
                'consignee_id' => $this->input->post('consignee_id'),
                'destination_port' => $this->input->post('destination_port'),
                'port_of_shipment' => $this->input->post('port_of_shipment'),
                'transhipment' => $this->input->post('transhipment'),
                'partial_shipment' => $this->input->post('partial_shipment'),
                'label_document' => $this->input->post('label_document'),
                //'bank_id' => $bank_id,
                'lab_report_clauses' => $lab_report_clauses,
                'lbl' => $lbl,
                'payment_terms' => $this->input->post('payment_terms'),
                'authorised_signatory' => $this->input->post('authorised_signatory'),
                'add_info2' => $this->input->post('add_info2'),
                'accepted_by' => $this->input->post('accepted_by'),
                'add_info' => $this->input->post('add_info')
        );
        
        if ($this->db->insert('purchase_order', $insertArray)) {
            $data['type'] = 'success';
            $data['msg'] = 'Data added successfully';
        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Oops! somthing went wrong. Please try again';
        }

        return $data;
    }

    public function edit_purchase_order($id){
        $data = array();
        $data['title'] = 'Edit Purchase Order';
        $data['offer_list'] = $this->db->get('offers')->result();
        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 1))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 1))->result();
        $data['order_to'] = $this->db->get_where('acc_master', array('status' => 1))->result(); //, 'supplier_buyer' => 0
        $data['port_list'] = $this->db->get('ports')->result();
        $data['company'] = $this->db->get('company')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();
        $data['purchase_order_data'] = $this->db->get_where('purchase_order', array('po_id' => $id))->row();
        $data['payment_terms'] = $this->db->get('payment_terms')->result();
        
        return array('page' => 'accounts/purchase_order_edit_v', 'data' => $data);
    }
    
    public function form_edit_purchase_order(){

        $po_id =  $this->input->post('po_id');
        $data = array();
        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 
        $lab_report_clauses = json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 
        $updateArray = array(
                'company_id' => $this->input->post('company_id'),
                'po_number' => $this->input->post('po_number'),
                'po_date' => $this->input->post('po_date'),
                'offer' => $this->input->post('offer_id'),
                
                'tax' => $this->input->post('tax'),
                'your_ref' => $this->input->post('your_ref'),
                'order_to_id' => $this->input->post('order_to_id'),
                'order_to_contact' => $this->input->post('order_to_contact'),
                
                'sold_to_party_id' => $this->input->post('sold_to_party_id'),
                'consignee_id' => $this->input->post('consignee_id'),
                'destination_port' => $this->input->post('destination_port'),
                'port_of_shipment' => $this->input->post('port_of_shipment'),
                
                'transhipment' => $this->input->post('transhipment'),
                'partial_shipment' => $this->input->post('partial_shipment'),
                'label_document' => $this->input->post('label_document'),
                'lab_report_clauses' => $lab_report_clauses,
                'lbl' => $lbl,
                
                'payment_terms' => $this->input->post('payment_terms'),
                
                'authorised_signatory' => $this->input->post('authorised_signatory'),
                'add_info' => $this->input->post('add_info'),
                'add_info2' => $this->input->post('add_info2'),
                'accepted_by' => $this->input->post('accepted_by')
                
        );
        
        if ($this->db->update('purchase_order', $updateArray, array('po_id' => $po_id))) {
            $data['type'] = 'success';
            $data['msg'] = 'Data updated successfully';
        }else{
            $data['type'] = 'error';
            $data['msg'] = $this->db->error();
        }

        return $data;
    }

    public function edit_sale_contract($id){
        $data = array();
        $data['title'] = 'Edit Sale Contract';
        $data['offer_list'] = $this->db->get('offers')->result();

        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();

        $data['port_list'] = $this->db->get('ports')->result();

        $data['company'] = $this->db->get('company')->result();
        $data['payment_terms'] = $this->db->get('payment_terms')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();

        $data['sale_contract_data'] = $this->db->get_where('proforma_invoices', array('pi_id' => $id))->row();

        //echo "<pre>"; print_r($data['sale_contract_data']); die();

        return array('page' => 'accounts/sale_contract_form_edit_v', 'data' => $data);
    }
    
    public function form_edit_sale_contract(){
    // echo "<pre>"; print_r($this->input->post()); die(); //lbl
        $pi_id =  $this->input->post('pi_id');
        $data = array();
        $bank_id = $this->input->post('bank_id[]');

        $bank_id  = join(",",$bank_id);

        $lab_report_clauses = json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 

        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 

        $updateArray = array(
            'company_id' => $this->input->post('company_id'),
            'pi_number' => $this->input->post('pi_number'),
            'pi_date' => $this->input->post('pi_date'),
            'offer' => $this->input->post('offer_id'),
            'sold_to_party' => $this->input->post('sold_to_party'),
            'order_to_id' => $this->input->post('order_to_id'),
            'order_to_contact' => $this->input->post('order_to_contact'),
            'consignee_name' => $this->input->post('consignee_name'),
            'destination_port' => $this->input->post('destination_port'),
            'port_of_shipment' => $this->input->post('port_of_shipment'),
            'transhipment' => $this->input->post('transhipment'),
            'partial_shipment' => $this->input->post('partial_shipment'),
            'label_document' => $this->input->post('label_document'),
            'bank_id' => $bank_id,
            'lab_report_clauses' => $lab_report_clauses,
            'label' => $lbl,
            'payment_terms' => $this->input->post('payment_terms'),
            'your_ref' => $this->input->post('your_ref'),
            'add_info' => $this->input->post('add_info'),
            'add_info2' => $this->input->post('add_info2'),
            'authorised_signatory' => $this->input->post('authorised_signatory'),
            'accepted_by' => $this->input->post('accepted_by'),
            'tax' => $this->input->post('tax')
        );


        //echo "<pre>"; print_r($lab_report_clauses); die();
        
        if ($this->db->update('proforma_invoices', $updateArray, array('pi_id' => $pi_id))) {
            $data['type'] = 'success';
            $data['msg'] = 'Data updated successfully'; 
            // . $this->db->last_query();
        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Oops! somthing went wrong. Please try again';
        }

        return $data;
    }
    
    public function ajax_clause_on_customer(){
        
        $cid = $this->input->get('cid'); 
        return $this->db->get_where('all_clauses', array('customer_id' => $cid))->result();
        
    }
    
    public function log_before_update($post_array, $primary_key) {
        $insertArray = array(
            'table_name' => $this->table_name,
            'pk_id' => $primary_key,
            'action_taken' => 'edit',
            'old_data' => json_encode($post_array),
            'user_id' => $this->session->user_id,
            'comment' => '-',
        );
        if ($this->db->insert('user_logs', $insertArray)) {
            return true;
        } else {
            return false;
        }
    }

    public function proforma_invoice_print() {

        $pi_id = $this->input->post('sc_id');

        $t_id = $this->input->post('t_id');

        if (empty($t_id) and empty($pi_id)) {
            redirect(base_url('admin/sale-contract'));
        }

        $data['hdr'] = $this->db->get_where('sc_template', array('sc_template_id'=> $t_id, 'type'=>'SC'))->row();



        $data['header'] = $this->db
            ->select('proforma_invoices.*, pi_number,pi_date, am1.owner_name,am1.name, am1.official_address, am1.purchase_order_instruction as instruction, am1.shipping_address,am1.place_of_supply, am1.email_id, am2.owner_name as consignee_name,
                am2.name as consignee, am2.shipping_address as consignee_address,am2.shipping_address as consignee_shipping_address,
                am2.place_of_supply as consignee_place_of_supply,port1.port_name,port2.port_name as shipment_port, offers.offer_id, offers.offer_fz_number,offers.shelf_life, shipping_line,
                countries.name as country_name, incoterms.incoterm, offers.tolerance, offers.docs_provided, offers.shipment_timing, offers.size_of_container, offers.no_of_container, proforma_invoices.footer_contract, currencies.code, currencies.symbol')

            ->join('acc_master am1', 'am1.am_id = proforma_invoices.sold_to_party', 'left')
            ->join('acc_master am2', 'am2.am_id = proforma_invoices.consignee_name', 'left')

            ->join('ports port1', 'port1.p_id = proforma_invoices.destination_port', 'left')
            ->join('ports port2', 'port2.p_id = proforma_invoices.port_of_shipment', 'left')

            ->join('offers', 'offers.offer_id = proforma_invoices.offer', 'left')
            ->join('countries', 'countries.country_id = offers.country_id', 'left')
            ->join('currencies', 'currencies.c_id = offers.c_id', 'left')
            ->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left')

            ->get_where('proforma_invoices', array('proforma_invoices.pi_id' => $pi_id))->result();

        // echo "<pre>"; print_r($data['header']); die();

            $offer_id = $data['header'][0]->offer_id;
            $data['freight_sum'] =  $this->db
            ->select('selling_price.freight as totalfreight')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.freight')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

            if (@count($data['freight_sum']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Freight charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
            // echo "<pre>"; print_r($data['freight_sum']); die();

        $data['insurance_sum1'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id' => 8))->result();
        if (@count($data['insurance_sum1']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
        $data['insurance_sum2'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id2' => 8))->result();
        if (@count($data['insurance_sum2']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
        $data['insurance_sum3'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id3' => 8))->result();
        if (@count($data['insurance_sum3']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

        $data['insurance_sum4'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id4' => 8))->result();

        if (@count($data['insurance_sum4']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

            $data['total_insurance'] = 0;
            if(array_key_exists(0, $data['insurance_sum1'])){ 
            $data['total_insurance'] = number_format($data['insurance_sum1'][0]->total_insurance, 2);

            }

            if(array_key_exists(0, $data['insurance_sum2'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum2'][0]->total_insurance, 2);
            }

            if(array_key_exists(0, $data['insurance_sum3'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum3'][0]->total_insurance, 2);
            }

            if(array_key_exists(0, $data['insurance_sum4'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum4'][0]->total_insurance, 2);
            }

        $data['other_sum1'] =  $this->db
            ->select('sum(selling_price.other_price) as total_ot')
            ->where('selling_price.li_id <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

        $data['other_sum2'] =  $this->db
            ->select('sum(selling_price.other_price2) as total_ot')
            ->where('selling_price.li_id2 <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

        $data['other_sum3'] =  $this->db
            ->select('sum(selling_price.other_price3) as total_ot')
            ->where('selling_price.li_id3 <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

        $data['other_sum4'] =  $this->db
            ->select('sum(selling_price.other_price4) as total_ot')
            ->where('selling_price.li_id4 <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();


        $data['total_other'] = number_format(($data['other_sum1'][0]->total_ot + $data['other_sum2'][0]->total_ot + $data['other_sum3'][0]->total_ot + $data['other_sum4'][0]->total_ot),2);
            /*echo $this->db->last_query();*/
            $bank_id = $data['header'][0]->bank_id;
            $ids = explode(',', $bank_id);
            $this->db->where_in('bank_master_id', $ids );
            $data['bank_details'] = $this->db->get('bank_master')->result();

            //echo $this->db->last_query(); die();


            $company_id = $data['header'][0]->company_id;
            $data['company'] = $this->db->get_where('company',array('company_id' => $company_id))->row();
            // echo "<pre>"; print_r($data); die();

        $data['details'] = $this->db
            ->select('offer_details.grade, offer_details.product_line_sc,  offer_details.product_line,
                    offer_details.cartons_offered,
                    offer_details.gross_weight,
                    offer_details.product_description,
                    offer_details.pieces,
                    offer_details.size_before_glaze,
                    offer_details.size_after_glaze,

                    products.product_name,
                    products.scientific_name,
                    packing_sizes.packing_size,

                    sizes.size,
                    fzm.freezing_type as fzme,
                    fzt.freezing_type as fztp,

                    ptp.packing_type as ptp1,
                    pts.packing_type as pts1,

                    glazing.glazing as glazing,
                    blocks.block_size,
                    
                    payment_terms.payment_terms,

                    offer_details.quantity_offered,
                    offer_details.product_price,
                    offer_details.comment,
                    units.unit,
                    selling_price.final_selling_price,
                    selling_price.mar_selling_rate,
                    selling_price.mar_selling_approval_status,
                    offers.size_of_container,
                    incoterms.incoterm')

            ->join('offers', 'offers.offer_id = proforma_invoices.offer', 'left')
            ->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left')
            ->join('units', 'units.u_id = offer_details.unit_id', 'left')
            ->join('products', 'products.pr_id = offer_details.product_id', 'left')
            ->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left')
            ->join('sizes', 'sizes.size_id = offer_details.size_id', 'left')
            ->join('freezing fzm', 'fzm.ft_id = offer_details.freezing_method_id', 'left')
            ->join('freezing fzt', 'fzt.ft_id = offer_details.freezing_id', 'left')
            ->join('packing_types ptp', 'ptp.pt_id = offer_details.primary_packing_type_id', 'left')
            ->join('packing_types pts', 'pts.pt_id = offer_details.secondary_packing_type_id', 'left')
            ->join('glazing', 'glazing.gl_id = offer_details.glazing_id', 'left')
            ->join('blocks', 'blocks.block_id = offer_details.block_id', 'left')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->join('incoterms', 'incoterms.it_id = selling_price.selling_incoterm_id', 'left')
            ->join('payment_terms', 'payment_terms.pt_id = proforma_invoices.payment_terms', 'left')

            ->get_where('proforma_invoices', array('proforma_invoices.pi_id' => $pi_id, 'fzm.freezing_category' => 'Method', 'fzt.freezing_category' => 'Type', 'ptp.packing_category' => 'Primary packing', 'pts.packing_category' => 'Secondary packing'))->result_array();


            // echo "<pre>"; print_r($data['details']); die();

        return array('page' => 'accounts/proforma_invoice_print', 'data' => $data);

    }

    public function print_purchase_order() {
        $po_id = $this->input->post('po_id');

        $t_id = $this->input->post('t_id');

        if (empty($t_id) and empty($po_id)) {
            redirect(base_url('admin/purchase-order'));
        }

        $data['hdr'] = $this->db->get_where('sc_template', array('sc_template_id'=> $t_id, 'type'=>'PO'))->row();

        $data['header'] = $this->db
            ->select('purchase_order.*, po_number,po_date, am1.owner_name,am1.name, am1.purchase_order_instruction, am1.official_address,am1.shipping_address,am1.place_of_supply, am1.email_id, am2.owner_name as consignee_name,
                am2.name as consignee, am2.shipping_address as consignee_address,am2.shipping_address as consignee_shipping_address,
                am2.place_of_supply as consignee_place_of_supply,port1.port_name,port2.port_name as shipment_port, offers.offer_id, offers.offer_fz_number,offers.shelf_life, shipping_line,
                countries.name as country_name, incoterms.incoterm, offers.tolerance, offers.docs_provided, offers.shipment_timing, offers.size_of_container, offers.no_of_container, purchase_order.footer_contract, currencies.code, currencies.symbol, am3.name as order_to_name, am3.shipping_address as order_to_shipping_address')

            ->join('acc_master am1', 'am1.am_id = purchase_order.sold_to_party_id', 'left')
            ->join('acc_master am2', 'am2.am_id = purchase_order.consignee_id', 'left')
            ->join('acc_master am3', 'am3.am_id = purchase_order.order_to_id', 'left')


            ->join('ports port1', 'port1.p_id = purchase_order.destination_port', 'left')
            ->join('ports port2', 'port2.p_id = purchase_order.port_of_shipment', 'left')

            ->join('offers', 'offers.offer_id = purchase_order.offer', 'left')
            ->join('countries', 'countries.country_id = offers.country_id', 'left')
            ->join('currencies', 'currencies.c_id = offers.c_id', 'left')
            ->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left')
            ->join('payment_terms', 'payment_terms.pt_id = purchase_order.payment_terms', 'left')
            ->where('am3.supplier_buyer', 0)
            ->get_where('purchase_order', array('purchase_order.po_id' => $po_id))->result();


            //echo $this->db->last_query();

            //echo "<pre>"; print_r($data['header']); die();

        $company_id = $data['header'][0]->company_id;
        $data['company'] = $this->db->get_where('company',array('company_id' => $company_id))->row();
        //if (1==2) {
        $offer_id = $data['header'][0]->offer_id;
        
        $data['freight_sum'] =  $this->db
            ->select('selling_price.freight as totalfreight')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.freight')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

            if (@count($data['freight_sum']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Freight charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
            // echo "<pre>"; print_r($data['freight_sum']); die();

        $data['insurance_sum1'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id' => 8))->result();
        if (@count($data['insurance_sum1']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
        $data['insurance_sum2'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id2' => 8))->result();
        if (@count($data['insurance_sum2']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
        $data['insurance_sum3'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id3' => 8))->result();
        if (@count($data['insurance_sum3']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

        $data['insurance_sum4'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id4' => 8))->result();

        if (@count($data['insurance_sum4']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

            $data['total_insurance'] = 0;
            if(array_key_exists(0, $data['insurance_sum1'])){ 
            $data['total_insurance'] = number_format($data['insurance_sum1'][0]->total_insurance, 2);

            }

            if(array_key_exists(0, $data['insurance_sum2'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum2'][0]->total_insurance, 2);
            }

            if(array_key_exists(0, $data['insurance_sum3'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum3'][0]->total_insurance, 2);
            }

            if(array_key_exists(0, $data['insurance_sum4'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum4'][0]->total_insurance, 2);
            }


        $data['other_sum1'] =  $this->db
            ->select('sum(selling_price.other_price) as total_ot')
            ->where('selling_price.li_id <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

        $data['other_sum2'] =  $this->db
            ->select('sum(selling_price.other_price2) as total_ot')
            ->where('selling_price.li_id2 <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

        $data['other_sum3'] =  $this->db
            ->select('sum(selling_price.other_price3) as total_ot')
            ->where('selling_price.li_id3 <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

        $data['other_sum4'] =  $this->db
            ->select('sum(selling_price.other_price4) as total_ot')
            ->where('selling_price.li_id4 <> ', 8)
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();


        $data['total_other'] = number_format(($data['other_sum1'][0]->total_ot + $data['other_sum2'][0]->total_ot + $data['other_sum3'][0]->total_ot + $data['other_sum4'][0]->total_ot),2);
            /*echo $this->db->last_query();*/
            /*$bank_id = $data['header'][0]->bank_id;
            $ids = explode(',', $bank_id);
            $this->db->where_in('bank_master_id', $ids );
            $data['bank_details'] = $this->db->get('bank_master')->result();*/
            // echo "<pre>"; print_r($data); die();
        //}


        /*$data['details'] = $this->db
            ->select('offer_details.grade, offer_details.product_line, 
                    offer_details.cartons_offered, 
                    products.product_name,
                    products.scientific_name,
                    packing_sizes.packing_size,

                    sizes.size,

                    offer_details.quantity_offered,
                    offer_details.product_price,
                    units.unit,
                    selling_price.final_selling_price,
                    selling_price.mar_selling_rate,
                    selling_price.mar_selling_approval_status,
                    offers.size_of_container')

            ->join('offers', 'offers.offer_id = purchase_order.offer', 'left')
            ->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left')

            ->join('units', 'units.u_id = offer_details.unit_id', 'left')
            ->join('products', 'products.pr_id = offer_details.product_id', 'left')
            ->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left')

            ->join('sizes', 'sizes.size_id = offer_details.size_id', 'left')

            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')

            ->get_where('purchase_order', array('purchase_order.po_id' => $po_id))->result();*/


            $data['details'] = $this->db
            ->select('offer_details.grade, offer_details.product_line_sc,  offer_details.product_line,
                    offer_details.cartons_offered,

                    offer_details.gross_weight,

                    offer_details.product_description,

                    offer_details.pieces,

                    offer_details.size_before_glaze,

                    offer_details.size_after_glaze,

                    products.product_name,
                    products.scientific_name,
                    packing_sizes.packing_size,

                    sizes.size,
                    fzm.freezing_type as fzme,
                    fzt.freezing_type as fztp,

                    ptp.packing_type as ptp1,

                    pts.packing_type as pts1,

                    glazing.glazing as glazing,

                    blocks.block_size,


                    offer_details.quantity_offered,
                    offer_details.product_price,
                    offer_details.comment,
                    units.unit,
                    selling_price.final_selling_price,
                    selling_price.mar_selling_rate,
                    selling_price.mar_selling_approval_status,
                    offers.size_of_container')

            ->join('offers', 'offers.offer_id = purchase_order.offer', 'left')
            ->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left')

            ->join('units', 'units.u_id = offer_details.unit_id', 'left')
            ->join('products', 'products.pr_id = offer_details.product_id', 'left')
            ->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left')

            ->join('sizes', 'sizes.size_id = offer_details.size_id', 'left')

            ->join('freezing fzm', 'fzm.ft_id = offer_details.freezing_method_id', 'left')

            ->join('freezing fzt', 'fzt.ft_id = offer_details.freezing_id', 'left')


            ->join('packing_types ptp', 'ptp.pt_id = offer_details.primary_packing_type_id', 'left')

            ->join('packing_types pts', 'pts.pt_id = offer_details.secondary_packing_type_id', 'left')

            ->join('glazing', 'glazing.gl_id = offer_details.glazing_id', 'left')

            ->join('blocks', 'blocks.block_id = offer_details.block_id', 'left')

            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')

            ->get_where('purchase_order', array('purchase_order.po_id' => $po_id, 'fzm.freezing_category' => 'Method', 'fzt.freezing_category' => 'Type', 'ptp.packing_category' => 'Primary packing', 'pts.packing_category' => 'Secondary packing'))->result_array();

        //echo "<pre>"; print_r($data['details']); die();

        return array('page' => 'accounts/purchase_order_print', 'data' => $data);

    }


    public function payment_intent() {

        $data = array();
        $data['user_id'] = $userid = $this->session->user_id;
        $usertype = $this->session->usertype;
        $pr = $this->db->get_where('users', array('user_id'=>$userid))->row()->payment_role;
        $data['session_user_payment_role'] = $pr;    

        try {
            
            $data['tab_title'] = 'Payment Intent Bill';
            $data['section_heading'] = 'Payment Intent Bill <small>(Add / Edit / Delete)</small>';
            $data['menu_name'] = 'Payment Intent Bill';

            if($pr != NULL or $pr != ''){ //from accnts dept.
                $data['all_bills'] = $this->db
                    ->select('payment_bill.*,offers.offer_name,exportdata.partial_reference,exportdata.fz_ref_no,vendor.name as vendor_name, customer.name as customer_name, currencies.currency')
                    ->join('offers','offers.offer_id = payment_bill.offer_id','left')
                    ->join('exportdata','exportdata.export_id = payment_bill.export_id','left')
                    ->join('acc_master as vendor','vendor.am_id = payment_bill.vendor_id','left')
                    ->join('acc_master as customer','customer.am_id=payment_bill.customer_id','left')
                    ->join('currencies','currencies.c_id = payment_currency','left')
                    ->get('payment_bill')->result();

                $data['all_bills_ntrade'] = $this->db
                    ->join('acc_master','am_id = vendor','left')
                    ->get('payment_bill_ntrade')->result();    
            }else{ // normal users
                $data['all_bills'] = $this->db
                    ->select('payment_bill.*,offers.offer_name,exportdata.partial_reference,exportdata.fz_ref_no,vendor.name as vendor_name, customer.name as customer_name, currencies.currency')
                    ->join('offers','offers.offer_id = payment_bill.offer_id','left')
                    ->join('exportdata','exportdata.export_id = payment_bill.export_id','left')
                    // ->join('exportdata','exportdata.offer_id = offers.offer_id','left')
                    ->join('acc_master as vendor','vendor.am_id = payment_bill.vendor_id','left')
                    ->join('acc_master as customer','customer.am_id=payment_bill.customer_id','left')
                    ->join('currencies','currencies.c_id = payment_currency','left')
                    ->get_where('payment_bill', array('payment_request_initiator' => $userid))
                    ->result();

                $data['all_bills_ntrade'] = $this->db
                    ->join('acc_master','am_id = vendor','left')
                    ->get_where('payment_bill_ntrade', array('payment_request_initiator' => $userid))
                    ->result();    
            }

            return array('page' => 'accounts/payment_intent', 'data' => $data);

        } catch (Exception $e) {
            show_error($e->getMessage() . '<br>' . $e->getTraceAsString());
        }
    }

    public function payment_intent_edit($pbno){

        $data = array();
        $data['user_id'] = $userid = $this->session->user_id;
        $data['username'] = $this->session->username;
        $data['usertype'] = $usertype = $this->session->usertype;
        $data['tab_title'] = 'Payment Intent Bill';
        $data['section_heading'] = 'Payment Intent Bill <small>(Add / Edit / Delete)</small>';
        $data['menu_name'] = 'Payment Intent Bill';

        $pr = $this->db->get_where('users', array('user_id'=>$userid))->row()->payment_role;
        $data['session_user_payment_role'] = $pr;    

        if($this->input->post('bill_add')){
            
            $insert_array = array(
                'offer_id' => $this->input->post('offer_id'),
                'export_id' => $this->input->post('export_id'),
                'vendor_id' => $this->input->post('vendor_id'),
                'customer_id' => $this->input->post('customer_id'),
                'purchase_order_no' => $this->input->post('purchase_order_no'),
                'payment_bill_no' => $this->input->post('payment_bill_no'),
                'payment_bill_date' => $this->input->post('payment_bill_date'),
                'total_payment_amount' => $this->input->post('total_payment_amount'),
                'ETD' => ($this->input->post('etd') == '') ? NULL : $this->input->post('etd'),
                'ETA' => ($this->input->post('eta') == '') ? NULL : $this->input->post('eta'),
                'payment_request_initiator' => $this->session->user_id,
                'payment_approval_status' => $this->input->post('payment_approval_status'),
                'payment_approver_role' => $this->input->post('payment_approver_role'),
                'payment_approved_by' => $this->input->post('payment_approved_by'),
                'payment_method' => $this->input->post('payment_method'),
                'payment_status' => $this->input->post('payment_status'),
                'remark' => $this->input->post('remark'),
                'session_user_id' => $this->session->user_id
            );

            $this->db->insert('payment_bill', $insert_array);
            // echo $this->db->last_query(); die;
            $insert_id = $this->db->insert_id();
            redirect(base_urL('admin/payment-intent-edit').'/'.$insert_id, 'refresh');

        }

        if($this->input->post('bill_edit')){
            
            $update_array = array(
                'purchase_order_no' => $this->input->post('purchase_order_no'),
                'payment_bill_no' => $this->input->post('payment_bill_no'),
                'payment_bill_date' => $this->input->post('payment_bill_date'),
                'total_payment_amount' => $this->input->post('total_payment_amount'),
                'ETD' => $this->input->post('etd'),
                'ETA' => $this->input->post('eta'),
                'payment_approval_status' => $this->input->post('payment_approval_status'),
                'payment_approver_role' => $this->input->post('payment_approver_role'),
                'payment_approved_by' => $this->input->post('payment_approved_by'),
                'payment_method' => $this->input->post('payment_method'),
                'payment_status' => $this->input->post('payment_status'),
                'remark' => $this->input->post('remark'),
                'session_user_id' => $this->session->user_id
            );

            $this->db->update('payment_bill', $update_array, array('pb_id' => $pbno));            
            // echo $this->db->last_query(); die;
            redirect(base_urL('admin/payment-intent-edit').'/'.$pbno, 'refresh');

        }

        if($this->input->post('payment_add')){
            
            $insert_array = array(
                'payment_bill_id' => $pbno,
                'payable_percentage' => $this->input->post('payable_percentage'),
                'paid_percentage' => $this->input->post('paid_percentage'),
                'payable_flat' => $this->input->post('payable_flat'),
                'paid_flat' => $this->input->post('paid_flat'),
                'payment_date' => $this->input->post('payment_date'),
                'remark' => $this->input->post('remark'),
                'session_user_id' => $this->session->user_id
            );

            $this->db->insert('payment_bill_details', $insert_array);

        }

        if($this->input->post('payment_update_modal')){
            
            $pbd_id = $this->input->post('payment_details_pk');
            $update_array = array(
                'payable_percentage' => $this->input->post('payable_percentage_modal'),
                'paid_percentage' => $this->input->post('paid_percentage_modal'),
                'payable_flat' => $this->input->post('payable_flat_modal'),
                'paid_flat' => $this->input->post('paid_flat_modal'),
                'payment_date' => $this->input->post('payment_date_modal'),
                'bill_intent_permission' => $this->input->post('bill_intent_permission_modal'),
                'remark' => $this->input->post('remark_modal'),
                'intent_approver_id' => $this->session->user_id,
                'intent_approver_role' => $this->db->get_where('users', array('user_id'=>$this->session->user_id))->row()->payment_role,
                'session_user_id' => $this->session->user_id
            );

            $this->db->update('payment_bill_details', $update_array, array('pbd_id' => $pbd_id));
            // echo $this->db->last_query(); die;

        }

        $data['bill_id'] = $pbno;
        $data['offers'] = $this->db->get_where('offers', array('offer_fz_number !=' => ''))->result();
        $data['customers'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        
        $bill_val = 1;
        $nr_pb = $this->db->get_where('payment_bill')->num_rows();
        if($nr_pb > 0){
            $bill_val = $this->db->order_by('payment_bill_no', 'desc')->limit(1)->get_where('payment_bill')->row()->payment_bill_no;
            $bill_val = sprintf('%03d', $bill_val);
        }
        
        if($pbno == 0){ // adding new bill
            $data['bill_no'] = $bill_val+1;
            $data['payment_approved_by'] = '';
        }else{ // editing a bill
            $data['bill_no'] = $bill_val;
            $data['payment_approved_by'] = ($usertype == 7 or $usertype == 1) ? $this->session->user_id : '';
        }

        $data['all_bills'] = $this->db
            ->select('payment_bill.*,payment_bill.remark as payment_remark, payment_bill_details.*,offers.offer_name,
                exportdata.partial_reference,exportdata.fz_ref_no,exportdata.partial_reference,vendor.name as vendor_name, 
                customer.name as customer_name, currencies.currency, username as request_initiator,payment_role')
            ->join('payment_bill_details','payment_bill_id = payment_bill.pb_id','left')
            ->join('offers','offers.offer_id = payment_bill.offer_id','left')
            ->join('exportdata','exportdata.export_id = payment_bill.export_id','left')
            ->join('acc_master as vendor','vendor.am_id = payment_bill.vendor_id','left')
            ->join('acc_master as customer','customer.am_id=payment_bill.customer_id','left')
            ->join('currencies','currencies.c_id = offers.c_id','left')
            ->join('users', 'users.user_id = payment_request_initiator', 'left')
            ->get_where('payment_bill', array('payment_bill.pb_id' => $pbno))
            ->result();
        // echo $this->db->last_query();

        return array('page' => 'accounts/payment_intent_edit', 'data' => $data);

    }

    public function payment_intent_print($pbno){

        $data = array();
        $data['username'] = $this->session->username;
        $data['all_bills'] = $this->db
            ->select('payment_bill.*,payment_bill.remark as payment_remark, payment_bill_details.*,offers.offer_name,
                exportdata.partial_reference,exportdata.fz_ref_no,exportdata.partial_reference,vendor.name as vendor_name, 
                customer.name as customer_name, currencies.currency, username as request_initiator,payment_role')
            ->join('payment_bill_details','payment_bill_id = payment_bill.pb_id','left')
            ->join('offers','offers.offer_id = payment_bill.offer_id','left')
            ->join('exportdata','exportdata.offer_id = payment_bill.offer_id','left')
            ->join('acc_master as vendor','vendor.am_id = payment_bill.vendor_id','left')
            ->join('acc_master as customer','customer.am_id=payment_bill.customer_id','left')
            ->join('currencies','currencies.c_id = offers.c_id','left')
            ->join('users', 'users.user_id = payment_request_initiator', 'left')
            ->get_where('payment_bill', array('payment_bill.pb_id' => $pbno))
            ->result();
        

        return array('page' => 'accounts/payment_intent_print', 'data' => $data);

    }

    public function fz_ref_no_from_offer_id($offer_id){
        $rv = $this->db
            ->select('export_id,fz_ref_no,partial_reference,supplier_id,name, vend_inv_amt,currency')
            ->join('currencies','vend_inv_amt_currency=c_id','left')
            ->join('acc_master','am_id=supplier_id','left')
            ->get_where('exportdata', array('offer_id' => $offer_id))->result();
        // echo $this->db->last_query();
        return $rv;
    }

    public function amount_from_export_id($pb_id) {
        $rv = $this->db
            ->select('vend_inv_amt,currency')
            ->join('currencies','vend_inv_amt_currency=c_id','left')
            ->get_where('exportdata', array('export_id' => $pb_id))->result();
        // echo $this->db->last_query();
        return $rv;
    }

    public function delete_payment_bill_details(){
        $pk = $this->input->post('pk');
        $this->db->where('pbd_id',$pk)->delete('payment_bill_details');
        // echo $this->db->last_query();
        return;
    }

    public function delete_payment_bill(){
        $pk = $this->input->post('pk');
        $this->db->where('payment_bill_id',$pk)->delete('payment_bill_details');
        $this->db->where('pb_id',$pk)->delete('payment_bill');
        return;
    }

    public function payment_intent_edit_ntrade($pbno){

        $data = array();
        $data['user_id'] = $userid = $this->session->user_id;
        $data['username'] = $this->session->username;
        $data['usertype'] = $usertype = $this->session->usertype;
        $data['tab_title'] = 'Payment Intent Bill (Non-trade)';
        $data['section_heading'] = 'Payment Intent Bill (Non-trade) <small>(Add / Edit / Delete)</small>';
        $data['menu_name'] = 'Payment Intent Bill (Non-trade)';

        $pr = $this->db->get_where('users', array('user_id'=>$userid))->row()->payment_role;
        $data['session_user_payment_role'] = $pr;    

        if($this->input->post('bill_add')){
            
            $insert_array = array(
                'vendor' => $this->input->post('vendor'),
                'payment_type' => $this->input->post('payment_type'),
                'mode_of_payment' => $this->input->post('mode_of_payment'),
                'invoice_no' => $this->input->post('invoice_no'),
                'invoice_date' => $this->input->post('invoice_date'),
                'requisition_no' => $this->input->post('requisition_no'),
                'deadline' => $this->input->post('deadline'),
                'total_payable' => $this->input->post('total_payable'),
                'remark' => $this->input->post('remark'),
                'payment_request_initiator' => $this->session->user_id,
                'payment_approved_by' => $this->input->post('payment_approved_by'),
                'payment_approval_status' => 0,
                'payment_approver_role' => $this->input->post('payment_approver_role'),
                'payment_method' => $this->input->post('payment_method'),
                'payment_status' => $this->input->post('payment_status'),
                'session_user_id' => $this->session->user_id
            );

            $this->db->insert('payment_bill_ntrade', $insert_array);
            // echo $this->db->last_query(); die;
            $insert_id = $this->db->insert_id();
            redirect(base_urL('admin/payment-intent-edit-ntrade').'/'.$insert_id, 'refresh');

        }

        if($this->input->post('bill_edit')){
            
            $update_array = array(
                'vendor' => $this->input->post('vendor'),
                'payment_type' => $this->input->post('payment_type'),
                'mode_of_payment' => $this->input->post('mode_of_payment'),
                'invoice_no' => $this->input->post('invoice_no'),
                'invoice_date' => $this->input->post('invoice_date'),
                'requisition_no' => $this->input->post('requisition_no'),
                'deadline' => $this->input->post('deadline'),
                'total_payable' => $this->input->post('total_payable'),
                'remark' => $this->input->post('remark'),
                'payment_approved_by' => $this->input->post('payment_approved_by'),
                'payment_approval_status' => $this->input->post('payment_approval_status'),
                'payment_approver_role' => $this->input->post('payment_approver_role'),
                'payment_method' => $this->input->post('payment_method'),
                'payment_status' => $this->input->post('payment_status'),
                'session_user_id' => $this->session->user_id
            );
            $this->db->update('payment_bill_ntrade', $update_array, array('pbt_id' => $pbno));            
            // die(print_r($_FILES));
            // document upload
            for($iter = 1; $iter < 7; $iter ++){

                if (!empty($_FILES['userfile'.$iter]['name'][0])) {
                    $return_data = array(); 
                    $upload_path = './upload/accounts/' ; 
                    $file_type = 'jpg|jpeg|png|bmp|pdf';
                    $user_file_name = 'userfile'.$iter;
                    $return_data = $this->_upload_files($_FILES['userfile'.$iter], $upload_path, $file_type, $user_file_name);
                    // print_r($return_data[0]['filename']);die;
                    $update_array = array(
                        'userfile'.$iter => $return_data[0]['filename']
                    );
                    $this->db->update('payment_bill_ntrade', $update_array, array('pbt_id' => $pbno));            
                }

            }
            
            // echo $this->db->last_query(); die;
            redirect(base_urL('admin/payment-intent-edit-ntrade').'/'.$pbno, 'refresh');

        }

        if($this->input->post('payment_add')){
            
            $insert_array = array(
                'payment_bill_id' => $pbno,
                'payable_percentage' => $this->input->post('payable_percentage'),
                'paid_percentage' => $this->input->post('paid_percentage'),
                'payable_flat' => $this->input->post('payable_flat'),
                'paid_flat' => $this->input->post('paid_flat'),
                'payment_date' => $this->input->post('payment_date'),
                'remark' => $this->input->post('remark'),
                'session_user_id' => $this->session->user_id
            );

            $this->db->insert('payment_bill_details_ntrade', $insert_array);

        }

        if($this->input->post('payment_update_modal')){
            
            $pbd_id = $this->input->post('payment_details_pk');
            $update_array = array(
                'payable_percentage' => $this->input->post('payable_percentage_modal'),
                'paid_percentage' => $this->input->post('paid_percentage_modal'),
                'payable_flat' => $this->input->post('payable_flat_modal'),
                'paid_flat' => $this->input->post('paid_flat_modal'),
                'payment_date' => $this->input->post('payment_date_modal'),
                'bill_intent_permission' => $this->input->post('bill_intent_permission_modal'),
                'remark' => $this->input->post('remark_modal'),
                'intent_approver_id' => $this->session->user_id,
                'intent_approver_role' => $this->db->get_where('users', array('user_id'=>$this->session->user_id))->row()->payment_role,
                'session_user_id' => $this->session->user_id
            );

            $this->db->update('payment_bill_details_ntrade', $update_array, array('pbd_id' => $pbd_id));
            // echo $this->db->last_query(); die;

        }

        $data['bill_id'] = $pbno;
        $data['ntrade_vendors'] = $this->db->get_where('acc_master', array('acc_type' => 'non-trader'))->result();
        $data['payment_types'] = $this->db->get_where('payment_types', array('status' => 1))->result();
        $data['payment_modes'] = $this->db->get_where('payment_modes', array('status' => 1))->result();
        
        $data['all_bills'] = $this->db
            ->select('payment_bill_ntrade.*,payment_bill_ntrade.remark as payment_remark, payment_bill_details_ntrade.*, username as request_initiator,payment_role')
            ->join('payment_bill_details_ntrade','payment_bill_id = payment_bill_ntrade.pbt_id','left')
            ->join('users', 'users.user_id = payment_request_initiator', 'left')
            ->get_where('payment_bill_ntrade', array('payment_bill_ntrade.pbt_id' => $pbno))
            ->result();
        

        return array('page' => 'accounts/payment_intent_edit_ntrade', 'data' => $data);

    }

    public function delete_payment_bill_details_ntrade(){
        $pk = $this->input->post('pk');
        $this->db->where('pbd_id',$pk)->delete('payment_bill_details_ntrade');
        // echo $this->db->last_query();
        return;
    }

    public function delete_payment_bill_ntrade(){
        $pk = $this->input->post('pk');
        $this->db->where('payment_bill_id',$pk)->delete('payment_bill_details_ntrade');
        $this->db->where('pbt_id',$pk)->delete('payment_bill_ntrade');
        return;
    }

    public function delete_payment_bill_file(){
        $pk = $this->input->post('pid');
        $field = $this->input->post('fid');
        
        // $filename = $this->db->get_where('payment_bill_ntrade', array('pbt_id' => $pk))->row()->$field;
        // unlink(base_url('upload/accounts') . '/' . $filename);

        $update_array = array(
            $field => NULL
        );
        $this->db->update('payment_bill_ntrade', $update_array, array('pbt_id' => $pk));
        return;
    }

    public function payment_intent_print_ntrade($pbno){

        $data = array();
        $data['username'] = $this->session->username;
        $data['all_bills'] = $this->db
            ->join('payment_bill_details_ntrade','payment_bill_id = payment_bill_ntrade.pbt_id','left')
            ->join('acc_master as vendor','vendor.am_id = payment_bill_ntrade.vendor','left')
            ->join('users', 'users.user_id = payment_request_initiator', 'left')
            ->get_where('payment_bill_ntrade', array('payment_bill_ntrade.pbt_id' => $pbno))
            ->result();

        return array('page' => 'accounts/payment_intent_print_ntrade', 'data' => $data);

    }

    private function _upload_files($files, $upload_path, $file_type, $user_file_name){

        // date_default_timezone_set("Asia/Kolkata");  

        $uploadedFileData = array();
        $key = 0;

        $config = array(
            'upload_path'   => $upload_path,
            'allowed_types' => $file_type,
            'overwrite'     => 1,                       
        );

        $this->load->library('upload', $config);

        // print_r($_FILES[$user_file_name]);

        $_FILES['file']['name']       = $_FILES[$user_file_name]['name'];
        $_FILES['file']['type']       = $_FILES[$user_file_name]['type'];
        $_FILES['file']['tmp_name']   = $_FILES[$user_file_name]['tmp_name'];
        $_FILES['file']['error']      = $_FILES[$user_file_name]['error'];
        $_FILES['file']['size']       = $_FILES[$user_file_name]['size'];

        // $config['file_name'] = date('His') .'_'. $image;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            
            $imageData = $this->upload->data();

            $new_array[] = array(
                'filename' => $imageData['file_name'], 
                'status' => 'success',
                'msg' => 'OK'
            );

            $final_array = array_merge($uploadedFileData, $new_array);

        } else {
            $new_array[] = array(
                'filename' => null, 
                'status' => 'error',
                'msg' => 'Type or Size Mismatch' //$this->upload->display_errors() .
            );

            $final_array = array_merge($uploadedFileData, $new_array);
        }

        return $final_array;
    }
}