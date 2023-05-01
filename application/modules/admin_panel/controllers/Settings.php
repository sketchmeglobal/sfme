<?php

class Settings extends My_Controller {

    private $user_type = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('grocery_CRUD');

        if($this->session->has_userdata('user_id')) { //if logged-in
            $this->user_type = $this->session->usertype;
        }
    }

    public function index() {
        redirect(base_url('admin/profile'));
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
    
    public function database_backup_m() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Settings_m');
            $data = $this->Settings_m->database_backup_m();
        }
    }

    public function view_templates() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Settings_m');
            $data = $this->Settings_m->view_templates();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function view_report_filter_templates() {
        if($this->check_permission(array(1)) == true) {
            
            $this->load->model('Settings_m');
            $data = $this->Settings_m->view_report_filter_templates();
            $this->load->view($data['page'], $data['data']);
        }
    }
     public function view_templates_report() {
        if($this->check_permission(array(1)) == true) {
            /*echo "<pre>";
            print_r();
            die();*/
            $this->load->model('Settings_m');
            $data = $this->Settings_m->view_templates_report();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function account_templates() {
        if($this->check_permission(array(1)) == true) {
            /*echo "<pre>";
            print_r();
            die();*/
            $this->load->model('Settings_m');
            $data = $this->Settings_m->account_templates();
            $this->load->view($data['page'], $data['data']);
        }
    }


    public function mail_templates() {
        if($this->check_permission(array(1)) == true) {
            /*echo "<pre>";
            print_r();
            die();*/
            $this->load->model('Settings_m');
            $data = $this->Settings_m->mail_templates();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function ajax_delete_acc_template($at_id) {

        if($this->check_permission(array(1)) == true) {
            $this->load->model('Settings_m');
            $data = $this->Settings_m->ajax_delete_acc_template($at_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }


    public function ajax_delete_mail_template($at_id) {

        if($this->check_permission(array(1)) == true) {
            $this->load->model('Settings_m');
            $data = $this->Settings_m->ajax_delete_mail_template($at_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    
    public function ajax_delete_view_templates_report($vt_id) {

        if($this->check_permission(array(1)) == true) {
            $this->load->model('Settings_m');
            $data = $this->Settings_m->ajax_delete_view_templates_report($vt_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function ajax_delete_view_templates_report_filter($vt_id) {

        if($this->check_permission(array(1)) == true) {
            $this->load->model('Settings_m');
            $data = $this->Settings_m->ajax_delete_view_templates_report_filter($vt_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function ajax_delete_view_templates($vt_id) {

        if($this->check_permission(array(1)) == true) {
            $this->load->model('Settings_m');
            $data = $this->Settings_m->ajax_delete_view_templates($vt_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

}