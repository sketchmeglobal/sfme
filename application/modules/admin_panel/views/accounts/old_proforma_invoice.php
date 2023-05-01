<?php  ?>

<?php #echo '<pre>', print_r($header), '</pre>' ?>
<?php #echo '<pre>', print_r($details), '</pre>' ?>


<?php //echo phpversion(); ?>

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
            .border-bottom-double{border-bottom:  3px double #000} 
            
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
        </style>
    </head>

    <!-- Set "A5", "A4" or "A3" for class name -->
    <!-- Set also "landscape" if you need -->
    <body class="A4" id="page-content" >
                <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <section class="sheet padding-10mm">
            <div>
                <header class="pull-right">
                    <!-- <small>Page No. 1</small> -->
                </header>
                <div class="clearfix"></div>
                <div class="container">
                    <div class="row text-center text-uppercase mar_bot_3">
                        <h3 class="head_font">Seafood Middle East</h3>
                    </div>
                    <div class="row">
                        <hr style="border-bottom: 2px solid #000; margin: 0 0 5px">
                    </div>
                    <div class="row border_bottom mar_bot_3">
                        <h4 class="mar_0 bold">Attention: <?= $header[0]->owner_name ?></h4>
                    </div>
                    <div class="row border-bottom-double text-center mar_bot_3">
                        <h5 class="mar_0 bold">Sales Contract</h5>
                    </div>
                    <div class="row mar_bot_3">
                        <div class="col-sm-7">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Sales Contract:</p>
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
                                    <p><strong><?=$header[0]->official_address?></strong></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p class="bold">Consignee:</p>
                                </div>
                                <div class="col-sm-8">
                                    <p><strong><?=$header[0]->consignee?></strong></p>
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
                                    <th>Product(s)</th>
                                    <th>Packing</th>
                                    <th>Grade (Gm.)</th>
                                    <th class="">Cartoon (Pcs.)</th>
                                    <th class="">Qty</th>
                                    <th class="">Rate</th>
                                </tr>
                            </thead>
                            <tbody class="actual_table">
                                <?php
                                $crtns = 0;
                                $qnty = 0;
                                
                                foreach($details as $d){
                                    
                                    if($d->mar_selling_approval_status){
                                        $fv = $d->mar_selling_rate;
                                    }else{
                                        $fv = $d->final_selling_price;
                                    }
                                    
                                ?>
                                <tr>
                                    <td><?=$d->product_name?></td>
                                    <td><?=$d->packing_size?></td>
                                    <td><?=$d->grade?></td>
                                    <td><?php $crtns += $d->cartons_offered; echo $d->cartons_offered?></td>
                                    <td><?php $qnty += $d->quantity_offered; echo $d->quantity_offered . ' (' . $d->unit .')'?></td>
                                    <td><?=($fv == '') ? 'Selling Price Not Present' : $fv?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3"></td>
                                    <th><?=$crtns?></th>
                                    <th><?=$qnty?></th>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th style="text-align: left" colspan="6">1 x <?= $d->size_of_container ?> Container</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="row border-bottom-double">
                        <h5>Tolerance: <?=$header[0]->tolerance?></h5>
                    </div>
                    <div class="row">
                        <?=$header[0]->footer_contract?>
                    </div>
                </section>
                
            </body>
</html>






<!-- required section  -->

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
                                <h5 style="font-weight: bold;"> To be approved by you.</h5>
                            </div>
                            <h5>
                            Temperature Clause:   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To keep and transport below -18 degree centigrade.
                            </h5>
                            <div style="display:flex; column-gap: 6rem; margin-bottom: -14px;">
                                <h5>Docs provided :</h5>
                                <h5 style="font-weight: bold;">Invoice , Packing List , Health certificate , certificate of origin ,Bill of lading
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
                                            <tr>
                                                <th>
                                                    TPC : Nil
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Total count : Below 25,000
                                                </th>
                                            </tr>
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
                            <div class="row border-bottom-double">
                                
                            </div>
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </section>
<!-- // -->
