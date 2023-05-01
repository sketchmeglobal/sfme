<?php  ?>

<?php //echo "string"; ?>
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

		<style type="text/css">
			.ck-editor__editable {min-height: 200px;}
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
						<div class="col-lg-12">
							<section class="panel">
							    <div class="badge badge-success">Last Pi Number: <?=$pon?></div>
								<div class="panel-body">
									<form autocomplete="off" id="form_add_sale_cotract" method="post" action="<?=base_url('admin/form_add_purchase_order')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form" autocomplete="on">
										<div class="form-group row">
											<div class="col-lg-3">
												<label for="company_id" class="control-label text-danger">Company *</label>
												<select name="company_id" required  id="company_id" class="form-control select2">
													<option value=""> -- Select company -- </option>
													<?php
													foreach($company as $companyrow){
													?>
													<option value="<?=$companyrow->company_id ?>"><?=$companyrow->company_name ?></option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-3">
												<label for="po_number" class="control-label text-danger">PO Number *</label>
												<input  id="po_number" required name="po_number" type="text" placeholder="Enter PI Number" class="form-control" />
											</div>
											<div class="col-lg-3">
												<label for="po_date" class="control-label text-danger">PO Date*</label>
												<input  id="po_date" name="po_date" required type="date" class="form-control" />
											</div>
											<div class="col-lg-3">
												<label for="offer_id" class="control-label text-danger">Offer *</label>
												<select name="offer_id"  id="offer_id" class="form-control select2">
													<option value=""> -- Select Offer -- </option>
													<?php
													foreach($offer_list as $offer_listrow){
													?>
													<option value="<?= $offer_listrow->offer_id ?>"><?= $offer_listrow->offer_name . ' ['.$offer_listrow->offer_number.']' ?>
													</option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										
                                        <div class="form-group row">
										    <div class="col-lg-3">
												<label for="pi_number" class="control-label">Tax</label>
												<input  id="tax" name="tax"  type="text" placeholder="Enter TAX" class="form-control" />
											</div>

										    <div class="col-lg-3">
										        <label for="your_ref" class="control-label">Your Ref.</label>
											    <input  id="your_ref" name="your_ref" type="text" placeholder="Enter Your Ref" class="form-control" />
										    </div>
										    <div class="col-lg-3">
											    <label for="tax" class="control-label">Order To.</label>
												<select name="order_to_id"  id="order_to_id" class="form-control select2">
													<option value=""> -- Select Order to party list -- </option>
													<?php foreach($order_to_party_list as $otp){ ?>
													<option data-contact="<?=$otp->owner_name . '/' . $otp->manager_name?>" value="<?= $otp->am_id ?>">
													    <?= $otp->name . ' ['.$otp->am_code.']' ?>
													</option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-3">
											    <label for="manager_name" class="control-label">Manager Name</label>
												<input id="manager_name" value="" name="order_to_contact" type="text" placeholder="Enter contact name" class="form-control" />
											</div>
										</div>

										<div class="form-group row">
											<div class="col-lg-3">
												<label for="sold_to_party_id" class="control-label">Sold to party</label>
												<select name="sold_to_party_id"  id="sold_to_party_id" class="form-control select2">
													<option value=""> -- Select sold to party list -- </option>
													<?php
													foreach($sold_to_party_list as $sold_to_party_listrow){
													?>
													<option value="<?= $sold_to_party_listrow->am_id ?>"><?= $sold_to_party_listrow->name . ' ['.$sold_to_party_listrow->am_code.']' ?>
													</option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-3">
												<label for="consignee_id" class="control-label">Consignee name</label>
												<select name="consignee_id"  id="consignee_id" class="form-control select2">
													<option value=""> -- Select Consignee -- </option>
													<?php
													foreach($consignee_name_list as $consignee_name_listrow){
													?>
													<option value="<?= $consignee_name_listrow->am_id ?>"><?= $consignee_name_listrow->name . ' ['.$consignee_name_listrow->am_code.']' ?>
													</option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-3">
												<label for="destination_port" class="control-label">Destination port</label>
												<select name="destination_port"  id="destination_port" class="form-control select2">
													<option value=""> -- Select Destination port -- </option>
													<?php
													foreach($port_list as $port_listrow){
													?>
													<option value="<?= $port_listrow->p_id ?>"><?= $port_listrow->port_name;?>
													</option>
													<?php
													}
													?>
												</select>
											</div>
											<div class="col-lg-3">
												<label for="port_of_shipment" class="control-label">Port of shipment </label>
												<select name="port_of_shipment"  id="port_of_shipment" class="form-control select2">
													<option value=""> -- Select Port of shipment -- </option>
													<?php
													foreach($port_list as $port_listrow){
													?>
													<option value="<?= $port_listrow->p_id ?>"><?= $port_listrow->port_name;?>
													</option>
													<?php
													}
													?>
												</select>
											</div>
										</div>
										
										<div class="form-group row">
										    
											<div class="col-lg-3">
												<label for="transhipment" class="control-label">Transhipment</label>
												<input  id="transhipment" name="transhipment" placeholder="Enter Transhipment" type="text" class="form-control" />
											</div>
											<div class="col-lg-3">
												<label for="partial_shipment" class="control-label">Partial shipment</label>
												<input  id="partial_shipment" name="partial_shipment" placeholder="Enter Partial shipment" type="text" class="form-control" />
											</div>
											<div class="col-lg-3">
												<label for="label_document" class="control-label">Label  and Documents</label>
												<input  id="label_document" name="label_document" placeholder="Enter Label  and Documents" type="text" class="form-control" />
											</div>
           <!--                                 <div class="col-lg-3">-->
											<!--	<label for="bank_id" class="control-label">Bank</label>-->
											<!--	<select name="bank_id[]" multiple data-placeholder="-- Select bank --"  id="bank_id" class="form-control select2">-->
											<!--		< ?php-->
											<!--		foreach($banklist as $banklistrow){-->
											<!--		?>-->
											<!--		<option value="<?=$banklistrow->bank_master_id ?>"><?=$banklistrow->bank_name . ' ['.$banklistrow->account_number.']' ?></option>-->
											<!--		< ?php-->
											<!--		}-->
											<!--		?>-->
											<!--	</select>-->
											<!--</div>-->
										</div>
										
										<!--<div class="form-group row">-->
										<!--	<div class="col-lg-3">-->
										<!--		<label for="payment_terms" class="control-label">Payment Terms</label>-->
										<!--		<select required name="payment_terms" data-placeholder="-- Select payment terms --"  id="payment_terms" class="form-control select2">-->
										<!--			< ?php-->
										<!--			foreach($payment_terms as $pt){-->
										<!--			?>-->
										<!--			    <option value="<?=$pt->pt_id ?>"><?=$pt->payment_terms ?></option>-->
										<!--			< ?php-->
										<!--			}-->
										<!--			?>-->
										<!--		</select>-->
												
										<!--	</div>-->
										<!--</div>-->

										<div class="form-group row">
											<div class="col-lg-6">
												<label for="authorised_signatory" class="control-label">Authorised Signature</label>
												<textarea name="authorised_signatory" id="authorised_signatory" cols="30" rows="10" class="form-control"></textarea>
											</div>

											<div class="col-lg-6">
												<label for="accepted_by" class="control-label">Accepted by</label>
												<textarea name="accepted_by" id="accepted_by" cols="30" rows="10" class="form-control"></textarea>
											</div>
										</div>


  										<div class="form-group row">
											<div class="col-lg-6">
												<label for="authorised_signatory" class="control-label">Additional Info</label>
												<textarea name="add_info" id="add_info" cols="30" rows="10" class="form-control"></textarea>
											</div>

											<div class="col-lg-6">
												<label for="authorised_signatory" class="control-label">Additional Info 2</label>
												<textarea name="add_info2" id="add_info2" cols="30" rows="10" class="form-control"></textarea>
											</div>
										</div>

										<div id="add-div" class="addrowmore">
										    <div class="form-group row" id="">
												<div class="col-lg-2">
													<input type="text"  placeholder="Enter Label" name="lbl[]" id="lbl" class="form-control" value="">
												</div>
												<div class="col-lg-7">
													<input  id="" name="lab_report_clauses[]" placeholder="Enter Description" type="text" class="form-control" value="" />
												</div>
												<div class="col-lg-3">
													<button type="button"  class="btn btn-success btn-sm" onclick="addMore()"> <i class="fa fa-plus"></i></button>
												</div>
											</div>
										</div>
										<br>
										
										<div class="form-group">
											<div class="col-lg-12">
												<a href="<?=base_url('admin/purchase-order') ?>"><button class="btn btn-danger pull-right" type="button">Back</button></a>
												<button class="btn btn-success pull-right" type="submit" style="margin-right: 20px;"><i class="fa fa-plus"> Save</i></button>
											</div>
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

		<!--<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>-->

        <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
		<script>
            CKEDITOR.replace( 'authorised_signatory' );
            CKEDITOR.replace( 'add_info' );
            CKEDITOR.replace( 'add_info2' );
            CKEDITOR.replace( 'accepted_by' );
            // CKEDITOR.replace( 'ckeditor' );
            // CKEDITOR.replace( 'lab_report_clauses' );
        </script>
        
		<script>
		function addMore() {
		    var randId = 'lab_report_clauses' + (Math.floor(1 + (100 - 1) * Math.random()));
			var formGroup = [];
			$('div[id*="formGroup_"]').each(function (index){
				formGroup.push($(this).attr("id"));
			});
			//console.log(formGroup);
			var maxfdiv = maxDivId(formGroup);
			var newfMaxid = maxfdiv + 1;
			var add_row ='<div class="form-group row addrowmore" id="formGroup_'+newfMaxid+'">';
						add_row += '<div class="col-lg-2"><input type="text" required  placeholder="Enter Label" name="lbl[]" id="lbl" class="form-control"></div>';
						add_row += '<div class="col-lg-7">';
									add_row += '<textarea id="'+randId+'" required name="lab_report_clauses[]" placeholder="Enter Lab report clauses" type="text" class="form-control"></textarea>';
						add_row += '</div>';
						add_row += '<div class="col-lg-3">';
									add_row += '<button type="button"  class="btn btn-success btn-sm addorremove" onclick="addMore()"> <i class="fa fa-plus"></i></button> <button type="button"  class="btn btn-danger btn-sm" onclick="removebtn('+newfMaxid+')"> <i class="fa fa-minus" aria-hidden="true"></i> </button>';
						add_row += '</div>';
			add_row += '</div>';
        	add_row += '</div>';
        	
        	$(add_row).clone().appendTo("#add-div");
        	CKEDITOR.replace(randId)
	}
	
	function maxDivId(divArray){
	var lastidArray = [];
	var maxid = 0;
	for(var i=0; i < divArray.length; i++){
	var str = divArray[i];
	var splitRes = str.split("_");
	var lastid =  splitRes[1];
	
	lastidArray.push(lastid);
	}
	//console.log(lastidArray);
	maxid = Math.max.apply(null, lastidArray);
	//console.log(maxid);
	return maxid;
	}
	function removebtn(id) {
	$("#formGroup_"+id).remove();
	}
	//add-item-form validation and submit
	$("#form_add_sale_cotract").validate({
	
	rules: {
	offer_id:{
	required: true
	},
	company_id: {
	required: true
	},
	pi_number:{
	required: true
	},
	pi_date: {
	required: true
	},
	bank_id: {
	required: true
	},
	
	},
	messages: {
	}
	});
	$('#form_add_sale_cotract').ajaxForm({
	beforeSubmit: function () {
	return $("#form_add_sale_cotract").valid(); // TRUE when form is valid, FALSE will cancel submit
	},
	success: function (returnData) {
	console.log(returnData);
	obj = JSON.parse(returnData);
	notification(obj);
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
	
	<script>
	    
	    $("#sold_to_party_id").change(function(){
	        var stp = $(this).val();
	        console.log(stp)
	        
	        $.ajax({
                url: "<?=base_url('admin/ajax-clause-on-customer')?>",
                type: 'GET',
                data: {cid: stp},
                dataType: 'json', // added data type
                success: function(res) {
                    console.log(res);
                    
                    jQuery.each(res, function(index, item) {
                        //now you can access properties using dot notation
                        var add_row ='<div class="form-group row addrowmore" id="">';
        						add_row += '<div class="col-lg-2"><input type="text" required  placeholder="Enter Label" name="lbl[]" id="lbl" class="form-control" value="'+item.clause_name+'"></div>';
        						add_row += '<div class="col-lg-7">';
        									add_row += '<textarea  id="ajax'+index+'" name="lab_report_clauses[]" placeholder="Enter Description" class="form-control ckeditor">'+item.clause_details+'</textarea>';
        						add_row += '</div>';
        						add_row += '<div class="col-lg-3">';
        									add_row += '<button type="button"  class="btn btn-success btn-sm addorremove" onclick="addMore()"> <i class="fa fa-plus"></i></button> <button type="button"  class="btn btn-danger remove-this btn-sm" onclick="removebtn(1)"> <i class="fa fa-minus" aria-hidden="true"></i> </button>';
        						add_row += '</div>';
            			add_row += '</div>';
                    	add_row += '</div>';
                    	
                    	$(add_row).clone().appendTo("#add-div");
                        
                        CKEDITOR.replace( 'ajax'+index );
                        
                    });
        			
                    
                    
                    
                },
                error: function(res){
                    
                }
            }).then(function(){
                // CKEDITOR.replace( 'lab_report_clauses' );
            });
	        
	    })
	    
	    $(document).on('click', '.remove-this', function(){
	      
	      $(this).closest('.addrowmore').remove()
	        
	    })
	    
	    $("#order_to_id").on('change', function(){
		    $val = ($(this).find(":selected").data('contact'))
		    $("#manager_name").val($val)
		})
	    
	</script>
	
</body>
</html>