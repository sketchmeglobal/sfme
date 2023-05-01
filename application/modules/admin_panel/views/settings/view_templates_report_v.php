<?php 
//echo "<pre>"; print_r($users);die; 
// $users = $users[0];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?> | <?=WEBSITE_NAME;?></title>
    <meta name="keyword" content="user dashboard">
    <meta name="description" content="account statistic">

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
    <style type="text/css">
        .panel{min-height: auto!important;}
    </style>
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

         <!--body wrapper start-->
        <div class="wrapper">
            <div class="col-md-12">
                <form method="POST" class="panel">
                    <div class="panel-header bg-success text-white text-center p-1">
                        <h4>Create Templates</h4>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-3">
                            <label>Template name</label><br>
                            <input required="" type="text" id="template_name" name="template_name" placeholder="Enter Template Name" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Export header</label><br>
                            <select id="exportHeader" required="" multiple="" data-placeholder="-- Select Report Header --" name="export_header[]" class="form-control select2">
                                <option value="name">Vendor Name</option>
                                 <option value="shipping_line">Shipping Line</option>
                                 <option value="product_origin">Product Origin</option>
                                 <!--<option value="product_name">Product Name</option>-->
                                <?php foreach ($report_header as $key => $value) { ?>
                                    <?php if ($key != 0 && $value != 'actual_sales_amt_currency' && $value != 'insurance_currency' && $value != 'frieght_currency' && $value != 'pi_sales_amt_currency' && $value != 'po_purch_amt_currency' && $value != 'vend_inv_amt_currency' && $value != 'adv_amt_vend_currency' && $value != 'adv_paid_vend_currency' && $value != 'adv_amt_cust_currency' && $value != 'adv_recd_from_cust_currency') { ?>
                                            <?php if ($value == "offer_id") { ?>
                                                <option value="<?php echo $value ?>"><?php echo "Offer Name"  ?></option>
                                            <?php }else{ ?>
                                                <option value="<?php echo $value ?>"><?php echo ucwords(str_replace('_',' ',$value))  ?></option>
                                            <?php } ?>
                                <?php }} ?>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label>Exporter</label><br>
                            <select multiple id="exporter" required=""  data-placeholder="-- Select Exporter --" name="export_user[]" class="form-control select2">
                                <?php foreach ($users as $key => $user) { ?>
                                    <option value="<?=$user->user_id ?>"><?=$user->firstname ?> <?=$user->lastname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                      
                        <div class="col-lg-1">
                            <label>Action</label><br>
                            <button class="btn btn-success" type="submit">Submit</button>
                        </div>
                    </div>
                </form>    
            </div> 

            <div class="col-sm-12">
                <?php  

                //if($insert != ''){
                    ?>
                    <div class="badge badge-right"><?=$this->session->flashdata('success')?></div>
                    <?php
                //}

                ?>
            </div>

            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-header bg-success text-white text-center p-1">
                        <h4>Existing Templates</h4>
                    </div>
                    <div class="panel-body">
                        <table id="existing_templates_table" class="table table-responsive table-bordered" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Template name</th>
                                    <th>Export header fields</th>
                                    <th>User</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $iter = 0; 
                                foreach ($existing_templates as $et) {

                                    ?>
                                    <tr>
                                        <td><?= ++$iter ?></td>
                                        <td><?=$et->template_name?></td>
                                        <td><?php 
                                        //$val = '';
                                        if ($et->export_header_fields == 'offer_id') {
                                            echo  "Offer Name";
                                        }else{
                                           echo str_replace(',',', &nbsp; &nbsp;',$et->export_header_fields);
                                        }
                                        ?>
                                            
                                        </td>
                                        <td>
                                           <span class="hidden"><?=$et->user_id?></span> 
                                           <?=$et->name?>
                                        </td>
                                        <td>
                                            <?php if ($et->vt_category != "DT") {
                                            ?>
                                            <button data-vt_id="<?=$et->vt_id?>" type="button" class="btn btn-danger delete">Delete</button>
                                            <button data-vt_id="<?=$et->vt_id?>" type="button" class="btn btn-warning copy">Copy</button>
                                        <?php } ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                 ?>
                            </tbody>
                        </table>
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
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<script type="text/javascript">
     $('.select2').select2({
        // placeholder: "-- Select Report Header --",
    })
</script>


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

<script src="<?=base_url()?>assets/admin_panel/js/data-table-init.js"></script>
<!--Select2-->
<script>
   
    $("#existing_templates_table").DataTable({
        //"scrollX": true
    })

     /* DELETE AREA */
    $(document).on('click', '.delete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undo.")){

            $vt_id = $(this).data('vt_id');           

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-view-templates-report') ?>/"+$vt_id,
                dataType: 'json',
                type: 'POST',
                success: function (returnData) {
                    console.log(returnData);
                    $this.closest('tr').remove();
                    // obj = JSON.parse(returnData);

                    notification(returnData);

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    console.log(returnData);
                    notification(returnData);
                }
            });
        }   
    });
</script>   

<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>

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
    
     $(document).on('click', '.copy', function(){

        var exportHeader= $.trim($(this).closest('td').prev('td').prev('td').text())
        var allFields = (exportHeader.replace(/\s/g, '')).split(',')
        $('#exportHeader').val(allFields).trigger('change');
        
        var exporter= $.trim($(this).closest('td').prev('td').find('span.hidden').text())
        var allFields = (exporter.replace(/\s/g, '')).split(',')
        console.log(allFields)
        $('#exporter').val(allFields).trigger('change');
        
        // var filterVal = ($("#exporter option:contains('"+exportHeader+"')").val())
        // $('#exporter').select2("val", filterVal);

    })
</script>
</body>
</html>