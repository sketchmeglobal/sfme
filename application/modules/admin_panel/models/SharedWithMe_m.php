<?php
class sharedwithme_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function shared_with_me($parentFolderId) {
        $data['title'] = 'My Documents';
        $data['menu'] = 'Documents';
        $created_by = $this->session->user_id;
        $documents = $this->db->select('document_id, created_by, shared_with_me')->get_where('document_master', array('created_by' => $created_by))->result();
        $data['documents'] = $documents;
        $data['parentFolderId'] = $parentFolderId;
        
        if(sizeof($documents) > 0){
            $document_id = $documents[0]->document_id;
            if($documents[0]->shared_with_me != ''){
                $documents1 = $documents[0]->shared_with_me;
                $documents = json_decode($documents1);
                $folders = $documents->folders;
            
                $files = $documents->files;
            }else{
                $folders = array();
                $files = array();
            }
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
                    $breadcum_ul_li .= "<li><a href='".base_url().'admin/shared-with-me/'.$breadCumNameNew[$j]->fold_id."'>".$breadCumNameNew[$j]->folderName."</a></li>";
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
            
        }
        
        return array('page' => 'sharedwithme/document_list_v', 'data'=>$data);
    }
    
    

}