<?php
class Pricing_m extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function offer_buying_price($offer_id, $od_id) {
        $data['title'] = 'Buying Pricing';
        $data['menu'] = 'Pricing';
        $data['incoterms'] = $this->db->get_where('incoterms', array('status' =>1))->result();
        $data["offer_name"] = $this->db
            ->select("offer_name,offer_number,incoterms.incoterm , currencies.currency, currencies.symbol")
            ->join('incoterms','`incoterms`.`it_id` = `offers`.`incoterm_id`','left')
            ->join('currencies','`currencies`.`c_id` = `offers`.`c_id`','left')          
            ->get_where('offers', array('offer_id' => $offer_id))
            ->result();

        $data["product"] = $this->db
            ->select("product_name,scientific_name,product_price")
            ->join('products','products.pr_id = offer_details.product_id','left')
            ->get_where('offer_details', array('od_id' => $od_id))
            ->result(); 

        $data['currency'] = $this->db->get_where('currencies', array('status' => 1))->result();       
        return $data;
    }

    

    public function fetch_line_items_on_type($type){
        
        $data = $this->db->get_where('line_items', array('status' => 1, 'line_item_category' => $type))->result();
        
        return $data;
    }

    public function add_buying_price(){
        
        // echo $this->input->post('buying_price_submit');die;

        $insertArray = array(
            'od_id' => $this->input->post('od_id'),
            'li_id' => $this->input->post('li_id'),
            'incoterm_id' => $this->input->post('incoterm_id'),
            'currency_id' => $this->input->post('currency_id'),
            'buying_price' => $this->input->post('buying_price'),

            'final_buying_price' => $this->input->post('product_price'),
            
            'user_id' => $this->session->user_id
        );

        if($this->db->insert('buying_price', $insertArray)){
            
            $data['type'] = 'success';
            $data['msg'] = 'Buying Price added successfully'; 

        }else{

            $data['type'] = 'error';
            $data['msg'] = 'Database Error Occured';                 
        }
        return $data;
    }

    public function update_buying_price(){
        
        // echo $this->input->post('buying_price_submit');die;

        if($this->input->post('bp_id') == ''){

            $data['type'] = 'error';
            $data['msg'] = 'Nothing Selected<hr>Select row to update';    

        }else{

            $bp_id = $this->input->post('bp_id');

            $updateArray = array(
                'od_id' => $this->input->post('od_id'),
                'li_id' => $this->input->post('li_id'),
                'incoterm_id' => $this->input->post('incoterm_id'),
                'currency_id' => $this->input->post('currency_id'),
                'buying_price' => $this->input->post('buying_price'),
                'final_buying_price' => $this->input->post('product_price'),
                'user_id' => $this->session->user_id
            );

            if($this->db->update('buying_price', $updateArray, array('bp_id' => $bp_id))){
                
                $data['type'] = 'success';
                $data['msg'] = 'Price Updated successfully'; 

            }else{

                $data['type'] = 'error';
                $data['msg'] = 'Database Error Occured';                 
            }


        }
        return $data;
    }

    public function ajax_buying_price_table_data($od_id) {

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;
        
        //actual db table column names
        $column_orderable = array(
            0 => 'buying_price.offer_id'
        );
        // Set searchable column fields
        $column_search = array('buying_price.li_id');
        
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $rs = $this->_buying_table_common_query($usertype, $user_id, $od_id);

        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $rs = $this->_buying_table_common_query($usertype, $user_id, $od_id);
        }
        //if searching for something
        else {
            $this->db->start_cache();
            // loop searchable columns
            $i = 0;
            foreach($column_search as $item){
                // first loop
                if($i===0){
                    $this->db->group_start(); //open bracket
                    $this->db->like($item, $search);
                }else{
                    $this->db->or_like($item, $search);
                }
                // last loop
                if(count((array)$column_search) - 1 == $i){
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }
            $this->db->stop_cache();

            $rs = $this->_buying_table_common_query($usertype, $user_id, $od_id);

            $totalFiltered = count((array)$rs);

            $rs = $this->_buying_table_common_query($usertype, $user_id, $od_id);

            $this->db->flush_cache();
        }

        $data = array();

        foreach ($rs as $val) {

            // if($val->img){$img='<img src="'.base_url('assets/admin_panel/img/article_img/'.$val->img).'" width="50">';} else{$img='';}
            if($val->status == '1'){$status='Enable';} else{$status='Disable';}
            

            // $nestedData['offer_name'] = $val->offer_name;
            // $nestedData['offer_number'] = $val->offer_number;
            $nestedData['line_item'] = $val->line_item_name;
            $nestedData['incoterm'] = $val->incoterm;
            $nestedData['currency'] = $val->currency . ' ('. $val->symbol .')';
            $nestedData['buying_price'] = $val->buying_price;
            $nestedData['action'] = '
            <a data-bp_id="'.$val->bp_id.'" href="javascript:void(0)" class="btn btn-info buying_price_edit_btn col-xs-6"><i class="fa fa-pencil"></i> Edit</a>
            <a data-bp_id="'.$val->bp_id.'" href="javascript:void(0)" class="btn btn-danger delete col-xs-6"><i class="fa fa-times"></i> Delete</a>
            ';

            $data[] = $nestedData;

            // echo '<pre>', print_r($rs), '</pre>'; 
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return $json_data;
    } 


    private function _buying_table_common_query($usertype, $user_id, $od_id){

        if($usertype == 1){

            #for admin

            $query = "
                SELECT
                `buying_price`.*,
                `line_items`.`line_item_name`,
                `incoterms`.`incoterm`,
                `currencies`.`currency`,
                `currencies`.`symbol`
            FROM
                `buying_price`
            LEFT JOIN `line_items` ON `buying_price`.`li_id` = `line_items`.`li_id`
            LEFT JOIN `incoterms` ON `incoterms`.`it_id` = `buying_price`.`incoterm_id`
            LEFT JOIN `currencies` ON `currencies`.`c_id` = `buying_price`.`currency_id`
            WHERE
                `line_items`.`status` = 1 AND `buying_price`.`od_id` = $od_id
            ORDER BY `incoterms`.`incoterm`    
            ";
            $rs = $this->db->query($query)->result();

            // echo '<pre>', print_r($rs), '</pre>';die;
            // echo $this->db->get_compiled_select('buying_price');
            // exit();

        }else{
            die('Operation died: no permission');
        }

        return $rs;
    }

    /*edit*/
    
    public function fetch_buying_price_on_pk($bp_id){
        
        return $this->db
            ->select('buying_price.*, line_item_category')
            ->join('line_items', 'line_items.li_id = buying_price.li_id', 'left')
            ->get_where('buying_price', array('bp_id' => $bp_id))
            ->result(); 

    }

    public function fetch_offer_products_on_offer_id($offer_id){
        
        return $this->db
            ->select('od_id, product_name, scientific_name')
            ->join('products', 'products.pr_id = offer_details.product_id', 'left')
            ->get_where('offer_details', array('offer_id' => $offer_id))
            ->result(); 

    }

    public function form_export_product_pricing(){
        
        $from_odid = $this->input->post('from_odid');
        $to_odid = $this->input->post('od_id');

        $query = "
            INSERT INTO buying_price(`od_id`,`li_id`,`incoterm_id`,`currency_id`,`buying_price`,`user_id`)
            SELECT
                $to_odid,`li_id`,`incoterm_id`,`currency_id`,`buying_price`,1
            FROM
                buying_price
            WHERE
                od_id = $from_odid
        ";

        if($this->db->query($query)){

            $query1 = "
            INSERT INTO selling_price(`od_id`,`li_id`,`selling_incoterm_id`,`country_id`,`currency_id`,`am_id`,`other_price`,`other_price_comment`,`li_id2`,`other_price2`,`other_price_comment2`,`li_id3`,`other_price3`,`other_price_comment3`,`li_id4`,`other_price4`,`other_price_comment4`,`freight`,`margin_flat`,`margin_percentage`,`final_selling_price`,`mar_selling_rate`,`user_id`)
            SELECT
                $to_odid,`li_id`,`selling_incoterm_id`,`country_id`,`currency_id`,`am_id`,`other_price`,`other_price_comment`,`li_id2`,`other_price2`,`other_price_comment2`,`li_id3`,`other_price3`,`other_price_comment3`,`li_id4`,`other_price4`,`other_price_comment4`,`freight`,`margin_flat`,`margin_percentage`,`final_selling_price`,`mar_selling_rate`,1
            FROM
                selling_price
            WHERE
                od_id = $from_odid
        ";



            if($this->db->query($query1)){
                    $sp_id = $this->db->insert_id();

                

            
            $query2 = "INSERT INTO sell_price_details(`sp_id`,`offer_id`,`od_id`,`country_id`,`am_id`,`currency_id`,`exchange_rate`,`operator`,`user_id`)
            SELECT
                $sp_id,`offer_id`,$to_odid,`country_id`,`am_id`,`currency_id`,`exchange_rate`,`operator`, 1
            FROM
                sell_price_details
            WHERE
                od_id = $from_odid";

                if($this->db->query($query2)){
                    $data['type'] = 'success';
                    $data['msg'] = 'Pricing Exported Successfully.';
                }
            }

        }else{

            $data['title'] = 'Issue-Detected';
            $data['type'] = 'error';
            $data['msg'] = 'Offer Not Exported<hr>Contact Admin';

        }

        return $data;    
    }



    public function form_export_product_selling_pricing(){



        
        $from_odid = $this->input->post('from_odid');

        $to_odid = $this->input->post('od_id');


        $country_wise_od_id = $this->input->post('country_wise_od_id');

        $data = array();
        if($from_odid != $to_odid){

            $selling_price_data = $this->db->get_where('selling_price', array('od_id' => $from_odid))->num_rows();



            if($selling_price_data > 0){

            $buying_price_data_extadd = $this->db->get_where('buying_price', array('od_id' => $to_odid))->num_rows();

            $base_buying_price_data = $this->db->get_where('offer_details', array('od_id' => $to_odid))->row();
            $totalbyuing = 0;
            if ($buying_price_data_extadd > 0) {
                                            $this->db->select('sum(buying_price) as buying_price_ext');
                $buying_price_data_extaddmain = $this->db->get_where('buying_price', array('od_id' => $to_odid))->result();

                $totalbyuing = $base_buying_price_data->product_price + $buying_price_data_extaddmain[0]->buying_price_ext;
            }else{
                $totalbyuing = $base_buying_price_data->product_price;
            }

            

            $selling_price_insert_data = $this->db->get_where('selling_price', array('od_id' => $from_odid))->result();


            

            foreach ($selling_price_insert_data as $key => $row) {


                $insertArray = array();


                $insertArray['od_id'] = $to_odid;

                $insertArray['li_id'] = $row->li_id;
                $insertArray['selling_incoterm_id'] = $row->selling_incoterm_id;
                $insertArray['country_id'] = $row->country_id;
                $insertArray['currency_id'] = $row->currency_id;
                $insertArray['am_id'] = $row->am_id;
                $insertArray['other_price'] = $row->other_price;
                $insertArray['other_price_comment'] = $row->other_price_comment;
                $insertArray['li_id2'] = $row->li_id2;
                $insertArray['other_price2'] = $row->other_price2;
                $insertArray['other_price_comment2'] = $row->other_price_comment2;
                $insertArray['li_id3'] = $row->li_id3;
                $insertArray['other_price3'] = $row->other_price3;
                $insertArray['other_price_comment3'] = $row->other_price_comment3;
                $insertArray['li_id4'] = $row->li_id4;
                $insertArray['other_price4'] = $row->other_price4;
                $insertArray['other_price_comment4'] = $row->other_price_comment4;
                $insertArray['freight'] = $row->freight;
                $insertArray['margin_flat'] = $row->margin_flat;
                $insertArray['margin_percentage'] = $row->margin_percentage;
                $insertArray['final_selling_price'] = ($totalbyuing + $row->margin_flat + $row->freight + $row->other_price +$row->other_price2 + $row->other_price3 + $row->other_price4);
                $insertArray['mar_selling_rate'] = $row->mar_selling_rate;
                $insertArray['user_id'] = 1;

                $this->db->insert('selling_price', $insertArray);
                               
            }
                
            $query1 = "INSERT INTO sell_price_details(`sp_id`,`offer_id`,`od_id`,`country_id`,`am_id`,`currency_id`,`exchange_rate`,`operator`,`user_id`)
            SELECT
                $country_wise_od_id,`offer_id`,$to_odid,`country_id`,`am_id`,`currency_id`,`exchange_rate`,`operator`, 1
            FROM
                sell_price_details
            WHERE
                od_id = $from_odid";
            if($this->db->query($query1)){
                $data['type'] = 'success';
                $data['msg'] = 'Pricing Exported Successfully.';
            }

                

        }else{

            $data['type'] = 'error';
            $data['msg'] = 'Selling price not set for this product. At first set selling price';
        }
    }

        return $data;    
    }


    /*delete*/

    public function ajax_delete_buying_price($bp_id){
        
        $this->db->where('bp_id', $bp_id)->delete('buying_price');

        $data['title'] = 'Deleted!';
        $data['type'] = 'success';
        $data['msg'] = 'Buying price deleted successfully';

        return $data;

    }
// *************************************

// Selling Price

    public function offer_selling_price($offer_id, $od_id) {

    $buying_price_data = $this->db->get_where('buying_price', array('od_id' => $od_id))->num_rows();

    if($buying_price_data == 0){

        $this->session->set_flashdata('type', 'error');

        $this->session->set_flashdata('msg', 'Buying price not set. At first set buying price');

        return redirect(base_url('admin/edit-offer/'.$offer_id));
    }

        $data['title'] = 'Seling Pricing';
        $data['menu'] = 'Pricing';
        $data['incoterms'] = $this->db->get_where('incoterms', array('status' =>1))->result();
        $data["offer_name"] = $this->db
            ->select("offer_name, offer_number, incoterms.incoterm, currencies.currency, currencies.symbol")
            ->join('incoterms','`incoterms`.`it_id` = `offers`.`incoterm_id`','left')
            ->join('currencies','`currencies`.`c_id` = `offers`.`c_id`','left')
            ->get_where('offers', array('offer_id' => $offer_id))
            ->result();
        $data["product"] = $this->db
            ->select("product_name,scientific_name,product_price")
            ->join('products','products.pr_id = offer_details.product_id','left')
            ->get_where('offer_details', array('od_id' => $od_id))
            ->result(); 
        $data["final_buying_price"] = $this->db
            ->select("SUM(buying_price) as final_buying_price")
            ->get_where('buying_price', array('od_id' => $od_id))
            ->result();       
        $data['country'] = $this->db->get_where('countries', array('status' => 1))->result(); 

        //$data['ports'] = $this->db->get_where('ports', array('status' => 1))->result();
        $data['currency'] = $this->db->get_where('currencies', array('status' => 1))->result();       
        $data['acc_master'] = $this->db->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 1))->result(); 
        return $data;

    }

    public function add_country_wise_selling_price(){



        /*print_r($this->input->post());

        die();*/
        
        $insertArray = array(
            'offer_id' => $this->input->post('country_wise_offer_id'),
            'od_id' => $this->input->post('country_wise_od_id'),
            'sp_id'=> $this->input->post('country_wise_od_id'),
            'country_id' => $this->input->post('country_wise_country_id'),
            'am_id' => $this->input->post('country_wise_acc_master'),
            'operator' => $this->input->post('operator'),
            'currency_id' => $this->input->post('country_wise_currency_id'),
            'exchange_rate' => $this->input->post('exchange_rate'),
            'user_id' => $this->session->user_id
        );

        // echo '<pre>' , print_r($insertArray), '</pre>';

        if($this->db->insert('sell_price_details', $insertArray)){
            
            $data['type'] = 'success';
            $data['msg'] = 'Selling Price added successfully'; 

        }else{

            $data['type'] = 'error';
            $data['msg'] = 'Database Error Occured';                 
        }
        return $data;

    }

    public function ajax_selling_price_table_data($od_id) {

        // echo $od_id; die;

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;
        
        //actual db table column names
        $column_orderable = array(
            0 => 'selling_price.selling_incoterm_id'
        );
        // Set searchable column fields
        $column_search = array('selling_price.country_id, selling_price.am_id');
        
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $rs = $this->_selling_table_common_query($usertype, $user_id, $od_id);

        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $rs = $this->_selling_table_common_query($usertype, $user_id, $od_id);
        }
        //if searching for something
        else {
            $this->db->start_cache();
            // loop searchable columns
            $i = 0;
            foreach($column_search as $item){
                // first loop
                if($i===0){
                    $this->db->group_start(); //open bracket
                    $this->db->like($item, $search);
                }else{
                    $this->db->or_like($item, $search);
                }
                // last loop
                if(count((array)$column_search) - 1 == $i){
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }
            $this->db->stop_cache();

            $rs = $this->_selling_table_common_query($usertype, $user_id, $od_id);

            $totalFiltered = count((array)$rs);

            $rs = $this->_selling_table_common_query($usertype, $user_id, $od_id);

            $this->db->flush_cache();
        }

        $data = array();



        foreach ($rs as $val) {

            $nestedData['selling_incoterm'] = $val->selling_incoterm;
            $nestedData['country_name'] = 'All';
            $nestedData['currency_name'] = $val->currency_name;
            $nestedData['customer_name'] = 'All';
            $nestedData['margin_flat'] = $val->margin_flat;
            $nestedData['margin_percentage'] = $val->margin_percentage;
            $nestedData['freight'] = $val->freight;
            
            $nestedData['line_item_name'] = $val->line_item_name;
            $nestedData['other_price'] = $val->other_price;
            $nestedData['other_price_comment'] = $val->other_price_comment;
            
            $nestedData['line_item_name2'] = $val->line_item_name2;
            $nestedData['other_price2'] = $val->other_price2;
            $nestedData['other_price_comment2'] = $val->other_price_comment2;
            
            $nestedData['line_item_name3'] = $val->line_item_name3;
            $nestedData['other_price3'] = $val->other_price3;
            $nestedData['other_price_comment3'] = $val->other_price_comment3;

            $nestedData['line_item_name4'] = $val->line_item_name4;
            $nestedData['other_price4'] = $val->other_price4;
            $nestedData['other_price_comment4'] = $val->other_price_comment4;

            $nestedData['final_selling_price'] = $val->final_selling_price;
            $nestedData['action'] = '
            <a data-sp_id="'.$val->sp_id.'" href="javascript:void(0)" class="btn btn-info selling_price_edit_btn col-xs-6"><i class="fa fa-pencil"></i> Edit</a>
            <a data-sp_id="'.$val->sp_id.'" href="javascript:void(0)" class="btn btn-danger delete col-xs-6"><i class="fa fa-times"></i> Delete</a>
            ';

            $data[] = $nestedData;

            // echo '<pre>', print_r($rs), '</pre>'; 
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return $json_data;
    } 

    private function _selling_table_common_query($usertype, $user_id, $od_id){

        if($usertype == 1){

            #for admin

            $query = "
                SELECT
                `selling_price`.*,
                CONCAT(countries.name, ' [', countries.iso3,']') AS country_name,
                CONCAT(currencies.currency, ' [', currencies.symbol,']') AS currency_name,
                CONCAT(acc_master.name, ' [', acc_master.am_code ,']') AS customer_name, li1.line_item_name, li2.line_item_name as line_item_name2, li3.line_item_name as line_item_name3, li4.line_item_name as line_item_name4, incoterms.incoterm AS selling_incoterm
                
                FROM `selling_price`

                LEFT JOIN `countries` ON countries.country_id = selling_price.country_id
                LEFT JOIN `currencies` ON currencies.c_id = selling_price.currency_id
                LEFT JOIN `acc_master` ON acc_master.am_id = selling_price.am_id

                LEFT JOIN `line_items` li1 ON li1.li_id = selling_price.li_id
                LEFT JOIN `line_items` li2 ON li2.li_id = selling_price.li_id2
                LEFT JOIN `line_items` li3 ON li3.li_id = selling_price.li_id3
                LEFT JOIN `line_items` li4 ON li4.li_id = selling_price.li_id4

                LEFT JOIN incoterms ON  incoterms.it_id = selling_price.selling_incoterm_id
                WHERE selling_price.od_id = $od_id
                ORDER BY selling_price.selling_incoterm_id
            ";
            $rs = $this->db->query($query)->result();
           
            // echo $this->db->last_query();

            // echo '<pre>', print_r($rs), '</pre>';die;
            // echo $this->db->get_compiled_select('selling_price');
            // exit();

        }else{
            die('Operation died: no permission');
        }

        return $rs;
    }

    public function ajax_selling_price_details_table_data($offer_id, $od_id) {

        // echo $od_id; die;

        $usertype = $this->session->usertype;
        $user_id = $this->session->user_id;
        
        //actual db table column names
        $column_orderable = array(
            0 => 'sell_price_details.spd_id'
        );
        // Set searchable column fields
        $column_search = array('sell_price_details.country_id, sell_price_details.am_id');
        
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        
        $order = $column_orderable[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $search = $this->input->post('search')['value'];

        $rs = $this->_selling_table_details_common_query($usertype, $offer_id, $od_id);

        $totalData = count((array)$rs);
        $totalFiltered = $totalData;

        //if not searching for anything
        if(empty($search)) {
            $this->db->limit($limit, $start);
            $this->db->order_by($order, $dir);

            $rs = $this->_selling_table_details_common_query($usertype, $offer_id, $od_id);
        }
        //if searching for something
        else {
            $this->db->start_cache();
            // loop searchable columns
            $i = 0;
            foreach($column_search as $item){
                // first loop
                if($i===0){
                    $this->db->group_start(); //open bracket
                    $this->db->like($item, $search);
                }else{
                    $this->db->or_like($item, $search);
                }
                // last loop
                if(count((array)$column_search) - 1 == $i){
                    $this->db->group_end(); //close bracket
                }
                $i++;
            }
            $this->db->stop_cache();

            $rs = $this->_selling_table_details_common_query($usertype, $offer_id, $od_id);

            $totalFiltered = count((array)$rs);

            $rs = $this->_selling_table_details_common_query($usertype,$offer_id, $od_id);

            $this->db->flush_cache();
        }

        $data = array();



        foreach ($rs as $val) {

            $nestedData['country_name'] = $val->country_name;
            $nestedData['currency_name'] = $val->currency_name;
            $nestedData['customer_name'] = $val->customer_name;
            $nestedData['exchange_rate'] = $val->exchange_rate;
            $nestedData['approved_rate'] = $this->_show_final_approved_rate($val->od_id);
            $nestedData['marketing_price'] = $this->_show_admin_marketing_price($val->offer_id, $val->operator, $val->od_id, $val->exchange_rate);
            $nestedData['action'] = '<a data-sp_id="'.$val->spd_id.'" href="javascript:void(0)" class="btn btn-info  selling_price_details_edit_btn col-xs-5"><i class="fa fa-pencil"></i> Edit</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a data-sp_id="'.$val->spd_id.'" href="javascript:void(0)" class="btn btn-danger delete_details col-xs-5"><i class="fa fa-times"></i> Delete</a>';

            $data[] = $nestedData;

            // echo '<pre>', print_r($rs), '</pre>'; 
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        return $json_data;
    }

    private function _selling_table_details_common_query($usertype,$offer_id, $od_id){

        if($usertype == 1){

            #for admin

            $query = "
                SELECT
                `sell_price_details`.*,
                CONCAT(countries.name, ' [', countries.iso3,']') AS country_name,
                CONCAT(currencies.currency, ' [', currencies.symbol,']') AS currency_name,
                CONCAT(acc_master.name, ' [', acc_master.am_code ,']') AS customer_name
                
                FROM `sell_price_details`

                LEFT JOIN `countries` ON countries.country_id = sell_price_details.country_id
                LEFT JOIN `currencies` ON currencies.c_id = sell_price_details.currency_id
                LEFT JOIN `acc_master` ON acc_master.am_id = sell_price_details.am_id

                WHERE sell_price_details.od_id = $od_id
                AND sell_price_details.offer_id = $offer_id

            ";
            $rs = $this->db->query($query)->result();
           
            // echo $this->db->last_query();

            // echo '<pre>', print_r($rs), '</pre>';die;
            // echo $this->db->get_compiled_select('selling_price');
            // exit();

        }else{
            die('Operation died: no permission');
        }

        return $rs;
    }

    private function _show_final_approved_rate($od_id){

        $this->db->reset_query();

        $query = "
        SELECT
            GROUP_CONCAT(
                `incoterm`,
                ': ',
                final_selling_price SEPARATOR '<br>'
            ) AS fsp
        FROM
            (
            SELECT
                `incoterms`.`incoterm`, 
                IF( mar_selling_approval_status = 1, mar_selling_rate, final_selling_price) as final_selling_price
            FROM
                `selling_price`
            LEFT JOIN `incoterms` ON `incoterms`.`it_id` = `selling_price`.`selling_incoterm_id`
            WHERE
                `od_id` = $od_id
            ORDER BY
                `sp_id` ASC
        ) AS derived";

        $rs = $this->db->query($query)->result();

        if (isset($rs[0])){
            return $rs[0]->fsp;
        } else{
            return '-';
        }

        // echo $this->db->last_query(); die;    
        // echo $this->db->get_compiled_select('selling_price'); die();
    }

    private function _show_admin_marketing_price($offer_id, $operator, $od_id, $exchange_rate){
        //$operator = (empty($operator) || $operator == '')?'*':$operator;
        $this->db->reset_query();

        $query = "
        SELECT
            GROUP_CONCAT(
                `incoterm`,
                ': ',
                TRUNCATE(final_selling_price,2) SEPARATOR '<br>'
            ) AS fsp
        FROM
            (
            SELECT
                `incoterms`.`incoterm`,
                IF( mar_selling_approval_status = 1, mar_selling_rate $operator $exchange_rate, final_selling_price $operator $exchange_rate) as final_selling_price
            FROM
                `selling_price`
            LEFT JOIN `incoterms` ON `incoterms`.`it_id` = `selling_price`.`selling_incoterm_id`
            WHERE
                `od_id` = $od_id
            ORDER BY
                `sp_id` ASC
        ) AS derived";

        $rs = $this->db->query($query)->result();

        if (isset($rs[0])){
            return $rs[0]->fsp;
        } else{
            return '-';
        }

        // echo $this->db->last_query(); die;    
        // echo $this->db->get_compiled_select('selling_price'); die();
    }

    public function add_selling_price(){
        
        if(count((array)$this->input->post('acc_masters[]')) > 0){
            $am = join(',',$this->input->post('acc_masters[]'));
        }else{
            $am = '';
        }

        $final_selling_price = ($this->input->post('product_price') + $this->input->post('freight') + $this->input->post('margin_flat') + $this->input->post('other_price') + $this->input->post('other_price2') + $this->input->post('other_price3') + $this->input->post('other_price4'));

        $insertArray = array(
            'od_id' => $this->input->post('od_id'),
            'selling_incoterm_id' => $this->input->post('selling_incoterm_id'),
            'country_id' => $this->input->post('country_id'),
            'currency_id' => $this->input->post('currency_id'),
            'am_id' => $am,

            'li_id' => $this->input->post('li_id'),
            'other_price' => $this->input->post('other_price'),
            'other_price_comment' => $this->input->post('other_cost_comment'),
            'li_id2' => $this->input->post('li_id2'),
            'other_price2' => $this->input->post('other_price2'),
            'other_price_comment2' => $this->input->post('other_cost_comment2'),
            'li_id3' => $this->input->post('li_id3'),
            'other_price3' => $this->input->post('other_price3'),
            'other_price_comment3' => $this->input->post('other_cost_comment3'),
            'li_id4' => $this->input->post('li_id4'),
            'other_price4' => $this->input->post('other_price4'),
            'other_price_comment4' => $this->input->post('other_cost_comment4'),

            'freight' => $this->input->post('freight'),
            'margin_flat' => $this->input->post('margin_flat'),
            'margin_percentage' => $this->input->post('margin_percentage'),
            'final_selling_price' => $final_selling_price,
            'user_id' => $this->session->user_id
        );

        if($this->db->insert('selling_price', $insertArray)){
            $data['type'] = 'success';
            $data['msg'] = 'Selling Price added successfully'; 

        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Database Error Occured' . $this->db->last_query();
        }
        return $data;
    }






    public function fetch_selling_price_on_pk($sp_id){
        
         $query = "
                SELECT
                incoterms.it_id as selling_incoterm_id,
                countries.country_id,currencies.c_id as currency_id,
                acc_master.am_id, li1.li_id, li1.line_item_category, 
                li2.li_id as li_id2, li2.line_item_category as line_item_category2, li3.li_id as li_id3, 
                li3.line_item_category as line_item_category3, li4.li_id as li_id4, li4.line_item_category as line_item_category4, 
                selling_price.*

                FROM `selling_price`

                LEFT JOIN `countries` ON countries.country_id = selling_price.country_id
                LEFT JOIN `currencies` ON currencies.c_id = selling_price.currency_id
                LEFT JOIN `acc_master` ON acc_master.am_id = selling_price.am_id
                LEFT JOIN `line_items` li1 ON li1.li_id = selling_price.li_id
                LEFT JOIN `line_items` li2 ON li2.li_id = selling_price.li_id2
                LEFT JOIN `line_items` li3 ON li3.li_id = selling_price.li_id3
                LEFT JOIN `line_items` li4 ON li4.li_id = selling_price.li_id4
                LEFT JOIN incoterms ON  incoterms.it_id = selling_price.selling_incoterm_id
                
                WHERE selling_price.sp_id = $sp_id
            ";

            $rs = $this->db->query($query)->result();

            // echo $this->db->last_query();die;

            return $rs;

    }

    public function update_selling_price(){
        
        // echo $this->input->post('buying_price_submit');die;


        //echo $this->input->post('sp_id'); die();

        if($this->input->post('sp_id') == ''){

            $data['type'] = 'error';
            $data['msg'] = 'Nothing Selected<hr>Select row to update';    

        }else{

            $sp_id = $this->input->post('sp_id');
            if(count((array)$this->input->post('acc_masters[]')) > 0){
                $am = join(',',$this->input->post('acc_masters[]'));
            }else{
                $am = '';
            }

            $final_selling_price = ($this->input->post('product_price') + $this->input->post('freight') + $this->input->post('margin_flat') + $this->input->post('other_price') + $this->input->post('other_price2') + $this->input->post('other_price3') + $this->input->post('other_price4'));

            $updateArray = array(
                
                'od_id' => $this->input->post('od_id'),
                'selling_incoterm_id' => $this->input->post('selling_incoterm_id'),
                'country_id' => $this->input->post('country_id'),
                'currency_id' => $this->input->post('currency_id'),
                'am_id' => $am,

                'li_id' => $this->input->post('li_id'),
                'other_price' => $this->input->post('other_price'),
                'other_price_comment' => $this->input->post('other_cost_comment'),
                'li_id2' => $this->input->post('li_id2'),
                'other_price2' => $this->input->post('other_price2'),
                'other_price_comment2' => $this->input->post('other_cost_comment2'),
                'li_id3' => $this->input->post('li_id3'),
                'other_price3' => $this->input->post('other_price3'),
                'other_price_comment3' => $this->input->post('other_cost_comment3'),
                'li_id4' => $this->input->post('li_id4'),
                'other_price4' => $this->input->post('other_price4'),
                'other_price_comment4' => $this->input->post('other_cost_comment4'),

                'freight' => $this->input->post('freight'),
                'margin_flat' => $this->input->post('margin_flat'),
                'margin_percentage' => $this->input->post('margin_percentage'),
                'final_selling_price' => $final_selling_price,

                'mar_selling_rate' => 0,
                'mar_selling_status' => 0,

                'user_id' => $this->session->user_id

            );

            // echo '<pre>',print_r($updateArray),'</pre>'; die;

            if($this->db->update('selling_price', $updateArray, array('sp_id' => $sp_id))){
                
                $data['type'] = 'success';
                $data['msg'] = 'Price Updated successfully'; 

            }else{

                $data['type'] = 'error';
                $data['msg'] = 'Database Error Occured';                 
            }


        }
        return $data;
    }


    public function ajax_delete_selling_price($sp_id){
        
        $this->db->where('sp_id', $sp_id)->delete('selling_price');

        $data['title'] = 'Deleted!';
        $data['type'] = 'success';
        $data['msg'] = 'Buying price deleted successfully';

        return $data;

    }

    public function ajax_delete_selling_price_details($spd_id){
        
        $this->db->where('spd_id', $spd_id)->delete('sell_price_details');
        
        // echo $this->db->last_query(); die;
        
        $data['title'] = 'Deleted!';
        $data['type'] = 'success';
        $data['msg'] = 'Buying price details deleted successfully';

        return $data;

    }


    public function task_add()
    {
        $taskinsertArray = array();
         $taskinsertArray['TaskName']  = $this->input->post('task_name');



         $taskinsertArray['shift']  = $this->input->post('shift');


         $taskinsertArray['particular_category']  = $this->input->post('particular_category');

         $taskinsertArray['sector']  = $this->input->post('sector');

         $taskinsertArray['emp']  = $this->input->post();


         $taskinsertArray['weight']  = $this->input->post();

         $taskinsertArray['custom_time']  = $this->input->post();


          
 

         

    }

// Pricing ENDS 

}