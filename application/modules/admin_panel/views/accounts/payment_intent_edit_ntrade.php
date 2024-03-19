<?php  
function fetch_amnt_paid($pb_id, $pay_method, $currency){
    $CI = & get_instance();
    $nr_per = $CI->db->get_where('payment_bill_details', array('payment_bill_id' => $pb_id))->num_rows();

    if($pay_method == 'Percentage'){
        if($nr_per > 0){
            $paid = $CI->db->select('SUM(paid_percentage) as paid')->group_by('payment_bill_id')->get_where('payment_bill_details', array('payment_bill_id' => $pb_id))->row()->paid . ' %';
        }else{
            $paid = '0 (%)';
        }
    }else{
        if($nr_per > 0){
            $paid = $CI->db->select('SUM(paid_flat) as paid')->group_by('payment_bill_id')->get_where('payment_bill_details', array('payment_bill_id' => $pb_id))->row()->paid . ' ' . $currency;
        }else{
            $paid = '- (Flat)';
        }
    }
    return $paid;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$tab_title . ' | ' . WEBSITE_NAME?></title>
    <meta name="description" content="admin panel">
    <!-- common head -->
    <?php $this->load->view('components/_common_head'); //left side menu ?>
    <!-- /common head -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!--Select2-->
    <link href="<?=base_url('assets/admin_panel/css/select2.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/admin_panel/css/select2-bootstrap.css')?>" rel="stylesheet">
    <style>
        .nav-tabs > li{width: 200px;text-align: center;}
        ul.nav.nav-tabs{margin-bottom: 20px;}
        .select2-container .select2-choice, .form-control{border: 1px solid #626262}
        label{font-weight: bold;}
        .col-lg-3{margin-bottom:10px;}
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
        <div class="header-section light-color" style="background-color: #1c352b">

            <!--logo and logo icon start-->
            <div class="logo theme-logo-bg hidden-xs hidden-sm">
                <a href="<?=base_url();?>" target="_blank">
                    <img src="<?=base_url();?>assets/img/logo_20px.png" alt="Logo">
        <!--            <i class="fa fa-home"></i>-->
                    <span class="brand-name"><strong><?=WEBSITE_NAME_SHORT;?></strong></span>
                </a>
            </div>

            <div class="icon-logo theme-logo-bg hidden-xs hidden-sm">
                <a href="<?=base_url();?>" target="_blank">
                    <img src="<?=base_url();?>assets/img/logo_20px.png" alt="Logo">
        <!--            <i class="fa fa-home"></i>-->
                </a>
            </div>
            <!--logo and logo icon end-->

            <!--toggle button start-->
            <a class="toggle-btn"><i class="fa fa-outdent"></i></a>
            <!--toggle button end-->

            <div class="notification-wrap">
                <!--right notification start-->
                <div class="right-notification">
                    <ul class="notification-menu">
                        <li>
                            <a href="javascript:;" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                <?php
                                $user_row = $this->db->get_where('user_details', array('user_id' => $this->session->user_id))->row();
                                $profile_img = isset($user_row->img) ? $user_row->img : 'default.png';
                                ?>
                                <img class="profile_img" src="<?=base_url();?>assets/admin_panel/img/profile_img/<?=$profile_img;?>" />
                                <span class="lastname"><?=$this->session->name; //user lastname?></span>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu purple pull-right">
                                    <li><a href="<?=base_url();?>admin/profile"><i class="fa fa-vcard-o pull-right"></i>Profile</a></li>
                                <li><a href="<?=base_url();?>logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <!--right notification end-->
            </div>
        </div>
        <!-- header section end-->
        <!--body wrapper start-->
        <div class="wrapper">
            <div class="row">
                <?php #echo '<pre>', print_r($all_bills), '</pre>' ?>
                <div class="col-lg-10">
                    <section class="panel">
                        <header class="panel-heading">
                            <?=$section_heading;?>
                        </header>
                        <div class="panel-body">
                            <form class="" action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="vendor">Select vendor</label>
                                        <select required class="form-control" name="vendor" id="">
                                            <?php foreach($ntrade_vendors as $nv){ ?>
                                            <option <?=(!empty($all_bills[0]->vendor)) ? ($all_bills[0]->vendor == $nv->am_id) ? 'selected' : '' : '' ?> value="<?=$nv->am_id?>"><?=$nv->name?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="payment_type">Select payment type</label>
                                        <select required class="form-control" name="payment_type" id="">
                                            <?php foreach($payment_types as $pt){ ?>
                                            <option <?=(!empty($all_bills[0]->payment_type)) ? (($all_bills[0]->payment_type == $pt->pt_id) ? 'selected' : '') : '' ?> value="<?=$pt->pt_id?>"><?=$pt->payment_title?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="mode_of_payment">Select payment mode</label>
                                        <select required class="form-control" name="mode_of_payment" id="">
                                            <?php foreach($payment_modes as $pm){ ?>
                                            <option <?=(!empty($all_bills[0]->mode_of_payment)) ? (($all_bills[0]->mode_of_payment == $pm->pm_id) ? 'selected' : '') : '' ?> value="<?=$pm->pm_id?>"><?=$pm->payment_title?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="invoice_no">Invoice No.</label>
                                        <input type="text" class="form-control" name="invoice_no" value="<?=(!empty($all_bills[0]->invoice_no)) ? $all_bills[0]->invoice_no : '' ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="invoice_date">Invoice Date</label>
                                        <input type="date" class="form-control" name="invoice_date" value="<?=(!empty($all_bills[0]->invoice_date)) ? $all_bills[0]->invoice_date : '' ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="requisition_no">Requisition No.</label>
                                        <input type="text" class="form-control" name="requisition_no" value="<?=(!empty($all_bills[0]->requisition_no)) ? $all_bills[0]->requisition_no : '' ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="deadline">Deadline</label>
                                        <input type="date" class="form-control" name="deadline" value="<?=(!empty($all_bills[0]->deadline)) ? $all_bills[0]->deadline : '' ?>">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="total_payable">Total Payable</label>
                                        <input required type="text" class="form-control" name="total_payable" value="<?=(!empty($all_bills[0]->total_payable)) ? $all_bills[0]->total_payable : '' ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload Invoice</label>
                                        <input type="file" name="userfile1" id="userfile1" accept=".jpg,.jpeg,.png,.bmp" class="file">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload PO</label>
                                        <input type="file" name="userfile2" id="userfile2" accept=".jpg,.jpeg,.png,.bmp" class="file">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload PI</label>
                                        <input type="file" name="userfile3" id="userfile3" accept=".jpg,.jpeg,.png,.bmp" class="file">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload Supplier PI</label>
                                        <input type="file" name="userfile4" id="userfile4" accept=".jpg,.jpeg,.png,.bmp" class="file">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload Requisite</label>
                                        <input type="file" name="userfile5" id="userfile5" accept=".jpg,.jpeg,.png,.bmp" class="file">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload Others</label>
                                        <input type="file" name="userfile6" id="userfile6" accept=".jpg,.jpeg,.png,.bmp" class="file">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-2">
                                        <label for="payment_method">Payment Type</label>
                                        <select required name="payment_method" id="payment_method" class="form-control select2">
                                            <option <?= ($bill_id != 0) ? (($all_bills[0]->payment_method == 'Percentage') ? 'selected' : 'disabled') : '' ?> value="Percentage">Percentage</option>
                                            <option <?= ($bill_id != 0) ? ($all_bills[0]->payment_method == 'Flat') ? 'selected' : 'disabled' : '' ?> value="Flat">Flat</option>
                                        </select>
                                    </div>
                                    <?php if(($bill_id != 0) and ($session_user_payment_role == 3)){ // show to accnt_head ?>
                                    <div class="col-lg-2">        
                                        <label for="payment_approval_status">Approval Status</label>
                                        <select name="payment_approval_status" id="payment_approval_status" class="form-control select2">
                                            <option <?=(isset($all_bills[0]) and $all_bills[0]->payment_approval_status == 0) ? 'selected' : ''?> value="0">Not approved</option>
                                            <option <?=(isset($all_bills[0]) and $all_bills[0]->payment_approval_status == 1) ? 'selected' : ''?> value="1">Approved</option>
                                        </select>
                                    </div>        
                                    <?php }else{
                                        ?>
                                        <input type="hidden" name="payment_approval_status" id="payment_approval_status" class="form-control hidden" value="0" />
                                        <?php
                                    } ?> 
                                    <?php if(($bill_id != 0) and ($session_user_payment_role == 3)){ // show to accnt_head ?>
                                        <div class="col-lg-2">        
                                            <label for="payment_status">Payment Status</label>
                                            <select required name="payment_status" id="payment_status" class="form-control select2">
                                                <option <?= ($bill_id != 0) ? (($all_bills[0]->payment_status == 'Pending') ? 'selected' : '') : '' ?> value="Pending">Pending</option>
                                                <option <?= ($bill_id != 0) ? ($all_bills[0]->payment_status == 'Completed') ? 'selected' : '' : '' ?> value="Completed">Completed</option>
                                            </select>
                                        </div>
                                    <?php } ?> 
                                    <div class="col-lg-4">
                                        <label for="remark">Remark</label>
                                        <textarea name="remark" id="" class="form-control"><?=($bill_id != 0) ? $all_bills[0]->remark : ''?></textarea>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="submit">Action</label><br>
                                        <input type="hidden" value="<?=$bill_id?>" name="pb_id">
                                        <?php if($bill_id == 0){ ?>
                                            <input type="hidden" name="payment_status" id="payment_status" class="form-control hidden" value="Pending" />
                                            <input type="hidden" name="payment_approved_by" id="payment_approved_by" class="form-control hidden" value=<?=$user_id?> />
                                            <input type="submit" name="bill_add" value="Add" class="btn btn-success">
                                        <?php } else{
                                            if(($session_user_payment_role != NULL) or ($session_user_payment_role != '') or $all_bills[0]->payment_approval_status == '0'){
                                                ?>
                                                <input type="hidden" name="payment_approved_by" id="payment_approved_by" class="form-control hidden" value=<?=$user_id?> />
                                                <input type="hidden" name="payment_approver_role" id="payment_approver_role" class="form-control hidden" value=<?=$session_user_payment_role?> />
                                                <input type="submit" name="bill_edit" value="Update" class="btn btn-success">
                                                <?php    
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </form>    
                        </div>
                    </section>

                    <hr>
                    <?php if($bill_id != 0){ ?>
                    <section class="panel">
                        <header class="panel-heading">
                            <b>Details:</b> <?=$section_heading;?>
                        </header>
                        <div class="panel-body">

                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#list">List</a></li>
                                <li><a data-toggle="tab" href="#add">Add Payment Release</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="list" class="tab-pane fade in active">
                                    
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Payment Date</th>
                                                <th>Payable in Percentage</th>
                                                <th>Paid in Percentage</th>
                                                <th>Payable in Flat</th>
                                                <th>Paid in Flat</th>
                                                <th>Remark</th>
                                                <th>Approval Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        foreach($all_bills as $ab){
                                            if(empty($all_bills[0]->payment_bill_id)){
                                                continue;
                                            }
                                            ?>
                                            <tr>
                                                <td><?=date('d-m-Y', strtotime($ab->payment_date))?></td>
                                                <td><?=$ab->payable_percentage?></td>
                                                <td><?=$ab->paid_percentage?></td>
                                                <td><?=$ab->payable_flat?></td>
                                                <td><?=$ab->paid_flat?></td>
                                                <td><?=$ab->remark?></td>
                                                <td>
                                                    <?php
                                                        $db_role = ($ab->intent_approver_role == '' or $ab->intent_approver_role == NULL) ? '0' : $ab->intent_approver_role; // 0 for non-accnt user
                                                        if($ab->bill_intent_permission == '0'){
                                                            echo 'Waiting from <b>Junior Head</b>';
                                                        } else if($db_role == 1){
                                                            echo 'Waiting from <b>Senior Head</b>';
                                                        } else if($db_role == 2){
                                                            echo 'Waiting from <b>Account Head</b>';
                                                        }else{
                                                            echo 'Completed';
                                                        }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 

                                                        if($ab->bill_intent_permission == 0){
                                                            ?>
                                                            <a data-pk="<?=$ab->pbd_id?>" data-toggle="modal" href="#" class="btn btn-info edit">Edit</a>
                                                            <a data-pk="<?=$ab->pbd_id?>" href="javascript:void(0)" class="btn btn-danger delete">Delete</a>
                                                            <?php
                                                        } else if($db_role < $session_user_payment_role ){
                                                            ?>
                                                            <a data-pk="<?=$ab->pbd_id?>" data-toggle="modal" href="#" class="btn btn-info edit">Edit</a>
                                                            <a data-pk="<?=$ab->pbd_id?>" href="javascript:void(0)" class="btn btn-danger delete">Delete</a>
                                                            <?php
                                                        }else {
                                                            echo '-';
                                                        } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </table>
                                
                                </div>
                                <div id="add" class="tab-pane fade">
                                    <form action="" id="payment_intent_ntrade" method="post">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <label for="payment_date">Payment Date</label>
                                                <input type="date" name="payment_date" id="payment_date" value="" class="form-control">
                                            </div>
                                            <?php if($all_bills[0]->payment_method == 'Flat'){ ?>
                                            <div class="col-lg-2">
                                                <label for="payable_flat">Payable in Flat</label>
                                                <input type="text" name="payable_flat" id="payable_flat" value="" class="form-control">
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="paid_flat">Paid in Flat</label>
                                                <?php if(($session_user_payment_role != NULL) or ($session_user_payment_role != '')){ ?>
                                                <input type="text" name="paid_flat" id="paid_flat" value="" class="form-control">
                                                <?php } else{ ?>
                                                    <input readonly disabled type="text" name="paid_flat" id="paid_flat" value="" class="form-control">    
                                                <?php } ?>
                                            </div>
                                            <?php }else{ ?>
                                            <div class="col-lg-2">
                                                <label for="payable_percentage">Payable in Percentage</label>
                                                <input type="text" name="payable_percentage" id="payable_percentage" value="" class="form-control">
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="paid_percentage">Paid in Percentage</label>
                                                <?php if(($session_user_payment_role != NULL) or ($session_user_payment_role != '')){ ?>
                                                <input type="text" name="paid_percentage" id="paid_percentage" value="" class="form-control">
                                                <?php } else{ ?>
                                                    <input readonly disabled type="text" name="paid_percentage" id="paid_percentage" value="" class="form-control">
                                                <?php } ?>
                                            </div>
                                            <?php } ?>
                                            <div class="col-lg-3">
                                                <label for="remark">Remark</label>
                                                <textarea name="remark" id="remark" rows="3" class="form-control"></textarea>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="payment_add">Action</label><br>
                                                <input type="submit" name="payment_add" value="Add" class="btn btn-success">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php } ?>
                </div>
                <div class="col-lg-2">
                    <section class="panel">
                        <header class="panel-heading">Summary</header>
                        <div class="panel-body">
                            <p><b>Total Payable:</b> <?=(!empty($all_bills[0]->total_payable) ? $all_bills[0]->total_payable : '-')?> </p>
                            <p>
                                <b>Total Paid:</b> 
                                <?php 
                                $total = 0;
                                if(isset($all_bills[0]) and ($all_bills[0]->paid_flat != '' or $all_bills[0]->paid_percentage != '')){ 
                                    foreach($all_bills as $ab){
                                        $total += $ab->paid_flat;
                                        $total += $ab->paid_percentage;
                                    }
                                    echo $total; 
                                } 
                                ?>
                             </p>
                            <hr>
                            <p>
                                <b>Pending:</b> 
                                <?php 
                                    if(isset($all_bills[0]) and $all_bills[0]->payment_method == 'Flat'){ 
                                        echo number_format($all_bills[0]->total_payable - $total, 2);
                                    }else{
                                        echo number_format(100 -$total, 2) . ' %';
                                    }
                                ?>
                            </p>
                        </div>
                    </section>
                    <br><br>
                    <section class="panel">
                        <header class="panel-heading">Files</header>
                        <div class="panel-body">
                            <?php 
                            if($all_bills[0]->userfile1){
                            ?>
                                <p>
                                    <a target="_new" class="col-sm-6" href="<?=base_url('upload/accounts') . '/' . $all_bills[0]->userfile1?>">Invoice</a> 
                                    &nbsp;&nbsp;
                                    <button data-fid="userfile1" data-pid="<?=$all_bills[0]->pbt_id?>" class="btn btn-danger btn-sm delete-file">
                                        <i class="fa fa-close"></i> Delete
                                    </button>
                                </p>
                                <hr>
                            <?php
                            } 
                            if($all_bills[0]->userfile2){
                            ?>
                                <p>
                                    <a target="_new" class="col-sm-6" href="<?=base_url('upload/accounts') . '/' . $all_bills[0]->userfile2?>">PO</a> 
                                    &nbsp;&nbsp;
                                    <button data-fid="userfile2" data-pid="<?=$all_bills[0]->pbt_id?>" class="btn btn-danger btn-sm delete-file">
                                        <i class="fa fa-close"></i> Delete
                                    </button>
                                </p>
                                <hr>
                            <?php
                            } 
                            if($all_bills[0]->userfile3){
                            ?>
                                <p>
                                    <a target="_new" class="col-sm-6" href="<?=base_url('upload/accounts') . '/' . $all_bills[0]->userfile3?>">PI</a> 
                                    &nbsp;&nbsp;
                                    <button data-fid="userfile3" data-pid="<?=$all_bills[0]->pbt_id?>" class="btn btn-danger btn-sm delete-file">
                                        <i class="fa fa-close"></i> Delete
                                    </button>
                                </p>
                                <hr>
                            <?php
                            } 
                            if($all_bills[0]->userfile4){
                            ?>
                                <p>
                                    <a target="_new" class="col-sm-6" href="<?=base_url('upload/accounts') . '/' . $all_bills[0]->userfile4?>">Supplier PI</a> 
                                    &nbsp;&nbsp;
                                    <button data-fid="userfile4" data-pid="<?=$all_bills[0]->pbt_id?>" class="btn btn-danger btn-sm delete-file">
                                        <i class="fa fa-close"></i> Delete
                                    </button>
                                </p>
                                <hr>
                            <?php
                            } 
                            if($all_bills[0]->userfile5){
                            ?>
                                <p>
                                    <a target="_new" class="col-sm-6" href="<?=base_url('upload/accounts') . '/' . $all_bills[0]->userfile5?>">Requisite</a> 
                                    &nbsp;&nbsp;
                                    <button data-fid="userfile5" data-pid="<?=$all_bills[0]->pbt_id?>" class="btn btn-danger btn-sm delete-file">
                                        <i class="fa fa-close"></i> Delete
                                    </button>
                                </p>
                                <hr>
                            <?php
                            } 
                             
                            if($all_bills[0]->userfile6){
                            ?>
                                <p>
                                    <a target="_new" class="col-sm-6" href="<?=base_url('upload/accounts') . '/' . $all_bills[0]->userfile6?>">Others</a> 
                                    &nbsp;&nbsp;
                                    <button data-fid="userfile6" data-pid="<?=$all_bills[0]->pbt_id?>" class="btn btn-danger btn-sm delete-file">
                                        <i class="fa fa-close"></i> Delete
                                    </button>
                                </p>
                                <hr>
                            <?php
                            } 
                            ?>
                        </div>
                    </section>
                </div>
            </div>

        </div>
        <!--body wrapper end-->
        <!--footer section start-->
        <?php $this->load->view('components/footer');?>
        <!--footer section end-->

    </div>
    <!-- body content end-->
</section>
<script src="<?=base_url('assets/admin_panel/js/jquery-1.10.2.min.js')?>"></script>
<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>
<!-- /common js -->
<!-- modal for edit -->
<div class="modal fade" id="edit_payment_details_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Payment Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" class="row">
            <div class="col-lg-2">
                <label for="payment_date_modal">Payment Date</label>
                <input type="date" name="payment_date_modal" id="payment_date_modal" value="" class="form-control">
            </div>
            <?php if($all_bills[0]->payment_method == 'Flat'){ ?>
            <div class="col-lg-2">
                <label for="payable_flat_modal">Payable in Flat</label>
                <input type="text" name="payable_flat_modal" id="payable_flat_modal" value="" class="form-control">
            </div>
            <?php if($session_user_payment_role == 3){ ?>
            <div class="col-lg-2">
                <label for="paid_flat">Paid in Flat</label>
                <input required type="text" name="paid_flat_modal" id="paid_flat_modal" value="" class="form-control">
            </div>
            <?php 
                }
            } else{ ?>
            <div class="col-lg-2">
                <label for="payable_percentage">Payable in Percentage</label>
                <input type="text" name="payable_percentage_modal" id="payable_percentage_modal" value="" class="form-control">
            </div>
            <?php if($session_user_payment_role == 3){ ?>
            <div class="col-lg-2">
                <label for="paid_percentage">Paid in Percentage</label>
                <input required type="text" name="paid_percentage_modal" id="paid_percentage_modal" value="" class="form-control">
            </div>
            <?php 
                }
            } 
            ?>
            <div class="col-lg-3">
                <label for="remark">Remark</label>
                <textarea name="remark_modal" id="remark_modal" rows="3" class="form-control"></textarea>
            </div>
            <?php if(($bill_id != 0) and (($session_user_payment_role != NULL) or ($session_user_payment_role != ''))){ ?>
            <div class="col-lg-2">
                <label for="bill_intent_permission_modal">Bill Details Permission</label>
                <select class="form-control" name="bill_intent_permission_modal" id="bill_intent_permission_modal">
                    <option value="1">Approve</option>
                    <option value="0">Reject</option>
                </select>  
            </div>
            <?php } ?>
            <div class="col-lg-2">
                <!-- <label for="payment_add">Action</label><br> -->
                <input type="hidden" name="payment_details_pk" id="payment_details_pk" value="" class="btn btn-success">
                <input type="submit" name="payment_update_modal" value="Update" class="btn btn-success">
            </div>
        </form>   
      </div>
    </div>
  </div>
</div>
<!-- modal for edit ends -->
<script>

    $('.edit').on('click', function (e) {
        inputDate = ($(this).closest('tr').find('td:eq(0)').text())
        var arr = inputDate.split('-');
        str = arr[2] +'-'+arr[1]+'-'+arr[0]
        $("#payment_date_modal").val(str)
        $("#payable_percentage_modal").val($(this).closest('tr').find('td:eq(1)').text())
        $("#paid_percentage_modal").val($(this).closest('tr').find('td:eq(2)').text())
        $("#payable_flat_modal").val($(this).closest('tr').find('td:eq(3)').text())
        $("#paid_flat_modal").val($(this).closest('tr').find('td:eq(4)').text())
        $("#remark_modal").text($(this).closest('tr').find('td:eq(5)').text())

        $("#payment_details_pk").val($(this).data('pk'))

        $('#edit_payment_details_modal').modal('show')
    })
    
    
    $(document).on('click', ".delete", function(){
        if(confirm("Are you sure?")){
            pbd_id = $(this).data('pk')
            $this = $(this);
            $.ajax({
                url: "<?=base_url('admin/delete_payment_bill_details_ntrade')?>",
                dataType: 'json',
                method: 'post',
                data: {pk: pbd_id},
                success: function(rdata){
                    $this.closest('tr').remove();
                    alert('Deleted. Please reload the page to update Summary section.')
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    console.log("Status: " + textStatus); 
                    console.log("Error: " + errorThrown); 
                }
            })
        }
    })


    $(document).on('click', ".delete-file", function(){
        if(confirm("Are you sure?")){
            pid = $(this).data('pid')
            fid = $(this).data('fid')
            $this = $(this);
            $.ajax({
                url: "<?=base_url('admin/delete_payment_bill_file')?>",
                dataType: 'json',
                method: 'post',
                data: {pid:pid,fid:fid},
                success: function(rdata){
                    $this.closest('p').remove();
                    // alert('Deleted. Please reload the page to update Summary section.')
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    console.log("Status: " + textStatus); 
                    console.log("Error: " + errorThrown); 
                }
            })
        }
    })

    // $("#payment_intent").submit(function(){
    //     usertype = "< ?=$usertype?>";
    //     appr_stat = $("#payment_approval_status").find("option:selected").val()
    //     if($("#purchase_order_no").val() == '' && appr_stat == 1 && (usertype == "1" || usertype == "7")){
    //         alert("PO No. can\'t be blank.")
    //         $("#purchase_order_no").focus()
    //         return false
    //     }
    // })
    
</script>

<!--Select2-->
<script src="<?=base_url('assets/admin_panel/js/select2.js')?>" type="text/javascript"></script>
<script>
    $('.select2').select2();
</script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $("table").DataTable()
</script>
</body>
</html>