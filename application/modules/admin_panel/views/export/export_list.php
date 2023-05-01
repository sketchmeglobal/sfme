<?php
// echo '<pre>', print_r($word_colour), '</pre>'; die;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?> | <?=WEBSITE_NAME;?></title>
    <meta name="description" content="<?=$title?>">

    <!--Data Table-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/css/buttons.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <?php 
    foreach($css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        
    <?php endforeach; ?>

    <style type="text/css">
        /*.ic label{text-decoration: underline;cursor: pointer;}*/
        /*.modal-dialog{width:90%}*/
        tbody tr td:first-child{display:block;min-width: 130px!important}
        .flexigrid table tr.hDiv th, .flexigrid div.bDiv td{vertical-align:bottom!important;}
        .flexigrid .search-div-clear-button {float:none;}
        /* The actual timeline (the vertical ruler) */
        /*.timeline {*/
        /*  position: relative;*/
        /*  max-width: 1200px;*/
        /*  margin: 0 auto;*/
        /*}*/
        
        /* The actual timeline (the vertical ruler) */
        /*.timeline::after {*/
        /*  content: '';*/
        /*  position: absolute;*/
        /*  width: 6px;*/
        /*  background-color: #000;*/
        /*  top: 0;*/
        /*  bottom: 0;*/
        /*  left: 49.5%;*/
        /*  outline: 3px solid #dce1fb;*/
        /*  outline-offset: 1px;*/
          /*margin-left: -3px;*/
        /*}*/
        
        /* Container around content */
        /*.tcontainer {*/
        /*  padding: 10px 40px;*/
        /*  position: relative;*/
        /*  background-color: inherit;*/
        /*  width: 49.50%;*/
        /*}*/
        
        /* The circles on the timeline */
        /*.tcontainer::after { */
        /*  content: '';*/
        /*  position: absolute;*/
        /*  width: 25px;*/
        /*  height: 25px;*/
        /*  right: -17px;*/
        /*  background-color: white;*/
        /*  border: 4px solid #FF9F55;*/
        /*  top: 15px;*/
        /*  border-radius: 50%;*/
        /*  z-index: 1;*/
        /*}*/
        /*.tbreak{ width: 100%;z-index: 1;text-align: center;position: relative; }*/
        /*.tbreak .tcontent{padding:0;background: #607d8b;color: #fff;}*/
        
        /* Place the container to the left */
        /*.tleft {*/
        /*  left: 0;*/
        /*}*/
        
        /* Place the container to the right */
        /*.tright {*/
        /*  left: 50%;*/
        /*}*/
        
        /* Add arrows to the left container (pointing right) */
        /*.tleft::before {*/
        /*  content: " ";*/
        /*  height: 0;*/
        /*  position: absolute;*/
        /*  top: 22px;*/
        /*  width: 0;*/
        /*  z-index: 1;*/
        /*  right: 30px;*/
        /*  border: medium solid #c7aeae;*/
        /*  border-width: 10px 0 10px 10px;*/
        /*  border-color: transparent transparent transparent #c7aeae;*/
        /*}*/
        
        /* Add arrows to the right container (pointing left) */
        /*.tright::before {*/
        /*  content: " ";*/
        /*  height: 0;*/
        /*  position: absolute;*/
        /*  top: 22px;*/
        /*  width: 0;*/
        /*  z-index: 1;*/
        /*  left: 30px;*/
        /*  border: medium solid #c7aeae;*/
        /*  border-width: 10px 10px 10px 0;*/
        /*  border-color: transparent #c7aeae transparent transparent;*/
        /*}*/
        
        /* Fix the circle for containers on the right side */
        /*.tright::after {*/
        /*  left: -16px;*/
        /*}*/
        
        /* The actual content */
        /*.tcontent {*/
        /*  padding: 20px 30px;*/
        /*  background-color: #c7aeae;*/
        /*  position: relative;*/
        /*  border-radius: 6px;*/
        /*}*/
        
        /*.tcontent-active{*/
        /*    outline: 3px dotted red;*/
        /*    outline-offset: -6px;*/
        /*    border-radius: 10px;*/
        /*}*/
        
        /* Media queries - Responsive timeline on screens less than 600px wide */
        /*@media screen and (max-width: 600px) {*/
          /* Place the timelime to the left */
        /*  .timeline::after {*/
        /*    left: 31px;*/
        /*  }*/
          
          /* Full-width containers */
        /*  .tcontainer {*/
        /*      width: 100%;*/
        /*      padding-left: 70px;*/
        /*      padding-right: 25px;*/
        /*  }*/
          
          /* Make sure that all arrows are pointing leftwards */
        /*  .tcontainer::before {*/
        /*      left: 60px;*/
        /*      border: medium solid white;*/
        /*      border-width: 10px 10px 10px 0;*/
        /*      border-color: transparent white transparent transparent;*/
        /*  }*/
        
          /* Make sure all circles are at the same spot */
        /*  .tleft::after, .right::after {*/
        /*    left: 15px;*/
        /*  }*/
          
          /* Make all right containers behave like the left ones */
        /*  .tright {*/
        /*    left: 0%;*/
        /*  }*/
        /*}*/

        /*.flexigrid div.form-div input[type="text"], .flexigrid div.form-div input[type="password"]{*/
        /*    height: 37px !important;*/
        /*}*/

        /*.vewofr, .editex {*/
        /*    text-decoration: none !important;*/
        /*    font-size: 15px !important;*/
            /*color: #24af10 !important;*/
        /*}*/
        .form-display-as-box{
            text-transform: capitalize;
        }
        .dropdown .btn .caret{margin:0;}
        .border-bottom-1{border-bottom: 1px solid;}
        td.yes{background: #c2eec2!important}
        td.no{background: #ffa8a8!important}
        .flexigrid div.tDiv3{float:none}
        
        .flexigrid tr.erow td{background: none}
        
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
        <?php $this->load->view('components/top_menu'); ?>
        <!-- header section end-->
        <button class="btn btn-primary show_row_color text-center">Show Row Colour</button>
        <button class="btn btn-primary show_cell_color text-center">Show Cell Colour</button>
        <!--body wrapper start-->
        <div class="wrapper">
                
             <div class="row screenwidth" style="background: grey;padding:0.1%">
                <div class="col-lg-2 col-md-4 text-center">
                    <a class="btn btn-info" href="<?=base_url('admin/export-list-segment/cf')?>">Common Freeze</a>
                </div>
                <div class="col-lg-2 col-md-4 text-center">
                    <a class="btn btn-info" href="<?=base_url('admin/export-list-segment/con')?>">Contractual</a>
                </div>
                <div class="col-lg-2 col-md-4 text-center">
                    
                    <div class="dropdown">
                        <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">
                            Shipment/Docs <span class="caret"></span>
                        </button>
                      <ul class="dropdown-menu">
                        <li>
                            <a class="btn btn-default border-bottom-1" href="<?=base_url('admin/export-list-segment/sd')?>">All Shipment/Docs</a>
                        </li>
                        <li>
                            <a class="btn btn-default border-bottom-1" href="<?=base_url('admin/export-list-segment/sub-psd')?>">Pre-Ship Doc</a>
                        </li>
                        <li>
                            <a class="btn btn-default border-bottom-1" href="<?=base_url('admin/export-list-segment/sub-psp')?>">Post Ship Pry Doc</a>
                        </li>
                        <li>
                            <a class="btn btn-default border-bottom-1" href="<?=base_url('admin/export-list-segment/sub-psad')?>">Post Ship Add. Doc</a>
                        </li>
                        <li>
                            <a class="btn btn-default border-bottom-1" href="<?=base_url('admin/export-list-segment/sub-aod')?>">Any Other Docs</a>
                        </li>
                        <li>
                            <a class="btn btn-default border-bottom-1" href="<?=base_url('admin/export-list-segment/sub-sts')?>">Shipment Tracking section</a>
                        </li>
                      </ul>
                    </div> 
                    
                </div>
                <div class="col-lg-2 col-md-4 text-center">
                    <a class="btn btn-info" href="<?=base_url('admin/export-list-segment/df')?>">Docs File</a>
                </div>
                <div class="col-lg-2 col-md-4 text-center">
                    <a class="btn btn-info" href="<?=base_url('admin/export-list-segment/pay')?>">Payments</a>
                </div>
                <div class="col-lg-2 col-md-4 text-center">
                    <a class="btn btn-info" href="<?=base_url('admin/export-list-segment/info')?>">Information</a>
                </div>
             </div>
             
             
             
             <br />
             
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if($this->session->usertype != 3){
                    ?>
                        <a href="<?= base_url('admin/export-add') ?>" class="btn btn-success  mx-auto"><i class="fa fa-plus"></i> Add</a>
                        <br><br>
                    <?php
                    }
                    ?>
                            <?php echo $output; ?>
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

<!-- Request modal -->


<!-- Comments modal -->


<!-- View (Settings) modal -->


<!-- Status modal -->


<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>

<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>

<!--Data Table-->
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/JSZip-2.5.0/jszip.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.bootstrap.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.colVis.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/js/buttons.print.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/js/responsive.bootstrap.min.js"></script>
<!--data table init-->
<script src="<?=base_url()?>assets/admin_panel/js/data-table-init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<!--form validation-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.validate.min.js"></script>
<!--ajax form submit-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.form.min.js"></script>
<!--Select2-->
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
    
<?php endforeach; ?>




<?php if($this->session->flashdata('type')){ ?>

<script type="text/javascript">
    toastr[<?=$this->session->flashdata('type')?>](<?=$this->session->flashdata('msg')?>, obj.title, {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "5000",
            "timeOut": "5000",
            "extendedTimeOut": "7000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        })
</script>

<?php } ?>

<script type="text/javascript">
    //toastr notification
    function notification(obj) {
        toastr[obj.type](obj.msg, obj.title, {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "5000",
            "timeOut": "5000",
            "extendedTimeOut": "7000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        })
    }

    $(window).on('load', function() {
        $(".vewofr").attr("target","_blank");
        $tw = $('table').width()+250
        $('html,body').css('width', $tw)
        $('.screenwidth').width($(window).width() - 250)
    });
    
    $(".show_row_color").click(function(){
        $('table > tbody  > tr').each(function(index, tr) { 
            
            $colr = ($(this).find('td:last-child > div').text())
            $(this).css('background', $colr)
            
        })
    })
    
    
    $(".show_cell_color").click(function(){
        
        $word_colour = <?= json_encode($word_colour) ?>;
        // console.log($word_colour)
        
        $('table > tbody  > tr').each(function(index, tr) { 
            
            $(this).find('td').each(function(){
                
                $cr = $(this).find('div')
                $table_text = $.trim($(this).find('div').text())
                $.each($word_colour, function(key,value) {
                    
                    if($table_text == value.word){
                        $cr.css('background', value.color_hex_code)
                        // console.log(value.word)
                    }
                    
                })
                
            })
        })
    })
    
</script>

</body>
</html>