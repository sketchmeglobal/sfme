<?php  //echo "string"; ?>


<?php error_reporting(0); ?>

    
<?php 
    
    if(empty($product_details) or !isset($product_details)){
        
        die('Please finalise the offer and get accepted by the Trader in order to view the Offer. You can also communicate with the Trader from the <a href="http://seafoodmiddleeast.net/admin_panel/Offer/offer_comments/add">Comments Section</a>');
        
    }

  /*  $templates = $view_offer_data['templates'][0];
    $offer_header = $view_offer_data['offer'][0];
    $offer_details = $view_offer_data['offer_details'];
    $selling_price = $view_offer_data['selling_price'];

    $offer_header_fields = explode(',',$templates->offer_header_fields);
    $offer_details_fields = explode(',',$templates->offer_details_fields);
    $selling_prices_fields = explode(',',$templates->selling_prices_fields);

    $country_based_customers = $view_offer_data['country_based_customers'];*/
    //echo '<pre>', print_r($product_details), '</pre>';

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Export Prodect Details</title>

        <!-- Latest compiled and minified CSS -->
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
        <!-- Normalize or reset CSS with your favorite library -->
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->

        <!-- Load paper.css for happy printing -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css"> -->
        
         <!-- Normalize or reset CSS with your favorite library -->
    <link href="<?=base_url();?>assets/admin_panel/css/normalize.min.css" rel="stylesheet">
    <!-- Load paper.css for happy printing -->
    <link href="<?=base_url();?>assets/admin_panel/css/paper.css" rel="stylesheet">
    
        <link href="http://ecoudyog.com/image/favicon.ico" rel="shortcut icon" type="image/png">

<!--toastr-->
<link href="<?=base_url();?>assets/admin_panel/js/toastr-master/toastr.css" rel="stylesheet" type="text/css" />

<!--common style-->
<link href="<?=base_url();?>assets/admin_panel/css/style.css?v=1.2" rel="stylesheet" type="text/css">
<link href="<?=base_url();?>assets/admin_panel/css/style-responsive.css" rel="stylesheet">

<!--loading css-->
<link rel="stylesheet" href="<?=base_url();?>assets/admin_panel/css/loading.css" type="text/css" />

