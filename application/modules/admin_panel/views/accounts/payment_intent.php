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

function fetch_amnt_paid_ntrade($pb_id, $pay_method, $currency=''){
    $CI = & get_instance();
    $nr_per = $CI->db->get_where('payment_bill_details_ntrade', array('payment_bill_id' => $pb_id))->num_rows();

    if($pay_method == 'Percentage'){
        if($nr_per > 0){
            $paid = $CI->db->select('SUM(paid_percentage) as paid')->group_by('payment_bill_id')->get_where('payment_bill_details_ntrade', array('payment_bill_id' => $pb_id))->row()->paid . ' %';
        }else{
            $paid = '0 (%)';
        }
    }else{
        if($nr_per > 0){
            $paid = $CI->db->select('SUM(paid_flat) as paid')->group_by('payment_bill_id')->get_where('payment_bill_details_ntrade', array('payment_bill_id' => $pb_id))->row()->paid . ' ' . $currency;
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
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">
                            <?=$section_heading;?>
                        </header>
                        <div class="panel-body">
                            <a href="<?=base_url('admin/payment-intent-edit') . '/0'?>" class="btn btn-success">Request Intent (Trade)</a>
                            <hr>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Offer</th>
                                        <th>FZ Ref. No.</th>
                                        <th>Partial Ref.</th>
                                        <th>Supplier</th>
                                        <th>Vendor</th>
                                        <th>Total Amnt.</th>
                                        <th>Total Paid</th>
                                        <th>Payment Approval Status</th>
                                        <th>Payment Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                // echo '<pre>'; print_r($all_bills);
                                foreach($all_bills as $ab){
                                    
                                    // if($ab->payment_approver_role == 0 or $ab->payment_approver_role == ''){
                                        ?>
                                        <tr>
                                            <td><?=$ab->offer_name?></td>
                                            <td><?=$ab->fz_ref_no?></td>
                                            <td><?=$ab->partial_reference?></td>
                                            <td><?=$ab->customer_name?></td>
                                            <td><?=$ab->vendor_name?></td>
                                            <td><?=$ab->total_payment_amount?></td>
                                            <td><?=fetch_amnt_paid($ab->pb_id, $ab->payment_method, $ab->currency)?></td>
                                            <td><?=($ab->payment_approval_status == 0) ? 'Pending' : 'Approved'?></td>
                                            <td><?=($ab->payment_status == 'Pending') ? 'Pending' : 'Completed'?></td>
                                            <td>
                                                <a class="btn btn-sm btn-info" href="<?=base_url('admin/payment-intent-edit') . '/' . $ab->pb_id?>">Edit</a>
                                                <a class="btn btn-sm btn-primary" href="<?=base_url('admin/payment-intent-print') . '/' . $ab->pb_id?>">Print</a>
                                                <?php  
                                                if($ab->payment_approval_status == 0) {
                                                    ?>
                                                    <a href="javascript:void(0)" data-pk="<?=$ab->pb_id?>" class="btn btn-danger btn-sm delete">Delete</a>
                                                    <?php
                                                } 
                                                ?>
                                                <a target="_new" class="btn btn-sm btn-warning" href="<?=base_url('admin/export-edit') . '/' . $ab->export_id?>">Export Link</a>
                                            </td>
                                        </tr>
                                        <?php
                                    // } 
                                }
                                ?>
                                </tbody>
                            </table>    
                        </div>
                    </section>
                </div>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">PAYMENT INTENT BILL (NON-TRADE)</header>
                        <div class="panel-body">
                            <a href="<?=base_url('admin/payment-intent-edit-ntrade') . '/0'?>" class="btn btn-success">Request Intent (Non-trade)</a>
                            <hr>
                            <table class="table">
                                <thead>
                                    <tr>
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
                                // echo '<pre>'; print_r($all_bills);
                                foreach($all_bills_ntrade as $ab){
                                    
                                    // if($ab->payment_approver_role == 0 or $ab->payment_approver_role == ''){
                                        ?>
                                        <tr>
                                            <td><?=$ab->name?></td>
                                            <td><?=$ab->invoice_no?></td>
                                            <td><?=$ab->invoice_date?></td>
                                            <td><?=$ab->total_payable?></td>
                                            <td><?=fetch_amnt_paid_ntrade($ab->pbt_id, $ab->payment_method, $ab->currency='')?></td>
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
                                    // } 
                                }
                                ?>
                                </tbody>
                            </table>    
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
<script src="http://seafoodmiddleeast.net/assets/admin_panel/js/jquery-1.10.2.min.js"></script>
<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>
<!-- /common js -->

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $("table").DataTable();

    $(document).on('click', ".delete", function(){
        if(confirm("Are you sure?")){
            pb_id = $(this).data('pk')
            $this = $(this);
            $.ajax({
                url: "<?=base_url('admin/delete_payment_bill_ntrade')?>",
                dataType: 'json',
                method: 'post',
                data: {pk: pb_id},
                success: function(rdata){
                    $this.closest('tr').remove();
                    alert('Row deleted. Details also delete.')
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) { 
                    console.log("Status: " + textStatus); 
                    console.log("Error: " + errorThrown); 
                }
            })
        }
    })

</script>
</body>
</html>