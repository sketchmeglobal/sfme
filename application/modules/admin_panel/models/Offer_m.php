<?php
class Offer_m extends CI_Model {

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

    public function offer_temp()
    {


        //print_r($this->input->post()); die;
        $data = array();
        if(empty($this->input->post("assigned_template_id")) && $this->input->post("template_assign_update") != "Update" && $this->input->post("template_assign_update") != "Finalise"){

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

                $data['type'] = 'success';
                $data['msg'] = 'Template Added Successfully';

                

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
                'user_id' => $this->session->user_id,
                'marketing_edit_status' => 1
            );

             ///print_r($updateArray); die;

            // Send mail to marketing 

            /*if(count((array)$this->input->post('marketing_id[]')) > 0){
                $mrk = join(',',$this->input->post('marketing_id[]'));
            }else{
                $mrk = '';
            }
            
            ##PROBLEM IF MULTIPLE##
            // print_r($mrk); die;
            ##PROBLEM IF MULTIPLE##
            
            $to = $this->db->get_where('users', array('user_id' => $mrk))->result();

            if (isset($to[0]->email)) {
                $offer_name = $this->db->get_where('offers', array('offer_id' => $offer_id))->result()[0]->offer_name;
                $offer_no = $this->db->get_where('offers', array('offer_id' => $offer_id))->result()[0]->offer_number;
                $content = '<b>' . $offer_name . ' (' . $offer_no . ')</b> is finalized by the Trader. Please review at your earliest.';
            }
            
            
            $this->sendmail($to, $content, 'STS - Offer Finalized by Trader!');*/ 


            if($this->db->update('assigned_templates', $updateArray, array('at_id' => $at_id))){

                $data['type'] = 'success';
                $data['msg'] = 'Template Updated Successfully';
                // . $this->db->last_query();
            }
        }else if($this->input->post("template_assign_update") == "Finalise"){

            /*$offer_id = $this->input->post('template_offer_id');

            $updateArray = array(
                'marketing_edit_status' => 1
            );

            if($this->db->update('assigned_templates', $updateArray, array('offer_id' => $offer_id))){

                $data['type'] = 'success';
                $data['msg'] = 'Offer sent to marketing personnel'; 

            }*/
        }
        return $data;
    }

    public function offer() {

        $data["insert"] = '';

        //die(print_r($this->input->post()));
        
        
        $data['title'] = 'Offer Lists';
        $data['menu'] = 'Offers';
        $data['mar_users'] = $this->db->get_where('users', array('usertype' => 3))->result();
        $data['res_users'] = $this->db->get_where('users', array('usertype' => 2))->result();
        $data['view_templates'] = $this->db->get_where('view_templates', array('status' => 1))->result();
        $data['company_details'] = $this->db->get_where('company', array('status' => 'Active'))->result();
        return array('page'=>'offer/offer_list_v', 'data'=>$data);   
    }

    public function ajax_offer_table_data($offer_type) {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;
        //actual db table column names

        if($usertype == 2){
             $column_orderable = array(
            0 => 'offer_name',
            1 => 'offer_number',
            2 => 'offer_date',
            3 => 'offer_date',
            4 => 'offers_resource.resource_id'
        );
        }else{
            $column_orderable = array(
            0 => 'offer_name',
            1 => 'offer_number',
            2 => 'offer_date',
            3 => 'offer_date',
            4 => 'offers.resource_id'
        );
        }
        
        // Set searchable column fields
        $column_search = array('offer_name','offer_number','acc_master.name');
        // $column_search = array('co_no');

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = trim($this->input->post('search')['value']);

        $rs = $this->_offer_common_query($offer_type,$usertype, $user_id);

        $totalData = count((array)$rs);
        $totalFiltered = $totalData;
        // date wise filter
        $searchByFromdate =  $this->input->post('searchByFromdate');
        $searchByTodate =  $this->input->post('searchByTodate');

        //if not searching for anything
        if(empty($search)) {
            if(empty($searchByFromdate) && empty($searchByTodate)){
                $this->db->limit($limit, $start);
                $this->db->order_by($order, $dir);
                $rs = $this->_offer_common_query($offer_type,$usertype, $user_id);
            }

            if (!empty($searchByFromdate) && !empty($searchByTodate)) {
                $this->db->start_cache();
                $this->db->where('offer_date BETWEEN "'. date('Y-m-d', strtotime($searchByFromdate)). '" and "'. date('Y-m-d', strtotime($searchByTodate)).'"');
                $this->db->stop_cache();

                

                $rs = $this->_offer_common_query($offer_type,$usertype, $user_id);

                $this->db->limit($limit, $start);
                $this->db->order_by($order, $dir);
                //$totalData = count((array)$rs);
                $totalFiltered = count((array)$rs);

                $rs = $this->_offer_common_query($offer_type,$usertype, $user_id);
                /*echo $this->db->last_query();
                die();*/
            }

            /*echo $this->db->last_query();
                die();*/
            
        }else {

            //if searching for something

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

            if (!empty($searchByFromdate) && !empty($searchByTodate)) {
                $this->db->where('offer_date BETWEEN "'. date('Y-m-d', strtotime($searchByFromdate)). '" and "'. date('Y-m-d', strtotime($searchByTodate)).'"');
                /*echo $this->db->last_query();
                die();*/
            }
            
            $this->db->stop_cache();

            $rs = $this->_offer_common_query($offer_type,$usertype, $user_id);
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);
            $totalFiltered = count((array)$rs);

            $rs = $this->_offer_common_query($offer_type,$usertype, $user_id);

            $this->db->flush_cache();

           /* echo $this->db->last_query();
            die();*/
        }
        
        /*echo $this->db->last_query();
        die();*/
        $data = array();

        foreach ($rs as $val) {

            // if($val->img){$img='<img src="'.base_url('assets/admin_panel/img/article_img/'.$val->img).'" width="50">';} else{$img='';}
            if( $val->status == '1' ){ $status ='Enable'; } else{ $status='Disable'; }
            $wip = ($val->resource_edit_status == 1) ? 'Not finalised' : 'Finalised';
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
            $nestedData['offer_date'] = date("d-m-Y", strtotime($val->offer_date));
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

            $nestedData['action'] = $this->_offer_common_actions($usertype, $val->resource_edit_status, $val->at_id, $val->offer_id, $val->offer_name, $val->offer_number);
           
            

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


    private function _offer_common_query($offer_type,$usertype, $user_id){

        if($usertype == 1){

            #for admin

            $this->db->select('offers.*, assigned_templates.at_id, acc_master.name as supplier_name, acc_master.am_code as supplier_code, offers.offer_date as offer_date, currencies.currency, currencies.code as currency_code, users.username, firstname, lastname, countries.country_id, countries.iso, countries.name,remark1_offer_validity.remark');
            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
            $this->db->join('users', 'users.user_id = offers.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');
            $this->db->join('assigned_templates', 'assigned_templates.offer_id = offers.offer_id', 'left');
            if($offer_type == 'closed'){
                $rs = $this->db->get_where('offers', array('offers.status' =>1, 'offers.offer_status_id' => 2))->result();
            }
            else{
                $rs = $this->db->get_where('offers', array('offers.status' =>1, 'offers.offer_status_id !=' => 2))->result(); // 2 means closed    
            }
            
            // echo $this->db->get_compiled_select('offers');
            // exit();
        }elseif($usertype == 2){

            #for resource   
            // echo $offer_type; die('dead');
            
            $this->db->select('offers_resource.*, assigned_templates.at_id, acc_master.name as supplier_name, acc_master.am_code as supplier_code, offers_resource.offer_date as offer_date, currencies.currency, currencies.code as currency_code, users.username, firstname, lastname, countries.country_id, countries.iso, countries.name,remark1_offer_validity.remark');
            $this->db->join('acc_master', 'acc_master.am_id = offers_resource.am_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers_resource.c_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers_resource.country_id', 'left');
            $this->db->join('users', 'users.user_id = offers_resource.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers_resource.remarks_1', 'left');
            $this->db->join('assigned_templates', 'assigned_templates.offer_id = offers_resource.offer_id', 'left');
            if($offer_type == 'closed'){
                $rs = $this->db->get_where('offers_resource', array('offers_resource.status' => 1, 'offers_resource.resource_id' => $user_id, 'offers_resource.offer_status_id' => 2))->result();                
            }else{
                $rs = $this->db->get_where('offers_resource', array('offers_resource.status' => 1, 'offers_resource.resource_id' => $user_id, 'offers_resource.offer_status_id !=' => 2 ))->result();
            }
           /* echo $this->db->last_query();
        exit();*/

        }else{
            #for marketing

            $this->db->select('offers.*, assigned_templates.at_id, acc_master.name as supplier_name, acc_master.am_code as supplier_code, offers.offer_date as offer_date, currencies.currency, currencies.code as currency_code, users.username, firstname, lastname, countries.country_id, countries.iso, countries.name,remark1_offer_validity.remark');
            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
            $this->db->join('users', 'users.user_id = offers.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');
            $this->db->join('assigned_templates', 'assigned_templates.offer_id = offers.offer_id', 'left');
            if($offer_type == 'closed'){
                $rs = $this->db->get_where('offers', array('offers.status' =>1, 'offers.offer_status_id' => 2))->result();    
            }else{
                $rs = $this->db->get_where('offers', array('offers.status' =>1, 'offers.offer_status_id !=' => 2))->result();
            }
            
            // echo $this->db->get_compiled_select('offers');
            // exit();
        }

        return $rs;
        /*echo $this->db->last_query();
        exit();*/
    }

    private function _offer_common_actions($usertype, $edit_status, $at_id, $offer_id, $offer_name, $offer_number){

        if($edit_status == 1 and $usertype == 2){
            # resource not Finalise
            $nestedData = '
            <a href="'. base_url('admin/view-offer/'.$offer_id) .'/1" class="btn bg-yellow" target="_blank"><i class="fa fa-eye" ></i> View</a>
            <a href="'. base_url('admin/edit-offer/'.$offer_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-primary finalise"><i class="fa fa-check"></i> Finalise</a>';

            /*<a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>*/
        }else if($edit_status == 0 and $usertype == 2){
            
            # resource  Finalise
            $nestedData = '
            <a href="'. base_url('admin/view-offer/'.$offer_id) .'/1" class="btn bg-yellow" target="_blank"><i class="fa fa-eye"></i> View</a>
            <button data-offer_id="'.$offer_id.'" class="btn bg-beige clone"><i class="fa fa-refresh"></i> Clone</button>
            <a data-toggle="modal" data-target="#myModal" data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn bg-green request"><i class="fa fa-universal-access"></i> Request Access</a>';
        } else if($edit_status == 1 and $usertype == 1){
            # trader not Finalise
            $nestedData = '
            <a href="javascript:void(0)" data-offer_id="'.$offer_id.'" class="btn bg-yellow slt_view_ofr"><i class="fa fa-eye"></i> View</a>
            <a href="'. base_url('admin/edit-offer/'.$offer_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';
        }else if($edit_status == 0 and $usertype == 1){
            /* href="'. base_url('admin/view-offer/'.$offer_id) .'"  */
            # trader Finalise -> ALREADY FINALISED
            $nestedData = '
            <button data-toggle="modal" data-at_id="'.$at_id.'" data-offer_id="'.$offer_id.'" data-offer_name="'.$offer_name.'" data-offer_number="'.$offer_number.'" data-target="#statusModal" class="btn statusModal" style="background:#795548; color:#fff"><i class="fa fa-clock-o"></i> Status </button> 
            <button data-toggle="modal" data-at_id="'.$at_id.'" data-offer_id="'.$offer_id.'" data-offer_name="'.$offer_name.'" data-offer_number="'.$offer_number.'" data-target="#settingsModal" class="btn settingsModal" style="background:#607d8b; color:#fff"><i class="fa fa-eye"></i> Template </button> 
            <a href="javascript:void(0)" data-offer_id="'.$offer_id.'" class="btn bg-yellow slt_view_ofr"><i class="fa fa-eye"></i> View</a>
            <a href="'. base_url('admin/edit-offer/'.$offer_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <button data-toggle="modal" data-target="#commentModal" data-offer_id="'.$offer_id.'" href="" class="btn btn-warning all_comments"><i class="fa fa-check"></i> Request Access</button>
            <a data-offer_id="'.$offer_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';
        }
        return $nestedData;

    }

    public function ajax_update_offer_wip(){
        $updateArray = array(
            'resource_edit_status' => 0
        );
        $offer_id = $this->input->post('offer_id');
       $this->db->update('offers', $updateArray, array('offer_id' => $offer_id));

       $this->db->update('offers_resource', $updateArray, array('offer_id' => $offer_id));
        
        
        /*send mail to trader about the offer*/
        
        $this->db->select('email');
        $this->db->where('user_id',1);
        $to = $this->db->get('users')->row()->email;

        $this->db->select('offer_name,offer_number');
        $this->db->where('offer_id',$offer_id);
        $offer = $this->db->get('offers')->row();
 
        $content = '<b>' . $offer->offer_name . ' (' . $offer->offer_number . ')</b> is finalized by the resource developer. Please review at your earliest.';
        
        if($this->sendmail($to, $content, 'STS - Offer Finalized by Resource Developer!') == true){

            $data['type'] = 'success';
            $data['msg'] = 'Offer sucessfully sent to Trader and mail send'; 

        }else{
            $data['type'] = 'success';
            $data['msg'] = 'Offer sucessfully sent to Trader but mail mail not send'; 
        } 

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
                'resource_edit_status' => 1
            );        
            $this->db->update('offers', $updateOfferArray, array('offer_id' => $offer_id));

            $this->db->update('offers_resource', $updateOfferArray, array('offer_id' => $offer_id));
    
            $data['type'] = 'success';
            $data['msg'] = 'Edit permission activated!';    
            
        }
        
        return $data;
    }
    
