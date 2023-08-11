<?php

class Task extends My_Controller {

    private $user_type = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('grocery_CRUD');

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

    public function task_group(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Task_m');
            $data = $this->Task_m->task_group();
            $this->load->view($data['page'], $data['data']);
        }

    }
    
    public function task_list(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Task_m');
            $data = $this->Task_m->task_list();
            $this->load->view($data['page'], $data['data']);
        }

    }
    
    public function task_activity(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Task_m');
            $data = $this->Task_m->task_activity();
            $this->load->view($data['page'], $data['data']);
        }

    }

    public function task_common_activity(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Task_m');
            $data = $this->Task_m->task_common_activity();
            $this->load->view($data['page'], $data['data']);
        }

    }

    public function task_communication(){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Task_m');
            $data = $this->Task_m->task_communication();
            $this->load->view($data['page'], $data['data']);
        }

    }

    public function edit_user_task_activity($id){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Task_m');
            $data = $this->Task_m->edit_user_task_activity($id);
            $this->load->view($data['page'], $data['data']);
        }

    }

}