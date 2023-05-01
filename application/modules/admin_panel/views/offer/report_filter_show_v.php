<?php 


 $templates = $offer_data['templates'];
  // $offer_header = $offer_data['offer'];
  // $offer_details = $offer_data['offer_details'];


$offer_header_fields = explode(',',$templates->offer_header);
$offer_details_fields = explode(',', $templates->offer_details);  

// $offer_details = $data['offer_details'];

$offer_details = $offer_data['offer'];


 // echo "<pre>"; print_r($offer_header_fields); die();

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
          <!-- <div class="row">
            <div class="bg-dark" style="padding:0.1%; text-align: center;">
              <h4 style="font-weight: bold;">Filter Result Offer</h4>
            </div>
            <table id="offer_filter_table" class="table data-table table-striped" role="grid" aria-describedby="offer_details_table_info">
              <thead>
                <tr role="row">
                  <th>Offer</th>
                  <th >Product Name</th>
                  <th >Scientific Name</th>
                  <th>Size</th>
                  <th>Pieces</th>
                  <th >Packing size</th>
                  <th>Quantity Offered</th>
                  <th >Product Price (€)</th>
                  <th >Total Price (€)</th></tr>
                </thead>
                <tbody >
                  <tr role="row" class="odd">
                    <td>Offer 123</td>
                    <td class="sorting_1">Sardinella Eba</td>
                    <td>Sardinella Maderensis</td><td>18 CM+</td><td></td><td>20 Kg Box</td><td>67.50</td><td>€ 740</td><td>€ 49950</td>
                  </tr>
                  <tr role="row" class="even">
                    <td>Offer 123</td>
                    <td class="sorting_1">Sardinella Eba</td><td>Sardinella Maderensis</td><td>16 CM+</td><td></td><td>20 Kg Box</td><td>27.00</td><td>€ 720</td>
                    <td>€ 19440</td>
                  </tr>
                </tbody>
                <tfoot>
                <tr><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1"></th><th rowspan="1" colspan="1">Total Qty:  108.00</th><th rowspan="1" colspan="1">Total : € 2220.00</th><th rowspan="1" colspan="1">Total :  € 79650.00</th><th rowspan="1" colspan="1">-</th></tr>
                <tr class="bg-green">
                  <th colspan="21">Buying Product price: dd</th>
                </tr> 
                </tfoot>
              </table>
              
            </div>
          </div> -->

          <!-- Customization -->
          <?php //echo "<pre>"; print_r($this->input->post()); die(); ?>
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
              <h4 style="font-weight: bold;">Filter Result Offer</h4>
            </div>
            <div class="table-responsive">
                <?php if (@count($offer_details) == 0) { ?>
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
                    <?php //echo "<pre>"; print_r($offer_details_fields); ?>
                        <thead>
                            <tr>
                                <th>#</th>
                            <?php if(in_array('offer_name', $offer_header_fields)){ ?>
                                <th>Offer Name</th>
                            <?php } ?>

                            <?php if(in_array('offer_number', $offer_header_fields)){ ?>
                                <th>Offer Number</th>
                            <?php } ?>

                            <?php if(in_array('destination_country', $offer_header_fields)){ ?>
                                <th>D Country</th>
                            <?php } ?>
                            <?php if(in_array('source_country', $offer_header_fields)){ ?>
                                <th>S Country</th>
                            <?php } ?>
                            <?php if(in_array('tolerance', $offer_header_fields)){ ?>
                                <th>Tolerance</th>
                            <?php } ?>
                            <?php if(in_array('offer_date', $offer_header_fields)){ ?>
                                <th>Offer Date</th>
                            <?php } ?>
                            <?php if(in_array('supplier_name', $offer_header_fields)){ ?>
                                <th>Vendor</th>
                            <?php } ?>
                            <?php if(in_array('currency', $offer_header_fields)){ ?>
                                <th>Currency</th>
                            <?php } ?>
                            <?php if(in_array('no_of_container', $offer_header_fields)){ ?>
                                <th>Container Number</th>
                            <?php } ?>
                            <?php if(in_array('size_of_container', $offer_header_fields)){ ?>
                                <th>Container Size</th>
                            <?php } ?>
                            <?php if(in_array('quantity_each_container', $offer_header_fields)){ ?>
                                <th>Container Quantity</th>
                            <?php } ?>
                            <?php if(in_array('shipping_line', $offer_header_fields)){ ?>
                                <th>Shipping Line</th>
                            <?php } ?>
                            <?php if(in_array('supplier_payment_terms', $offer_header_fields)){ ?>
                                <th>Supplier Payment Terms</th>
                            <?php } ?>
                            <?php if(in_array('document_clause', $offer_header_fields)){ ?>
                                <th>Document Clause</th>
                            <?php } ?>
                            <?php if(in_array('inspection_clause', $offer_header_fields)){ ?>
                                <th>Inspection Clause</th>
                            <?php } ?>
                            <?php if(in_array('lab_report_clause', $offer_header_fields)){ ?>
                                <th>Lab Report clause</th>
                            <?php } ?>
                            <?php if(in_array('shipment_timing', $offer_header_fields)){ ?>
                                <th>Shipment Timing</th>
                            <?php } ?>
                            <?php if(in_array('etd', $offer_header_fields)){ ?>
                                <th>ETD</th>
                            <?php } ?>
                            <?php if(in_array('port_of_loading', $offer_header_fields)){ ?>
                                <th>Loading Port</th>
                            <?php } ?>
                            <?php if(in_array('production_date', $offer_header_fields)){ ?>
                                <th>Production Date</th>
                            <?php } ?>
                            <?php if(in_array('shelf_life', $offer_header_fields)){ ?>
                                <th>shelf Life</th>
                            <?php } ?>
                            
                            <?php if(in_array('label_attached', $offer_header_fields)){ ?>
                                <th>Label Attached</th>
                            <?php } ?>
                            <?php if(in_array('remarks_1', $offer_header_fields)){ ?>
                                <th>Remark 1</th>
                            <?php } ?>
                            <?php if(in_array('remarks_2', $offer_header_fields)){ ?>
                                <th>Remark 2</th>
                            <?php } ?>
                            <?php if(in_array('remarks_3', $offer_header_fields)){ ?>
                                <th>Remark 3</th>
                            <?php } ?>
                            
                            <?php if(in_array('carton_with_date', $offer_header_fields)){ ?>
                                <th>Carton With Date</th>
                            <?php } ?>

                            <?php if(in_array('product_name', $offer_details_fields) or in_array('product_name', $offer_details_fields)){ ?>
                                <th>Product Name</th>
                            <?php } ?>

                            <?php  
                            if(in_array('incoterm_id', $offer_header_fields) or in_array('buying_incoterm', $offer_header_fields)){
                            ?>
                            <th>Incoterm</th>
                            <?php } ?>

                            <?php if(in_array('freezing_type', $offer_details_fields)){ ?>
                                <th>Freezing Type</th>
                            <?php } ?>

                            <?php if(in_array('freezing_method_type', $offer_details_fields)){ ?>
                                <th>Freezing Method Type</th>
                            <?php } ?>

                             <?php if(in_array('primary_packing_type', $offer_details_fields)){ ?>
                                <th>Packing type (primary)</th>
                            <?php } ?>

                            <?php if(in_array('secondary_packing_type', $offer_details_fields)){ ?>    
                                <th>Packing type (secondary)</th>
                            <?php } ?>

                            <?php if(in_array('packing_size', $offer_details_fields)){ ?>    
                                <th>Packing Sizes</th>
                            <?php } ?>

                            <?php if(in_array('glazing_type', $offer_details_fields)){ ?>    
                                <th>Glazing</th>
                            <?php } ?>

                             <?php if(in_array('block_type', $offer_details_fields)){ ?>    
                                <th>Block</th>
                            <?php } ?>

                            <?php if(in_array('size_type', $offer_details_fields)){ ?>    
                                <th>Sizes</th>
                            <?php } ?>

                            <?php if(in_array('product_description', $offer_details_fields)){ ?>
                                <th>Product Description</th>
                            <?php } ?>

                            <?php if(in_array('pieces', $offer_details_fields)){ ?>
                                <th>Pieces</th>
                            <?php } ?>

                            <?php if(in_array('grade', $offer_details_fields)){ ?>    
                                <th>Grade</th>
                            <?php } ?>

                            <?php if(in_array('size_before_glaze', $offer_details_fields)){ ?>    
                                <th>Size before Glaze</th>
                            <?php } ?>

                            <?php if(in_array('size_after_glaze', $offer_details_fields)){ ?>    
                                <th>Size after Glaze</th>
                            <?php } ?>
                            <?php if(in_array('unit', $offer_details_fields)){ ?>    
                                <th>Unit</th>
                            <?php } ?>
                            <?php if(in_array('comment', $offer_details_fields)){ ?>    
                                <th>Comment</th>
                            <?php } ?>
                            <?php if(in_array('quantity_offered', $offer_details_fields)){ ?>    
                                <th>Quantity Offered</th>
                            <?php } ?>

                            <?php if(in_array('cartons_offered', $offer_details_fields)){ ?>    
                                <th>Cartons Offered</th>
                            <?php } ?>

                            <?php if(in_array('product_price', $offer_details_fields)){ ?>    
                                <th>Product Price</th>
                            <?php } ?>
                            <th>Total Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_amount = 0;
                            $total_qnty = 0;
                            $total_crtn = 0;
                            $total_price = 0;
                            // echo "<pre>"; print_r($offer_details); die();
                            
                            foreach($offer_details  as $key=>$vod){
                                // echo $key;
                                ?>
                                <tr>
                                    <td><?=++$key?></td>
                                <?php if(in_array('offer_name', $offer_header_fields)){ ?>
                                <td><?= $vod->offer_name ?></td>
                                <?php } ?>

                                <?php if(in_array('offer_number', $offer_header_fields)){ ?>
                                <td><?= $vod->offer_number ?></td>
                                <?php } ?>

                                <?php if(in_array('destination_country', $offer_header_fields)){ 
                                    $d_c_name = $this->db->get_where('countries', array('country_id'=>$vod->destination_c_id))->row()->name;
                                ?>
                                <td><?= $d_c_name ?></td>
                                <?php } ?>
                                <?php if(in_array('source_country', $offer_header_fields)){ 
                                    $d_s_name = $this->db->get_where('countries', array('country_id'=>$vod->country_id))->row()->name;
                                ?>
                                <td><?= $d_s_name ?></td>
                                <?php } ?>
                                <?php if(in_array('tolerance', $offer_header_fields)){ ?>
                                <td><?= $vod->tolerance ?></td>
                                <?php } ?>
                                <?php if(in_array('offer_date', $offer_header_fields)){ ?>
                                <td><?= $vod->offer_date ?></td>
                                <?php } ?>
                                <?php if(in_array('supplier_name', $offer_header_fields)){ 
                                    $supplier_name = $this->db->get_where('acc_master', array('am_id'=>$vod->am_id))->row()->name;
                                ?>
                                <td><?= $supplier_name ?></td>
                                <?php } ?>
                                <?php if(in_array('currency', $offer_header_fields)){ ?>
                                <td><?= $vod->offer_number ?></td>
                                <?php } ?>
                                <?php if(in_array('no_of_container', $offer_header_fields)){ ?>
                                <td><?= $vod->no_of_container ?></td>
                                <?php } ?>
                                <?php if(in_array('size_of_container', $offer_header_fields)){ ?>
                                <td><?= $vod->size_of_container ?></td>
                                <?php } ?>
                                <?php if(in_array('quantity_each_container', $offer_header_fields)){ ?>
                                <td><?= $vod->quantity_each_container ?></td>
                                <?php } ?>
                                <?php if(in_array('shipping_line', $offer_header_fields)){ ?>
                                <td><?= $vod->offer_number ?></td>
                                <?php } ?>
                                <?php if(in_array('supplier_payment_terms', $offer_header_fields)){ ?>
                                <td><?= $vod->supplier_payment_terms ?></td>
                                <?php } ?>
                                <?php if(in_array('document_clause', $offer_header_fields)){ ?>
                                <td><?= $vod->document_clause ?></td>
                                <?php } ?>
                                <?php if(in_array('inspection_clause', $offer_header_fields)){ ?>
                                <td><?= $vod->inspection_clause ?></td>
                                <?php } ?>
                                <?php if(in_array('lab_report_clause', $offer_header_fields)){ ?>
                                <td><?= $vod->lab_report_clause ?></td>
                                <?php } ?>
                                <?php if(in_array('shipment_timing', $offer_header_fields)){ ?>
                                <td><?= $vod->shipment_timing ?></td>
                                <?php } ?>
                                <?php if(in_array('etd', $offer_header_fields)){ ?>
                                <td><?= $vod->etd ?></td>
                                <?php } ?>
                                <?php if(in_array('port_of_loading', $offer_header_fields)){ ?>
                                <td><?= $vod->port_of_loading ?></td>
                                <?php } ?>
                                <?php if(in_array('production_date', $offer_header_fields)){ ?>
                                <td><?= $vod->production_date ?></td>
                                <?php } ?>
                                <?php if(in_array('shelf_life', $offer_header_fields)){ ?>
                                <td><?= $vod->shelf_life ?></td>
                                <?php } ?>
                                
                                <?php if(in_array('label_attached', $offer_header_fields)){ ?>
                                <td><?= $vod->label_attached ?></td>
                                <?php } ?>
                                <?php if(in_array('remarks_1', $offer_header_fields)){ ?>
                                <td><?= $vod->remarks_1 ?></td>
                                <?php } ?>
                                <?php if(in_array('remarks_2', $offer_header_fields)){ ?>
                                <td><?= $vod->remarks_2 ?></td>
                                <?php } ?>
                                <?php if(in_array('remarks_3', $offer_header_fields)){ ?>
                                <td><?= $vod->remarks_3 ?></td>
                                <?php } ?>
                                <?php if(in_array('product_id', $offer_details_fields) or in_array('product_name', $offer_details_fields)){ ?>
                                    <td>  
                                      <?= $vod->product_name . ' ('. $vod->scientific_name .')' ?>
                                    </td>
                                <?php } ?>
                                <?php  
                                if(in_array('incoterm_id', $offer_header_fields) or in_array('buying_incoterm', $offer_header_fields)){
                                ?>
                                <td><?= $vod->incoterm ?></td>
                                <?php } ?>
                                <?php if(in_array('freezing_type', $offer_details_fields)){ ?>    
                                    <td><?= $vod->freezing_type ?></td>
                                <?php } ?>

                                <?php if(in_array('freezing_method_type', $offer_details_fields)){ ?>    
                                    <td><?= $vod->freezing_method ?></td>
                                <?php } ?>
                                <?php if(in_array('primary_packing_type', $offer_details_fields)){ ?>    
                                    <td><?= $vod->packing_type ?></td>
                                <?php } ?>
                                <?php if(in_array('secondary_packing_type', $offer_details_fields)){ ?>    
                                    <td><?= $vod->pts ?></td>
                                <?php } ?>
                                <?php if(in_array('packing_size', $offer_details_fields)){ ?>    
                                    <td><?= $vod->packing_size ?></td>
                                <?php } ?>
                                <?php if(in_array('glazing_type', $offer_details_fields)){ ?>    
                                    <td><?= $vod->glazing ?></td>
                                <?php } ?>
                                <?php if(in_array('block_type', $offer_details_fields)){ ?>    
                                    <td><?= $vod->block_size ?></td>
                                <?php } ?>
                                <?php if(in_array('size_type', $offer_details_fields)){ ?>    
                                    <td>
                                        <?php if(empty($vod->size)){
                                            echo "N/A";
                                        }else{
                                            echo $vod->size . ' ('. $vod->unit .')';
                                        }
                                        ?>
                                    </td>
                                <?php } ?>
                                <?php if(in_array('product_description', $offer_details_fields)){ ?>    
                                   <td><?= $vod->product_description ?></td>
                                <?php } ?>
                                <?php if(in_array('pieces', $offer_details_fields)){ ?>    
                                    <td><?= $vod->pieces ?></td>
                                <?php } ?>
                                <?php if(in_array('grade', $offer_details_fields)){ ?>    
                                    <td><?= $vod->grade ?></td>
                                <?php } ?>


                                 <?php if(in_array('size_before_glaze', $offer_details_fields)){ ?>    
                                    <td><?= $vod->size_before_glaze ?></td>
                                <?php } ?>
                                 <?php if(in_array('size_after_glaze', $offer_details_fields)){ ?>    
                                    <td><?= $vod->size_after_glaze ?></td>
                                <?php } ?>
                                <?php if(in_array('unit', $offer_details_fields)){ ?>    
                                    <td><?= $vod->unit ?></td>
                                <?php } ?>

                                <?php if(in_array('comment', $offer_details_fields)){ ?>    
                                    <td><?= $vod->comment ?></td>
                                <?php } ?>

                                <?php if(in_array('quantity_offered', $offer_details_fields)){ ?>
                                    <td>
                                        <?php 
                                        echo $vod->quantity_offered;
                                        $total_qnty += $vod->quantity_offered 
                                        ?>
                                    </td>
                                <?php } ?>

                                
                                <?php if(in_array('cartons_offered', $offer_details_fields)){ ?>    
                                    <td>
                                        <?php 
                                        if(is_numeric($vod->cartons_offered)){
                                            $total_crtn += $vod->cartons_offered;
                                            echo $vod->cartons_offered;
                                        }else{
                                            echo 0;
                                        }
                                        ?>
                                    </td>
                                <?php } ?>

                                <?php if(in_array('product_price', $offer_details_fields)){ ?>    
                                    <td><?php 
                                        echo $vod->product_price;
                                        $total_price += $vod->product_price 
                                        ?>
                                        <?php  
                                        if(in_array('c_id', $offer_header_fields)){
                                            echo $vod->currency .'('. $vod->currency_code . ')';
                                        } 
                                        ?>
                                    </td>
                                <?php } ?> 
                                    <td>
                                        <?php
                                        echo $total_selling_price = ($vod->product_price * $vod->quantity_offered);
                                        $total_amount += ($vod->product_price * $vod->quantity_offered) 
                                        ?>
                                        <?php  
                                        //if(in_array('c_id', $offer_header_fields)){
                                        echo '('. $vod->currency_code . ')';
                                           //} 
                                        ?>
                                    </td>
                                </tr>
                                <?php } ?>
                             <tr>
                                <th></th>
                                <?php if(in_array('offer_name', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('offer_number', $offer_header_fields)){ ?>
                               <th></th>
                            <?php } ?>

                            <?php if(in_array('destination_country', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('source_country', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('tolerance', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('offer_date', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('supplier_name', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('currency', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('no_of_container', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('size_of_container', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('quantity_each_container', $offer_header_fields)){ ?>
                               <th></th>
                            <?php } ?>
                            <?php if(in_array('shipping_line', $offer_header_fields)){ ?>
                               <th></th>
                            <?php } ?>
                            <?php if(in_array('supplier_payment_terms', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('document_clause', $offer_header_fields)){ ?>
                               <th></th>
                            <?php } ?>
                            <?php if(in_array('inspection_clause', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('lab_report_clause', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('shipment_timing', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('etd', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('port_of_loading', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('production_date', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('shelf_life', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                           
                            <?php if(in_array('label_attached', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('remarks_1', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('remarks_2', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('remarks_3', $offer_header_fields)){ ?>
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('product_name', $offer_details_fields) or in_array('product_name', $offer_details_fields)){ ?>
                                <th></th>
                            <?php } ?>

                            <?php  
                            if(in_array('incoterm_id', $offer_header_fields) or in_array('buying_incoterm', $offer_header_fields)){
                            ?>
                            <th></th>
                            <?php } ?>

                            <?php if(in_array('freezing_type', $offer_details_fields)){ ?>
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('freezing_method_type', $offer_details_fields)){ ?>
                                <th></th>
                            <?php } ?>

                             <?php if(in_array('primary_packing_type', $offer_details_fields)){ ?>
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('secondary_packing_type', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('packing_size', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('glazing_type', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>

                             <?php if(in_array('block_type', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('size_type', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('product_description', $offer_details_fields)){ ?>
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('pieces', $offer_details_fields)){ ?>
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('grade', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('size_before_glaze', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>

                            <?php if(in_array('size_after_glaze', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('unit', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('comment', $offer_details_fields)){ ?>    
                                <th></th>
                            <?php } ?>
                            <?php if(in_array('quantity_offered', $offer_details_fields)){ ?>    
                                <th><?=number_format($total_qnty,2)?></th>
                            <?php } ?>

                            

                            <?php if(in_array('cartons_offered', $offer_details_fields)){ ?>    
                               <th><?=$total_crtn?></th>
                            <?php } ?>

                            <?php if(in_array('product_price', $offer_details_fields)){ ?>    
                                <th><?=number_format($total_price,2) .' ('. $vod->currency_code . ')' ?></th>
                            <?php } ?>
                            <th><?=number_format($total_amount,2) .' ('. $vod->currency_code . ')'?></th>


                            <!-- <th  style="text-align:center;">Grand Total</th> -->
                                
                            </tr>
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
      
      </script>
    </body>
  </html>