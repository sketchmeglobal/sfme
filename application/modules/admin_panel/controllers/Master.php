<?php

class Master extends My_Controller {

    private $user_type = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('grocery_CRUD');

        if($this->session->has_userdata('user_id')) { //if logged-in
            $this->user_type = $this->session->usertype;
        }
    }

    public function index() {
        redirect(base_url('admin/item_group'));
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

    public function units() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->units();
            $this->load->view($data['page'], $data['data']);
        }
    }
    
    public function colors() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->colors();
            $this->load->view($data['page'], $data['data']);
        }
    }
    
    public function word_colors() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->word_colors();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function responsible_purchase() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->responsible_purchase();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function responsible_sales() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->responsible_sales();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function responsible_logistic() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->responsible_logistic();
            $this->load->view($data['page'], $data['data']);
        }
    }



    public function products() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->products();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function account_master() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->account_master();
            $this->load->view($data['page'], $data['data']);
        }
    }


    public function bank()
    {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->bank();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function company() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->company();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function offer_status() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->offer_status();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function payment_terms() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->payment_terms();
            $this->load->view($data['page'], $data['data']);
        }
    }
    
    public function all_clauses() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->all_clauses();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function countries() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->countries();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function ports() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->ports();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function freezing() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->freezing();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function packing_types() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->packing_types();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function packing_sizes() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->packing_sizes();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function glazing() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->glazing();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function remark1_offer_validity() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->remark1_offer_validity();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function blocks() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->blocks();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function sizes() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->sizes();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function currencies() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->currencies();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function incoterms() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->incoterms();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function line_items() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->line_items();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function freight_master() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            $data = $this->Master_m->freight_master();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function ajax_del_row_on_table_and_pk() {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Master_m');
            if($this->input->post('tab') == 'item-dtl'){
                $data = $this->Master_m->ajax_del_item_master_color();
            }else if($this->input->post('tab') == 'item-master'){
                $data = $this->Master_m->ajax_del_item_master();
            }else if($this->input->post('tab') == 'article-master'){
                $data = $this->Master_m->ajax_del_article_master();
            }else{
                $data = $this->Master_m->ajax_del_row_on_table_and_pk();
            }            
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

}