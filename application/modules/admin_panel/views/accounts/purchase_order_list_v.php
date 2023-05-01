<?php  ?>

<?php  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$tab_title . ' | ' . WEBSITE_NAME?></title>
    <meta name="description" content="admin panel">

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); //left side menu ?>
    <!-- /common head -->

    <!-- Start grocerycrud JS & STYLES -->
    <?php
if (!empty($output)) {
	foreach ($css_files as $file):
	?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php
endforeach;
	foreach ($js_files as $file):
	?>
        <script src="<?php echo $file; ?>"></script>
        <?php
endforeach;
}
?>
    <!--  End grocerycrud JS & STYLES  -->

    <style>
        .form-control{
            height: 30px !important;
        }

        .vewofr, .editex {
            text-decoration: none !important;
            font-size: 15px !important;
            /*color: #24af10 !important;*/
        }
    </style>
</head>

<body class="sticky-header">

<section>
    <?php
if (!isset($state)) {
	$state = '';
}
?>

    <input type="hidden" name="state" value ="<?=(isset($state) ? $state : '')?>" id="state"/>
    <input type="hidden" name="emp_code" value ="<?=(isset($emp_code) ? $emp_code : '')?>" id="emp_code"/>

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
                            <?php echo $add_button; ?>
                            <?php echo $output; ?>
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

<!-- Placed js at the end of the document so the pages load faster -->
<!--<script src="--><?//=base_url();?><!--assets/admin_panel/js/jquery-1.10.2.min.js"></script>-->
<!--<script src="--><?//=base_url();?><!--assets/admin_panel/js/jquery-migrate.js"></script>-->

<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>
<!-- /common js -->

<?php
//open print page
if (isset($print)) {
	?>
    <script>window.open("<?=base_url($print);?>");</script>
    <?php
}
?>

<script>
    //making required fields label color red
    $("span.required").parents('div.form-display-as-box').css("color", "red");

    $(window).on('load',function(){
        if($("#state").val() == 'add'){
            // alert();
            $("#field-e_code").val($("#emp_code").val());
        }
    })

</script>

</body>
</html>