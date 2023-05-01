
<?php
// print_r($buyer_details);die;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?> | <?=WEBSITE_NAME;?></title>
    <meta name="description" content="<?=$title?>">

    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">

    <!--iCheck-->
    <link href="<?=base_url();?>assets/admin_panel/js/icheck/skins/all.css" rel="stylesheet">

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->
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

            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <div class="panel-body">
                            <form autocomplete="off" id="form_add_offer" method="post" action="<?=base_url('admin/form-add-offer')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form" autocomplete="on">
                                <div class="form-group row">
                                         <label for="company_id" class="control-label col-lg-2 col-lg-offset-3" style="font-weight: bold;">Company</label>
                                         <div class="col-lg-4 ">
                                         <select name="company_id" id="company_id" class="form-control select2">
                                            <option value="" >-- Select Company --</option>
                                            <?php foreach ($company as $company_row) { ?>
                                                <option value="<?=$company_row->company_id?>"><?=$company_row->company_name?></option>
                                            <?php } ?>
                                         </select>
                                     </div>
                                </div>
                                
                                <div class="form-group ">
                                    <div class="col-lg-2">
                                        <label for="offer_number" class="control-label text-danger">Offer Number *</label>
                                        <input value="<?=$offer_name?>" id="offer_number" name="offer_number" type="text" placeholder="Offer Number" class="form-control round-input" />
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="offer_name" class="control-label text-danger">Offer Name *</label>
                                        <input value="" id="offer_name" name="offer_name" type="text" placeholder="Offer Name" class="form-control round-input" />
                                    </div>                                    
                                    <div class="col-lg-2">
                                        <label for="offer_fz_number" class="control-label">FZ Number</label>
                                        <input value="" id="offer_fz_number" name="offer_fz_number" type="text" placeholder="Offer FZ Number" class="form-control round-input" />
                                    </div> 
                                    
                                    <div class="col-lg-2">
                                        <label for="resources" class="control-label text-danger">Resource Developer *</label>
                                        <select name="resources" id="resources" class="form-control select2">
                                            <option value="">Select Resource Developer</option>
                                                <?php
                                                foreach($resources as $bd){
                                                ?> 
                                                <option value="<?= $bd->user_id ?>"><?= $bd->username . ' ['. $bd->firstname . ' ' .$bd->lastname .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                
                                    <div class="col-lg-2">
                                        <label for="acc_master_id" class="control-label text-danger">Supplier *</label>
                                        <?php $permitted_suppliers = explode(',',$permitted_suppliers->acc_masters) ?>
                                        <select multiple name="acc_master_id[]" id="acc_master_id" class="form-control select2">
                                            <option value="">Select Supplier</option>
                                                <?php
                                                foreach($suppliers as $bd){
                                                    if(!in_array($bd->am_id, $permitted_suppliers)){
                                                        continue;
                                                    }
                                                    $sn = ($bd->am_code == '' ? '-' : $bd->am_code);
                                                ?> 
                                                    <option value="<?= $bd->am_id ?>"><?= $bd->name . ' ['. $sn .']' ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <label for="currencies" class="control-label text-danger">Currencies *</label>
                                        <select name="currencies" id="currencies" class="form-control select2">
                                            <option value="">Select Currencies</option>
                                                <?php
                                                foreach($currencies as $bd){
                                                    $sn = ($bd->code == '' ? '-' : $bd->code);
                                                ?> 
                                                    <option value="<?= $bd->c_id ?>"><?= $bd->currency . ' ['. $sn .'] - ('. $bd->symbol .')' ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group ">

                                    <div class="col-lg-2">
                                        <label for="incoterms" class="control-label text-danger">Incoterms *</label>
                                        <select name="incoterms" id="incoterms" class="form-control select2">
                                            <option value="">Select Incoterms</option>
                                                <?php
                                                foreach($incoterms as $bd){
                                                    $sn = ($bd->information == '' ? '-' : $bd->information);
                                                ?> 
                                                <option value="<?= $bd->it_id ?>"><?= $bd->incoterm . ' ['. $sn .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="destination_c_id" class="control-label">Destination Country</label>
                                        <select multiple="" name="destination_c_id[]" id="destination_c_id" class="form-control select2">
                                            <option value="">Select Destination Country</option>
                                                <?php
                                                foreach($countries as $bd){
                                                ?> 
                                                <option value="<?= $bd->country_id ?>"><?= $bd->name . ' ['. $bd->iso .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="country_id" class="control-label text-danger">Source Country *</label>
                                        <select name="country_id" id="country_id" class="form-control select2">
                                            <option value="">Select Source Country</option>
                                                <?php
                                                foreach($countries as $bd){
                                                ?> 
                                                <option value="<?= $bd->country_id ?>"><?= $bd->name . ' ['. $bd->iso .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="offer_date" class="control-label text-danger">Offer Date *</label>
                                        <input id="offer_date" name="offer_date" type="date" placeholder="Offer Date" value="<?=date('Y-m-d')?>" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="no_of_container" class="control-label">No of Container</label>
                                        <input id="no_of_container" name="no_of_container" type="number" placeholder="No of Container" class="form-control round-input" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="size_of_container" class="control-label">Size of Container</label>

                                        <select name="size_of_container" id="size_of_container" class="form-control round-input select2">
                                            <option value="">Select Size Of Container</option>

                                            <?php

                                            $size_of_containers = array("20 FT Reefer FCL", "40 FT Reefer FCL", "20 FT Dry FCL", "40 FT Dry FCL", "20 FT Reefer LCL", "40 FT Reefer LCL", "20 FT Dry LCL", "40 FT Dry LCL");
                                            foreach ($size_of_containers as $key => $size_of_container) {
                                        
                                            ?>

                                            <option value="<?=$size_of_container?>"><?=$size_of_container?></option>

                                        <?php } ?>
                                            
                                            
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="quantity_each_container" class="control-label">Qnty of Each Container</label>
                                       
                                         <select name="quantity_each_container" id="quantity_each_container" class="form-control round-input select2">
                                            <option value=""> Select quantity of each container</option>

                                            <?php

                                            $quantity_each_containers = array("24.0 Tons", "25.0 Tons", "26.0 Tons", "26.5 Tons", "27.0 Tons", "27.5 Tons", "28.0 Tons");
                                            foreach ($quantity_each_containers as $key => $quantity_each_container) {
                                            ?>

                                            <option value="<?=$quantity_each_container?>"><?=$quantity_each_container?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="shipping_line" class="control-label">Shipping Line</label>
                                        <select name="shipping_line" id="shipping_line" class="form-control round-input select2">
                                            <option value="">Select shipping line</option>

                                            <?php

                                            $shipping_lines = array("CMA-CGM", "MAERSK LINE", "MSC LINE", "COSCO", "HAPAG-LLOYD", "SAFMARINE", "ANY INTERNATIONAL SHIPPING LINE");
                                            foreach ($shipping_lines as $key => $shipping_line) {
                                            ?>

                                            <option value="<?=$shipping_line?>"><?=$shipping_line?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>

                                        
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="shipment_timing" class="control-label">Shipment Timing</label>
                                        <input id="shipment_timing" name="shipment_timing" type="text" placeholder="Shipment Timing" class="form-control round-input" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="supplier_payment_terms" class="control-label">Supplier Payment Terms</label>
                                        
                                        <select name="supplier_payment_terms" id="supplier_payment_terms" class="form-control round-input select2">
                                            <option value=""> Select supplier payment terms</option>

                                            <?php

                                            $supplier_payment_terms = array("05% upon Inspection; 05% upon Loading; 90% upon Scan Copy of Final Docs", "10% Advance; 90% upon Scan Copy of Final Docs", "20% Advance; 80% upon Scan Copy of Final Docs", "25% Advance; 75% upon Scan Copy of Final Docs", "30% Advance; 70% upon Scan Copy of Final Docs", "70% upon loading; 30% after 7 days from Loading", "TT Against Scan Final Docs", "Cash against Documents", "Cash against Documents via Bank", "30 Days from BL Date", "45 Days from BL Date", "60 Days from BL Date", "100% Advance Payment");
                                            foreach ($supplier_payment_terms as $key => $supplier_payment_term) {
                                            ?>

                                            <option value="<?=$supplier_payment_term?>"><?=$supplier_payment_term?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>

                                        
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="etd" class="control-label">ETD</label>
                                        <input id="etd" value="" name="etd" type="text" placeholder="ETD" class="form-control round-input" />
                                    </div>


                                    <div class="col-lg-3">
                                        <label for="port_of_loading" class="control-label text-danger">Port of Loading*</label>
                                        <select name="port_of_loading" id="port_of_loading" class="form-control select2">
                                            <option value="">Select Port</option>
                                            <?php
                                            foreach($ports as $bd){
                                            ?> 
                                            <option value="<?= $bd->p_id ?>"><?= $bd->port_name ?>
                                            </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="document_clause" class="control-label">Document Clause</label>               

                                        <select name="document_clause" id="document_clause" class="form-control round-input select2">
                                            <option value="">Select document clause</option>

                                            <?php

                                            $document_clauses = array("INV, PL, HC, COO & BL", "INV, PL, HC, COO & BL + EXPORT DECLARATION");
                                            foreach ($document_clauses as $key => $document_clause) {
                                            ?>

                                            <option value="<?=$document_clause?>"><?=$document_clause?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="inspection_clause" class="control-label">Inspection Clause</label>
                                        <textarea rows="4" id="inspection_clause" name="inspection_clause" placeholder="Inspection Clause" class="form-control"></textarea>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="lab_report_clause" class="control-label">Lab Report Clause</label>
                                        <textarea rows="4" id="lab_report_clause" name="lab_report_clause" placeholder="Lab Report Clause" class="form-control"></textarea>
                                    </div>
                                      
                                    <div class="col-lg-3">
                                        <label for="production_date" class="control-label">Production Date</label>
                                        <input id="production_date" name="production_date" type="date" value="" placeholder="Production Date" class="form-control round-input" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="shelf_life" class="control-label">Shelf Life</label>                                  

                                        <select name="shelf_life" id="shelf_life" class="form-control round-input select2">
                                            <option value="">Select shelf life</option>

                                            <?php

                                            $shelf_lifes = array("12 Months", "18 Months", "24 Months", "36 Months");
                                            foreach ($shelf_lifes as $key => $shelf_life) {
                                            ?>

                                            <option value="<?=$shelf_life?>"><?=$shelf_life?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="tolerance" class="control-label">Tolerance</label>

                                        <select name="tolerance" id="tolerance" class="form-control round-input select2">
                                            <option value="">Select shelf life</option>
                                            <?php
                                            $tolerances = array("05%", "10%");
                                            foreach ($tolerances as $key => $tolerance) {
                                            ?>
                                            <option value="<?=$tolerance?>"><?=$tolerance?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="label_attached" class="control-label">Label Attached?</label>
                                        <select name="label_attached" id="label_attached" class="form-control select2">
                                            <option value="">Select Label</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="NA">N.A.</option>
                                            <option value="remarks">See Remarks</option>
                                        </select>
                                     </div>
                                     <div class="col-lg-3">
                                        <label for="carton_with_date" class="control-label">Carton Printed with Production Date?</label>
                                        <select name="carton_with_date" id="carton_with_date" class="form-control select2">
                                            <option value="">Select Options</option>
                                            <option value="Yes">Yes</option>
                                            <option value="No">No</option>
                                            <option value="NA">N.A.</option>
                                            <option value="remarks">See Remarks</option>          
                                        </select>
                                     </div>
                                     <div class="col-lg-3">
                                        <label for="remark1" class="control-label text-danger">Remark 1 - Offer Validity</label>
                                        <select required="" name="remark1" id="remark1" class="form-control select2">
                                            <option value="">Select Remark 1 - Validity</option>
                                            <?php
                                            foreach($remark1_offer_validity as $bd){
                                            ?> 
                                            <option value="<?= $bd->rov_id ?>"><?= $bd->remark ?>
                                            </option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                     
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label for="remark2" class="control-label">Remark 2</label>
                                        <textarea rows="4" id="remark2" name="remark2" placeholder="Remark 2" class="form-control"></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark3" class="control-label">Remark 3</label>
                                        <textarea  rows="4" id="remark3" name="remark3" placeholder="Remark 3" class="form-control"></textarea>
                                    </div> 

                                    <div class="col-lg-3">
                                        <label for="docs_provided" class="control-label">Docs provided</label>
                                        <input id="docs_provided" name="docs_provided" type="text" value="" placeholder="Docs provided" class="form-control round-input" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload Pictures</label>
                                        <input type="file" multiple="" name="userfile[]" id="userfile" accept=".jpg,.jpeg,.png,.txt,.doc,.docx,.xls,.xlsx,.pdf" class="file">
                                     </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <label for="inspection_reports" class="control-label">Upload Inspection Reports</label>
                                        <input type="file" id="inspection_reports" name="inspection_reports[]" multiple="" accept=".jpg,.jpeg,.png,.txt,.doc,.docx,.xls,.xlsx,.pdf" class="file" >
                                     </div>

                                     <div class="col-lg-3">
                                         <label for="offer_status_id" class="control-label">Offer Status</label>
                                         <select name="offer_status_id" id="offer_status_id" class="form-control round-input select2">
                                            <?php
                                            foreach ($offer_status as $key => $offer_status_row) {
                                            ?>
                                            <option value="<?=$offer_status_row->offer_status_id?>"><?=$offer_status_row->offer_status?></option>
                                            <?php } ?>
                                         </select>
                                     </div>
                                </div>
                                <!-- <div class="form-group">
                                    <div class="col-lg-6">
                                        <label for="img" class="control-label">Documents</label>
                                        <input type="file" id="img" name="img" accept=".jpg,.jpeg,.png,.doc,.docx,.xls,.pdf" class="file" >
                                    </div>
                                    <div class="col-lg-6">
                                        <label class="control-label text-danger">Status *</label><br />
                                        <input type="radio" name="status" id="enable" value="1" checked required class="iCheck-square-green">
                                        <label for="enable" class="control-label">Enable</label>

                                        <input type="radio" name="status" id="disable" value="0" required class="iCheck-square-red">
                                        <label for="disable" class="control-label">Disable</label>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <button class="btn btn-success pull-right" type="submit"><i class="fa fa-plus"> Add Offer</i></button>
                                    </div>
                                    <!-- <div class="col-lg-6">
                                        <a id="edit_btn" href="javascript:void(0)" class="hidden btn btn-info"><i class="fa fa-pencil"> Edit Offer</i></a>
                                    </div> -->
                                </div>
                            </form>
                        </div>
                    </section>
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
<!-- common js -->
<?php $this->load->view('components/_common_js'); //left side menu ?>
<!--Select2-->
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<script>
    $('.select2').select2();
</script>
<!--Icheck-->
<script src="<?=base_url();?>assets/admin_panel/js/icheck/skins/icheck.min.js"></script>
<script src="<?=base_url();?>assets/admin_panel/js/icheck-init.js"></script>
<!--form validation-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.validate.min.js"></script>
<!--ajax form submit-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.form.min.js"></script>

<script>
    //add-item-form validation and submit
    $("#form_add_offer").validate({
        
        rules: {
            offer_number: {
                required: true,
                remote: {
                    url: "<?=base_url('admin/ajax-unique-offer-number')?>",
                    type: "post",
                    data: {
                        offer_number: function() {
                          return $("#offer_number").val();
                        }
                    },
                },
            },
            
            acc_master_id: {
                required: true
            },
            offer_country:{
                required: true
            },
            currencies: {
                required: true
            },
            resources: {
                required: true
            },
            incoterms: {
                required: true
            },
            offer_date: {
                required: true
            },
            port_of_loading: {
                required: true
            },
            remark1:{
                required: true
            },
            userfile: {
                fileType: {
                    types: ["jpeg", "jpg", "png"]
                },
                maxFileSize: {
                    "unit": "MB",
                    "size": 1
                },
                minFileSize: {
                    "unit": "KB",
                    "size": "10"
                }
            }
        },
        messages: {

        }
    });


    $('#form_add_offer').ajaxForm({
        beforeSubmit: function () {
            return $("#form_add_offer").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            console.log(returnData);
            obj = JSON.parse(returnData);
            notification(obj);

                if(parseInt(obj.insert_id) > 0){
                    if(obj.type == 'error'){
                        setTimeout(function(){ 
                            window.location.href = '<?=base_url()?>admin/edit-offer/'+obj.insert_id; 
                            }, 3000);
                    }else{
                        window.location.href = '<?=base_url()?>admin/edit-offer/'+obj.insert_id;
                    }               
                }            

		}
    });


    
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
            "hideDuration": "1000",
            "timeOut": "15000",
            "extendedTimeOut": "10000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        })
    }
    
    // $("#acc_master_id").on('change', function(){
    //     $val = ($("#acc_master_id").select2().find(":selected").data("code"));
    //     console.log($val);
    //     if($val != 'CO'){
    //         string = $("#order_no").val();
    //         $ns = string.replace(/^.{2}/g, $val);
    //         $("#order_no").val($ns);
    //     }  
    // })
</script>

</body>
</html>