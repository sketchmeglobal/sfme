<?php

class Dashboard_m extends CI_Model {

    public function __construct() {
        parent::__construct();

        if($this->session->has_userdata('user_id')) { //if logged-in
            $this->user_type = $this->session->usertype;
        }
    }

    public function dashboard() {
	$data = array();
        $data['title'] = 'Home page';
        $data['menu'] = 'dashboard';
        
        #request has been made by the resource developers

        if($this->user_type == 1){
            # trader
            $data['admin_pending_permissions'] = $this->db
                ->select('users.username, firstname,lastname, offers.offer_id, offer_name, offer_number, offer_comments.oc_id, offer_comments.comment')
                ->join('users','users.user_id = offers.resource_id', 'left')
                ->join('user_details','users.user_id = user_details.user_id', 'left')
                ->join('offer_comments','offers.offer_id = offer_comments.offer_id', 'left')
                ->get_where('offers', array('resource_edit_status' => 0, 'offer_comments.status' => 1))->result();


                //echo $this->db->last_query();  die();


                // mar_selling_approval_status 0= not approved 1=approved

                // mar_selling_status 0= not sent to approved 1= sent to approved
            
            $data['marketing_price_update'] = $this->db
                ->select('users.username, firstname,lastname, offers.offer_id, offer_name, offer_number')
                ->join('offer_details','offer_details.od_id = selling_price.od_id', 'left')
                ->join('offers','offers.offer_id = offer_details.offer_id', 'left')
                ->join('assigned_templates','assigned_templates.offer_id = offers.offer_id', 'left')
                ->join('users','users.user_id = assigned_templates.marketing_id', 'left')
                ->join('user_details','users.user_id = user_details.user_id', 'left')
                ->get_where('selling_price', array('selling_price.mar_selling_status' => 1, 'selling_price.mar_selling_approval_status' => 0))->result();

                 //echo $this->db->last_query();  die();    

        }else if($this->user_type == 2){
            # resource
            $data['admin_pending_permissions'] = $this->db
                ->select('users.usertype, users.username, firstname,lastname, offers.offer_id, offer_name, offer_number, offer_comments.oc_id, offer_comments.comment')
                ->join('users','users.user_id = offers.resource_id', 'left')
                ->join('user_details','users.user_id = user_details.user_id', 'left')
                ->join('offer_comments','offers.offer_id = offer_comments.offer_id', 'left')
                ->get_where('offers', array('resource_edit_status' => 1, 'offer_comments.status' => 1, 'users.user_id' => $this->session->user_id, 'users.usertype' => 2))->result();

        }else{
            
            # marketing
            $data['admin_pending_permissions'] = $this->db
                ->select('users.usertype, users.username, firstname,lastname, offers.offer_id, offer_name, offer_number')
                ->join('assigned_templates','assigned_templates.offer_id = offers.offer_id', 'left')
                ->join('users','users.user_id = assigned_templates.marketing_id', 'left')
                ->join('user_details','users.user_id = user_details.user_id', 'left')
                ->where('find_in_set("'.$this->session->user_id.'", assigned_templates.marketing_id) <> 0')
                ->get_where('offers', array('resource_edit_status' => 0, 'final_marketing_approval_status' => 1))->result();
                //echo $this->db->last_query();  die();
            // echo '<pre>', print_r($data), '</pre>';    
        }

        return array('page' => 'dashboard_v', 'data' => $data);
    }


} // /.Dashboard_m model