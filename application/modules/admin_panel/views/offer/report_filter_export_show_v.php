<?php  ?>

<?php 


 $templates = $offer_data['templates'];
  // $offer_header = $offer_data['offer'];
  // $offer_details = $offer_data['offer_details'];


$export_header_fields = explode(',',$templates->export_header);

// $offer_details = $data['offer_details'];

$export_data = $offer_data['export_data'];

 // echo "<pre>"; print_r($export_data); die();

function date_frmt($date)
{
    if ($date == "0000-00-00" or $date == NULL or $date == '') {
        $dt = '-';
    }else{
        $dt = date("d/m/Y", strtotime($date));
    }
    

    return $dt;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Filter Report</title>
    <meta name="description" content="">
    <!--Data Table-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/css/buttons.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">
    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <style type="text/css">
    .ic label{text-decoration: underline;cursor: pointer;}
    .modal-dialog{width:90%}
    .font-weight-bold{font-weight: bold}
    </style>
  </head>
  <body>
    <section>
      <div class="body-content" style="margin-left: 0px;">
        <div class="wrapper">
          <!-- Customization -->
            <?php if (!empty($this->input->post())) { ?>
            <div style="width: max-content;margin: auto;">
                <div class="bg-dark" style="padding:0.1%; text-align: center;">
                    <h4 style="font-weight: bold;">Filter Result Header</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php if(!empty($this->input->post('customer_id'))){ ?>
                                    <th>Customer</th>
                                <?php } ?>
                                <?php if(!empty($this->input->post('vendor_id'))){ ?>
                                    <th>Vendor</th>
                                <?php } ?>
                                <?php if(!empty($this->input->post('offer_id'))){ ?>
                                    <th>Offer</th>
                                <?php } ?>
                                <?php if(!empty($this->input->post('product_id'))){ ?>
                                    <th>Offer Product</th>
                                <?php } ?>
                                <?php if(!empty($this->input->post('origin_id'))){ ?>
                                    <th>Origine</th>
                                <?php } ?>
                                <?php if(!empty($this->input->post('destination_id'))){ ?>
                                    <th>Destination</th>
                                <?php } ?>
                                 <?php if(!empty($this->input->post('product_id_exe'))){ ?>
                                    <th>Product</th>
                                <?php } ?>
                                
                                <?php if(!empty($this->input->post('company_id'))){ ?>
                                    <th>Company</th>
                                <?php } ?>

                                <?php if(!empty($this->input->post('offer_status'))){ ?>
                                    <th>Offer Staaus</th>
                                <?php } ?>
                                
                                <?php if(!empty($this->input->post('tepmlate_id'))){ ?>
                                    <th>Template</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                            <?php if(!empty($this->input->post('customer_id'))){ 
                                $cstmr = $this->db->get_where('acc_master', array('supplier_buyer' => 1, 'am_id' => $this->input->post('customer_id')))->row();
                            ?>
                                <td><?=(empty($cstmr)?'':$cstmr->name) ?></td>
                            <?php } ?>
                            <?php if(!empty($this->input->post('vendor_id'))){
                                $vndr = $this->db->get_where('acc_master', array('supplier_buyer' => 0, 'am_id' => $this->input->post('vendor_id')))->row();
                            ?>
                                <td><?=(empty($vndr)?'':$vndr->name) ?></td>
                            <?php } ?>
                            <?php if(!empty($this->input->post('offer_id'))){ 
                                $ofr = $this->db->get_where('offers', array('offer_id' => $this->input->post('offer_id')))->row();
                            ?>
                               <td><?=(empty($ofr)?'':$ofr->offer_name) ?></td>
                            <?php } ?>
                            <?php if(!empty($this->input->post('product_id'))){ 
                                $this->db->get_where('products', array('status' => 1))->result();

                                $p_data =  $this->db->select('product_name,')
                                            ->join('products','products.pr_id = offer_details.product_id','left')
                                            ->get_where('offer_details', array('offer_details.offer_id'=> $this->input->post('offer_id'), 'offer_details.status' => 1))->row();
                            ?>
                            <td><?=(empty($p_data)?'':$p_data->product_name) ?></td>
                            <?php } ?>
                            <?php if(!empty($this->input->post('origin_id'))){ 
                                $orgn = $this->db->get_where('countries', array('status' => 1, 'country_id' => $this->input->post('origin_id')))->row();
                            ?>
                            <td><?=(empty($orgn)?'':$orgn->name) ?></td>
                            <?php } ?>
                            <?php if(!empty($this->input->post('destination_id'))){ 
                                $des = $this->db->get_where('countries', array('status' => 1, 'country_id' => $this->input->post('destination_id')))->row();
                            ?>
                            <td><?=(empty($des)?'':$des->name) ?></td>
                            <?php } ?>
                            <?php if(!empty($this->input->post('product_id_exe'))){ 
                                $prd = $this->db->get_where('products', array('status' => 1, 'pr_id' => $this->input->post('product_id_exe')))->row();
                            ?>
                            <td><?=(empty($prd)?'':$prd->product_name) ?></td>
                            <?php } ?>
                            

                            <?php if(!empty($this->input->post('company_id'))){
                                $cmpdt = $this->db->get_where('company', array('status' => "Active", 'company_id' => $this->input->post('company_id')))->row();      
                            ?>
                            <td><?=(empty($cmpdt)?'':$cmpdt->company_name) ?></td>
                            <?php } ?>

                            <?php if(!empty($this->input->post('offer_status'))){
                                $offrsts = $this->db->get_where('offer_status', array('status' => 1, 'offer_status_id' => $this->input->post('offer_status')))->row();
                            ?>
                            <td><?=(empty($offrsts)?'':$offrsts->offer_status) ?></td>
                            <?php } ?>

                            <?php if(!empty($this->input->post('tepmlate_id'))){ 
                                $temp = $this->db->get_where('report_filter_template', array('report_filter_template_id' => $this->input->post('tepmlate_id')))->row();
                            ?>
                            <td><?=(empty($temp)?'':$temp->template_name) ?></td>
                            <?php } ?>
                            
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } ?>
            <div class="bg-dark" style="padding:0.1%; text-align: center;">
              <h4 style="font-weight: bold;">Filter Result Export</h4>
            </div>
            <div class="table-responsive">
                <?php if (@count($export_data) == 0) { ?>
                    <table id="" class="table table-hover width-100 table2excel offer_details">
                        <thead>
                            <tr >
                                <th style="text-align: center;font-weight: bold;font-size: 34px;">
                                    Data Not Found
                                </th>
                            </tr>
                        </thead>
                    </table>
                <?php }else{ ?>
                <table id="" class="table table-hover width-100 table2excel offer_details" >
                    <?php //echo "<pre>"; print_r($export_header_fields); ?>
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php if(in_array('offer_id', $export_header_fields)){ ?>
                                    <th>Offer Name</th>
                                <?php } ?>

                                <?php if(in_array('company', $export_header_fields)){ ?>
                                    <th>Company</th>
                                <?php } ?>

                                <?php if(in_array('fz_ref_no', $export_header_fields)){ ?>
                                    <th>FZ Ref No</th>
                                <?php } ?>
                                <?php if(in_array('no_of_container', $export_header_fields)){ ?>
                                    <th>No Of Container</th>
                                <?php } ?>
                                <?php if(in_array('partial_reference', $export_header_fields)){ ?>
                                    <th>Partial Reference</th>
                                <?php } ?>
                                <?php if(in_array('actual_sale_amt', $export_header_fields)){ ?>
                                    <th>Actual Sate AMT</th>
                                <?php } ?>
                                <?php if(in_array('admin_appr', $export_header_fields)){ ?>
                                    <th>Admin APPR</th>
                                <?php } ?>
                                <?php if(in_array('adv_amt_from_cust', $export_header_fields)){ ?>
                                    <th>AVT AMT From CUST</th>
                                <?php } ?>
                                <?php if(in_array('rlink_for_bl_to_appear', $export_header_fields)){ ?>
                                    <th>RLINK for BL to APPER</th>
                                <?php } ?>
                                <?php if(in_array('advise_received_from_bank', $export_header_fields)){ ?>
                                    <th>Advise Received From Bank </th>
                                <?php } ?>
                                <?php if(in_array('adv_paid_to_vendor', $export_header_fields)){ ?>
                                    <th>ADV Paid to Vendor</th>
                                <?php } ?>
                                <?php if(in_array('adv_amt_to_vendor', $export_header_fields)){ ?>
                                    <th>ADV AMT to Vendor</th>
                                <?php } ?>
                                <?php if(in_array('adv_recd_from_cust', $export_header_fields)){ ?>
                                    <th>ADV RECD From CUST</th>
                                <?php } ?>
                                <?php if(in_array('ata', $export_header_fields)){ ?>
                                    <th>ATA</th>
                                <?php } ?>
                                <?php if(in_array('atd', $export_header_fields)){ ?>
                                    <th>ATD</th>
                                <?php } ?>
                                <?php if(in_array('svd', $export_header_fields)){ ?>
                                    <th>SVD</th>
                                <?php } ?>
                                <?php if(in_array('besc_applied', $export_header_fields)){ ?>
                                    <th>BESC Applied</th>
                                <?php } ?>
                                <?php if(in_array('bl_no', $export_header_fields)){ ?>
                                    <th>BL No</th>
                                <?php } ?>
                                <?php if(in_array('corrc_appr_by_cust', $export_header_fields)){ ?>
                                    <th>Corrc APPR By CUST</th>
                                <?php } ?>
                                <?php if(in_array('corrc_appr_cust_date', $export_header_fields)){ ?>
                                    <th>CORRC APPR CUST Date</th>
                                <?php } ?>
                                <?php if(in_array('corrc_appr_to_vend', $export_header_fields)){ ?>
                                    <th>Corrc Appr To VEND</th>
                                <?php } ?>
                                
                                <?php if(in_array('correc_appr_vend_date', $export_header_fields)){ ?>
                                    <th>CORREC APPR VEND Date</th>
                                <?php } ?>
                                <?php if(in_array('cr_note_to_cust', $export_header_fields)){ ?>
                                    <th>CR Note to CUST</th>
                                <?php } ?>
                                <?php if(in_array('cr_note_to_supp', $export_header_fields)){ ?>
                                    <th>CR Note to SUPP</th>
                                <?php } ?>
                                <?php if(in_array('cust_po_no', $export_header_fields)){ ?>
                                    <th>CUST PO No</th>
                                <?php } ?>
                                
                                <?php if(in_array('cust_pi_conf', $export_header_fields)){ ?>
                                    <th>CUST PI CONF</th>
                                <?php } ?>

                                <?php if(in_array('dbt_note_to_cust', $export_header_fields)){ ?>
                                    <th>DBT Note To CUST</th>
                                <?php } ?>

                                <?php  
                                if(in_array('dbt_note_to_supp', $export_header_fields)){
                                ?>
                                <th>DBT Note To SUPP</th>
                                <?php } ?>

                                <?php if(in_array('dbt_note_cust_comm', $export_header_fields)){ ?>
                                    <th>DBT NOTE CUST COMM</th>
                                <?php } ?>

                                <?php if(in_array('draft_docs_recd', $export_header_fields)){ ?>
                                    <th>Draft DOCS RECD</th>
                                <?php } ?>

                                 <?php if(in_array('draft_docs_recd_date', $export_header_fields)){ ?>
                                    <th>Draft Docs RECD Date</th>
                                <?php } ?>

                                <?php if(in_array('draft_docs_sent', $export_header_fields)){ ?>    
                                    <th>Draft DOCS SENT</th>
                                <?php } ?>

                                <?php if(in_array('draft_docs_sent_date', $export_header_fields)){ ?>    
                                    <th>Draft DOCS SENT Date</th>
                                <?php } ?>

                                <?php if(in_array('eta', $export_header_fields)){ ?>    
                                    <th>ETA</th>
                                <?php } ?>

                                 <?php if(in_array('etd', $export_header_fields)){ ?>    
                                    <th>ETD</th>
                                <?php } ?>

                                <?php if(in_array('export_appr', $export_header_fields)){ ?>    
                                    <th>Export APPR</th>
                                <?php } ?>

                                <?php if(in_array('final_docs_submitted', $export_header_fields)){ ?>
                                    <th>Final DOCS Submitted</th>
                                <?php } ?>

                                <?php if(in_array('final_copy_cust', $export_header_fields)){ ?>
                                    <th>Final Copy CUST</th>
                                <?php } ?>

                                <?php if(in_array('final_copy_cust_date', $export_header_fields)){ ?>    
                                    <th>Final Copy CUST Date</th>
                                <?php } ?>

                                <?php if(in_array('final_copy_vend', $export_header_fields)){ ?>    
                                    <th>Final Copy VEND</th>
                                <?php } ?>

                                <?php if(in_array('final_copy_vend_date', $export_header_fields)){ ?>    
                                    <th>Final Copy VEND Date</th>
                                <?php } ?>
                                <?php if(in_array('finance_appr', $export_header_fields)){ ?>    
                                    <th>Finance APPR</th>
                                <?php } ?>
                                <?php if(in_array('freight_agent', $export_header_fields)){ ?>    
                                    <th>Freight Agent</th>
                                <?php } ?>
                                <?php if(in_array('freight_invoice_no', $export_header_fields)){ ?>    
                                    <th>Freight Invoice NO</th>
                                <?php } ?>

                                <?php if(in_array('frieght', $export_header_fields)){ ?>    
                                    <th>Frieght</th>
                                <?php } ?>

                                <?php if(in_array('lc_amt_recd', $export_header_fields)){ ?>    
                                    <th>LC AMT RECD</th>
                                <?php } ?>
                                <!-- New Th Add -->
                                <?php if(in_array('lc_amd_reqd', $export_header_fields)){ ?>    
                                    <th>LC AMD REQD</th>
                                <?php } ?><?php if(in_array('lc_critical_condition', $export_header_fields)){ ?>    
                                    <th>LC Critical Condition</th>
                                <?php } ?><?php if(in_array('lc_doc_submission_date', $export_header_fields)){ ?>    
                                    <th>LC DOC Submission Date</th>
                                <?php } ?><?php if(in_array('lc_expiry_date', $export_header_fields)){ ?>    
                                    <th>LC Expiry Date</th>
                                <?php } ?><?php if(in_array('lc_recd_cust', $export_header_fields)){ ?>    
                                    <th>LC RECD CUST</th>
                                <?php } ?><?php if(in_array('insp_license_number', $export_header_fields)){ ?>    
                                    <th>INSP License Number</th>
                                <?php } ?><?php if(in_array('insurance', $export_header_fields)){ ?>    
                                    <th>Insurance</th>
                                <?php } ?><?php if(in_array('label_appr_cust', $export_header_fields)){ ?>    
                                    <th>Label APPR CUST</th>
                                <?php } ?><?php if(in_array('label_appr_vend', $export_header_fields)){ ?>    
                                    <th>Label APPR VEND</th>
                                <?php } ?><?php if(in_array('last_remark', $export_header_fields)){ ?>    
                                    <th>Last Remark</th>
                                <?php } ?><?php if(in_array('latest_dos', $export_header_fields)){ ?>    
                                    <th>Latest DOS</th>
                                <?php } ?><?php if(in_array('mrktng_appr', $export_header_fields)){ ?>    
                                    <th>Mrktng APPR</th>
                                <?php } ?><?php if(in_array('org_docs_cust_date', $export_header_fields)){ ?>    
                                    <th>ORG DOCS CUST</th>
                                <?php } ?><?php if(in_array('org_docs_vend_date', $export_header_fields)){ ?>    
                                    <th>ORG DOCS VEND Date</th>
                                <?php } ?><?php if(in_array('sale_contract', $export_header_fields)){ ?>    
                                    <th>Sale Contract</th>
                                <?php } ?><?php if(in_array('sc_qty', $export_header_fields)){ ?>    
                                    <th>SC QTY</th>
                                <?php } ?><?php if(in_array('pi_sales_amt', $export_header_fields)){ ?>    
                                    <th>PI Sales AMT</th>
                                <?php } ?><?php if(in_array('po_purch_amt', $export_header_fields)){ ?>    
                                    <th>PO PURCH AMT</th>
                                <?php } ?><?php if(in_array('qty_loaded', $export_header_fields)){ ?>    
                                    <th>QTY Loaded</th>
                                <?php } ?><?php if(in_array('resource_appr', $export_header_fields)){ ?>    
                                    <th>Resource APPR</th>
                                <?php } ?><?php if(in_array('remark_for_outstation', $export_header_fields)){ ?>    
                                    <th>Remark For Outstation</th>
                                <?php } ?><?php if(in_array('remark_from_outstation', $export_header_fields)){ ?>    
                                    <th>Remark From Outstation</th>
                                <?php } ?><?php if(in_array('remark_admin_rp', $export_header_fields)){ ?>    
                                    <th>Remark admin RP</th>
                                <?php } ?><?php if(in_array('remark_finan_rp', $export_header_fields)){ ?>    
                                    <th>Remark Finan RP</th>
                                <?php } ?><?php if(in_array('remark_purch_rp', $export_header_fields)){ ?>    
                                    <th>Remark Purch RP</th>
                                <?php } ?><?php if(in_array('remark_sales_rp', $export_header_fields)){ ?>    
                                    <th>remark Sales RP</th>
                                <?php } ?><?php if(in_array('think', $export_header_fields)){ ?>    
                                    <th>Think</th>
                                <?php } ?><?php if(in_array('3rd_insp_upload', $export_header_fields)){ ?>    
                                    <th>3rd INSP Upload</th>
                                <?php } ?><?php if(in_array('vend_pi', $export_header_fields)){ ?>    
                                    <th>VEND PI</th>
                                <?php } ?><?php if(in_array('vend_inv_amt', $export_header_fields)){ ?>    
                                    <th>VEND INV AMT</th>
                                <?php } ?><?php if(in_array('vend_po_conf', $export_header_fields)){ ?>    
                                    <th>VEND PO CONF</th>
                                <?php } ?><?php if(in_array('actual_sales_amt_currency', $export_header_fields)){ ?>    
                                    <th>Actual Sales AMT currency</th>
                                <?php } ?><?php if(in_array('adv_amt_cust_currency', $export_header_fields)){ ?>    
                                    <th>ADV AMT CUST Currency</th>
                                <?php } ?><?php if(in_array('adv_amt_vend_currency', $export_header_fields)){ ?>    
                                    <th>ADV AMT VEND Currency</th>
                                <?php } ?><?php if(in_array('adv_paid_vend_currency', $export_header_fields)){ ?>    
                                    <th>ADV Paid VEND Currency</th>
                                <?php } ?><?php if(in_array('adv_recd_from_cust_currency', $export_header_fields)){ ?>    
                                    <th>ADV RECD from CUST currency</th>
                                <?php } ?><?php if(in_array('country_id', $export_header_fields)){ ?>    
                                    <th>Country Name</th>
                                <?php } ?><?php if(in_array('cust_inco_id', $export_header_fields)){ ?>    
                                    <th>CUST INCO</th>
                                <?php } ?><?php if(in_array('frieght_currency', $export_header_fields)){ ?>    
                                    <th>Crieght Currency</th>
                                <?php } ?><?php if(in_array('insurance_currency', $export_header_fields)){ ?>    
                                    <th>Insurance Currency</th>
                                <?php } ?><?php if(in_array('pymt_terms_cust_id', $export_header_fields)){ ?>    
                                    <th>PYMT TERMS CUST</th>
                                <?php } ?><?php if(in_array('pi_sales_amt_currency', $export_header_fields)){ ?>    
                                    <th>PI SALES AMT Currency</th>
                                <?php } ?><?php if(in_array('po_purch_amt_currency', $export_header_fields)){ ?>    
                                    <th>PO PURCH AMT Currency</th>
                                <?php } ?><?php if(in_array('responsible_purchase_id', $export_header_fields)){ ?>    
                                    <th>Responsible Purchase</th>
                                <?php } ?><?php if(in_array('responsible_sale_id', $export_header_fields)){ ?>    
                                    <th>Responsible Sale</th>
                                <?php } ?><?php if(in_array('responsible_logistics_id', $export_header_fields)){ ?>    
                                    <th>Responsible Logistics</th>
                                <?php } ?><?php if(in_array('vend_inv_amt_currency', $export_header_fields)){ ?>    
                                    <th>VEND INV AMT Currency</th>
                                <?php } ?><?php if(in_array('dox_remark', $export_header_fields)){ ?>    
                                    <th>DOX Remark</th>
                                <?php } ?><?php if(in_array('shipt_remark', $export_header_fields)){ ?>    
                                    <th>Shipt Remark</th>
                                <?php } ?><?php if(in_array('payment_remark', $export_header_fields)){ ?>    
                                    <th>Payment Remark</th>
                                <?php } ?><?php if(in_array('collect_remark', $export_header_fields)){ ?>    
                                    <th>Collect Remark</th>
                                <?php } ?><?php if(in_array('general_remark', $export_header_fields)){ ?>    
                                    <th>General Remark</th>
                                <?php } ?><?php if(in_array('insp_sr_applied', $export_header_fields)){ ?>    
                                    <th>INSP SR applied</th>
                                <?php } ?><?php if(in_array('insp_sr_number', $export_header_fields)){ ?>    
                                    <th>INSP SR Number</th>
                                <?php } ?>
                                <?php if(in_array('sr_date', $export_header_fields)){ ?>    
                                    <th>SR Date</th>
                                <?php } ?>
                                <?php if(in_array('insp_aoc_coc', $export_header_fields)){ ?>    
                                    <th>INSP AOC COC</th>
                                <?php } ?>
                                <?php if(in_array('aoc_coc_date', $export_header_fields)){ ?>    
                                    <th>AOC COC  Date</th>
                                <?php } ?>
                                <?php if(in_array('dayes_delayed', $export_header_fields)){ ?>    
                                    <th>Dayes Delayed</th>
                                <?php } ?>
                                <?php if(in_array('customer', $export_header_fields)){ ?>    
                                    <th>Customer</th>
                                <?php } ?>
                                <?php if(in_array('rem_dayes_for_shipt', $export_header_fields)){ ?>    
                                    <th>REM Dayes For Shipt</th>
                                <?php } ?>
                                <?php if(in_array('besc_others_no', $export_header_fields)){ ?>    
                                    <th>BESC Others NO</th>
                                <?php } ?>
                                <?php if(in_array('besc_cert', $export_header_fields)){ ?>    
                                    <th>BESC CERT</th>
                                <?php } ?>
                                <?php if(in_array('check_list_applied', $export_header_fields)){ ?>    
                                    <th>Check List Applied</th>
                                <?php } ?>
                                <?php if(in_array('doc_courier_no_incoming', $export_header_fields)){ ?>    
                                    <th>DOC  Courier NO Incoming</th>
                                <?php } ?>
                                <?php if(in_array('doc_courier_no_outgoing', $export_header_fields)){ ?>    
                                    <th>DOC Courier NO Outgoing</th>
                                <?php } ?><?php if(in_array('', $export_header_fields)){ ?>    
                                    <th></th>
                                <?php } ?>
                                <?php if(in_array('container_discharge_date', $export_header_fields)){ ?>    
                                    <th>Container Discharge Date</th>
                                <?php } ?>
                                <?php if(in_array('final_clearance_date', $export_header_fields)){ ?>    
                                    <th>Final Clearance Date</th>
                                <?php } ?>
                                <?php if(in_array('doc_recd', $export_header_fields)){ ?>    
                                    <th>DOC RECD</th>
                                <?php } ?>
                                <?php if(in_array('accounts_appr', $export_header_fields)){ ?>    
                                    <th>Accounts APPR</th>
                                <?php } ?>
                                <?php if(in_array('latest_doc_lc', $export_header_fields)){ ?>    
                                    <th>Latest DOC LC</th>
                                <?php } ?>

                                <?php if(in_array('payment_by_supplier_comm', $export_header_fields)){ ?>    
                                    <th>Payment By Supplier COMM</th>
                                <?php } ?>

                                <?php if(in_array('invoice_file', $export_header_fields)){ ?>    
                                    <th>Invoice  File</th>
                                <?php } ?>
                                <?php if(in_array('packing_list_file', $export_header_fields)){ ?>    
                                    <th>Packing List File</th>
                                <?php } ?>
                                <?php if(in_array('health_cer_file', $export_header_fields)){ ?>    
                                    <th>Health CER File</th>
                                <?php } ?>
                                <?php if(in_array('cert_of_origin', $export_header_fields)){ ?>    
                                    <th>CERT of origin</th>
                                <?php } ?>
                                <?php if(in_array('bill_of_leading', $export_header_fields)){ ?>    
                                    <th>Bill Of leading</th>
                                <?php } ?>
                                <?php if(in_array('sgs_cert', $export_header_fields)){ ?>    
                                    <th>SGS CERT</th>
                                <?php } ?>
                                <?php if(in_array('feri_cert', $export_header_fields)){ ?>    
                                    <th>FERI CERT</th>
                                <?php } ?>
                                <?php if(in_array('insp_report_file', $export_header_fields)){ ?>    
                                    <th>INSP Report File</th>
                                <?php } ?>
                                <?php if(in_array('besc_cert_file', $export_header_fields)){ ?>    
                                    <th>BESC CERT file</th>
                                <?php } ?>
                                <?php if(in_array('appr_label_file', $export_header_fields)){ ?>    
                                    <th>APPR Label File</th>
                                <?php } ?>
                                <?php if(in_array('confirmed_po_file', $export_header_fields)){ ?>    
                                    <th>Confirmed PO File</th>
                                <?php } ?>
                                <?php if(in_array('confirmed_pi_file', $export_header_fields)){ ?>    
                                    <th>Confirmed PI file</th>
                                <?php } ?>
                                <?php if(in_array('micrbiology_report_file', $export_header_fields)){ ?>    
                                    <th>Micrbiology Report File</th>
                                <?php } ?>

                                <?php if(in_array('other_export_report_file', $export_header_fields)){ ?>    
                                    <th>Other Export Report File</th>
                                <?php } ?>
                                <?php if(in_array('any_other_quality_report_file', $export_header_fields)){ ?>    
                                    <th>ANY Other Quality Report File</th>
                                <?php } ?>

                                <!-- <th>Total Value</th> -->
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php
                            $total_amount = 0;
                            $total_qnty = 0;
                            $total_crtn = 0;
                            $total_price = 0;
                            // echo "<pre>"; print_r($offer_details); die();
                            
                            foreach($export_data  as $key=>$vod){
                                // echo $key;
                            ?>
                            <tr>
                                <td><?=++$key;?></td>
                                <?php if(in_array('offer_id', $export_header_fields)){ 
                                     $offer = $this->db->get_where('offers', array('offer_id' => $vod->offer_id))->row();
                                ?>
                                    <td><?= $offer->offer_name; ?></td>
                                <?php } ?>

                                <?php if(in_array('company', $export_header_fields)){ ?>
                                    <td><?= $vod->company ?></td>
                                <?php } ?>

                                <?php if(in_array('fz_ref_no', $export_header_fields)){ ?>
                                    <td><?= $vod->fz_ref_no ?></td>
                                <?php } ?>
                                <?php if(in_array('no_of_container', $export_header_fields)){ ?>
                                    <td><?= $vod->no_of_container ?></td>
                                <?php } ?>
                                <?php if(in_array('partial_reference', $export_header_fields)){ ?>
                                    <td><?= $vod->partial_reference ?></td>
                                <?php } ?>
                                <?php if(in_array('actual_sale_amt', $export_header_fields)){ ?>
                                    <td><?= $vod->actual_sale_amt ?></td>
                                <?php } ?>
                                <?php if(in_array('admin_appr', $export_header_fields)){ ?>
                                    <td><?= $vod->admin_appr ?></td>
                                <?php } ?>
                                <?php if(in_array('adv_amt_from_cust', $export_header_fields)){ ?>
                                    <td><?= $vod->adv_amt_from_cust ?></td>
                                <?php } ?>
                                <?php if(in_array('rlink_for_bl_to_appear', $export_header_fields)){ ?>
                                    <td><?= $vod->rlink_for_bl_to_appear ?></td>
                                <?php } ?>
                                <?php if(in_array('advise_received_from_bank', $export_header_fields)){ ?>
                                    <td><?= $vod->advise_received_from_bank ?></td>
                                <?php } ?>
                                <?php if(in_array('adv_paid_to_vendor', $export_header_fields)){ ?>
                                    <td><?= $vod->adv_paid_to_vendor ?></td>
                                <?php } ?>
                                <?php if(in_array('adv_amt_to_vendor', $export_header_fields)){ ?>
                                    <td><?= $vod->adv_amt_to_vendor ?></td>
                                <?php } ?>
                                <?php if(in_array('adv_recd_from_cust', $export_header_fields)){ ?>
                                    <td><?= $vod->adv_recd_from_cust ?></td>
                                <?php } ?>
                                <?php if(in_array('ata', $export_header_fields)){ ?>
                                    <td><?= date_frmt($vod->ata) ?></td>
                                <?php } ?>
                                <?php if(in_array('atd', $export_header_fields)){ ?>
                                    <td><?= date_frmt($vod->atd) ?></td>
                                <?php } ?>
                                <?php if(in_array('svd', $export_header_fields)){ ?>
                                    <td><?= $vod->svd ?></td>
                                <?php } ?>
                                <?php if(in_array('besc_applied', $export_header_fields)){ ?>
                                    <td><?= $vod->besc_applied ?></td>
                                <?php } ?>
                                <?php if(in_array('bl_no', $export_header_fields)){ ?>
                                    <td><?= $vod->bl_no ?></td>
                                <?php } ?>
                                <?php if(in_array('corrc_appr_by_cust', $export_header_fields)){ ?>
                                    <td><?= $vod->corrc_appr_by_cust ?></td>
                                <?php } ?>
                                <?php if(in_array('corrc_appr_cust_date', $export_header_fields)){ ?>
                                    <td><?= date_frmt($vod->corrc_appr_cust_date) ?></td>
                                <?php } ?>
                                <?php if(in_array('corrc_appr_to_vend', $export_header_fields)){ ?>
                                    <td><?= $vod->corrc_appr_to_vend ?></td>
                                <?php } ?>
                                
                                <?php if(in_array('correc_appr_vend_date', $export_header_fields)){ ?>
                                    <td><?= $vod->correc_appr_vend_date ?></td>
                                <?php } ?>
                                <?php if(in_array('cr_note_to_cust', $export_header_fields)){ ?>
                                    <td><?= $vod->cr_note_to_cust ?></td>
                                <?php } ?>
                                <?php if(in_array('cr_note_to_supp', $export_header_fields)){ ?>
                                    <td><?= $vod->cr_note_to_supp ?></td>
                                <?php } ?>
                                <?php if(in_array('cust_po_no', $export_header_fields)){ ?>
                                    <td><?= $vod->cust_po_no ?></td>
                                <?php } ?>
                                
                                <?php if(in_array('cust_pi_conf', $export_header_fields)){ ?>
                                    <td><?= $vod->cust_pi_conf ?></td>
                                <?php } ?>

                                <?php if(in_array('dbt_note_to_cust', $export_header_fields)){ ?>
                                    <td><?= $vod->dbt_note_to_cust ?></td>
                                <?php } ?>

                                <?php  
                                if(in_array('dbt_note_to_supp', $export_header_fields)){
                                ?>
                                <td><?= $vod->dbt_note_to_supp ?></td>
                                <?php } ?>

                                <?php if(in_array('dbt_note_cust_comm', $export_header_fields)){ ?>
                                    <td><?= $vod->dbt_note_cust_comm ?></td>
                                <?php } ?>

                                <?php if(in_array('draft_docs_recd', $export_header_fields)){ ?>
                                    <td><?= $vod->draft_docs_recd ?></td>
                                <?php } ?>

                                 <?php if(in_array('draft_docs_recd_date', $export_header_fields)){ ?>
                                    <td><?= $vod->draft_docs_recd_date ?></td>
                                <?php } ?>

                                <?php if(in_array('draft_docs_sent', $export_header_fields)){ ?>    
                                   <td><?= $vod->draft_docs_sent ?></td>
                                <?php } ?>

                                <?php if(in_array('draft_docs_sent_date', $export_header_fields)){ ?>    
                                    <td><?= $vod->draft_docs_sent_date ?></td>
                                <?php } ?>

                                <?php if(in_array('eta', $export_header_fields)){ ?>    
                                    <td><?= $vod->eta ?></td>
                                <?php } ?>

                                 <?php if(in_array('etd', $export_header_fields)){ ?>    
                                    <td><?= $vod->etd ?></td>
                                <?php } ?>

                                <?php if(in_array('export_appr', $export_header_fields)){ ?>    
                                    <td><?= $vod->export_appr ?></td>
                                <?php } ?>

                                <?php if(in_array('final_docs_submitted', $export_header_fields)){ ?>
                                    <td><?= $vod->final_docs_submitted ?></td>
                                <?php } ?>

                                <?php if(in_array('final_copy_cust', $export_header_fields)){ ?>
                                    <td><?= $vod->final_copy_cust ?></td>
                                <?php } ?>

                                <?php if(in_array('final_copy_cust_date', $export_header_fields)){ ?>    
                                    <td><?= $vod->final_copy_cust_date ?></td>
                                <?php } ?>

                                <?php if(in_array('final_copy_vend', $export_header_fields)){ ?>    
                                    <td><?= $vod->final_copy_vend ?></td>
                                <?php } ?>

                                <?php if(in_array('final_copy_vend_date', $export_header_fields)){ ?>    
                                    <td><?= $vod->final_copy_vend_date ?></td>
                                <?php } ?>
                                <?php if(in_array('finance_appr', $export_header_fields)){ ?>    
                                    <td><?= $vod->finance_appr ?></td>
                                <?php } ?>
                                <?php if(in_array('freight_agent', $export_header_fields)){ ?>    
                                    <td><?= $vod->freight_agent ?></td>
                                <?php } ?>
                                <?php if(in_array('freight_invoice_no', $export_header_fields)){ ?>    
                                    <td><?= $vod->freight_invoice_no ?></td>
                                <?php } ?>

                                <?php if(in_array('frieght', $export_header_fields)){ ?>    
                                    <td><?= $vod->frieght ?></td>
                                <?php } ?>

                                <?php if(in_array('lc_amt_recd', $export_header_fields)){ ?>    
                                    <td><?= $vod->lc_amt_recd ?></td>
                                <?php } ?>
                                
                                <?php if(in_array('lc_amd_reqd', $export_header_fields)){ ?>    
                                    <td><?= $vod->lc_amd_reqd ?></td>
                                <?php } ?><?php if(in_array('lc_critical_condition', $export_header_fields)){ ?>    
                                    <td><?= $vod->lc_critical_condition ?></td>
                                <?php } ?><?php if(in_array('lc_doc_submission_date', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->lc_doc_submission_date) ?></td>
                                <?php } ?><?php if(in_array('lc_expiry_date', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->lc_expiry_date) ?></td>
                                <?php } ?><?php if(in_array('lc_recd_cust', $export_header_fields)){ ?>    
                                    <td><?= $vod->lc_recd_cust ?></td>
                                <?php } ?><?php if(in_array('insp_license_number', $export_header_fields)){ ?>    
                                    <td><?= $vod->insp_license_number ?></td>
                                <?php } ?><?php if(in_array('insurance', $export_header_fields)){ ?>    
                                    <td><?= $vod->insurance ?></td>
                                <?php } ?><?php if(in_array('label_appr_cust', $export_header_fields)){ ?>    
                                    <td><?= $vod->label_appr_cust ?></td>
                                <?php } ?><?php if(in_array('label_appr_vend', $export_header_fields)){ ?>    
                                    <td><?= $vod->label_appr_vend ?></td>
                                <?php } ?><?php if(in_array('last_remark', $export_header_fields)){ ?>    
                                    <td><?= $vod->last_remark ?></td>
                                <?php } ?><?php if(in_array('latest_dos', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->latest_dos) ?></td>
                                <?php } ?><?php if(in_array('mrktng_appr', $export_header_fields)){ ?>    
                                    <td><?= $vod->mrktng_appr ?></td>
                                <?php } ?><?php if(in_array('org_docs_cust_date', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->org_docs_cust_date) ?></td>
                                <?php } ?><?php if(in_array('org_docs_vend_date', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->org_docs_vend_date) ?></td>
                                <?php } ?><?php if(in_array('sale_contract', $export_header_fields)){ ?>    
                                    <td><?= $vod->sale_contract ?></td>
                                <?php } ?><?php if(in_array('sc_qty', $export_header_fields)){ ?>    
                                    <td><?= $vod->sc_qty ?></td>
                                <?php } ?><?php if(in_array('pi_sales_amt', $export_header_fields)){ ?>    
                                    <td><?= $vod->pi_sales_amt ?></td>
                                <?php } ?><?php if(in_array('po_purch_amt', $export_header_fields)){ ?>    
                                    <td><?= $vod->po_purch_amt ?></td>
                                <?php } ?><?php if(in_array('qty_loaded', $export_header_fields)){ ?>    
                                    <td><?= $vod->qty_loaded ?></td>
                                <?php } ?><?php if(in_array('resource_appr', $export_header_fields)){ ?>    
                                    <td><?= $vod->resource_appr ?></td>
                                <?php } ?><?php if(in_array('remark_for_outstation', $export_header_fields)){ ?>    
                                    <td><?= $vod->remark_for_outstation ?></td>
                                <?php } ?><?php if(in_array('remark_from_outstation', $export_header_fields)){ ?>    
                                    <td><?= $vod->remark_from_outstation ?></td>
                                <?php } ?><?php if(in_array('remark_admin_rp', $export_header_fields)){ ?>    
                                    <td><?= $vod->remark_admin_rp ?></td>
                                <?php } ?><?php if(in_array('remark_finan_rp', $export_header_fields)){ ?>    
                                    <td><?= $vod->remark_finan_rp ?></td>
                                <?php } ?><?php if(in_array('remark_purch_rp', $export_header_fields)){ ?>    
                                    <td><?= $vod->remark_purch_rp ?></td>
                                <?php } ?><?php if(in_array('remark_sales_rp', $export_header_fields)){ ?>    
                                    <td><?= $vod->remark_sales_rp ?></td>
                                <?php } ?><?php if(in_array('think', $export_header_fields)){ ?>    
                                    <td><?= $vod->think ?></td>
                                <?php } ?><?php if(in_array('3rd_insp_upload', $export_header_fields)){  ?>    
                                    <td><?= date_frmt($vod->rdinsp) ?></td>
                                <?php } ?><?php if(in_array('vend_pi', $export_header_fields)){ ?>    
                                    <td><?= $vod->vend_pi ?></td>
                                <?php } ?><?php if(in_array('vend_inv_amt', $export_header_fields)){ ?>    
                                    <td><?= $vod->vend_inv_amt ?></td>
                                <?php } ?><?php if(in_array('vend_po_conf', $export_header_fields)){ ?>    
                                    <td><?= $vod->vend_po_conf ?></td>
                                <?php } ?><?php if(in_array('actual_sales_amt_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->actual_sales_amt_currency ?></td>
                                <?php } ?><?php if(in_array('adv_amt_cust_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->adv_amt_cust_currency ?></td>
                                <?php } ?><?php if(in_array('adv_amt_vend_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->adv_amt_vend_currency ?></td>
                                <?php } ?><?php if(in_array('adv_paid_vend_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->adv_paid_vend_currency ?></td>
                                <?php } ?><?php if(in_array('adv_recd_from_cust_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->adv_recd_from_cust_currency ?></td>
                                <?php } ?><?php if(in_array('country_id', $export_header_fields)){ ?>    
                                    <td><?= $vod->country_id ?></td>
                                <?php } ?><?php if(in_array('cust_inco_id', $export_header_fields)){ ?>    
                                    <td><?= $vod->cust_inco_id ?></td>
                                <?php } ?><?php if(in_array('frieght_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->frieght_currency ?></td>
                                <?php } ?><?php if(in_array('insurance_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->insurance_currency ?></td>
                                <?php } ?><?php if(in_array('pymt_terms_cust_id', $export_header_fields)){ ?>    
                                    <td><?= $vod->pymt_terms_cust_id ?></td>
                                <?php } ?><?php if(in_array('pi_sales_amt_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->pi_sales_amt_currency ?></td>
                                <?php } ?><?php if(in_array('po_purch_amt_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->po_purch_amt_currency ?></td>
                                <?php } ?><?php if(in_array('responsible_purchase_id', $export_header_fields)){ ?>    
                                    <td><?= $vod->responsible_purchase_id ?></td>
                                <?php } ?><?php if(in_array('responsible_sale_id', $export_header_fields)){ ?>    
                                    <td><?= $vod->responsible_sale_id ?></td>
                                <?php } ?><?php if(in_array('responsible_logistics_id', $export_header_fields)){ ?>    
                                    <td><?= $vod->responsible_logistics_id ?></td>
                                <?php } ?><?php if(in_array('vend_inv_amt_currency', $export_header_fields)){ ?>    
                                    <td><?= $vod->vend_inv_amt_currency ?></td>
                                <?php } ?><?php if(in_array('dox_remark', $export_header_fields)){ ?>    
                                    <td><?= $vod->dox_remark ?></td>
                                <?php } ?><?php if(in_array('shipt_remark', $export_header_fields)){ ?>    
                                    <td><?= $vod->shipt_remark ?></td>
                                <?php } ?><?php if(in_array('payment_remark', $export_header_fields)){ ?>    
                                    <td><?= $vod->payment_remark ?></td>
                                <?php } ?><?php if(in_array('collect_remark', $export_header_fields)){ ?>    
                                    <td><?= $vod->collect_remark ?></td>
                                <?php } ?><?php if(in_array('general_remark', $export_header_fields)){ ?>    
                                    <td><?= $vod->general_remark ?></td>
                                <?php } ?><?php if(in_array('insp_sr_applied', $export_header_fields)){ ?>    
                                    <td><?= $vod->insp_sr_applied ?></td>
                                <?php } ?><?php if(in_array('insp_sr_number', $export_header_fields)){ ?>    
                                    <td><?= $vod->insp_sr_number ?></td>
                                <?php } ?>
                                <?php if(in_array('sr_date', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->sr_date) ?></td>
                                <?php } ?>
                                <?php if(in_array('insp_aoc_coc', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->insp_aoc_coc) ?></td>
                                <?php } ?>
                                <?php if(in_array('aoc_coc_date', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->aoc_coc_date) ?></td>
                                <?php } ?>
                                <?php if(in_array('dayes_delayed', $export_header_fields)){ ?>    
                                    <td><?= $vod->dayes_delayed ?></td>
                                <?php } ?>
                                <?php 
                                    if(in_array('customer', $export_header_fields)){ 
                                        if(!empty($vod->customer)){
                                ?>    
                                    <td><?= $this->db->get_where('acc_master', array('am_id' => $vod->customer))->row()->name ?></td>
                                <?php } } ?>
                                <?php if(in_array('rem_dayes_for_shipt', $export_header_fields)){ ?>    
                                    <td><?= $vod->rem_dayes_for_shipt ?></td>
                                <?php } ?>
                                <?php if(in_array('besc_others_no', $export_header_fields)){ ?>    
                                    <td><?= $vod->besc_others_no ?></td>
                                <?php } ?>
                                <?php if(in_array('besc_cert', $export_header_fields)){ ?>    
                                    <td><?= $vod->besc_cert ?></td>
                                <?php } ?>
                                <?php if(in_array('check_list_applied', $export_header_fields)){ ?>    
                                    <td><?= $vod->check_list_applied ?></td>
                                <?php } ?>
                                <?php if(in_array('doc_courier_no_incoming', $export_header_fields)){ ?>    
                                    <td><?= $vod->doc_courier_no_incoming ?></td>
                                <?php } ?>
                                <?php if(in_array('doc_courier_no_outgoing', $export_header_fields)){ ?>    
                                    <td><?= $vod->doc_courier_no_outgoing ?></td>
                                <?php  } ?>

                                <?php if(in_array('container_discharge_date', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->container_discharge_date) ?></td>
                                <?php } ?>
                                <?php if(in_array('final_clearance_date', $export_header_fields)){ ?>    
                                   <td><?= date_frmt($vod->final_clearance_date) ?></td>
                                <?php } ?>
                                <?php if(in_array('doc_recd', $export_header_fields)){ ?>    
                                    <td><?= $vod->doc_recd ?></td>
                                <?php } ?>
                                <?php if(in_array('accounts_appr', $export_header_fields)){ ?>    
                                    <td><?= $vod->accounts_appr ?></td>
                                <?php } ?>
                                <?php if(in_array('latest_doc_lc', $export_header_fields)){ ?>    
                                    <td><?= date_frmt($vod->latest_doc_lc) ?></td>
                                <?php } ?>

                                <?php if(in_array('payment_by_supplier_comm', $export_header_fields)){ ?>    
                                    <td><?= $vod->payment_by_supplier_comm ?></td>
                                <?php } ?>

                                <?php if(in_array('invoice_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->invoice_file ?></td>
                                <?php } ?>
                                <?php if(in_array('packing_list_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->packing_list_file ?></td>
                                <?php } ?>
                                <?php if(in_array('health_cer_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->health_cer_file ?></td>
                                <?php } ?>
                                <?php if(in_array('cert_of_origin', $export_header_fields)){ ?>    
                                   <td><?= $vod->cert_of_origin ?></td>
                                <?php } ?>
                                <?php if(in_array('bill_of_leading', $export_header_fields)){ ?>    
                                    <td><?= $vod->bill_of_leading ?></td>
                                <?php } ?>
                                <?php if(in_array('sgs_cert', $export_header_fields)){ ?>    
                                   <td><?= $vod->sgs_cert ?></td>
                                <?php } ?>
                                <?php if(in_array('feri_cert', $export_header_fields)){ ?>    
                                    <td><?= $vod->feri_cert ?></td>
                                <?php } ?>
                                <?php if(in_array('insp_report_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->insp_report_file ?></td>
                                <?php } ?>
                                <?php if(in_array('besc_cert_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->besc_cert_file ?></td>
                                <?php } ?>
                                <?php if(in_array('appr_label_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->appr_label_file ?></td>
                                <?php } ?>
                                <?php if(in_array('confirmed_po_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->confirmed_po_file ?></td>
                                <?php } ?>
                                <?php if(in_array('confirmed_pi_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->confirmed_pi_file ?></td>
                                <?php } ?>
                                <?php if(in_array('micrbiology_report_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->micrbiology_report_file ?></td>
                                <?php } ?>

                                <?php if(in_array('other_export_report_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->other_export_report_file ?></td>
                                <?php } ?>
                                <?php if(in_array('any_other_quality_report_file', $export_header_fields)){ ?>    
                                    <td><?= $vod->any_other_quality_report_file ?></td>
                                <?php } ?>
                                <!-- <td>Total Value</td> -->
                            </tr>
                            <?php } ?>
                                
                        </tbody>
                    </table>
                </div>
                <?php } ?>



          <!-- // -->
          </div>
          <!--body wrapper end-->
        </div>
        <!-- body content end-->
      </section>
      <!-- Request modal -->
      <!-- Comments modal -->
      <!-- View (Settings) modal -->
      <!-- Status modal -->
      <!-- Placed js at the end of the document so the pages load faster -->
      <script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>
      <!-- common js -->
      <?php $this->load->view('components/_common_js'); //left side menu ?>
      <!--Data Table-->
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/JSZip-2.5.0/jszip.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.bootstrap.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.flash.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.print.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
      <script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/js/responsive.bootstrap.min.js"></script>
      <!--data table init-->
      <script src="<?=base_url()?>assets/admin_panel/js/data-table-init.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
      <!--form validation-->
      <script src="<?=base_url();?>assets/admin_panel/js/jquery.validate.min.js"></script>
      <!--ajax form submit-->
      <script src="<?=base_url();?>assets/admin_panel/js/jquery.form.min.js"></script>
      <!--Select2-->
      <script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
      <script>
      $('.select2').select2();
      </script>
      <script type="text/javascript">
      //toastr notification
      function notification(obj) {
      toastr[obj.type](obj.msg, obj.title, {
      "closeButton": true,
      "debug": false,
      "newestOnTop": false,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "5000",
      "timeOut": "5000",
      "extendedTimeOut": "7000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
      })
      }
      
      $("#offer_id").on('change', function(){
      $offer_id = $(this).val();
      $.ajax({
      url: "<?=base_url()?>admin/ajax_get_product_data",
      dataType:"json",
      type: "post",
      data:{"offer_id":$offer_id},
      success: function(data){
      $("#product_id").html(data);
      }
      });
      });
      $("#product_id").on('change', function(){
      if ($(this).val() == '') {
      $('#product_id_exe_div').show();
      }else{
      $('#product_id_exe_div').hide();
      }
      });
      
    //   $('.offer_details tfoot th').each(function () {
    //         var title = $(this).text();
    //         $(this).html('<input type="text" placeholder="'+title+'" />');
    //     });
    //     var table = $('.offer_details').DataTable({
    //         dom: 'Blfrtip',
    //         buttons: [
    //             {
    //                 extend: 'excel',
    //                 exportOptions: {
    //                     // columns: [1, 2, 3, 4, 6]
    //                     // columns: ':not(:last-child)'
    //                 }
    //             },
    //             'copy', 'print'
    //         ], 
    //         aLengthMenu: [
    //             [5, 10, 25, 50, 100, 200, -1],
    //             ['5 Rows', '10 Rows', '25 Rows', '50 Rows', '100 Rows', '200 Rows', "All"]
    //         ],
    //         // iDisplayLength: -1,
    //         // columnDefs: [ { orderable: false, targets: [1,2,6,7,8,10,11,12] }]
    //         initComplete: function () {
    //             // Apply the search
    //             this.api()
    //                 .columns()
    //                 .every(function () {
    //                     var that = this;
     
    //                     $('input', this.footer()).on('keyup change clear', function () {
    //                         if (that.search() !== this.value) {
    //                             that.search(this.value).draw();
    //                         }
    //                     });
    //                 });
    //         },
    //     });
        
    //     // Refilter the table
    //     $('#min, #max').on('change', function () {
    //         table.draw();
    //     });
        
      </script>
    </body>
  </html>