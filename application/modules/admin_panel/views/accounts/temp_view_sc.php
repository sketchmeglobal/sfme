<?php  ?>
<?php //echo "string"; ?>
<?php
// print_r($buyer_details);die;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>SC Template | <?=WEBSITE_NAME;?></title>
		<meta name="description" content="SC Template">
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
									<form autocomplete="off" id="form_add_sale_cotract" method="post" action="<?=base_url('admin/print-sale-contract')?>" target="_blank" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form" autocomplete="on">
										
										<div class="form-group row">
											<label for="t_id" class="control-label col-lg-2">Select Template</label>

											<div class="col-lg-10">
												<?php $sc_id = $this->uri->segment(3); ?>
												<input type="hidden" value="<?=$sc_id?>" name="sc_id">
												<select name="t_id" id="t_id" class="form-control">
													<?php 
														$tmp = $this->db->get_where('sc_template', array('type' => 'SC'))->result();
														foreach ($tmp as $key => $value) {
													?>
														<option value="<?=$value->sc_template_id?>"><?=$value->template_name?></option>

													<?php } ?>
												</select>
											</div>
										</div>

									
										<div class="form-group">
											<div class="col-lg-12">
												<button class="btn btn-success pull-right" type="submit" style="margin-right: 20px;"> Submit</button>
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

		<script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>

		
</body>
</html>