<?php

class Master_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function fetch_permission_matrix($user_id, $m_id){
        $nr = $this->db->get_where('user_permission', array('user_id' => $user_id, 'm_id' => 3))->num_rows();
        if(count($nr) == 0){
            $this->session->set_flashdata('title', 'Not-set!');
            $this->session->set_flashdata('msg', 'Permission not set. Please contact admin for permission.');
            redirect(base_url('admin/dashboard'));
        }else{
            return $this->db->get_where('user_permission', array('user_id' => $user_id, 'm_id' => $m_id))->result();
        }
    }

    public function log_before_update($post_array,$primary_key){
        $insertArray = array(
            'table_name' => $this->table_name,
            'pk_id' => $primary_key,
            'action_taken'=>'edit', 
            'old_data' => json_encode($post_array),
            'user_id' => $this->session->user_id,
            'comment' => 'master'
        );
        if($this->db->insert('user_logs', $insertArray)){
            return true;
        }else{
            return false;
        }
    }

    public function check_and_log_before_delete($primary_key){
        // echo $this->reference_table_name . ' || ' . $this->reference_pk_field_name . ' || ' . $primary_key;die;
        $item_exists = 0;
        foreach($this->reference_array as $ra){
            $nr = $this->db->get_where($ra['tbl_name'], array($ra['tbl_pk_fld'] => $primary_key))->num_rows();
            if($nr > 0){
                $item_exists = 1;
            }
        }
        // print_r($this->reference_array);die;        

        if($item_exists > 0){
            return false;
        } else{
            $user_data = $this->db->where($this->pk_field_name, $primary_key)->get($this->table_name)->row();
            $insertArray = array(
                'table_name' => $this->table_name,
                'pk_id' => $primary_key,
                'action_taken'=>'delete', 
                'old_data' => json_encode($user_data),
                'user_id' => $this->session->user_id,
                'comment' => 'master'
            );
            if($this->db->insert('user_logs', $insertArray)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function units() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/units'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Unit');
            $crud->set_table('units');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'units';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('unit','info','status');
            $crud->fields('unit','info','status','user_id');
            $crud->required_fields('unit','status');
            $crud->unique_fields(array('unit'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Units';
            $output->section_heading = 'Units <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Units';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }
    
    public function colors() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/colors'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Colour');
            $crud->set_table('colors');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'colors';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            // $crud->columns('unit','info','status');
            // $crud->fields('unit','info','status','user_id');
            $crud->required_fields('color_name','color_hex_code');
            $crud->unique_fields(array('color_name'));

            // $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Colours';
            $output->section_heading = 'Colours <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Colours';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function word_colors() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/word_colors'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Word Colour');
            $crud->set_table('word_colors');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'word_colors';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            // $crud->columns('unit','info','status');
            // $crud->fields('unit','info','status','user_id');
            $crud->required_fields('word');
            $crud->unique_fields(array('word'));

            $crud->set_relation('color_id', 'colors', '{color_name} - {color_hex_code}');

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Word Colours';
            $output->section_heading = 'Word Colours <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Word Colours';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }
    
    public function responsible_purchase() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/responsible_purchase'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Responsible Purchase');
            $crud->set_table('responsible_purchase');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'responsible_purchase';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('name','information','status');
            $crud->fields('name','information','status','user_id');
            $crud->required_fields('name','status');
            $crud->unique_fields(array('name'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Responsible Purchase';
            $output->section_heading = 'Responsible Purchase <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Responsible Purchase';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }


    public function responsible_sales() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/responsible_sales'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Responsible Sales');
            $crud->set_table('responsible_sales');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'responsible_sales';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('name','information','status');
            $crud->fields('name','information','status','user_id');
            $crud->required_fields('name','status');
            $crud->unique_fields(array('name'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Responsible Sales';
            $output->section_heading = 'Responsible Sales <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Responsible Sales';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }



    public function responsible_logistic() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/responsible_logistic'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Responsible Logistic');
            $crud->set_table('responsible_logistic');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'responsible_logistic';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('name','information','status');
            $crud->fields('name','information','status','user_id');
            $crud->required_fields('name','status');
            $crud->unique_fields(array('name'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Responsible Logistic';
            $output->section_heading = 'Responsible Logistic <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Responsible Logistic';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }



      


    public function products() {
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/products'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Product');
            $crud->set_table('products');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'products';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('product_name','scientific_name','status');
            $crud->fields('product_name','scientific_name','status','user_id');
            $crud->required_fields('product_name');
            $crud->unique_fields(array('product_name','scientific_name'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Products';
            $output->section_heading = 'Products <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Products';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function  bank(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/bank'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Bank');
            $crud->set_table('bank_master');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'bank';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            //$crud->columns('supplier_buyer','name','phone_number','email_id','address','status');
            //$crud->unset_fields('create_date','modify_date','user_id');
            
            ///$crud->required_fields('name','am_code','email_id','country_id','supplier_buyer');
            //$crud->unique_fields(array('name','phone_number'));

           // $crud->set_relation('country_id','countries','name');

           // $crud->display_as('supplier_buyer','Supplier / Buyer');
           // $crud->display_as('country_id','Country');

           // $crud->field_type('user_id', 'hidden', $user_id);
            //$crud->field_type('supplier_buyer', 'dropdown', array('0' => 'Supplier', '1' => 'Buyer'));

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Bank Details';
            $output->section_heading = 'Bank Details <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Bank Details';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function  offer_terms(){
        $user_id = $this->session->user_id;
        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/offer_status'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Offer Status');
            $crud->set_table('offer_status');
            $crud->unset_read();
            $crud->unset_clone();
            $crud->unset_delete();

            $this->table_name = 'offer_status';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('offer_status');
            //$crud->unset_fields('create_date','modify_date','user_id');
            
            ///$crud->required_fields('name','am_code','email_id','country_id','supplier_buyer');
            $crud->unset_fields(array('created_at','updated_at'));

           // $crud->set_relation('country_id','countries','name');

           // $crud->display_as('supplier_buyer','Supplier / Buyer');
           // $crud->display_as('country_id','Country');

           // $crud->field_type('user_id', 'hidden', $user_id);
            //$crud->field_type('supplier_buyer', 'dropdown', array('0' => 'Supplier', '1' => 'Buyer'));

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Offer Status';
            $output->section_heading = 'Offer Status <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Offer Status';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function  payment_terms(){
        $user_id = $this->session->user_id;
        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/payment_terms'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Payment Terms');
            $crud->set_table('payment_terms');
            $crud->unset_read();
            $crud->unset_clone();
            $crud->unset_delete();

            $this->table_name = 'payment_terms';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('payment_terms','status');
            $crud->unset_fields(array('created_date','modified_date'));
    
            $crud->required_fields('payment_terms');
            
            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Payment Terms';
            $output->section_heading = 'Payment Status <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Payment Terms';
            $output->add_button = '';
            
            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }
    
    public function  all_clauses(){
        $user_id = $this->session->user_id;
        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/all_clauses'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Clause Master');
            $crud->set_table('all_clauses');
            
            $crud->unset_read();
            $crud->unset_clone();
            $crud->unset_delete();

            $this->table_name = 'all_clauses';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('clause_name', 'clause_details', 'customer_id','status');
            $crud->unset_fields(array('created_date','modified_date'));
            
            $crud->set_relation('customer_id','acc_master','name', array('supplier_buyer' =>1));
            
            $crud->required_fields('clause_name', 'clause_details', 'customer_id');
            
            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Clause Master';
            $output->section_heading = 'Clause Master <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Clause Master';
            $output->add_button = '';
            
            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function account_master(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/account_master'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Acc Master');
            $crud->set_table('acc_master');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'acc_master';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('supplier_buyer','name','phone_number','email_id','address','status');
            $crud->unset_fields('payment_term','create_date','modify_date','user_id');
            
            $crud->required_fields('name','am_code','email_id','country_id','supplier_buyer');
            $crud->unique_fields(array('name','phone_number'));

            $crud->set_relation('country_id','countries','name');

            $crud->display_as('supplier_buyer','Supplier / Buyer');
            $crud->display_as('country_id','Country');

            $crud->field_type('user_id', 'hidden', $user_id);
            $crud->field_type('supplier_buyer', 'true_false', array('0' => 'Supplier', '1' => 'Buyer'));
            
            
            $crud->display_as('instruction','Sale Contract Instruction');

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Acc Master';
            $output->section_heading = 'Acc Master <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Acc Master';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }


    public function company(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/company'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Company Details');
            $crud->set_table('company');
            $crud->unset_read();
            $crud->unset_clone();
            $crud->unset_delete();

            $this->table_name = 'company';

            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('company_logo','company_name','address','status');
            $crud->unset_fields('created_date','updated_date','user_id');
            
            $crud->required_fields('company_name','address');
            $crud->unique_fields(array('company_name'));
            
            $crud->set_field_upload('company_logo','assets/img');

            $crud->display_as('company_name','Company Name');
            $crud->display_as('address','Address');

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Company';
            $output->section_heading = 'Company <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Company';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    

    public function countries(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/countries'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Countries');
            $crud->set_table('countries');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'countries';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('name','iso3','phonecode','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('name');
            $crud->unique_fields(array('name','phonecode'));

            // $crud->display_as('supplier_buyer','Supplier / Buyer');

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Countries';
            $output->section_heading = 'Countries <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Countries';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function ports(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/ports'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Ports');
            $crud->set_table('ports');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'ports';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('port_name','info','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('port_name');
            $crud->unique_fields(array('port_name'));

            // $crud->display_as('supplier_buyer','Supplier / Buyer');

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Ports';
            $output->section_heading = 'Ports <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Ports';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function remark1_offer_validity(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/remark1_offer_validity'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Remark 1 - Offer Validity');
            $crud->set_table('remark1_offer_validity');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'remark1_offer_validity';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('remark','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('remark');
            $crud->unique_fields(array('remark'));

            // $crud->display_as('supplier_buyer','Supplier / Buyer');

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Remark 1 - Offer Validity';
            $output->section_heading = 'Remark 1 - Offer Validity <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Remark 1 - Offer Validity';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function freezing(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/freezing'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Freezing');
            $crud->set_table('freezing');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'freezing';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('freezing_category','freezing_type','comment','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('freezing_category','freezing_type');
            $crud->unique_fields(array('freezing_type'));

            // $crud->display_as('supplier_buyer','Supplier / Buyer');

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Freezing Details';
            $output->section_heading = 'Freezing Details <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Freezing Details';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function packing_types(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/packing_types'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Packing Types');
            $crud->set_table('packing_types');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'packing_types';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('packing_type','information','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('packing_type', 'packing_category');
            // $crud->unique_fields(array('packing_type'));

            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Packing Types';
            $output->section_heading = 'Packing Types <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Packing Types';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function packing_sizes(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/packing_sizes'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Packing Sizes');
            $crud->set_table('packing_sizes');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'packing_sizes';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('packing_size','information','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('packing_size');
            $crud->unique_fields(array('packing_size'));
            
            $crud->display_as('packing_size','Packing size / carton');
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Packing Sizes';
            $output->section_heading = 'Packing Sizes <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Packing Sizes';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }
   
    public function glazing(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/glazing'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Packing Sizes');
            $crud->set_table('glazing');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'glazing';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('glazing','information','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('glazing');
            $crud->unique_fields(array('glazing'));
            
            // $crud->display_as('packing_size','Packing size / carton');
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Glazing';
            $output->section_heading = 'Glazing <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Glazing';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function blocks(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/blocks'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Block Sizes');
            $crud->set_table('blocks');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'blocks';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('block_size','information','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('block_size');
            $crud->unique_fields(array('block_size'));
            
            // $crud->display_as('packing_size','Packing size / carton');
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Blocks';
            $output->section_heading = 'Blocks <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Blocks';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function sizes(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/sizes'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Sizes');
            $crud->set_table('sizes');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'sizes';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('size','unit_id','information','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('size','unit_id');
            $crud->unique_fields(array('size'));
            
            // $crud->display_as('packing_size','Packing size / carton');
            $crud->field_type('user_id', 'hidden', $user_id);

            $crud->set_relation('unit_id','units','unit');

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'sizes';
            $output->section_heading = 'sizes <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'sizes';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function currencies(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/currencies'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Currencies');
            $crud->set_table('currencies');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'currencies';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('currency','code','symbol','status');
            $crud->unset_fields('thousand_separator','decimal_separator','created_date','modified_date','user_id');
            $crud->required_fields('currency','code');
            $crud->unique_fields(array('code'));
            
            // $crud->display_as('packing_size','Packing size / carton');
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Currencies';
            $output->section_heading = 'Currencies <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Currencies';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function incoterms(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/incoterms'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('incoterms');
            $crud->set_table('incoterms');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'incoterms';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('incoterm','information','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('incoterm');
            $crud->unique_fields(array('incoterm'));
            
            // $crud->display_as('packing_size','Packing size / carton');
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Incoterms';
            $output->section_heading = 'Incoterms <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Incoterms';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function line_items(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/line_items'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Line Items');
            $crud->set_table('line_items');
            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'line_items';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->columns('line_item_category','line_item_name','status');
            $crud->unset_fields('created_date','modified_date','user_id');
            $crud->required_fields('line_item_category','line_item_name');
            $crud->unique_fields(array('line_item_name'));
            
            // $crud->display_as('packing_size','Packing size / carton');
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Line Items';
            $output->section_heading = 'Line Items <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Line Items';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function freight_master(){
        $user_id = $this->session->user_id;

        try{
            $crud = new grocery_CRUD();
            $crud->set_crud_url_path(base_url('admin_panel/Master/freight_master'));
            $crud->set_theme('flexigrid');
            $crud->set_subject('Freight Master');
            $crud->set_table('freight_master');

            $crud->unset_read();
            $crud->unset_clone();

            $this->table_name = 'freight_master';
            $crud->callback_before_update(array($this,'log_before_update'));
            
            $crud->unset_columns('created_date','modified_date','user_id');
            $crud->unset_fields('created_date','modified_date','user_id');

            $crud->required_fields('source_country','destination_country','container_size','freight_amount');
            
            $crud->set_relation('source_country','ports','port_name');
            $crud->set_relation('destination_country','ports','port_name');


            $crud->display_as('source_country','Source port');

            $crud->display_as('destination_country', 'Destination port');
            
            $crud->field_type('user_id', 'hidden', $user_id);

            $output = $crud->render();
            //rending extra value to $output
            $output->tab_title = 'Freight Master';
            $output->section_heading = 'Freight Master <small>(Add / Edit / Delete)</small>';
            $output->menu_name = 'Freight Master';
            $output->add_button = '';

            return array('page'=>'common_v', 'data'=>$output); //loading common view page
        } catch(Exception $e) {
            show_error($e->getMessage().'<br>'.$e->getTraceAsString());
        }
    }

    public function ajax_del_row_on_table_and_pk(){
        $warning = 0;
        $pk_name = str_replace('-','_',$this->input->post('pk_name'));
        $pk_value = $this->input->post('pk_value');
        $table = str_replace('-','_',$this->input->post('tab'));
        $child = $this->input->post('child');
        $ref_table = str_replace('-','_',$this->input->post('ref_table'));
        $ref_pk_name = str_replace('-','_',$this->input->post('ref_pk_name')); 

        // checking article details table with customer order 
        if($this->input->post('ref_pk_name') == "art-master#multiple-check"){
            
            $details = $this->db->get_where($table, array($pk_name => $pk_value))->result();
            $nr = $this->db->get_where($ref_table, array('am_id' => $details[0]->am_id, 'fc_id' => $details[0]->fit_color_id, 'lc_id' => $details[0]->lth_color_id))->num_rows();
            if($nr > 0){
                $warning = 1;
            }else{
                $warning = 0;
            }
            // echo '<pre>',print_r($details), '</pre>';die;
        }else { # all other master delete 
            if($child == 0){
                $warning = 0;
            }else{
                $nr = $this->db->get_where($ref_table, array($ref_pk_name => $pk_value))->num_rows();
                
                if($nr > 0){
                    $warning = 1;
                }else{
                    $warning = 0;   
                }
            }
        }

        if($warning == 1){
            $data['type'] = 'warning';
            $data['msg'] = 'Unsuccessful! Item already exists in another table'; 
        }else{
            $data = $this->log_and_direct_delete($pk_name, $pk_value, $table);
        }
        
        return $data;
    }

    private function log_and_direct_delete($pk_name, $pk_value, $table){
        // log data first 
        
        $user_data = $this->db->where($pk_name, $pk_value)->get($table)->row();
        $insertArray = array(
            'table_name' => $table,
            'pk_id' => $pk_value,
            'action_taken'=>'delete', 
            'old_data' => json_encode($user_data),
            'user_id' => $this->session->user_id,
            'comment' => 'master'
        );
        if($this->db->insert('user_logs', $insertArray)){

            $this->db->where($pk_name, $pk_value)->delete($table);
            $data['title'] = 'Deleted!';
            $data['type'] = 'success';
            $data['msg'] = 'Item Successfully Deleted';
            
        }else{
            return false;
        }

        return $data;
    }

}