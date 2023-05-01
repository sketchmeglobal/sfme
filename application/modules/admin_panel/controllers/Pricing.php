<?php

class Pricing extends My_Controller {

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

    // BUYING PRICING AREA

    public function offer_buying_price($offer_id, $od_id) {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Pricing_m');

            $data['offer_id'] = $offer_id;
            $data['od_id'] = $od_id;
            $data['offer_buying_price'] = $this->Pricing_m->offer_buying_price($offer_id, $od_id);

            $data['incoterms'] = $data['offer_buying_price']['incoterms'];
            $data['title'] = $data['offer_buying_price']['title'];
            $data['menu'] = $data['offer_buying_price']['menu'];

            $data['offer_name'] = $data['offer_buying_price']['offer_name'][0]->offer_name . ' ['.$data['offer_buying_price']['offer_name'][0]->offer_number.']';


            $data['currency_symbol'] = $data['offer_buying_price']['offer_name'][0]->symbol;

            $data['original_incoterm'] = $data['offer_buying_price']['offer_name'][0]->incoterm;

            $data['currencies'] = $data['offer_buying_price']['currency'];

            $data['product'] = $data['offer_buying_price']['product'][0]->product_name . ' ['.$data['offer_buying_price']['product'][0]->scientific_name.']';

            $data['product_price'] = $data['offer_buying_price']['product'][0]->product_price;
            
            // echo '<pre>', print_r($data), '</pre>';die;
            $this->load->view('pricing/buying_price_v', $data);

        }
    }

    /*list area*/

    public function ajax_buying_price_table_data($od_id){
        
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->ajax_buying_price_table_data($od_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    /*add area*/    
    public function fetch_line_items_on_type() {
        if($this->check_permission() == true) {
            $type = $this->input->post('type');
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->fetch_line_items_on_type($type);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function add_buying_price(){

        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            if($this->input->post('buying_price_submit') == 'Insert'){
                $data = $this->Pricing_m->add_buying_price();
            }else{
                $data = $this->Pricing_m->update_buying_price();
            }
            
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }    

    public function fetch_buying_price_on_pk($bp_id){
        
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->fetch_buying_price_on_pk($bp_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function fetch_offer_products_on_offer_id($offer_id){
        
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->fetch_offer_products_on_offer_id($offer_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function form_export_product_pricing(){

         if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->form_export_product_pricing();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }           

    }

    public function form_export_product_selling_pricing(){

         if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->form_export_product_selling_pricing();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }           

    }

    // delete area
    public function ajax_delete_buying_price($bp_id){
       
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->ajax_delete_buying_price($bp_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }


    //Selling Price 

     public function offer_selling_price($offer_id, $od_id) {
        if($this->check_permission(array(1)) == true) {
            $this->load->model('Pricing_m');

            $data['offer_id'] = $offer_id;
            $data['od_id'] = $od_id;
            $data['offer_selling_price'] = $this->Pricing_m->offer_selling_price($offer_id, $od_id);

            $data['incoterms'] = $data['offer_selling_price']['incoterms'];
            $data['title'] = $data['offer_selling_price']['title'];
            $data['menu'] = $data['offer_selling_price']['menu'];

            $data['offer_name'] = $data['offer_selling_price']['offer_name'][0]->offer_name . ' ['.$data['offer_selling_price']['offer_name'][0]->offer_number.']';


            $data['currency_symbol'] = $data['offer_selling_price']['offer_name'][0]->symbol;

            $data['currency'] = $data['offer_selling_price']['offer_name'][0]->currency;

            $data['original_incoterm'] = $data['offer_selling_price']['offer_name'][0]->incoterm;

            $data['countries'] = $data['offer_selling_price']['country'];

            //$data['ports'] = $data['offer_selling_price']['ports'];

            $data['currencies'] = $data['offer_selling_price']['currency'];

            $data['acc_masters'] = $data['offer_selling_price']['acc_master'];

            $data['product'] = $data['offer_selling_price']['product'][0]->product_name . ' ['.$data['offer_selling_price']['product'][0]->scientific_name.']';

            $data['product_price'] = $data['offer_selling_price']['product'][0]->product_price;
            
            $data['final_buying_price'] = ($data['offer_selling_price']['final_buying_price'][0]->final_buying_price + $data['product_price']);
            
            $data['source_currency'] = $data['offer_selling_price']['offer_name'][0]->currency .' ('. $data['offer_selling_price']['offer_name'][0]->symbol . ')';

            // echo '<pre>', print_r($data), '</pre>';die;
            $this->load->view('pricing/selling_price_v', $data);

        }
    }

    /*list area*/

    public function ajax_selling_price_details_table_data($offer_id, $od_id){
        
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->ajax_selling_price_details_table_data($offer_id,$od_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function ajax_selling_price_table_data($od_id){
        
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->ajax_selling_price_table_data($od_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function add_selling_price(){

        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');

            if($this->input->post('selling_price_submit') == 'Insert'){
                $data = $this->Pricing_m->add_selling_price();
            }else{
                $data = $this->Pricing_m->update_selling_price();
            }
            
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }   

    public function add_country_wise_selling_price(){

        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');

            if($this->input->post('country_wise_selling_price_submit') == 'Insert'){
                $data = $this->Pricing_m->add_country_wise_selling_price();
            }else{
                $data = $this->Pricing_m->update_country_wise_selling_price();
            }
            
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    } 

    public function fetch_selling_price_on_pk($sp_id){
        
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->fetch_selling_price_on_pk($sp_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    // delete area
    public function ajax_delete_selling_price($sp_id){
       
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->ajax_delete_selling_price($sp_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    public function ajax_delete_selling_price_details($spd_id){
       
        if($this->check_permission() == true) {
            $this->load->model('Pricing_m');
            $data = $this->Pricing_m->ajax_delete_selling_price_details($spd_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

    }

    

}