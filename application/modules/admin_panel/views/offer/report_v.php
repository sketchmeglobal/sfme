<?php  ?>

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

    <style type="text/css">
        .ic label{text-decoration: underline;cursor: pointer;}
        .modal-dialog{width:90%}
    </style>
    
    <style>
        
        
        /* The actual timeline (the vertical ruler) */
        .timeline {
          position: relative;
          max-width: 1200px;
          margin: 0 auto;
        }
        
        /* The actual timeline (the vertical ruler) */
        .timeline::after {
          content: '';
          position: absolute;
          width: 6px;
          background-color: #000;
          top: 0;
          bottom: 0;
          left: 49.5%;
          outline: 3px solid #dce1fb;
          outline-offset: 1px;
          /*margin-left: -3px;*/
        }
        
        /* Container around content */
        .tcontainer {
          padding: 10px 40px;
          position: relative;
          background-color: inherit;
          width: 49.50%;
        }
        
        /* The circles on the timeline */
        .tcontainer::after { 
          content: '';
          position: absolute;
          width: 25px;
          height: 25px;
          right: -17px;
          background-color: white;
          border: 4px solid #FF9F55;
          top: 15px;
          border-radius: 50%;
          z-index: 1;
        }
        .tbreak{ width: 100%;z-index: 1;text-align: center;position: relative; }
        .tbreak .tcontent{padding:0;background: #607d8b;color: #fff;}
        
        /* Place the container to the left */
        .tleft {
          left: 0;
        }
        
        /* Place the container to the right */
        .tright {
          left: 50%;
        }
        
        /* Add arrows to the left container (pointing right) */
        .tleft::before {
          content: " ";
          height: 0;
          position: absolute;
          top: 22px;
          width: 0;
          z-index: 1;
          right: 30px;
          border: medium solid #c7aeae;
          border-width: 10px 0 10px 10px;
          border-color: transparent transparent transparent #c7aeae;
        }
        
        /* Add arrows to the right container (pointing left) */
        .tright::before {
          content: " ";
          height: 0;
          position: absolute;
          top: 22px;
          width: 0;
          z-index: 1;
          left: 30px;
          border: medium solid #c7aeae;
          border-width: 10px 10px 10px 0;
          border-color: transparent #c7aeae transparent transparent;
        }
        
        /* Fix the circle for containers on the right side */
        .tright::after {
          left: -16px;
        }
        
        /* The actual content */
        .tcontent {
          padding: 20px 30px;
          background-color: #c7aeae;
          position: relative;
          border-radius: 6px;
        }
        
        .tcontent-active{
            outline: 3px dotted red;
            outline-offset: -6px;
            border-radius: 10px;
        }
        
        /* Media queries - Responsive timeline on screens less than 600px wide */
        @media screen and (max-width: 600px) {
          /* Place the timelime to the left */
          .timeline::after {
            left: 31px;
          }
          
          /* Full-width containers */
          .tcontainer {
              width: 100%;
              padding-left: 70px;
              padding-right: 25px;
          }
          
          /* Make sure that all arrows are pointing leftwards */
          .tcontainer::before {
              left: 60px;
              border: medium solid white;
              border-width: 10px 10px 10px 0;
              border-color: transparent white transparent transparent;
          }
        
          /* Make sure all circles are at the same spot */
          .tleft::after, .right::after {
            left: 15px;
          }
          
          /* Make all right containers behave like the left ones */
          .tright {
            left: 0%;
          }
        }

        .flexigrid div.form-div input[type="text"], .flexigrid div.form-div input[type="password"]{
            height: 37px !important;
        }

        .vewofr{
            text-decoration: none !important;
            font-size: 15px !important;
        }
        .form-display-as-box{
            text-transform: capitalize;
        }
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

        <!--body wrapper start-->
        <div class="wrapper">

          <div class="row ">
                <div class="col-lg-12 ">
                  <div class=" bg-success text-white text-center ">
                        <h4 style="padding: 47px;">Generate Offer Report</h4>
                    </div>
                </div>
          </div>        
          <div class="row mt-3">
              <div class="col-lg-12 " style="padding: 37px;">
              	<div class="row ">
                  <form method="post" action="<?php echo base_url('admin/generate-offer-report'); ?>" target="_blank">
                    <div class="col-lg-2">
                       <label for="report_temp" class="col-form-label">Choose Template:</label>
                       <select name="report_temp" required="" id="report_temp" class="form-control">
                        <option value="">-- Select Template --</option>
                        <?php 
                        foreach ($template_data as $key => $value) { 
                            if($this->session->usertype == 2){
                                if (strpos($value->user_id, $this->session->user_id) > -1) {
                                    ?>
                                    <option value="<?php echo $value->vt_id ?>"><?php echo $value->template_name; ?></option>
                                    <?php
                                }else{
                                    continue;
                                }
                            }else{
                                ?>
                                <option value="<?php echo $value->vt_id ?>"><?php echo $value->template_name; ?></option>
                                <?php
                            }
                         }  ?>
                       </select>
                    </div>
                      <div class="col-lg-3">
                         <label for="offer" class="col-form-label">Choose Offer:</label>
                         <select name="offer" required="" id="offer" class="form-control select2">
                          <option value="">-- Select Offer --</option>
                          <?php foreach ($offer_data as $key => $offers) { ?>
                           <option value="<?php echo $offers->offer_id ?>"><?php echo $offers->offer_name; ?></option>
                          <?php }  ?>
                         </select>
                      </div>
                    <?php if($this->session->usertype == 1){ ?>
                    <div class="col-lg-2">
                      <label for="trader" class="col-form-label">Trader:</label>
                       <select name="trader" id="trader" class="form-control">
                        <option value="">-- Select Trader Product --</option>
                        <option value="Yes">Show Product</option>
                        <option value="No">Don't Show Product</option>
                        
                       </select>
                    </div>
                    <?php } ?>
                    <div class="col-lg-2">
                      <label for="resuorce_developer" class="col-form-label">Resource Developer:</label>
                       <select name="resuorce_developer" id="resuorce_developer" class="form-control">
                        <option value="">-- Select Resource Developer Product --</option>
                        <option value="Yes">Show Product</option>
                        <option value="No">Don't Show Product</option>
                        
                       </select>
                    </div>

                    <div class="col-lg-1 text-center">
                      <br>
                      <button type="submit" class="btn btn-success shadow-success px-5 "> Generate</button>
                    </div>
                  </form>
                  

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

<script>
    $('.select2').select2();
</script>


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

</script>

</body>
</html>