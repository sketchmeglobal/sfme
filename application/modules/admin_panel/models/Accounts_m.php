<?php
class Accounts_m extends CI_Model {

	public function __construct() {
		parent::__construct();
        $this->load->library('user_agent');
        $this->db->query("SET sql_mode = ' ' ");

	}

	public function proforma_invoice() {
		$user_id = $this->session->user_id;

		try {
			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(base_url('admin_panel/Accounts/proforma_invoice'));
			$crud->set_theme('flexigrid');
			$crud->set_subject('Sale Contract');
			$crud->set_table('proforma_invoices');

			$crud->unset_read();
			$crud->unset_clone();

            $crud->unset_add();

            $crud->unset_edit();
             $crud->add_action('Edit Sale Contract', '', '', 'fa fa-pencil vewofr',array($this,'_callback_webpage_url_edit_sale_contract'));
			$crud->set_relation('offer', 'offers', '{offer_name} - {offer_number}');
			$crud->set_relation('sold_to_party', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
			$crud->set_relation('consignee_name', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
			$crud->set_relation('destination_port', 'ports', 'port_name');
			$crud->set_relation('port_of_shipment', 'ports', 'port_name');

			$crud->columns('pi_number', 'pi_date', 'offer', 'sold_to_party');
			$crud->unset_fields('status', 'created_date', 'modified_date');


                
			$crud->add_action('Print Sale Contract', '', '', 'fa fa-print p_modal', array($this, '_callback_webpage_url_print_sale_contract'));

			$this->table_name = 'proforma_invoices';
			$crud->callback_before_update(array($this, 'log_before_update'));

			$output = $crud->render();

			//rending extra value to $output
			$output->tab_title = 'Sale Contract';
			$output->section_heading = 'Sale Contract <small>(Add / Edit / Delete)</small>';
			$output->menu_name = 'Offer Proforma';
			$output->add_button = '<a href="'.base_url('admin/add_sale_contract').'" class="btn btn-success ">Add Sale Contarct</a>';

			return array('page' => 'accounts/sale_contract_list_v', 'data' => $output); //loading common view page

		} catch (Exception $e) {
			show_error($e->getMessage() . '<br>' . $e->getTraceAsString());
		}
	}


	public function purchase_order() {
		$user_id = $this->session->user_id;

		try {
			$crud = new grocery_CRUD();
			$crud->set_crud_url_path(base_url('admin_panel/Accounts/purchase_order'));
			$crud->set_theme('flexigrid');
			$crud->set_subject('Purchase Order');
			$crud->set_table('purchase_order');

			$crud->unset_read();
			$crud->unset_clone();

            $crud->unset_add();

            $crud->unset_edit();
             $crud->add_action('Edit PO', '', '', 'fa fa-pencil vewofr',array($this,'_callback_webpage_url_edit_purchase_order'));
			$crud->set_relation('offer', 'offers', '{offer_name} - {offer_number}');
			$crud->set_relation('sold_to_party_id', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
			$crud->set_relation('order_to_id', 'acc_master', '{name} - {am_code}');
			$crud->set_relation('consignee_id', 'acc_master', '{name} - {am_code}', array('supplier_buyer' => 1));
			$crud->set_relation('destination_port', 'ports', 'port_name');
			$crud->set_relation('port_of_shipment', 'ports', 'port_name');

			$crud->columns('po_number', 'po_date', 'offer', 'sold_to_party_id','order_to_id');
			$crud->unset_fields('status', 'created_date', 'modified_date');
			
			$crud->add_action('Print PO', '', '', 'fa fa-print vewofr', array($this, '_callback_webpage_url_print_purchase_order'));
			
			$crud->display_as('sold_to_party_id' , 'Sold To Party');
			$crud->display_as('order_to_id' , 'Order To');

			$this->table_name = 'purchase_order';
			$crud->callback_before_update(array($this, 'log_before_update'));

			$output = $crud->render();

			//rending extra value to $output
			$output->tab_title = 'Purchase Order';
			$output->section_heading = 'Purchase Order <small>(Add / Edit / Delete)</small>';
			$output->menu_name = 'Purchase Order';
			$output->add_button = '<a href="'.base_url('admin/purchase_order_add').'" class="btn btn-success ">Add Purchase Order</a>';

			return array('page' => 'accounts/purchase_order_list_v', 'data' => $output); //loading common view page

		} catch (Exception $e) {
			show_error($e->getMessage() . '<br>' . $e->getTraceAsString());
		}
	}


	public function _callback_webpage_url_edit_purchase_order($value, $row)
	{
		return site_url('admin/edit_purchase_order/' . $row->po_id);
	}

    

    public function _callback_webpage_url_edit_sale_contract($value, $row) {

        return site_url('admin/edit_sale_contract/' . $row->pi_id);


    }

	public function _callback_webpage_url_print_sale_contract($value, $row) {

		/* echo "<pre>";
			        print_r($row);
		*/
		//return "<a href='".site_url('admin/view-offer/'.$row->offer_id.'/comp1')."' target='_blank'>View Offer</a>";
		return site_url('admin/show_sc_template/' . $row->pi_id);
	}


	public function _callback_webpage_url_print_purchase_order($value, $row)
	{
		return site_url('admin/show_po_template/' . $row->po_id);
	}


    public function add_sale_contract()
    {

        $data = array();
        $data['title'] = 'Add Sale Contract';
        $data['offer_list'] = $this->db->get('offers')->result();
        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['port_list'] = $this->db->get('ports')->result();
        $data['company'] = $this->db->get('company')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();
        $data['payment_terms'] = $this->db->get('payment_terms')->result();
        // $data['all_clauses'] = $this->db->where('clause_segment', 'PI')->or_where('clause_segment', 'COMMON')->get('all_clauses')->result();
        $data['pin'] = $this->db->query("select * from proforma_invoices order BY created_date desc")->row()->pi_number;
        
        // print_r($data['all_clauses']);
        
        return array('page' => 'accounts/sale_contract_form', 'data' => $data);
    }

    public function form_add_sale_contract()
    {

        //return $this->input->post();
        $data = array();
        $bank_id = join(",",$this->input->post('bank_id[]'));

        $lab_report_clauses = json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 
        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 

        $insertArray = array(
            'company_id' => $this->input->post('company_id'),
            'pi_number' => $this->input->post('pi_number'),
            'pi_date' => $this->input->post('pi_date'),
            'offer' => $this->input->post('offer_id'),
            'sold_to_party' => $this->input->post('sold_to_party_id'),
            'order_to_id' => $this->input->post('order_to_id'),
            'order_to_contact' => $this->input->post('order_to_contact'),
            'consignee_name' => $this->input->post('consignee_name'),
            'destination_port' => $this->input->post('destination_port'),
            'port_of_shipment' => $this->input->post('port_of_shipment'),
            'transhipment' => $this->input->post('transhipment'),
            'partial_shipment' => $this->input->post('partial_shipment'),
            'label_document' => $this->input->post('label_document'),
            'bank_id' => $bank_id,
            'lab_report_clauses' => $lab_report_clauses,
            'label' => $lbl,
            'payment_terms' => $this->input->post('payment_terms'),
            'your_ref' => $this->input->post('your_ref'),
            'add_info' => $this->input->post('add_info'),
            'add_info2' => $this->input->post('add_info2'),
            'authorised_signatory' => $this->input->post('authorised_signatory'),
            'accepted_by' => $this->input->post('accepted_by'),
            'tax' => $this->input->post('tax')
        );
       
        if ($this->db->insert('proforma_invoices', $insertArray)) {
            $data['type'] = 'success';
            $data['msg'] = 'Data added successfully';
        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Oops! somthing went wrong. Please try again' . $this->db->last_query();
        }

        return $data;
    }

    public function purchase_order_add()
    {

        $data = array();


        $data['title'] = 'Add Purchase Order';
        $data['offer_list'] = $this->db->get('offers')->result();
        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to'] = $this->db->select('am_id, name, am_code')->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 0))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        
        $data['port_list'] = $this->db->get('ports')->result();
        $data['company'] = $this->db->get('company')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();
        $data['pon'] = $this->db->query("select * from purchase_order order BY created_date desc")->row()->po_number;
        $data['payment_terms'] = $this->db->get('payment_terms')->result();

        return array('page' => 'accounts/purchase_order_add_v', 'data' => $data);
    }
    
    public function form_add_purchase_order()
    {

        $data = array();
        //$bank_id = join(",",$this->input->post('bank_id[]'));

        $lab_report_clauses =  json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG);

        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG);

        $insertArray = array(
                'company_id' => $this->input->post('company_id'),
                'po_number' => $this->input->post('po_number'),
                'po_date' => $this->input->post('po_date'),
                'offer' => $this->input->post('offer_id'),
                'tax' => $this->input->post('tax'),
                'your_ref' => $this->input->post('your_ref'),
                'order_to_id' => $this->input->post('order_to_id'),
                'order_to_contact' => $this->input->post('order_to_contact'),
                'sold_to_party_id' => $this->input->post('sold_to_party_id'),
                'consignee_id' => $this->input->post('consignee_id'),
                'destination_port' => $this->input->post('destination_port'),
                'port_of_shipment' => $this->input->post('port_of_shipment'),
                'transhipment' => $this->input->post('transhipment'),
                'partial_shipment' => $this->input->post('partial_shipment'),
                'label_document' => $this->input->post('label_document'),
                //'bank_id' => $bank_id,
                'lab_report_clauses' => $lab_report_clauses,
                'lbl' => $lbl,
                
                'authorised_signatory' => $this->input->post('authorised_signatory'),
                'add_info2' => $this->input->post('add_info2'),
                'accepted_by' => $this->input->post('accepted_by'),
                'add_info' => $this->input->post('add_info')
        );
        
        if ($this->db->insert('purchase_order', $insertArray)) {
            $data['type'] = 'success';
            $data['msg'] = 'Data added successfully';
        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Oops! somthing went wrong. Please try again';
        }

        return $data;
    }

    public function edit_purchase_order($id)
    {
        $data = array();
        $data['title'] = 'Edit Purchase Order';
        $data['offer_list'] = $this->db->get('offers')->result();
        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 1))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('status' => 1, 'supplier_buyer' => 1))->result();
        $data['order_to'] = $this->db->select('am_id, name, am_code')->get_where('acc_master', array('status' => 1))->result(); //, 'supplier_buyer' => 0
        $data['port_list'] = $this->db->get('ports')->result();
        $data['company'] = $this->db->get('company')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();
        $data['purchase_order_data'] = $this->db->get_where('purchase_order', array('po_id' => $id))->row();

        return array('page' => 'accounts/purchase_order_edit_v', 'data' => $data);
    }
    
    public function form_edit_purchase_order()
    {

        $po_id =  $this->input->post('po_id');
        $data = array();

       /* echo "<pre>";
        print_r($this->input->post('lab_report_clauses[]'));
        die();*/

        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 
        $lab_report_clauses = json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 

       //die();

        $updateArray = array(
                'company_id' => $this->input->post('company_id'),
                'po_number' => $this->input->post('po_number'),
                'po_date' => $this->input->post('po_date'),
                'offer' => $this->input->post('offer_id'),
                
                'tax' => $this->input->post('tax'),
                'your_ref' => $this->input->post('your_ref'),
                'order_to_id' => $this->input->post('order_to_id'),
                'order_to_contact' => $this->input->post('order_to_contact'),
                
                'sold_to_party_id' => $this->input->post('sold_to_party_id'),
                'consignee_id' => $this->input->post('consignee_id'),
                'destination_port' => $this->input->post('destination_port'),
                'port_of_shipment' => $this->input->post('port_of_shipment'),
                
                'transhipment' => $this->input->post('transhipment'),
                'partial_shipment' => $this->input->post('partial_shipment'),
                'label_document' => $this->input->post('label_document'),
                'lab_report_clauses' => $lab_report_clauses,
                'lbl' => $lbl,
                
                'authorised_signatory' => $this->input->post('authorised_signatory'),
                'add_info' => $this->input->post('add_info'),
                'add_info2' => $this->input->post('add_info2'),
                'accepted_by' => $this->input->post('accepted_by')
                
        );
        
        if ($this->db->update('purchase_order', $updateArray, array('po_id' => $po_id))) {
            $data['type'] = 'success';
            $data['msg'] = 'Data updated successfully';
        }else{
            $data['type'] = 'error';
            $data['msg'] = $this->db->error();
        }

        return $data;
    }

    public function edit_sale_contract($id)
    {
        $data = array();
        $data['title'] = 'Edit Sale Contract';
        $data['offer_list'] = $this->db->get('offers')->result();

        $data['sold_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['order_to_party_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();
        $data['consignee_name_list'] = $this->db->get_where('acc_master', array('supplier_buyer' => 1))->result();

        $data['port_list'] = $this->db->get('ports')->result();

        $data['company'] = $this->db->get('company')->result();
        $data['payment_terms'] = $this->db->get('payment_terms')->result();
        $data['banklist'] = $this->db->get('bank_master')->result();

        $data['sale_contract_data'] = $this->db->get_where('proforma_invoices', array('pi_id' => $id))->row();

        //echo "<pre>"; print_r($data['sale_contract_data']); die();

        return array('page' => 'accounts/sale_contract_form_edit_v', 'data' => $data);
    }
    
    public function form_edit_sale_contract()
    {
       // echo "<pre>"; print_r($this->input->post()); die(); //lbl
        $pi_id =  $this->input->post('pi_id');
        $data = array();
        $bank_id = $this->input->post('bank_id[]');

        $bank_id  = join(",",$bank_id);

        $lab_report_clauses = json_encode($this->input->post('lab_report_clauses[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 

        $lbl = json_encode($this->input->post('lbl[]'), JSON_HEX_QUOT | JSON_HEX_TAG); 

        $updateArray = array(
            'company_id' => $this->input->post('company_id'),
            'pi_number' => $this->input->post('pi_number'),
            'pi_date' => $this->input->post('pi_date'),
            'offer' => $this->input->post('offer_id'),
            'sold_to_party' => $this->input->post('sold_to_party_id'),
            'order_to_id' => $this->input->post('order_to_id'),
            'order_to_contact' => $this->input->post('order_to_contact'),
            'consignee_name' => $this->input->post('consignee_name'),
            'destination_port' => $this->input->post('destination_port'),
            'port_of_shipment' => $this->input->post('port_of_shipment'),
            'transhipment' => $this->input->post('transhipment'),
            'partial_shipment' => $this->input->post('partial_shipment'),
            'label_document' => $this->input->post('label_document'),
            'bank_id' => $bank_id,
            'lab_report_clauses' => $lab_report_clauses,
            'label' => $lbl,
            'payment_terms' => $this->input->post('payment_terms'),
            'your_ref' => $this->input->post('your_ref'),
            'add_info' => $this->input->post('add_info'),
            'add_info2' => $this->input->post('add_info2'),
            'authorised_signatory' => $this->input->post('authorised_signatory'),
            'accepted_by' => $this->input->post('accepted_by'),
            'tax' => $this->input->post('tax')
        );


        //echo "<pre>"; print_r($lab_report_clauses); die();
        
        if ($this->db->update('proforma_invoices', $updateArray, array('pi_id' => $pi_id))) {
            $data['type'] = 'success';
            $data['msg'] = 'Data updated successfully'; 
            // . $this->db->last_query();
        }else{
            $data['type'] = 'error';
            $data['msg'] = 'Oops! somthing went wrong. Please try again';
        }

        return $data;
    }
    
    public function ajax_clause_on_customer(){
        
        $cid = $this->input->get('cid'); 
        return $this->db->get_where('all_clauses', array('customer_id' => $cid))->result();
        
    }
    
	public function log_before_update($post_array, $primary_key) {
		$insertArray = array(
			'table_name' => $this->table_name,
			'pk_id' => $primary_key,
			'action_taken' => 'edit',
			'old_data' => json_encode($post_array),
			'user_id' => $this->session->user_id,
			'comment' => '-',
		);
		if ($this->db->insert('user_logs', $insertArray)) {
			return true;
		} else {
			return false;
		}
	}

	public function proforma_invoice_print() {

        $pi_id = $this->input->post('sc_id');

        $t_id = $this->input->post('t_id');

        if (empty($t_id) and empty($pi_id)) {
            redirect(base_url('admin/sale-contract'));
        }

        $data['hdr'] = $this->db->get_where('sc_template', array('sc_template_id'=> $t_id, 'type'=>'SC'))->row();



		$data['header'] = $this->db
			->select('proforma_invoices.*, pi_number,pi_date, am1.owner_name,am1.name, am1.official_address, am1.instruction, am1.shipping_address,am1.place_of_supply, am1.email_id, am2.owner_name as consignee_name,
                am2.name as consignee, am2.shipping_address as consignee_address,am2.shipping_address as consignee_shipping_address,
                am2.place_of_supply as consignee_place_of_supply,port1.port_name,port2.port_name as shipment_port, offers.offer_id, offers.offer_fz_number,offers.shelf_life, shipping_line,
                countries.name as country_name, incoterms.incoterm, offers.tolerance, offers.docs_provided, offers.shipment_timing, offers.size_of_container, offers.no_of_container, proforma_invoices.footer_contract, currencies.code, currencies.symbol')

			->join('acc_master am1', 'am1.am_id = proforma_invoices.sold_to_party', 'left')
			->join('acc_master am2', 'am2.am_id = proforma_invoices.consignee_name', 'left')

			->join('ports port1', 'port1.p_id = proforma_invoices.destination_port', 'left')
			->join('ports port2', 'port2.p_id = proforma_invoices.port_of_shipment', 'left')

			->join('offers', 'offers.offer_id = proforma_invoices.offer', 'left')
			->join('countries', 'countries.country_id = offers.country_id', 'left')
			->join('currencies', 'currencies.c_id = offers.c_id', 'left')
			->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left')

			->get_where('proforma_invoices', array('proforma_invoices.pi_id' => $pi_id))->result();

		// echo "<pre>"; print_r($data['header']); die();

			$offer_id = $data['header'][0]->offer_id;
		    $data['freight_sum'] =  $this->db
			->select('selling_price.freight as totalfreight')
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.freight')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

            if (@count($data['freight_sum']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Freight charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
            // echo "<pre>"; print_r($data['freight_sum']); die();

		$data['insurance_sum1'] =  $this->db
			->select('selling_price.other_price as total_insurance')
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id' => 8))->result();
        if (@count($data['insurance_sum1']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
		$data['insurance_sum2'] =  $this->db
			->select('selling_price.other_price as total_insurance')
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id2' => 8))->result();
        if (@count($data['insurance_sum2']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
		$data['insurance_sum3'] =  $this->db
			->select('selling_price.other_price as total_insurance')
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id3' => 8))->result();
        if (@count($data['insurance_sum3']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

		$data['insurance_sum4'] =  $this->db
			->select('selling_price.other_price as total_insurance')
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id4' => 8))->result();

        if (@count($data['insurance_sum4']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

            $data['total_insurance'] = 0;
            if(array_key_exists(0, $data['insurance_sum1'])){ 
               $data['total_insurance'] = number_format($data['insurance_sum1'][0]->total_insurance, 2);

             }

             if(array_key_exists(0, $data['insurance_sum2'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum2'][0]->total_insurance, 2);
             }

             if(array_key_exists(0, $data['insurance_sum3'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum3'][0]->total_insurance, 2);
             }

             if(array_key_exists(0, $data['insurance_sum4'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum4'][0]->total_insurance, 2);
             }

		$data['other_sum1'] =  $this->db
			->select('sum(selling_price.other_price) as total_ot')
			->where('selling_price.li_id <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

		$data['other_sum2'] =  $this->db
			->select('sum(selling_price.other_price2) as total_ot')
			->where('selling_price.li_id2 <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

		$data['other_sum3'] =  $this->db
			->select('sum(selling_price.other_price3) as total_ot')
			->where('selling_price.li_id3 <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

		$data['other_sum4'] =  $this->db
			->select('sum(selling_price.other_price4) as total_ot')
			->where('selling_price.li_id4 <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();


		$data['total_other'] = number_format(($data['other_sum1'][0]->total_ot + $data['other_sum2'][0]->total_ot + $data['other_sum3'][0]->total_ot + $data['other_sum4'][0]->total_ot),2);
			/*echo $this->db->last_query();*/
			$bank_id = $data['header'][0]->bank_id;
			$ids = explode(',', $bank_id);
			$this->db->where_in('bank_master_id', $ids );
			$data['bank_details'] = $this->db->get('bank_master')->result();

            //echo $this->db->last_query(); die();


			$company_id = $data['header'][0]->company_id;
			$data['company'] = $this->db->get_where('company',array('company_id' => $company_id))->row();
			// echo "<pre>"; print_r($data); die();

		$data['details'] = $this->db
			->select('offer_details.grade, offer_details.product_line_sc,  offer_details.product_line,
					  offer_details.cartons_offered,
					  offer_details.gross_weight,
                      offer_details.product_description,
                      offer_details.pieces,
                      offer_details.size_before_glaze,
                      offer_details.size_after_glaze,

					  products.product_name,
					  products.scientific_name,
					  packing_sizes.packing_size,

					  sizes.size,
                      fzm.freezing_type as fzme,
                      fzt.freezing_type as fztp,

                      ptp.packing_type as ptp1,
                      pts.packing_type as pts1,

                      glazing.glazing as glazing,
                      blocks.block_size,
                      
                      payment_terms.payment_terms,

					  offer_details.quantity_offered,
					  offer_details.product_price,
                      offer_details.comment,
					  units.unit,
					  selling_price.final_selling_price,
					  selling_price.mar_selling_rate,
					  selling_price.mar_selling_approval_status,
					  offers.size_of_container,
					  incoterms.incoterm')

			->join('offers', 'offers.offer_id = proforma_invoices.offer', 'left')
			->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left')
			->join('units', 'units.u_id = offer_details.unit_id', 'left')
			->join('products', 'products.pr_id = offer_details.product_id', 'left')
			->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left')
			->join('sizes', 'sizes.size_id = offer_details.size_id', 'left')
            ->join('freezing fzm', 'fzm.ft_id = offer_details.freezing_method_id', 'left')
            ->join('freezing fzt', 'fzt.ft_id = offer_details.freezing_id', 'left')
            ->join('packing_types ptp', 'ptp.pt_id = offer_details.primary_packing_type_id', 'left')
            ->join('packing_types pts', 'pts.pt_id = offer_details.secondary_packing_type_id', 'left')
            ->join('glazing', 'glazing.gl_id = offer_details.glazing_id', 'left')
            ->join('blocks', 'blocks.block_id = offer_details.block_id', 'left')
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->join('incoterms', 'incoterms.it_id = selling_price.selling_incoterm_id', 'left')
			->join('payment_terms', 'payment_terms.pt_id = proforma_invoices.payment_terms', 'left')

			->get_where('proforma_invoices', array('proforma_invoices.pi_id' => $pi_id, 'fzm.freezing_category' => 'Method', 'fzt.freezing_category' => 'Type', 'ptp.packing_category' => 'Primary packing', 'pts.packing_category' => 'Secondary packing'))->result_array();


            // echo "<pre>"; print_r($data['details']); die();

		return array('page' => 'accounts/proforma_invoice_print', 'data' => $data);

	}

	public function print_purchase_order() {
        $po_id = $this->input->post('po_id');

        $t_id = $this->input->post('t_id');

        if (empty($t_id) and empty($po_id)) {
            redirect(base_url('admin/purchase-order'));
        }

        $data['hdr'] = $this->db->get_where('sc_template', array('sc_template_id'=> $t_id, 'type'=>'PO'))->row();

		$data['header'] = $this->db
            ->select('purchase_order.*, po_number,po_date, am1.owner_name,am1.name, am1.purchase_order_instruction, am1.official_address,am1.shipping_address,am1.place_of_supply, am1.email_id, am2.owner_name as consignee_name,
                am2.name as consignee, am2.shipping_address as consignee_address,am2.shipping_address as consignee_shipping_address,
                am2.place_of_supply as consignee_place_of_supply,port1.port_name,port2.port_name as shipment_port, offers.offer_id, offers.offer_fz_number,offers.shelf_life, shipping_line,
                countries.name as country_name, incoterms.incoterm, offers.tolerance, offers.docs_provided, offers.shipment_timing, offers.size_of_container, offers.no_of_container, purchase_order.footer_contract, currencies.code, currencies.symbol, am3.name as order_to_name, am3.shipping_address as order_to_shipping_address')

            ->join('acc_master am1', 'am1.am_id = purchase_order.sold_to_party_id', 'left')
            ->join('acc_master am2', 'am2.am_id = purchase_order.consignee_id', 'left')
            ->join('acc_master am3', 'am3.am_id = purchase_order.order_to_id', 'left')


            ->join('ports port1', 'port1.p_id = purchase_order.destination_port', 'left')
            ->join('ports port2', 'port2.p_id = purchase_order.port_of_shipment', 'left')

            ->join('offers', 'offers.offer_id = purchase_order.offer', 'left')
            ->join('countries', 'countries.country_id = offers.country_id', 'left')
            ->join('currencies', 'currencies.c_id = offers.c_id', 'left')
            ->join('incoterms', 'incoterms.it_id = offers.incoterm_id', 'left')
            ->where('am3.supplier_buyer', 0)
            ->get_where('purchase_order', array('purchase_order.po_id' => $po_id))->result();


			//echo $this->db->last_query();

		 	//echo "<pre>"; print_r($data['header']); die();

		$company_id = $data['header'][0]->company_id;
		$data['company'] = $this->db->get_where('company',array('company_id' => $company_id))->row();
		//if (1==2) {
		$offer_id = $data['header'][0]->offer_id;
		
        $data['freight_sum'] =  $this->db
            ->select('selling_price.freight as totalfreight')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.freight')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

            if (@count($data['freight_sum']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Freight charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
            // echo "<pre>"; print_r($data['freight_sum']); die();

        $data['insurance_sum1'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id' => 8))->result();
        if (@count($data['insurance_sum1']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
        $data['insurance_sum2'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id2' => 8))->result();
        if (@count($data['insurance_sum2']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }
        $data['insurance_sum3'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id3' => 8))->result();
        if (@count($data['insurance_sum3']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

        $data['insurance_sum4'] =  $this->db
            ->select('selling_price.other_price as total_insurance')
            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
            ->group_by('selling_price.other_price')
            ->get_where('offer_details', array('offer_details.offer_id' => $offer_id, 'selling_price.li_id4' => 8))->result();

        if (@count($data['insurance_sum4']) > 1) {
                $this->session->set_flashdata('type', 'warning');
                $this->session->set_flashdata('msg', 'Insurance charges miss match');
                // echo $refer =  $this->agent->referrer(); die();
                redirect($this->agent->referrer());
            }

            $data['total_insurance'] = 0;
            if(array_key_exists(0, $data['insurance_sum1'])){ 
               $data['total_insurance'] = number_format($data['insurance_sum1'][0]->total_insurance, 2);

             }

             if(array_key_exists(0, $data['insurance_sum2'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum2'][0]->total_insurance, 2);
             }

             if(array_key_exists(0, $data['insurance_sum3'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum3'][0]->total_insurance, 2);
             }

             if(array_key_exists(0, $data['insurance_sum4'])){ 
                $data['total_insurance'] = number_format($data['insurance_sum4'][0]->total_insurance, 2);
             }


		$data['other_sum1'] =  $this->db
			->select('sum(selling_price.other_price) as total_ot')
			->where('selling_price.li_id <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

		$data['other_sum2'] =  $this->db
			->select('sum(selling_price.other_price2) as total_ot')
			->where('selling_price.li_id2 <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

		$data['other_sum3'] =  $this->db
			->select('sum(selling_price.other_price3) as total_ot')
			->where('selling_price.li_id3 <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();

		$data['other_sum4'] =  $this->db
			->select('sum(selling_price.other_price4) as total_ot')
			->where('selling_price.li_id4 <> ', 8)
			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')
			->get_where('offer_details', array('offer_details.offer_id' => $offer_id))->result();


		$data['total_other'] = number_format(($data['other_sum1'][0]->total_ot + $data['other_sum2'][0]->total_ot + $data['other_sum3'][0]->total_ot + $data['other_sum4'][0]->total_ot),2);
			/*echo $this->db->last_query();*/
			/*$bank_id = $data['header'][0]->bank_id;
			$ids = explode(',', $bank_id);
			$this->db->where_in('bank_master_id', $ids );
			$data['bank_details'] = $this->db->get('bank_master')->result();*/
			// echo "<pre>"; print_r($data); die();
		//}


		/*$data['details'] = $this->db
			->select('offer_details.grade, offer_details.product_line, 
					  offer_details.cartons_offered, 
					  products.product_name,
					  products.scientific_name,
					  packing_sizes.packing_size,

					  sizes.size,

					  offer_details.quantity_offered,
					  offer_details.product_price,
					  units.unit,
					  selling_price.final_selling_price,
					  selling_price.mar_selling_rate,
					  selling_price.mar_selling_approval_status,
					  offers.size_of_container')

			->join('offers', 'offers.offer_id = purchase_order.offer', 'left')
			->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left')

			->join('units', 'units.u_id = offer_details.unit_id', 'left')
			->join('products', 'products.pr_id = offer_details.product_id', 'left')
			->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left')

			->join('sizes', 'sizes.size_id = offer_details.size_id', 'left')

			->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')

			->get_where('purchase_order', array('purchase_order.po_id' => $po_id))->result();*/


            $data['details'] = $this->db
            ->select('offer_details.grade, offer_details.product_line_sc,  offer_details.product_line,
                      offer_details.cartons_offered,

                      offer_details.gross_weight,

                      offer_details.product_description,

                      offer_details.pieces,

                      offer_details.size_before_glaze,

                      offer_details.size_after_glaze,

                      products.product_name,
                      products.scientific_name,
                      packing_sizes.packing_size,

                      sizes.size,
                      fzm.freezing_type as fzme,
                      fzt.freezing_type as fztp,

                      ptp.packing_type as ptp1,

                      pts.packing_type as pts1,

                      glazing.glazing as glazing,

                      blocks.block_size,


                      offer_details.quantity_offered,
                      offer_details.product_price,
                      offer_details.comment,
                      units.unit,
                      selling_price.final_selling_price,
                      selling_price.mar_selling_rate,
                      selling_price.mar_selling_approval_status,
                      offers.size_of_container')

            ->join('offers', 'offers.offer_id = purchase_order.offer', 'left')
            ->join('offer_details', 'offer_details.offer_id = offers.offer_id', 'left')

            ->join('units', 'units.u_id = offer_details.unit_id', 'left')
            ->join('products', 'products.pr_id = offer_details.product_id', 'left')
            ->join('packing_sizes', 'packing_sizes.ps_id = offer_details.packing_size_id', 'left')

            ->join('sizes', 'sizes.size_id = offer_details.size_id', 'left')

            ->join('freezing fzm', 'fzm.ft_id = offer_details.freezing_method_id', 'left')

            ->join('freezing fzt', 'fzt.ft_id = offer_details.freezing_id', 'left')


            ->join('packing_types ptp', 'ptp.pt_id = offer_details.primary_packing_type_id', 'left')

            ->join('packing_types pts', 'pts.pt_id = offer_details.secondary_packing_type_id', 'left')

            ->join('glazing', 'glazing.gl_id = offer_details.glazing_id', 'left')

            ->join('blocks', 'blocks.block_id = offer_details.block_id', 'left')

            ->join('selling_price', 'selling_price.od_id = offer_details.od_id', 'left')

            ->get_where('purchase_order', array('purchase_order.po_id' => $po_id, 'fzm.freezing_category' => 'Method', 'fzt.freezing_category' => 'Type', 'ptp.packing_category' => 'Primary packing', 'pts.packing_category' => 'Secondary packing'))->result_array();

		//echo "<pre>"; print_r($data['details']); die();

		return array('page' => 'accounts/purchase_order_print', 'data' => $data);

	}

}