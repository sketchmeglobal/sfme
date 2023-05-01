<?php  ?>
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
                        <form autocomplete="off" id="" method="post" action="<?=base_url('admin/form-add-export')?>" enctype="multipart/form-data" class=" form-horizontal tasi-form" autocomplete="on">
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Common Freeze
                                        <span class="tools pull-right">
                                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group row">
                                            <div class="col-lg-12 text-right">
                                                <input type="submit" name="submit" class="btn btn-success" value="Add">
                                            </div>
                                            <div class="col-lg-3 col-offset-4" style="margin:auto">
                                                <?php //echo "<pre>"; print_r($offers); die(); ?>
                                                <label for="offer_id" class="control-label text-danger">Offer Name *</label>
                                                <select id="offer_id" name="offer_id" required class="form-control select2">
                                                    <option selected value="">Select Offer</option>
                                                    <?php foreach ($offers as $offer) {?>
                                                    <option value="<?php echo $offer->offer_id ?>"><?php echo $offer->offer_name.'['. $offer->offer_fz_number.']'; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-3" style="margin:auto">
                                                <?php //echo "<pre>"; print_r($offers); die(); ?>
                                                <label for="row_colour" class="control-label">Row Colour</label>
                                                <select name="row_colour" id="row_colour" name="row_colour" class="form-control">
                                                    <option selected value="">Select Colour</option>
                                                    <?php foreach ($colours as $c) {?>
                                                    <option style="background:<?=$c->color_hex_code?>" value="<?= $c->color_id ?>"><?php echo $c->color_name. '['. $c->color_hex_code.']'; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            
                                            <div class="col-lg-3">
                                                <label for="vendor_id" class="control-label text-danger">Vendor Name *</label>
                                                <select id="vendor_id" name="supplier_id" required class="form-control select2">
                                                    <option disabled selected value="">Select vendor</option>
                                                    
                                                </select>

                                            </div>
                                            <!-- FZ Ref # -->
                                            <div class="col-lg-3">
                                                <label for="fz_ref_no" class="control-label">FZ Ref #</label>
                                                <input  id="fz_ref_no" name="fz_ref_no" type="text" placeholder="FZ No" class="form-control" />
                                            </div>
                                            <!-- Partial Ref # -->
                                            <div class="col-lg-3">
                                                <label for="partial_reference" class="control-label">Partial Ref #</label>
                                                <input  id="partial_reference" name="partial_reference" type="text" placeholder="FZ Ref No" class="form-control" />
                                            </div>
                                            <!-- VEND PI -->
                                            <div class="col-lg-3">
                                                <label for="vend_pi" class="control-label">VEND PI</label>
                                                <input  id="vend_pi" name="vend_pi" type="text" placeholder="VEND PI" class="form-control" />
                                            </div>
                                            <!-- VEND INV AMT -->
                                            <div class="col-lg-3">
                                                <label for="vend_inv_amt" class="control-label">VEND INV AMT</label>
                                                <input  id="vend_inv_amt" name="vend_inv_amt" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="VEND INV AMT" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="vend_inv_amt_currency" class="control-label">Currency</label>
                                                <select id="vend_inv_amt_currency" name="vend_inv_amt_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Vend PO Conf -->
                                            <div class="col-lg-3">
                                                <label for="vend_po_conf" class="control-label">Vend PO Conf</label>
                                                <input  id="vend_po_conf" name="vend_po_conf" type="text" placeholder="Vend PO Conf" class="form-control"/>
                                            </div>
                                            <!-- Cust Inco -->
                                            <div class="col-lg-3">
                                                <label for="cust_inco_id" class="control-label">Cust Inco</label>
                                                <select id="cust_inco_id" name="cust_inco_id" class="form-control " >
                                                    <option selected>Select Incoterm</option>
                                                    <?php foreach ($incoterms as $incoterm) {?>
                                                    <option value="<?php echo $incoterm->it_id ?>"><?php echo $incoterm->incoterm ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- PAYT TERMS CUST -->
                                            <div class="col-lg-3">
                                                <label for="pymt_terms_cust_id" class="control-label">PAYT TERMS CUST</label>
                                                <input  id="pymt_terms_cust_id" name="pymt_terms_cust_id" type="text" title="Enter number" placeholder="PAYT TERMS CUST" class="form-control" />
                                            </div>
                                            <!-- Responsible Purchase -->
                                            <div class="col-lg-3">
                                                <label for="responsible_purchase_id" class="control-label">Responsible Purchase</label>
                                                <select name="responsible_purchase_id" id="responsible_purchase_id" class="form-control">
                                                    <option value="">Select Responsible Purchase</option>
                                                    <?php foreach ($responsible_purchase as $responsible_purchase) {?>
                                                    <option value="<?php echo $responsible_purchase->responsible_purchase_id ?>"><?php echo $responsible_purchase->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Responsible Sale -->
                                            <div class="col-lg-3">
                                                <label for="responsible_sale_id" class="control-label"> Responsible Sale </label>
                                                <select name="responsible_sale_id" id="responsible_sale_id" class="form-control">
                                                    <option value="">Select Responsible Sale</option>
                                                    <?php foreach ($responsible_sales as $responsible_sales) {?>
                                                    <option value="<?php echo $responsible_sales->responsible_sales_id ?>"><?php echo $responsible_sales->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Responsible Logistics -->
                                            <div class="col-lg-3">
                                                <label for="responsible_logistics_id" class="control-label"> Responsible Logistics </label>
                                                <select name="responsible_logistics_id" id="responsible_logistics_id" class="form-control">
                                                    <option value="">Select Responsible Logistics</option>
                                                    <?php foreach ($responsible_logistic as $responsible_logistic) {?>
                                                    <option value="<?php echo $responsible_logistic->responsible_logistic_id ?>"><?php echo $responsible_logistic->name ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-lg-3">
                                                <input type="submit" name="submit" class="btn btn-success" value="Add">
                                            </div>
                                        </div> -->
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Contractual
                                        <span class="tools pull-right">
                                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group row">
                                            <!-- CUST PO # -->
                                            <div class="col-lg-3">
                                                <label for="cust_po_no" class="control-label">CUST PO #</label>
                                                <input  id="cust_po_no" name="cust_po_no" type="text" placeholder="CUST PO #" class="form-control" />
                                            </div>
                                            <!-- Cust PI Conf -->
                                            <div class="col-lg-3">
                                                <label for="cust_pi_conf" class="control-label">Cust PI Conf</label>
                                                <input  id="cust_pi_conf" name="cust_pi_conf" type="text" placeholder="Cust PI Conf" class="form-control" />
                                            </div>
                                            <!-- Latest DOS -->
                                            <div class="col-lg-3">
                                                <label for="latest_dos" class="control-label">Latest DOS</label>
                                                <input  id="latest_dos" name="latest_dos" type="date" placeholder="Latest DOS" class="form-control" />
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-lg-3">
                                                <input type="submit" name="submit" class="btn btn-success" value="Add">
                                            </div>
                                        </div> -->
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Shipment/DOCS
                                        <span class="tools pull-right">
                                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group row">
                                           <!-- Hyperlink for BL to appear -->
                                            <div class="col-lg-3">
                                                <label for="rlink_for_bl_to_appear" class="control-label"> Hyperlink for BL to appear </label>
                                                <input  id="rlink_for_bl_to_appear" name="rlink_for_bl_to_appear" type="text" placeholder="Hyperlink for BL to appear" class="form-control" />
                                            </div>
                                            <!-- BESC / Others - Appld -->
                                            <div class="col-lg-3">
                                                <label for="besc_applied" class="control-label"> BESC / Others - Appld </label>
                                                <select name="besc_applied" id="besc_applied" class="form-control">
                                                    <option value="">Select BESC / Others- Appld </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- BL No -->
                                            <div class="col-lg-3">
                                                <label for="bl_no" class="control-label">BL No</label>
                                                <input  id="bl_no" name="bl_no" type="text" placeholder="BL No" class="form-control" />
                                            </div>
                                            <!-- Corrc Appr by Cust -->
                                            <div class="col-lg-3">
                                                <label for="corrc_appr_by_cust" class="control-label"> Corrc Appr by Cust </label>
                                                <select name="corrc_appr_by_cust" id="corrc_appr_by_cust" class="form-control">
                                                    <option value=""> Select Draft Docs Recd  </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Recd Date -->
                                            <div class="col-lg-3">
                                                <label for="corrc_appr_cust_date" class="control-label"> Recd Date </label>
                                                <input  id="corrc_appr_cust_date" name="corrc_appr_cust_date" type="date"  class="form-control " />
                                            </div>
                                            <!-- Corrc Appr to Vend -->
                                            <div class="col-lg-3">
                                                <label for="corrc_appr_to_vend" class="control-label"> Corrc Appr to Vend  </label>
                                                <select name="corrc_appr_to_vend" id="corrc_appr_to_vend" class="form-control">
                                                    <option value="">Select Draft Docs Recd  </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Sent Date -->
                                            <div class="col-lg-3">
                                                <label for="correc_appr_vend_date" class="control-label"> Sent Date </label>
                                                <input  id="correc_appr_vend_date" name="correc_appr_vend_date" type="date"  class="form-control " />
                                            </div>
                                            <!-- DOCS TO SGS/ITS (CEAN CERT) -->
                                            <div class="col-lg-3">
                                                <label for="docs_sent_to_sgs_for_clean_cer" class="control-label"> DOCS TO SGS/ITS (CEAN CERT) </label>
                                                <input  id="docs_sent_to_sgs_for_clean_cer" name="docs_sent_to_sgs_for_clean_cer" type="text" placeholder="DOCS TO SGS/ITS (CEAN CERT)"  class="form-control " />
                                            </div>
                                            <!-- Draft Docs Recd -->
                                            <div class="col-lg-3">
                                                <label for="draft_docs_recd" class="control-label"> Draft Docs Recd  </label>
                                                <select name="draft_docs_recd" id="draft_docs_recd" class="form-control">
                                                    <option value="">Select Draft Docs Recd  </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Recd Date -->
                                            <div class="col-lg-3">
                                                <label for="draft_docs_recd_date" class="control-label">Recd Date </label>
                                                <input  id="draft_docs_recd_date" name="draft_docs_recd_date" type="date"  class="form-control " />
                                            </div>
                                            <!-- Draft Docs Sent -->
                                            <div class="col-lg-3">
                                                <label for="draft_docs_sent" class="control-label"> Draft Docs Sent  </label>
                                                <select name="draft_docs_sent" id="draft_docs_sent" class="form-control">
                                                    <option value="">Select Draft Docs Recd  </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Sent Date -->
                                            <div class="col-lg-3">
                                                <label for="draft_docs_sent_date" class="control-label"> Sent Date </label>
                                                <input  id="draft_docs_sent_date" name="draft_docs_sent_date" type="date"  class="form-control " />
                                            </div>
                                            <!-- Final Docs Submitted (LC) -->
                                            <div class="col-lg-3">
                                                <label for="final_docs_submitted" class="control-label"> Final Docs Submitted (LC) </label>
                                                <input  id="final_docs_submitted" name="final_docs_submitted" type="text" placeholder="Final Docs Submitted (LC)"  class="form-control lc_amt_recd" />
                                            </div>
                                            <!-- Final Copy-Cust -->
                                            <div class="col-lg-3">
                                                <label for="final_copy_cust" class="control-label"> Final Copy-Cust </label>
                                                <select name="final_copy_cust" id="final_copy_cust" class="form-control">
                                                    <option value=""> Select Final Copy-Cust  </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Sent Date -->
                                            <div class="col-lg-3">
                                                <label for="final_copy_cust_date" class="control-label"> Sent Date </label>
                                                <input  id="final_copy_cust_date" name="final_copy_cust_date" type="date"  class="form-control " />
                                            </div>
                                            <!-- Final Copy-Vend -->
                                            <div class="col-lg-3">
                                                <label for="final_copy_vend" class="control-label"> Final Copy-Vend </label>
                                                <select name="final_copy_vend" id="final_copy_vend" class="form-control">
                                                    <option value=""> Select Final Copy-Vend  </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Recd Date -->
                                            <div class="col-lg-3">
                                                <label for="final_copy_vend_date" class="control-label"> Recd Date </label>
                                                <input  id="final_copy_vend_date" name="final_copy_vend_date" type="date"  class="form-control " />
                                            </div>
                                             <!-- Freight Agent -->
                                            <div class="col-lg-3">
                                                <label for="freight_agent" class="control-label">Freight Agent</label>
                                                <input  id="freight_agent" name="freight_agent" type="text" placeholder="Freight Agent" class="form-control" />
                                            </div>
                                             <!-- Freight Inv # -->
                                            <div class="col-lg-3">
                                                <label for="freight_invoice_no" class="control-label">Freight Inv #</label>
                                                <input  id="freight_invoice_no" name="freight_invoice_no" type="text" placeholder="Freight Inv #" class="form-control" />
                                            </div>
                                            <!-- INSP License # -->
                                            <div class="col-lg-3">
                                                <label for="insp_license_number" class="control-label">Insp / Imp Lic No</label>
                                                <input  id="insp_license_number" name="insp_license_number" type="text" placeholder="Insp / Imp Lic No" class="form-control " />
                                            </div>
                                            <!-- LABEL APPR CUST -->
                                            <div class="col-lg-3">
                                                <label for="label_appr_cust" class="control-label">LABEL APPR CUST</label>
                                                <input  id="label_appr_cust" name="label_appr_cust" type="text" placeholder="LABEL APPR CUST" class="form-control" />
                                            </div>
                                            <!-- LABEL APPR VEND -->
                                            <div class="col-lg-3">
                                                <label for="label_appr_vend" class="control-label">LABEL APPR VEND</label>
                                                <input  id="label_appr_vend" name="label_appr_vend" type="text" placeholder="LABEL APPR VEND" class="form-control" />
                                            </div>
                                            <!-- Org Docs- Cust -->
                                            <div class="col-lg-3">
                                                <label for="org_docs_cust" class="control-label"> Org Docs- Cust </label>
                                                <select name="org_docs_cust" id="org_docs_cust" class="form-control">
                                                    <option value=""> Select Org Docs- Cust   </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Sent Date -->
                                            <div class="col-lg-3">
                                                <label for="org_docs_cust_date" class="control-label"> Sent Date </label>
                                                <input  id="org_docs_cust_date" name="org_docs_cust_date" type="date"  class="form-control " />
                                            </div>
                                            <!-- Org Docs- Vend -->
                                            <div class="col-lg-3">
                                                <label for="org_docs_vend" class="control-label"> Org Docs- Vend </label>
                                                <select name="org_docs_vend" id="org_docs_vend" class="form-control">
                                                    <option value=""> Select Org Docs- Vend   </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Recd Date -->
                                            <div class="col-lg-3">
                                                <label for="org_docs_vend_date" class="control-label"> Recd Date </label>
                                                <input  id="org_docs_vend_date" name="org_docs_vend_date" type="date"  class="form-control " />
                                            </div>
                                            <!-- Sale Contract # -->
                                            <div class="col-lg-3">
                                                <label for="sale_contract" class="control-label">Sale Contract #</label>
                                                <input  id="sale_contract" name="sale_contract" type="text" placeholder="Sale Contract" class="form-control" />
                                            </div>
                                            <!-- SC Qty -->
                                            <div class="col-lg-3">
                                                <label for="sc_qty" class="control-label">SC Qty</label>
                                                <input value="" id="sc_qty" name="sc_qty" type="text" placeholder="SC Qty" class="form-control " />
                                            </div>
                                            <!-- PI Sales Amt -->
                                            <div class="col-lg-3">
                                                <label for="pi_sales_amt" class="control-label">PI Sales Amt</label>
                                                <input  id="pi_sales_amt" name="pi_sales_amt" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="PI Sales Amt" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="pi_sales_amt_currency" class="control-label">Currency</label>
                                                <select id="pi_sales_amt_currency" name="pi_sales_amt_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- PO Purch Amt -->
                                            <div class="col-lg-3">
                                                <label for="po_purch_amt" class="control-label">PO Purch Amt</label>
                                                <input  id="po_purch_amt" name="po_purch_amt" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="PI Sales Amt" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="po_purch_amt_currency" class="control-label">Currency</label>
                                                <select id="po_purch_amt_currency" name="po_purch_amt_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                             <!-- Qty Loaded -->
                                            <div class="col-lg-3">
                                                <label for="qty_loaded" class="control-label">Qty Loaded</label>
                                                <input value="" id="qty_loaded" name="qty_loaded" type="text" placeholder="Qty Loaded" class="form-control" />
                                            </div>
                                            <!-- 3rd INSP Upload -->
                                            <div class="col-lg-3">
                                                <label for="3rd_insp_upload" class="control-label">3rd INSP Upload</label>
                                                <input  id="3rd_insp_upload" name="3rd_insp_upload" type="date" placeholder="3rd INSP Upload" class="form-control " />
                                            </div>
                                            <!-- Insp. AOC / COC -->
                                            <div class="col-lg-3">
                                                <label for="insp_aoc_coc" class="control-label">Insp. AOC / COC</label>
                                                <input  id="insp_aoc_coc" name="insp_aoc_coc" type="text" placeholder="Insp. AOC / COC" class="form-control" />
                                            </div>
                                            <!-- AOC / COC Date -->
                                            <div class="col-lg-3">
                                                <label for="aoc_coc_date" class="control-label">AOC / COC Date</label>
                                                <input  id="aoc_coc_date" name="aoc_coc_date" type="date" placeholder="AOC / COC Date" class="form-control" />
                                            </div>
                                            <!-- Days Delayed -->
                                            <div class="col-lg-3">
                                                <label for="dayes_delayed" class="control-label">Days Delayed</label>
                                                <input  id="dayes_delayed" name="dayes_delayed" type="text" readonly placeholder="Days Delayed" class="form-control" />
                                            </div>
                                            <!-- Rem. Days for Shipt -->
                                            <div class="col-lg-3">
                                                <label for="rem_dayes_for_shipt" class="control-label">Rem. Days for Shipt</label>
                                                <input  id="rem_dayes_for_shipt" name="rem_dayes_for_shipt" type="text" readonly placeholder="Rem. Days for Shipt" class="form-control" />
                                            </div>                                            
                                            <!-- BESC / Others- # -->
                                            <div class="col-lg-3">
                                                <label for="besc_others_no" class="control-label">BESC / Others- #</label>
                                                <input  id="besc_others_no" name="besc_others_no" type="text" placeholder="BESC / Others- #" class="form-control besc_applied" />
                                            </div>
                                            <!-- BESC / Others- CERT -->
                                            <div class="col-lg-3">
                                                <label for="besc_cert" class="control-label"> BESC / Others- CERT </label>
                                                <select name="besc_cert" id="besc_cert" class="form-control">
                                                    <option value="">Select BESC / Others- CERT </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Check-List Applied -->
                                            <div class="col-lg-3">
                                                <label for="check_list_applied" class="control-label"> Check-List Applied </label>
                                                <input  id="check_list_applied" name="check_list_applied" type="text" placeholder="Check-List Applied" class="form-control " />
                                            </div>
                                            <!-- Doc Courier- # (Incoming) -->
                                            <div class="col-lg-3">
                                                <label for="doc_courier_no_incoming" class="control-label"> Doc Courier- # (Incoming) </label>
                                                <input  id="doc_courier_no_incoming" name="doc_courier_no_incoming" type="text" placeholder="Doc Courier- # (Incoming)"  class="form-control " />
                                            </div>
                                            <!-- Doc Courier- # (Outgoing) -->
                                            <div class="col-lg-3">
                                                <label for="doc_courier_no_outgoing" class="control-label"> Doc Courier- # (Outgoing) </label>
                                                <input  id="doc_courier_no_outgoing" name="doc_courier_no_outgoing" type="text" placeholder="Doc Courier- # (Outgoing)"  class="form-control " />
                                            </div>
                                            <!-- Container Discharge Date -->
                                            <div class="col-lg-3">
                                                <label for="container_discharge_date" class="control-label"> Container Discharge Date </label>
                                                <input  id="container_discharge_date" name="container_discharge_date" type="text" placeholder="Container Discharge Date"  class="form-control " />
                                            </div>
                                            <!-- Final Clearance Date -->
                                            <div class="col-lg-3">
                                                <label for="final_clearance_date" class="control-label"> Final Clearance Date </label>
                                                <input  id="final_clearance_date" name="final_clearance_date" type="text" placeholder="Final Clearance Date"  class="form-control " />
                                            </div>
                                            <!-- DOC RECD(FAX) -->
                                            <div class="col-lg-3">
                                                <label for="doc_recd" class="control-label"> DOC RECD(FAX) </label>
                                                <input  id="doc_recd" name="doc_recd" type="text" placeholder="DOC RECD(FAX)"  class="form-control " />
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-lg-3">
                                                <input type="submit" name="submit" class="btn btn-success" value="Add">
                                            </div>
                                        </div> -->
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        DOCS File
                                        <span class="tools pull-right">
                                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group row">
                                            <!-- INSP SR Applied -->
                                            <div class="col-lg-3">
                                                <label for="insp_sr_applied" class="control-label"> INSP SR Applied </label>
                                                <select name="insp_sr_applied" id="insp_sr_applied" class="form-control">
                                                    <option value="">Select INSP SR Applied </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- Insp. SR # -->
                                            <div class="col-lg-3">
                                                <label for="insp_sr_number" class="control-label">Insp. SR #</label>
                                                <input  id="insp_sr_number" name="insp_sr_number" type="text" placeholder="Insp. SR #" class="form-control" />
                                            </div>
                                                <!-- Upload Invoice -->
                                            <div class="col-lg-3">
                                                <label for="invoice_file" class="control-label">Upload Invoice</label>
                                                <input  id="invoice_file" name="invoice_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Packing List -->
                                            <div class="col-lg-3">
                                                <label for="packing_list_file" class="control-label">Upload Packing List</label>
                                                <input  id="packing_list_file" name="packing_list_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Health Certificate -->
                                            <div class="col-lg-3">
                                                <label for="health_cer_file" class="control-label">Upload Health Certificate</label>
                                                <input  id="health_cer_file" name="health_cer_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Certificate of Origin -->
                                            <div class="col-lg-3">
                                                <label for="cert_of_origin" class="control-label">Upload Certificate of Origin</label>
                                                <input  id="cert_of_origin" name="cert_of_origin" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Bill of Leading -->
                                            <div class="col-lg-3">
                                                <label for="bill_of_leading" class="control-label">Upload Bill of Leading</label>
                                                <input  id="bill_of_leading" name="bill_of_leading" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload SGS Certificate -->
                                            <div class="col-lg-3">
                                                <label for="sgs_cert" class="control-label">Upload SGS Certificate</label>
                                                <input  id="sgs_cert" name="sgs_cert" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload FERI Certificate -->
                                            <div class="col-lg-3">
                                                <label for="feri_cert" class="control-label">Upload FERI Certificate</label>
                                                <input  id="feri_cert" name="feri_cert" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Inspection Report -->
                                            <div class="col-lg-3">
                                                <label for="insp_report_file" class="control-label">Upload Inspection Report</label>
                                                <input  id="insp_report_file" name="insp_report_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload SGS BESC Certificate -->
                                            <div class="col-lg-3">
                                                <label for="besc_cert_file" class="control-label">Upload SGS BESC Certificate</label>
                                                <input  id="besc_cert_file" name="besc_cert_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Approved Label -->
                                            <div class="col-lg-3">
                                                <label for="appr_label_file" class="control-label">Upload Approved Label</label>
                                                <input  id="appr_label_file" name="appr_label_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Confirmed PO -->
                                            <div class="col-lg-3">
                                                <label for="confirmed_po_file" class="control-label">Upload Confirmed PO</label>
                                                <input  id="confirmed_po_file" name="confirmed_po_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Confirmed PI -->
                                            <div class="col-lg-3">
                                                <label for="confirmed_pi_file" class="control-label">Upload Confirmed PI</label>
                                                <input  id="confirmed_pi_file" name="confirmed_pi_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Micrbiology Report -->
                                            <div class="col-lg-3">
                                                <label for="micrbiology_report_file" class="control-label">Upload Micrbiology Report</label>
                                                <input  id="micrbiology_report_file" name="micrbiology_report_file" type="file" class="form-control" />
                                            </div>
                                            
                                            <!-- Upload Other Export Document -->
                                            <div class="col-lg-3">
                                                <label for="other_export_report_file" class="control-label">Upload Other Export Document</label>
                                                <input  id="other_export_report_file" name="other_export_report_file" type="file" class="form-control" />
                                            </div>
                                            <!-- Upload Any other quality report -->
                                            <div class="col-lg-3">
                                                <label for="any_other_quality_report_file" class="control-label">Upload Any other quality report</label>
                                                <input  id="any_other_quality_report_file" name="any_other_quality_report_file" type="file" class="form-control" />
                                            </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-lg-3">
                                                <input type="submit" name="submit" class="btn btn-success" value="Add">
                                            </div>
                                        </div> -->
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Payment
                                        <span class="tools pull-right">
                                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group row">
                                            <!-- Adv Amt from Cust -->
                                            <div class="col-lg-3">
                                                <label for="adv_amt_from_cust" class="control-label">Adv Amt from Cust</label>
                                                <input  id="adv_amt_from_cust" name="adv_amt_from_cust" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="Adv Amt from Cust" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="adv_amt_cust_currency" class="control-label">Currency</label>
                                                <select id="adv_amt_cust_currency" name="adv_amt_cust_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- BANK ADVICE RCPT -->
                                            <div class="col-lg-3">
                                                <label for="advise_received_from_bank" class="control-label"> BANK ADVICE RCPT </label>
                                                <input  id="advise_received_from_bank" name="advise_received_from_bank" type="text"  class="form-control " />
                                            </div>
                                            <!-- Adv Paid to Vendor -->
                                            <div class="col-lg-3">
                                                <label for="adv_paid_to_vendor" class="control-label">Adv Paid to Vendor</label>
                                                <input  id="adv_paid_to_vendor" name="adv_paid_to_vendor" type="number" pattern="[0-9]{10}" title="Enter number" placeholder=" Adv Amt to Vendor" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="adv_paid_vend_currency" class="control-label">Currency</label>
                                                <select id="adv_paid_vend_currency" name="adv_paid_vend_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Adv Amt to Vendor -->
                                            <div class="col-lg-3">
                                                <label for="adv_amt_to_vendor" class="control-label">Adv Amt to Vendor</label>
                                                <input  id="adv_amt_to_vendor" name="adv_amt_to_vendor" type="number" pattern="[0-9]{10}" title="Enter number" placeholder=" Adv Amt to Vendor" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="adv_amt_vend_currency" class="control-label">Currency</label>
                                                <select id="adv_amt_vend_currency" name="adv_amt_vend_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Adv Recd from Cust -->
                                            <div class="col-lg-3">
                                                <label for="adv_recd_from_cust" class="control-label">Adv Recd from Cust</label>
                                                <input  id="adv_recd_from_cust" name="adv_recd_from_cust" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="Adv Amt from Cust" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="adv_recd_from_cust_currency" class="control-label">Currency</label>
                                                <select id="adv_recd_from_cust_currency" name="adv_recd_from_cust_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- CR NOTE TO CUST -->
                                            <div class="col-lg-3">
                                                <label for="cr_note_to_cust" class="control-label"> CR NOTE TO CUST  </label>
                                                <input  id="cr_note_to_cust" name="cr_note_to_cust" type="text" placeholder="CR NOTE TO CUST"  class="form-control " />
                                            </div>
                                            <!-- CR NOTE TO SUPP -->
                                            <div class="col-lg-3">
                                                <label for="cr_note_to_supp" class="control-label"> CR NOTE TO SUPP </label>
                                                <input  id="cr_note_to_supp" name="cr_note_to_supp" type="text" placeholder="CR NOTE TO SUPP"  class="form-control " />
                                            </div>
                                             <!-- DBT NOTE TO CUST -->
                                            <div class="col-lg-3">
                                                <label for="dbt_note_to_cust" class="control-label"> DBT NOTE TO CUST </label>
                                                <input  id="dbt_note_to_cust" name="dbt_note_to_cust" type="text" placeholder="DBT NOTE TO CUST"  class="form-control " />
                                            </div>
                                            <!-- DBT NOTE TO SUPP -->
                                            <div class="col-lg-3">
                                                <label for="dbt_note_to_supp" class="control-label"> DBT NOTE TO SUPP </label>
                                                <input  id="dbt_note_to_supp" name="dbt_note_to_supp" type="text" placeholder="DBT NOTE TO SUPP"  class="form-control " />
                                            </div>
                                            <!-- DBT NOTE CUST(COMM) -->
                                            <div class="col-lg-3">
                                                <label for="dbt_note_cust_comm" class="control-label"> DBT NOTE CUST(COMM) </label>
                                                <input  id="dbt_note_cust_comm" name="dbt_note_cust_comm" type="text" placeholder="DBT NOTE CUST(COMM)"  class="form-control " />
                                            </div>
                                            <!-- LC AMD RECD -->
                                            <div class="col-lg-3">
                                                <label for="lc_amt_recd" class="control-label"> LC AMD RECD </label>
                                                <input  id="lc_amt_recd" name="lc_amt_recd" type="text" placeholder="LC AMD RECD"  class="form-control lc_amt_recd" />
                                            </div>
                                            <!-- LC AMD REQD -->
                                            <div class="col-lg-3">
                                                <label for="lc_amd_reqd" class="control-label"> LC AMD REQD </label>
                                                <input  id="lc_amd_reqd" name="lc_amd_reqd" type="text" placeholder="LC AMD REQD"  class="form-control " />
                                            </div>
                                            <!-- LC AMD/TRANSFER -->
                                            <div class="col-lg-3">
                                                <label for="lc_amd_transfer" class="control-label"> LC AMD/TRANSFER </label>
                                                <input  id="lc_amd_transfer" name="lc_amd_transfer" type="text"  class="form-control " />
                                            </div>
                                            <!-- LC CRITICAL CONDITION -->
                                            <div class="col-lg-3">
                                                <label for="lc_critical_condition" class="control-label"> LC CRITICAL CONDITION </label>
                                                <input  id="lc_critical_condition" name="lc_critical_condition" type="text" placeholder="LC CRITICAL CONDITION"  class="form-control lc_amt_recd" />
                                            </div>
                                            <!-- LC DOC SUBM DT -->
                                            <div class="col-lg-3">
                                                <label for="lc_doc_submission_date" class="control-label"> LC DOC SUBM DT </label>
                                                <input  id="lc_doc_submission_date" name="lc_doc_submission_date" type="date" placeholder="LATEST DOS (LC)"  class="form-control lc_amt_recd" />
                                            </div>
                                            <!-- LC EXP DT -->
                                            <div class="col-lg-3">
                                                <label for="lc_expiry_date" class="control-label"> LC EXP DT </label>
                                                <input  id="lc_expiry_date" name="lc_expiry_date" type="date" placeholder="LC EXP DT"  class="form-control lc_amt_recd" />
                                            </div>
                                            <!-- LC RECD CUST -->
                                            <div class="col-lg-3">
                                                <label for="lc_recd_cust" class="control-label"> LC RECD CUST </label>
                                                <select name="lc_recd_cust" id="lc_recd_cust" class="form-control">
                                                    <option value=""> Select LC RECD CUST  </option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="N/A">N/A</option>
                                                </select>
                                            </div>
                                            <!-- PAYT BY SUPP (COMM) -->
                                            <div class="col-lg-3">
                                                <label for="payment_by_supplier_comm" class="control-label"> PAYT BY SUPP (COMM) </label>
                                                <input  id="payment_by_supplier_comm" name="payment_by_supplier_comm" type="text" placeholder="PAYT BY SUPP (COMM)"  class="form-control " />
                                            </div>
                                        </div>
                                        <!-- <div class="form-group row">
                                            <div class="col-lg-3">
                                                <input type="submit" name="submit" class="btn btn-success" value="Add">
                                            </div>
                                        </div> -->
                                    </div>
                                </section>
                            </div>
                            <div class="col-lg-12">
                                <section class="panel">
                                    <header class="panel-heading">
                                        Information
                                        <span class="tools pull-right">
                                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                                        </span>
                                    </header>
                                    <div class="panel-body">
                                        <div class="form-group row">
                                           <!-- ACTUAL SALE AMT -->
                                            <div class="col-lg-3">
                                                <label for="actual_sale_amt" class="control-label">ACTUAL SALE AMT</label>
                                                <input  id="actual_sale_amt" name="actual_sale_amt" type="number" pattern="[0-9]{10}" title="Enter number" placeholder="ACTUAL SALE AMT" class="form-control" />
                                            </div>
                                            <!-- Currency -->
                                            <div class="col-lg-3">
                                                <label for="actual_sales_amt_currency" class="control-label">Currency</label>
                                                <select id="actual_sales_amt_currency" name="actual_sales_amt_currency" class="form-control">
                                                    <option selected value="">Select Currency</option>
                                                    <?php foreach ($currencies as $currency) { ?>
                                                    <option value="<?php echo $currency->c_id ?>"><?php echo $currency->currency.' ('. $currency->code .')' ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <!-- Admin Appr -->
                                            <div class="col-lg-3">
                                                <label for="admin_appr" class="control-label"> Admin Appr </label>
                                                <input  id="admin_appr" name="admin_appr" type="text" placeholder="Admin Appr"  class="form-control " />
                                            </div>
                                            <!-- Last Remark -->
                                            <div class="col-lg-3">
                                                <label for="last_remark" class="control-label">Last Remark</label>
                                                <textarea id="last_remark" name="last_remark" type="text" placeholder="Last Remark" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Mrktg Appr -->
                                            <div class="col-lg-3">
                                                <label for="mrktng_appr" class="control-label"> Mrktg Appr </label>
                                                <input  id="mrktng_appr" name="mrktng_appr" type="text" placeholder="Admin Appr"  class="form-control " />
                                            </div>
                                            <!-- Rescrce Appr -->
                                            <div class="col-lg-3">
                                                <label for="resource_appr" class="control-label"> Rescrce Appr </label>
                                                <input  id="resource_appr" name="resource_appr" type="text" placeholder="Admin Appr"  class="form-control " />
                                            </div>
                                            <!-- Remark For Outstation -->
                                            <div class="col-lg-3">
                                                <label for="remark_for_outstation" class="control-label">Remark For Outstation</label>
                                                <textarea id="remark_for_outstation" name="remark_for_outstation" type="text" placeholder="Remark For Outstation" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Remark From Outstation -->
                                            <div class="col-lg-3">
                                                <label for="remark_from_outstation" class="control-label">Remark From Outstation</label>
                                                <textarea id="remark_from_outstation" name="remark_from_outstation" type="text" placeholder="Remark From Outstation" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Remark Admin RP -->
                                            <div class="col-lg-3">
                                                <label for="remark_admin_rp" class="control-label">Remark Admin RP</label>
                                                <textarea id="remark_admin_rp" name="remark_admin_rp" type="text" placeholder="Remark Admin RP" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Remark Final RP -->
                                            <div class="col-lg-3">
                                                <label for="remark_finan_rp" class="control-label">Remark Final RP</label>
                                                <textarea id="remark_finan_rp" name="remark_finan_rp" type="text" placeholder="Remark Sales RP" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                             <!-- Remark Purch RP -->
                                            <div class="col-lg-3">
                                                <label for="remark_purch_rp" class="control-label">Remark Purch RP</label>
                                                <textarea id="remark_purch_rp" name="remark_purch_rp" type="text" placeholder="Remark Purch RP" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Remark Sales RP -->
                                            <div class="col-lg-3">
                                                <label for="remark_sales_rp" class="control-label">Remark Sales RP</label>
                                                <textarea id="remark_sales_rp" name="remark_sales_rp" type="text" placeholder="Remark Sales RP" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- THINK -->
                                            <div class="col-lg-3">
                                                <label for="think" class="control-label"> THINK </label>
                                                <input  id="think" name="think" type="text" placeholder="THINK"  class="form-control " />
                                            </div>
                                            <!-- Dox Remark -->
                                            <div class="col-lg-3">
                                                <label for="dox_remark" class="control-label">Dox Remark</label>
                                                <textarea id="dox_remark" name="dox_remark" type="text" placeholder="Dox Remark" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Shipt Remark -->
                                            <div class="col-lg-3">
                                                <label for="shipt_remark" class="control-label">Shipt Remark</label>
                                                <textarea id="shipt_remark" name="shipt_remark" type="text" placeholder="Shipt Remark" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Payment Remark -->
                                            <div class="col-lg-3">
                                                <label for="payment_remark" class="control-label">Payment Remark</label>
                                                <textarea id="payment_remark" name="payment_remark" type="text" placeholder="Payment Remark" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Collect Remark -->
                                            <div class="col-lg-3">
                                                <label for="collect_remark" class="control-label">Collect Remark</label>
                                                <textarea id="collect_remark" name="collect_remark" type="text" placeholder="Collect Remark" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- General Remark -->
                                            <div class="col-lg-3">
                                                <label for="general_remark" class="control-label">General Remark</label>
                                                <textarea id="general_remark" name="general_remark" type="text" placeholder="General Remark" class="form-control " cols="30" rows="5"></textarea>
                                            </div>
                                            <!-- Accounts Appr -->
                                            <div class="col-lg-3">
                                                <label for="accounts_appr" class="control-label"> Accounts Appr </label>
                                                <input  id="accounts_appr" name="accounts_appr" type="text" placeholder="Accounts Appr"  class="form-control " />
                                            </div>
                                            <div class="col-lg-3">
                                                <label for="no_of_container" class="control-label"> No of Containers </label>
                                                <input  id="no_of_container" name="no_of_container" type="text" placeholder="No of Containers"  class="form-control " />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12 text-center">
                                                <input type="submit" name="submit" class="btn btn-success" value="Add">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </form>
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
        $(document).ready(function() {
        $('#customer').select2();
        });
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
        $('#offer_id').change(function () {
            $offer_id = $(this).val();
            $.ajax({
                url: "<?= base_url('admin/ajax_get_offer_data'); ?>",
                dataType:"json",
                type: "post",
                data:{"offer_id":$offer_id},
                success: function(data){
                    console.log(data.vendors)
                    $('#fz_ref_no').val(data.fz_number);
                    $('#sc_qty').val(data.sc_qty);
                    $('#sale_contract').val(data.sale_contract_no);
                    // $customer
                    $('#customer').val(data.customers); // Change the value or make some change to the internal state
                    $('#customer').trigger('change.select2'); // Notify only Select2 of changes
                    
                    $("#vendor_id").html("")
                    $("#vendor_id").select2()
                    $.each( data.vendors, function( key, value ) {
                        console.log( value.am_id );
                        $str = "<option value='"+value.am_id+"'>"+value.name+"</option>";
                        $("#vendor_id").append($str)
                    });

                }
            });
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
        
        $(".lc_amt_recd").prop("readonly", false);
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