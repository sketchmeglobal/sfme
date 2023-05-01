
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
                            <form autocomplete="off" id="form_add_user" method="post" action="<?=base_url('admin/form-add-user')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                                
                                <div class="form-group ">

                                    <div class="col-lg-3">
                                        
                                        <label for="user_type" class="control-label text-danger">User type *</label>
                                        <select required="" name="user_type" id="user_type" class="form-control select2">
                                            <option value="" selected="" disabled="">Select User Type</option>
                                            <option value="1">Trader</option>
                                            <option value="2">Resource Developer</option>
                                            <option value="3">Marketing Personnel</option>
                                            <option value="4">Exporter</option>
                                        </select>

                                    </div>

                                    <div class="col-lg-3">
                                        <label for="username" class="control-label text-danger">User Name*</label>
                                        <input value="" id="username" name="username" type="text" placeholder="User Name" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="firstname" class="control-label">First Name</label>
                                        <input value="" id="firstname" name="firstname" type="text" placeholder="First Name" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="lastname" class="control-label">Last Name</label>
                                        <input value="" id="lastname" name="lastname" type="text" placeholder="Last Name" class="form-control round-input" />
                                    </div>                              
                                </div>

                                <div class="form-group">
                                    
                                    <div class="col-lg-3">
                                        <label for="email" class="control-label">Email ID</label>
                                        <input value="" id="email" name="email" type="email" placeholder="Email ID" class="form-control round-input" />
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="contact" class="control-label">Mobile Number</label>
                                        <input value="" id="contact" name="contact" type="text" placeholder="Mobile Number" class="form-control round-input" />
                                    </div> 

                                    <div class="col-lg-3">
                                        <label for="pass" class="control-label text-danger">Password*</label>
                                        <input required="" value="" id="pass" name="pass" type="password" placeholder="Password" class="form-control round-input" />
                                    </div> 

                                    <div class="col-lg-3">
                                        
                                        <!--FOR BUYER OR SUPPLIER-->
                                        
                                        <label for="acc_masters" class="control-label acc_masters_values">Permission (Buyer/Supplier)</label>
                                        <select title="If none selected then permission for all" multiple="" name="acc_masters[]" id="acc_masters" class="form-control acc_masters_values">
                                        </select>
                                        
                                        <!--FOR OFFER SECTION-->
                                        
                                        <label for="offer_values" class="control-label offer_values">Select Offer</label>
                                        <select title="If none selected then permission for all" multiple="" name="offer_values[]" id="offer_values" class="form-control offer_values">
                                        </select>
                                        
                                        
                                    </div>                                    

                                </div>
                               
                                <div class="form-group">
                                    <div class="col-lg-3">
                                        <label for="blocked" class="control-label text-danger">Block User?</label>
                                        <select required="" name="blocked" id="blocked" class="form-control select2">
                                            <option value="" selected="" disabled="">Select User Status</option>
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div> 
                                    <div class="col-lg-3">
                                        <label for="" class="control-label">Upload User Picture</label>
                                        <input type="file" name="userfile" id="userfile" accept=".jpg,.jpeg,.png,.bmp" class="file">
                                     </div>
                                                                        
                                </div>    

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <button class="btn btn-success pull-right" type="submit"><i class="fa fa-plus"> Add User</i></button>
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
    $("#form_add_user").validate({
        
        rules: {
            username: {
                required: true,
                remote: {
                    url: "<?=base_url('admin/ajax-unique-username')?>",
                    type: "post",
                    data: {
                        username: function() {
                          return $("#username").val();
                        }
                    },
                }
            },            
            user_type:{
                required: true
            },
            pass : {
                required: true
            }   
        },
        messages: {

        }
    });
    $('#form_add_user').ajaxForm({
        beforeSubmit: function () {
            return $("#form_add_user").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            console.log(returnData);
            obj = JSON.parse(returnData);
            notification(obj);
			if(parseInt(obj.insert_id) > 0){
                if(obj.type == 'error'){
                    setTimeout(function(){ 
                        window.location.href = '<?=base_url()?>admin/edit-user/'+obj.insert_id; 
                        }, 3000);
                }else{
                    window.location.href = '<?=base_url()?>admin/edit-user/'+obj.insert_id;
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