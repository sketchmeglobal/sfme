<?php
function fetch_export($offer_id){
    $CI = & get_instance();
    $exp_data=$CI->db->get_where('exportdata',array('offer_id'=>$offer_id))->result();
    if(count($exp_data) > 0){
        $val = '<b>FZ Ref. No. : </b>';
        foreach($exp_data as $ed){
            $val .= $ed->fz_ref_no . ', ';
        }
        return rtrim($val, ', ');
    }else{
        return '-';
    }
    
}
function fetch_bill_details($pb_id, $table){
    $CI = & get_instance();
    $pb_data=$CI->db->get_where($table,array('payment_bill_id'=>$pb_id))->result();
    if(count($pb_data) > 0){

        if($pb_data[0]->payable_percentage == '' or $pb_data[0]->payable_percentage == NULL){
            $label = "<u>Payment Type: <b>Flat</b></u><br>";
            $iter_flat = 1;
            foreach($pb_data as $pd){
                if ($pd->payable_flat == '' or $pd->payable_flat == NULL){
                    $p_flat_payable = '0';
                    $p_flat_paid = '0';
                }else{
                    $p_flat_payable = $pd->payable_flat;
                    $p_flat_paid = ($pd->paid_flat == '') ? '0' : $pd->paid_flat;
                }
                $label .= '<div class="dashed_border"><b>' .$iter_flat++ . '</b>. Payable: ' . $p_flat_payable . ' - Paid: ' . $p_flat_paid . '<br>';
                if($pd->bill_intent_permission == 0){
                    $label .= '<i>Pending from Junior Head</i><br>';
                } else if($pd->intent_approver_role == 1){
                    $label .= '<i>Pending from Senior Head</i><br>';
                } else if($pd->intent_approver_role == 2){
                    $label .= '<i>Pending from Account Head</i><br>';
                } else if($pd->intent_approver_role == 3){
                    // $label .= '<i>Paid</i><br>';
                }
                $label .= "</div>";
            }
        }else{
            $label = "<u>Payment Type: <b>Percentage</b></u><br>";
            $iter_per = 1;
            foreach($pb_data as $pd){
                if ($pd->payable_percentage == '' or $pd->payable_percentage == NULL){
                    $p_perc_payable = '0';
                    $p_perc_paid = '0';
                }else{
                    $p_perc_payable = $pd->payable_percentage;
                    $p_perc_paid = ($pd->paid_percentage == '') ? '0' : $pd->paid_percentage;
                }
                $label .= '<div class="dashed_border"><b>' .$iter_per++ . '</b>. Payable: ' . $p_perc_payable . ' - Paid: ' . $p_perc_paid . '<br>';
                if($pd->bill_intent_permission == 0){
                    $label .= '<i>Pending from Junior Head</i><br>';
                } else if($pd->intent_approver_role == 1){
                    $label .= '<i>Pending from Senior Head</i><br>';
                } else if($pd->intent_approver_role == 2){
                    $label .= '<i>Pending from Account Head</i><br>';
                } else if($pd->intent_approver_role == 3){
                    // $label .= '<i>Paid</i><br>';
                }
                $label .= "</div>";
            }
        }

        return rtrim($label, '<br>');
    }else{
        return '-';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?> | <?=WEBSITE_NAME;?></title>
    <meta name="description" content="<?=$title?>">

    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">

    <!--iCheck-->
    <link href="<?=base_url();?>assets/admin_panel/js/icheck/skins/all.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style>
        /* body,.body-content{overflow: scroll;} */
        u{text-underline-offset: 4px;}
        tfoot th input{width:50px; transition: .3s all}
        tfoot th input:active,tfoot th input:focus{width:150px; transition: .5s all}
        .form-horizontal .control-label, label{font-weight:bold}
        .form-control, select,.select2-drop-mask{border:1px solid green;}
        .form-group{border-bottom: 1px solid #dedede;padding-bottom: 15px;}
        .highlight{background: beige;padding: 1%;border: 1px solid;margin-bottom: 0px;box-shadow: -1px 0px 1px 1px #ddd;margin-bottom: 15px}
        .table-bordered,.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td{border: 1px solid #4d4b4b;text-align: left;}
        .dashed_border{border: 1px dashed;margin: 5px 0;text-align: center;}
        .dashed_border i{color: red;}
    </style>
</head>

<body class="sticky-header">
<?php //echo "<pre>", print_r($export_details), '</pre>'; ?>
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
            
            <div class="col-lg-12">
                <div class="highlight">
                    <h4>Notification Panel</h4>
                    <hr style="border-color: black">
                    <div class="row">
                        
                    <div class="col-sm-12">
                        <h4>Payment Details</h4>
                        <table id="filter_results" class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Offer</th>
                                    <!-- <th>Export</th> -->
                                    <!-- <th>Vendor</th> -->
                                    <!-- <th>Supplier</th> -->
                                    <!-- <th>Purchase Order</th> -->
                                    <th>Bill No.</th>
                                    <!-- <th>Bill Date</th> -->
                                    <th>Bill Amount</th>
                                    <!-- <th>ETD</th> -->
                                    <!-- <th>ETA</th> -->
                                    <!-- <th>Request Initiator</th> -->
                                    <th>Bill Details</th>
                                    <th>Approval Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php 
                        $iter= 1;
                        foreach($payment_bill as $pb){
                            // echo '<pre>'; print_r($pb); die;
                        ?>

                            <tr>
                                <td><?=$iter++?></td>
                                <td><?=$pb->offer_name?>.</td>
                                <!-- <td><?=fetch_export($pb->offer_id)?></td> -->
                                <!-- <td>< ?=$pb->vendor_name?></td> -->
                                <!-- <td>< ?=$pb->supllier_name?></td> -->
                                <!-- <td><?=$pb->purchase_order_no?></td> -->
                                <td nowrap><?=PAYMENT_BILL_NO . $pb->payment_bill_no . '<br>(' . date('d-m-Y', strtotime($pb->payment_bill_date)) . ')'?></td>
                                <!-- <td>< ?=date('d-m-Y', strtotime($pb->payment_bill_date))?></td> -->
                                <td><?=$pb->total_payment_amount?></td>
                                <!-- <td>< ?=($pb->ETD == '0000-00-00') ? '-' : date('d-m-Y', strtotime($pb->ETD))?></td> -->
                                <!-- <td>< ?=($pb->ETA == '0000-00-00') ? '-' : date('d-m-Y', strtotime($pb->ETA))?></td> -->
                                <!-- <td>< ?=$pb->username?></td> -->
                                <td nowrap><?=fetch_bill_details($pb->pb_id,'payment_bill_details')?></td>
                                <td><?=($pb->payment_approval_status == 0) ? 'Not approved' : 'Approved'?></td>
                                <td><?=($pb->payment_status == 'Pending') ? 'Pending' : 'Completed'?></td>
                                <td>
                                    <a class="btn btn-info" href="<?=base_url('admin/payment-intent-edit') . '/' . $pb->pb_id?>">Edit</a>
                                    <a target="_new" href="<?=base_url('admin/export-edit') . '/' . $pb->export_id?>" class="btn btn-warning">Export Link</a>
                                </td>
                            </tr>
                        
                        <?php    
                        } 
                        ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Offer</th>
                                    <!-- <th>Export</th> -->
                                    <!-- <th>Vendor</th> -->
                                    <!-- <th>Supplier</th> -->
                                    <!-- <th>Purchase Order</th> -->
                                    <th>Bill No.</th>
                                    <!-- <th>Bill Date</th> -->
                                    <th>Bill Amount</th>
                                    <!-- <th>ETD</th> -->
                                    <!-- <th>ETA</th> -->
                                    <!-- <th>Request Initiator</th> -->
                                    <th>Bill Details</th>
                                    <th>Approval Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="highlight">
                    <h4>Notification Panel (Non-trade)</h4>
                    <hr style="border-color: black">
                    <div class="row">
                        
                    <div class="col-sm-12">
                        <h4>Payment Details</h4>
                        <table id="filter_results" class="table table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor</th>
                                    <th>Invoice No.</th>
                                    <th>Invoice Date</th>
                                    <th>Total Payable</th>
                                    <th>Total Paid</th>
                                    <th>Payment Approval Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                        <?php 
                        $iter= 1;
                        foreach($payment_bill_ntrade as $ab){
                            // echo '<pre>'; print_r($pb); die;
                        ?>

                            <tr>
                                <td><?=$iter++?></td>
                                <td><?=$ab->name?></td>
                                <td><?=$ab->invoice_no?></td>
                                <td><?=$ab->invoice_date?></td>
                                <td><?=$ab->total_payable?></td>
                                <td nowrap><?=fetch_bill_details($ab->pbt_id,'payment_bill_details_ntrade')?></td>
                                <td><?=($ab->payment_approval_status == 0) ? 'Pending' : 'Approved'?></td>
                                <td><?=($ab->payment_status == 'Pending') ? 'Pending' : 'Completed'?></td>
                                <td>
                                    <a class="btn btn-info" href="<?=base_url('admin/payment-intent-edit-ntrade') . '/' . $ab->pbt_id?>">Edit</a>
                                    <a class="btn btn-warning" href="<?=base_url('admin/payment-intent-print-ntrade') . '/' . $ab->pbt_id?>">Print</a>
                                    <?php  
                                    if($ab->payment_approval_status == 0) {
                                        ?>
                                        <a href="javascript:void(0)" data-pk="<?=$ab->pbt_id?>" class="btn btn-danger delete">Delete</a>
                                        <?php
                                    } 
                                    ?>
                                </td>
                            </tr>
                        
                        <?php    
                        } 
                        ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Vendor</th>
                                    <th>Invoice No.</th>
                                    <th>Invoice Date</th>
                                    <th>Total Payable</th>
                                    <th>Total Paid</th>
                                    <th>Payment Approval Status</th>
                                    <th>Payment Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
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

<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>
<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>
<!--Select2-->
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<script>
    $('.select2').select2();
</script>
<!--Icheck-->
<script src="<?=base_url();?>assets/admin_panel/js/icheck/skins/icheck.min.js"></script>
<script src="<?=base_url();?>assets/admin_panel/js/icheck-init.js"></script>
<!--form validation-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.validate.min.js"></script>
<!--ajax form submit-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>

    $(document).ready(function() {
        
        $('#filter_results').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excel', 'print'
            ],
            initComplete: function () {
                this.api()
                    .columns()
                    .every(function () {
                        let column = this;
                        let title = column.footer().textContent;
        
                        // Create input element
                        let input = document.createElement('input');
                        input.placeholder = title;
                        column.footer().replaceChildren(input);
        
                        // Event listener for user input
                        input.addEventListener('keyup', () => {
                            if (column.search() !== this.value) {
                                column.search(input.value).draw();
                            }
                        });
                    });
            }
        } );
        $('.select2').select2();
        CKEDITOR.replaceClass = 'ckeditor';
    });
    
</script>

</body>
</html>