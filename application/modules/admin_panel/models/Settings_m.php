<?php

class Settings_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function database_backup_m() {

        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->dbutil();

        $prefs = array('format' => 'zip', 'filename' => 'Database-backup_' . date('Y-m-d_H-i'));
        $backup = $this->dbutil->backup($prefs);

        if (!write_file('./assets/admin_panel/backup/BD-backup_' . date('Y-m-d_H-i') . '.zip', $backup)) {
        echo "Error while creating auto database backup!";
        }
        else {
            //file path
                    $file = './assets/admin_panel/backup/BD-backup_' . date('Y-m-d_H-i') . '.zip';
                    //download file from directory
                    force_download($file, NULL);
        }

    }

    public function view_templates(){
        
        $data['insert'] = '';

        if($this->input->post()){
            $this->_add_view_templates();
            $data['insert'] = "Data inserted successfully";
        }

        $user_id = $this->session->user_id;
        $data['user_type'] = $this->session->usertype;
        $data['users'] = $this->db
                ->join('user_details','users.user_id = user_details.user_id','left')
                ->get('users')->result();
                
        // $data['existing_templates'] = $this->db->get_where('view_templates', array('status' => 1))->result();
        $query = "SELECT
                *, t1.user_id, GROUP_CONCAT(t2.firstname, ' ', t2.lastname) AS name
            FROM
                `view_templates` AS t1
            LEFT JOIN user_details AS t2
            ON
                FIND_IN_SET(t2.user_id, t1.user_id) > 0
            GROUP BY t1.vt_id";
        
        $data['existing_templates'] = $this->db->query($query)->result();

        // echo '<pre>', print_r($data),'</pre>';
                        
        $data['title'] = 'Template Settings';
        $data['menu'] = 'view profile';
        

        return array('page'=>'settings/view_templates_v', 'data'=>$data);

    }


    public function view_report_filter_templates(){

        $data['insert'] = '';

        if($this->input->post()){
        $user_id = $this->session->user_id;
        $data['user_type'] = $this->session->usertype;

        $insertArray = array(
 
            'template_name' => $this->input->post('template_name'),
            'offer_header' => join(',',$this->input->post('offer_header[]')),
            'offer_details' => join(',',$this->input->post('offer_details[]')),
            'export_header' => join(',',$this->input->post('export_header[]'))
        );

        // echo "<pre>"; print_r($insertArray); die();

        if($this->db->insert('report_filter_template', $insertArray)){
            // echo $this->db->last_query();die;
            $data['insert'] = "Data inserted successfully";
            return redirect(base_url('admin/view_report_filter_templates'));
        }
            
        }

        $user_id = $this->session->user_id;
        $data['user_type'] = $this->session->usertype;
        $data['report_header'] = $this->db->list_fields('exportdata');
        $data['existing_templates'] = $this->db->get('report_filter_template')->result();
                        
        $data['title'] = 'Template Settings1';
        $data['menu'] = 'view profile';


        

        return array('page'=>'settings/view_report_filter_templates', 'data'=>$data);

    }

