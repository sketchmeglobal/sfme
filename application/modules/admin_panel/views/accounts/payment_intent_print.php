<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Payment Certificate</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">
    </head>

    <body class="A4" id="page-content">
        <section class="sheet padding-10mm" style="height:auto">
            <div class="row border text-center">
                <h3 class="fs-4 fw-bold">SEA FOOD MIDDLE EAST</h3>
            </div>
            <div class="row">
                <div class="col-4 border">
                    <p><b>Offer:</b> <small><?=$all_bills[0]->offer_name?></small></p>
                    <p><b>Partial Ref:</b> <?=$all_bills[0]->partial_reference?></p>
                </div>
                <div class="col-4 border">
                    <p><b>Customer:</b> <?=$all_bills[0]->customer_name ?> </p>
                    <p><b>Vendor:</b> <?=$all_bills[0]->vendor_name?> </p>
                </div>
                <div class="col-4 border">
                    <p><b>Total Amount: </b> <?=$all_bills[0]->total_payment_amount?></p>
                    <p><b>Payment Status: </b> <?=($all_bills[0]->payment_approval_status == 1) ? 'Completed' : 'Ongoing'?></p>
                    <p><b>BIll No.: </b><?= PAYMENT_BILL_NO . $all_bills[0]->payment_bill_no?></p>
                </div>
            </div>
            <div class="row">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Payment Date</th>
                            <th>Payable Value</th>
                            <th>Paid Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $iter = 1;
                        foreach($all_bills as $ab){
                            if(empty($all_bills[0]->payment_bill_id)){
                                continue;
                            } 
                        ?>
                        <tr>
                            <td><?=$iter++?></td>
                            <td><?=date('d-m-Y', strtotime($ab->payment_date))?></td>
                            <?php if($all_bills[0]->payment_method == 'Percentage'){ ?>
                            <td><?=$ab->payable_percentage?></td>
                            <td><?=$ab->paid_percentage?></td>
                            <?php } else if($all_bills[0]->payment_method == 'Flat'){ ?>
                            <td><?=$ab->payable_flat?></td>
                            <td><?=$ab->paid_flat?></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php if($all_bills[0]->payment_approval_status == 1){
                    ?>
                    <img style="width: 300px;display: block;margin-left: auto;" src="<?=base_url()?>assets/img/paid.png" alt="">
                    <?php
                } ?>
            </div>
        </section>
    </body>
</html>