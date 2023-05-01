<?php

class Accounts extends My_Controller {

    private $user_type = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('grocery_CRUD');

        if($this->session->has_userdata('user_id')) { //if logged-in
            $this->user_type = $this->session->usertype;
        }
    }

    public function index() {
        redirect(base_url('admin/proforma_invoice'));
    }


    public function purchase_order()
    {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->purchase_order();
            $this->load->view($data['page'], $data['data']);
        }
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

    public function add_sale_contract()
    {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->add_sale_contract();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function purchase_order_add()
    {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->purchase_order_add();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function form_add_purchase_order() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->form_add_purchase_order();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    
    public function ajax_clause_on_customer()
    {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->ajax_clause_on_customer();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function edit_sale_contract($id)
    {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->edit_sale_contract($id);
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function edit_purchase_order($id)
    {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->edit_purchase_order($id);
            $this->load->view($data['page'], $data['data']);
        }
    }

    

    public function form_add_sale_contract() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->form_add_sale_contract();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }


    public function form_edit_sale_contract() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->form_edit_sale_contract();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function form_edit_purchase_order() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->form_edit_purchase_order();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    

    public function proforma_invoice() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->proforma_invoice();
            $this->load->view($data['page'], $data['data']);
        }
    }
    
    public function proforma_invoice_print() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->proforma_invoice_print();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function print_purchase_order() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Accounts_m');
            $data = $this->Accounts_m->print_purchase_order();
            $this->load->view($data['page'], $data['data']);
        }
    }


    public function purchase_order_print($id='')
    {
         $this->load->view('accounts/purchase_order_print');
    }


    public function show_sc_template($sc_id)
    {
         $this->load->view('accounts/temp_view_sc');
    }


    public function show_po_template($po_id)
    {
         $this->load->view('accounts/temp_view_po');
    }


    

    
}