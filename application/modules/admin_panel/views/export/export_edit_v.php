
<?php
// echo '<pre>', print_r($export_details), '</pre>';die;
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->
    <style>
        .form-horizontal .control-label, label{font-weight:bold}
        .form-control, select,.select2-drop-mask{border:1px solid green;}
    </style>
</head>

<body class="sticky-header">
<?php //echo "<pre>"; print_r($export_details); die(); ?>
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
                <form autocomplete="off" id="" method="post" action="<?=base_url('admin/form-edit-export')?>" enctype="multipart/form-data" class=" form-horizontal tasi-form" autocomplete="on">
                    <input type="hidden" value="<?=$export_details->export_id?>" name="export_id">
                    <div class="col-lg-12">
                        <section class="panel">
                            <div class="panel-body">
                                 <div class="row">
                                     <div class="col-lg-3 text-center">
                                       <h4 style="border: 1px solid;background: #64ae64;font-weight: bold; color: white;">Complete</h4>  
                                     </div>
                                     <div class="col-lg-3 text-center">
                                        <h4 style="border: 1px solid;background: #dfdfa5;font-weight: bold;">Partially blank</h4> 
                                     </div>
                                     <div class="col-lg-3 text-center">
                                        <h4 style="border: 1px solid;background: #b94b4b;font-weight: bold; color: white;">Blank</h4> 
                                     </div>
                                 </div>
                            </div>
                        </section>
                    </div>
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" id="common_freeze_head">
                            Common Freeze
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="form-group row" id="common_freeze">
                                 <div class="form-group row">
                                    <div class="col-lg-3" style="margin:auto">
                                        <?php //echo "<pre>"; print_r($offers); die(); ?>
                                        <label for="row_colour" class="control-label">Row Colour</label>
                                        <select name="row_colour" id="row_colour" name="row_colour" class="form-control">
                                            <option selected value="">Select Colour</option>
                                            <?php foreach ($colours as $c) {?>
                                            <option <?= ($c->color_id == $export_details->row_colour) ? 'selected' : '' ?> style="background:<?=$c->color_hex_code?>" value="<?= $c->color_id ?>"><?php echo $c->color_name. '['. $c->color_hex_code.']'; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    
                                    <div class="col-lg-3" style="margin:auto">
                                        <?php //echo "<pre>"; print_r($offers); die(); ?>
                                        <label for="company" class="control-label">Company</label>
                                        <select name="company" id="company" name="company" class="form-control">
                                            <option selected value="">Select Company</option>
                                            <option <?= ($export_details->company == 'FSG') ? 'selected' : '' ?> value="FSG">FSG</option>
                                            <option <?= ($export_details->company == 'SFME') ? 'selected' : '' ?> value="SFME">SFME</option>
                                            <option <?= ($export_details->company == 'Other') ? 'selected' : '' ?> value="Other">Other</option>
                                        </select>
                                    </div>
                                     
                                    <div class="col-lg-6 text-center">
                                        <h5><u>Supplier Name: <b><?=$export_details->name?></b></u></h5>
                                        <!--<label for="supplier_id" class="control-label">Supplier name</label>-->
                                        <!--<select name="supplier_id" id="supplier_id" name="supplier_id" class="form-control">-->
                                        <!--    <option selected value="">Select Supplier</option>-->
                                        <!--    <?php foreach ($suppliers as $s) {?>-->
                                        <!--        <option value="<?= $s->am_id ?>"><?php echo $s->name. '['. $s->am_code.']'; ?></option>-->
                                        <!--    <?php } ?>-->
                                        <!--</select>-->
                                    </div>
                                 </div>
                                 
                                 <div class="col-lg-3">
                                    <label for="offer_id" class="control-label text-danger">Offer Name *</label>
<!-- select2-->
                                    <select id="offer_id" name="offer_id" required class="form-control" >
                                        <!--<option selected>Select Offer</option>-->
                                        <?php foreach ($offers as $offer) {?>
                                            <option value="<?php echo $offer->offer_id ?>" <?php echo ($export_details->offer_id == $offer->offer_id)?'selected':'disabled'; ?>><?php echo $offer->offer_name.'['. $offer->offer_fz_number.']'; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="fz_ref_no" class="control-label">FZ Ref #</label>
                                    <input readonly id="fz_ref_no" value="<?=$export_details->fz_ref_no?>" name="fz_ref_no" type="text" placeholder="FZ Ref No" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="partial_reference" class="control-label">Partial Ref #</label>
                                    <input  id="partial_reference" value="<?=$export_details->partial_reference?>" name="partial_reference" type="text" placeholder="FZ Ref No" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="vend_pi" class="control-label">VEND PI</label>
                                    <input  id="vend_pi" name="vend_pi" value="<?=$export_details->vend_pi?>" type="text" placeholder="VEND PI" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="vend_inv_amt" class="control-label">VEND INV AMT</label>
                                    <input  id="vend_inv_amt" name="vend_inv_amt" value="<?=$export_details->vend_inv_amt?>" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="VEND INV AMT" class="form-control" />
                                </div>

                                <div class="col-lg-3">
                                    <label for="vend_inv_amt_currency" class="control-label">Currency</label>
                                    <select id="vend_inv_amt_currency" name="vend_inv_amt_currency" class="form-control">
                                        <option selected value="">Select Currency</option>
                                        <?php foreach ($currencies as $currency) { ?>
                                            <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->vend_inv_amt_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="vend_po_conf" class="control-label">Vend PO Conf</label>
                                    <input  id="vend_po_conf" name="vend_po_conf" value="<?=$export_details->vend_po_conf?>" type="text" placeholder="Vend PO Conf" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="cust_inco_id" class="control-label">Cust Inco</label>
                                    <select id="cust_inco_id" name="cust_inco_id" class="form-control " >
                                        <option selected>Select Incoterm</option>
                                        <?php foreach ($incoterms as $incoterm) {?>
                                            <option value="<?php echo $incoterm->it_id ?>" <?php echo ($export_details->cust_inco_id == $incoterm->it_id)?'selected':''; ?>><?php echo $incoterm->incoterm ?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="pymt_terms_cust_id" class="control-label">PAYT TERMS CUST</label>
                                    <input  id="pymt_terms_cust_id" name="pymt_terms_cust_id" value="<?=$export_details->pymt_terms_cust_id?>" type="text" title="Enter number" placeholder="PAYT TERMS CUST" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="responsible_purchase_id" class="control-label">Responsible Purchase</label>
                                    <select name="responsible_purchase_id" id="responsible_purchase_id" class="form-control">
                                        <option value="">Select Responsible Purchase</option>
                                         <?php foreach ($responsible_purchase as $responsible_purchase) {?>
                                            <option value="<?php echo $responsible_purchase->responsible_purchase_id ?>"<?php echo ($export_details->responsible_purchase_id == $responsible_purchase->responsible_purchase_id)?'selected':''; ?>><?php echo $responsible_purchase->name ?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="responsible_sale_id" class="control-label"> Responsible Sale </label>
                                    <select name="responsible_sale_id" id="responsible_sale_id" class="form-control">
                                        <option value="">Select Responsible Sale</option>
                                        <?php foreach ($responsible_sales as $responsible_sale) {?>
                                            <option value="<?php echo $responsible_sale->responsible_sales_id ?>" <?php echo ($export_details->responsible_sale_id == $responsible_sale->responsible_sales_id)?'selected':''; ?>><?php echo $responsible_sale->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="responsible_logistics_id" class="control-label"> Responsible Logistics </label>
                                    <select name="responsible_logistics_id" id="responsible_logistics_id" class="form-control">
                                        <option value="">Select Responsible Logistics</option>
                                        <?php foreach ($responsible_logistic as $responsible_logistic) {?>

                                            <option value="<?php echo $responsible_logistic->responsible_logistic_id ?>" <?php echo ($export_details->responsible_logistics_id == $responsible_logistic->responsible_logistic_id)?'selected':''; ?>><?php echo $responsible_logistic->name ?></option>

                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                                <!-- <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="submit" name="submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>   -->                             
                        </div>
                    </section>
                </div>
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" id="contractual_head">
                            Contractual
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="form-group row" id="contractual">
                                <div class="col-lg-3">
                                    <label for="cust_po_no" class="control-label">CUST PO #</label>
                                    <input  id="cust_po_no" name="cust_po_no" value="<?=$export_details->cust_po_no?>" type="text" placeholder="CUST PO #" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="cust_pi_conf" class="control-label">Cust PI Conf</label>
                                    <input  id="cust_pi_conf" name="cust_pi_conf" value="<?=$export_details->cust_pi_conf?>" type="text" placeholder="Cust PI Conf" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                    <label for="latest_dos" class="control-label">Latest DOS</label>
                                    <input  id="latest_dos" name="latest_dos" type="date" value="<?=$export_details->latest_dos?>" placeholder="Latest DOS" class="form-control" />
                                </div>
                            </div>
                                <!-- <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="submit" name="submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>   -->                             
                        </div>
                    </section>
                </div>
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" id="shipment_docs_head">
                            Shipment/DOCS
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="form-group row" id="shipment_docs">
                                <div class="col-lg-3">
                                    <label for="rlink_for_bl_to_appear" class="control-label"> Hyperlink for BL to appear </label>
                                    <input  id="rlink_for_bl_to_appear" value="<?=$export_details->rlink_for_bl_to_appear?>" name="rlink_for_bl_to_appear" type="text" placeholder="Hyperlink for BL to appear" class="form-control" />
                                </div>
                                <div class="col-lg-3">
                                        <label for="besc_applied" class="control-label"> BESC / Others - Appld </label>
                                        <select name="besc_applied" id="besc_applied" class="form-control">
                                            <option value="">Select BESC / Others- Appld </option>
                                            <option value="Yes" <?php echo ($export_details->besc_applied == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->besc_applied == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->besc_applied == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="bl_no" class="control-label">BL No</label>
                                        <input  id="bl_no" name="bl_no" type="text" value="<?=$export_details->bl_no?>" placeholder="BL No" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="corrc_appr_by_cust" class="control-label"> Corrc Appr by Cust </label>
                                        <select name="corrc_appr_by_cust" id="corrc_appr_by_cust" class="form-control">
                                            <option value=""> Select Draft Docs Recd  </option>
                                             <option value="Yes" <?php echo ($export_details->corrc_appr_by_cust == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->corrc_appr_by_cust == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->corrc_appr_by_cust == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="corrc_appr_cust_date" class="control-label"> Recd Date </label>
                                        <input  id="corrc_appr_cust_date" name="corrc_appr_cust_date" value="<?=$export_details->corrc_appr_cust_date?>" type="date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="corrc_appr_to_vend" class="control-label"> Corrc Appr to Vend  </label>
                                        <select name="corrc_appr_to_vend" id="corrc_appr_to_vend" class="form-control">
                                            <option value="">Select Draft Docs Recd  </option>
                                             <option value="Yes" <?php echo ($export_details->corrc_appr_to_vend == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->corrc_appr_to_vend == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->corrc_appr_to_vend == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="correc_appr_vend_date" class="control-label"> Sent Date </label>
                                        <input  id="correc_appr_vend_date" name="correc_appr_vend_date" value="<?=$export_details->correc_appr_vend_date?>" type="date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="docs_sent_to_sgs_for_clean_cer" class="control-label"> DOCS TO SGS/ITS (CEAN CERT) </label>
                                        <input  id="docs_sent_to_sgs_for_clean_cer" value="<?=$export_details->docs_sent_to_sgs_for_clean_cer?>" name="docs_sent_to_sgs_for_clean_cer" type="text" placeholder="DOCS TO SGS/ITS (CEAN CERT)"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="draft_docs_recd" class="control-label"> Draft Docs Recd  </label>
                                        <select name="draft_docs_recd" id="draft_docs_recd" class="form-control">
                                            <option value="">Select Draft Docs Recd  </option>
                                            <option value="Yes" <?php echo ($export_details->draft_docs_recd == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->draft_docs_recd == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->draft_docs_recd == 'N/A')?'selected':''; ?> >N/A</option>

                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="draft_docs_recd_date" class="control-label">Recd Date </label>
                                        <input  id="draft_docs_recd_date" name="draft_docs_recd_date" value="<?=$export_details->draft_docs_recd_date?>" type="date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="draft_docs_sent" class="control-label"> Draft Docs Sent  </label>
                                        <select name="draft_docs_sent" id="draft_docs_sent" class="form-control">
                                            <option value="">Select Draft Docs Recd  </option>
                                            <option value="Yes" <?php echo ($export_details->draft_docs_sent == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->draft_docs_sent == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->draft_docs_sent == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="draft_docs_sent_date" class="control-label"> Sent Date </label>
                                        <input  id="draft_docs_sent_date" name="draft_docs_sent_date" value="<?=$export_details->draft_docs_sent_date?>" type="date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="final_docs_submitted" class="control-label"> Final Docs Submitted (LC) </label>
                                        <input  id="final_docs_submitted" value="<?=$export_details->final_docs_submitted?>" name="final_docs_submitted" type="text" placeholder="Final Docs Submitted (LC)"  class="form-control lc_amt_recd" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="final_copy_cust" class="control-label"> Final Copy-Cust </label>
                                        <select name="final_copy_cust" id="final_copy_cust" class="form-control">
                                            <option value=""> Select Final Copy-Cust  </option>
                                            <option value="Yes" <?php echo ($export_details->final_copy_cust == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->final_copy_cust == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->final_copy_cust == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="final_copy_cust_date" class="control-label"> Sent Date </label>
                                        <input  id="final_copy_cust_date" value="<?=$export_details->final_copy_cust_date?>" name="final_copy_cust_date" type="date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="final_copy_vend" class="control-label"> Final Copy-Vend </label>
                                        <select name="final_copy_vend" id="final_copy_vend" class="form-control">
                                            <option value=""> Select Final Copy-Vend  </option>
                                            <option value="Yes" <?php echo ($export_details->final_copy_vend == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->final_copy_vend == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->final_copy_vend == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div> 


                                    <div class="col-lg-3">
                                        <label for="final_copy_vend_date" class="control-label"> Recd Date </label>
                                        <input  id="final_copy_vend_date" value="<?=$export_details->final_copy_vend_date?>" name="final_copy_vend_date" type="date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="freight_agent" class="control-label">Freight Agent</label>
                                        <input  id="freight_agent" name="freight_agent" value="<?=$export_details->freight_agent?>" type="text" placeholder="Freight Agent" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="freight_invoice_no" class="control-label">Freight Inv #</label>
                                        <input  id="freight_invoice_no" value="<?=$export_details->freight_invoice_no?>" name="freight_invoice_no" type="text" placeholder="Freight Inv #" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="insp_license_number" class="control-label">Insp / Imp Lic No</label>
                                        <input  id="insp_license_number" value="<?=$export_details->insp_license_number?>" name="insp_license_number" type="text" placeholder="Insp / Imp Lic No" class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="label_appr_cust" class="control-label">LABEL APPR CUST</label>
                                        <input  id="label_appr_cust" name="label_appr_cust" value="<?=$export_details->label_appr_cust?>" type="text" placeholder="LABEL APPR CUST" class="form-control" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="label_appr_vend" class="control-label">LABEL APPR VEND</label>
                                        <input  id="label_appr_vend" name="label_appr_vend" value="<?=$export_details->label_appr_vend?>" type="text" placeholder="LABEL APPR VEND" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="org_docs_cust" class="control-label"> Org Docs- Cust </label>
                                        <select name="org_docs_cust" id="org_docs_cust" class="form-control">
                                            <option value=""> Select Org Docs- Cust   </option>
                                            <option value="Yes" <?php echo ($export_details->org_docs_cust == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->org_docs_cust == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->org_docs_cust == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="org_docs_cust_date" class="control-label"> Sent Date </label>
                                        <input  id="org_docs_cust_date" value="<?=$export_details->org_docs_cust_date?>" name="org_docs_cust_date" type="date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="org_docs_vend" class="control-label"> Org Docs- Vend </label>
                                        <select name="org_docs_vend" id="org_docs_vend" class="form-control">
                                            <option value=""> Select Org Docs- Vend   </option>
                                           <option value="Yes" <?php echo ($export_details->org_docs_vend == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->org_docs_vend == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->org_docs_vend == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="org_docs_vend_date" class="control-label"> Recd Date </label>
                                        <input  id="org_docs_vend_date" value="<?=$export_details->org_docs_vend_date?>" name="org_docs_vend_date" type="date"  class="form-control " />
                                    </div>
                                     <div class="col-lg-3">
                                        <label for="sale_contract" class="control-label">Sale Contract #</label>
                                        <input  id="sale_contract" value="<?=$export_details->sale_contract?>" name="sale_contract" type="text" placeholder="Sale Contract" class="form-control" />
                                    </div>


                                   <div class="col-lg-3">
                                        <label for="sc_qty" class="control-label">SC Qty</label>
                                        <input id="sc_qty" name="sc_qty" value="<?=$export_details->sc_qty?>" type="text" placeholder="SC Qty" class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="pi_sales_amt" class="control-label">PI Sales Amt</label>
                                        <input  id="pi_sales_amt" name="pi_sales_amt" value="<?=$export_details->pi_sales_amt?>" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="PI Sales Amt" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="pi_sales_amt_currency" class="control-label">Currency</label>
                                        <select id="pi_sales_amt_currency" name="pi_sales_amt_currency" class="form-control">
                                            <option selected value="">Select Currency</option>
                                            <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->pi_sales_amt_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="po_purch_amt" class="control-label">PO Purch Amt</label>
                                        <input  id="po_purch_amt" name="po_purch_amt" value="<?=$export_details->po_purch_amt?>" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="PI Sales Amt" class="form-control" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="po_purch_amt_currency" class="control-label">Currency</label>
                                        <select id="po_purch_amt_currency" name="po_purch_amt_currency" class="form-control">
                                            <option selected value="">Select Currency</option>
                                            <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->po_purch_amt_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="qty_loaded" class="control-label">Qty Loaded</label>
                                        <input  id="qty_loaded" value="<?=$export_details->qty_loaded?>"  name="qty_loaded" type="text" placeholder="Qty Loaded" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="3rd_insp_upload" class="control-label">3rd INSP Upload</label>
                                        <input  id="3rd_insp_upload" value="" name="3rd_insp_upload" type="date" placeholder="3rd INSP Upload" class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="insp_aoc_coc" class="control-label">Insp. AOC / COC</label>
                                        <input  id="insp_aoc_coc" name="insp_aoc_coc" type="text" value="<?=$export_details->insp_aoc_coc?>" placeholder="Insp. AOC / COC" class="form-control" />
                                    </div>


                                     <div class="col-lg-3">
                                        <label for="aoc_coc_date" class="control-label">AOC / COC Date</label>
                                        <input  id="aoc_coc_date" name="aoc_coc_date" type="date" value="<?=$export_details->aoc_coc_date?>" placeholder="AOC / COC Date" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="dayes_delayed" class="control-label">Days Delayed</label>
                                        <input  id="dayes_delayed" name="dayes_delayed" type="text" value="<?=$export_details->dayes_delayed?>" readonly placeholder="Days Delayed" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="rem_dayes_for_shipt" class="control-label">Rem. Days for Shipt</label>
                                        <input  id="rem_dayes_for_shipt" name="rem_dayes_for_shipt" value="<?=$export_details->rem_dayes_for_shipt?>" type="text" readonly placeholder="Rem. Days for Shipt" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="besc_others_no" class="control-label">BESC / Others- #</label>
                                        <input  id="besc_others_no" name="besc_others_no" value="<?=$export_details->besc_others_no?>" type="text" placeholder="BESC / Others- #" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="check_list_applied" class="control-label"> Check-List Applied </label>
                                        <input  id="check_list_applied" name="check_list_applied" value="<?=$export_details->check_list_applied?>" type="text" placeholder="Check-List Applied" class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="doc_courier_no_incoming" class="control-label"> Doc Courier- # (Incoming) </label>
                                        <input  id="doc_courier_no_incoming" value="<?=$export_details->doc_courier_no_incoming?>" name="doc_courier_no_incoming" type="text" placeholder="Doc Courier- # (Incoming)"  class="form-control " />
                                    </div> 

                                    <div class="col-lg-3">
                                        <label for="doc_courier_no_outgoing" class="control-label"> Doc Courier- # (Outgoing) </label>
                                        <input  id="doc_courier_no_outgoing" value="<?=$export_details->doc_courier_no_outgoing?>" name="doc_courier_no_outgoing" type="text" placeholder="Doc Courier- # (Outgoing)"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="container_discharge_date" class="control-label"> Container Discharge Date </label>
                                        <input  id="container_discharge_date" value="<?=$export_details->container_discharge_date?>" name="container_discharge_date" type="date" placeholder="Container Discharge Date"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="doc_recd" class="control-label"> DOC RECD(FAX) </label>
                                        <input  id="doc_recd" name="doc_recd" type="text" value="<?=$export_details->doc_recd?>" placeholder="DOC RECD(FAX)"  class="form-control " />
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <label for="ata" class="control-label"> ATA </label>
                                        <input  id="ata" value="<?=$export_details->ata?>" name="ata" type="date" placeholder="ATA"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="atd" class="control-label"> ATD </label>
                                        <input  id="atd" value="<?=$export_details->atd?>" name="atd" type="date" placeholder="ATD"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="svd" class="control-label"> SVD </label>
                                        <input  id="svd" name="svd" type="text" value="<?=$export_details->svd?>" placeholder="SVD"  class="form-control " />
                                    </div>


                            </div>
                                <!-- <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="submit" name="submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>   -->                             
                        </div>
                    </section>
                </div>
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" id="docs_file_head">
                            DOCS File
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="form-group row" id="docs_file">
                                <div class="col-lg-3">
                                        <label for="insp_sr_applied" class="control-label"> INSP SR Applied </label>
                                        <select name="insp_sr_applied" id="insp_sr_applied" class="form-control">
                                            <option value="">Select INSP SR Applied </option>

                                            <option value="Yes" <?php echo ($export_details->insp_sr_applied == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->insp_sr_applied == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->insp_sr_applied == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="insp_sr_number" class="control-label">Insp. SR #</label>
                                        <input  id="insp_sr_number" name="insp_sr_number" value="<?=$export_details->insp_sr_number?>" type="text" placeholder="Insp. SR #" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->invoice_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->invoice_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="invoice_file" class="control-label">Upload Invoice</label>
                                        <input  id="invoice_file" name="invoice_file" value="<?=$export_details->invoice_file?>" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->packing_list_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->packing_list_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="packing_list_file" class="control-label">Upload Packing List</label>
                                        <input  id="packing_list_file" value="<?=$export_details->packing_list_file?>" name="packing_list_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->health_cer_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->health_cer_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="health_cer_file" class="control-label">Upload Health Certificate</label>
                                        <input  id="health_cer_file" value="<?=$export_details->health_cer_file?>" name="health_cer_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->bill_of_leading ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->bill_of_leading ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="bill_of_leading" class="control-label">Upload Bill of Leading</label>
                                        <input  id="bill_of_leading" value="<?=$export_details->bill_of_leading?>" name="bill_of_leading" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->sgs_cert ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->sgs_cert ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="sgs_cert" class="control-label">Upload SGS Certificate</label>
                                        <input  id="sgs_cert" value="<?=$export_details->sgs_cert?>" name="sgs_cert" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->feri_cert ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->feri_cert ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="feri_cert" class="control-label">Upload FERI Certificate</label>
                                        <input  id="feri_cert" value="<?=$export_details->feri_cert?>" name="feri_cert" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">

                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->insp_report_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->insp_report_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="insp_report_file" class="control-label">Upload Inspection Report</label>
                                        <input  id="insp_report_file" value="<?=$export_details->insp_report_file?>" name="insp_report_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->besc_cert_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->besc_cert_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="besc_cert_file" class="control-label">Upload BESC Certificate</label>
                                        <input  id="besc_cert_file" value="<?=$export_details->besc_cert_file?>" name="besc_cert_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->appr_label_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->appr_label_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="appr_label_file" class="control-label">Upload Approved Label</label>
                                        <input  id="appr_label_file" value="<?=$export_details->appr_label_file?>" name="appr_label_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->confirmed_po_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->confirmed_po_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="confirmed_po_file" class="control-label">Upload Confirmed PO</label>
                                        <input  id="confirmed_po_file" value="<?=$export_details->confirmed_po_file?>" name="confirmed_po_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->confirmed_pi_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->confirmed_pi_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="confirmed_pi_file" class="control-label">Upload Confirmed PI</label>
                                        <input  id="confirmed_pi_file" value="<?=$export_details->confirmed_pi_file?>" name="confirmed_pi_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->micrbiology_report_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->micrbiology_report_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="micrbiology_report_file" class="control-label">Upload Micrbiology Report</label>
                                        <input  id="micrbiology_report_file" value="<?=$export_details->micrbiology_report_file?>" name="micrbiology_report_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->other_export_report_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->other_export_report_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="other_export_report_file" class="control-label">Upload Other Export Document</label>
                                        <input  id="other_export_report_file" value="<?=$export_details->other_export_report_file?>" name="other_export_report_file" type="file" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <br><br>
                                        <img src="<?= base_url('upload/export') .'/' . $export_details->any_other_quality_report_file ?>" style="height:75px;margin-bottom: 7px;"> 
                                        <br><br>
                                        <a title="Download / View" class="btn btn-primary" style="padding:5px 10px" href="<?= base_url('upload/export') .'/' . $export_details->any_other_quality_report_file ?>" class="" download>
                                            <i class="fa fa-download"></i>
                                        </a>
                                        <br>
                                        <label for="any_other_quality_report_file" class="control-label">Upload Any other quality report</label>
                                        <input  id="any_other_quality_report_file" value="<?=$export_details->any_other_quality_report_file?>" name="any_other_quality_report_file" type="file" class="form-control" />
                                    </div>
                            </div>
                                <!-- <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="submit" name="submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>   -->                             
                        </div>
                    </section>
                </div>
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" id="payment_head">
                            Payment
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="form-group row" id="payment">
                                <div class="col-lg-3">
                                        <label for="adv_amt_from_cust" class="control-label">Adv Amt from Cust</label>
                                        <input  id="adv_amt_from_cust" name="adv_amt_from_cust" value="<?=$export_details->adv_paid_to_vendor?>" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="Adv Amt from Cust" class="form-control" />
                                    </div>


                                    <div class="col-lg-3">
                                        <label for="adv_amt_cust_currency" class="control-label">Currency</label>
                                        <select id="adv_amt_cust_currency" name="adv_amt_cust_currency" class="form-control">
                                            <option selected value="">Select Currency</option>
                                            <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->adv_amt_cust_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="advise_received_from_bank" class="control-label"> BANK ADVICE RCPT </label>
                                        <input  id="advise_received_from_bank" value="<?=$export_details->advise_received_from_bank?>" name="advise_received_from_bank" type="text"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="adv_paid_to_vendor" class="control-label">Adv Paid to Vendor</label>
                                        <input  id="adv_paid_to_vendor" name="adv_paid_to_vendor" value="<?=$export_details->adv_paid_to_vendor?>" type="number" pattern="[0-9]{10}" title="Enter number" placeholder=" Adv Amt to Vendor" class="form-control" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="adv_paid_vend_currency" class="control-label">Currency</label>
                                        <select id="adv_paid_vend_currency" name="adv_paid_vend_currency" class="form-control">
                                            <option selected value="">Select Currency</option>
                                            <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->adv_paid_vend_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="adv_amt_to_vendor" class="control-label">Adv Amt to Vendor</label>
                                        <input  id="adv_amt_to_vendor" value="<?=$export_details->adv_amt_to_vendor?>" name="adv_amt_to_vendor" type="number" pattern="[0-9]{10}" title="Enter number" placeholder=" Adv Amt to Vendor" class="form-control" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="adv_amt_vend_currency" class="control-label">Currency</label>
                                        <select id="adv_amt_vend_currency" name="adv_amt_vend_currency" class="form-control">
                                            <option selected value="">Select Currency</option>
                                            <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->adv_amt_vend_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="adv_recd_from_cust" class="control-label">Adv Recd from Cust</label>
                                        <input  id="adv_recd_from_cust" name="adv_recd_from_cust" value="<?=$export_details->adv_paid_to_vendor?>" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="Adv Amt from Cust" class="form-control" />
                                    </div>


                                     <div class="col-lg-3">
                                        <label for="adv_recd_from_cust_currency" class="control-label">Currency</label>
                                        <select id="adv_recd_from_cust_currency" name="adv_recd_from_cust_currency" class="form-control">
                                            <option selected value="">Select Currency</option>
                                            <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->adv_recd_from_cust_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="cr_note_to_cust" class="control-label"> CR NOTE TO CUST  </label>
                                        <input  id="cr_note_to_cust" value="<?=$export_details->cr_note_to_cust?>" name="cr_note_to_cust" type="text" placeholder="CR NOTE TO CUST"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="cr_note_to_supp" class="control-label"> CR NOTE TO SUPP </label>
                                        <input  id="cr_note_to_supp" value="<?=$export_details->cr_note_to_supp?>" name="cr_note_to_supp" type="text" placeholder="CR NOTE TO SUPP"  class="form-control " />
                                    </div> 
                                    <div class="col-lg-3">
                                        <label for="dbt_note_to_cust" class="control-label"> DBT NOTE TO CUST </label>
                                        <input  id="dbt_note_to_cust" value="<?=$export_details->dbt_note_to_cust?>" name="dbt_note_to_cust" type="text" placeholder="DBT NOTE TO CUST"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="dbt_note_to_supp" class="control-label"> DBT NOTE TO SUPP </label>
                                        <input  id="dbt_note_to_supp" value="<?=$export_details->dbt_note_to_supp?>" name="dbt_note_to_supp" type="text" placeholder="DBT NOTE TO SUPP"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="dbt_note_cust_comm" class="control-label"> DBT NOTE CUST(COMM) </label>
                                        <input  id="dbt_note_cust_comm" value="<?=$export_details->dbt_note_cust_comm?>" name="dbt_note_cust_comm" type="text" placeholder="DBT NOTE CUST(COMM)"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="lc_amt_recd" class="control-label"> LC AMD RECD </label>
                                        <input  id="lc_amt_recd" name="lc_amt_recd" value="<?=$export_details->lc_amt_recd?>" type="text" placeholder="LC AMD RECD"  class="form-control lc_amt_recd" />
                                    </div>
                                     <div class="col-lg-3">
                                        <label for="lc_amd_reqd" class="control-label"> LC AMD REQD </label>
                                        <input  id="lc_amd_reqd" name="lc_amd_reqd" value="<?=$export_details->lc_amd_reqd?>" type="text" placeholder="LC AMD REQD"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="lc_amd_transfer" class="control-label"> LC AMD/TRANSFER </label>
                                        <input  id="lc_amd_transfer" name="lc_amd_transfer" value="<?=$export_details->lc_amd_transfer?>" type="text"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="lc_critical_condition" class="control-label"> LC CRITICAL CONDITION </label>
                                        <input  id="lc_critical_condition" value="<?=$export_details->lc_critical_condition?>" name="lc_critical_condition" type="text" placeholder="LC CRITICAL CONDITION"  class="form-control lc_amt_recd" />
                                    </div>
                                     <div class="col-lg-3">
                                        <label for="lc_doc_submission_date" class="control-label"> LC DOC SUBM DT </label>
                                        <input  id="lc_doc_submission_date" value="<?=$export_details->lc_doc_submission_date?>" name="lc_doc_submission_date" type="date" placeholder="LATEST DOS (LC)"  class="form-control lc_amt_recd" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="lc_expiry_date" class="control-label"> LC EXP DT </label>
                                        <input  id="lc_expiry_date" name="lc_expiry_date" value="<?=$export_details->lc_expiry_date?>" type="date" placeholder="LC EXP DT"  class="form-control lc_amt_recd" />
                                    </div>
                                      <div class="col-lg-3">
                                        <label for="lc_recd_cust" class="control-label"> LC RECD CUST </label>
                                        <select name="lc_recd_cust" id="lc_recd_cust" class="form-control">
                                            <option value=""> Select LC RECD CUST  </option>
                                             <option value="Yes" <?php echo ($export_details->lc_recd_cust == 'Yes')?'selected':''; ?> >Yes</option>
                                            <option value="No" <?php echo ($export_details->lc_recd_cust == 'No')?'selected':''; ?> >No</option>
                                            <option value="N/A" <?php echo ($export_details->lc_recd_cust == 'N/A')?'selected':''; ?> >N/A</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="payment_by_supplier_comm" class="control-label"> PAYT BY SUPP (COMM) </label>
                                        <input  id="payment_by_supplier_comm" value="<?=$export_details->payment_by_supplier_comm?>" name="payment_by_supplier_comm" type="text" placeholder="PAYT BY SUPP (COMM)"  class="form-control " />
                                    </div>
                                <!-- <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="submit" name="submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>   -->                             
                        </div>
                    </section>
                </div>
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" id="information_head">
                            Information
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                            <div class="form-group row" id="information">
                                <div class="col-lg-3">
                                        <label for="actual_sale_amt" class="control-label">ACTUAL SALE AMT</label>
                                        <input  id="actual_sale_amt" name="actual_sale_amt" value="<?=$export_details->actual_sale_amt?>" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="ACTUAL SALE AMT" class="form-control" />
                                    </div> 

                                     <div class="col-lg-3">
                                        <label for="actual_sales_amt_currency" class="control-label">Currency</label>
                                        <select id="actual_sales_amt_currency" name="actual_sales_amt_currency" class="form-control">
                                            <option selected value="">Select Currency</option>
                                            <?php foreach ($currencies as $currency) { ?>
                                                <option value="<?php echo $currency->c_id ?>" <?php echo ($export_details->actual_sales_amt_currency == $currency->c_id)?'selected':''; ?> ><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="etd" class="control-label">ETD</label>
                                        <input  id="etd" name="etd" type="date" value="<?=$export_details->etd?>" placeholder="AOC / COC Date" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="eta" class="control-label">ETA</label>
                                        <input  id="eta" name="eta" type="date" value="<?=$export_details->eta?>" placeholder="AOC / COC Date" class="form-control" />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="admin_appr" class="control-label"> Admin Appr </label>
                                        <input  id="admin_appr" name="admin_appr" value="<?=$export_details->admin_appr?>" type="text" placeholder="Admin Appr"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="last_remark" class="control-label">Last Remark</label>
                                        <textarea id="last_remark"  name="last_remark" type="text" placeholder="Last Remark" class="form-control " cols="30" rows="5"><?=$export_details->last_remark?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="mrktng_appr" class="control-label"> Mrktg Appr </label>
                                        <input  id="mrktng_appr" name="mrktng_appr" value="<?=$export_details->mrktng_appr?>" type="text" placeholder="Admin Appr"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="resource_appr" class="control-label"> Rescrce Appr </label>
                                        <input  id="resource_appr" name="resource_appr" value="<?=$export_details->resource_appr?>" type="text" placeholder="Admin Appr"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark_for_outstation" class="control-label">Remark For Outstation</label>
                                        <textarea id="remark_for_outstation" name="remark_for_outstation" type="text" placeholder="Remark For Outstation" class="form-control " cols="30" rows="5"><?=$export_details->remark_for_outstation?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark_from_outstation" class="control-label">Remark From Outstation</label>
                                        <textarea id="remark_from_outstation" name="remark_from_outstation" type="text" placeholder="Remark From Outstation" class="form-control " cols="30" rows="5"><?=$export_details->remark_from_outstation?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark_admin_rp" class="control-label">Remark Admin RP</label>
                                        <textarea id="remark_admin_rp" name="remark_admin_rp" type="text" placeholder="Remark Admin RP" class="form-control " cols="30" rows="5"><?=$export_details->remark_admin_rp?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark_finan_rp" class="control-label">Remark Final RP</label>
                                        <textarea id="remark_finan_rp" name="remark_finan_rp" type="text" placeholder="Remark Sales RP" class="form-control " cols="30" rows="5"><?=$export_details->remark_finan_rp?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark_purch_rp" class="control-label">Remark Purch RP</label>
                                        <textarea id="remark_purch_rp" name="remark_purch_rp" type="text" placeholder="Remark Purch RP" class="form-control " cols="30" rows="5"><?=$export_details->remark_purch_rp?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="remark_sales_rp" class="control-label">Remark Sales RP</label>
                                        <textarea id="remark_sales_rp" name="remark_sales_rp" type="text" placeholder="Remark Sales RP" class="form-control " cols="30" rows="5"><?=$export_details->remark_sales_rp?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="think" class="control-label"> THINK </label>
                                        <input  id="think" name="think" type="text" value="<?=$export_details->think?>" placeholder="THINK"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="dox_remark" class="control-label">Dox Remark</label>
                                        <textarea id="dox_remark" name="dox_remark" type="text" placeholder="Dox Remark" class="form-control " cols="30" rows="5"><?=$export_details->dox_remark?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="shipt_remark" class="control-label">Shipt Remark</label>
                                        <textarea id="shipt_remark" name="shipt_remark" type="text" placeholder="Shipt Remark" class="form-control " cols="30" rows="5"><?=$export_details->shipt_remark?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="payment_remark" class="control-label">Payment Remark</label>
                                        <textarea id="payment_remark" name="payment_remark" type="text" placeholder="Payment Remark" class="form-control " cols="30" rows="5"><?=$export_details->payment_remark?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="collect_remark" class="control-label">Collect Remark</label>
                                        <textarea id="collect_remark" name="collect_remark" type="text" placeholder="Collect Remark" class="form-control " cols="30" rows="5"><?=$export_details->collect_remark?></textarea>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="general_remark" class="control-label">General Remark</label>
                                        <textarea id="general_remark" name="general_remark" type="text" placeholder="General Remark" class="form-control " cols="30" rows="5"><?=$export_details->general_remark?></textarea>
                                    </div>
                                     <div class="col-lg-3">
                                        <label for="accounts_appr" class="control-label"> Accounts Appr </label>
                                        <input  id="accounts_appr" value="<?=$export_details->accounts_appr?>" name="accounts_appr" type="text" placeholder="Accounts Appr"  class="form-control " />
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="accounts_appr" class="control-label"> No of Containers </label>
                                        <input  id="accounts_appr" value="<?=$export_details->no_of_container?>" name="no_of_container" type="text" placeholder="No of Container"  class="form-control " />
                                    </div>
                            </div>
                                <div class="form-group row">
                                    <div class="col-lg-3">
                                        <input type="submit" name="submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>                               
                        </div>
                    </section>
                </div>
                </form>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Export Product Quantity
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body">
                             <form autocomplete="off" id="form_export_product_qty" method="post" action="<?=base_url('admin/add-export-product-qty')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form" autocomplete="on">
                                <hr>
                                     <div class="form-group row text-right">
                                         <div class="col-lg-12">
                                            <input type="submit" name="submit" class="btn btn-success" value="Export save">
                                        </div>
                                    </div>  

                                    <input type="hidden" value="<?=@count($export_details_products)?>" name="product_count" id="product_count">

                                    <input type="hidden" value="<?=$export_details->export_id?>" name="export_id" id="export_id">

                                    <input type="hidden" name="offer_id_pd" id="offer_id_pd">

                                    
                            <?php foreach ($export_details_products as $key => $export_details_product) { ?>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label for="product_name_<?=$key?>" class="control-label text-danger">Product Number *</label>
                                            <input value="<?=$export_details_product['product_name']?>" id="product_name_<?=$key?>" readonly name="product_name_<?=$key?>" type="text" placeholder="Product Name" class="form-control round-input" />
 
                                            <input type="hidden" value="<?=$export_details_product['od_id']?>" name="od_id_<?=$key?>" id="product_id_<?=$key?>">


                                        </div>

                                        <div class="col-lg-3">
                                            <label for="pcs_<?=$key?>" class="control-label text-danger">Pcs</label>
                                            <input value="<?=$export_details_product['pieces']?>" id="pcs_<?=$key?>" readonly name="pcs_<?=$key?>" type="text" placeholder="Pcs" class="form-control round-input" />
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="grade_<?=$key?>" class="control-label text-danger">Grade</label>
                                            <input value="<?=$export_details_product['grade']?>" id="grade_<?=$key?>" readonly name="grade_<?=$key?>" type="text" placeholder="Grade" class="form-control round-input" />
                                        </div>


                                        <div class="col-lg-3">
                                            <label for="quantity_offered" class="control-label text-danger">Quantity Offered *</label>
                                            <input value="<?=$export_details_product['quantity_offered']?>" readonly id="quantity_offered_<?=$key?>" name="quantity_offered_<?=$key?>" type="text" placeholder="Quantity Offered" class="form-control round-input" />
                                        </div>

                                    </div>
                                    <br><br>
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label for="currency_<?=$key?>" class="control-label text-danger">Currency</label>
                                            <input value="<?=$export_details_product['currency']?> (<?=$export_details_product['symbol']?>)" id="currency_<?=$key?>" readonly name="currency_<?=$key?>" type="text" placeholder="Currency" class="form-control round-input" />
                                        </div>


                                        <div class="col-lg-3">
                                            <label for="no_of_pack_<?=$key?>" class="control-label text-danger">No Packing Size</label>
                                            <input value="<?=$export_details_product['packing_size']?>" id="no_of_pack_<?=$key?>" readonly name="no_of_pack_<?=$key?>" type="text" placeholder="Currency" class="form-control round-input" />
                                        </div>

                                        <div class="col-lg-3">
                                            <label for="cartons_quantity_deviation_<?=$key?>" class="control-label text-danger">Cartons & Quantity Deviation  </label>
                                            <input value="<?=number_format(($export_details_product['cartons_offered'] / $export_details_product['quantity_offered']),2)?>" id="cartons_quantity_deviation_<?=$key?>" readonly name="cartons_quantity_deviation_<?=$key?>" type="text" placeholder="Currency" class="form-control round-input" />
                                        </div>


                                        <div class="col-lg-3">
                                          <label for="qty_loaded" class="control-label text-danger"> Qty Loaded *</label>
                                          <input value="<?=(empty($loaded_qty1[$key]['qty_loaded'])?'0.00':$loaded_qty1[$key]['qty_loaded'])?>" id="qty_loaded_<?=$key?>" required name="qty_loaded_<?=$key?>" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" min="0" placeholder="Qty Loaded" max="<?=(int)$export_details_product['quantity_offered']?>" onblur="enforceMinMax(this)" class="form-control round-input" />  
                                        </div>

                                        <div class="col-lg-3">
                                          <label for="qty_loaded_date" class="control-label text-danger"> Qty Loaded Date *</label>
                                          <input  id="qty_loaded_date_<?=$key?>" value="<?=(empty($loaded_qty1[$key]['qty_loaded_date'])?'':$loaded_qty1[$key]['qty_loaded_date'])?>" required name="qty_loaded_date_<?=$key?>" type="date" placeholder="Qty Loaded Date" class="form-control round-input" />  
                                        </div>

                                        <div class="col-lg-3">
                                            <br>

                                          <a href="javascript:void(0)" onclick="getprice(<?=$export_details_product['od_id']?>);" class="btn btn-primary">Get Price</a>
                                        </div>

                                        
                                    </div>

                                    <br><br><br><br><br>
                            <?php } ?>
                            <hr>
                                     <div class="form-group row">
                                         <div class="col-lg-3">
                                            <input type="submit" name="submit" class="btn btn-success" value="Export save">
                                        </div>
                                    </div>  
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!--body wrapper end-->


<!-- Request modal -->
<div class="modal fade" id="myModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Price Details</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-6">
                            <table class="table  table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">Buying Price</th>                                 
                                </tr>
                              </thead>
                              <tbody id="buying_price_table">

                                  
                              </tbody>
                          </table>
                        </div>


                        <div class="col-lg-6">
                            <table class="table  table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">Selling Price</th>                                 
                                </tr>
                              </thead>
                              <tbody id="selling_price_table">

                                  
                              </tbody>
                          </table>
                        </div>

                        
                    </div>
                </div>
                <div></div>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- Request modal end -->
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>


    $(document).ready(function() {
        $('#customer').select2();
    });

    function getprice(pid) {
       // alert(pid);

       //$("#myModal").modal('show');

         $.ajax({
            url: "<?= base_url('admin/get_price_details'); ?>",
            dataType:"json",
            type: "post",
            data:{"pid":pid},
            success: function(data){
               //$('#fz_ref_no').val(data.fz_number);

               console.log(data);
               var buying_price_data = '';

                $.each(data.buying_price, function (index, value1) {
                    // final_buying_price
                 buying_price_data += "<tr>";

                 buying_price_data += "<td>"+  (parseFloat(value1.final_buying_price) +  parseFloat(value1.buying_price))+"</td>";

                 buying_price_data += "</tr>";
                });


                $("#buying_price_table").html(buying_price_data);


                var selling_price_data = '';

                $.each(data.selling_price, function (index, value2) {
                 selling_price_data += "<tr>";

                 selling_price_data += "<td>"+value2.final_selling_price+"</td>";


                 selling_price_data += "</tr>";
                });


                $("#selling_price_table").html(selling_price_data);

                $("#myModal").modal('show');

            }
        });



    }



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


    /*for (var i = 0; i <= < ?=@count($export_details_products)?>; i++) {
       console.log(i);
    
        $("#form_export_product_qty").validate({
            rules: {
             
                'qty_loaded_' + i: {
                    required: true,
                    number: true,
                    greaterThan: '#minimum_selection_for_bash_dish' 
                }
            },
            messages: {
                
            }
        });

    }*/

    $('#form_export_product_qty').ajaxForm({
       /* beforeSubmit: function () {
            return $("#form_export_product_qty").valid(); // TRUE when form is valid, FALSE will cancel submit
        },*/
        success: function (returnData) {
            console.log('RD => ' + returnData);
            obj = JSON.parse(returnData);

            /*$('#form_edit_offer_details')[0].reset(); //reset form
            $("#form_edit_offer_details select").select2("val", ""); 
            $("#form_edit_offer_details").validate().resetForm(); */

            notification(obj);
            
            //refresh table
            $('#offer_details_table').DataTable().ajax.reload();
            
        }
    });

     $('#offer_id').change(function () {

        $offer_id = $(this).val();

        $.ajax({
            url: "<?= base_url('admin/ajax_get_offer_data'); ?>",
            dataType:"json",
            type: "post",
            data:{"offer_id":$offer_id},
            success: function(data){
               $('#fz_ref_no').val(data.fz_number);

               $('#sc_qty').val(data.sc_qty);


               $('#sale_contract').val(data.sale_contract_no);

               // $customer

               $('#customer').val(data.customers); // Change the value or make some change to the internal state
               $('#customer').trigger('change.select2'); // Notify only Select2 of changes
               

               // customer

               


            }
        });

    });


    $(document).ready(function () {
var offer_id_pd = $("#offer_id").val();
        $("#offer_id_pd").val(offer_id_pd) 


        $offer_id = $("#offer_id").val();

         $.ajax({
            url: "<?= base_url('admin/ajax_get_offer_data'); ?>",
            dataType:"json",
            type: "post",
            data:{"offer_id":$offer_id},
            success: function(data){
               $('#fz_ref_no').val(data.fz_number);

               $('#sc_qty').val(data.sc_qty);


               $('#sale_contract').val(data.sale_contract_no);

               // $customer

               $('#customer').val(data.customers); // Change the value or make some change to the internal state
               $('#customer').trigger('change.select2'); // Notify only Select2 of changes
               

               // customer

               


            }
        });









                /*$offer_id = $("#offer_id").val();
        $.ajax({
            url: "< ?= base_url('admin/get-fz-number'); ?>",
            dataType:"json",
            type: "post",
            data:{"offer_id":$offer_id},
            success: function(data){
               $('#fz_ref_no').val(data.fz_number);
            }
        });*/

         /*Accordion Work*/
         /*common_freeze*/
         var com_frz = [];
         var common_freeze_field = $('#common_freeze').find('input,select');
         $.each(common_freeze_field, function(key,val) {             
            if ($(this).val() != '') {
                 com_frz.push(key);
            }
        });
        
         var com_frz_per = (com_frz.length / common_freeze_field.length) * 100;
        //  console.log(common_freeze_field);
         // console.log(com_frz_per);
         if (com_frz_per == 0) {
            $('#common_freeze_head').css('background-color','#b94b4b');
         }
         if (com_frz_per > 0 && com_frz_per <= 100) {
            $('#common_freeze_head').css({'background-color':'#dfdfa5','color':'black'});
         }
         if (com_frz_per == 100) {
            $('#common_freeze_head').css({'background-color':'#64ae64','color':'white'});
         }

         /*--Contractual----*/
         var contractual = [];
         var contractual_field = $('#contractual').find('input');
         // console.log(contractual_field);
         $.each(contractual_field, function(key,val) {             
            if ($(this).val() != '') {
                contractual.push(key);
            }
        });
         var contractual_per = (contractual.length / contractual_field.length) * 100;
         if (contractual_per == 0) {
            $('#contractual_head').css('background-color','#b94b4b');
         }
         if (contractual_per > 0 && contractual_per <= 100) {
            $('#contractual_head').css({'background-color':'#dfdfa5','color':'black'});
         }
         if (contractual_per == 100) {
            $('#contractual_head').css({'background-color':'#64ae64','color':'white'});
         }
         /*----------------*/

         /*---- shipment_docs ----*/

         var shipment_docs = [];
         var shipment_docs_field = $('#shipment_docs').find('input,select');
         $.each(shipment_docs_field, function(key,val) {             
            if ($(this).val() != '') {
                 shipment_docs.push(key);
            }
        });
         var shipment_docs_per = (shipment_docs.length / shipment_docs_field.length) * 100;
         // console.log(shipment_docs_per);
         if (shipment_docs_per == 0) {
            $('#shipment_docs_head').css('background-color','#b94b4b');
         }
         if (shipment_docs_per > 0 && shipment_docs_per <= 100) {
            $('#shipment_docs_head').css({'background-color':'#dfdfa5','color':'black'});
         }
         if (shipment_docs_per == 100) {
            $('#shipment_docs_head').css({'background-color':'#64ae64','color':'white'});
         }


         /*---- docs_file ----*/

         var docs_file = [];
         var docs_file_field = $('#docs_file').find('input,select');
         $.each(docs_file_field, function(key,val) {  
         // alert($(this).val());           
            if ($(this).val() != '') {
                 docs_file.push(key);
            }
        });
         var docs_file_per = (docs_file.length / docs_file_field.length) * 100;
        //  console.log(docs_file_field);
         if (docs_file_per == 0) {
            $('#docs_file_head').css('background-color','#b94b4b');
         }
         if (docs_file_per > 0 && docs_file_per <= 100) {
            $('#docs_file_head').css({'background-color':'#dfdfa5','color':'black'});
         }
         if (docs_file_per == 100) {
            $('#docs_file_head').css({'background-color':'#64ae64','color':'white'});
         }

         /*---------------*/

         /*---- payment ----*/
         var payment = [];
         var payment_field = $('#payment').find('input,select');
         $.each(payment_field, function(key,val) {             
            if ($(this).val() != '') {
                 payment.push(key);
            }
        });
         var payment_per = (payment.length / payment_field.length) * 100;
         // console.log(shipment_docs_per);
         if (payment_per == 0) {
            $('#payment_head').css('background-color','#b94b4b');
         }
         if (payment_per > 0 && payment_per <= 100) {
            $('#payment_head').css({'background-color':'#dfdfa5','color':'black'});
         }
         if (payment_per == 100) {
            $('#payment_head').css({'background-color':'#64ae64','color':'white'});
         }
         /*---------------*/

         /*---- information ----*/
         var information = [];
         var information_field = $('#information').find('input,select');
         $.each(information_field, function(key,val) {             
            if ($(this).val() != '') {
                 information.push(key);
            }
        });
         var information_per = (information.length / information_field.length) * 100;
         // console.log(shipment_docs_per);
         if (information_per == 0) {
            $('#information_head').css('background-color','#b94b4b');
         }
         if (information_per > 0 && information_per <= 100) {
            $('#information_head').css({'background-color':'#dfdfa5','color':'black'});
         }
         if (information_per == 100) {
            $('#information_head').css({'background-color':'#64ae64','color':'white'});
         }
         /*---------------*/
         /*--------------*/
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


    function enforceMinMax(ths){
       var _this = ths;
       var min = 0; // if min attribute is not defined, 1 is default
       
       var max = parseInt(_this.max) || 100; // if max attribute is not defined, 100 is default

       //alert(max);
       var val = parseInt(_this.value) || (min - 1); // if input char is not a number the value will be (min - 1) so first condition will be true
       if (val < min)
        _this.value = min;
       if (val > max)
        _this.value = max;
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

    $(document).ready(function(){
        //alert();
        if($("#lc_recd_cust").val() == 'N/A'){
            $("#latest_doc_lc").attr('type', 'text');
            
            $("#lc_expiry_date").attr('type', 'text');

            $("#lc_doc_submission_date").attr('type', 'text');
            $(".lc_amt_recd").prop("readonly", true);
            $(".lc_amt_recd").val('N/A');

        }else{
            $(".lc_amt_recd").val('');
            $("#latest_doc_lc").attr('type', 'date');
            $("#lc_expiry_date").attr('type', 'date');
            $("#lc_doc_submission_date").attr('type', 'date');
            $(".lc_amt_recd").arr("readonly", false);
        }   
    });

    $("#lc_recd_cust").on('change', function(){
        // alert();
        if($(this).val() == 'N/A'){
            $("#latest_doc_lc").attr('type', 'text');
            
            $("#lc_expiry_date").attr('type', 'text');

            $("#lc_doc_submission_date").attr('type', 'text');
            $(".lc_amt_recd").prop("readonly", true);
            $(".lc_amt_recd").val('N/A');

            

        }else{
            $(".lc_amt_recd").val('');
            $("#latest_doc_lc").attr('type', 'date');
            $("#lc_expiry_date").attr('type', 'date');
            $("#lc_doc_submission_date").attr('type', 'date');
            
            $(".lc_amt_recd").arr("readonly", false);
        }   
    });


    $(document).ready(function(){
        if($("#besc_applied").val() == 'N/A'){
            $(".besc_applied").prop("readonly", true);
            $(".besc_applied").val('N/A');
            $("#besc_cert").val("N/A").change();
            // $('#besc_cert option[value=val2]').attr('selected','selected');

        }else{
            $(".besc_applied").val('');
             $("#besc_cert").val("").change();
            
            $(".besc_applied").prop("readonly", false);
        }   
    });


    $("#besc_applied").on('change', function(){
        // alert();
        if($(this).val() == 'N/A'){
            $(".besc_applied").prop("readonly", true);
            $(".besc_applied").val('N/A');
            $("#besc_cert").val("N/A").change();
            // $('#besc_cert option[value=val2]').attr('selected','selected');

        }else{
            $(".besc_applied").val('');
             $("#besc_cert").val("").change();
            
            $(".besc_applied").prop("readonly", false);
        }   
    });
</script>

</body>
</html>