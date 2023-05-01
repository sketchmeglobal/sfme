<?php
class user_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function user_management() {
        $data['title'] = 'User Management';
        $data['menu'] = 'Users';
        return array('page'=>'user/user_list_v', 'data'=>$data);
    }

    public function ajax_user_table_data() {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;

        //actual db table column names
        $column_orderable = array(
            0 => 'users.usertype',
            1 => 'user_details.firstname'
        );
        // Set searchable column fields
        $column_search = array('usertype','firstname');
        // $column_search = array('co_no');

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $rs = $this->_user_common_query($usertype, $user_id);

        $totalData = count($rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $rs = $this->_user_common_query($usertype, $user_id);
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
                if(count($column_search) - 1 == $i){
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }
            $this->db->stop_cache();

            $rs = $this->_user_common_query($usertype, $user_id);

            $totalFiltered = count($rs);

            $rs = $this->_user_common_query($usertype, $user_id);

            $this->db->flush_cache();
        }

        $data = array();

        foreach ($rs as $val) {

            if($val->usertype == 1){ 
                $type = "Trader" ;
            }elseif($val->usertype == 2){
                $type = "Resource Developer";
            }elseif($val->usertype == 3){
                $type = "Marketing";
            }else{
                $type = "Exporter";
            }

            $nestedData['usertype'] = $type;
            $nestedData['name'] = $val->name;
            $nestedData['username'] = $val->username;
            $nestedData['action'] = $this->_user_common_actions($val->usertype, $val->user_id);

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


    private function _user_common_query($usertype, $user_id){

        if($usertype == 1){

            #for admin

            $rs = $this->db
                ->select('users.*, CONCAT(firstname, " ", lastname) AS name')
                ->join('user_details', 'users.user_id = user_details.user_id', 'left')
                ->get('users')
                ->result();            
            
            // echo $this->db->get_compiled_select('users');
            // exit();
        }

        return $rs;
        
    }

    private function _user_common_actions($usertype, $user_id){

        if($usertype == 1){
            # resource is still working
            $nestedData = '
            <a href="'. base_url('admin/edit-user/'.$user_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>';
        }else{
            $nestedData = '
            <a href="'. base_url('admin/edit-user/'.$user_id) .'" class="btn btn-info"><i class="fa fa-pencil"></i> Edit</a>
            <a data-user_id="'.$user_id.'" href="javascript:void(0)" class="btn btn-danger delete"><i class="fa fa-times"></i> Delete</a>';
        }
        return $nestedData;

    }

    public function add_user(){
        
        $data['title'] = 'User Management';
        $data['menu'] = 'Add Users';

        return array('page'=>'user/user_add_v', 'data'=>$data);

    }

    public function ajax_unique_username(){
        
        $username = $this->input->post('username');
        $rs = $this->db->get_where('users', array('username' => $username))->num_rows();
        // echo $this->db->last_query();die;
        
        if($rs != '0') {
            $data = 'Username already exists.';
        }else{
            $data='true';
        }

        return $data;

    }

    public function acc_master_on_usertype(){
        
        $usertype = $this->input->post('usertype');

        if($usertype == 1){
            # admin - all

            $rs = $this->db->get_where('acc_master', array('status' => 1))->result();

        }else if($usertype == 2){
            
            # resource develper -> Supplier
            $rs = $this->db->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 0))->result();

        }else if($usertype == 3){
            
            # marketing -> Buyer
            $rs = $this->db->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 1))->result();

        }if($usertype == 4){
            
            # exporter -> Offers
            $rs = $this->db->get_where('offers', array('status' => 1))->result();
            
        }

        return $rs;

    }

    public function form_add_user(){
        
        if( $this->input->post('user_type') == 4){
            
            if(count($this->input->post('offer_values[]')) > 0){
                $accn = join(',',$this->input->post('offer_values[]'));
            }else{
                $accn = NULL;
            }
         
            $insertArray = array(
                'usertype' => $this->input->post('user_type'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'pass' => hash('sha256', $this->input->post('pass')),
                'acc_masters' => NULL,
                'offer_ids' => $accn,
                'verified' => 1
            );
            
        }else{
            
             if(count($this->input->post('acc_masters[]')) > 0){
                $accn = join(',',$this->input->post('acc_masters[]'));
            }else{
                $accn = NULL;
            }
            
            $insertArray = array(
                'usertype' => $this->input->post('user_type'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'pass' => hash('sha256', $this->input->post('pass')),
                'acc_masters' => $accn,
                'offer_ids' => NULL,
                'verified' => 1
            );
            
        }
        

        

        if($this->db->insert('users', $insertArray)){

            $data['insert_id'] = $this->db->insert_id();

            // image upload
            if (!empty($_FILES['userfile']['name'][0])) {

                $return_data = array(); 

                $upload_path = './upload/users/' ; 
                $file_type = 'jpg|jpeg|png|bmp';
                $user_file_name = 'userfile';

                $return_data = $this->_upload_files($_FILES['userfile'], $upload_path, $file_type, $user_file_name);

                // print_r($return_data);die;

                foreach ($return_data as $datam) {

                    if ($datam['status'] != 'error') {
                        
                        // Insert filename to db
                        
                        $insertArray1 = array(
                            'user_id' => $data['insert_id'],
                            'firstname' => $this->input->post('firstname'),
                            'lastname' => $this->input->post('lastname'),
                            'contact' => $this->input->post('contact'),
                            'img' => $datam['filename']
                        );

                        $this->db->insert('user_details', $insertArray1);
                    }
                }

                $data['type'] = 'success';
                $data['msg'] = 'Image Files Uploaded<hr>User added successfully.'; 

            }else{

                $insertArray1 = array(
                    'user_id' => $data['insert_id'],
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'contact' => $this->input->post('contact')
                );

                $this->db->insert('user_details', $insertArray1);

                $data['type'] = 'success';
                $data['msg'] = 'No Files Uploaded<hr>User added successfully.'; 
            }          

        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Database Insert Error';
        }

        return $data;

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

    public function edit_user($user_id=''){
        
        $data['title'] = 'User Management';
        $data['menu'] = 'Users';

        $data['user_details'] = $this->db
            ->join('user_details', 'user_details.user_id=users.user_id', 'left')
            ->get_where('users', array('users.user_id' => $user_id))->result();

        // echo '<pre>',print_r($data), '</pre>'; die;   

        if($data['user_details'][0]->usertype == 1){ #admin

            $data['acc_masters'] =  $this->db
            ->get_where('acc_master',array('acc_master.status' => 1))->result();

        }else if($data['user_details'][0]->usertype == 2){ #Resource D   
    
            $data['acc_masters'] =  $this->db
            ->get_where('acc_master',array('acc_master.status' => 1, 'supplier_buyer' => 0))->result();

        }else if($data['user_details'][0]->usertype == 3){ #Mark

            $data['acc_masters'] =  $this->db
            ->get_where('acc_master',array('acc_master.status' => 1, 'supplier_buyer' => 1))->result();

        } if($data['user_details'][0]->usertype == 4){
            
            $data['acc_masters'] =  $this->db
            ->get_where('offers',array('offers.status' => 1))->result();
            
        }
        

        // echo $this->db->last_query(); die;

        return array('page'=>'user/user_edit_v', 'data'=>$data);

    }

    public function ajax_unique_username_edit(){
        
        $username = $this->input->post('username');
        $user_id = $this->input->post('user_id');

        $rs = $this->db->where('user_id !=', $user_id)->get_where('users', array('username' => $username))->num_rows();

        
        if($rs != '0') {
            $data = 'Username already exists.';
        }else{
            $data='true';
        }

        return $data;

    }

    public function form_edit_user(){
        
        
        
        if( $this->input->post('user_type') == 4){
            
            if(count($this->input->post('offer_values[]')) > 0){
                $accn = join(',',$this->input->post('offer_values[]'));
            }else{
                $accn = NULL;
            }
         
            $user_id = $this->input->post('user_id');
    
            if($this->input->post('pass') == ''){
    
                $updateArray = array(
                    'usertype' => $this->input->post('user_type'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'acc_masters' => NULL,
                    'offer_ids' => $accn,
                    'blocked' => $this->input->post('blocked')
                );
    
            }else{
    
                $updateArray = array(
                    'usertype' => $this->input->post('user_type'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                     'acc_masters' => NULL,
                    'offer_ids' => $accn,
                    'pass' => hash('sha256', $this->input->post('pass')),
                    'blocked' => $this->input->post('blocked')
                );
    
            }

            
        }else{
            
             if(count($this->input->post('acc_masters[]')) > 0){
                $accn = join(',',$this->input->post('acc_masters[]'));
            }else{
                $accn = NULL;
            }
            
            $user_id = $this->input->post('user_id');

            if($this->input->post('pass') == ''){
    
                $updateArray = array(
                    'usertype' => $this->input->post('user_type'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'acc_masters' => $accn,
                    'offer_ids' => NULL,
                    'blocked' => $this->input->post('blocked')
                );
    
            }else{
    
                $updateArray = array(
                    'usertype' => $this->input->post('user_type'),
                    'username' => $this->input->post('username'),
                    'email' => $this->input->post('email'),
                    'acc_masters' => $accn,
                    'offer_ids' => NULL,
                    'pass' => hash('sha256', $this->input->post('pass')),
                    'blocked' => $this->input->post('blocked')
                );
    
            }

            
        }
        
        
        
        $val = $this->db->update('users', $updateArray, array('user_id' => $user_id));

         if($val){

            // image upload
            if (!empty($_FILES['userfile']['name'][0])) {

                $return_data = array(); 

                $upload_path = './upload/users/' ; 
                $file_type = 'jpg|jpeg|png|bmp';
                $user_file_name = 'userfile';

                $return_data = $this->_upload_files($_FILES['userfile'], $upload_path, $file_type, $user_file_name);

                // print_r($return_data);die;

                foreach ($return_data as $datam) {

                    if ($datam['status'] != 'error') {
                        
                        // Insert filename to db
                        
                        $updateArray1 = array(
                            'user_id' => $user_id,
                            'firstname' => $this->input->post('firstname'),
                            'lastname' => $this->input->post('lastname'),
                            'contact' => $this->input->post('contact'),
                            'img' => $datam['filename']
                        );

                        $this->db->update('user_details', $updateArray1, array('user_id' => $user_id));
                        //echo $this->db->last_query();die;
                    }
                }

                $data['type'] = 'success';
                $data['msg'] = 'Image Files Uploaded<hr>User edited successfully.'; 

            }else{

                        $updateArray1 = array(
                            'user_id' => $user_id,
                            'firstname' => $this->input->post('firstname'),
                            'lastname' => $this->input->post('lastname'),
                            'contact' => $this->input->post('contact')
                        );

                        $this->db->update('user_details', $updateArray1, array('user_id' => $user_id));
                        //echo $this->db->last_query();die;
                        
                $data['type'] = 'success';
                $data['msg'] = 'No Files Uploaded<hr>User edited successfully.'; 
            }          

        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Database Update Error';
        }

        return $data;

    }

    public function ajax_delete_user(){

        $user_id = $this->input->post('user_id');
        $delClause = array(
            'user_id' => $user_id
        );

        $this->db->where($delClause)->delete('user_details');
        $this->db->where($delClause)->delete('users');

        $data['type'] = 'success';
        $data['title'] = 'Deletion!';
        $data['msg'] = 'User deleted successfully'; 

        return $data;
        
    }

    

// User ENDS 

}