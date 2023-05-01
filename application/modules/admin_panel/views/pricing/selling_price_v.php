<?php #echo '<pre>',print_r($offer_selling_price), '</pre>'; die; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?> | <?=WEBSITE_NAME;?></title>
    <meta name="description" content="<?=$title?>">

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
        table a{min-width: 75px;}
    </style>
</head>

<body class="sticky-header">

<section>
    <!-- sidebar left start (Menu)-->
    <?php $this->load->view('components/left_sidebar'); //left side menu ?>
    <!-- sidebar left end (Menu)-->

    <!-- body content start-->
    <div class="body-content" style="min-height: 1500px;">

        <!-- header section start-->
        <?php $this->load->view('components/top_menu'); ?>
        <!-- header section end-->

        <!--body wrapper start-->
        <div class="wrapper">
            
            <div class="row text-enter">
                <span class="badge badge-right">Offer: <?=$offer_name?></span>
                <span class="badge badge-left">Product: <?=$product?></span>
            </div>

            <div class="row text-enter">
                <!-- <span class="badge badge-right">Original incoterm in: </span> -->
                <span class="badge badge-left">Original buying price / incoterm : <?=$final_buying_price?> (<?=$currency_symbol?>) / <?=$original_incoterm?></span>
            </div>

            <div class="row">
                <div class="col-md-12">
                    
                    <button data-toggle="modal" data-target="#exportPricingModal" data-offer_id="<?=$offer_id?>" href="" class="btn bg-warning badge-right export-pricing"><i class="fa fa-check"></i> Export</button>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="panel">
                        <div class="panel-heading">
                            Common Selling Price Details
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </div>
                        <div class="panel-body">
                            <form autocomplete="off" id="form_add_selling_price" method="post" action="<?=base_url('admin/form-add-selling-price')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="selling_incoterm_id text-danger">Selling Incoterms*</label>
                                        <select required="" name="selling_incoterm_id" id="selling_incoterm_id" class="form-control select2">
                                            <option value='' disabled selected>Select your option</option>
                                            <?php 
                                            foreach($incoterms as $in){
                                                ?>
                                                <option value="<?=$in->it_id?>"><?=$in->incoterm?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="currency_id">Currency*</label>
                                        <select disabled="" name="currency_id" id="currency_id" class="form-control select2">
                                            <option value='' disabled selected>Source currency considered</option>
                                            <?php 
                                            foreach($currencies as $ci){
                                                ?>
                                                <option value="<?=$ci->c_id?>"><?=$ci->currency .' ['.$ci->symbol.']'?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="country_id text-danger">Country</label>
                                        <select disabled="" name="country_id" id="country_id" class="form-control select2">
                                            <option value='' disabled selected>All countries considered</option>
                                            <?php 
                                            foreach($countries as $in){
                                                ?>
                                                <option value="<?=$in->country_id?>"><?=$in->name. ' ['.$in->iso3.']'?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="acc_masters text-danger">Customer</label>
                                        <select disabled="" name="acc_masters[]" id="acc_masters" class="form-control select2">
                                            <option value='' disabled selected>All customers considered</option>
                                            <?php 
                                            foreach($acc_masters as $in){
                                                ?>
                                                <option value="<?=$in->am_id?>"><?=$in->name . ' ['.$in->am_code.']'?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="li_category">Item Type1</label>
                                        <select name="li_category" id="li_category" class="form-control select2">
                                            <option value="" disabled selected>Select your option</option>
                                            <option value="Line Item">Line Item</option>
                                            <option value="First Level">First Level</option>
                                            <option value="Second Level">Second Level</option>
                                            <option value="Third Level">Third Level</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="li_id">Line Items1</label>
                                        <select name="li_id" id="li_id" class="form-control select2">
                                            <option value="" disabled selected>Select item type first</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price text-danger">Other price1 (<?=$currency_symbol?>) </label>
                                        <input required="" type="number" value="0" id="other_price" name="other_price" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price_comment">Other price comment1</label>
                                        <input type="text" id="other_cost_comment" name="other_cost_comment" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="li_category2">Item Type2</label>
                                        <select name="li_category2" id="li_category2" class="form-control select2">
                                            <option value="" disabled selected>Select your option</option>
                                            <option value="Line Item">Line Item</option>
                                            <option value="First Level">First Level</option>
                                            <option value="Second Level">Second Level</option>
                                            <option value="Third Level">Third Level</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="li_id2">Line Items2</label>
                                        <select name="li_id2" id="li_id2" class="form-control select2">
                                            <option value="" disabled selected>Select item type first</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price2 text-danger">Other price2 (<?=$currency_symbol?>) </label>
                                        <input required="" type="number" value="0" id="other_price2" name="other_price2" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price_comment2">Other price comment2</label>
                                        <input type="text" id="other_cost_comment2" name="other_cost_comment2" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="li_category3">Item Type3</label>
                                        <select name="li_category3" id="li_category3" class="form-control select2">
                                            <option value="" disabled selected>Select your option</option>
                                            <option value="Line Item">Line Item</option>
                                            <option value="First Level">First Level</option>
                                            <option value="Second Level">Second Level</option>
                                            <option value="Third Level">Third Level</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="li_id3">Line Items3</label>
                                        <select name="li_id3" id="li_id3" class="form-control select2">
                                            <option value="" disabled selected>Select item type first</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price3 text-danger">Other price3 (<?=$currency_symbol?>) </label>
                                        <input required="" type="number" value="0" id="other_price3" name="other_price3" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price_comment3">Other price comment3</label>
                                        <input type="text" id="other_cost_comment3" name="other_cost_comment3" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="li_category4">Item Type4</label>
                                        <select name="li_category4" id="li_category4" class="form-control select2">
                                            <option value="" disabled selected>Select your option</option>
                                            <option value="Line Item">Line Item</option>
                                            <option value="First Level">First Level</option>
                                            <option value="Second Level">Second Level</option>
                                            <option value="Third Level">Third Level</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="li_id4">Line Items4</label>
                                        <select name="li_id4" id="li_id4" class="form-control select2">
                                            <option value="" disabled selected>Select item type first</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price4 text-danger">Other price4 (<?=$currency_symbol?>) </label>
                                        <input required="" type="number" value="0" id="other_price4" name="other_price4" class="form-control">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="other_price_comment4">Other price comment4</label>
                                        <input type="text" id="other_cost_comment4" name="other_cost_comment4" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <label for="freight text-danger">Freight*</label>
                                        <input required="" value="0" type="number" id="freight" name="freight" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="margin_flat text-danger">Margin (Flat)</label>
                                        <input required="" value="0" type="number" id="margin_flat" name="margin_flat" class="form-control">
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="margin_percentage text-danger">Margin (%)</label>
                                        <input required="" type="number" id="margin_percentage" name="margin_percentage" value="0" class="form-control">
                                    </div>
                                    <div class="col-lg-2 pull-right">
                                        <div class="row text-center">
                                            <div class="col-md-6">
                                                <label for="selling_price_submit" id="bps">Add</label><br>
                                                <input type="submit" id="selling_price_submit" name="selling_price_submit" class="btn btn-success" value="Insert">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="selling_price_submit" id="bpu">Update</label><br>
                                        
                                                <input type="submit" name="selling_price_submit" class="btn btn-success" value="Update">
                                            </div>
                                        </div>
                                        <!-- HIDDEN FIELDS -->
                                        <input required="" type="hidden" id="final_selling_price" name="final_selling_price" value="0">
                                        <input required="" type="hidden" id="product_price" name="product_price" value="<?=$final_buying_price?>">
                                        <input required="" type="hidden" id="od_id" name="od_id" value="<?=$od_id?>">
                                        <input type="hidden" name="sp_id" id="sp_id" value="">
                                    </div>
                                </div>
                            </form>    

                            <div class="row"><hr></div>

                            <div class="row">

                                <div class="panel-heading">
                                    Common Selling Price Data
                                </div>

                                <div class="col-lg-12 text-right">
                                   <table id="selling_price_table" class="table data-table dataTable">
                                        <thead>
                                            <tr>
                                                <th>Incoterm (Sell)</th>
                                                <th>Country</th>
                                                <th>Currency</th>
                                                <th>Customer</th>
                                                <th>Margin (Flat)</th>
                                                <th>Margin (%)</th>
                                                <th>Freight Amount</th>
                                                <th>Line Item1</th>
                                                <th>Other Price1</th>
                                                <th>Other Price Comment1</th>

                                                <th>Line Item2</th>
                                                <th>Other Price2</th>
                                                <th>Other Price Comment2</th>

                                                <th>Line Item3</th>
                                                <th>Other Price3</th>
                                                <th>Other Price Comment3</th>

                                                <th>Line Item4</th>
                                                <th>Other Price4</th>
                                                <th>Other Price Comment4</th>

                                                <th>Final Selling Price</th>
                                                <th>Actions</th>
                                            </tr>
                                            <tr class="bg-green">
                                                <th colspan="21">Buying Product price: <?=$final_buying_price?> (<?=$currency_symbol?>) / <?=$original_incoterm?></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table> 
                                   
                                </div>
                            </div>

                        </div>
                    </div> 
                                            
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="panel">
                        <div class="panel-heading">
                            Country-wise Selling Price Details <b>(Source currency in: <?=$source_currency?>)</b>
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </div>
                        <div class="panel-body">
                            <?php  //echo "<pre>"; print_r($ports); die(); ?>
                            <form autocomplete="on" id="form_add_country_wise_selling_price" method="post" action="<?=base_url('admin/form-add-country-wise-selling-price')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                               
                                <div class="form-group">
                                    <div class="col-lg-2">
                                        <label for="country_wise_country_id text-danger">Country</label>
                                        <select name="country_wise_country_id" id="country_wise_country_id" class="form-control select2">
                                            <option value='' disabled selected>Select from the list</option>
                                            <?php 


                                            foreach($countries as $in){ ?>
                                                <option value="<?=$in->country_id?>"><?=$in->name. ' ['.$in->iso3.']'?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="acc_masters text-danger">Customer</label>
                                        <select name="country_wise_acc_master" id="country_wise_acc_master" class="form-control select2">
                                            <option value='' disabled selected>Select from the list</option>
                                            <?php 
                                            foreach($acc_masters as $in){
                                                ?>
                                                <option value="<?=$in->am_id?>"><?=$in->name . ' ['.$in->am_code.']'?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label class="text-danger" for="country_wise_currency_id">Currency*</label>
                                        <select required="" name="country_wise_currency_id" id="country_wise_currency_id" class="form-control select2">
                                            <option value='' disabled selected>Select from the list</option>
                                            <?php 
                                            foreach($currencies as $ci){
                                                ?>
                                                <option value="<?=$ci->c_id?>"><?=$ci->currency .' ['.$ci->symbol.']'?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!--  -->
                                    <div class="col-lg-2">
                                        <label class="text-danger" for="exchange_rate">Custom Exchange * (<?=$currency_symbol?>)</label>
                                        <input required="" type="number" id="exchange_rate" name="exchange_rate" class="form-control">
                                    </div>

                                    <div class="col-lg-2">
                                        <label class="text-danger" for="operator">Operator *</label>
                                        <select required="" name="operator" id="operator" required="" class="form-control">
                                            <option value='' disabled selected>Select from the list</option>
                                           
                                                <option value="*">Multiply</option>
                                                <option value="/">Divide </option>
                                        </select>
                                    </div>
                                   
                                    <div class="col-lg-2 pull-right">
                                        <div class="row text-center">
                                            <div class="col-md-6">
                                                <label for="country_wise_selling_price_submit" id="cbps">Add</label><br>
                                                <input type="submit" id="country_wise_selling_price_submit" name="country_wise_selling_price_submit" class="btn btn-success" value="Insert">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="selling_price_submit" id="cbpu">Update</label><br>
                                        
                                                <input type="submit" name="country_wise_selling_price_submit" class="btn btn-success" value="Update">
                                            </div>
                                        </div>
                                        <!-- HIDDEN FIELDS -->
                                        <input type="hidden" id="country_wise_od_id" name="country_wise_od_id" value="<?=$od_id?>">
                                        <input type="hidden" name="country_wise_offer_id" id="country_wise_offer_id" value="<?=$offer_id?>">
                                    </div>
                                </div>
                            </form>    

                            <div class="row"><hr></div>

                            <div class="row">

                                <div class="panel-heading">
                                    Country/Customer Wise Selling Price Data
                                </div>

                                <div class="panel-body">
                                   <table id="selling_price_details_table" class="table data-table dataTable table-responsive">
                                        <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Customer</th>
                                                <th>Currency</th>
                                                <th>Exchange Rate</th>
                                                <th>Final Approved Rate</th>
                                                <th>Marketing Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table> 
                                   
                                </div>
                            </div>

                        </div>
                    </div> 
                                            
                </div>
            </div>
            
            

        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <?php $this->load->view('components/footer'); ?>
        <!--footer section end-->

    </div>
    <!-- body content end-->
</section>

<!-- Request modal -->
<div class="modal fade" id="exportPricingModal" tabindex="-1" role="dialog" aria-labelledby="exportPricingModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Export Pricing to other products</h4>
            </div>
            <div class="modal-body">
                <form id="form_export_pricing" method="post" action="<?=base_url('admin/form-export-product-selling-pricing')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                    <div class="form-group ">
                        <label class="control-label col-md-4 text-danger">Select Products*</label>
                        <div class="col-md-4">
                           <select required="" name="od_id" id="old_products" class="form-control">
                               <option value="" selected readonly disabled="">Select from the list</option>
                           </select>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" name="country_wise_od_id" value="<?=$od_id?>" id="country_wise_od_id">
                            <input type="hidden" name="from_odid" value="<?=$od_id?>" id="from_odid">
                            <input type="submit" name="request-submit" value="Export" id="request-submit" class="btn btn-success">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>


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

<script src="<?=base_url()?>assets/admin_panel/js/data-table-init.js"></script>
<!--Select2-->
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<script>
    $('.select2').select2();
</script>   

<script>
    $(document).ready(function() {
        
        $od_id = $("#od_id").val();
        
        // alert($od_id);

        $('#selling_price_table').DataTable( {
            "scrollX": true,
            "processing": true,
            "language": {
                processing: '<img src="<?=base_url('assets/img/ellipsis.gif')?>"><span class="sr-only">Processing...</span>',
            },
            "serverSide": true,
            "ajax": {
                "url": "<?=base_url('admin/ajax-selling-price-table-data')?>/"+$od_id,
                "type": "POST",
                "dataType": "json",
            },
            //will get these values from JSON 'data' variable
            "columns": [
                { "data": "selling_incoterm" },
                { "data": "country_name" },

                {
                    "data": "currency_name",
                    "name": "QuantitySold",
                    "render": function (data, type, row) {

                                var cval = "<?=$currency?>" + "(<?=$currency_symbol?>)";

                        return '<td>' + cval + '</td>'
                    },
                },
                { "data": "customer_name" },
                { "data": "margin_flat" },
                { "data": "margin_percentage" },
                { "data": "freight" },

                { "data": "line_item_name" },
                { "data": "other_price" },
                { "data": "other_price_comment" },

                { "data": "line_item_name2" },
                { "data": "other_price2" },
                { "data": "other_price_comment2" },

                { "data": "line_item_name3" },
                { "data": "other_price3" },
                { "data": "other_price_comment3" },

                { "data": "line_item_name4" },
                { "data": "other_price4" },
                { "data": "other_price_comment4" },

                { "data": "final_selling_price" },
                { "data": "action" }
            ],
            //column initialisation properties
            "columnDefs": [{
                "targets": [1,2,3], //disable 'Image','Actions' column sorting
                "orderable": false,
            }],
            "initComplete": function(settings, json) {
                
                // nothing now

              }
              
        } );
    });

    /*edit area*/

    $(document).on('click', '.selling_price_edit_btn', function(){
        $this = $(this);
        $sp_id = $(this).data('sp_id');  

        $.ajax({
            url: "<?= base_url('admin/fetch-selling-price-on-pk/') ?>/"+$sp_id,
            dataType: 'json',
            type: 'POST',
            // data: {bp_id: $bp_id},
            success: function (data) {
   
                data = data[0];

                $am_id = data.am_id.split(',');

                $("#selling_price_table").find('tr').removeClass('bg-green1')
                $this.closest('tr').addClass('bg-green1');

                $("#sp_id").val($sp_id);

                $("#selling_incoterm_id").val(data.selling_incoterm_id).trigger('change');
                $("#country_id").val(data.country_id).trigger('change');
                $("#currency_id").val(data.currency_id).trigger('change');
                $("#acc_masters").val($am_id).trigger('change');
                
                $("#li_category").val(data.line_item_category).trigger('change');
                $("#other_price").val(data.other_price).trigger('change');
                $("#other_cost_comment").val(data.other_price_comment).trigger('change');
                $("#li_category2").val(data.line_item_category2).trigger('change');
                $("#other_price2").val(data.other_price2).trigger('change');
                $("#other_cost_comment2").val(data.other_price_comment2).trigger('change');
                $("#li_category3").val(data.line_item_category3).trigger('change');
                $("#other_price3").val(data.other_price3).trigger('change');
                $("#other_cost_comment3").val(data.other_price_comment3).trigger('change');
                $("#li_category4").val(data.line_item_category4).trigger('change');
                $("#other_price4").val(data.other_price4).trigger('change');
                $("#other_cost_comment4").val(data.other_price_comment4).trigger('change');

                $("#freight").val(data.freight).trigger('change');
                $("#margin_flat").val(data.margin_flat);
                $("#margin_percentage").val(data.margin_percentage);


                setTimeout(function(){ 
                    $("#li_id").val(data.li_id).trigger('change');
                    $("#li_id2").val(data.li_id2).trigger('change');
                    $("#li_id3").val(data.li_id3).trigger('change');
                    $("#li_id4").val(data.li_id4).trigger('change');
                }, 500);
            }
        })        

    });

    /* DELETE AREA */
    $(document).on('click', '.delete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){

            $sp_id = $(this).data('sp_id');           

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-selling-price') ?>/"+$sp_id,
                dataType: 'json',
                type: 'POST',
                // data: {bp_id: $bp_id},
                success: function (returnData) {
                    // console.log(returnData);
                                       
                    // obj = JSON.parse(returnData);
                    notification(returnData);

                    //refresh table
                    $("#selling_price_table").DataTable().ajax.reload();

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }   
    });
</script>

<!-- NEW selling PRICE ADD -->

<script type="text/javascript">

    $("#margin_flat").blur(function(){

        $product_price = parseFloat($("#product_price").val())
        $margin_flat = parseFloat($(this).val())
        $other_price = parseFloat($("#other_price").val())
        $other_price2 = parseFloat($("#other_price2").val())
        $other_price3 = parseFloat($("#other_price3").val())
        $other_price4 = parseFloat($("#other_price4").val())
        $freight = parseFloat($("#freight").val())

        $selling_price = $product_price + $freight + $margin_flat + $other_price + $other_price2 + $other_price3 + $other_price4
        
        // console.log($selling_price)

        $margin_percentage   = parseFloat(($margin_flat/$selling_price)*100)
        
        $("#margin_percentage").val($margin_percentage.toFixed(2))

        $("#final_selling_price").val($selling_price);

    })

    $("#margin_percentage").blur(function(){

        $product_price = parseFloat($("#product_price").val())
        $margin_percentage = $(this).val()
        $other_price = parseFloat($("#other_price").val())
        $freight = parseFloat($("#freight").val())

        $other_price2 = parseFloat($("#other_price2").val())
        $other_price3 = parseFloat($("#other_price3").val())
        $other_price4 = parseFloat($("#other_price4").val())

        $selling_price = $product_price + $freight + $other_price

        $margin_flat   = parseFloat(($margin_percentage*$selling_price)/(100 - $margin_percentage))
        
        $("#margin_flat").val($margin_flat.toFixed(2))

        //$selling_price = $product_price + $freight + $margin_flat + $other_price + $other_price2 + $other_price3 + $other_price4

        $("#final_selling_price").val($selling_price);

    })

    $('#li_category, #li_category2, #li_category3, #li_category4').on('change', function(){
        $this = $(this).parent().next().find('select');
        $type = $(this).val();
        fetch_selling_price_details($this, $type)
    });

    function fetch_selling_price_details($this, $type) {
        
         $.ajax({
            url: "<?= base_url('admin/fetch-line-items-on-type/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {type: $type},
            success: function (returnData) {
                console.log(returnData);                
                $this.html("<option value='' disabled selected>Select your option</option>");
                $.each(returnData, function (index, itemData) {
                   $str = '<option value="'+itemData.li_id+'">'+itemData.line_item_name+'</option>';
                   $this.append($str);
                });
            }
        })

    }
   
    $("#form_add_selling_price").validate({
        rules: {
            
            incoterm_id: {
                required: true
            },
            selling_price: {
                required: true
            },
            currency_id: {
                required: true
            }
        },
        messages: {

        }
    });
    $('#form_add_selling_price').ajaxForm({
        beforeSubmit: function () {
            return $("#form_add_selling_price").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            obj = JSON.parse(returnData);
            notification(obj);

            $("#sp_id").val("");

            //refresh table
            $('#selling_price_table').DataTable().ajax.reload();
        }
    });
</script>

<script type="text/javascript">
    // selling_price for marketing setup
    
    $("#form_add_country_wise_selling_price").validate({
        rules: {
            country_wise_currency_id: {
                required: true
            },
            exchange_rate:{
                required: true
            },
            messages: {
                //messages
            }
        }
    });   

    $('#form_add_country_wise_selling_price').ajaxForm({
        beforeSubmit: function () {
            return $("#form_add_country_wise_selling_price").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            obj = JSON.parse(returnData);
            notification(obj);

            //refresh table
            $('#selling_price_details_table').DataTable().ajax.reload();
        }
    });

    $(document).ready(function() {
        
        $od_id = $("#od_id").val();
        $offer_id = $("#country_wise_offer_id").val()
        // alert($offer_id);

        $('#selling_price_details_table').DataTable( {
            // "scrollX": true,
            "processing": true,
            "language": {
                processing: '<img src="<?=base_url('assets/img/ellipsis.gif')?>"><span class="sr-only">Processing...</span>',
            },
            "serverSide": true,
            "ajax": {
                "url": "<?=base_url('admin/ajax-selling-price-details-table-data')?>/"+$offer_id+'/'+$od_id,
                "type": "POST",
                "dataType": "json",
            },
            //will get these values from JSON 'data' variable
            "columns": [
                
                { "data": "country_name" },
                { "data": "customer_name" },
                { "data": "currency_name" },
                { "data": "exchange_rate" },
                { "data": "approved_rate" },
                { "data": "marketing_price" },
                { "data": "action" }

            ],
            //column initialisation properties
            "columnDefs": [{
                "targets": [1,2,3,4,5,6], //disable 'Image','Actions' column sorting
                "orderable": false,
            }],
            
            "initComplete": function(settings, json) {
                
                // nothing now

              }
              
        } );
    });

     /* DELETE DETAILS AREA */

    $(document).on('click', '.delete_details', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){

            $spd_id = $(this).data('sp_id');           

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-selling-price-details') ?>/"+$spd_id,
                dataType: 'json',
                type: 'POST',
                // data: {bp_id: $bp_id},
                success: function (returnData) {
                    // console.log(returnData);
                                       
                    // obj = JSON.parse(returnData);
                    notification(returnData);

                    //refresh table
                    $("#selling_price_details_table").DataTable().ajax.reload();

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }   
    });
</script>

<!-- Export  -->
<script type="text/javascript">
    
    $(".export-pricing").click(function(){
        
        $offer_id = $(this).data('offer_id');

        $.ajax({
            url: "<?= base_url('admin/fetch-offer-products-on-offer_id/') ?>/"+$offer_id,
            dataType: 'json',
            type: 'POST',
            // data: {type: $type},
            success: function (returnData) {
                console.log(returnData);                
                $("#old_products").html("<option value='' disabled selected>Select your option</option>");
                $.each(returnData, function (index, itemData) {

                    if(itemData.od_id != <?=$od_id?>){
                   $str = '<option value="'+itemData.od_id+'">'+itemData.product_name+ ' ['+itemData.scientific_name+']'+'</option>';
                   $("#old_products").append($str);
                    }
                   
                });
                // $("#old_products").select2("open")
            }
        })

    });

    $("#form_export_pricing").validate({
        rules: {
            old_products: {
                required: true
            }
        },
        messages: {

        }
    });
    $('#form_export_pricing').ajaxForm({
        beforeSubmit: function () {
            return $("#form_export_pricing").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            obj = JSON.parse(returnData);
            notification(obj);
        }
    });

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
</script>

</body>
</html>