// ADD Offer 


    public function add_offer() {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;

        $data['title'] = 'New Offer Lists';
        
        $data['menu'] = 'Offers';

        $data['offer_status'] = $this->db->select('offer_status_id, offer_status')->get_where('offer_status', array('status' => 1))->result();
        $data['company'] = $this->db->select('company_id, company_name')->get_where('company', array('status' => 'Active'))->result();
        $data['suppliers'] = $this->db->select('am_id, name, am_code')->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 0))->result(); 
        $data['permitted_suppliers'] = $this->db->select('acc_masters')->get_where('users', array('users.user_id' => $this->session->user_id))->row(); 
        
        $data['currencies'] = $this->db->select('c_id, currency, code, symbol')->get_where('currencies', array('status' => 1))->result();

        $data['countries'] = $this->db->select('country_id, iso, name')->get_where('countries', array('status' => 1))->result(); 

        $data['ports'] = $this->db->select('p_id, port_name')->get_where('ports', array('status' => 1))->result(); 
        
        $data['remark1_offer_validity'] = $this->db->get_where('remark1_offer_validity', array('status' => 1))->result();

        $data['incoterms'] = $this->db->select('it_id, incoterm, information')->get_where('incoterms', array('status' => 1))->result(); 

        if($usertype == 1){
            # if admin
            $data['resources'] = $this->db->select('users.user_id, users.username, firstname, lastname')->join('user_details', 'users.user_id = user_details.user_id', 'left')->get_where('users', array('users.verified' => 1, 'users.blocked' => 0, 'users.usertype' => 2))->result();
        }else{
            # if others
            $data['resources'] = $this->db->select('users.user_id, users.username, firstname, lastname')->join('user_details', 'users.user_id = user_details.user_id', 'left')->get_where('users', array('users.verified' => 1, 'users.blocked' => 0, 'users.usertype' => 2, 'users.user_id' => $user_id))->result();
        } 
        
        $data['offer_name'] = 'OFFER/'. date('dmY/his');

        return array('page'=>'offer/offer_add_v', 'data'=>$data);
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

    public function form_add_offer(){

        if(count((array)$this->input->post('acc_master_id[]')) > 0){
            $supplier = join(',',$this->input->post('acc_master_id[]'));
        }else{
            $supplier = '';
        }
        
        if(count((array)$this->input->post('destination_c_id[]')) > 0){
            $dstn = join(',',$this->input->post('destination_c_id[]'));
        }else{
            $dstn = '';
        }

        $insertArray = array(
            'offer_name' => $this->input->post('offer_name'),
            'offer_number' => $this->input->post('offer_number'),
            'offer_fz_number' => $this->input->post('offer_fz_number'),
            'am_id' => $supplier,
            'c_id' => $this->input->post('currencies'),
            'resource_id' => $this->input->post('resources'),
            'country_id' => $this->input->post('country_id'),
            'destination_c_id' => $dstn,
            'incoterm_id' => $this->input->post('incoterms'),
            'offer_date' => $this->input->post('offer_date'),
            'no_of_container' => $this->input->post('no_of_container'),
            'size_of_container' => $this->input->post('size_of_container'),
            'quantity_each_container' => $this->input->post('quantity_each_container'),
            'shipment_timing' => $this->input->post('shipment_timing'),
            'shelf_life' => $this->input->post('shelf_life'),
            'shipping_line' => $this->input->post('shipping_line'),
            'supplier_payment_terms' => $this->input->post('supplier_payment_terms'),
            'document_clause' => $this->input->post('document_clause'),
            'inspection_clause' => $this->input->post('inspection_clause'),
            'lab_report_clause' => $this->input->post('lab_report_clause'),
            'etd' => $this->input->post('etd'),    
            'port_of_loading' => $this->input->post('port_of_loading'),    
            'production_date' => $this->input->post('production_date'), 
            'shelf_life' => $this->input->post('shelf_life'),    
            'tolerance' => $this->input->post('tolerance'),
            'label_attached' => $this->input->post('label_attached'),
            'carton_with_date' => $this->input->post('carton_with_date'),
            'remarks_1' => $this->input->post('remark1'),
            'remarks_2' => $this->input->post('remark2'),
            'remarks_3' => $this->input->post('remark3'),
            'company_id' => $this->input->post('company_id'),
            'offer_status_id' => $this->input->post('offer_status_id'),

            'docs_provided' => $this->input->post('docs_provided'),
            'user_id' => $this->session->user_id
        );

        // echo '<pre>', print_r($insertArray), '</pre>';die;

        $this->db->insert('offers', $insertArray);

        if($this->db->insert_id() > 0){

            $original_offer_id = $this->db->insert_id();
            if($original_offer_id > 0){
                $data['insert_id'] = $original_offer_id;
            }else{
                $data['insert_id'] = 0;
            }
            
            
            if($this->session->usertype == 2){

                $this->db->insert('offers_resource', $insertArray);

                //print_r($insertArray);
                $resource_offer_id = $this->db->insert_id();

                //print_r($this->db->error());

                $data['resource_offer_id'] = $resource_offer_id;
                
                // Update resource offer id with current offer ID


                
                $updateArray = array(
                    'offer_id' => $original_offer_id
                );
            
                $this->db->update('offers_resource', $updateArray, array('offer_resource_id' => $resource_offer_id));
            }
            
            $upload_picture_success = 0; 
            $upload_report_success = 0; 
            $upload_picture_error = 0; 
            $upload_report_error = 0; 


            // image upload
            
            if (!empty($_FILES['userfile']['name'][0])) {

                $return_data = array(); 

                $upload_path = './upload/pictures/' ; 
                $file_type = 'jpg|jpeg|png|txt|doc|docx|xls|xlsx|pdf';
                $user_file_name = 'userfile';

                $return_data = $this->_upload_files($_FILES['userfile'], $upload_path, $file_type, $user_file_name);

                // print_r($return_data);die;

                foreach ($return_data as $datam) {

                    if ($datam['status'] == 'error') {
                        
                        $upload_picture_error++;                        

                    }else{

                        // Insert filename to db
                        
                        $insertArray = array(
                            'offer_id' => $data['insert_id'],
                            'file_category' => 'picture',
                            'file_name' => $datam['filename'],
                            'user_id' => $this->session->user_id
                        );

                        $this->db->insert('offer_files', $insertArray);
                        $original_offer_files_id = $this->db->insert_id();
                        
                        $this->db->insert('offer_files_resource', $insertArray);
                        $new_offer_files_id = $this->db->insert_id();
                        
                         $updateArray = array(
                            'offer_files_id' => $original_offer_files_id
                        );
                    
                        $this->db->update('offer_files_resource', $updateArray, array('op_id' => $new_offer_files_id));
                        
                        $upload_picture_success++;
                    }
                }

            }else{
                $data['type'] = 'success';
                $data['msg'] = 'No Files Uploaded<hr>Offer added successfully.'; 
            }     

            // Report Upload

            if (!empty($_FILES['inspection_reports']['name'][0])) {

                $return_data = array(); 

                $upload_path = './upload/reports/' ; 
                $file_type = 'jpg|jpeg|png|txt|doc|docx|xls|xlsx|pdf';
                $user_file_name = 'inspection_reports';

                $return_data = $this->_upload_files($_FILES['inspection_reports'], $upload_path, $file_type, $user_file_name);

                // print_r($return_data);die;

                foreach ($return_data as $datam) {

                    if ($datam['status'] == 'error') {

                        $upload_report_error++; 

                    }else{

                        // Insert filename to db
                        
                        $insertArray = array(
                            'offer_id' => $data['insert_id'],
                            'file_category' => 'report',
                            'file_name' => $datam['filename'],
                            'user_id' => $this->session->user_id
                        );

                        $this->db->insert('offer_files', $insertArray);
                        $original_offer_files_id = $this->db->insert_id();
                        
                        $this->db->insert('offer_files_resource', $insertArray);
                        $new_offer_files_id = $this->db->insert_id();
                        
                         $updateArray = array(
                            'offer_files_id' => $original_offer_files_id
                        );
                    
                        $this->db->update('offer_files_resource', $updateArray, array('op_id' => $new_offer_files_id));

                        $upload_report_success++; 
                    }
                }

            }else{
                $data['type'] = 'success';
                $data['msg'] = 'No Files Uploaded<hr>Offer added successfully.'; 
            }         

        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Database Insert Error';
        }

        if($upload_report_error > 0 or $upload_picture_error > 0){

            $data['type'] = 'error';
            $data['msg'] = 'Some or All Files Not Uploaded.<hr>Pending Pictures: '.$upload_picture_error.'<br>Pending Report:'.$upload_report_error;

        }else if($upload_report_success > 0 or $upload_picture_success > 0){

            $data['type'] = 'success';
            $data['msg'] = 'Offer added successfully.<hr>Pictures Uploaded: '.$upload_picture_success.'<br>Reports Uploaded:'.$upload_report_success;
        }

        // echo $this->db->last_query(); die;
        return $data;
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

        foreach ($files['name'] as $key => $image) {

            $_FILES['file']['name']       = $_FILES[$user_file_name]['name'][$key];
            $_FILES['file']['type']       = $_FILES[$user_file_name]['type'][$key];
            $_FILES['file']['tmp_name']   = $_FILES[$user_file_name]['tmp_name'][$key];
            $_FILES['file']['error']      = $_FILES[$user_file_name]['error'][$key];
            $_FILES['file']['size']       = $_FILES[$user_file_name]['size'][$key];

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
                    'msg' => 'Type or Size Mismatch'
                );

                $final_array = array_merge($uploadedFileData, $new_array);
            }
        }

        return $final_array;
    }

    public function edit_offer($offer_id) {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;

        $data['title'] = 'Edit Offer';
        $data['menu'] = 'Offers';

        /*This offer list for offer detail export section*/

        if($usertype == 1){
            $data['offers'] = $this->db->get_where('offers', array('status' => 1))->result();
        }else{
            $data['offers'] = $this->db->get_where('offers_resource', array('status' => 1, 'resource_id' => $user_id))->result();
        }

        /*This offer list for offer detail export section end*/
        
        $data['offer_files'] = $this->db->get_where('offer_files', array('offer_id' => $offer_id))->result(); 

        /*Common*/
        $data['products'] = $this->db->get_where('products', array('status' => 1))->result(); 

        $data['freezing'] = $this->db->get_where('freezing', array('status' => 1))->result(); 
        $data['packing_types_p'] = $this->db->get_where('packing_types', array('status' => 1, 'packing_category' => 'Primary packing'))->result(); 
        $data['packing_types_s'] = $this->db->get_where('packing_types', array('status' => 1, 'packing_category' => 'Secondary packing'))->result(); 
        $data['packing_sizes'] = $this->db->get_where('packing_sizes', array('status' => 1))->result(); 
        $data['glazing'] = $this->db->get_where('glazing', array('status' => 1))->result(); 
        $data['blocks'] = $this->db->get_where('blocks', array('status' => 1))->result(); 
        $data['sizes'] = $this->db->get_where('sizes', array('status' => 1))->result(); 
        $data['units'] = $this->db->get_where('units', array('status' => 1))->result();

        $data['offer_status'] = $this->db->select('offer_status_id, offer_status')->get_where('offer_status', array('status' => 1))->result();
        $data['company'] = $this->db->select('company_id, company_name')->get_where('company', array('status' => 'Active'))->result();

        $data['suppliers'] = $this->db->select('am_id, name, am_code')->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 0))->result(); 


        $data['permitted_suppliers'] = $this->db->select('acc_masters')->get_where('users', array('users.user_id' => $this->session->user_id))->row(); 
        
        $data['currencies'] = $this->db->select('c_id, currency, code, symbol')->get_where('currencies', array('status' => 1))->result(); 

        $data['countries'] = $this->db->select('country_id, iso, name')->get_where('countries', array('status' => 1))->result(); 

        $data['ports'] = $this->db->select('p_id, port_name')->get_where('ports', array('status' => 1))->result();

        $data['remark1_offer_validity'] = $this->db->get_where('remark1_offer_validity', array('status' => 1))->result();

        $data['incoterms'] = $this->db->select('it_id, incoterm, information')->get_where('incoterms', array('status' => 1))->result(); 

        /*Common End*/


        /*This for Offer header*/

        if($usertype == 1){
            # if admin
            $data['resources'] = $this->db->select('users.user_id, users.username, firstname, lastname')->join('user_details', 'users.user_id = user_details.user_id', 'left')->get_where('users', array('users.verified' => 1, 'users.blocked' => 0, 'users.usertype' => 2))->result(); 
            $data['offer_details'] =$this->db->select('offers.*,currencies.currency, currencies.symbol')->join('currencies', 'currencies.c_id = offers.c_id', 'left')->get_where('offers', array('offer_id' => $offer_id))->result();


            //$data['currencies'] = $this->db->select('c_id, currency, code, symbol')->get_where('currencies', array('status' => 1))->result(); 

            
        }else{
            # if others
            $data['resources'] = $this->db->select('users.user_id, users.username, firstname, lastname')->join('user_details', 'users.user_id = user_details.user_id', 'left')->get_where('users', array('users.verified' => 1, 'users.blocked' => 0, 'users.usertype' => 2, 'users.user_id' => $user_id))->result();
            // $data['offer_details'] = $this->db->get_where('offers_resource', array('offer_id' => $offer_id))->result();
            $data['offer_details'] =$this->db->select('offers_resource.*,currencies.currency, currencies.symbol')->join('currencies', 'currencies.c_id = offers_resource.c_id', 'left')->get_where('offers_resource', array('offer_id' => $offer_id))->result();


            //$data['currencies'] = $this->db->select('c_id, currency, code, symbol')->get_where('currencies', array('status' => 1))->result(); 

            
        }

        if(@count($data['offer_details']) == 0){
           
            $this->session->set_flashdata('type', 'warning');

            $this->session->set_flashdata('msg', 'Oops! somthing went wrong. Please try again.');
            redirect(base_url('admin/offers'));
        }

        /*This for Offer header End*/

        return array('page'=>'offer/offer_edit_v', 'data'=>$data);
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

    public function form_edit_offer(){

        if(count((array)$this->input->post('acc_master_id[]')) > 0){
            $supplier = join(',',$this->input->post('acc_master_id[]'));
        }else{
            $supplier = '';
        }
        
        if(count((array)$this->input->post('destination_c_id[]')) > 0){
            $dstn = join(',',$this->input->post('destination_c_id[]'));
        }else{
            $dstn = '';
        }

        $updateArray = array(
            'offer_id' => $this->input->post('offer_id'),
            'offer_name' => $this->input->post('offer_name'),
            'offer_number' => $this->input->post('offer_number'),
            'offer_fz_number' => $this->input->post('offer_fz_number'),
            'am_id' => $supplier,
            'c_id' => $this->input->post('currencies'),
            'resource_id' => $this->input->post('resources'),
            'country_id' => $this->input->post('country_id'),
            'destination_c_id' => $dstn,
            'incoterm_id' => $this->input->post('incoterms'),
            'offer_date' => $this->input->post('offer_date'),
            'no_of_container' => $this->input->post('no_of_container'),
            'size_of_container' => $this->input->post('size_of_container'),
            'quantity_each_container' => $this->input->post('quantity_each_container'),
            'shipment_timing' => $this->input->post('shipment_timing'),
            'shelf_life' => $this->input->post('shelf_life'),
            'shipping_line' => $this->input->post('shipping_line'),
            'supplier_payment_terms' => $this->input->post('supplier_payment_terms'),
            'document_clause' => $this->input->post('document_clause'),
            'inspection_clause' => $this->input->post('inspection_clause'),
            'lab_report_clause' => $this->input->post('lab_report_clause'),
            'etd' => $this->input->post('etd'),    
            'port_of_loading' => $this->input->post('port_of_loading'),    
            'production_date' => $this->input->post('production_date'), 
            'shelf_life' => $this->input->post('shelf_life'),    
            'tolerance' => $this->input->post('tolerance'),
            'label_attached' => $this->input->post('label_attached'),
            'carton_with_date' => $this->input->post('carton_with_date'),
            'remarks_1' => $this->input->post('remark1'),
            'remarks_2' => $this->input->post('remark2'),
            'remarks_3' => $this->input->post('remark3'),
            'docs_provided' => $this->input->post('docs_provided'),
            'user_id' => $this->session->user_id,
            'company_id' => $this->input->post('company_id'),
            'offer_status_id' => $this->input->post('offer_status_id'),
        );
        
        // print_r($updateArray);die;
        
        if($this->session->usertype == 1){
            
            $updateOfferStatus = array(
                'offer_status_id' => $this->input->post('offer_status_id')
            );
            
            $val = $this->db->update('offers', $updateArray, array('offer_id' => $this->input->post('offer_id')));   
            $val = $this->db->update('offers_resource', $updateOfferStatus, array('offer_id' => $this->input->post('offer_id')));
            
        }else{

            $val = $this->db->update('offers', $updateArray, array('offer_id' => $this->input->post('offer_id')));   

            $val = $this->db->update('offers_resource', $updateArray, array('offer_id' => $this->input->post('offer_id')));
        }
        // echo $this->db->last_query();

        if($val){

            $data['insert_id'] = $this->input->post('offer_id');

            $upload_picture_success = 0; 
            $upload_report_success = 0; 
            $upload_picture_error = 0; 
            $upload_report_error = 0; 


            // image upload
            
            if (!empty($_FILES['userfile']['name'][0])) {

                $return_data = array(); 

                $upload_path = './upload/pictures/' ; 
                $file_type = 'jpg|jpeg|png';
                $user_file_name = 'userfile';

                $return_data = $this->_upload_files($_FILES['userfile'], $upload_path, $file_type, $user_file_name);

                // print_r($return_data);die;

                foreach ($return_data as $datam) {

                    if ($datam['status'] == 'error') {
                        
                        $upload_picture_error++;                        

                    }else{

                        // Insert filename to db
                        
                        $insertArray = array(
                            'offer_id' => $data['insert_id'],
                            'file_category' => 'picture',
                            'file_name' => $datam['filename'],
                            'user_id' => $this->session->user_id
                        );

                        $this->db->insert('offer_files', $insertArray);

                        $upload_picture_success++;
                    }
                }

            }else{
                $data['type'] = 'success';
                $data['msg'] = 'No Files Uploaded <hr> Offer added successfully.'; 
            }     

            // Report Upload

            if (!empty($_FILES['inspection_reports']['name'][0])) {

                $return_data = array(); 

                $upload_path = './upload/reports/' ; 
                $file_type = 'txt|doc|docx|xls|xlsx|pdf';
                $user_file_name = 'inspection_reports';

                $return_data = $this->_upload_files($_FILES['inspection_reports'], $upload_path, $file_type, $user_file_name);

                // print_r($return_data);die;

                foreach ($return_data as $datam) {

                    if ($datam['status'] == 'error') {

                        $upload_report_error++; 

                    }else{

                        // Insert filename to db
                        
                        $insertArray = array(
                            'offer_id' => $data['insert_id'],
                            'file_category' => 'report',
                            'file_name' => $datam['filename'],
                            'user_id' => $this->session->user_id
                        );

                        $this->db->insert('offer_files', $insertArray);

                        $upload_report_success++; 
                    }
                }

            }else{
                $data['type'] = 'success';
                $data['msg'] = 'No Files Uploaded<hr>Offer added successfully.'; 
            }         

        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Database Insert Error';
        }

        if($upload_report_error > 0 or $upload_picture_error > 0){

            $data['type'] = 'error';
            $data['msg'] = 'Some or All Files Not Uploaded.<hr>Pending Pictures:'.$upload_picture_error.'<br>Pending Report:'.$upload_report_error;

        }else if($upload_report_success > 0 or $upload_picture_success > 0){

            $data['type'] = 'success';
            $data['msg'] = 'Offer added successfully.<hr>Pictures Uploaded:'.$upload_picture_success.'<br>Reports Uploaded:'.$upload_report_success;
        }


        return $data;

    }

    public function ajax_offer_details_table_data() {


        // echo $this->session->usertype; die();

        if ($this->session->usertype == 1) {
            // when user admin means trader
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

        $this->db->select('offer_details.od_id, offer_details.offer_id, offer_details.pieces, quantity_offered, product_price, product_name, packing_sizes.packing_size, scientific_name, sizes.size');
        $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
        $this->db->join('sizes', 'offer_details.size_id = sizes.size_id', 'left');
        $this->db->join('packing_sizes', 'offer_details.packing_size_id = packing_sizes.ps_id', 'left');
        $rs = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();
        
        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);
            
            $this->db->select('offer_details.od_id, offer_details.offer_id, offer_details.pieces, quantity_offered, product_price, product_name, 
                packing_sizes.packing_size, scientific_name, sizes.size');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $this->db->join('sizes', 'offer_details.size_id = sizes.size_id', 'left');
            $this->db->join('packing_sizes', 'offer_details.packing_size_id = packing_sizes.ps_id', 'left');
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

            $this->db->select('offer_details.od_id, offer_details.offer_id, offer_details.pieces, quantity_offered, product_price, product_name, 
                 packing_sizes.packing_size, scientific_name, sizes.size');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $this->db->join('sizes', 'offer_details.size_id = sizes.size_id', 'left');
            $this->db->join('packing_sizes', 'offer_details.packing_size_id = packing_sizes.ps_id', 'left');
            $rs = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();      

            $totalFiltered = count((array)$rs);

            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $this->db->select('offer_details.od_id, offer_details.offer_id, offer_details.pieces, quantity_offered, product_price, product_name, 
                packing_sizes.packing_size, scientific_name, sizes.size');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $this->db->join('sizes', 'offer_details.size_id = sizes.size_id', 'left');
            $this->db->join('packing_sizes', 'offer_details.packing_size_id = packing_sizes.ps_id', 'left');
            $rs = $this->db->get_where('offer_details', array('offer_id' => $offer_id))->result();

            $this->db->flush_cache();
        }

        $data = array();
        

        foreach ($rs as $val) {
            
            $nestedData['name'] = $val->product_name;
            $nestedData['scientific_name'] = $val->scientific_name;
            $nestedData['size_name'] = $val->size;

            $nestedData['pieces'] = $val->pieces;

            $nestedData['packing_size'] = $val->packing_size;

            
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
                <a title="Inter-Copy (Other Offer Details)" href="javascript:void(0)" data-od_id="'.$val->od_id.'" class="offer_details_export_btn btn bg-yellow"><i class="fa fa-clone"></i> Export</a>';
                /*<a data-tab="offer_details" data-pk="'.$val->od_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>*/

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
        }elseif ($this->session->usertype == 2) {
            // when resource developer

            $offer_id = $this->input->post('offer_id');
        //actual db table column names
        $column_orderable = array(
            0 => 'offer_details_resource.product_id'
        );
        // Set searchable column fields
        $column_search = array('product_name');
        // $column_search = array('co_no');

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $this->db->select('offer_details_resource.odr_id, offer_details_resource.offer_id, quantity_offered, product_price, product_name, scientific_name, offer_details_resource.pieces, packing_sizes.packing_size, sizes.size');
        $this->db->join('products', 'products.pr_id = offer_details_resource.product_id', 'left');
        $this->db->join('sizes', 'offer_details_resource.size_id = sizes.size_id', 'left');
        $this->db->join('packing_sizes', 'offer_details_resource.packing_size_id = packing_sizes.ps_id', 'left');
        $rs = $this->db->get_where('offer_details_resource', array('offer_id' => $offer_id))->result();
        
        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);
            
            $this->db->select('offer_details_resource.odr_id, offer_details_resource.offer_id, quantity_offered, product_price, product_name, scientific_name, offer_details_resource.pieces, packing_sizes.packing_size, sizes.size');
        $this->db->join('products', 'products.pr_id = offer_details_resource.product_id', 'left');
        $this->db->join('sizes', 'offer_details_resource.size_id = sizes.size_id', 'left');
        $this->db->join('packing_sizes', 'offer_details_resource.packing_size_id = packing_sizes.ps_id', 'left');
        $rs = $this->db->get_where('offer_details_resource', array('offer_id' => $offer_id))->result();
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

            $this->db->select('offer_details_resource.odr_id, offer_details_resource.offer_id, quantity_offered, product_price, product_name, scientific_name, offer_details_resource.pieces, packing_sizes.packing_size, sizes.size');
            $this->db->join('products', 'products.pr_id = offer_details_resource.product_id', 'left');
            $this->db->join('sizes', 'offer_details_resource.size_id = sizes.size_id', 'left');
        $this->db->join('packing_sizes', 'offer_details_resource.packing_size_id = packing_sizes.ps_id', 'left');
            $rs = $this->db->get_where('offer_details_resource', array('offer_id' => $offer_id))->result();      

            $totalFiltered = count((array)$rs);

            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $this->db->select('offer_details_resource.odr_id, offer_details_resource.offer_id, quantity_offered, product_price, product_name, scientific_name, offer_details_resource.pieces, packing_sizes.packing_size, sizes.size');
            $this->db->join('products', 'products.pr_id = offer_details_resource.product_id', 'left');
            $this->db->join('sizes', 'offer_details_resource.size_id = sizes.size_id', 'left');
            $this->db->join('packing_sizes', 'offer_details_resource.packing_size_id = packing_sizes.ps_id', 'left');
            $rs = $this->db->get_where('offer_details_resource', array('offer_id' => $offer_id))->result();

            $this->db->flush_cache();
        }

        $data = array();
        

        foreach ($rs as $val) {
            
            $nestedData['name'] = $val->product_name;
            $nestedData['scientific_name'] = $val->scientific_name;
             $nestedData['size_name'] = $val->size;

            $nestedData['pieces'] = $val->pieces;

            $nestedData['packing_size'] = $val->packing_size;

            $nestedData['quantity'] = $val->quantity_offered;
            $nestedData['price'] = $val->product_price;
            $nestedData['total_price'] = $val->product_price * $val->quantity_offered;

            if($this->session->usertype == 1){

                $nestedData['action'] = '<a href="javascript:void(0)" data-od_id="'.$val->odr_id.'" class="offer_details_edit_btn btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                <a title="Intra-Copy (Current Offer Details)" href="javascript:void(0)" data-od_id="'.$val->odr_id.'" class="offer_details_clone_btn btn bg-beige"><i class="fa fa-clone"></i> Clone</a>
                <a title="Inter-Copy (Other Offer Details)" href="javascript:void(0)" data-od_id="'.$val->odr_id.'" class="offer_details_export_btn btn bg-yellow"><i class="fa fa-clone"></i> Export</a>
                <a href="javascript:void(0)" data-offer_id="'.$val->offer_id.'" data-od_id="'.$val->odr_id.'" class="offer_details_pricing_btn btn bg-green1"><i class="fa fa-clone"></i> Pricing</a>
                <a data-tab="offer_details" data-pk="'.$val->odr_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';

            }else{

                $nestedData['action'] = '<a href="javascript:void(0)" data-od_id="'.$val->odr_id.'" class="offer_details_edit_btn btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
                <a title="Intra-Copy (Current Offer Details)" href="javascript:void(0)" data-od_id="'.$val->odr_id.'" class="offer_details_clone_btn btn bg-beige"><i class="fa fa-clone"></i> Clone</a>
                <a title="Inter-Copy (Other Offer Details)" href="javascript:void(0)" data-od_id="'.$val->odr_id.'" class="offer_details_export_btn btn bg-yellow"><i class="fa fa-clone"></i> Export</a>';

                /*<a data-tab="offer_details" data-pk="'.$val->odr_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>*/

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
        }
        

        return $json_data;
    }  


    public function ajax_fetch_assigned_templates($offer_id){

        $data = array();
        
        $rs = $this->db
            ->select('template_name, view_templates.vt_id,assigned_templates.marketing_id, assigned_templates.resource_id')
            // ->join('user_details','users.user_id = user_details.user_id','left')
            ->join('view_templates','view_templates.vt_id = assigned_templates.vt_id','left')
            ->where(array('assigned_templates.offer_id' => $offer_id))
            ->get('assigned_templates')
            ->result();

            if (count($rs) > 0) {
                $data['rs'] =  $rs;
            }else{
                $data['rs'] =  array("no");
            }
            
            $approval_status = $this->db->select('final_marketing_approval_status')->where(array('offer_id' => $offer_id))->get('offers')->row();
            $data['approval_status'] = $approval_status->final_marketing_approval_status;


            

            return $data;
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

            // return  $this->db->last_query();
    
        $data["offer_headers"] = $this->db
            ->select('resource_edit_status,final_marketing_approval_status')
            ->where(array('offers.offer_id' => $offer_id))
            ->get('offers')
            ->result();
            // return  $this->db->last_query();
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
            $data["final_mail_send_status"] = $this->db->select('final_mail_send_status')
            ->where(array('offer_id' => $offer_id))
            ->get('final_mail_send')
            ->row();  



        $data["exoprt_data"] = $this->db
            ->where(array('offer_id' => $offer_id))
            ->get('exportdata')
            ->num_rows();   
            
        return $data;    

        // echo $this->db->get_compiled_select('assigned_templates');
        // exit();        

    }

    public function form_add_offer_details(){

        /*echo "Here";

        die();*/

        /*  echo "<pre>";

        print_r($this->input->post());

        die();*/
        
        $insertArray = array(
            'offer_id' => $this->input->post('offer_id'),
            'product_id' => $this->input->post('product_id'),
            'product_description' => $this->input->post('product_description'),

            'freezing_id' => $this->input->post('freezing_id'),
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

            'product_line' => $this->input->post('product_line_po'),
            
            'product_line_sc' => $this->input->post('product_line_sc'),
            
            'gross_weight' => $this->input->post('gross_weight'),
            
            

            'cartons_offered' => $this->input->post('cartons_offered'),
            'product_price' => $this->input->post('product_price'),
            'comment' => $this->input->post('comment'),
            'user_id' => $this->session->user_id
        );
        // echo '<pre>', print_r($insertArray), '</pre>';die;

        if ($this->session->usertype == 1) {
            // when trader
            $this->db->insert('offer_details', $insertArray);
        
            if($this->db->insert_id() > 0){

                $original_offer_details_id = $this->db->insert_id();
                $data['insert_id'] = $original_offer_details_id;
                
                /*$this->db->insert('offer_details_resource', $insertArray);
                $resource_offer_details_id = $this->db->insert_id();*/
                
                // Update resource offer id with current offer ID
                
                /*$updateArray = array(
                    'od_id' => $original_offer_details_id
                );
            
                $this->db->update('offer_details_resource', $updateArray, array('odr_id' => $resource_offer_details_id));*/
                
                $data['type'] = 'success';
                $data['msg'] = 'Offer details added successfully.';
                
            }else{
                
                $data['type'] = 'error';
                $data['msg'] = 'Offer not added. Contact Admin';
                
            }
            // $data['insert_id'] = $this->db->insert_id();
        }elseif ($this->session->usertype == 2) {

            // when resource developer

            $this->db->insert('offer_details', $insertArray);
        
            if($this->db->insert_id() > 0){

                $original_offer_details_id = $this->db->insert_id();
                //$data['insert_id'] = $original_offer_details_id;

                $insertArray['od_id'] = $original_offer_details_id;
                
                
                $this->db->insert('offer_details_resource', $insertArray);
                //$resource_offer_details_id = $this->db->insert_id();
                
                // Update resource offer id with current offer ID
                
                /*$updateArray = array(
                    'od_id' => $original_offer_details_id
                );
            
                $this->db->update('offer_details_resource', $updateArray, array('odr_id' => $resource_offer_details_id));*/
                
                $data['type'] = 'success';
                $data['msg'] = 'Offer details added successfully.';
                
            }else{
                
                $data['type'] = 'error';
                $data['msg'] = 'Offer not added. Contact Admin';
                
            }
            // $data['insert_id'] = $this->db->insert_id();
        }
        
        
         
        return $data;
    }
    
    public function fetch_offer_details_on_pk(){

        if ($this->session->usertype == 1) {
            $od_id = $this->input->post('pk');
            $rs = $this->db->get_where('offer_details', array('od_id' => $od_id))->result();
        }elseif ($this->session->usertype == 2) {
            $odr_id = $this->input->post('pk');
            $rs = $this->db->get_where('offer_details_resource', array('odr_id' => $odr_id))->result();
        }

        return $rs;
        
        
    }

    public function form_edit_offer_details(){
        
        /*echo "<pre>";

        print_r($this->input->post());

        die();*/
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

            'product_line' => $this->input->post('product_line_po_edit'),
            
            'product_line_sc' => $this->input->post('product_line_sc_edit'),
            
            'gross_weight' => $this->input->post('gross_weight_edit'),
        


            'grade' => $this->input->post('grade_edit'),
            'pieces' => $this->input->post('pieces_edit'),
            'unit_id' => $this->input->post('unit_id_edit'),
            'cartons_offered' => $this->input->post('cartons_offered_edit'),
            'product_price' => $this->input->post('product_price_edit'),
            'comment' => $this->input->post('comment_edit'),
            'user_id' => $this->session->user_id
        );
        $od_id = $this->input->post('offer_details_trader_id_edit');



         if ($this->session->usertype == 1) {

            // echo '<pre>', print_r($updateArray), '</pre>';die;
            $this->db->update('offer_details', $updateArray, array('od_id' => $od_id));
            // echo $this->db->last_query();die;
         }elseif ($this->session->usertype == 2) {


            $this->db->update('offer_details', $updateArray, array('od_id' => $od_id));

            $odr_id = $this->input->post('offer_details_id_edit');

            // offer_details_id_edit
            $this->db->update('offer_details_resource', $updateArray, array('odr_id' => $odr_id));

         }


        $data['type'] = 'success';
        $data['msg'] = 'Offer details updated successfully.';
        return $data;
    }

    public function form_export_offer_details(){
        

        /* echo "<pre>";

        print_r($this->input->post());

        die();*/
        $insertArray = array(
            'offer_id' => $this->input->post('offer_id_export'),
            'product_id' => $this->input->post('product_id_export'),
            'freezing_id' => $this->input->post('freezing_id_export'),
            'freezing_method_id' => $this->input->post('freezing_method_export'),


            'primary_packing_type_id' => $this->input->post('primary_packing_type_id_export'),
            'secondary_packing_type_id' => $this->input->post('secondary_packing_type_id_export'),
            'packing_size_id' => $this->input->post('packing_size_id_export'),

            'glazing_id' => $this->input->post('glazing_id_export'),
            'block_id' => $this->input->post('block_id_export'),
            'size_id' => $this->input->post('size_id_export'),
            'size_before_glaze' => $this->input->post('size_before_glaze_export'),
            'size_after_glaze' => $this->input->post('size_after_glaze_export'),
            'quantity_offered' => $this->input->post('quantity_offered_export'),

            'product_line' => $this->input->post('product_line_po_export'),

            'product_line_sc' => $this->input->post('product_line_sc_export'),
            
            'gross_weight' => $this->input->post('gross_weight_export'),
            
            

            'grade' => $this->input->post('grade_export'),
            'pieces' => $this->input->post('pieces_export'),
            'unit_id' => $this->input->post('unit_id_export'),
            'cartons_offered' => $this->input->post('cartons_offered_export'),
            'product_price' => $this->input->post('product_price_export'),
            'comment' => $this->input->post('comment_export'),
            'user_id' => $this->session->user_id
        );
        
        // echo '<pre>', print_r($insertArray), '</pre>';die;
        
      /*  if($this->session->usertype == 1){
            $this->db->insert('offer_details', $insertArray);    
        }else{
            $this->db->insert('offer_details_resource', $insertArray);
        }*/


                if ($this->session->usertype == 1) {
            // when trader
            $this->db->insert('offer_details', $insertArray);
        
            if($this->db->insert_id() > 0){

                $original_offer_details_id = $this->db->insert_id();
                $data['insert_id'] = $original_offer_details_id;
                
                /*$this->db->insert('offer_details_resource', $insertArray);
                $resource_offer_details_id = $this->db->insert_id();*/
                
                // Update resource offer id with current offer ID
                
                /*$updateArray = array(
                    'od_id' => $original_offer_details_id
                );
            
                $this->db->update('offer_details_resource', $updateArray, array('odr_id' => $resource_offer_details_id));*/
                
                $data['type'] = 'success';
                $data['msg'] = 'Offer details added successfully.';
                
            }else{
                
                $data['type'] = 'error';
                $data['msg'] = 'Offer not added. Contact Admin';
                
            }
            // $data['insert_id'] = $this->db->insert_id();
        }elseif ($this->session->usertype == 2) {

            // when resource developer

            $this->db->insert('offer_details', $insertArray);
        
            if($this->db->insert_id() > 0){

                $original_offer_details_id = $this->db->insert_id();
                //$data['insert_id'] = $original_offer_details_id;

                $insertArray['od_id'] = $original_offer_details_id;
                
                
                $this->db->insert('offer_details_resource', $insertArray);
                //$resource_offer_details_id = $this->db->insert_id();
                
                // Update resource offer id with current offer ID
                
                /*$updateArray = array(
                    'od_id' => $original_offer_details_id
                );
            
                $this->db->update('offer_details_resource', $updateArray, array('odr_id' => $resource_offer_details_id));*/
                
                $data['type'] = 'success';
                $data['msg'] = 'Offer details added successfully.';
                
            }else{
                
                $data['type'] = 'error';
                $data['msg'] = 'Offer not added. Contact Admin';
                
            }
            // $data['insert_id'] = $this->db->insert_id();
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

        $user_id = $this->session->user_id;

        $on = '"OFFER/'.date('dmY').'/'.date('his').'"';
        
        if($this->session->usertype == 1){
        
            $query = "
                INSERT INTO offers(
                    `offer_name`,`offer_number`,`offer_date`,`am_id`,`destination_c_id`,
                    `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,`resource_edit_status`,`resource_id`
                )
                SELECT
                    `offer_name`,$on,`offer_date`,`am_id`,`destination_c_id`, `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,1,$user_id
                FROM
                    offers
                WHERE
                    offer_id = $offer_id
            ";
        
        }else{

            $queryFortrader = "
                INSERT INTO offers(
                    `offer_name`,`offer_number`,`offer_date`,`am_id`,`destination_c_id`,
                    `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,`resource_edit_status`,`resource_id`
                )
                SELECT
                    `offer_name`,$on,`offer_date`,`am_id`,`destination_c_id`, `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,1,$user_id
                FROM
                    offers
                WHERE
                    offer_id = $offer_id
            ";


            $this->db->query($queryFortrader);

            $new_trader_offer_id = $this->db->insert_id();
            
            $query = "
                INSERT INTO offers_resource(
                    `offer_id`,`offer_name`,`offer_number`,`offer_date`,`am_id`,`destination_c_id`,
                    `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,`resource_edit_status`,`resource_id`
                )
                SELECT
                    $new_trader_offer_id, `offer_name`,$on,`offer_date`,`am_id`,`destination_c_id`, `country_id`,`c_id`,`incoterm_id`,`no_of_container`,`size_of_container`,`quantity_each_container`,`shipping_line`,`supplier_payment_terms`,`document_clause`,`inspection_clause`,`lab_report_clause`,`shipment_timing`,`etd`,`port_of_loading`,`production_date`,`shelf_life`,`tolerance`,`label_attached`,`carton_with_date`,`remarks_1`,`remarks_2`,`remarks_3`,1,$user_id
                FROM
                    offers_resource
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



                $query_offer_details_trader ="
                    INSERT INTO offer_details(
                    `offer_id`,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,`user_id`)
                    SELECT 
                    $new_trader_offer_id,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,1
                    FROM
                        offer_details
                    WHERE
                        offer_id = $offer_id
                ";

                $this->db->query($query_offer_details_trader);

                $new_trader_offer_details_id = $this->db->insert_id();



                $query1="
                    INSERT INTO offer_details_resource(
                    `od_id`,`offer_id`,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,`user_id`)
                    SELECT 
                    $new_trader_offer_details_id, $new_trader_offer_id,`product_id`,`freezing_id`,`freezing_method_id`,`primary_packing_type_id`,`secondary_packing_type_id`,`packing_size_id`,`glazing_id`,`block_id`,`size_id`,`pieces`,`grade`,`size_before_glaze`,`size_after_glaze`,`quantity_offered`,`unit_id`,`cartons_offered`,`product_price`,`comment`,1
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

        $data['insert_id'] = $new_trader_offer_id;
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
        $data['msg'] = 'Uploaded File Successfully Deleted. <hr> Refresh to Update';
        return $data;
    }


    public function report()
    {
        $data = array();
        $data['template_data'] = $this->db
                ->select('vt_id,template_name,user_id')
                ->get_where('view_templates',array('status' => 1))->result();

        
        if($this->session->usertype == 2) //resource developer
        {
            $data['offer_data'] = $this->db
                ->select('offer_id,offer_name')
                ->where('resource_id', $this->session->user_id)
                ->get_where('offers',array('status' => 1))->result();
        }else{
            $data['offer_data'] = $this->db
                ->select('offer_id,offer_name')
                ->get_where('offers',array('status' => 1))->result();
        }
                
        return $data;
    }


    public function report_filter()
    {
        $data = array();
        $data['vendor'] = $this->db->get_where('acc_master',array('supplier_buyer' => 0))->result();


        $data['customer'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();


        $data['product'] = $this->db->get_where('products', array('status' => 1))->result();
        
        $data['destination'] = $this->db->get_where('countries', array('status' => 1))->result();

        $data['template'] = $this->db->get('report_filter_template')->result();

        $data['offer_status'] = $this->db->get_where('offer_status', array('status' => 1))->result();
        $data['company'] = $this->db->get_where('company', array('status' => "Active"))->result();      

        $data['offer'] = $this->db->select('offer_id,offer_name')->get_where('offers', array('status' => 1))->result();
        return $data;
    }

    public function report_filter_export()
    {
        $data = array();
        $data['vendor'] = $this->db->get_where('acc_master',array('supplier_buyer' => 0))->result();


        $data['customer'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();


        $data['product'] = $this->db->get_where('products', array('status' => 1))->result();
        
        $data['destination'] = $this->db->get_where('countries', array('status' => 1))->result();

        $data['template'] = $this->db->get('report_filter_template')->result();

        $data['offer_status'] = $this->db->get_where('offer_status', array('status' => 1))->result();
        $data['company'] = $this->db->get_where('company', array('status' => "Active"))->result();      

        $data['offer'] = $this->db->select('offer_id,offer_name')->get_where('offers', array('status' => 1))->result();
        return $data;
    }
    
    
    public function ajax_get_product_data()
    {
        
        $offer_id = $this->input->post('offer_id');
        $data = array();
        $p_data =  $this->db->select('od_id,product_id,product_name, sizes.size, units.unit')
        ->join('products','products.pr_id = offer_details.product_id','left')
        ->join('sizes','sizes.size_id = offer_details.size_id','left')
        ->join('units','units.u_id = sizes.unit_id','left')
        //->group_by('offer_details.product_id')
        ->get_where('offer_details', array('offer_details.offer_id'=> $offer_id, 'offer_details.status' => 1))->result();
        
        
        $html = '<option value=""> -- Select Product -- </option>';
        
        
        foreach($p_data as $index=>$val){
            
            $html .= '<option value='.$val->product_id.'> '.$val->product_name.' ('.$val->size.' '.$val->unit.') </option>';
        }
        
        return $html;
    }

    public function report_filter_form()
    {
        // echo "<pre>"; print_r($this->input->post()); die();
        $data = array();

        //if ($this->input->post('submit_btn') == 'submit') {
            

                /*Define Veriable*/

                $customer_id = $this->input->post('customer_id');
                $vendor_id = $this->input->post('vendor_id');
                $offer_id = $this->input->post('offer_id');
                $product_id = $this->input->post('product_id'); 
                $product_id_exe = $this->input->post('product_id_exe');
                $origin_id = $this->input->post('origin_id');
                $destination_id = $this->input->post('destination_id');
                $tepmlate_id = $this->input->post('tepmlate_id');


                $company_id = $this->input->post('company_id');
                $tepmlate_id = $this->input->post('tepmlate_id');
                
                




            /******************/
            $this->db->select('offers.*, offer_details.*, DATE_FORMAT(offers.offer_date, "%d-%m-%Y") as offer_date, acc_master.name as supplier_name, acc_master.am_code as supplier_code, currencies.currency, currencies.symbol as currency_code, countries.iso, countries.name, incoterms.incoterm, ports.port_name,remark1_offer_validity.remark, product_name, product_price, scientific_name, f1.freezing_type,f2.freezing_type as freezing_method, ptp.packing_type, pts.packing_type as pts, packing_size, glazing, block_size,sizes.size,units.unit, size_before_glaze, size_after_glaze, offer_details.od_id,quantity_offered, cartons_offered');
            $this->db->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $this->db->join('freezing f1', 'f1.ft_id = offer_details.freezing_id', 'left');
            $this->db->join('freezing f2', 'f2.ft_id = offer_details.freezing_method_id', 'left');
            $this->db->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left');
            $this->db->join('packing_types ptp', 'ptp.pt_id = offer_details.primary_packing_type_id', 'left');
            $this->db->join('packing_types pts', 'pts.pt_id = offer_details.secondary_packing_type_id', 'left');
            $this->db->join('glazing', 'glazing.gl_id = offer_details.glazing_id', 'left');
            $this->db->join('blocks', 'blocks.block_id = offer_details.block_id', 'left');
            $this->db->join('sizes', 'sizes.size_id = offer_details.size_id', 'left');
            $this->db->join('units', 'units.u_id = sizes.unit_id', 'left');

            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left');
            $this->db->join('ports', 'ports.p_id = offers.port_of_loading', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');

            $this->db->join('sell_price_details', 'sell_price_details.offer_id = offers.offer_id');

            
            
            if(!empty($origin_id)){
                $this->db->where('offers.country_id', $origin_id);
            }
            if (!empty($destination_id)) {
                $this->db->where('offers.destination_c_id', $destination_id);
            }

            if (!empty($vendor_id)) {
                $this->db->where('offers.am_id', $vendor_id);
            }

            if (!empty($customer_id)) {
                $this->db->where('sell_price_details.am_id', $customer_id);
            }
            if(!empty($product_id)){
                $this->db->where('offer_details.product_id', $product_id);
            }
            if(!empty($product_id_exe)){
                $this->db->where('products.pr_id', $product_id_exe);
            }


            if(!empty($company_id)){
                $this->db->where('offers.company_id', $company_id);
            }
            if(!empty($offer_status)){
                $this->db->where('offers.offer_status_id', $offer_status);
            }


            if (!empty($offer_id)) {
                $this->db->group_by('offer_details.od_id');
                $this->db->where('offers.offer_id', $offer_id);
                
            }

            $data['offer'] = $this->db->get('offers')->result();


            /*-------Raw SQL-------*/

            /*---------------------*/

            // echo $this->db->last_query(); die();

             // echo "<pre>"; print_r($data['offer']); die();

            $data['templates'] = $this->db->get_where('report_filter_template', array('report_filter_template_id' => $tepmlate_id))->row();

            return $data;
    }

    public function report_filter_export_form()
    {
        // echo "<pre>"; print_r($this->input->post()); die();
        $data = array();
        //if ($this->input->post('submit_btn') == 'submit') {

            /*Define Veriable*/
            $customer_id = $this->input->post('customer_id');
            $vendor_id = $this->input->post('vendor_id');
            $offer_id = $this->input->post('offer_id');
            $product_id = $this->input->post('product_id'); 
            $origin_id = $this->input->post('origin_id');
            $destination_id = $this->input->post('destination_id');
            $tepmlate_id = $this->input->post('tepmlate_id');
            $company_id = $this->input->post('company_id');
            $tepmlate_id = $this->input->post('tepmlate_id');

            /******************/
            /*offer_details.*, DATE_FORMAT(offers.offer_date, "%d-%m-%Y") as offer_date, acc_master.name as supplier_name, acc_master.am_code as supplier_code, currencies.currency, currencies.symbol as currency_code, countries.iso, countries.name, incoterms.incoterm, ports.port_name,remark1_offer_validity.remark, product_name, product_price, scientific_name, f1.freezing_type,f2.freezing_type as freezing_method, ptp.packing_type, pts.packing_type as pts, packing_size, glazing, block_size,sizes.size,units.unit, size_before_glaze, size_after_glaze, offer_details.od_id,quantity_offered, cartons_offered*/
            $this->db->select('exportdata.3rd_insp_upload as rdinsp, exportdata.*');
            $this->db->join('offers', 'offers.offer_id = exportdata.offer_id', 'left');
            $this->db->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left');
            $this->db->join('products', 'products.pr_id = offer_details.product_id', 'left');
            $this->db->join('freezing f1', 'f1.ft_id = offer_details.freezing_id', 'left');
            $this->db->join('freezing f2', 'f2.ft_id = offer_details.freezing_method_id', 'left');
            $this->db->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left');
            $this->db->join('packing_types ptp', 'ptp.pt_id = offer_details.primary_packing_type_id', 'left');
            $this->db->join('packing_types pts', 'pts.pt_id = offer_details.secondary_packing_type_id', 'left');
            $this->db->join('glazing', 'glazing.gl_id = offer_details.glazing_id', 'left');
            $this->db->join('blocks', 'blocks.block_id = offer_details.block_id', 'left');
            $this->db->join('sizes', 'sizes.size_id = offer_details.size_id', 'left');
            $this->db->join('units', 'units.u_id = sizes.unit_id', 'left');

            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left');
            $this->db->join('ports', 'ports.p_id = offers.port_of_loading', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');

            $this->db->join('sell_price_details', 'sell_price_details.offer_id = offers.offer_id');

            
            if(!empty($origin_id)){
                $this->db->where('offers.country_id', $origin_id);
            }
            if (!empty($destination_id)) {
                $this->db->where('offers.destination_c_id', $destination_id);
            }

            if (!empty($vendor_id)) {
                $this->db->where('offers.am_id', $vendor_id);
            }

            if (!empty($customer_id)) {
                $this->db->where('sell_price_details.am_id', $customer_id);
            }
            if(!empty($product_id)){
                $this->db->where('offer_details.product_id', $product_id);
            }

            if(!empty($company_id)){
                $this->db->where('offers.company_id', $company_id);
            }
            if(!empty($offer_status)){
                $this->db->where('offers.offer_status_id', $offer_status);
            }

            if (!empty($offer_id)) {
                $this->db->group_by('offer_details.od_id');
                $this->db->where('offers.offer_id', $offer_id);
                
            }

            $data['export_data'] = $this->db->get('exportdata')->result();


            /*-------Raw SQL-------*/

            /*---------------------*/
            // echo "<pre>"; print_r($this->db->list_fields('exportdata'));
            // echo $this->db->last_query(); die();

             // echo "<pre>"; print_r($data['offer']); die();

            $data['templates'] = $this->db->get_where('report_filter_template', array('report_filter_template_id' => $tepmlate_id))->row();

            return $data;
    }

    public function generate_offer_report($data)
    {
        $user_id = $this->session->user_id;
        $report_temp = $data['report_temp'];
        $offer = $data['offer'];
        $trader = $data['trader'];
        $resuorce_developer = $data['resuorce_developer'];
        $data = array();
        $data['template'] = $this->db
                ->select('offer_header_fields')
                ->get_where('view_templates',array('vt_id' => $report_temp))->result();

                // `status` = 1
         //$offers =  $this->get_offer_list($user_id);
         /*$data['offer_data'] = $this->db
                ->select('*')
                ->get_where('offers',array('offer_id' => $offer))->result();*/

            $sql = "SELECT
            `offers`.*,
            `assigned_templates`.`at_id`,
            `incoterms`.`incoterm`,
            `acc_master`.`name` AS `supplier_name`,
            `acc_master`.`am_code` AS `supplier_code`,
            DATE_FORMAT(offers.offer_date, '%d-%m-%Y') AS offer_date,
            `currencies`.`currency`,
            `currencies`.`code` AS `currency_code`,
            `currencies`.`symbol` AS `currency_symbol`,
            `users`.`username`,
            `firstname`,
            `lastname`,
            `source`.`country_id`,
            `source`.`iso` AS `source_country_iso`,
            `source`.`name` AS `source_country_name`,

            `destination`.`country_id`,
            `destination`.`iso` AS `destination_country_iso`,
            `destination`.`name` AS `destination_country_name`,
            `remark1_offer_validity`.`remark`
        FROM
            `offers`
        LEFT JOIN `acc_master` ON `acc_master`.`am_id` = `offers`.`am_id`
        LEFT JOIN `currencies` ON `currencies`.`c_id` = `offers`.`c_id`
        LEFT JOIN `countries` AS  `source`
        ON
            `source`.`country_id` = `offers`.`country_id`
        LEFT JOIN `countries` AS  `destination`
        ON
            `destination`.`country_id` = `offers`.`destination_c_id`
        LEFT JOIN `users` ON `users`.`user_id` = `offers`.`resource_id`
        LEFT JOIN `incoterms` ON `incoterms`.`it_id` = `offers`.`incoterm_id`
        LEFT JOIN `user_details` ON `users`.`user_id` = `user_details`.`user_id`
        LEFT JOIN `remark1_offer_validity` ON `remark1_offer_validity`.`rov_id` = `offers`.`remarks_1`
        LEFT JOIN `assigned_templates` ON `assigned_templates`.`offer_id` = `offers`.`offer_id`
        WHERE
            `offers`.`offer_id` = $offer AND `offers`.`status` = 1";

         $data['offer_data'] = $this->db->query($sql)->result();

         if ($trader == "Yes") {
            
                $treadersql = "SELECT
                `offer_details`.`od_id`,
                `quantity_offered`,
                `cartons_offered`,
                `product_price`,
                `product_name`,
                `scientific_name`,
                `f1`.`freezing_type`,
                `f2`.`freezing_type` AS `freezing_method`,
                `ptp`.`packing_type`,
                `pts`.`packing_type` AS `pts`,
                `packing_size`,
                `glazing`,
                `block_size`,
                `sizes`.`size`,
                `units`.`unit`,
                `size_before_glaze`,
                `size_after_glaze`
            FROM
                `offer_details`
            LEFT JOIN `products` ON `products`.`pr_id` = `offer_details`.`product_id`
            LEFT JOIN `freezing` `f1` ON
                `f1`.`ft_id` = `offer_details`.`freezing_id`
            LEFT JOIN `freezing` `f2` ON
                `f2`.`ft_id` = `offer_details`.`freezing_method_id`
            LEFT JOIN `packing_types` `ptp` ON
                `ptp`.`pt_id` = `offer_details`.`primary_packing_type_id`
            LEFT JOIN `packing_types` `pts` ON
                `pts`.`pt_id` = `offer_details`.`secondary_packing_type_id`
            LEFT JOIN `packing_sizes` ON `packing_sizes`.`ps_id` = `offer_details`.`packing_size_id`
            LEFT JOIN `glazing` ON `glazing`.`gl_id` = `offer_details`.`glazing_id`
            LEFT JOIN `blocks` ON `blocks`.`block_id` = `offer_details`.`block_id`
            LEFT JOIN `sizes` ON `sizes`.`size_id` = `offer_details`.`size_id`
            LEFT JOIN `units` ON `units`.`u_id` = `sizes`.`unit_id`
            WHERE `offer_id` = $offer";

            $data['trader'] = $this->db->query($treadersql)->result();
         }

         if ($resuorce_developer == "Yes") {
             $resuorcedevelopersql = "SELECT
                `offer_details_resource`.`od_id`,
                `quantity_offered`,
                `cartons_offered`,
                `product_price`,
                `product_name`,
                `scientific_name`,
                `f1`.`freezing_type`,
                `f2`.`freezing_type` AS `freezing_method`,
                `ptp`.`packing_type`,
                `pts`.`packing_type` AS `pts`,
                `packing_size`,
                `glazing`,
                `block_size`,
                `sizes`.`size`,
                `units`.`unit`,
                `size_before_glaze`,
                `size_after_glaze`
            FROM
                `offer_details_resource`
            LEFT JOIN `products` ON `products`.`pr_id` = `offer_details_resource`.`product_id`
            LEFT JOIN `freezing` `f1` ON
                `f1`.`ft_id` = `offer_details_resource`.`freezing_id`
            LEFT JOIN `freezing` `f2` ON
                `f2`.`ft_id` = `offer_details_resource`.`freezing_method_id`
            LEFT JOIN `packing_types` `ptp` ON
                `ptp`.`pt_id` = `offer_details_resource`.`primary_packing_type_id`
            LEFT JOIN `packing_types` `pts` ON
                `pts`.`pt_id` = `offer_details_resource`.`secondary_packing_type_id`
            LEFT JOIN `packing_sizes` ON `packing_sizes`.`ps_id` = `offer_details_resource`.`packing_size_id`
            LEFT JOIN `glazing` ON `glazing`.`gl_id` = `offer_details_resource`.`glazing_id`
            LEFT JOIN `blocks` ON `blocks`.`block_id` = `offer_details_resource`.`block_id`
            LEFT JOIN `sizes` ON `sizes`.`size_id` = `offer_details_resource`.`size_id`
            LEFT JOIN `units` ON `units`.`u_id` = `sizes`.`unit_id`
            WHERE `offer_id` = $offer";

            $data['resuorce_developer'] = $this->db->query($resuorcedevelopersql)->result();
         }



       

        return $data;
    }


    public function del_row_offer_details(){

        $id = $this->input->post('pk');

        $check = false;
        if($this->session->usertype == 1){
            $this->db->where('od_id', $id)->delete('offer_details');
            $check = true;
        }elseif ($this->session->usertype == 2) {
            $this->db->where('odr_id', $id)->delete('offer_details_resource');
            $check = true;
        }
        
        
        if ($check == true) {
            $data['title'] = 'Deleted!';
            $data['type'] = 'success';
            $data['msg'] = 'Offer Details Row Successfully Deleted';
        }
        return $data;
        
    }

    
    // REPORT 
    public function view_offer($offer_id,$com_id){


        if($this->session->usertype == 1 || $this->session->usertype == 3){
            
            $this->db->select('offers.*, DATE_FORMAT(offers.offer_date, "%d-%m-%Y") as offer_date,acc_master.name as supplier_name, acc_master.am_code as supplier_code, currencies.currency, currencies.symbol as currency_code, users.username, firstname, lastname, countries.iso, countries.name, incoterms.incoterm, ports.port_name,remark1_offer_validity.remark');
            $this->db->join('acc_master', 'acc_master.am_id = offers.am_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers.country_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers.c_id', 'left');
            $this->db->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left');
            $this->db->join('users', 'users.user_id = offers.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('ports', 'ports.p_id = offers.port_of_loading', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers.remarks_1', 'left');
            $data['offer'] = $this->db->get_where('offers', array('offers.offer_id' => $offer_id))->result();


            $ids = $data['offer'][0]->destination_c_id;

            if(!empty($ids)){
                $data['destination_country'] = $this->db->query("SELECT name as destination_cntr, iso as destination_iso FROM countries WHERE country_id IN ($ids)")->result_array();
            }

             $data['company_details'] = $this->db->get_where('company', array('company_id'=>$com_id, 'status' => 'Active'))->row();
            /*echo "<pre>";
            print_r($data['destination_country']);*/

            //die();

            //echo $this->db->last_query();

            //die();    
            
        }else{
            
            $this->db->select('offers_resource.*, DATE_FORMAT(offers_resource.offer_date, "%d-%m-%Y") as offer_date,acc_master.name as supplier_name, acc_master.am_code as supplier_code, currencies.currency, currencies.symbol as currency_code, users.username, firstname, lastname, countries.iso, countries.name, incoterms.incoterm, ports.port_name,remark1_offer_validity.remark');
            $this->db->join('acc_master', 'acc_master.am_id = offers_resource.am_id', 'left');
            $this->db->join('countries', 'countries.country_id = offers_resource.country_id', 'left');
            $this->db->join('currencies', 'currencies.c_id = offers_resource.c_id', 'left');
            $this->db->join('incoterms', 'incoterms.it_id = offers_resource.incoterm_id', 'left');
            $this->db->join('users', 'users.user_id = offers_resource.resource_id', 'left');
            $this->db->join('user_details', 'users.user_id = user_details.user_id', 'left');
            $this->db->join('ports', 'ports.p_id = offers_resource.port_of_loading', 'left');
            $this->db->join('remark1_offer_validity', 'remark1_offer_validity.rov_id = offers_resource.remarks_1', 'left');
            $data['offer'] = $this->db->get_where('offers_resource', array('offers_resource.offer_id' => $offer_id))->result();

            $ids = $data['offer'][0]->destination_c_id;

            if(!empty($ids)){
                $data['destination_country'] = $this->db->query("SELECT name as destination_cntr, iso as destination_iso FROM countries WHERE country_id IN ($ids)")->result_array();
            }

            $data['company_details'] = $this->db->get_where('company', array('company_id'=>$com_id, 'status' => 'Active'))->row();

          
        }


        if($this->session->usertype == 1 || $this->session->usertype == 3){
            
            $this->db->select('offer_details.*, offer_details.od_id,quantity_offered, cartons_offered, product_price, product_name, scientific_name, f1.freezing_type,f2.freezing_type as freezing_method, ptp.packing_type, pts.packing_type as pts, packing_size, glazing, block_size,sizes.size,units.unit, size_before_glaze, size_after_glaze');
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
            
            $this->db->select('offer_details_resource.*, offer_details_resource.od_id,quantity_offered, cartons_offered, product_price, product_name, scientific_name, f1.freezing_type,f2.freezing_type as freezing_method, ptp.packing_type, pts.packing_type as pts, packing_size, glazing, block_size,sizes.size,units.unit, size_before_glaze, size_after_glaze');
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
            
        }
        


        $this->db->select('selling_price.*,incoterms.incoterm,currencies.currency, currencies.symbol,
            lis.line_item_name as lin,lis2.line_item_name as lin2,
            lis3.line_item_name as lin3, lis4.line_item_name as lin4,  
            other_price, other_price2, other_price3, other_price4,
            other_price_comment, other_price_comment2, other_price_comment3, other_price_comment4');

        $this->db->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left');
        $this->db->join('incoterms', 'incoterms.it_id = selling_price.selling_incoterm_id', 'left');
        $this->db->join('line_items lis', 'lis.li_id = selling_price.li_id', 'left');
        $this->db->join('line_items lis2', 'lis2.li_id = selling_price.li_id2', 'left');
        $this->db->join('line_items lis3', 'lis3.li_id = selling_price.li_id3', 'left');
        $this->db->join('line_items lis4', 'lis4.li_id = selling_price.li_id4', 'left');

        $data['selling_price'] = $this->db
            ->select('offer_details.*,products.product_name, sell_price_details.spd_id, sell_price_details.exchange_rate, countries.iso, countries.name,acc_master.am_id, acc_master.name as customer_name, acc_master.am_code as customer_code')
            ->join('products','products.pr_id=offer_details.product_id','left')
            ->join('sell_price_details','sell_price_details.od_id=offer_details.od_id','left')
            ->join('currencies', 'currencies.c_id = sell_price_details.currency_id', 'left')
            ->join('countries', 'countries.country_id = sell_price_details.country_id', 'left')
            ->join('acc_master', 'acc_master.am_id = sell_price_details.am_id', 'left')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))
            ->result();


            //echo $this->db->last_query();

        $data['country_based_customers'] = $this->db
            ->select('countries.iso, countries.name,acc_master.am_id, acc_master.name as customer_name, acc_master.am_code as customer_code')
            ->join('countries','countries.country_id = acc_master.country_id', 'left')
            ->get_where('acc_master', array('acc_master.status' => 1))->result();
 
        $data['templates'] = $this->db
            ->select('offer_header_fields,offer_details_fields,selling_prices_fields')
            ->join('assigned_templates','assigned_templates.vt_id = view_templates.vt_id','left')
            ->get_where('view_templates',array('assigned_templates.offer_id' => $offer_id))->result();

        if(count($data['templates']) == 0 || $this->session->usertype == 4){
            $data['templates'] = $this->db
                ->select('offer_header_fields,offer_details_fields,selling_prices_fields')
                ->get_where('view_templates',array('vt_category' => 'DRT'))->result();
        }

        // echo count($data['templates']) . '<hr>' . '<pre>',print_r($data),'</pre>';

        return $data;
    }

    public function upgrade_selling_rate($updateArray, $sp_id){
        
        if($this->db->update('selling_price', $updateArray, array('sp_id' => $sp_id))){

            return true;

        }else{
            return false;
        }

    }

    public function final_mail_status($insertArray)
    {
        $this->db->insert('final_mail_send', $insertArray);
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
            
            $link = base_url('admin/view-offer') .'/' . $val->offer_id . '/1';

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
            $rs = $this->db->get_where('offers', array('offers.status' => 1, 'marketing_edit_status' => 1, 'final_marketing_approval_status'=> 1 ))->result();

        return $rs;
        // echo $this->db->get_compiled_select('offer');
        // exit();
    }


    public function update_final_marketing_approval_status($offer){
        
        // update offer status details

        // 0=not send 1= send
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

        $fmas_return = $this->db->get_where('offers', array('offer_id' => $offer))->result()[0]->final_marketing_approval_status;
        //$this->db->update('offers_resource', $updateArray, array('offer_id' => $offer));
        $data = array();
        if($fmas_return == 0){
          $data['type'] = 'success';
          $data['msg'] = 'Offer permission revoke from marketing';
          $data['approval_status'] =  $fmas_return;          
        }

        if($fmas_return == 1){
          $data['type'] = 'success';
          $data['msg'] = 'Offer sent to marketing personnel';   
          $data['approval_status'] =  $fmas_return;         
        }



        return $data;

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
        if($this->email->send()){
           return true; 
       }else{
            return false;
       }

        

    }

// Offer ENDS 

}
