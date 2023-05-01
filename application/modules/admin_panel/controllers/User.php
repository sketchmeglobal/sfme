<?php

class User extends My_Controller {

    private $user_type = null;

    public function __construct() {
        parent::__construct();

        // $this->load->library('grocery_CRUD');

        if($this->session->has_userdata('user_id')) { //if logged-in
            $this->user_type = $this->session->usertype;
        }
    }

    public function index() {
        redirect(base_url('admin/dashboard'));
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

    public function user_management(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->user_management();
            $this->load->view($data['page'], $data['data']);
        }

    }

    public function ajax_user_table_data(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->ajax_user_table_data();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }


    public function add_user(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->add_user();
            $this->load->view($data['page'], $data['data']);
        }        

    }

    public function ajax_unique_username(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->ajax_unique_username();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }        

    }

    public function ajax_delete_user(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->ajax_delete_user();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function acc_master_on_usertype(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->acc_master_on_usertype();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function form_add_user(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->form_add_user();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function edit_user($user_id){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->edit_user($user_id);
            $this->load->view($data['page'], $data['data']);
        }

    }

    public function ajax_unique_username_edit(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->ajax_unique_username_edit();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function form_edit_user(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('User_m');
            $data = $this->User_m->form_edit_user();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

}