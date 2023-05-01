<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard | <?=WEBSITE_NAME;?></title>
    <meta name="keyword" content="user dashboard">
    <meta name="description" content="account statistic">

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->
</head>

<body class="sticky-header">

<section>
    <!-- sidebar left start (Menu)-->
    <?php $this->load->view('components/left_sidebar'); //left side menu ?>
    <!-- sidebar left end (Menu)-->
    <style>
        .p-1{padding: 1%;}
        .pt-0{padding-top: 0}
        .px-1{padding: 1rem 0;}
        .mb-1{margin-bottom: 1rem;}
        .mb-2{margin-bottom: 2rem;}
        .panel{min-height: 400px;}
        .panel-footer {background-color: rgb(0 0 0 / 15%);position: absolute;bottom: 0;width: 100%;}
        .text-white{color:#fff;}
        .text-dark{color:#000;}
        .border-bottom{border-bottom: 1px solid #787878;}
    </style>
    <!-- body content start-->
    <div class="body-content" style="min-height: 1500px;">

        <!-- header section start-->
        <?php $this->load->view('components/top_menu'); ?>
        <!-- header section end-->

        <!-- page head start-->
        <div class="page-head">
            <h3>Dashboard</h3>
            <span class="sub-title">Welcome to <?=WEBSITE_NAME;?> dashboard</span>
        </div>
        <!-- page head end-->

         <!--body wrapper start-->
        <div class="wrapper">

            <?php if($this->session->usertype == 1){ ?>

            <div class="col-md-6">
                <div class="panel">
                    <?php //print_r($lastest_costings) ?>
                    <div class="panel-header bg-success text-white text-center p-1">
                        <h4>Pending Permissions (Resource Developer)</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Offer Name</th>
                                    <th>Offer Number</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $iter=0;
                        // echo '<pre>', print_r($admin_pending_permissions), '</pre>'; 
                                if(count($admin_pending_permissions) == 0){
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No records found</td>
                                    </tr>
                                    <?php
                                }else{
                                    foreach($admin_pending_permissions as $app){
                                    ?>                
                                    <tr>            
                                        <td><?=++$iter?></td>
                                        <td><?=$app->firstname . ' ' . $app->lastname?></td>
                                        <td><?=$app->offer_name?></td>
                                        <td><?=$app->offer_number?></td>
                                        <td><?=$app->comment?></td>
                                        <td>
                                            <?php 
                                            if($this->session->usertype == 1){
                                                ?>
                                                <a href="<?= base_url('admin/offers?q=resolve&oid='.$app->offer_id.'&ocid='.$app->oc_id) ?>" class="btn bg-beige" target="_blank">Resolve</a>
                                                <?php
                                            }else{
                                                echo 'Pending from Admin';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div> 
            
            <div class="col-md-6">
                <div class="panel">
                    <?php //print_r($lastest_costings) ?>
                    <div class="panel-header bg-success text-white text-center p-1">
                        <h4>Pending Permissions (Marketing Price)</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Offer Name</th>
                                    <th>Offer Number</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $iter=0;
                        // echo '<pre>', print_r($admin_pending_permissions), '</pre>'; 
                                if(count($marketing_price_update) == 0){
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No records found</td>
                                    </tr>
                                    <?php
                                }else{
                                    foreach($marketing_price_update as $app){
                                    ?>                
                                    <tr>            
                                        <td><?=++$iter?></td>
                                        <td><?=$app->firstname . ' ' . $app->lastname?></td>
                                        <td><?=$app->offer_name?></td>
                                        <td><?=$app->offer_number?></td>
                                        <td>Action not taken from Trader</td>
                                        <td><a href="<?= base_url('admin/view-offer/'.$app->offer_id . '/1') ?>" class="btn bg-beige" target="_blank">Resolve</a></td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div> 

            <?php } else if($this->session->usertype == 2){ ?>
            
            <div class="col-md-6">
                <div class="panel">
                    <?php //print_r($lastest_costings) ?>
                    <div class="panel-header bg-success text-white text-center p-1">
                        <h4>Pending Permissions (Resource Developer)</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Offer Name</th>
                                    <th>Offer Number</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $iter=0;
                        // echo '<pre>', print_r($admin_pending_permissions), '</pre>'; 
                                if(count($admin_pending_permissions) == 0){
                                    ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No records found</td>
                                    </tr>
                                    <?php
                                }else{
                                    foreach($admin_pending_permissions as $app){
                                    ?>                
                                    <tr>            
                                        <td><?=++$iter?></td>
                                        <td><?=$app->firstname . ' ' . $app->lastname?></td>
                                        <td><?=$app->offer_name?></td>
                                        <td><?=$app->offer_number?></td>
                                        <td><?=$app->comment?></td>
                                        <td>
                                            <?php 
                                            if($this->session->usertype == 1){
                                                ?>
                                                <a href="<?= base_url('admin/offers?q=resolve&oid='.$app->offer_id.'&ocid='.$app->oc_id) ?>" class="btn bg-beige" target="_blank">Resolve</a>
                                                <?php
                                            }else{
                                                echo 'Pending from Admin';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div> 

            <?php } else if($this->session->usertype == 3){ ?>
            
            <div class="col-md-6">
                <div class="panel">
                    <?php //print_r($lastest_costings) ?>
                    <div class="panel-header bg-success text-white text-center p-1">
                        <h4>Offer Permissions</h4>
                    </div>
                    <div class="panel-body">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <!--<th>Name</th>-->
                                    <th>Offer Name</th>
                                    <th>Offer Number</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $iter=0;
                        // echo '<pre>', print_r($admin_pending_permissions), '</pre>'; 
                                if(count($admin_pending_permissions) == 0){
                                    ?>
                                    <tr>
                                        <td colspan="5" class="text-center">No records found</td>
                                    </tr>
                                    <?php
                                }else{
                                    foreach($admin_pending_permissions as $app){
                                        if($app->offer_name == ''){
                                            continue;
                                        }
                                    ?>                
                                    <tr>            
                                        <td><?=++$iter?></td>
                                        <!--<td>< ?=$app->firstname . ' ' . $app->lastname?></td>-->
                                        <td><?=$app->offer_name?></td>
                                        <td><?=$app->offer_number?></td>
                                        <td>New offer added</td>
                                        <td><a href="<?= base_url('admin/view-offer/'.$app->offer_id . '/1') ?>" class="btn bg-beige" target="_blank">View</a></td>
                                    </tr>
                                    <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>      
            
            <?php } ?>

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
<!--<script src="--><?//=base_url();?><!--assets/admin_panel/js/jquery-migrate.js"></script>-->

<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>

</body>
</html>