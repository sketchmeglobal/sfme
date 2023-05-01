<?php #echo '<pre>', print_r($offer_details), '</pre>'; die;

/*if(isset($offer_details[0])){
}*/
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

    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">

    <!--iCheck-->
    <link href="<?=base_url();?>assets/admin_panel/js/icheck/skins/all.css" rel="stylesheet">

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        text-align: right;
        }

        /* Firefox */
        /*input[type=number] {
            text-align: right;
            -moz-appearance: textfield;
        }  */      
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

            <div class="row text-enter">
                <?= ($offer_details[0]->cloned_offer_id != null) ? '<span class="badge badge-right">This is Cloned</span>' : '' ?>
            </div>
            <div class="row">
                <!-- <div class="col-sm-12">
                    < ?php if($this->session->usertype == 1){ ?>
                    <button class="btn btn-success btn-large pull-right mar_final_btn">
                    < ?php if($offer_details[0]->final_marketing_approval_status == 0){ ?>      
                        FINALISE
                    < ?php }else { ?>
                        REVOKE
                    < ?php } } ?>
                </button>
                </div> -->
            </div>
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit <?= $offer_details[0]->offer_name ?>
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">

                            <form autocomplete="off" id="form_edit_offer" method="post" action="<?=base_url('admin/form-edit-offer')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form" autocomplete="on">

                                <div class="form-group row">
                                         <label for="company_id" class="control-label col-lg-2 col-lg-offset-3" style="font-weight: bold;">Company</label>
                                         <div class="col-lg-4 ">
                                         <select name="company_id" id="company_id" class="form-control select2">
                                            <option value="" >-- Select Company --</option>
                                            <?php foreach ($company as $company_row) { ?>
                                                <option value="<?=$company_row->company_id?>" <?=($company_row->company_id == $offer_details[0]->company_id) ? 'selected' : ''?>><?=$company_row->company_name?></option>
                                            <?php } ?>
                                         </select>
                                     </div>
                                </div>
                                <div class="form-group ">
                                    <?php
                                    if($this->session->usertype != 1){
                                        $per = 'readonly';
                                    }else{
                                        $per = '';
                                    }  
                                    ?>
                                    <div class="col-lg-2">
                                        <label for="offer_number" class="control-label text-danger">Offer Number *</label>
                                        <input <?=$per?> value="<?=$offer_details[0]->offer_number?>" id="offer_number" name="offer_number" type="text" placeholder="Offer Number" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="offer_name" class="control-label text-danger">Offer Name *</label>
                                        <input <?=$per?> value="<?=$offer_details[0]->offer_name?>" id="offer_name" name="offer_name" type="text" placeholder="Offer Name" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="offer_fz_number" class="control-label text-danger">FZ Number</label>
                                        <input <?=$per?> value="<?=$offer_details[0]->offer_fz_number?>" id="offer_fz_number" name="offer_fz_number" type="text" placeholder="FZ Number" class="form-control round-input" />
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <label for="resources" class="control-label text-danger">Resource Developer *</label>
                                        <select name="resources" id="resources" class="form-control select2">
                                            <!-- <option value="">Select Resource Developer</option> -->
                                                <?php
                                                foreach($resources as $bd){
                                                ?> 
                                                <option <?=($offer_details[0]->resource_id == $bd->user_id) ? 'selected' : ''?> value="<?= $bd->user_id ?>"><?= $bd->username . ' ['. $bd->firstname . ' ' .$bd->lastname .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="acc_master_id" class="control-label text-danger">Supplier *</label>
                                        <?php $permitted_suppliers = explode(',',$permitted_suppliers->acc_masters) ?>
                                        <input type="hidden" id="selected_acc_master_id" value="<?=$offer_details[0]->am_id?>">
                                        <select multiple name="acc_master_id[]" id="acc_master_id" class="form-control select2">
                                            <!-- <option value="">Select Supplier</option> -->
                                                <?php
                                                foreach($suppliers as $bd){
                                                    if(!in_array($bd->am_id, $permitted_suppliers)){
                                                        continue;
                                                    }
                                                    $sn = ($bd->am_code == '' ? '-' : $bd->am_code);
                                                ?> 
                                                    <option <?=($offer_details[0]->am_id == $bd->am_id) ? 'selected' : ''?> value="<?= $bd->am_id ?>"><?= $bd->name . ' ['. $sn .']' ?>
                                                    </option>
                                                    <?php
                                                }
                                                ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-2">
                                        <label for="currencies" class="control-label text-danger">Currencies *</label>
                                        <select name="currencies" id="currencies" class="form-control select2">
                                            <!-- <option value="">Select Currencies</option> -->
                                                <?php
                                                foreach($currencies as $bd){
                                                    $sn = ($bd->code == '' ? '-' : $bd->code);
                                                ?> 
                                                    <option <?=($offer_details[0]->c_id == $bd->c_id) ? 'selected' : ''?> value="<?= $bd->c_id ?>">

                                                        <?= $bd->currency . ' ['. $sn .'] - ('. $bd->symbol .')' ?>
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
                                            <!-- <option value="">Select Incoterms</option> -->
                                                <?php
                                                foreach($incoterms as $bd){
                                                    $sn = ($bd->information == '' ? '-' : $bd->information);
                                                ?> 
                                                <option <?=($offer_details[0]->incoterm_id == $bd->it_id) ? 'selected' : ''?> value="<?= $bd->it_id ?>"><?= $bd->incoterm . ' ['. $sn .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="destination_c_id" class="control-label">Destination Country </label>
                                        <input type="hidden" id="selected_destination_countries" value="<?=$offer_details[0]->destination_c_id?>">
                                        <select multiple="" name="destination_c_id[]" id="destination_c_id" class="form-control select2">
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
                                                <?php
                                                foreach($countries as $bd){
                                                ?> 
                                                <option <?=($offer_details[0]->country_id == $bd->country_id) ? 'selected' : ''?> value="<?= $bd->country_id ?>"><?= $bd->name . ' ['. $bd->iso .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                        </select>
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="offer_date" class="control-label text-danger">Offer Date *</label>
                                        <input id="offer_date" name="offer_date" type="date" placeholder="Offer Date" value="<?=date('Y-m-d', strtotime($offer_details[0]->offer_date))?>" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-2">
                                        <label for="no_of_container" class="control-label">No of Container</label>
                                        <input id="no_of_container" name="no_of_container" type="number" placeholder="No of Container" class="form-control round-input" value="<?=$offer_details[0]->no_of_container?>" />
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="size_of_container" class="control-label">Size of Container </label>

                                        <select name="size_of_container" id="size_of_container" class="form-control round-input select2">
                                            <option value="">Select Size Of Container</option>

                                            <?php

                                            $size_of_containers = array("20 FT Reefer FCL", "40 FT Reefer FCL", "20 FT Dry FCL", "40 FT Dry FCL", "20 FT Reefer LCL", "40 FT Reefer LCL", "20 FT Dry LCL", "40 FT Dry LCL");
                                            foreach ($size_of_containers as $key => $size_of_container) {
                                        
                                            ?>

                                            <option value="<?=$size_of_container?>" <?=($offer_details[0]->size_of_container == $size_of_container)?'selected':''?>><?=$size_of_container?></option>

                                        <?php } ?>
                                            
                                            
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="quantity_each_container" class="control-label">Qnty of Each Container</label> <br>
                                         <select name="quantity_each_container" id="quantity_each_container" class="form-control round-input select2">
                                            <option value=""> Select quantity of each container</option>

                                            <?php

                                            $quantity_each_containers = array("24.0 Tons", "25.0 Tons", "26.0 Tons", "26.5 Tons", "27.0 Tons", "27.5 Tons", "28.0 Tons");
                                            foreach ($quantity_each_containers as $key => $quantity_each_container) {
                                            ?>

                                            <option value="<?=$quantity_each_container?>" <?=($offer_details[0]->quantity_each_container == $quantity_each_container)?'selected':''?>><?=$quantity_each_container?></option>

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

                                            <option value="<?=$shipping_line?>" <?=($offer_details[0]->shipping_line == $shipping_line)?'selected':''?>><?=$shipping_line?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>

                                        
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="shipment_timing" class="control-label">Shipment Timing</label>
                                        <input id="shipment_timing" name="shipment_timing" type="text" placeholder="Shipment Timing" class="form-control round-input" value="<?=$offer_details[0]->shipment_timing?>" />
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

                                            <option value="<?=$supplier_payment_term?>" <?=($offer_details[0]->supplier_payment_terms == $supplier_payment_term)?'selected':''?>><?=$supplier_payment_term?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>

                                        
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="etd" class="control-label">ETD</label>
                                        <input id="etd" value="<?=$offer_details[0]->etd?>" name="etd" type="text" placeholder="ETD" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="port_of_loading" class="control-label text-danger">Port of Loading*</label>

                                        <select name="port_of_loading" id="port_of_loading" class="form-control select2">
                                            <option value="">Select Port</option>
                                            <?php
                                            foreach($ports as $bd){
                                            ?> 
                                            <option <?=($offer_details[0]->port_of_loading == $bd->p_id) ? 'selected' : ''?> value="<?= $bd->p_id ?>"><?= $bd->port_name ?>
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

                                            <option value="<?=$document_clause?>" <?=($offer_details[0]->document_clause == $document_clause)?'selected':''?>><?=$document_clause?></option>

                                            <?php } ?>
                                            
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">    
                                    <div class="col-lg-3">
                                        <label for="inspection_clause" class="control-label">Inspection Clause</label>
                                        <textarea rows="4" id="inspection_clause" name="inspection_clause" placeholder="Inspection Clause" class="form-control"><?=$offer_details[0]->inspection_clause?></textarea>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="lab_report_clause" class="control-label">Lab Report Clause</label>
                                        <textarea rows="4" id="lab_report_clause" name="lab_report_clause" placeholder="Lab Report Clause" class="form-control"><?=$offer_details[0]->lab_report_clause?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="production_date" class="control-label">Production Date</label>
                                        <input id="production_date" name="production_date" type="date" value="<?=$offer_details[0]->production_date?>" placeholder="Production Date" class="form-control round-input" />
                                    </div>
                                  
                                    <div class="col-lg-3">
                                        <label for="shelf_life" class="control-label">Shelf Life</label>                                  

                                        <select name="shelf_life" id="shelf_life" class="form-control round-input select2">
                                            <option value="">Select shelf life</option>

                                            <?php

                                            $shelf_lifes = array("12 Months", "18 Months", "24 Months", "36 Months");
                                            foreach ($shelf_lifes as $key => $shelf_life) {
                                            ?>

                                            <option value="<?=$shelf_life?>" <?=($offer_details[0]->shelf_life == $shelf_life)?'selected':''?>><?=$shelf_life?></option>

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
                                            <option value="<?=$tolerance?>" <?=($offer_details[0]->tolerance == $tolerance)?'selected':''?>><?=$tolerance?></option>

                                            <?php } ?>
                                        </select>

                                        
                                    </div>
                                     <div class="col-lg-3">
                                        <label for="label_attached" class="control-label">Label Attached?</label>
                                        <select name="label_attached" id="label_attached" class="form-control select2">
                                            <!-- <option value="">Select Label</option> -->
                                        <option value="Yes" <?=($offer_details[0]->label_attached == 'Yes') ? 'selected' : ''?>>Yes</option>
                                        <option value="No" <?=($offer_details[0]->label_attached == 'No') ? 'selected' : ''?>>No</option>
                                         <option value="NA" <?=($offer_details[0]->label_attached == 'NA') ? 'selected' : ''?>>N.A.</option>
                                          <option value="remarks" <?=($offer_details[0]->label_attached == 'remarks') ? 'selected' : ''?>>See Remarks</option>
                                        </select>
                                     </div>
                                     <div class="col-lg-3">
                                        <label for="carton_with_date" class="control-label">Carton Printed with Production Date?</label>
                                        <select name="carton_with_date" id="carton_with_date" class="form-control select2">
                                            <option value="Yes" <?=($offer_details[0]->carton_with_date == 'Yes') ? 'selected' : ''?>>Yes</option>
                                            <option value="No" <?=($offer_details[0]->carton_with_date == 'No') ? 'selected' : ''?>>No</option>
                                            <option value="NA" <?=($offer_details[0]->carton_with_date == 'NA') ? 'selected' : ''?>>N.A.</option>
                                            <option value="remarks" <?=($offer_details[0]->carton_with_date == 'remarks') ? 'selected' : ''?>>See Remarks</option>
                                        </select>
                                     </div>

                                     <div class="col-lg-3">
                                        <label for="remark1" class="control-label">Remark 1</label>
                                        <select name="remark1" id="remark1" class="form-control select2">
                                            <option value="">Remark 1 - Offer Validity</option>
                                            <?php
                                            foreach($remark1_offer_validity as $bd){
                                            ?> 
                                            <option <?=($offer_details[0]->remarks_1 == $bd->rov_id) ? 'selected' : ''?> value="<?= $bd->rov_id ?>"><?= $bd->remark ?>
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
                                        <textarea rows="4" id="remark2" name="remark2" placeholder="Remark 2" class="form-control"><?=$offer_details[0]->remarks_2?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark3" class="control-label">Remark 3</label>
                                        <textarea  rows="4" id="remark3" name="remark3" placeholder="Remark 3" class="form-control"><?=$offer_details[0]->remarks_3?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="docs_provided" class="control-label">Docs provided</label>
                                        <input id="docs_provided" name="docs_provided" type="text" value="<?=$offer_details[0]->docs_provided?>" placeholder="Docs provided" class="form-control round-input" />
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
                                     <?php if($this->session->usertype == 1){ ?>
                                     <div class="col-lg-3">
                                         <label for="offer_status_id" class="control-label">Offer Status</label>
                                         <select name="offer_status_id" id="offer_status_id" class="form-control round-input select2">
                                            <?php
                                            foreach ($offer_status as $key => $offer_status_row) {
                                            ?>
                                            <option value="<?=$offer_status_row->offer_status_id?>" <?=($offer_status_row->offer_status_id == $offer_details[0]->offer_status_id) ? 'selected' : ''?>><?=$offer_status_row->offer_status?></option>
                                            <?php } ?>
                                         </select>
                                     </div>
                                     <?php } ?>
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
                                        <button class="btn btn-success pull-right" type="submit"><i class="fa fa-plus"> Update Offer</i></button>
                                    </div>
                                    <!-- <div class="col-lg-6">
                                        <a id="edit_btn" href="javascript:void(0)" class="hidden btn btn-info"><i class="fa fa-pencil"> Edit Offer</i></a>
                                    </div> -->
                                </div>
                                <input type="hidden" id="offer_id" name="offer_id" class="hidden" value="<?= $offer_details[0]->offer_id ?>" />
                            </form>
                        </div>
                    </section>
                </div>
                
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Files: 
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                                                
                        <div class="panel-body text-center" style="padding: 1px;">
                            <h4><strong> Pictures: </strong></h4>
                            <?php 
                            echo (count($offer_files) == 0) ? 'Nothing Uploaded':'';
                            foreach ($offer_files as $value) { 
                                if($value->file_category == 'report'){
                                    continue;
                                }

                                $tmp_val = explode('.',$value->file_name);
                                $file_ext=strtolower(end($tmp_val));
                                
                                $extensions= array("jpeg","jpg","png");
                                ?>
                                <div class="col-lg-2">             
                                    <?php
                                    if(in_array($file_ext,$extensions) === false){
                                     ?>
                                    <img src="<?= base_url('assets/admin_panel/img') .'/no-file.png' ?>" style="height:75px;margin-bottom: 7px;"> 
                                    <br><br>
                                    <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/pictures') .'/' . $value->file_name ?>" class="" download>
                                        <i class="fa fa-download"></i>
                                    </a>
                                
                                    <button style="padding:5px 10px" title="Remove / Delete" class="btn btn-danger delete-file"> <i class="fa fa-remove"></i></button>
                                    
                                    <hr>
                                    <?php
                                    }else{
                                    ?>
                                    <img src="<?= base_url('upload/pictures') .'/' . $value->file_name ?>" style="height:75px;margin-bottom: 7px;"> 
                                    <br><br>
                                    <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/pictures') .'/' . $value->file_name ?>" class="" download>
                                        <i class="fa fa-download"></i>
                                    </a>
                                
                                    <button style="padding:5px 10px" title="Remove / Delete" class="btn btn-danger delete-file"> <i class="fa fa-remove"></i></button>

                                    <hr />
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        
                        <div class="panel-body text-center">
                            <h4><strong> Reports: </strong></h4>
                            <?php
                            echo (count($offer_files) == 0) ? 'Nothing Uploaded':''; 
                            foreach ($offer_files as $value) { 
                                if($value->file_category == 'picture'){
                                    continue;
                                }

                                $tmp_val = explode('.',$value->file_name);
                                $file_ext=strtolower(end($tmp_val));
                                ?>
                                
                                <div class="col-lg-2">             
                                    <?php
                                    if(in_array($file_ext,$extensions) === false){
                                     ?>
                                   <img src="<?= base_url('assets/admin_panel/img') .'/no-file.png' ?>" style="height:75px;margin-bottom: 7px;">  
                                    <br><br>
                                    <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/reports') .'/' . $value->file_name ?>" class="" download>
                                        <i class="fa fa-download"></i>
                                    </a>
                                
                                    <button style="padding:5px 10px" title="Remove / Delete" class="btn btn-danger delete-file"> <i class="fa fa-remove"></i></button>
                                    
                                    <hr>
                                    <?php
                                    }else{
                                    ?>
                                    <img src="<?= base_url('upload/reports') .'/' . $value->file_name ?>" style="height:75px;margin-bottom: 7px;"> 
                                    <br><br>
                                    <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/reports') .'/' . $value->file_name ?>" class="" download>
                                        <i class="fa fa-download"></i>
                                    </a>
                                
                                    <button style="padding:5px 10px" title="Remove / Delete" class="btn btn-danger delete-file"> <i class="fa fa-remove"></i></button>

                                    <hr />
                                    <?php } ?>
                                </div>          
                            
                            <?php } ?>     
                        </div> 
                    </section>
                </div>
            </div>
           
            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Add Offer details for <?= $offer_details[0]->offer_name ?>
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <!--Tabs-->
                            <ul id="offer_tabs" class="nav nav-tabs nav-justified">
                                <li class="active"><a href="#offer_details_list" data-toggle="tab">List</a></li>
                                <li  id="offer_details_add_tab"><a href="#offer_details_add" data-toggle="tab">Add</a></li>
                                <li id="offer_details_edit_tab" class="disabled"><a href="#offer_details_edit" data-toggle="">Edit</a></li>
                                <li id="offer_details_export_tab" class="disabled"><a href="#offer_details_export" data-toggle="">Export</a></li>
                            </ul>
                            <!--Tab Content-->
                            <div class="tab-content">
                            <img style="display:none; position: absolute;margin: auto;left: 0;right: 0;" src="<?=base_url('assets/img/ellipsis.gif')?>" id="loading_div"><span class="sr-only">Processing...</span>
                            
                                <div id="offer_details_list" class="tab-pane fade in active">
                                    <table id="offer_details_table" class="table data-table dataTable">
                                        <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Scientific Name</th>

                                            <th>Size</th>

                                            <th>Pieces</th>

                                            <th>Packing size</th>
                                            
                                            <th>Quantity Offered</th>
                                            <th>Product Price <?= (array_key_exists(0,$offer_details) && !empty($offer_details[0]->symbol))?'('.$offer_details[0]->symbol.')':''?></th>
                                            <th>Total Price <?= (array_key_exists(0,$offer_details) && !empty($offer_details[0]->symbol))?'('.$offer_details[0]->symbol.')':''?></th>
                                            <th>Actions</th>


                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th ><span></span></th>
                                            <th></th>                                            
                                        </tr>
                                            <!-- <tr class="bg-green">
                                                <th colspan="21">Buying Product price: dd</th>
                                            </tr>  -->
                                        </tfoot>
                                    </table>
                                </div>

                                <div id="offer_details_add" class="tab-pane fade">
                                    <br/>
                                    <div class="form">
                                        <form id="form_add_offer_details" method="post" action="<?=base_url('admin/form-add-offer-details')?>" class="cmxform form-horizontal tasi-form">
                                        <div class="form-group ">    

                                            <div class="col-lg-3">
                                                <label for="product_id" class="control-label text-danger">Product Name*</label>
                                                <select name="product_id" id="product_id" class="form-control select2">
                                                    <option>Select Product</option>
                                                    <?php
                                                    foreach($products as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->pr_id ?>"><?= $bd->product_name . ' ['. $bd->scientific_name .']' ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="product_description" class="control-label">Product Desciption</label>
                                                <input type="text" name="product_description" id="product_description" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="size_id" class="control-label">Sizes*</label>
                                                <select name="size_id" id="size_id" class="form-control select2">
                                                    <option>Select sizes</option>
                                                    <?php
                                                    foreach($sizes as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->size_id ?>"><?= $bd->size ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="pieces" class="control-label">Pieces</label>
                                                <input type="text" name="pieces" id="pieces" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="grade" class="control-label">Grade</label>
                                                <input type="text" name="grade" id="grade" class="form-control">
                                            </div>

                                            <div class="col-lg-3">
                                                <label for="product_line_po" class="control-label">Product Line (PO)</label>
                                                <textarea name="product_line_po" id="product_line_po" class="form-control"></textarea>
                                            </div> 
                                            
                                            <div class="col-lg-3">
                                                <label for="product_line_sc" class="control-label">Product Line (SC)</label>
                                                <textarea name="product_line_sc" id="product_line_sc" class="form-control"></textarea>
                                            </div> 


                                            <div class="col-lg-3">
                                                <label for="packing_size_id" class="control-label">Packing Sizes*</label>
                                                <select name="packing_size_id" id="packing_size_id" class="form-control select2">
                                                    <option>Select Packing Size</option>
                                                    <?php
                                                    foreach($packing_sizes as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->ps_id ?>"><?= $bd->packing_size ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-3">
                                                <label for="blocks" class="control-label">Blocks*</label>
                                                <select name="block_id" id="block_id" class="form-control select2">
                                                    <option>Select Block</option>
                                                    <?php
                                                    foreach($blocks as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->block_id ?>"><?= $bd->block_size ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="primary_packing_type_id" class="control-label">Packing type (primary)*</label>
                                                <select name="primary_packing_type_id" id="primary_packing_type_id" class="form-control select2">
                                                    <option>Select Packing (primary)</option>
                                                    <?php
                                                    foreach($packing_types_p as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->pt_id ?>"><?= $bd->packing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="secondary_packing_type_id" class="control-label">Packing type (secondary)*</label>
                                                <select name="secondary_packing_type_id" id="secondary_packing_type_id" class="form-control select2">
                                                    <option>Select Packing (secondary)</option>
                                                    <?php
                                                    foreach($packing_types_s as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->pt_id ?>"><?= $bd->packing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="freezing_id" class="control-label">Freezing type*</label>
                                                <select name="freezing_id" id="freezing_id" class="form-control select2">
                                                    <option>Select Freezing Type</option>
                                                    <?php
                                                    foreach($freezing as $bd){
                                                        if($bd->freezing_category == 'Method'){
                                                            continue;
                                                        }
                                                    ?> 
                                                    <option value="<?= $bd->ft_id ?>"><?= $bd->freezing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-2">
                                                <label for="freezing_method_id" class="control-label">Freezing method</label>
                                                <select name="freezing_method_id" id="freezing_method_id" class="form-control select2">
                                                    <option>Select Freezing Method</option>
                                                    <?php
                                                    foreach($freezing as $bd){
                                                        if($bd->freezing_category == 'Type'){
                                                            continue;
                                                        }
                                                    ?> 
                                                    <option value="<?= $bd->ft_id ?>"><?= $bd->freezing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="glazing" class="control-label">Glazing*</label>
                                                <select name="glazing_id" id="glazing_id" class="form-control select2">
                                                    <option>Select Glazing</option>
                                                    <?php
                                                    foreach($glazing as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->gl_id ?>"><?= $bd->glazing ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="size_before_glaze" class="control-label">Size before Glaze</label>
                                                <select name="size_before_glaze" id="size_before_glaze" class="form-control select2">
                                                    <option>Select size before glazing</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="NA">N.A.</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="size_after_glaze" class="control-label">Size after Glaze</label>
                                                <select name="size_after_glaze" id="size_after_glaze" class="form-control select2">
                                                    <option>Select size after glazing</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="NA">N.A.</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="cartons_offered" class="control-label">Cartons Offered</label>
                                                <input type="number" name="cartons_offered" id="cartons_offered" class="form-control">
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="unit_id" class="control-label text-danger">Quantity Unit</label>
                                                <select name="unit_id" id="unit_id" class="form-control select2">
                                                    <option>Select Quantity Unit</option>
                                                    <?php
                                                    foreach($units as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->u_id ?>"><?= $bd->unit ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-2">
                                                <label for="gross_weight" class="control-label">Gross Weight</label>
                                                <input type="text" name="gross_weight" id="gross_weight" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-lg-2">
                                                <label for="quantity_offered" class="control-label text-danger">Quantity Offered</label>
                                                <input type="number" step="0.001" id="quantity_offered" min="0" name="quantity_offered" class="form-control">
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="product_price" class="control-label text-danger">Product Price</label>
                                                <input type="number" step="0.001" id="product_price" min="0" name="product_price" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="total_value" class="control-label text-danger">Total Value</label>
                                                <input type="number" readonly="" name="total_value" id="total_value" class="form-control">
                                            </div> 
                                            <div class="col-lg-5">
                                                <label for="unit_id" class="control-label">Remarks</label>
                                                <textarea rows="4" id="comment" name="comment" placeholder="Line remarks" class="form-control"></textarea>
                                            </div>
                                        </div>

                                       
                                        <div class="form-group ">                   
                                            <hr>
                                           <div class="col-lg-12 text-center"> 
                                            <input type="submit" name="offer_details_submit" class="btn btn-success text-center" id="offer_details_submit" value="Add">
                                            <input type="hidden" name="offer_id" class="hidden" value="<?= $offer_details[0]->offer_id ?>" />
                                            </div>
                                        </div>    
                                        </form>
                                    </div>
                                </div>

                                <div id="offer_details_edit" class="tab-pane">
                                    <br/>
                                    <div class="form">
                                        <form id="form_edit_offer_details" method="post" action="<?=base_url('admin/form-edit-offer-details')?>" class="cmxform form-horizontal tasi-form">
                                        <div class="form-group ">
                                            <div class="col-lg-3">
                                                <label for="product_id_edit" class="control-label text-danger">Product Name*</label>
                                                <select name="product_id_edit" id="product_id_edit" class="form-control select2">
                                                    <option>Select Product</option>
                                                    <?php
                                                    foreach($products as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->pr_id ?>"><?= $bd->product_name . ' ['. $bd->scientific_name .']' ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="product_description_edit" class="control-label">Product Desciption</label>
                                                <input type="text" name="product_description_edit" id="product_description_edit" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="size_id_edit" class="control-label">Sizes*</label>
                                                <select name="size_id_edit" id="size_id_edit" class="form-control select2">
                                                    <option>Select sizes</option>
                                                    <?php
                                                    foreach($sizes as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->size_id ?>"><?= $bd->size ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="pieces_edit" class="control-label">Pieces</label>
                                                <input type="text" name="pieces_edit" id="pieces_edit" class="form-control">
                                            </div>

                                            <div class="col-lg-3">
                                                <label for="grade_edit" class="control-label">Grade</label>
                                                <input type="text" name="grade_edit" id="grade_edit" class="form-control">
                                            </div> 

                                            <div class="col-lg-3">
                                                <label for="product_line_po_edit" class="control-label">Product Line (PO)</label>
                                                <textarea name="product_line_po_edit" id="product_line_po_edit" class="form-control"></textarea>
                                            </div> 
                                            
                                            <div class="col-lg-3">
                                                <label for="product_line_sc_edit" class="control-label">Product Line (SC)</label>
                                                <textarea name="product_line_sc_edit" id="product_line_sc_edit" class="form-control"></textarea>
                                            </div> 
                                            
                                            <div class="col-lg-3">
                                                <label for="packing_size_id_edit" class="control-label">Packing Sizes*</label>
                                                <select name="packing_size_id_edit" id="packing_size_id_edit" class="form-control select2">
                                                    <option>Select Packing Size</option>
                                                    <?php
                                                    foreach($packing_sizes as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->ps_id ?>"><?= $bd->packing_size ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <div class="col-lg-3">
                                                <label for="blocks_id_edit" class="control-label">Blocks*</label>
                                                <select name="block_id_edit" id="block_id_edit" class="form-control select2">
                                                    <option>Select Block</option>
                                                    <?php
                                                    foreach($blocks as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->block_id ?>"><?= $bd->block_size ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="primary_packing_type_id_edit" class="control-label">Packing type (primary)*</label>
                                                <select name="primary_packing_type_id_edit" id="primary_packing_type_id_edit" class="form-control select2">
                                                    <option>Select Packing (primary)</option>
                                                    <?php
                                                    foreach($packing_types_p as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->pt_id ?>"><?= $bd->packing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="secondary_packing_type_id_edit" class="control-label">Packing type (secondary)*</label>
                                                <select name="secondary_packing_type_id_edit" id="secondary_packing_type_id_edit" class="form-control select2">
                                                    <option>Select Packing (secondary)</option>
                                                    <?php
                                                    foreach($packing_types_s as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->pt_id ?>"><?= $bd->packing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="freezing_id_edit" class="control-label">Freezing type*</label>
                                                <select name="freezing_id_edit" id="freezing_id_edit" class="form-control select2">
                                                    <option>Select Freezing Type</option>
                                                    <?php
                                                    foreach($freezing as $bd){
                                                        if($bd->freezing_category == 'Method'){
                                                            continue;
                                                        }
                                                    ?> 
                                                    <option value="<?= $bd->ft_id ?>"><?= $bd->freezing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <div class="col-lg-2">
                                                <label for="freezing_method_edit" class="control-label">Freezing method</label>
                                                <select name="freezing_method_edit" id="freezing_method_edit" class="form-control select2">
                                                    <option>Select Freezing Method</option>
                                                    <?php
                                                    foreach($freezing as $bd){
                                                        if($bd->freezing_category == 'Type'){
                                                            continue;
                                                        }
                                                    ?> 
                                                    <option value="<?= $bd->ft_id ?>"><?= $bd->freezing_type ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="glazing_id_edit" class="control-label">Glazing*</label>
                                                <select name="glazing_id_edit" id="glazing_id_edit" class="form-control select2">
                                                    <option>Select Glazing</option>
                                                    <?php
                                                    foreach($glazing as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->gl_id ?>"><?= $bd->glazing ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="size_before_glaze_edit" class="control-label">Size before Glaze</label>
                                                <select name="size_before_glaze_edit" id="size_before_glaze_edit" class="form-control select2">
                                                    <option>Select size before glazing</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="NA">N.A.</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="size_after_glaze_edit" class="control-label">Size after Glaze</label>
                                                <select name="size_after_glaze_edit" id="size_after_glaze_edit" class="form-control select2">
                                                    <option>Select size after glazing</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="NA">N.A.</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="cartons_offered_edit" class="control-label">Cartons Offered</label>
                                                <input type="number" name="cartons_offered_edit" id="cartons_offered_edit" class="form-control">
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="unit_id_edit" class="control-label text-danger">Quantity Unit</label>
                                                <select name="unit_id_edit" id="unit_id_edit" class="form-control select2">
                                                    <option>Select Quantity Unit</option>
                                                    <?php
                                                    foreach($units as $bd){
                                                    ?> 
                                                    <option value="<?= $bd->u_id ?>"><?= $bd->unit ?>
                                                    </option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            
                                            <div class="col-lg-2">
                                                <label for="gross_weight_edit" class="control-label">Gross Weight</label>
                                                <input type="text" name="gross_weight_edit" id="gross_weight_edit" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">    
                                            <div class="col-lg-2">
                                                <label for="quantity_offered_edit" class="control-label text-danger">Quantity Offered</label>
                                                <input type="number" step="0.001" id="quantity_offered_edit" min="0" name="quantity_offered_edit" class="form-control">
                                            </div>

                                            <div class="col-lg-2">
                                                <label for="product_price_edit" class="control-label text-danger">Product Price</label>
                                                <input type="number" step="0.001" id="product_price_edit" min="0" name="product_price_edit" class="form-control">
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="total_value_edit" class="control-label text-danger">Total Value</label>
                                                <input type="number" readonly="" name="total_value_edit" id="total_value_edit" class="form-control">
                                            </div>
                                            <div class="col-lg-5">
                                                <label for="comment_edit" class="control-label">Remarks</label>
                                                <textarea rows="4" id="comment_edit" name="comment_edit" placeholder="Line remarks" class="form-control"></textarea>
                                            </div>                                            
                                        </div>

                                   <div class="col-lg-12 text-center"> 
                                            
                                            <input type="hidden" name="offer_details_id_edit" class="btn btn-success text-center" id="offer_details_id_edit" value="">

                                            <input type="hidden" name="offer_details_trader_id_edit" class="btn btn-success text-center" id="offer_details_trader_id_edit" value="">

                                            <input type="hidden" name="offer_id_edit" class="btn btn-success text-center" id="offer_id_edit" value="<?=$offer_details[0]->offer_id?>">

                                            <input type="submit" name="offer_details_edit_submit" class="btn btn-success text-center" id="offer_details_edit_submit" value="Update">            
                                        </div>
                                       
                                    </form>
                                </div>
                            </div> 

                            <div id="offer_details_export" class="tab-pane">
                                <br/>
                                <div class="form">
                                    <form id="form_export_offer_details" method="post" action="<?=base_url('admin/form-export-offer-details')?>" class="cmxform form-horizontal tasi-form">
                                    <div class="form-group ">    

                                        <div class="col-lg-3">
                                            <label for="offer_id_export" class="control-label text-danger">Offer Name*</label>
                                            <select name="offer_id_export" id="offer_id_export" class="form-control select2">
                                                <!-- <option>Select Offer</option> -->
                                                <?php
                                                foreach($offers as $bd){
                                                ?> 
                                                <option value="<?= $bd->offer_id ?>"><?= $bd->offer_name ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="product_id_export" class="control-label text-danger">Product Name*</label>
                                            <select name="product_id_export" id="product_id_export" class="form-control select2">
                                                <option>Select Product</option>
                                                <?php
                                                foreach($products as $bd){
                                                ?> 
                                                <option value="<?= $bd->pr_id ?>"><?= $bd->product_name . ' ['. $bd->scientific_name .']' ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="size_id_export" class="control-label">Sizes*</label>
                                            <select name="size_id_export" id="size_id_export" class="form-control select2">
                                                <option>Select sizes</option>
                                                <?php
                                                foreach($sizes as $bd){
                                                ?> 
                                                <option value="<?= $bd->size_id ?>"><?= $bd->size ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="pieces_export" class="control-label">Pieces</label>
                                            <input type="text" name="pieces_export" id="pieces_export" class="form-control valid" aria-invalid="false">

                                        </div>

                                        <div class="col-lg-3">
                                            <label for="grade_export" class="control-label">Grade</label>
                                            <input type="text" name="grade_export" id="grade_export" class="form-control">
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="product_line_po_export" class="control-label">Product Line (PO)</label>
                                            <textarea name="product_line_po_export" id="product_line_po_export" class="form-control"></textarea>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="product_line_sc_export" class="control-label">Product Line (SC)</label>
                                            <textarea name="product_line_sc_export" id="product_line_sc_export" class="form-control"></textarea>
                                        </div> 
                                        <div class="col-lg-3">
                                            <label for="packing_size_id_export" class="control-label">Packing Sizes*</label>
                                            <select name="packing_size_id_export" id="packing_size_id_export" class="form-control select2">
                                                <option>Select Packing Size</option>
                                                <?php
                                                foreach($packing_sizes as $bd){
                                                ?> 
                                                <option value="<?= $bd->ps_id ?>"><?= $bd->packing_size ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <label for="product_description_export" class="control-label">Product Desciption</label>
                                            <input type="text" name="product_description_export" id="product_description_export" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group ">      
                                        <div class="col-lg-3">
                                            <label for="blocks_id_export" class="control-label">Blocks*</label>
                                            <select name="block_id_export" id="block_id_export" class="form-control select2">
                                                <option>Select Block</option>
                                                <?php
                                                foreach($blocks as $bd){
                                                ?> 
                                                <option value="<?= $bd->block_id ?>"><?= $bd->block_size ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="primary_packing_type_id_export" class="control-label">Packing type (primary)*</label>
                                            <select name="primary_packing_type_id_export" id="primary_packing_type_id_export" class="form-control select2">
                                                <option>Select Packing (primary)</option>
                                                <?php
                                                foreach($packing_types_p as $bd){
                                                ?> 
                                                <option value="<?= $bd->pt_id ?>"><?= $bd->packing_type ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="secondary_packing_type_id_export" class="control-label">Packing type (secondary)*</label>
                                            <select name="secondary_packing_type_id_export" id="secondary_packing_type_id_export" class="form-control select2">
                                                <option>Select Packing (secondary)</option>
                                                <?php
                                                foreach($packing_types_s as $bd){
                                                ?> 
                                                <option value="<?= $bd->pt_id ?>"><?= $bd->packing_type ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="freezing_id_export" class="control-label">Freezing type*</label>
                                            <select name="freezing_id_export" id="freezing_id_export" class="form-control select2">
                                                <option>Select Freezing Type</option>
                                                <?php
                                                foreach($freezing as $bd){
                                                    if($bd->freezing_category == 'Method'){
                                                        continue;
                                                    }
                                                ?> 
                                                <option value="<?= $bd->ft_id ?>"><?= $bd->freezing_type ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <div class="col-lg-2">
                                            <label for="freezing_method_export" class="control-label">Freezing method</label>
                                            <select name="freezing_method_export" id="freezing_method_export" class="form-control select2">
                                                <option>Select Freezing Method</option>
                                                <?php
                                                foreach($freezing as $bd){
                                                    if($bd->freezing_category == 'Type'){
                                                        continue;
                                                    }
                                                ?> 
                                                <option value="<?= $bd->ft_id ?>"><?= $bd->freezing_type ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>      
                                        <div class="col-lg-2">
                                            <label for="glazing_id_export" class="control-label">Glazing*</label>
                                            <select name="glazing_id_export" id="glazing_id_export" class="form-control select2">
                                                <option>Select Glazing</option>
                                                <?php
                                                foreach($glazing as $bd){
                                                ?> 
                                                <option value="<?= $bd->gl_id ?>"><?= $bd->glazing ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="size_before_glaze_export" class="control-label">Size before Glaze</label>
                                            <select name="size_before_glaze_export" id="size_before_glaze_export" class="form-control select2">
                                                <option>Select size before glazing</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                <option value="NA">N.A.</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-2">
                                            <label for="size_after_glaze_export" class="control-label">Size after Glaze</label>
                                            <select name="size_after_glaze_export" id="size_after_glaze_export" class="form-control select2">
                                                <option>Select size after glazing</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                                <option value="NA">N.A.</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="cartons_offered_export" class="control-label">Cartons Offered</label>
                                            <input type="number" name="cartons_offered_export" id="cartons_offered_export" class="form-control">
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="unit_id_export" class="control-label text-danger">Quantity Unit</label>
                                            <select name="unit_id_export" id="unit_id_export" class="form-control select2">
                                                <option>Select Quantity Unit</option>
                                                <?php
                                                foreach($units as $bd){
                                                ?> 
                                                <option value="<?= $bd->u_id ?>"><?= $bd->unit ?>
                                                </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                         <div class="col-lg-2">
                                            <label for="gross_weight_export" class="control-label">Gross Weight</label>
                                            <input type="text" name="gross_weight_export" id="gross_weight_export" class="form-control">
                                         </div>
                                    </div> 
                                    <div class="form-group">
                                        <div class="col-lg-2">
                                            <label for="quantity_offered_export" class="control-label text-danger">Quantity Offered</label>
                                            <input type="number" step="0.001" id="quantity_offered_export" min="0" name="quantity_offered_export" class="form-control">
                                        </div>
                                        <div class="col-lg-2">
                                            <label for="product_price_export" class="control-label text-danger">Product Price</label>
                                            <input type="number" step="0.001" id="product_price_export" min="0" name="product_price_export" class="form-control">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="total_value_export" class="control-label text-danger">Total Value</label>
                                            <input type="number" readonly="" name="total_value_export" id="total_value_export" class="form-control">
                                        </div>
                                        <div class="col-lg-5">
                                            <label for="comment_export" class="control-label">Remarks</label>
                                            <textarea rows="4" id="comment_export" name="comment_export" placeholder="Line remarks" class="form-control"></textarea>
                                        </div>
                                       
                                    </div>
                                    <div class="col-lg-12 text-center"> 
                                        <input type="submit" name="offer_details_export_submit" class="btn btn-success text-center" id="offer_details_export_submit" value="Export">            
                                    </div>
                                    
                                   
                                    </form>
                                </div>
                            </div> 

                        </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<script>
    
    $(document).ready(function() {

        $('#offer_details_table').DataTable( {
            "processing": true,
            "language": {
                processing: '<img src="<?=base_url('assets/img/ellipsis.gif')?>"><span class="sr-only">Processing...</span>',
            },
            "serverSide": true,
            "createdRow": function (row, data, index) {
                    $('td', row).eq(6).html('<?=$offer_details[0]->symbol?> ' + data.price);

                    $('td', row).eq(7).html('<?=$offer_details[0]->symbol?> ' + data.total_price);
                
            },
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
 
                // converting to interger to find total
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                 var totalqty = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

               
                $( api.column( 5 ).footer() ).html('Total Qty:' + '  ' +  Math.round(totalqty).toFixed(2));


                var totalproductPrice = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

               
                $( api.column( 6 ).footer() ).html('Total :' + ' <?=$offer_details[0]->symbol?> ' +  Math.round(totalproductPrice).toFixed(2));

                var totalPrice = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

               
                $( api.column( 7 ).footer() ).html('Total :' + '  <?=$offer_details[0]->symbol?> ' +  Math.round(totalPrice).toFixed(2));
            },
            "ajax": {
                "url": "<?=base_url('admin/ajax-offer-details-table-data')?>",
                "type": "POST",
                "dataType": "json",
                data: {
                    offer_id: function () {
                        return $("#offer_id").val();
                    },
                },
            },
            //will get these values from JSON 'data' variable
            "columns": [
                { "data": "name" },
                { "data": "scientific_name" },
                { "data": "size_name" },

                { "data": "pieces" },

                { "data": "packing_size" },

                

                
                { "data": "quantity" },
                { "data": "price" },
                { "data": "total_price" },
                { "data": "action" },
            ],
            //column initialisation properties
            "columnDefs": [{
                "targets": [1,2,3,4,5,6,7,8],
                "orderable": false,
            }]
        } );
    } );

    // HEADER 
    $("#form_edit_offer").validate({
        rules: {
            offer_number: {
                required: true,
                remote: {
                    url: "<?=base_url('admin/ajax-unique-offer-number-edit')?>",
                    type: "post",
                    data: {
                        offer_number: function() {
                          return $("#offer_number").val();
                        },
                        offer_id: function(){
                          return $("#offer_id").val();  
                        }
                    },
                },
            },
            acc_master_id: {
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
            }
        },
        messages: {

        }
    });
    $('#form_edit_offer').ajaxForm({
        beforeSubmit: function () {
            return $("#form_edit_offer").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            obj = JSON.parse(returnData);
            notification(obj);
        }
    });

    // ADD
    $("#form_add_offer_details").validate({
        rules: {
            product_id: {
                required: true,
            },
            product_price: {
                required: true,
            },
            quantity_offered: {
                required: true,
            },
            unit_id: {
                required: true, 
            }
        },
        messages: {

        }
    });
    $('#form_add_offer_details').ajaxForm({
        beforeSubmit: function () {
			$('#loading_div').show();
			$('#offer_details_submit').prop( "disabled", true );
            return $("#form_add_offer_details").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            // console.log('RD => ' + returnData);
            obj = JSON.parse(returnData);
			$('#loading_div').hide();
			$('#offer_details_submit').prop( "disabled", false );

            /*$offer_total_amount = parseFloat(obj.total_amount).toFixed(2);
            $offer_total_quantity = parseFloat(obj.total_qnty).toFixed(2);
            $("#offer_total_amount").text($offer_total_amount);
            $("#offer_total_quantity").text($offer_total_quantity);*/

             $('#form_add_offer_details')[0].reset(); //reset form
             $("#form_add_offer_details select").select2("val", ""); //reset all select2 fields
             // $('#form_add_offer_details :radio').iCheck('update'); //reset all iCheck fields
             $("#form_add_offer_details").validate().resetForm(); //reset validation
            notification(obj);
            // $("#lc_id").select2('open');
            //refresh table
            $('#offer_details_table').DataTable().ajax.reload();
            
        }
    });

    $("#product_price, #quantity_offered").blur(function(){

        $product_price = $("#product_price").val();
        $quantity_offered = $("#quantity_offered").val();
        $val = parseFloat($product_price) * parseFloat($quantity_offered);
        $("#total_value").val($val.toFixed(2));
    });

    // EDIT
    $("#offer_details_table").on('click', '.offer_details_edit_btn', function() {
        $od_id = $(this).data('od_id');
        // alert($od_id);
        $("#offer_details_id_edit").val($od_id);

        $.ajax({
            url: "<?= base_url('admin/fetch-offer-details-on-pk/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {pk: $od_id},
            success: function (returnData) {
                console.log(returnData);                
                data = returnData[0];

                $("#offer_details_trader_id_edit").val(data.od_id);

                $("#product_id_edit").val(data.product_id).trigger('change');
                $("#product_description_edit").val(data.product_description).trigger('change');
                $("#product_price_edit").val(data.product_price).trigger('change');
                $("#freezing_method_edit").val(data.freezing_method_id).trigger('change');
                $("#freezing_id_edit").val(data.freezing_id).trigger('change');
                $("#primary_packing_type_id_edit").val(data.primary_packing_type_id).trigger('change');
                $("#secondary_packing_type_id_edit").val(data.secondary_packing_type_id).trigger('change');
                $("#packing_size_id_edit").val(data.packing_size_id).trigger('change');
                $("#glazing_id_edit").val(data.glazing_id).trigger('change');
                $("#block_id_edit").val(data.block_id).trigger('change');
                $("#size_id_edit").val(data.size_id).trigger('change');
                $("#size_before_glaze_edit").val(data.size_before_glaze).trigger('change');
                $("#pieces_edit").val(data.pieces).trigger('change');

                $("#product_line_po_edit").val(data.product_line);
                
                $("#product_line_sc_edit").val(data.product_line_sc);
                
                
                $("#gross_weight_edit").val(data.gross_weight);
                
                
                
                


                $("#grade_edit").val(data.grade);
                $("#size_after_glaze_edit").val(data.size_after_glaze).trigger('change');
                $("#quantity_offered_edit").val(data.quantity_offered).trigger('change');
                $("#unit_id_edit").val(data.unit_id).trigger('change');
                $("#total_value_edit").val((parseFloat(data.product_price) * parseFloat(data.quantity_offered)).toFixed(2)).trigger('change');
                $("#cartons_offered_edit").val(data.cartons_offered).trigger('change');
                $("#comment_edit").val(data.comment).trigger('change');

                $('a[href="#offer_details_edit"]').tab('show');

            },
            error: function (returnData) {
                obj = JSON.parse(returnData);
                notification(obj);
            }
        });
    });

    $("#form_edit_offer_details").validate({
        rules: {
             product_id_edit: {
                required: true,
            },
            product_price_edit: {
                required: true,
            },
            quantity_offered_edit: {
                required: true,
            },
            unit_id_edit: {
                required: true, 
            }
        },
        messages: {
            
        }
    });

    $('#form_edit_offer_details').ajaxForm({
        beforeSubmit: function () {
            return $("#form_edit_offer_details").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            console.log('RD => ' + returnData);
            obj = JSON.parse(returnData);

            $('#form_edit_offer_details')[0].reset(); //reset form
            $("#form_edit_offer_details select").select2("val", ""); 
            $("#form_edit_offer_details").validate().resetForm(); 

            notification(obj);
            
            //refresh table
            $('#offer_details_table').DataTable().ajax.reload();
            
        }
    });

    $("#product_price_edit, #quantity_offered_edit").blur(function(){

        $product_price = $("#product_price_edit").val();
        $quantity_offered = $("#quantity_offered_edit").val();
        $val = parseFloat($product_price) * parseFloat($quantity_offered);
        $("#total_value_edit").val($val.toFixed(2));
    });    

    // EXPORT
    $("#offer_details_table").on('click', '.offer_details_export_btn', function() {
        
        $od_id = $(this).data('od_id');
        
        $.ajax({
            url: "<?= base_url('admin/fetch-offer-details-on-pk/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {pk: $od_id},
            success: function (returnData) {
                console.log(returnData);                
                data = returnData[0];

                $("#product_id_export").val(data.product_id).trigger('change');
                $("#product_description_export").val(data.product_description).trigger('change');
                $("#product_price_export").val(data.product_price).trigger('change');
                $("#freezing_id_export").val(data.freezing_id).trigger('change');
                $("#freezing_method_export").val(data.freezing_method_id).trigger('change');
                $("#primary_packing_type_id_export").val(data.primary_packing_type_id).trigger('change');
                $("#secondary_packing_type_id_export").val(data.secondary_packing_type_id).trigger('change');
                $("#packing_size_id_export").val(data.packing_size_id).trigger('change');
                $("#glazing_id_export").val(data.glazing_id).trigger('change');
                $("#block_id_export").val(data.block_id).trigger('change');
                $("#size_id_export").val(data.size_id).trigger('change');
                $("#size_before_glaze_export").val(data.size_before_glaze).trigger('change');
                $("#size_after_glaze_export").val(data.size_after_glaze).trigger('change');
                $("#quantity_offered_export").val(data.quantity_offered).trigger('change');
                $("#pieces_export").val(data.pieces).trigger('change');

                $("#product_line_po_export").val(data.product_line);

                $("#product_line_sc_export").val(data.product_line_sc);
                
                $("#gross_weight_export").val(data.gross_weight);
                
                


                $("#grade_export").val(data.grade);
                $("#unit_id_export").val(data.unit_id).trigger('change');
                $("#total_value_export").val((parseFloat(data.product_price) * parseFloat(data.quantity_offered)).toFixed(2)).trigger('change');
                $("#cartons_offered_export").val(data.cartons_offered).trigger('change');
                $("#comment_export").val(data.comment).trigger('change');

                $('a[href="#offer_details_export"]').tab('show');

            },
            error: function (returnData) {
                obj = JSON.parse(returnData);
                notification(obj);
            }
        });
    });

    $("#form_export_offer_details").validate({
        rules: {

            offer_id_export: {
                required: true,
            },
            product_id_export: {
                required: true,
            },
            product_price_export: {
                required: true,
            },
            quantity_offered_export: {
                required: true,
            },
            unit_id_export: {
                required: true, 
            }
        },
        messages: {
            
        }
    });

    $('#form_export_offer_details').ajaxForm({
        beforeSubmit: function () {
            return $("#form_export_offer_details").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            console.log('RD => ' + returnData);
            obj = JSON.parse(returnData);

            $('#form_export_offer_details')[0].reset(); //reset form
            $("#form_export_offer_details select").select2("val", ""); 
            $("#form_export_offer_details").validate().resetForm(); 

            notification(obj);
            
            //refresh table
            $('#offer_details_table').DataTable().ajax.reload();
            
        }
    });

    $("#product_price_export, #quantity_offered_export").blur(function(){

        $product_price = $("#product_price_export").val();
        $quantity_offered = $("#quantity_offered_export").val();
        $val = parseFloat($product_price) * parseFloat($quantity_offered);
        $("#total_value_export").val($val.toFixed(2));
    });

    // DELETE
    
    $(document).on('click', '.delete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){
            $pk = $(this).attr('data-pk');
            
            $.ajax({
                url: "<?= base_url('admin/del-row-offer-details/') ?>",
                dataType: 'json',
                type: 'POST',
                data: {pk: $pk},
                success: function (returnData) {
                    console.log(returnData);
                    $this.closest('tr').remove();
                    
                    // obj = JSON.parse(returnData);
                    notification(returnData);
                    //refresh table
                    $("#offer_details_table").DataTable().ajax.reload();

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }        
    });
    
    $(document).on('click', '.delete-file', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){
            $pk = $(this).data('upload_id');
            
            $.ajax({
                url: "<?= base_url('admin/del-row-offer-files/') ?>",
                dataType: 'json',
                type: 'POST',
                data: {pk: $pk},
                success: function (returnData) {
                    console.log(returnData);
                    // $this.closest('a').remove();
                    
                    // obj = JSON.parse(returnData);
                    notification(returnData);
                    

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }        
    });

    // Clone area

    $(document).on('click', '.offer_details_clone_btn', function(){
        $this = $(this);
        $od_id = $(this).data('od_id');
        
        $.ajax({
            url: "<?= base_url('admin/fetch-offer-details-on-pk/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {pk: $od_id},
            success: function (returnData) {
                console.log(returnData);                
                data = returnData[0];

                $("#product_id").val(data.product_id).trigger('change');
                $("#product_price").val(data.product_price).trigger('change');
                $("#freezing_id").val(data.freezing_id).trigger('change');
                $("#freezing_method_id").val(data.freezing_method_id).trigger('change');
                $("#primary_packing_type_id").val(data.primary_packing_type_id).trigger('change');
                $("#secondary_packing_type_id").val(data.secondary_packing_type_id).trigger('change');
                $("#packing_size_id").val(data.packing_size_id).trigger('change');
                $("#glazing_id").val(data.glazing_id).trigger('change');
                $("#block_id").val(data.block_id).trigger('change');
                $("#size_id").val(data.size_id).trigger('change');
                $("#size_before_glaze").val(data.size_before_glaze).trigger('change');
                $("#size_after_glaze").val(data.size_after_glaze).trigger('change');
                $("#quantity_offered").val(data.quantity_offered).trigger('change');
                $("#unit_id").val(data.unit_id).trigger('change');
                $("#total_value").val((parseFloat(data.product_price) * parseFloat(data.quantity_offered)).toFixed(2)).trigger('change');
                $("#pieces").val(data.pieces).trigger('change');
                $("#grade").val(data.grade).trigger('change');
                $("#cartons_offered").val(data.cartons_offered).trigger('change');
                $("#comment").val(data.comment).trigger('change');

                $('a[href="#offer_details_add"]').tab('show');

            },
            error: function (returnData) {
                obj = JSON.parse(returnData);
                notification(obj);
            }
        });        
    });
    
    $sacc = $("#selected_acc_master_id").val().split(',');
    $('#acc_master_id').select2('val', $sacc).change();
    // Destination country show
    $sdc = $("#selected_destination_countries").val().split(',');
    $('#destination_c_id').select2('val', $sdc).change();


    // Pricing section

    $(document).on('click', '.offer_details_pricing_btn', function(){
        
        $odid = $(this).data('od_id');
        $ofid = $(this).data('offer_id');

        $.confirm({

            title: 'Set Buying / Selling Price',
            content: 'Choose pricing methods from the below options',
            buttons: {
                buy: {
                    text: 'Buying Price',
                    btnClass: 'btn-blue',
                    keys: ['enter', 'shift'],
                    action: function(){
                        window.open("<?= base_url() ?>admin/offer-buying-price/"+ $ofid + "/" + $odid, "_blank");
                    }
                },
                sell: {
                    text: 'Selling Price',
                    btnClass: 'btn-warning',
                    keys: ['enter', 'shift'],
                    action: function(){
                        window.open("<?= base_url() ?>admin/offer-selling-price/"+ $ofid + "/" + $odid, "_blank");
                    }
                },

                cancel: function () {}

            }

        });
    });


    

    // toastr notification
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
