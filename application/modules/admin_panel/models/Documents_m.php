<?php
class documents_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function my_documents($parentFolderId) {
        $data['title'] = 'My Documents';
        $data['menu'] = 'Documents';
        $created_by = $this->session->user_id;
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

        

        //get all users list
        $user_id = $this->session->user_id;
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
            
        } if($data['user_details'][0]->usertype == 5){            
            $data['acc_masters'] =  $this->db
            ->get_where('offers',array('offers.status' => 1))->result();            
        }
        
        return array('page' => 'documents/document_list_v', 'data'=>$data);
    }
    

    public function add_document($parentFolderId){  
        $data['title'] = 'Document Management';
        $data['menu'] = 'Add Document';  
        $data['parentFolderId'] = $parentFolderId;      
        return array('page'=>'documents/document_add_v', 'data'=>$data);
    }
    

    public function form_add_document(){  
        $daya = array();
        $status = true;

        $folderName = $this->input->post('folderName');
        $parentFolderId = $this->input->post('parentFolderId');
        $created_by = $this->session->user_id;
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

    public function ajax_delete_document(){
        $fold_id = $this->input->post('fold_id');
        $file_id = $this->input->post('file_id');
        $parentFolderId = $this->input->post('parentFolderId');
        $created_by = $this->session->user_id;

        $result = $this->db->select('document_id, created_by, documents')->get_where('document_master', array('created_by' => $created_by))->result();

        if(count($result) > 0){
            $update_id = $result[0]->document_id;
            $documents1 = $result[0]->documents;
            $documents = json_decode($documents1);            
            $folders = $documents->folders;
            $files = $documents->files;

            if($fold_id > 0){
                $fold_ids = array();
                array_push($fold_ids, $fold_id);
                $continue = false;

                do{
                    if(sizeof($fold_ids) > 0){
                        $found = false;
                        for($j = 0; $j < sizeof($fold_ids); $j++){
                            for($k = 0; $k < sizeof($folders); $k++){
                                $duplicate = false;

                                if($fold_ids[$j] == $folders[$k]->parentFolderId){
                                    if(in_array($folders[$k]->fold_id, $fold_ids)){
                                        //echo "Exist";
                                    }else{
                                        //echo "Not Exist";
                                        array_push($fold_ids, $folders[$k]->fold_id);
                                    }
                                }//end if
                            }//end inner for
                        }//end for

                        if($j == sizeof($fold_ids)){
                            $continue = false;  
                        }
                    }//end if
                }while($continue == true);
                
                $temp_folders = array();
                $temp_files = array();                

                //Unlink Folders
                for($y = 0; $y < sizeof($folders); $y++){                     
                    if(in_array($folders[$y]->fold_id, $fold_ids)){
                    }else{
                        array_push($temp_folders, $folders[$y]);
                    }
                }//end for

                //Unlink Files
                for($z = 0; $z < sizeof($files); $z++){
                    if(in_array($files[$z]->parentFolderId, $fold_ids)){
                        $path = 'upload/documents/' . $files[$z]->file_name;
                        if (file_exists($path)){
                            unlink($path);
                        }
                    }else{
                        array_push($temp_files, $files[$z]);
                    }//end if
                } //end for

                $documents->folders = $temp_folders;  
                $documents->files = $temp_files;
                $data['fold_ids'] = $fold_ids;
                $data['temp_folders'] = $temp_folders;
            }//end if

            if($file_id > 0){
                $temp_files = array();
                if(sizeof($files) > 0){
                    for($j = 0; $j < sizeof($files); $j++){
                        if($files[$j]->file_id == $file_id){
                            $path = 'upload/documents/' . $files[$j]->file_name;
                            if (file_exists($path)){
                                unlink($path);
                            }
                        }//end if

                        if($files[$j]->file_id != $file_id){
                            array_push($temp_files, $files[$j]);
                        }//end if
                    }//end for                    
                }//end if   
                $documents->files = $temp_files;   
            }//end if file
        }//end if result
        
        $updateArray = array(
            'documents' => json_encode($documents)
        );

        $val = $this->db->update('document_master', $updateArray, array('document_id' => $update_id));
        $data['file_updated'] = $val;

        $data['type'] = 'success';
        $data['title'] = 'Deletion!';
        $data['msg'] = 'Document deleted successfully'; 
        $data['parentFolderId'] = $parentFolderId;

        return $data;
        
    }//end fun

    

    public function ajax_edit_document(){
        $fold_id = $this->input->post('fold_id');
        $folderNameEdit = $this->input->post('folderNameEdit');
        $created_by = $this->session->user_id;

        $result = $this->db->select('document_id, created_by, documents')->get_where('document_master', array('created_by' => $created_by))->result();

        if(count($result) > 0){
            $update_id = $result[0]->document_id;
            $documents1 = $result[0]->documents;
            $documents = json_decode($documents1);            
            $folders = $documents->folders;

            for($i = 0; $i < sizeof($folders); $i++){
                if($folders[$i]->fold_id == $fold_id){
                    $folders[$i]->folderName = $folderNameEdit;
                }//end if
            }//end for
            $documents->folders = $folders; 
        }

        $updateArray = array(
            'documents' => json_encode($documents)
        );

        $val = $this->db->update('document_master', $updateArray, array('created_by' => $created_by));
        $data['file_updated'] = $val;

        $data['type'] = 'success';
        $data['title'] = 'Updated!';
        $data['msg'] = 'Document Name Updated Successfully'; 

        return $data;

    }//end fun

    public function ajax_share_document(){
        $dataSharedWith = $this->input->post('dataSharedWith');
        $rootFolderId = $this->input->post('rootFolderId');
        $fold_id = $this->input->post('rootFolderId');
        $created_by = $this->session->user_id;

        //print_r($dataSharedWith);

        $result = $this->db->select('document_id, created_by, documents')->get_where('document_master', array('created_by' => $created_by))->result();

        if(count($result) > 0){
            $update_id = $result[0]->document_id;
            $documents1 = $result[0]->documents;
            $documents = json_decode($documents1);            
            $folders = $documents->folders;
            $files = $documents->files;

            if($rootFolderId > 0){
                $fold_ids = array();
                array_push($fold_ids, $rootFolderId);
                $continue = false;

                do{
                    if(sizeof($fold_ids) > 0){
                        $found = false;
                        for($j = 0; $j < sizeof($fold_ids); $j++){
                            for($k = 0; $k < sizeof($folders); $k++){
                                $duplicate = false;

                                if($fold_ids[$j] == $folders[$k]->parentFolderId){
                                    if(in_array($folders[$k]->fold_id, $fold_ids)){
                                        //echo "Exist";
                                    }else{
                                        //echo "Not Exist";
                                        array_push($fold_ids, $folders[$k]->fold_id);
                                    }
                                }//end if
                            }//end inner for
                        }//end for

                        if($j == sizeof($fold_ids)){
                            $continue = false;  
                        }
                    }//end if
                }while($continue == true);
                
                $temp_folders = array();
                $temp_files = array();                

                //Share Folders
                for($y = 0; $y < sizeof($folders); $y++){                     
                    if(in_array($folders[$y]->fold_id, $fold_ids)){
                        array_push($temp_folders, $folders[$y]);
                    }else{
                    }
                }//end for

                //Share Files
                for($z = 0; $z < sizeof($files); $z++){
                    if(in_array($files[$z]->parentFolderId, $fold_ids)){
                        $path = 'upload/documents/' . $files[$z]->file_name;
                        if (file_exists($path)){
                            array_push($temp_files, $files[$z]);
                            //unlink($path);
                        }
                    }else{
                    }//end if
                } //end for
            }//end if
            //Fetch Old shared files of each individual users, call a function from here inside a loop

            //starting from the root folder id delete all the old child folders and files

            //Then update with new folders starting from the root folder
            for($i = 0; $i < sizeof($dataSharedWith); $i++){
                //echo $dataSharedWith[$i]['value'].' '.$dataSharedWith[$i]['text'];
                $share_with = $dataSharedWith[$i]['value'];
                $result_new = $this->db->select('document_id, created_by, shared_with_me')->get_where('document_master', array('created_by' => $share_with))->result();

                if(count($result_new) > 0){
                    if(count($result_new) > 0){
                        $update_id = $result_new[0]->document_id;
                        $documents1 = $result_new[0]->shared_with_me;
                        $documents_existing = json_decode($documents1);            
                        $existing_folders = $documents_existing->folders;
                        $existing_files = $documents_existing->files;

                        $existing_temp_folders = array();
                        $existing_temp_files = array();                

                        //Existing Folders
                        for($p = 0; $p < sizeof($existing_folders); $p++){                     
                            if(in_array($existing_folders[$p]->fold_id, $fold_ids)){
                            }else{
                                array_push($existing_temp_folders, $folders[$p]);
                            }
                        }//end for

                        //Existing Files
                        for($q = 0; $q < sizeof($existing_files); $q++){
                            if(in_array($existing_files[$q]->parentFolderId, $fold_ids)){
                            }else{
                                $path = 'upload/documents/' . $existing_files[$q]->file_name;
                                if (file_exists($path)){
                                    array_push($existing_temp_files, $files[$z]);
                                    //unlink($path);
                                }
                            }//end if
                        } //end for
                        
                        $data['existing_temp_folders'] = $existing_temp_folders;
                        $data['existing_temp_files'] = $existing_temp_files;

                        if(sizeof($existing_temp_folders) > 0){
                            for($r = 0; $r < sizeof($existing_temp_folders); $r++){
                                array_push($temp_folders, $existing_temp_folders[$r]);
                            }//end for
                        }//end if

                        if( sizeof($existing_temp_files) > 0){
                            for($s = 0; $s < sizeof($existing_temp_files); $s++){
                                $path = 'upload/documents/' . $existing_temp_files[$s]->file_name;
                                if (file_exists($path)){
                                    array_push($temp_files, $existing_temp_files[$s]);
                                    //unlink($path);
                                }
                            }//end for
                        }//end for
                    }//end if

                    $documents->folders = $temp_folders;  
                    $documents->files = $temp_files;
                    $data['fold_ids'] = $fold_ids;
                    $data['temp_folders'] = $temp_folders;
                    $data['temp_files'] = $temp_files;

                    //write update query
                    $updateArray = array(
                        'shared_with_me' => json_encode($documents)
                    );
                    $val = $this->db->update('document_master', $updateArray, array('created_by' => $share_with));
                }else{
                    $documents->folders = $temp_folders;  
                    $documents->files = $temp_files;
                    $data['fold_ids'] = $fold_ids;
                    $data['temp_folders'] = $temp_folders;
                    $data['temp_files'] = $temp_files;

                    //write insert query
                    $insertArray = array(
                        'created_by' => $share_with,
                        'shared_with_me' => json_encode($documents)
                    );
                    
                    $val = $this->db->insert('document_master', $insertArray);
                }//end if

            }//end for

            
        }//end if result
        
        // $updateArray = array(
        //     'documents' => json_encode($documents)
        // );
        //$val = $this->db->update('document_master', $updateArray, array('document_id' => $update_id));
        //$data['file_updated'] = $val;

        $data['type'] = 'success';
        $data['title'] = 'Shared!';
        $data['msg'] = 'Document Shared Successfully'; 
        $data['rootFolderId'] = $rootFolderId;

        return $data;
        
    }//end fun

    

// User ENDS 

}