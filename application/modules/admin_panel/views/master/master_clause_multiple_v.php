<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$tab_title . ' | ' . WEBSITE_NAME?></title>
    <meta name="description" content="admin panel">

    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">

    <!--iCheck-->
    <link href="<?=base_url();?>assets/admin_panel/js/icheck/skins/all.css" rel="stylesheet">

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    
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
            <img src="<?=base_url();?>assets/img/logo_20px.png" alt="Shilpa Logo">
<!--            <i class="fa fa-home"></i>-->
            <span class="brand-name"><strong><?=WEBSITE_NAME_SHORT;?></strong></span>
        </a>
    </div>

    <div class="icon-logo theme-logo-bg hidden-xs hidden-sm">
        <a href="<?=base_url();?>" target="_blank">
            <img src="<?=base_url();?>assets/img/logo_20px.png" alt="Shilpa Logo">
        </a>
    </div>
    <!--logo and logo icon end-->

    <!--toggle button start-->
    <a class="toggle-btn"><i class="fa fa-outdent"></i></a>
    <!--toggle button end-->

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
                            <form method="post" action="">
                                <div class="col-lg-3">
                                    <label for="customer_id">Select Customer</label>
                                    <select required multiple name="customer_id[]" id="customer_id" class="select2 form-control">
                                        <?php foreach($customers as $customer){ ?>
                                            <option value="<?=$customer->am_id?>"><?=$customer->name?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="clause_name">Clause Name</label>
                                    <input required type="text" name="clause_name" id="clause_name" class="form-control" value="">
                                </div>
                                <div class="col-lg-3">
                                    <label for="clause_details">Clause Details</label>
                                    <textarea required name="clause_details" id="clause_details" class="form-control" value=""></textarea>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">Action</label><br>
                                    <input type="submit" class="btn btn-success" value="Submit">
                                </div>

                            </form>
                        </div>
                        <?php if(isset($insert_flag) and $insert_flag){ ?>
                            <div class="panel-footer bg-white">
                                <h4 class="text-success text-center"><b>Data successfully inserted</b></h4>
                            </div>
                        <?php } ?>
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

<script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>
<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>
<!--Select2-->
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<script>
    $('.select2').select2();
</script>

</body>
</html>