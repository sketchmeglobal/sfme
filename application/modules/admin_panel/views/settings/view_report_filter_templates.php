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
                        <div class="col-lg-2">
                            <label>Template name</label><br>
                            <input required="" type="text" id="template_name" name="template_name" placeholder="Enter Template Name" class="form-control">
                        </div>
                        <div class="col-lg-2">
                            <label>Offer header</label><br>
                            <select id="offerHeader" required="" multiple="" name="offer_header[]" class="form-control select2">
                                <option value="offer_name">Offer name</option>
                                <option value="offer_number">Offer number</option>
                                <option value="offer_date">offer date</option>
                                <option value="supplier_name">Supplier name</option>
                                <option value="destination_country">Destination country</option>
                                <option value="source_country">Source country</option>
                                <option value="currency">Currency</option>
                                <option value="buying_incoterm">Buying incoterm </option>
                                <option value="no_of_container">No of container</option>
                                <option value="size_of_container">Size of container</option>
                                <option value="quantity_each_container">Quantity each container</option>
                                <option value="shipping_line">Shipping line</option>
                                <option value="supplier_payment_terms">Suppllier payment terms</option>
                                <option value="document_clause">Document clause</option>
                                <option value="inspection_clause">Inspection clause</option>
                                <option value="lab_report_clause">Lab report clause</option>
                                <option value="shipment_timing">Shipping timing</option>
                                <option value="etd">Etd</option>
                                <option value="port_of_loading">Port of loading</option>
                                <option value="production_date">Production date</option>
                                <option value="shelf_life">Self life</option>
                                <option value="tolerance">Tolerance</option>
                                <option value="label_attached">Label attached</option>
                                <option value="carton_with_date">Cartons with date</option>
                                <option value="remarks_1">Remark 1</option>
                                <option value="remarks_2">Remark 2</option>
                                <option value="remarks_3">Remark 3</option>
                            </select>
                        </div>


                        <div class="col-lg-2">
                            <label>Offer details</label><br>
                            <select id="offerDetail" required="" multiple="" name="offer_details[]" class="form-control select2">
                                <option value="product_name">Product name</option>
                                <option value="freezing_type">Freezing type</option>
                                <option value="freezing_method_type">Freezing method type</option>
                                <option value="primary_packing_type">Primary packing type</option>
                                <option value="secondary_packing_type">Secondary packing type</option>
                                <option value="packing_size">Packing size</option>
                                <option value="glazing_type">Glazing type</option>
                                <option value="block_type">Block type</option>
                                <option value="size_type">Size type</option>
                                <option value="product_description">Product description</option>
                                <option value="pieces">Pieces</option>
                                <option value="grade">Grade</option>
                                <option value="size_before_glaze">Size before glaze</option>
                                <option value="size_after_glaze">Size after glaze</option>
                                <option value="quantity_offered">Quantity offered</option>
                                <option value="unit">Quantity unit</option>
                                <option value="cartons_offered">Cartons offered</option>
                                <option value="product_price">Product price</option>
                                <option value="comment">Comment</option>
                            </select>
                        </div>   

                        <div class="col-lg-2">
                            <label>Export header</label><br>
                            <select id="exportHeader" required="" multiple="" data-placeholder="-- Select Report Header --" name="export_header[]" class="form-control select2">
                                <option value="name">Vendor Name</option>

                                 <option value="shipping_line">Shipping Line</option>

                                 <option value="product_origin">Product Origin</option>

                                 <option value="product_name">Product Name</option>

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
                        <div class="col-lg-2">
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
                                    <th>Offer header</th>
                                    <th>Offer Details</th>

                                    <th>Export header</th>
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
                                        <td>
                                            <?php 
                                            if ($et->offer_header == 'offer_id') {
                                              
                                                echo  "Offer Name";
                                            }else{
                                               echo str_replace(',',', &nbsp; &nbsp;',$et->offer_header);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            if ($et->offer_details == 'od_id') {
                                              
                                                echo  "Offer Details Name";
                                            }else{
                                               echo str_replace(',',', &nbsp; &nbsp;',$et->offer_details);
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php 
                                            //$val = '';
                                            if ($et->export_header == 'export_id') {
                                              
                                                echo  "Offer Name";
                                            }else{
                                               echo str_replace(',',', &nbsp; &nbsp;',$et->export_header);
                                            }
                                            ?>
                                        </td>
                                        
                                        <td>
                                            <?php //if ($et->vt_category != "DT") {
                                            ?>
                                            <button data-vt_id="<?=$et->report_filter_template_id?>"  type="button" class="btn btn-danger delete">Delete</button>
                                            <button data-vt_id="<?=$et->report_filter_template_id?>"  type="button" class="btn btn-warning copy">Copy</button>
                                        <?php //} ?>
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
                url: "<?= base_url('admin/ajax_delete_view_templates_report_filter') ?>/"+$vt_id,
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
    
     $(document).on('click', '.copy', function(){

        var exportHeader= $.trim($(this).closest('td').prev('td').text())
        var allFields = (exportHeader.replace(/\s/g, '')).split(',')
        $('#exportHeader').val(allFields).trigger('change');
        
        var offerDetail= $.trim($(this).closest('td').prev('td').prev('td').text())
        var allFields = (offerDetail.replace(/\s/g, '')).split(',')
        $('#offerDetail').val(allFields).trigger('change');

        var offerHeader= $.trim($(this).closest('td').prev('td').prev('td').prev('td').text())
        var allFields = (offerHeader.replace(/\s/g, '')).split(',')
        $('#offerHeader').val(allFields).trigger('change');

    })
    
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
</script>
</body>
</html>