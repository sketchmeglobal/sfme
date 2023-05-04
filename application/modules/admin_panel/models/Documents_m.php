<?php
class documents_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function my_documents($parentFolderId) {
        $data['title'] = 'My Documents';
        $data['menu'] = 'Documents';
        $created_by = $_SESSION['user_id'];
        $documents = $this->db->select('document_id, created_by, documents')->get_where('document_master', array('created_by' => $created_by))->result();
        $data['documents'] = $documents;
        $data['parentFolderId'] = $parentFolderId;
        
        if(sizeof($documents) > 0){
            $document_id = $documents[0]->document_id;
            $documents1 = $documents[0]->documents;
            $documents = json_decode($documents1);
            $folders = $documents->folders;
        
            $files = $documents->files;
            }else{
                $folders = array();
                $files = array();
            }
        
            if(sizeof($folders) > 0){
                if($parentFolderId > 0){
                    $breadCumName = array();
                    $breadCumNameNew = array();
                    $temp_parentFolderId = $parentFolderId;
                    
                    do{
                        for($i = 0; $i , sizeof($folders); $i++){
                            if($folders[$i]->fold_id == $temp_parentFolderId){
                                $folderObj = new stdClass();
                                $folderObj->folderName = $folders[$i]->folderName;
                                $folderObj->fold_id = $folders[$i]->fold_id;
                                array_push($breadCumName, $folderObj);

                                $temp_parentFolderId = $folders[$i]->parentFolderId;
                                break;
                            }
                        }
                    }while($temp_parentFolderId != 0);
                    $breadCumNameNew =  array_reverse($breadCumName);

                    $breadcum_ul_li = '';
                    for($j = 0; $j < sizeof($breadCumNameNew); $j++){
                        $breadcum_ul_li .= "<li><a href='".base_url().'admin/my-documents/'.$breadCumNameNew[$j]->fold_id."'>".$breadCumNameNew[$j]->folderName."</a></li>";
                    }//end for
                    $data['breadcum_ul_li'] = $breadcum_ul_li;
                }//enif
            }//end if

        return array('page' => 'documents/document_list_v', 'data'=>$data);
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

    public function add_document($parentFolderId){  
        $data['title'] = 'Document Management';
        $data['menu'] = 'Add Document';  
        $data['parentFolderId'] = $parentFolderId;      
        return array('page'=>'documents/document_add_v', 'data'=>$data);
    }

    public function ajax_unique_foldername(){        
        $folderName = $this->input->post('folderName');
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

    public function form_add_document(){  
        $daya = array();
        $status = true;

        $folderName = $this->input->post('folderName');
        $parentFolderId = $this->input->post('parentFolderId');
        $created_by = $_SESSION['user_id'];
        $fold_id = rand(1000, 9999);

        //check existing data
        $result = $this->db->select('document_id, created_by, documents')->get_where('document_master', array('created_by' => $created_by))->result();

        if(count($result) > 0){
            //print_r($result);
            $update_id = $result[0]->document_id;
            $documents1 = $result[0]->documents;
            $documents = json_decode($documents1);            
            $folders = $documents->folders;
            $files = $documents->files;

            if($folderName != ''){
                $folder = new stdClass();
                $folder->fold_id = $fold_id;
                $folder->folderName = $folderName;
                $folder->parentFolderId = $parentFolderId;
                array_push($folders, $folder);
            }           
            $documents->folders = $folders;
        }else{
            $documents = new stdClass();
            $folders = array();
            $files = array();

            if($folderName != ''){
                $folder = new stdClass();
                $folder->fold_id = $fold_id;
                $folder->folderName = $folderName;
                $folder->parentFolderId = $parentFolderId;
                array_push($folders, $folder);
            }
            
            $documents->folders = $folders;
            $documents->files = $files;

            $insertArray = array(
                'created_by' => $created_by,
                'documents' => json_encode($documents)
            );
            
            if($this->db->insert('document_master', $insertArray)){
                $update_id = $this->db->insert_id();            
            }//end if

        }//end if

        //echo 'count: '. count($result);
        //die;
        
        if($update_id > 0){
            if (!empty($_FILES['userfile']['name'][0])) {
                $return_data = array(); 

                $upload_path = './upload/documents/' ; 
                $file_type = 'jpg|jpeg|png|bmp|mp4|csv|pdf|docx|txt|zip|xlsx';
                $user_file_name = 'userfile';

                $return_data = $this->_upload_files($_FILES['userfile'], $upload_path, $file_type, $user_file_name);

                //echo json_encode($return_data);die;
                // print_r($return_data);die;

                foreach ($return_data as $datam) {
                    if ($datam['status'] != 'error') { 
                        $file_id = rand(1000, 9999);
                        $file = new stdClass();
                        $file->parentFolderId = $parentFolderId;
                        $file->file_id = $file_id;
                        $file->file_name = $datam['filename'];
                        $file->file_type = $datam['meta_data']['file_type'];
                        $file->meta_data = $datam['meta_data'];
                        
                        array_push($files, $file);
                    }//end if
                }//end foreach 
                $documents->files = $files;
            }//end file upload
                
            $updateArray = array(
                'documents' => json_encode($documents)
            );

            $val = $this->db->update('document_master', $updateArray, array('document_id' => $update_id));
            $data['file_updated'] = $val;
        }//end 

        
        $data['update_id'] = $update_id;
        $data['documents'] = $documents;
        $data['parentFolderId'] = $parentFolderId;
        $data['type'] = 'success';
        $data['msg'] = 'Document Saved Properly';
        $data['title'] = 'Add Document';
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
        $filesCount = count($_FILES[$user_file_name]['name']); 
        for($i = 0; $i < $filesCount; $i++){ 
            $_FILES['file']['name']       = $_FILES[$user_file_name]['name'][$i];
            $_FILES['file']['type']       = $_FILES[$user_file_name]['type'][$i];
            $_FILES['file']['tmp_name']   = $_FILES[$user_file_name]['tmp_name'][$i];
            $_FILES['file']['error']      = $_FILES[$user_file_name]['error'][$i];
            $_FILES['file']['size']       = $_FILES[$user_file_name]['size'][$i];

            // $config['file_name'] = date('His') .'_'. $image;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('file')) {                
                $imageData = $this->upload->data();
                //echo json_encode($imageData);
                $new_array[] = array(
                    'filename' => $imageData['file_name'], 
                    'meta_data' => $imageData, 
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
        }//end for

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