public function view_templates_report(){
        
        //$data['insert'] = '';
        if($this->input->post()){
            $this->_add_view_templates_report();
            $this->session->set_flashdata('success', 'Data inserted successfully.');
        }

        $user_id = $this->session->user_id;
        $data['user_type'] = $this->session->usertype;
        $data['report_header'] = $this->db->list_fields('exportdata');
        $data['users'] = $this->db
                ->where('users.usertype', 4)
                ->join('user_details','users.user_id = user_details.user_id','left')
                ->get('users')->result();

        // $this->db->join('users','users.user_id = view_templates_report.user_id','left');
        // $this->db->join('user_details','view_templates_report.user_id = user_details.user_id','left');
        // $data['existing_templates'] = $this->db->get_where('view_templates_report', array('status' => 1, 'users.usertype'=>4))->result();
        // echo $this->db->last_query();
        
        $query = "SELECT
                *, t1.user_id, GROUP_CONCAT(t2.firstname, ' ', t2.lastname) AS name
            FROM
                `view_templates_report` AS t1
            LEFT JOIN user_details AS t2
            ON
                FIND_IN_SET(t2.user_id, t1.user_id) > 0
            GROUP BY t1.vt_id";
        
        $data['existing_templates'] = $this->db->query($query)->result();
        
        // echo '<pre>', print_r($data),'</pre>'; die;
                        
        $data['title'] = 'Template Settings';
        $data['menu'] = 'view profile';
        

        return array('page'=>'settings/view_templates_report_v', 'data'=>$data);

    }


    public function account_templates(){
        
       

        $user_id = $this->session->user_id;



        //
        if ($this->input->post('submit_btn') == 'submit_btn') {
            
            //echo "<pre>"; print_r($this->input->post()); die();

            $insertArray = array();

            
            $insertArray['user_id'] = $user_id;

            $insertArray['template_name'] = $this->input->post('template_name');

            $insertArray['header'] =  join(',', $this->input->post('header'));

            $insertArray['type'] = $this->input->post('type');

            if($this->db->insert('sc_template', $insertArray)){

                redirect(base_url('admin/account_templates'));

            }


        }
        

        $data['title'] = 'Template Settings';
        $data['menu'] = 'view profile';
        

        return array('page'=>'settings/accounts_template', 'data'=>$data);

    }



    public function mail_templates(){
        
        $user_id = $this->session->user_id;
        //
        if ($this->input->post('submit_btn') == 'submit_btn') {
            
            //echo "<pre>"; print_r($this->input->post()); die();

            $insertArray = array();

            
            $insertArray['user_id'] = $user_id;

            $insertArray['template_name'] = $this->input->post('template_name');

            $insertArray['header'] =  join(',', $this->input->post('header'));

            if($this->db->insert('mail_template', $insertArray)){

                redirect(base_url('admin/mail_templates'));

            }


        }
        

        $data['title'] = 'Template Settings';
        $data['menu'] = 'view profile';
        

        return array('page'=>'settings/mail_template', 'data'=>$data);

    }

    


    private function _add_view_templates_report(){
        
        $user_id = $this->session->user_id;
        $data['user_type'] = $this->session->usertype;

        $insertArray = array(
            'template_name' => $this->input->post('template_name'),
            'export_header_fields' => join(',',$this->input->post('export_header[]')),
            'user_id' => join(',',$this->input->post('export_user[]')),
        );

        if($this->db->insert('view_templates_report', $insertArray)){
            // echo $this->db->last_query();die;
            return;
        }else{
            return false;
        }
    
    }

    private function _add_view_templates(){
        
        $user_id = $this->session->user_id;
        $data['user_type'] = $this->session->usertype;

        $insertArray = array(
            'template_name' => $this->input->post('template_name'),
            'offer_header_fields' => join(',',$this->input->post('offer_header[]')),
            'offer_details_fields' => join(',',$this->input->post('offer_details[]')),
            'selling_prices_fields' => join(',',$this->input->post('selling_prices[]')),
            'user_id' => join(',',$this->input->post('resource_user[]'))
        );

        if($this->db->insert('view_templates', $insertArray)){
            // echo $this->db->last_query();die;
            return;
        }else{
            return false;
        }
    
    }

    public function ajax_delete_view_templates_report($vt_id){

        $result = $this->db->where('vt_id', $vt_id)->delete('view_templates_report');

        if ($result) {
            $data['title'] = 'Deleted!';
            $data['type'] = 'success';
            $data['msg'] = 'Template deleted successfully';
        }else{
            $data['title'] = 'Not Delete!';
            $data['type'] = 'error';
            $data['msg'] = 'OOps! Somthing went wrong. Please try again.';
        }

        return $data;

    }

    public function ajax_delete_view_templates_report_filter($vt_id){

        $result = $this->db->where('report_filter_template_id', $vt_id)->delete('report_filter_template');

        if ($result) {
            $data['title'] = 'Deleted!';
            $data['type'] = 'success';
            $data['msg'] = 'Template deleted successfully';
        }else{
            $data['title'] = 'Not Delete!';
            $data['type'] = 'error';
            $data['msg'] = 'OOps! Somthing went wrong. Please try again.';
        }

        return $data;

    }

    


    public function ajax_delete_acc_template($at_id){

        $result = $this->db->where('sc_template_id', $at_id)->delete('sc_template');

        if ($result) {
            $data['title'] = 'Deleted!';
            $data['type'] = 'success';
            $data['msg'] = 'Template deleted successfully';
        }else{
            $data['title'] = 'Not Delete!';
            $data['type'] = 'error';
            $data['msg'] = 'OOps! Somthing went wrong. Please try again.';
        }

        return $data;
    }


    public function ajax_delete_mail_template($mt_id){

        $result = $this->db->where('mail_template_id', $mt_id)->delete('mail_template');

        if ($result) {
            $data['title'] = 'Deleted!';
            $data['type'] = 'success';
            $data['msg'] = 'Template deleted successfully';
        }else{
            $data['title'] = 'Not Delete!';
            $data['type'] = 'error';
            $data['msg'] = 'OOps! Somthing went wrong. Please try again.';
        }

        return $data;
    }

    public function ajax_delete_view_templates($vt_id){

        $this->db->where('vt_id', $vt_id)->delete('view_templates');

        $data['title'] = 'Deleted!';
        $data['type'] = 'success';
        $data['msg'] = 'Buying price deleted successfully';

        return $data;

    }
        
}