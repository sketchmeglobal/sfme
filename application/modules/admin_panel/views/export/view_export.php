    
<?php 
    
    if(empty($view_offer_data['templates'][0]) or !isset($view_offer_data['templates'][0])){
        
        die('Please finalise the offer and get accepted by the Trader in order to view the Offer. You can also communicate with the Trader from the <a href="http://seafoodmiddleeast.net/admin_panel/Offer/offer_comments/add">Comments Section</a>');
        
    }

    $templates = $view_offer_data['templates'][0];
    $offer_header = $view_offer_data['offer'][0];
    $offer_details = $view_offer_data['offer_details'];
    $selling_price = $view_offer_data['selling_price'];

    $offer_header_fields = explode(',',$templates->offer_header_fields);
    $offer_details_fields = explode(',',$templates->offer_details_fields);
    $selling_prices_fields = explode(',',$templates->selling_prices_fields);

    $country_based_customers = $view_offer_data['country_based_customers'];
    // echo '<pre>', print_r($selling_price), '</pre>';

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Offer Details</title>

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <!-- Normalize or reset CSS with your favorite library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

        <!-- Load paper.css for happy printing -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css"> -->

        <link href="https://fonts.googleapis.com/css?family=Chivo|Signika" rel="stylesheet">
        <!-- Set page size here: A5, A4 or A3 -->
        <!-- Set also "landscape" if you need -->
        <style>
            body{
                /*font-family: 'Chivo', sans-serif;*/
                font-family: Calibri;
            }
            p {
                margin: 0 0 5px;
            }
            table{ border: 1px solid #777; }
            .table{
                margin-bottom: 3px;
            }
            .head_font{
                /*font-family: 'Signika', sans-serif;*/
                font-family: Calibri;
            }
            .vodtainer{width: 100%}
            .border_all{
                border: 1px solid #000;
            }
            .border_bottom{
                border-bottom: 1px solid #000;
            }
            .border_right{border-right: 1px solid #000;}
            .mar_0{
                margin: 0
            }
            .mar_bot_3{
                margin-bottom: 3px
            }

            .header_left, .header_right{
                height: 150px
            }

            .bg-grey{background: #ececec;}

            .width-100{width: 100%}

            .height_60{ height: 60px }
            .height_42{ height: 42px }
            .height_135{height: 150px}
            .height_90{height: 90px}
            .height_100{height: 100px}
            .height_110{height: 110px}
            .height_41{ height: 41px }
            .height_23{ height: 23px }
            .height_63{ height: 63px }
            .height_21{ height: 21px }

            .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th { border: 1px solid #000!important;  text-align: center;}
            .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 5px; text-align: left; font-size: 13px}

            .border-bottom{border-bottom:  1px solid #000}

            @page { size: A4 }

            @media print{
                .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th { border: 1px solid #000;  text-align: center;}
                .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 5px; text-align: left; font-size: 13px}
                .col-md-4 {width: 33.33333333%;float:left}.col-sm-6{ width: 50%!important;float:left; }.col-sm-5 { width: 41.66666667%;float:left; }.col-sm-7 { width: 58.33333333%;float:left; }
                .border-bottom{border-bottom:  1px solid #000}
                /*body.A4 .sheet{*/
                /*    height: 500px;*/
                /*}*/
                thead{
                    margin-top: 15px;
                }
            }
            body.A4 .sheet{
                height: 7000px
            }
            thead{
                margin-top: 15px;
            }
        </style>
    </head>

    <!-- Set "A5", "A4" or "A3" for class name -->
    <!-- Set also "landscape" if you need -->
    <body class="A4 landscape" id="page-content">
                <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <?php (isset($upgrade_rate)) ? '<div class="alert alert-success">Approval request sent successfully</div>' : '' ?>
        <section class="sheet padding-10mm" style="height: auto; padding: 25px;">
            <div>
                
                <div class="clearfix"></div>
                <div class="container-fluid">
                    <div class="row border_all text-center text-uppercase mar_bot_3 bg-info">
                        <h3 class="mar_0 head_font">Offer : <?= $offer_header->offer_name ?> / <?= $offer_header->offer_number ?></h3>
                    </div>  
                    <div class="row mar_bot_3">
                        <div class="col-sm-3 border_all header_left">
                            <h3 class="mar_0">Company Details</h3>
                            <?php if($this->uri->segment(4) == 'comp1'){
                                
                                echo COMP1;
                                
                            }else{
                                
                                echo COMP2;
                                
                            } ?>
                            
                        </div>
                        <div class="col-sm-3 border_all header_left">
                            <!-- < ?php if(in_array('am_id', $offer_header_fields) or in_array('supplier_name', $offer_header_fields)){
                                ?>
                                <p class="mar_0">
                                    <strong>Supplier Name:</strong>
                                    < ?= $offer_header->supplier_name ?>/< ?= $offer_header->supplier_code ?>
                                </p>
                                <p class="mar_0">
                                    <strong>Supplier Address:</strong>
                                    < ?= $offer_header->supplier_name ?>/
                                </p>
                                <p class="mar_0">
                                    <strong>Shipment Address:</strong>
                                    < ?= $offer_header->supplier_name ?>/
                                </p>
                                < ?php
                            } 
                            ?> -->
                            <?php if(in_array('offer_name', $offer_header_fields)){
                                ?>
                                <h3 class="mar_0">Offer Details</h3>
                                <hr>
                                <h5 class="mar_0">
                                    <strong>Offer Name : </strong>
                                    <?= $offer_header->offer_name ?>
                                </h5>
                                <?php }  
                                if(in_array('offer_number', $offer_header_fields)){
                                ?>
                                <h5 class="mar_0">
                                    <strong>Offer No. : </strong>
                                    <?= $offer_header->offer_number ?>
                                </h5>
                                <?php } ?>
                                <?php  
                                if(in_array('offer_date', $offer_header_fields)){
                                ?>
                                <h5 class="mar_0">
                                    <strong>Offer Date : </strong>
                                    <?= date('d-m-Y', strtotime($offer_header->offer_date)) ?>
                                </h5>
                            <?php } ?>

                        </div>
                        <div class="col-sm-6 header_right">
                            <div class="row">
                                <div class="col-sm-6 border_all height_135">
                                    <h3 class="mar_0">Contact Details</h3>
                                    <hr>
                                    <h5 class="mar_0">
                                        <strong>Contact Personnel : </strong>
                                        <?= $this->session->name ?>
                                    </h5>
                                </div>
                                <div class="col-sm-6 border_all height_135">
                                    <h3 class="mar_0">Country Details</h3>
                                    <hr>
                                    <?php   
                                    if(in_array('country_id', $offer_header_fields) or in_array('source_country', $offer_header_fields)){
                                    ?>
                                    <p class="mar_0">
                                        <strong>Origin:</strong>
                                        <?= $offer_header->name ?>/<?= $offer_header->iso ?>
                                    </p>
                                    <?php } ?>
                                    <?php  
                                if(in_array('destination_c_id', $offer_header_fields)){
                                ?>
                                    <p class="mar_0">
                                        <strong>Destination Countries:</strong>
                                        <?php #echo $offer_header->name .' / '. $offer_header->iso ?>
                                    </p>
                                <?php } ?>   
                                </div>
                            </div>
                            
                            <!-- <div class="row border_all height_21">
                                <div class="col-sm-12">
                                    <p class="mar_0">
                                        <strong>Resource:</strong> <?= $offer_header->firstname . ' ' . $offer_header->lastname . ' ('.$offer_header->username.')' ?></p>
                                </div>
                            </div> -->
                        </div>
                    </div>

                    <div class="row border_all text-center text-uppercase mar_bot_3 bg-info">
                        <h3 class="mar_0 head_font">Offer Particulars</h3>
                    </div> 

                    <div class="row">
                        <?php  
                        if(in_array('no_of_container', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>No of container</strong>: <?=$offer_header->no_of_container?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('size_of_container', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>container Size</strong>: <?=$offer_header->size_of_container?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('quantity_each_container', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Quantity/container</strong>: <?=$offer_header->quantity_each_container?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('shipping_line', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Shipping Line</strong>: <?=$offer_header->shipping_line?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('shipment_timing', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Shipment Timing</strong>: <?=$offer_header->shipment_timing?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('supplier_payment_terms', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Supplier payment terms</strong>: <?=$offer_header->supplier_payment_terms?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('etd', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>ETD</strong>: <?=$offer_header->etd?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('port_of_loading', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Port of Loading</strong>: <?=$offer_header->port_name?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('document_clause', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Document Clause</strong>: <?=$offer_header->document_clause?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('inspection_clause', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Inspection Clause</strong>: <?=$offer_header->inspection_clause?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('lab_report_clause', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Lab Report Clause</strong>: <?=$offer_header->lab_report_clause?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('production_date', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Production date</strong>: <?=$offer_header->production_date?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('shelf_life', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Shelf life</strong>: <?=$offer_header->shelf_life?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('tolerance', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Tolerance</strong>: <?=$offer_header->tolerance?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('label_attached', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Label attached</strong>: <?=$offer_header->label_attached?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('carton_with_date', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Carton Printed with Production Date?</strong>: <?=$offer_header->carton_with_date?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('remarks_1', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Remark 1</strong>: <?=$offer_header->remark?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('remarks_2', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Remark 2</strong>: <?=$offer_header->remarks_2?>
                        </div>
                        <?php } ?>
                        <?php  
                        if(in_array('remarks_3', $offer_header_fields)){
                        ?>
                        <div class="col-md-4 mar_bot_3 border_all height_21">
                            <strong>Remark 3</strong>: <?=$offer_header->remarks_3?>
                        </div>
                        <?php } ?>
                    </div>

                    <!--table data-->
                    <div class="row">
                       <div class="border_all text-center text-uppercase mar_bot_3 bg-info">
                            <h3 class="mar_0 head_font">Product Details</h3>
                        </div>
                        <div class="table-responsive">
                        <table id="" class="table table-bordered table-hover width-100 table2excel offer_details" >
                                <thead>
                                    <tr>
                                    <?php if(in_array('product_id', $offer_details_fields) or in_array('product_name', $offer_details_fields)){ ?>
                                        <th>Product Name</th>
                                    <?php } ?>

                                    <?php  
                                    if(in_array('incoterm_id', $offer_header_fields) or in_array('buying_incoterm', $offer_header_fields)){
                                    ?>
                                    <th>Incoterm</th>
                                    <?php } ?>

                                    <?php if(in_array('freezing_method_id', $offer_details_fields)){ ?>
                                        <th>Freezing Type</th>
                                    <?php } ?>
                                    <?php if(in_array('primary_packing_type_id', $offer_details_fields)){ ?>
                                        <th>Packing type (primary)</th>
                                    <?php } ?>
                                    <?php if(in_array('secondary_packing_type_id', $offer_details_fields)){ ?>    
                                        <th>Packing type (secondary)</th>
                                    <?php } ?>
                                    <?php if(in_array('packing_size_id', $offer_details_fields)){ ?>    
                                        <th>Packing Sizes</th>
                                    <?php } ?>
                                    <?php if(in_array('freezing_method_id', $offer_details_fields)){ ?>    
                                        <th>Freezing Method</th>
                                    <?php } ?>
                                    <?php if(in_array('glazing_id', $offer_details_fields)){ ?>    
                                        <th>Glazing</th>
                                    <?php } ?>
                                    <?php if(in_array('block_id', $offer_details_fields)){ ?>    
                                        <th>Block</th>
                                    <?php } ?>
                                    <?php if(in_array('size_id', $offer_details_fields)){ ?>    
                                        <th>Sizes</th>
                                    <?php } ?>
                                    <?php if(in_array('size_before_glaze', $offer_details_fields)){ ?>    
                                        <th>Size before Glaze</th>
                                    <?php } ?>
                                    <?php if(in_array('size_after_glaze', $offer_details_fields)){ ?>    
                                        <th>Size after Glaze</th>
                                    <?php } ?>
                                    <?php if(in_array('cartons_offered', $offer_details_fields)){ ?>    
                                        <th>Cartons Offered</th>
                                    <?php } ?>
                                    <?php if(in_array('quantity_offered', $offer_details_fields)){ ?>    
                                        <th>Quantity Offered</th>
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
                                    foreach($offer_details  as $vod){
                                        ?>
                                        <tr>
                                        <?php if(in_array('product_id', $offer_details_fields) or in_array('product_name', $offer_details_fields)){ ?>
                                            <td><?= $vod->product_name . ' ('. $vod->scientific_name .')' ?>
                                            </td>
                                        <?php } ?>
                                        <?php  
                                        if(in_array('incoterm_id', $offer_header_fields) or in_array('buying_incoterm', $offer_header_fields)){
                                        ?>
                                        <td><?= $offer_header->incoterm ?></td>
                                        <?php } ?>
                                        <?php if(in_array('freezing_method_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->freezing_type ?></td>
                                        <?php } ?>
                                        <?php if(in_array('primary_packing_type_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->packing_type ?></td>
                                        <?php } ?>
                                        <?php if(in_array('secondary_packing_type_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->pts ?></td>
                                        <?php } ?>
                                        <?php if(in_array('packing_size_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->packing_size ?></td>
                                        <?php } ?>
                                        <?php if(in_array('freezing_method_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->freezing_method ?></td>
                                        <?php } ?>
                                        <?php if(in_array('glazing_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->glazing ?></td>
                                        <?php } ?>
                                        <?php if(in_array('block_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->block_size ?></td>
                                        <?php } ?>
                                        <?php if(in_array('size_id', $offer_details_fields)){ ?>    
                                            <td><?= $vod->size . ' ('. $vod->unit .')' ?></td>
                                        <?php } ?>
                                        <?php if(in_array('size_before_glaze', $offer_details_fields)){ ?>    
                                            <td><?= $vod->size_before_glaze ?></td>
                                        <?php } ?>
                                        <?php if(in_array('size_after_glaze', $offer_details_fields)){ ?>    
                                            <td><?= $vod->size_after_glaze ?></td>
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
                                        <?php if(in_array('quantity_offered', $offer_details_fields)){ ?>
                                            <td>
                                                <?php 
                                                echo $vod->quantity_offered;
                                                $total_qnty += $vod->quantity_offered 
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
                                                echo $offer_header->currency .'('. $offer_header->currency_code . ')';
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
                                                if(in_array('c_id', $offer_header_fields)){
                                                echo $offer_header->currency .'('. $offer_header->currency_code . ')';
                                                   } 
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <!-- <tr>
                                        <th colspan="10">Grand Total</th>
                                        <th><?=$total_crtn?></th>
                                        <th><?=$total_qnty?></th>
                                        <th><?=$total_price?></th>
                                        <th><?=$total_amount?></th>
                                    </tr> -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php 
                    if($this->session->usertype != 2){
                    ?>
                    
                    <form method="POST">
                        <div class="row">
                           <div class="border_all text-center text-uppercase mar_bot_3 bg-info">
                                <h3 class="mar_0 head_font">Customer Wise Price</h3>
                            </div>
                            
                            <div class="table-responsive">
                                <table id="" class="table table-bordered table-hover width-100 table2excel offer_details" >
                                    <thead>
                                        <tr>
                                            <th>Country Name*</th>        
                                            <th>Customer Name*</th>
                                            <th>Product Name*</th>            
                                        <?php if(in_array('selling_incoterm', $selling_prices_fields)){ ?>
                                            <th>Incoterm</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_country', $selling_prices_fields)){ ?>
                                            <th>Country</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_currency', $selling_prices_fields)){ ?>
                                            <th>Currency</th>
                                        <?php } ?>
                                        <?php if(in_array('customer', $selling_prices_fields)){ ?>
                                            <th>Customer</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item', $selling_prices_fields)){ ?>
                                            <th>Line item1</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price', $selling_prices_fields)){ ?>
                                            <th>Other price1</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment1</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item2', $selling_prices_fields)){ ?>
                                            <th>Line item2</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price2', $selling_prices_fields)){ ?>
                                            <th>Other price2</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment2', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment2</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item3', $selling_prices_fields)){ ?>
                                            <th>Line item3</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price3', $selling_prices_fields)){ ?>
                                            <th>Other price3</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment3', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment3</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item4', $selling_prices_fields)){ ?>
                                            <th>Line item4</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price4', $selling_prices_fields)){ ?>
                                            <th>Other price4</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment4', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment4</th>
                                        <?php } ?>                               
                                        <?php if(in_array('freight', $selling_prices_fields)){ ?>
                                            <th>Freight</th>
                                        <?php } ?>
                                        <?php if(in_array('margin_flat', $selling_prices_fields)){ ?>
                                            <th>Margin (flat)</th>
                                        <?php } ?>
                                        <?php if(in_array('margin_percentage', $selling_prices_fields)){ ?>
                                            <th>Margin (percentage)</th>
                                        <?php } ?>
                                        <?php if(in_array('final_selling_price', $selling_prices_fields)){ ?>
                                            <th>Selling Price</th>
                                        <?php } ?>
                                            <th>Incoterm / Exchange rate*</th>
                                            <th>Final Selling Price*</th>
                                            <th>Action (Change selling price)</th>
                                            <th>Mail</th>
                                        </tr>    
                                    </thead>
                                    <tbody>

                                    <?php foreach($selling_price as $sp): ?>
                                        <?php 
                                        if($sp->customer_name == ''){
                                            continue;
                                        }
                                        ?>

                                        <tr>
                                            <td><?=$sp->name?></td>
                                            <td> 
                                                <select disabled="" class="form-control" name="customer_id[]">
                                                    <option value="<?=$sp->am_id?>">
                                                        <?=$sp->customer_name?>
                                                    </option>
                                                </select>
                                            </td>
                                            <td><?=$sp->product_name ?></td>
                                        <?php if(in_array('selling_incoterm', $selling_prices_fields)){ ?>
                                            <td><?=$sp->incoterm?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_country', $selling_prices_fields)){ ?>
                                            <td><?=$sp->name . '('.$sp->iso.')'?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_currency', $selling_prices_fields)){ ?>
                                            <td><?=$sp->currency . '('.$sp->symbol.')'?></td>
                                        <?php } ?>
                                        <?php if(in_array('customer', $selling_prices_fields)){ ?>
                                            <td><?=$sp->customer_name . '('.$sp->customer_code.')'?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item2', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin2?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price2', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price2?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment2', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment2?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item3', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin3?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price3', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price3?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment3', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment3?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item4', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin4?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price4', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price4?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment4', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment4?></td>
                                        <?php } ?>
                                        <?php if(in_array('freight', $selling_prices_fields)){ ?>
                                            <td><?=$sp->freight?></td>
                                        <?php } ?>
                                        <?php if(in_array('margin_flat', $selling_prices_fields)){ ?>
                                            <td><?=$sp->margin_flat?></td>
                                        <?php } ?>
                                        <?php if(in_array('margin_percentage', $selling_prices_fields)){ ?>
                                            <td><?=$sp->margin_percentage?></td>
                                        <?php } ?>
                                        <?php if(in_array('final_selling_price', $selling_prices_fields)){ ?>
                                            <td>
                                                <?php
                                                if($sp->mar_selling_approval_status and $sp->mar_selling_rate != 0){
                                                    echo $sp->mar_selling_rate;
                                                }else{
                                                    echo $sp->final_selling_price;
                                                }
                                                ?>
                                            </td>
                                        <?php } ?>
                                            <td><?= $sp->incoterm . '/' .$sp->exchange_rate ?></td>
                                            <td>
                                                <?php
                                                if($sp->mar_selling_approval_status and $sp->mar_selling_rate != 0){
                                                    echo ($sp->mar_selling_rate * $sp->exchange_rate) . ' ' . $sp->currency;
                                                }else{
                                                    echo ($sp->final_selling_price * $sp->exchange_rate) . ' ' . $sp->currency;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                            <?php if($this->session->usertype == 3 and $sp->mar_selling_status == 0){
                                                /*Marketing*/
                                                ?>
                                                <form class="customer_selling_form" method="POST">
                                                    <input data-min="<?=$sp->final_selling_price?>" class="form-control" type="number" step="0.50" name="mar_selling_rate">
                                                    <input type="submit" class="btn btn-info btn-sm" name="upgrade_rate"  value="Request">
                                                    <!-- HIDDEN FIELDS -->
                                                     <input type="hidden" value="<?=$sp->final_selling_price?>" name="mar_base_price">
                                                    <input type="hidden" value="<?=$sp->sp_id?>" name="mar_sp_id">
                                                </form>
                                                <?php
                                            }else if($this->session->usertype == 3 and $sp->mar_selling_status == 1){

                                                echo 'Awaiting approval'; 

                                            }else if($sp->mar_selling_status == 1){
                                                /*admin*/
                                                ?>
                                                <form method="POST">
                                                <input class="form-control" readonly="" type="number" step="0.50" value="<?=$sp->mar_selling_rate?>" name="mar_selling_rate">
                                                <input type="submit" class="btn btn-info btn-sm" name="approve_upgrade_rate" value="Approve">
                                                <input type="submit" class="btn btn-danger btn-sm" name="decline_upgrade_rate" value="Decline">
                                                <!-- HIDDEN FIELDS -->
                                                <input type="hidden" value="<?=$sp->sp_id?>" name="admin_sp_id">
                                                </form>

                                                <?php 
                                                }else{
                                                    // echo ($sp->mar_selling_rate == 0) ? '-' : $sp->mar_selling_rate;
                                                    echo '-';
                                                }  
                                            ?>
                                            </td>
                                            <td> 
                                                <input type="checkbox" name="spd_id[]" value="<?= $sp->spd_id ?>"> 
                                                <input disabled="" type="hidden" value="<?=$sp->sp_id?>" name="sp_id_mail[]">
                                            </td>
                                        </tr>

                                    <?php endforeach ?>
                                        
                                    </tbody> 
                                </table>   
                            </div>
                        </div>

                        <div class="row">
                           <div class="border_all text-center text-uppercase mar_bot_3 bg-info">
                                <h3 class="mar_0 head_font">Country Wise Client Price</h3>
                            </div>

                            <div class="table-responsive">
                                <table id="" class="table table-bordered table-hover width-100 table2excel offer_details" >
                                    <thead>
                                        <tr>
                                            <th>Country Name*</th>        
                                            <th>Customer Name*</th>
                                            <th>Product Name*</th>            
                                        <?php if(in_array('selling_incoterm', $selling_prices_fields)){ ?>
                                            <th>Incoterm</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_country', $selling_prices_fields)){ ?>
                                            <th>Country</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_currency', $selling_prices_fields)){ ?>
                                            <th>Currency</th>
                                        <?php } ?>
                                        <?php if(in_array('customer', $selling_prices_fields)){ ?>
                                            <th>Customer</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item', $selling_prices_fields)){ ?>
                                            <th>Line item1</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price', $selling_prices_fields)){ ?>
                                            <th>Other price1</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment1</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item2', $selling_prices_fields)){ ?>
                                            <th>Line item2</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price2', $selling_prices_fields)){ ?>
                                            <th>Other price2</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment2', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment2</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item3', $selling_prices_fields)){ ?>
                                            <th>Line item3</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price3', $selling_prices_fields)){ ?>
                                            <th>Other price3</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment3', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment3</th>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item4', $selling_prices_fields)){ ?>
                                            <th>Line item4</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price4', $selling_prices_fields)){ ?>
                                            <th>Other price4</th>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment4', $selling_prices_fields)){ ?>
                                            <th>Other Price Comment4</th>
                                        <?php } ?>                               
                                        <?php if(in_array('freight', $selling_prices_fields)){ ?>
                                            <th>Freight</th>
                                        <?php } ?>
                                        <?php if(in_array('margin_flat', $selling_prices_fields)){ ?>
                                            <th>Margin (flat)</th>
                                        <?php } ?>
                                        <?php if(in_array('margin_percentage', $selling_prices_fields)){ ?>
                                            <th>Margin (percentage)</th>
                                        <?php } ?>
                                        <?php if(in_array('final_selling_price', $selling_prices_fields)){ ?>
                                            <th>Selling Price</th>
                                        <?php } ?>
                                            <th>Incoterm / Exchange rate*</th>
                                            <th>Final Selling Price*</th>
                                            <th>Action (Change selling price)</th>
                                            <th>Mail</th>
                                        </tr>    
                                    </thead>
                                    <tbody>

                                    <?php foreach($selling_price as $sp): ?>
                                        <?php 
                                        if($sp->customer_name != ''){
                                            continue;
                                        }
                                        ?>

                                        <tr>
                                            <td><?=$sp->name?></td>
                                            <td>
                                            <select disabled="" name="customer_id[]" class="select2 form-control">
                                            <?php 
                                            foreach($country_based_customers as $cbc){
                                                if($cbc->name == $sp->name){
                                                    ?>
                                                <option value="<?=$cbc->am_id?>">
                                                    <?= $cbc->customer_name ?>
                                                </option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            </select>
                                            </td>
                                            <td><?=$sp->product_name ?></td>
                                        <?php if(in_array('selling_incoterm', $selling_prices_fields)){ ?>
                                            <td><?=$sp->incoterm?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_country', $selling_prices_fields)){ ?>
                                            <td><?=$sp->name . '('.$sp->iso.')'?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_currency', $selling_prices_fields)){ ?>
                                            <td><?=$sp->currency . '('.$sp->symbol.')'?></td>
                                        <?php } ?>
                                        <?php if(in_array('customer', $selling_prices_fields)){ ?>
                                            <td><?=$sp->customer_name . '('.$sp->customer_code.')'?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item2', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin2?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price2', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price2?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment2', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment2?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item3', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin3?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price3', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price3?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment3', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment3?></td>
                                        <?php } ?>
                                        <?php if(in_array('selling_line_item4', $selling_prices_fields)){ ?>
                                            <td><?=$sp->lin4?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price4', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price4?></td>
                                        <?php } ?>
                                        <?php if(in_array('other_price_comment4', $selling_prices_fields)){ ?>
                                            <td><?=$sp->other_price_comment4?></td>
                                        <?php } ?>
                                        <?php if(in_array('freight', $selling_prices_fields)){ ?>
                                            <td><?=$sp->freight?></td>
                                        <?php } ?>
                                        <?php if(in_array('margin_flat', $selling_prices_fields)){ ?>
                                            <td><?=$sp->margin_flat?></td>
                                        <?php } ?>
                                        <?php if(in_array('margin_percentage', $selling_prices_fields)){ ?>
                                            <td><?=$sp->margin_percentage?></td>
                                        <?php } ?>
                                        <?php if(in_array('final_selling_price', $selling_prices_fields)){ ?>
                                            <td>
                                                <?php
                                                if($sp->mar_selling_approval_status and $sp->mar_selling_rate != 0){
                                                    echo $sp->mar_selling_rate;
                                                }else{
                                                    echo $sp->final_selling_price;
                                                }
                                                ?>
                                            </td>
                                        <?php } ?>
                                            <td><?= $sp->incoterm . '/' .$sp->exchange_rate ?></td>
                                            <td>
                                                <?php
                                                if($sp->mar_selling_approval_status and $sp->mar_selling_rate != 0){
                                                    echo ($sp->mar_selling_rate * $sp->exchange_rate) . ' ' . $sp->currency;
                                                }else{
                                                    echo ($sp->final_selling_price * $sp->exchange_rate) . ' ' . $sp->currency;
                                                }
                                                ?>
                                            </td>
                                            <td>
                                            <?php if($this->session->usertype == 3 and $sp->mar_selling_status == 0){
                                                /*Marketing*/
                                                ?>
                                                <form method="POST">
                                                    <input min="<?=$sp->final_selling_price?>" class="form-control" type="number" step="0.50" name="mar_selling_rate">
                                                    <input type="submit" class="btn btn-info btn-sm" name="upgrade_rate"  value="Request">
                                                    <!-- HIDDEN FIELDS -->
                                                    <input type="hidden" value="<?=$sp->sp_id?>" name="mar_sp_id">
                                                </form>
                                                <?php
                                            }else if($this->session->usertype == 3 and $sp->mar_selling_status == 1){

                                                echo 'Awaiting approval'; 

                                            }else if($sp->mar_selling_status == 1){
                                                /*admin*/
                                                ?>
                                                <form method="POST">
                                                <input class="form-control" readonly="" type="number" step="0.50" value="<?=$sp->mar_selling_rate?>" name="mar_selling_rate">
                                                <input type="submit" class="btn btn-info btn-sm" name="approve_upgrade_rate" value="Approve">
                                                <input type="submit" class="btn btn-danger btn-sm" name="decline_upgrade_rate" value="Decline">
                                                <!-- HIDDEN FIELDS -->
                                                <input type="hidden" value="<?=$sp->sp_id?>" name="admin_sp_id">
                                                </form>

                                                <?php 
                                                }else{
                                                    // echo ($sp->mar_selling_rate == 0) ? '-' : $sp->mar_selling_rate;
                                                    echo '-';
                                                }  
                                            ?>
                                            </td>
                                            <td>
                                                <input type="checkbox" value="<?= $sp->spd_id ?>" name="spd_id[]">
                                                <input disabled="" type="hidden" value="<?=$sp->sp_id?>" name="sp_id_mail[]">
                                            </td>
                                        </tr>

                                    <?php endforeach ?>
                                        
                                    </tbody> 
                                </table>   
                            </div>
                        </div>   
                       
                        <div class="row">
                            <div class="pull-right">
                                <?php if($this->session->usertype == 3 and $offer_header->final_marketing_approval_status == 1){ ?>
                                <input type="submit" name="mar_final_btn" class="btn btn-success btn-large pull-right" value="Forward to Client"/>
                                <?php } ?>
                            </div>
                        </div>
                    </form>
                    
                    <?php
                    }
                    ?>
                </div>
            </div>
        </section>

<!-- Placed js at the end of the document so the pages load faster -->
    <script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function(){

            $("input[type=checkbox]").click(function(){

                if($(this).prop('checked')){
                    
                    $(this).closest('tr').find('td:eq(1) select').removeAttr('disabled');
                    $(this).closest('tr').find('td:eq(12) input:eq(1)').removeAttr('disabled');

                }else{

                    $(this).closest('tr').find('td:eq(1) select').prop('disabled', true);
                    $(this).closest('tr').find('td:eq(12) input:eq(1)').prop('disabled', true);

                }

            });
            
        });
       
    </script>


    </body>
</html>
