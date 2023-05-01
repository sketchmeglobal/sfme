<?php  ?>


    
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
        <title>Offer Details</title>

        <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
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
                font-family: Calibri !important;
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

            @page { size: A4 }

            @media print and (color) {
	            .offer_color{
	            	background-color: #70ad47 ;
	            	color: white ;
	            	text-align: center ;
	            }
	            .export_color{
	            	background-color: #4472c4 ;
	            	color: white ;
	            	text-align: center ;
	            }
	            .derived_color{
	            	background-color: #ed7d31 ;
	            	color: white ;
	            	text-align: center ;
	            }
            }
            @media print{
            	.w-100{
            		width: 100vw !important;
            		text-align: center !important;
            	}
            .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th { border: 1px solid #000;  text-align: center;}
                .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 5px; text-align: left; font-size: 13px}
                .col-md-4 {width: 33.33333333%;float:left}.col-sm-6{ width: 50%!important;float:left; }.col-sm-5 { width: 41.66666667%;float:left; }.col-sm-7 { width: 58.33333333%;float:left; }
                .border-bottom{border-bottom:  1px solid #000}

                .table-bordered{
                	width: 100vw !important;
                }
                /*body.A4 .sheet{
                    height: 500px;
                }*/
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

            .table-bordered td, .table-bordered th{
            	border: 1px solid #4472c4 !important;
            }
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
                        <table id="" class="table table-bordered border border-primary table-hover w-100 table2excel product_details text-center">
                                <thead>
                                	<tr style="background-color:#44546a; border: 1px solid #000 !important;">
                                		<th class="text-center text-white" colspan="4">FZ Reference: <?=$product_details['export_data']->fz_ref_no?></th>
                                		<th class="text-center text-white" colspan="4">Partial Reference: <?=$product_details['export_data']->partial_reference?></th>
                                	</tr>
                                    <tr >
                                        <th class="offer_color border_all">Product Name</th>
                                        <th class="offer_color">Packing Sizes</th>
                                        <th class="offer_color">No of Pieces</th>
                                        <th class="offer_color">Cartons</th>
                                        <th class="offer_color">SC Qty</th>
                                        <th class="offer_color">Qty Unit</th>
                                        <th  class="export_color">Qty Loaded</th>
                                        <th class="derived_color">Qty Deviation <br> (Shortage / Surplus)</th>
                                    
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $total_amount = 0;
                                    $total_qnty = 0;
                                    $total_crtn = 0;
                                    $total_price = 0;
                                    foreach($product_details['export_product_details']  as $product_detail){ ?>

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
                                         <tr>
                                        <!-- <th colspan="12" style="text-align:center;">Grand Total</th> -->
                                        <!-- <th>< ?=$total_crtn?></th>
                                        <th>< ?=$total_qnty?></th>
                                        <th> <  ?=$total_price .' ('. $offer_header->currency_code . ')' ?></th>
                                        <th>< ?=$total_amount .' ('. $offer_header->currency_code . ')'?></th> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </section>

<!-- Placed js at the end of the document so the pages load faster -->
    <script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>
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
