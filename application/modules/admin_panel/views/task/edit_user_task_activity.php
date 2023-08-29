
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
        .form-group{border-bottom: 1px solid #dedede;padding-bottom: 15px;}
        .highlight{background: beige;padding: 1%;border: 1px solid;margin-bottom: 0px;box-shadow: -1px 0px 1px 1px #ddd;}
    </style>
</head>

<body class="sticky-header">
<?php //echo "<pre>", print_r($export_details), '</pre>'; ?>
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
            <?php
            if(!empty($msg)){
                ?>
                <div class="col-lg-12">
                    <h5 class="btn-warning pull-right" style="padding:1%"><?=$msg?></h5>
                </div>
                <?php
            }
            ?>
            <div class="col-lg-12">
                <h5 class="highlight">
                    Task <b><?= $task_details->task_title?></b>, started on <u><?=date('d-m-Y', strtotime($task_details->task_start_date))?> </u>
                    and about to be closed on <u><?=date('d-m-Y', strtotime($task_details->task_end_date))?></u> 
                    still have <u><?=$task_details->task_priority?></u> priority.
                </h5>
                <section class="panel">
                    <header class="panel-heading" id="common_activities" style="background-color: rgb(100, 174, 100); color: white;">
                        Common Activites
                        <span class="tools pull-right">
                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body" style="display: block;">
                        <form class="" id="common_form" method="post">
                            <?php 
                            if(!empty($common_activities)){
                                $common_activity_iter = 1;
                                foreach($common_activities as $ca){
                                    if($ca->pattern == 'yes-no'){
                                        ?>

                                        <div class="form-group row">
                                            <div class="col-lg-1">
                                                <?= $common_activity_iter++ ?>.
                                            </div>
                                            <div class="col-lg-8">
                                                <input type="hidden" name="task_common_id[]" value="<?=$ca->cta_id?>"/>
                                                <?= $ca->common_question ?>
                                            </div>
                                            <div class="col-lg-3">
                                                <select name="task_value[]" class="form-control">
                                                    <option <?= ($ca->task_value == 'Yes') ? 'selected' : '' ?> value="Yes">Yes</option>
                                                    <option <?= ($ca->task_value == 'No') ? 'selected' : '' ?> value="No">No</option>
                                                </select>
                                            </div>
                                        </div> 

                                        <?php
                                    }else if($ca->pattern == 'descriptive'){
                                        ?>
                                        <div class="form-group row">
                                            <div class="col-lg-1">
                                                <?= $common_activity_iter++ ?>.
                                            </div>
                                            <div class="col-lg-3">
                                            <input type="hidden" name="task_common_id[]" value="<?=$ca->cta_id?>"/>

                                                <?= $ca->common_question ?> (descriptive)
                                            </div>
                                            <div class="col-lg-8">
                                                <textarea name="task_value[]" class="form-control ckeditor">
                                                    <?=$ca->task_value?>
                                                </textarea>
                                            </div>
                                        </div> 
                                        <?php
                                    }
                                }   
                            }
                            ?>

                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <input type="hidden" name="task_activity_id" value="<?=$task_activity_id?>"/>
                                    <input type="submit" name="commonsubmit" class="btn btn-success" value="Update">
                                </div>
                            </div>  
                        </form>
                    </div>
                </section>

                <section class="panel">
                    <header class="panel-heading" id="general_activities" style="background-color: rgb(100, 174, 100); color: white;">
                        General Activites
                        <span class="tools pull-right">
                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body" style="display: block;">
                        <form id="general_form" method="post">
                            <?php 
                            if(count($task_activity) > 0){
                                $general_activity_iter = 1;
                                foreach($task_activity as $ta){
                                    ?>

                                        <div class="form-group row">
                                            <div class="col-lg-1">
                                                <?= $general_activity_iter++ ?>.
                                            </div>
                                            <div class="col-lg-3">
                                                <b>Title:</b> <br>
                                                <?= $ta->activity_title ?>
                                            </div>
                                            <div class="col-lg-3">
                                                <b>Start Date:</b> <br>
                                                <?= (!empty($ta->activity_start_date)) ? date('d-m-Y', strtotime($ta->activity_start_date)) : '' ?>
                                            </div>
                                            <div class="col-lg-3">
                                                <b>End Date:</b> <br>
                                                <?= (!empty($ta->activity_end_date)) ? date('d-m-Y', strtotime($ta->activity_end_date)) : ''?>
                                            </div>
                                            <div class="col-lg-2">
                                                <b>Current Status: </b><br>
                                                <select name="activity_status" class="form-control">
                                                    <!-- <option value="Completed"> Completed </option>
                                                    <option value="Ongoing"> Ongoing </option>
                                                    <option value="Postponed"> Postponed </option>
                                                    <option value="Stopped"> Stopped </option> -->
                                                    <option <?= ($ta->activity_status == 'Open') ? 'selected' : '' ?> value="Open">Open</option>
                                                    <option <?= ($ta->activity_status == 'Closed') ? 'selected' : '' ?> value="Closed">Closed</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">    
                                            <div class="col-lg-12">
                                                <textarea name="activity_question_ans" class="form-control ckeditor"><?= $ta->activity_details ?></textarea>
                                            </div>
                                        </div> 

                                    <?php
                                
                                }   
                            }
                            ?>

                            <div class="form-group row">
                                <div class="col-lg-3">
                                    <input type="hidden" name="task_activity_id" value="<?=$task_activity_id?>"/>
                                    <input type="submit" name="generalsubmit" class="btn btn-success" value="Update">
                                </div>
                            </div>  
                        </form>    
                    </div>
                </section>
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

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>


<script>


    $(document).ready(function() {
        $('.select2').select2();

        CKEDITOR.replaceClass = 'ckeditor';

    });


    $("#form_edit_user_task").validate({
        
        rules: {
            offer_number: {
                required: true,
                // remote: {
                //     url: "< ?=base_url('admin/ajax-unique-offer-number')?>",
                //     type: "post",
                //     data: {
                //         offer_number: function() {
                //           return $("#offer_number").val();
                //         }
                //     },
                // },
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
    
    
     

</script>

</body>
</html>