<?php

class Documents extends My_Controller {

    private $user_type = null;

    public function __construct() {
        parent::__construct();

        // $this->load->library('grocery_CRUD');

        if($this->session->has_userdata('user_id')) { //if logged-in
            $this->user_type = $this->session->usertype;
        }
    }

    public function index() {
        redirect(base_url('admin/my-documents'));
    }

    public function check_permission($auth_usertype = array()) {
        //if not logged-in
        if($this->user_type == null) {
            $this->session->set_flashdata('title', 'Log-in!');
            $this->session->set_flashdata('msg', 'Kindly log-in to access that page.');
            redirect(base_url('admin'));
        }

        //if no special permission required (should be logged-in only)
        if(count($auth_usertype) == 0) {
            return true;
        }

        if(in_array($this->user_type, $auth_usertype)) {
            return true;
        } else {
            $this->session->set_flashdata('title', 'Prohibited!');
            $this->session->set_flashdata('msg', 'You do not have permission to access that page, kindly contact Administrator.');
            redirect(base_url('admin/dashboard'));
        }
    }

    public function my_documents($parentFolderId){        
        if($this->check_permission(array()) == true) {
            $this->load->model('Documents_m');
            $data = $this->Documents_m->my_documents($parentFolderId);
            $this->load->view($data['page'], $data['data']);
        }
    }
    


    public function add_document($parentFolderId){        
        if($this->check_permission(array()) == true) {
            $this->load->model('Documents_m');
            $data = $this->Documents_m->add_document($parentFolderId);
            $this->load->view($data['page'], $data['data']);
        }        

    }
    

    public function ajax_delete_document(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Documents_m');
            $data = $this->Documents_m->ajax_delete_document();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }
    

    public function ajax_edit_document(){        
        if($this->check_permission(array()) == true) {
            $this->load->model('Documents_m');
            $data = $this->Documents_m->ajax_edit_document();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function ajax_share_document(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Documents_m');
            $data = $this->Documents_m->ajax_share_document();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }
    

    public function form_add_document(){        
        if($this->check_permission(array()) == true) {
            $this->load->model('Documents_m');
            $data = $this->Documents_m->form_add_document();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }
    

}