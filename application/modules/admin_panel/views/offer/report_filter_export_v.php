<?php  ?>

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
        .font-weight-bold{font-weight: bold}
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
                                <h4 style="padding: 47px;">Report Export Filter</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 " style="padding: 37px;">
                            <div class="row ">
                                <form method="post" action="<?php echo base_url('admin/report_filter_export_form'); ?>" target="_blank">
                                    <div class="col-lg-12">
                                        <div class="form-group col-lg-3">
                                            <label for="" class="font-weight-bold">Customer</label>
                                            <select name="customer_id" id="customer_id" class="form-control select2">
                                                <option value="">-- Select Customer --</option>
                                                <?php foreach ($customer as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->am_id?>"><?php echo $value->name; ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-3">
                                            <label class="font-weight-bold">Vendor</label>
                                            <select name="vendor_id" id="vendor_id" class="form-control select2">
                                                <option value="">-- Select Vendor --</option>
                                                <?php foreach ($vendor as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->am_id ?>"><?php echo $value->name; ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-6 form-group">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label for="offer_id" class="font-weight-bold">Offer</label>
                                                    <select name="offer_id" id="offer_id" class="form-control select2">
                                                        <option value="">-- Select Offer --</option>
                                                        <?php foreach ($offer as $key => $value) {
                                                        ?>
                                                        <option value="<?php echo $value->offer_id ?>"><?php echo $value->offer_name; ?></option>
                                                        <?php }  ?>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="offer_id" class="font-weight-bold">Offer Product</label>
                                                    <select name="product_id" id="product_id" class="form-control select2">
                                                        <option value="">-- Select Product --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="origin_id" class="font-weight-bold">Origin</label>
                                            <select name="origin_id" id="origin_id" class="form-control select2">
                                                <option value="">-- Select Origin --</option>
                                                <?php foreach ($destination as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->country_id ?>"><?php echo $value->name; ?></option>
                                                <?php }  ?>
                                            </select>
                                            
                                        </div>
                                        <div class="col-lg-3 form-group">
                                            <label for="destination_id" class="font-weight-bold">Destination</label>
                                            <select name="destination_id" id="destination_id" class="form-control select2">
                                                <option value="">-- Select Destination --</option>
                                                <?php foreach ($destination as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->country_id ?>"><?php echo $value->name; ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 form-group">
                                            <label class="font-weight-bold" for="company_id">Company</label>
                                            <select name="company_id" id="company_id" class="form-control select2">
                                                <option value="">-- Select Company --</option>
                                                <?php foreach ($company as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->company_id ?>"><?php echo $value->company_name; ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-3 form-group">
                                            <label class="font-weight-bold">Template</label>
                                            <select name="tepmlate_id" id="tepmlate_id" class="form-control select2" required>
                                                <option value="">-- Select Template --</option>
                                                <?php foreach ($template as $key => $value) {
                                                ?>
                                                <option value="<?php echo $value->report_filter_template_id ?>"><?php echo $value->template_name; ?></option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-12 text-center">
                                        <input type="submit" value="Submit" name="submit_btn" class="btn btn-primary" />
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
        
        $("#offer_id").on('change', function(){
        $offer_id = $(this).val();
        $.ajax({
        url: "<?=base_url()?>admin/ajax_get_product_data",
        dataType:"json",
        type: "post",
        data:{"offer_id":$offer_id},
        success: function(data){
        $("#product_id").html(data);
        }
        });
        });
        
        
        </script>
    </body>
</html>