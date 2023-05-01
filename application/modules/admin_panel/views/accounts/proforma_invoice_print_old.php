<?php  ?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Proforma Invoice Print </title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!-- Normalize or reset CSS with your favorite library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
        <!-- Load paper.css for happy printing -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
        <link href="https://fonts.googleapis.com/css?family=Chivo|Signika" rel="stylesheet">
        <!-- Set page size here: A5, A4 or A3 -->
        <!-- Set also "landscape" if you need -->
        <style>
        body{ font-family: 'Signika', sans-serif; font-family: Calibri; }
        p { margin: 0 0 5px; }
        table{ border: 1px solid #777; }
        
        .head_font{ font-family: 'Signika', sans-serif; font-family: Calibri;}
        
        .container{width: 100%}
        
        .border_all{ border: 1px solid #000; }
        .border_bottom{ border-bottom: 1px solid #000;}
        .border-bottom-double{border-bottom:  3px double #000; margin-top: 8px;}
        
        .mar_0{ margin: 0 }
        .mar_bot_3{ margin-bottom: 3px }
        .header_left, .header_right{ height: 150px }
        
        .bold{font-weight:bold;}
        
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
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 5px; text-align: center; font-size: 13px}
        .table{ margin-bottom: 3px;}
        
        
        .text-right{text-align: right!important;}
        
        @page { size: A4 }
        @media print{
        .bold{font-weight:bold;}
        .table-bordered, .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th { border: 1px solid #000;  text-align: center;}
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {padding: 5px; text-align: center; font-size: 13px}
        .col-sm-6{ width: 50%!important;float:left; }.col-sm-5 { width: 41.66666667%;float:left; }.col-sm-7 { width: 58.33333333%;float:left; }
        .border-bottom{border-bottom:  1px solid #000} .border-bottom-double{border-bottom:  3px double #000}
        .text-right{text-align: right!important;}
        }
        
        @media print {
        .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6,
        .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
        float: left;
        }
        .col-sm-12 {
        width: 100%;
        }
        .col-sm-11 {
        width: 91.66666666666666%;
        }
        .col-sm-10 {
        width: 83.33333333333334%;
        }
        .col-sm-9 {
        width: 75%;
        }
        .col-sm-8 {
        width: 66.66666666666666%;
        }
        .col-sm-7 {
        width: 58.333333333333336%;
        }
        .col-sm-6 {
        width: 50%;
        }
        .col-sm-5 {
        width: 41.66666666666667%;
        }
        .col-sm-4 {
        width: 33.33333333333333%;
        }
        .col-sm-3 {
        width: 25%;
        }
        .col-sm-2 {
        width: 16.666666666666664%;
        }
        .col-sm-1 {
        width: 8.333333333333332%;
        }
        .table thead tr td,.table tbody tr td{
        border-width: 1px !important;
        border-style: solid !important;
        border-color: black !important;
        -webkit-print-color-adjust:exact ;
        }
        .table thead tr td,.table tbody tr td{
        border-width: 0.7px !important;
        border-style: solid !important;
        border-color: rgba(0, 0, 0, 0.644) !important;
        -webkit-print-color-adjust:exact ;
        }
        #print{
        display: none !important;
        }
        }
        #print{
        display: block;
        margin: 20px auto;
        }
        </style>


    </head>
    <!-- Set "A5", "A4" or "A3" for class name -->
    <!-- Set also "landscape" if you need -->
    <body class="A4" id="page-content" >
        <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <button type="button" id="print" class="btn btn-primary">Print</button>
        <section class="sheet padding-10mm">
            <div>
                <header class="pull-right">
                    <!-- <small>Page No. 1</small> -->
                </header>
                <div class="clearfix"></div>
                <div class="container">
                    <?php include "p_header.php"; ?>
                    <div class="row mar_bot_3">
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Sales Contract</p>
                                </div>
                                <div class="col-sm-8">
                                    <p><strong><?=$header[0]->pi_number?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Shipment Ref No.:</p>
                                </div>
                                <div class="col-sm-8">
                                    <p><strong><?=$header[0]->offer_fz_number?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Sold to Party:</p>
                                </div>
                                <div class="col-sm-8">
                                    <p><strong><?=$header[0]->name?></strong></p>
                                    <br>
                                    <p><strong><?=$header[0]->official_address?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Consignee:</p>
                                </div>
                                <div class="col-sm-8">
                                    <p><strong><?=$header[0]->consignee?></strong></p> <br>
                                    <p ><strong><?=$header[0]->consignee_address?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Destination Port:</p>
                                </div>
                                <div class="col-sm-8">
                                    <p><strong><?=$header[0]->port_name?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Port of Shipment:</p>
                                </div>
                                <div class="col-sm-8">
                                    <p><strong><?=$header[0]->shipment_port?></strong></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-sm-5">
                                    <p class="bold">Date:</p>
                                </div>
                                <div class="col-sm-7">
                                    <p><strong><?=$header[0]->pi_date?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <p class="bold">Your Ref:</p>
                                </div>
                                <div class="col-sm-7">
                                    <p><strong><?=$header[0]->email_id?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <p class="bold">Product Origin:</p>
                                </div>
                                <div class="col-sm-7">
                                    <p><strong><?=$header[0]->country_name?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <p class="bold">Shipping Line:</p>
                                </div>
                                <div class="col-sm-7">
                                    <p><strong><?=$header[0]->shipping_line?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-5">
                                    <p class="bold">Incoterm:</p>
                                </div>
                                <div class="col-sm-7">
                                    <p><strong><?=$header[0]->incoterm?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--table data-->
                    <div class="row">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="2">Product(s)</th>
                                    <th>Size / pces</th>
                                    <th>Packing </th>
                                    <th class="">Cartoon</th>
                                    <th class="">Qty</th>
                                    <th class="">Rate</th>
                                    <th>Ammount (<?=$header[0]->code?>)</th>
                                </tr>
                            </thead>
                            <tbody class="actual_table">
                                <?php
                                $crtns = 0;
                                $qnty = 0;
                                $iter = 0;
                                $rate = 0;
                                $generate_iter = 9;
                                $amm = 0;
                                
                                foreach($details as $d){
                                $iter ++;
                                
                                if($d->mar_selling_approval_status){
                                $fv = $d->mar_selling_rate;
                                }else{
                                $fv = $d->final_selling_price;
                                }
                                if($iter == 9 or $iter == $generate_iter) {
                                $generate_iter += 8;
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row border-bottom-double">
                
            </div>
            <div class="row">
            </div>
        </section>
        <section class="sheet padding-10mm">
            <div>
                <header class="pull-right">
                    <!-- <small>Page No. 1</small> -->
                </header>
                <div class="clearfix"></div>
                <div class="container">
                    <?php include "p_header.php"; ?>
                    
                    <!--table data-->
                    <div class="row">
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th colspan="2">Product(s)</th>
                                    <th>Size / pces</th>
                                    <th> Packing </th>
                                    <th class="">Cartoon</th>
                                    <th class="">Qty</th>
                                    <th class="">Rate</th>
                                    <th>Ammount (<?=$header[0]->code?>)</th>
                                </tr>
                            </thead>
                            <tbody class="actual_table">
                                <?php } ?>
                                <tr>
                                    <td><?=$d->product_name?></td>
                                    <td><?=$d->scientific_name?></td>
                                    <td><?=$d->size?></td>
                                    <td><?=$d->packing_size?></td>
                                    <td><?php $crtns += $d->cartons_offered; echo $d->cartons_offered?></td>
                                    <td><?php $qnty += $d->quantity_offered; echo $d->quantity_offered . ' (' . $d->unit .')'?></td>
                                    <td><?php $rate += $d->product_price; echo $d->product_price?></td>
                                    <td><?php $amm += ($d->product_price * $d->quantity_offered); echo ($d->product_price * $d->quantity_offered)?></td>
                                </tr>
                                
                                <?php } ?>
                            </tbody>
                            <tfoot>
                            
                            <!-- <th style="text-align: left" colspan="8">1 x 40 FT Reefer FCL Container</th> -->
                            <tr>
                                <td>
                                    <?php
                                    
                                    $size_of_containerarr = explode(" ",$header[0]->size_of_container);
                                    ?>
                                    No of FCL : <?=$header[0]->no_of_container?> x <?=$size_of_containerarr[0]?> ft
                                </td>
                                <th colspan="7"></th>
                            </tr>
                            <tr>
                                <th> Shel life : <?=$header[0]->shelf_life?> from production date</th>
                                <th colspan="7"></th>
                            </tr>
                            <tr>
                                <th>Tolerance: <?=$header[0]->tolerance?></th>
                                <th colspan="4" style="text-align:right;">Freight</th>
                                <th colspan="4" style="text-align:right;"><?=number_format($freight_sum[0]->totalfreight,2)?></th>
                            </tr>
                            <tr>
                                <th>Shipment   :  <?=$header[0]->shipment_timing?> </th>
                                <th colspan="7"></th>
                            </tr>
                            <?php if($total_insurance != 0.00){ ?>
                            <tr>
                                <th></th>
                                <th colspan="4" style="text-align:right;">Insurance</th>
                                <th colspan="4" style="text-align:right;"> <?=$total_insurance?></th>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th <?php if($total_other == 0.00){ ?> colspan="8" style="text-align: left; padding-left: 70px;"  <?php } ?> >Transhipment : <?=$header[0]->transhipment?></th>
                                <?php if($total_other != 0.00){ ?>
                                <th colspan="4" style="text-align:right;">Others</th>
                                <th colspan="4" style="text-align:right;"><?=$total_other?></th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <th <?php if($header[0]->tax == 0.00){ ?> colspan="8" style="text-align: left; padding-left: 70px;"  <?php } ?> >Partial shipment : <?=$header[0]->partial_shipment?></th>
                                <?php if($header[0]->tax != 0.00){ ?>
                                <th colspan="4" style="text-align:right;">Tax:</th>
                                <th colspan="4" style="text-align:right;"><?=$header[0]->tax?></th>
                                <?php } ?>
                            </tr>
                            <tr>
                                <th></th>
                                <th colspan="4" style="text-align:right;"><?=$crtns?></th>
                                <th><?=$qnty?></th>
                                <th><?=$rate?></th>
                                <th colspan="4" style="text-align:right;">  <?=number_format(($amm + $freight_sum[0]->totalfreight + $total_insurance + $total_other + $header[0]->tax),2); ?> </th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="row border-bottom-double">
                        
                    </div>
                    <div class="row">
                    </div>
                </section>
                <section class="sheet padding-10mm">
                    <div>
                        <header class="pull-right">
                            <!-- <small>Page No. 1</small> -->
                        </header>
                        <div class="clearfix"></div>
                        <div class="container">
                            <?php include "p_header.php"; ?>
                            <div style="display:flex;"> <p style="width: 139px;word-wrap: break-word;">Label and document instruction:</p> Separate </div>
                            <div style="display:flex; column-gap: 9rem;">
                                <h5>Payment :</h5>
                                <h5 style=" font-weight: bold;">   30 days from BL date  </h5>
                                
                            </div>
                            <div style="display:flex; column-gap: 2.5rem;">
                                <h5>Owntership of goods:</h5>
                                <h5 style=" font-weight: bold;"> If payment is not fully made, the ownership of the goods will be retained by us. </h5>
                            </div>
                            <div style="display:flex; column-gap: 2rem;">
                                <h5>Label  and Documents:</h5>
                                <h5 style="font-weight: bold;"> <?=$header[0]->label_document?></h5>
                            </div>
                            <h5>
                            Temperature Clause:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To keep and transport below -18 degree centigrade.
                            </h5>
                            <div style="display:flex; column-gap: 6rem; margin-bottom: -14px;">
                                <h5>Docs provided :</h5>
                                <h5 style="font-weight: bold;"><?= $header[0]->docs_provided ?>
                                </h5>
                            </div>
                            <div style="display:flex; column-gap: 8rem;">
                                <h5>Quality complain :</h5>
                                <h5 style="font-weight: bold;">
                                <p> 1. In case of any specification related problem, it should be informed to us with in seven days from the
                                receipt of the container from the port.</p>
                                <p>
                                    2. in case of refrigeration or temperature related issues , it should be informed on an immediate basis
                                    with in 15 hours of the receipt of the container.
                                </p>
                                </h5>
                            </div>
                            <div style="display:flex; column-gap: 4rem;">
                                <h5>Lab report clauses:</h5>
                                <div style="display:grid;">
                                    <p>Following parameters to be maintained.</p> <br>
                                    <table  class="table table-hover table-striped table-bordered">
                                        <thead>
                                            <?php //echo @count(json_decode($header[0]->lab_report_clauses));
                                            if(@count($header[0]->lab_report_clauses) > 0){
                                            $label_documentarr = json_decode($header[0]->lab_report_clauses);
                                            
                                            foreach ($label_documentarr as $key => $value) {
                                            ?>
                                            <tr>
                                                <th>
                                                    <?=$value?>
                                                </th>
                                            </tr>
                                            <?php }} ?>
                                            
                                        </thead>
                                        
                                    </table>
                                </div>
                            </div>
                            <h5 style="font-weight: bold;">
                            Special clause :
                            </h5>
                            <p>
                                The proforma information should be considered to be official and correct information of this contract.
                                Any terms or conditions which is not mentioned in this contract , should not be considered as part of this contract.
                                Any other email/ skype / zoom/ google/ whatspapp etc or similar communication  should be considered as process of negotiation but should not be considered as Part of the contract. In case of any disputed such should be  ignored. This contract will be considered for disputed resolution.
                            </p>
                            <div class="row" >
                                <?php
                                    
                                    foreach ($bank_details as $key => $bank_detailrow) { ?>
                                <div class="col-lg-4">
                                        <p> <?=$key+1?>)
                                            <strong>
                                            BENEFICIARY : <?=$bank_detailrow->beneficiary_name;?> <br>
                                            ACCOUNT NUMBER : <?=$bank_detailrow->account_number;?> <br>
                                            IBAN NO. : <?=$bank_detailrow->iban_no;?> <br>
                                            BANK :  <?=$bank_detailrow->bank_name;?> <br>
                                            Branch : <?=$bank_detailrow->branch;?> <br>
                                            SWIFT CODE: <?=$bank_detailrow->swift_code;?> <br>
                                            </strong>
                                        </p> <br>                                    
                                </div>
                                <?php } ?>
                                
                            </div>

                            <div style="display:flex; column-gap: 33rem;">
                                <h5>Authorised Signatory</h5>
                                
                                <h5>Accepted by :</h5>
                            </div>

                            <div style="display:flex; column-gap: 32.5rem;">
                                <h5> <?= $header[0]->authorised_signatory?> </h5>
                                
                                <?=$header[0]->accepted_by?>
                            </div>
                            <div class="row border-bottom-double">
                                
                            </div>
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </section>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                $("#print").click(function () {
                // $(this).hide();
                window.print();
                });
                </script>
            </body>
        </html>