<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="<?=base_url();?>assets/admin_panel/js/html5shiv.js"></script>
<script src="<?=base_url();?>assets/admin_panel/js/respond.min.js"></script>
<![endif]-->

        <link href="https://fonts.googleapis.com/css?family=Chivo|Signika" rel="stylesheet">
        <!-- Set page size here: A5, A4 or A3 -->
        <!-- Set also "landscape" if you need -->
        
        <style>
        
            body{
                /*font-family: 'Chivo', sans-serif;*/
                font-family: Calibri !important;
                background-color: white;
            }
            p {
                margin: 0 0 5px !important;
            }
            
            .border-bottom{border-bottom:  1px solid #000 !important}


            .offer_color{
            	background-color: #70ad47;
            	color: white;
            	text-align: center;
            }

            .export_color{
            	background-color: #4472c4;
            	color: white;
            	text-align: center;
            }

            .border_all{
                border: 1px solid #000;
            }

            .derived_color{
            	background-color: #ed7d31;
            	color: white;
            	text-align: center;
            }

            @page {
            size: A4;
            margin: 0;
            }

           /* @media print  {
	           
            }*/
            
            .header_color {
                background-color:#44546a; 
                border: 1px solid #000 !important;
                color: white;
            }
            
            thead{
                margin-top: 15px;
            }

            .table-bordered td, .table-bordered th{
            	border: 1px solid #4472c4 !important;
            }
            
            @media print{
                
                body {color-adjust: exact!important;  
                -webkit-print-color-adjust: exact!important; 
                print-color-adjust: exact!important;}
                
                @page {size: landscape!important}
         
                 .offer_color{
	            	background-color: #70ad47!important;
	            	background-clip: border-box;
	            	color: white!important;
	            	text-align: center!important;
	            	box-shadow: inset 0 0 0 1000px #70ad47 !important;
	            }
	            
	            .border_print {
	                border: 1px solid #4472c4 !important;
	            }
	            
	            .export_color{
	            	background-color: #4472c4!important;
	            	background-clip: border-box;
	            	color: white!important;
	            	text-align: center!important;
	            	box-shadow: inset 0 0 0 1000px #4472c4 !important;
	            }
	            .derived_color{
	            	background-color: #ed7d31!important;
	            	color: white!important;
	            	text-align: center!important;
	            	box-shadow: inset 0 0 0 1000px #ed7d31 !important;
	            }
	            .header_color {
                color: white!important;
                box-shadow: inset 0 0 0 1000px #44546a !important;
                }
	            
            	.w-100{
            		width: 100vw !important;
            		text-align: center !important;
            	}
            /*.table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th { border: 1px solid #4472c4 !important;  text-align: center;}*/
            /*    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 5px; text-align: left; font-size: 13px}*/
            /*    .col-md-4 {width: 33.33333333%;float:left}.col-sm-6{ width: 50%!important;float:left; }.col-sm-5 { width: 41.66666667%;float:left; }.col-sm-7 { width: 58.33333333%;float:left; }*/

            /*    .table-bordered{*/
            /*    	width: 100vw !important;*/
            /*    }*/
                /*body.A4 .sheet{
                    height: 500px;
                }*/
                thead{
                    margin-top: 15px;
                }
            }
            /*body.A4 .sheet{*/
            /*    height: 7000px*/
            /*}*/
            
        </style>
    </head>

    <!-- Set "A5", "A4" or "A3" for class name -->
    <!-- Set also "landscape" if you need -->
    <body class="A4 landscape" id="page-content">


                <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <!-- < ?php (isset($upgrade_rate)) ? '<div class="alert alert-success">Approval request sent successfully</div>' : '' ?> -->
        <section class="sheet padding-10mm" style="height: auto; padding: 25px;">
            <div>
                <div class="clearfix"></div>
                <div class="container-fluid">
                
                    <!--table data-->
                    <div class="row">
                       <div class="border_all text-center text-uppercase w-100 mar_bot_3 " style="background-color: #d9edf7 !important;">
                            <h3 class="mar_0 head_font">Product Details</h3>
                        </div>
                        <div class="table-responsive">
                        <table id="" class="table table-bordered w-100 table2excel product_details text-center">

                            <?php //echo "<pre>"; print_r($product_details['export_product_details']);


                                $ttl_quantity_offered =  array_sum(array_column($product_details['export_product_details'], 'qty_loaded')); 
                                //$vl = 0;
                                if(trim($ttl_quantity_offered) == 27){

                                    //echo "string";
                                    $vl = $ttl_quantity_offered / 27;
                                }else{
                                    //echo "else";
                                   $vl =  floor($ttl_quantity_offered / 27);
                                }
                             ?>
                                <thead>
                                	<tr>
                                		<th class="text-center text-white header_color" colspan="4">FZ Reference: <?=$product_details['export_data']->fz_ref_no?></th>
                                		<th class="text-center text-white header_color" colspan="4">Partial Reference: <?=$product_details['export_data']->partial_reference?> (
                                        1-<?=$product_details['export_data']->no_of_container?>

                                        /<?=$product_details['export_product_details'][0]['no_of_container']?>

                                    ) </th>
                                	</tr>
                                    <tr >
                                        <th class="offer_color border_print">Product Name</th>
                                        <th class="offer_color border_print">Packing Sizes</th>
                                        <th class="offer_color border_print">No of Pieces</th>
                                        <th class="offer_color border_print">Cartons</th>
                                        <th class="offer_color border_print">SC Qty</th>
                                        <th class="offer_color border_print">Qty Unit</th>
                                        <th  class="export_color border_print">Qty Loaded</th>
                                        <th class="derived_color border_print">Qty Deviation <br> (Shortage / Surplus)</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_amount = 0;
                                    $total_scqnty = 0;
                                    $total_qntyloaded = 0;
                                    $total_qntydeviation = 0;
                                    $total_cartons_offered = 0;
                                    $total_crtn = 0;
                                    $total_price = 0;
                                    foreach($product_details['export_product_details']  as $product_detail){
                                        $total_cartons_offered += $product_detail['cartons_offered'];
                                        $total_scqnty += $product_detail['quantity_offered'];

                                        $total_qntyloaded += $product_detail['qty_loaded'];
                                        $total_qntydeviation += ($product_detail['quantity_offered'] - $product_detail['qty_loaded'])
                                     ?>

                                    		<tr>
                                    			<td ><?=$product_detail['product_name']?></td>
                                    			<td ><?=$product_detail['size']?> <?=$product_detail['sizeUnit']?></td>
                                    			<td ><?=$product_detail['pieces']?></td>
                                    			<td ><?=$product_detail['cartons_offered']?></td>
                                    			<td ><?=$product_detail['quantity_offered']?></td>
                                    			<td ><?=$product_detail['prddtlUnit']?></td>
                                    			<td><?=$product_detail['qty_loaded']?></td>
                                    			<td><?=($product_detail['quantity_offered'] - $product_detail['qty_loaded'])?></td>
                                    		</tr>

                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="w-100 table2excel product_details text-center" style="border: 1px solid #4472c4;margin-top: -15px;">
                                <thead>
                                    <tr>
                                            <th width="543" style="text-align: right; padding-right: 32px;"><?=$total_cartons_offered?></th>
                                            <th width="190" style="text-align: left; padding-left: 28px;"><?=$total_scqnty?></th>
                                            <th width="125" style="text-align: center; padding-right: 11px;"><?=$total_qntyloaded?></th>
                                            <th width="211" style="text-align: center; padding-left: 8px;"><?=$total_qntydeviation?></th>
                                        </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>


        <?php  if($total_qntydeviation > 0){ ?>
        <section class="sheet padding-10mm" style="height: auto; padding: 25px;">
            <div>
                <div class="clearfix"></div>
                <div class="container-fluid">
                
                    <!--table data-->
                    <div class="row">
                       <div class="border_all text-center text-uppercase w-100 mar_bot_3 " style="background-color: #d9edf7 !important;">
                            <h3 class="mar_0 head_font" style="text-transform: capitalize;">Balance Partial</h3>
                        </div>
                        <div class="table-responsive">
                        <table id="" class="table table-bordered w-100 table2excel product_details text-center">

                            <?php //echo "<pre>"; print_r($product_details['export_product_details']);


                                $ttl_quantity_offered =  array_sum(array_column($product_details['export_product_details'], 'qty_loaded')); 
                                //$vl = 0;
                                if(trim($ttl_quantity_offered) == 27){

                                    //echo "string";
                                    $vl = $ttl_quantity_offered / 27;
                                }else{
                                    //echo "else";
                                   $vl =  floor($ttl_quantity_offered / 27);
                                }


                                
                                //echo $product_details['export_product_details'][0]['no_of_container'];
                             ?>
                                <thead>
                                    <tr>
                                        <th class="text-center text-white header_color" colspan="4">FZ Reference: <?=$product_details['export_data']->fz_ref_no?> (
                                        <?=($product_details['export_product_details'][0]['no_of_container'] - $product_details['export_data']->no_of_container)?>

                                        /<?=$product_details['export_product_details'][0]['no_of_container']?>

                                    )</th>
                                        <th class="text-center text-white header_color" colspan="4"> A Partial FZ Reference will be created for the Balance Partial Reference: <?=$product_details['export_data']->partial_reference?></th>
                                    </tr>
                                    <tr >
                                        <th class="offer_color border_print">Product Name</th>
                                        <th class="offer_color border_print">Packing Sizes</th>
                                        <th class="offer_color border_print">No of Pieces</th>
                                        <th class="offer_color border_print">Cartons</th>
                                        <th class="offer_color border_print">SC Qty</th>
                                        <th class="offer_color border_print">Qty Unit</th>
                                        <th  class="export_color border_print">Balance Qty</th>
                                        <th class="derived_color border_print">Qty Deviation <br> (Shortage / Surplus)</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_amount = 0;
                                    $total_scqnty = 0;
                                    $total_qntyloaded = 0;
                                    $total_qntydeviation = 0;
                                    $total_cartons_offered = 0;
                                    $total_crtn = 0;
                                    $total_price = 0;
                                    foreach($product_details['export_product_details']  as $product_detail){
                                        $total_cartons_offered += $product_detail['cartons_offered'];
                                        $total_scqnty += $product_detail['quantity_offered'];

                                        $total_qntyloaded += $product_detail['qty_loaded'];
                                        $total_qntydeviation += ($product_detail['quantity_offered'] - $product_detail['qty_loaded'])


                                     ?>

                                            <tr>
                                                <td ><?=$product_detail['product_name']?></td>
                                                <td ><?=$product_detail['size']?> <?=$product_detail['sizeUnit']?></td>
                                                <td ><?=$product_detail['pieces']?></td>
                                                <td ><?=$product_detail['cartons_offered']?></td>
                                                <td ><?=$product_detail['quantity_offered']?></td>
                                                <td ><?=$product_detail['prddtlUnit']?></td>
                                                <td><?=($product_detail['quantity_offered'] - $product_detail['qty_loaded'])?></td>
                                                <td><?=$product_detail['qty_loaded']?></td>
                                            </tr>

                                        <?php } ?>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="w-100 table2excel product_details text-center" style="border: 1px solid #4472c4;margin-top: -15px; width: 100%;">
                                <thead>
                                    <tr>
                                            <th width="297" style="text-align: right; padding-right: 26px;"><?=$total_cartons_offered?></th>
                                            <th width="105" style="padding-left: 36px;"><?=$total_scqnty?></th>
                                            <th width="125" style="text-align: right; padding-right: 13px;"> <?=$total_qntydeviation?></th>
                                            <th width="211" style="text-align: center; padding-left: 60px;"><?=$total_qntyloaded?></th>
                                        </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <?php } ?>

<!-- Placed js at the end of the document so the pages load faster -->
    <!--<script src="< ?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>-->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
    
    <script type="text/javascript">
/*
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
            
        });*/
       
    </script>
<script>
          <?php 

//if(!empty($this->session->flashdata('success_mail'))){?>
    
// alert("Mail Send Successfully"); 

<?php //} ?>
</script>

    </body>
</html>
