<?php

class Export extends My_Controller {

    private $user_type = null;

    public function __construct() {
        parent::__construct();

        $this->load->library('grocery_CRUD');

        if($this->session->has_userdata('user_id')) { //if logged-in
            $this->user_type = $this->session->usertype;
        }
    }

    public function index() {
        redirect(base_url('admin/offers'));
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

    public function offer_comments() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->offer_comments();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function export() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->export();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function ajax_export_table_data() {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
           $data = $this->Export_m->ajax_export_table_data();

            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }


    public function ajax_get_offer_data() {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            
           $data = $this->Export_m->ajax_get_offer_data();

            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function get_price_details() {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
             /*echo $pid = $this->input->post('pid');

             die();*/
           $data = $this->Export_m->get_price_details();

            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }
    
    public function export_list() {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->export_list();
            $this->load->view($data['page'], $data['data']);
        }
    }
    
    public function export_list_segment($sn) {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->export_list_segment($sn);
            $this->load->view($data['page'], $data['data']);
        }
    }
    
    public function ajax_update_offer_wip() {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_update_offer_wip();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function request_offer(){
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->request_offer();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }   
    }

    public function ajax_show_all_comments(){
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_show_all_comments();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }   
    }

    public function ajax_update_offer_comments(){
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_update_offer_comments();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }   
    }

    // ADD OFFER

    public function add_export() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->add_export();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function ajax_unique_offer_number(){
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_unique_offer_number();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function form_add_export() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');

           /* echo "<pre>";

            // print_r($this->input->post());

             echo $this->input->post('corrc_appr_cust_date');

        //date('Y-m-d_H-i')

        die();


            die();*/


            $data = $this->Export_m->form_add_export();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    // EDIT CUSTOMER ORDER 

    public function export_edit($export_id) {

        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->export_edit($export_id);
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function update_final_marketing_approval_status($offer_id) {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->update_final_marketing_approval_status($offer_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function ajax_unique_offer_number_edit(){
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_unique_offer_number_edit();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function form_edit_export(){
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->form_edit_export();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }
    
    public function ajax_offer_details_table_data() {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_offer_details_table_data();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function form_add_offer_details() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->form_add_offer_details();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function ajax_fetch_offer_details_on_pk() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_fetch_offer_details_on_pk();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function form_edit_offer_details() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->form_edit_offer_details();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function form_export_offer_details() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->form_export_offer_details();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function del_row_offer_details() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->del_row_offer_details();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function fetch_offer_details_on_pk() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->fetch_offer_details_on_pk();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    public function ajax_fetch_assigned_templates($offer_id){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_fetch_assigned_templates($offer_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }   

    }
    
    public function ajax_fetch_offer_status($offer_id){
        
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_fetch_offer_status($offer_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }   

    }

    // CLONE OFFER

    public function ajax_offer_clone($offer_id) {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_offer_clone($offer_id);
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }    
    
    // DELETE OFFER

    public function ajax_delete_offer() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_delete_offer();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }
    
    public function delete_offer_files() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->delete_offer_files();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }


    public function report()
    {
        $this->load->model('Export_m');
        $data['template_data'] = $this->Export_m->report();

        $data['title'] = "Report";
        /*
        echo "<pre>";
        print_r($data['view_offer_data']);
        die();*/
        $this->load->view('export/report_v', $data);
    }

    public function generate_report()
    {
        $data = array();
        $this->load->model('Export_m');
        $report_temp = $this->input->post('report_temp');
        $data['report_data'] = $this->Export_m->generate_report($report_temp);

        $data['template_name'] = ($this->db->query('SELECT template_name FROM view_templates_report WHERE vt_id='.$report_temp)->row()->template_name);
        
        // echo "<pre>";print_r($report_temp);die();
        
        $this->load->view('export/report_generate_v', $data);
    }


    // VIEW AREA
    
    public function view_report($report_id) {

        $this->load->model('Export_m');

        if($this->check_permission(array()) == true) {

            $data['upgrade_rate'] = false;

            if($this->input->post('upgrade_rate')){

                #from marketing
                
                $mbp = $this->input->post('mar_base_price');
                $msr = $this->input->post('mar_selling_rate');

                if($mbp > $msr){

                    $updateArray = array(
                        'mar_selling_rate' => $this->input->post('mar_selling_rate'),
                        'mar_selling_status' => 1,
                        'mar_selling_approval_status' => 0
                    );

                }else{

                    $updateArray = array(
                        'mar_selling_rate' => $this->input->post('mar_selling_rate'),
                        'mar_selling_status' => 0,
                        'mar_selling_approval_status' => 1
                    );

                }

                
                $sp_id = $this->input->post('mar_sp_id');
                
                // print_r($updateArray); die;

                if($this->Export_m->upgrade_selling_rate($updateArray, $sp_id)){
                    $data['upgrade_rate'] = true;
                }

            }

            if($this->input->post('approve_upgrade_rate')){

                #from admin
                $updateArray = array(
                    'mar_selling_status' => 0,
                    'mar_selling_approval_status' => 1
                );
                $sp_id = $this->input->post('admin_sp_id');
                
                // print_r($updateArray); die;

                if($this->Export_m->upgrade_selling_rate($updateArray, $sp_id)){
                    $data['upgrade_rate'] = true;
                }

            }

            if($this->input->post('decline_upgrade_rate')){

                #from admin
                $updateArray = array(
                    'mar_selling_rate' => 0,
                    'mar_selling_status' => 0,
                    'mar_selling_approval_status' => 0
                );
                $sp_id = $this->input->post('admin_sp_id');
                
                // print_r($updateArray); die;

                if($this->Export_m->upgrade_selling_rate($updateArray, $sp_id)){
                    $data['upgrade_rate'] = true;
                }

            }

            if($this->input->post('mar_final_btn')){

                $spds = $this->input->post('spd_id[]');
                $sps = $this->input->post('sp_id_mail[]');
                $cids = $this->input->post('customer_id[]');

                foreach($spds as $key=>$spd){
                    
                    $query = "
                    SELECT
                        $cids[$key] AS client_id,
                        (SELECT name FROM `acc_master` WHERE `acc_master`.`am_id` = $cids[$key]) AS client_name,
                        (SELECT email_id FROM `acc_master` WHERE `acc_master`.`am_id` = $cids[$key]) AS client_email,
                        `products`.`product_name`,
                        `incoterms`.`incoterm`,
                        `sell_price_details`.`exchange_rate`,
                        IF(
                            mar_selling_approval_status = 1,
                            mar_selling_rate * exchange_rate,
                            final_selling_price * exchange_rate
                        ) AS final_selling_price,
                        `currencies`.`currency`
                    FROM
                        `selling_price`
                    LEFT JOIN `incoterms` ON `incoterms`.`it_id` = `selling_price`.`selling_incoterm_id`
                    LEFT JOIN `offer_details` ON `offer_details`.`od_id` = `selling_price`.`od_id`
                    LEFT JOIN `products` ON `products`.`pr_id` = `offer_details`.`product_id`
                    LEFT JOIN `sell_price_details` ON `sell_price_details`.`od_id` = `offer_details`.`od_id`
                    LEFT JOIN `currencies` ON `currencies`.`c_id` = `sell_price_details`.`currency_id`
                    WHERE
                        `selling_price`.`sp_id` = $sps[$key] AND `sell_price_details`.`spd_id` = $spds[$key]
                    ";
                    
                    $rs[] = $this->db->query($query)->result_array();

                }

                
                // Group if same client found

                foreach($rs as $result){

                    foreach ($result as $element) {                        
                        $fresult[$element['client_id']][] = $element;
                    }

                }

                $this->_send_mail($fresult);

            }
            // die();

            $data['view_offer_data'] = $this->Export_m->view_offer($report_id);
            $this->load->view('export/view_export', $data);

        }
        
    }



    /*export product qty add*/

    
    public function add_export_product_qty() {

        /*echo "<pre>";

        print_r($this->input->post());

        die();*/

        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->add_export_product_qty();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }

        
    }



    /*end*/


    /*export report*/

    public function view_export_report_list($offer_id) {

        $this->load->model('Export_m');

        if($this->check_permission(array()) == true) {

            $data['upgrade_rate'] = false;

            $data['product_details'] = $this->Export_m->view_export_report_list($offer_id);

            if(@count($data['product_details']['export_product_details']) == 0){
                $this->session->set_flashdata('type','error');
                $this->session->set_flashdata('msg','Not report generate yet.');
                redirect(base_url('admin/export-list'));

            }else{
                $this->load->view('export/view_export_report_list_v', $data);
            }
            

        }
        
    }
    /*end*/

    // MARKETING AREA

    public function offers_marketing() {
        if($this->check_permission(array()) == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->offers_marketing();
            $this->load->view($data['page'], $data['data']);
        }
    }

    public function ajax_Export_marketing_table_data() {
        if($this->check_permission() == true) {
            $this->load->model('Export_m');
            $data = $this->Export_m->ajax_Export_marketing_table_data();
            echo json_encode($data, JSON_HEX_QUOT | JSON_HEX_TAG);
            exit();
        }
    }

    private function _send_mail($array){


        foreach($array as $arr){

            $content = "";

            // echo '<pre>', print_r($arr), '<pre>';

            foreach($arr as $ar){
                
                $content .= "Product name: " . $ar['product_name'] . '<br />';
                $content .= "Incoterm: " . $ar["incoterm"] . '<br />';
                $content .= "Price: " . $ar["final_selling_price"] . '('. $ar["currency"] .')<hr />';
                $to = $ar['client_email'];

            }

            $this->sendmail($to,$content,'STS - Welcome to the family!');

        }
       
        return true;
    }

    public function sendmail($mail_to,$msg,$mail_sub='',$mail_from='',$mailer_name='',$smtp_host='',$smtp_port='',$smtp_user='',$smtp_pass='') {

        if($mail_from == '') $mail_from=default_mail_from; else $mail_from=$mail_from;

        if($mailer_name == '') $mailer_name=default_mailer_name; else $mailer_name=$mailer_name;

        if($mail_sub == '') $mail_sub=default_mail_sub; else $mail_sub=$mail_sub;

        if($smtp_host == '') $smtp_host=default_smtp_host; else $smtp_host=$smtp_host;

        if($smtp_port == '') $smtp_port=default_smtp_port; else $smtp_port=$smtp_port;

        if($smtp_user == '') $smtp_user=default_smtp_user; else $smtp_user=$smtp_user;

        if($smtp_pass == '') $smtp_pass=default_smtp_pass; else $smtp_pass=$smtp_pass;



        $config = Array(

            'smtp_host' => $smtp_host,

            'smtp_port' => $smtp_port,

            'smtp_user' => $smtp_user,

            'smtp_pass' => $smtp_pass,

            'protocol' => 'smtp',

            'mailtype' => 'html',

            'charset' => 'utf-8',

            'wordwrap' => TRUE

        );

        $this->load->library('email', $config);



        $this->email->from($mail_from, $mailer_name);

        $this->email->to($mail_to);

        $this->email->subject($mail_sub);

        $this->email->message($msg);

        $this->email->send();

        return true;

    }

}