
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
    
    <style>
        .acc_masters_values, .offer_values{display: none}
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
                        <div class="panel-body">
                            <form autocomplete="off" id="form_add_document" method="post" action="<?=base_url('admin/form-add-document')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                                
                                <div class="form-group ">
                                    <div class="col-lg-3">
                                        <label for="folderName" class="control-label text-danger">Folder Name*</label>
                                        <input value="" id="folderName" name="folderName" type="text" placeholder="Folder Name" class="form-control round-input" />
                                        <input type="hidden" name="parentFolderId" id="parentFolderId" value="<?=$parentFolderId?>">
                                    </div>  

                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload Files</label>
                                        <input type="file" name="userfile[]" id="userfile" accept=".jpg,.jpeg,.png,.bmp,.txt,.docx,.xlsx,.csv,.pdf,.zip" class="file" multiple>
                                     </div>
                                </div>  

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <button class="btn btn-success pull-right" type="submit"><i class="fa fa-plus"> Add Document</i></button>
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

<script>
    //add-item-form validation and submit
    $("#form_add_document").validate({        
        rules: {
            folderName: {
                required: false
            }  
        },
        messages: {

        }
    });
    $('#form_add_document').ajaxForm({
        beforeSubmit: function () {
            return $("#form_add_document").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            console.log(returnData);
            obj = JSON.parse(returnData);
            notification(obj);
			if(parseInt(obj.update_id) > 0){
                console.log(JSON.stringify(obj));
                if(obj.type == 'error'){
                    // setTimeout(function(){ 
                    //     window.location.href = '<?=base_url()?>admin/edit-user/'+obj.insert_id; 
                    // }, 3000);
                }else{
                    setTimeout(function(){
                        window.location.href = '<?=base_url()?>admin/my-documents/'+obj.parentFolderId;
                    }, 3000);
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
    
    $("#user_type").on('change', function(){
        
         $usertype = $(this).val();
        // console.log($val);
        
        if($usertype == 4){
            
            $(".acc_masters_values").hide();
            $(".offer_values").show();
            
        }else{
            
            $(".acc_masters_values").show();
            $(".offer_values").hide();
            
        }
        
        
        $.ajax({
            url: "<?= base_url('admin/acc_master-on-usertype/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {usertype: $usertype},
            success: function (returnData) {
                
                console.log(returnData);
                
                $("#acc_masters").html("");
                
                if($usertype == 4){
                    
                    $.each(returnData, function (index, itemData) {
                       $str = '<option value="'+itemData.offer_id+'">'+itemData.offer_name + ' ['+ itemData.offer_fz_number +']' +'</option>';
                       $("#offer_values").append($str);
                    });
                    
                    $('#offer_values').select2({
                      placeholder: 'Select an option'
                    });
                    
                }else{
                
                    $.each(returnData, function (index, itemData) {
                       $str = '<option value="'+itemData.am_id+'">'+itemData.name + ' ['+ itemData.am_code +']' +'</option>';
                       $("#acc_masters").append($str);
                    });
                    
                    $('#acc_masters').select2({
                      placeholder: 'Select an option'
                    });
                    
                }
                

            },
            error: function (returnData) {
                obj = JSON.parse(returnData);
                notification(obj);
            }
        });
    })
</script>

</body>
</html>