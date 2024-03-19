
<?php 
    
    function username_from_userid($str){
        $CI =& get_instance();
        if(!empty($str)){
            $userids = explode(",", $str);
            $fstr = '';
            foreach($userids as $ui){
                $fstr .= '#<u>' . $CI->db->get_where('users', array('user_id' => $ui))->row()->username . '</u>';
            }
            return substr($fstr, 1);
        } else{
            echo '-';
        }
        
    }
    
    function first_mail_thread_from_header($thid){
        $CI =& get_instance();
        $mt = $CI->db->get_where('task_communication', array('task_header_id' => $thid, 'thread_status' => 'first'))->row();
        if(!empty($mt)){
            echo $mt->tc_id;
        }else{
            echo '-';
        }
        return ;
    }
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

    <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css" rel="stylesheet" />
    <style>
        .form-horizontal .control-label, label{font-weight:bold}
        .form-control, select,.select2-drop-mask{border:1px solid green;}
        .form-group{border-bottom: 1px solid #dedede;padding-bottom: 15px;}
        .highlight{background: beige;padding: 1%;border: 1px solid;margin-bottom: 0px;box-shadow: -1px 0px 1px 1px #ddd;margin-bottom: 15px}
        .table-bordered,.table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td{border: 1px solid #4d4b4b;}
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
            
            <div class="col-lg-12">
                <div class="highlight">
                    <h4>Notification Panel</h4>
                    <hr style="border-color: black">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-sm-12" style="border: 1px solid #000;border-radius:10px">
                                <h4>Activity Notification</h4>
                                <table id="activity_notification" class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Task title</th>
                                            <th>Task details</th>
                                            <th>Activity title</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php 
                                $iter= 1;
                                foreach($activity_notification as $an){
                                ?>

                                    <tr>
                                        <td><?=$iter++?></td>
                                        <td><?=$an->task_title?>.</td>
                                        <td>
                                            <b>Initiator: </b><?=username_from_userid($an->task_initiator)?><br>
                                            <b>Priority: </b><?=$an->task_priority?>
                                        </td>
                                        <td><b>Activity:</b> <?=$an->activity_title?></td>
                                        <td>
                                            <a class="btn btn-success" href="<?=base_url('admin/edit-user-task-activity')?>/<?=$an->ta_id?>">View</a>
                                        </td>
                                    </tr>
                                
                                <?php    
                                } 
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="col-sm-12" style="border: 1px solid #000;border-radius:10px">
                                <h4>Mail Notification</h4>
                                <table id="mail_notification" class="table table-bordered table-condensed">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Task title</th>
                                            <th>Task details</th>
                                            <th>Mail Details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?php 
                                $iter= 1;
                                foreach($mail_notification as $mn){
                                    $fmtfh = first_mail_thread_from_header($mn->th_id); 
                                    if(!empty($fmtfh)){
                                ?>

                                    <tr>
                                        <td><?=$iter++?></td>
                                        <td><?=$mn->task_title?>.</td>
                                        <td>
                                            <b>Initiator: </b><?=username_from_userid($mn->task_initiator)?><br>
                                            <b>Priority: </b><?=$mn->task_priority?>
                                        </td>
                                        <td>
                                            <b>Mail From:</b> <?=username_from_userid($mn->from_id)?> <b>To</b> <?=username_from_userid($mn->to_id)?><br>
                                            <b>Mail Type:</b> <?=($mn->thread_status == 'first') ? 'First mail' : 'Reply mail'?>
                                        </td>
                                        <td>
                                            <a class="btn btn-success" href="<?=base_url('admin/task-communication-details')?>/<?=$fmtfh?>">View</a>
                                        </td>
                                    </tr>
                                
                                <?php    
                                    }
                                } 
                                ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <section class="panel">
                    <header class="panel-heading" id="general_activities" style="background-color: rgb(100, 174, 100); color: white;">
                        Task Filters
                        <span class="tools pull-right">
                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                        </span>
                    </header>
                    <div class="panel-body" style="display: block;">
                        <form method="post" id="filter_form" class="row">
                            <div class="col-lg-2">
                                <label for="start_date">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="start_date" />
                            </div>
                            <div class="col-lg-2">
                                <label for="end_date">End Date</label>
                                <input type="date" class="form-control" name="end_date" id="end_date" />
                            </div>
                            <div class="col-lg-2">
                                <label for="task">Task</label>
                                <select name="task" id="task" class="form-control select2">
                                    <option disabled selected value="">Select from the list</option>
                                    <?php 
                                    foreach($all_tasks as $at){
                                        ?>
                                        <option value="<?=$at->th_id?>"><?=$at->task_title?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="task_initiator">Task Initiator</label>
                                <select name="task_initiator" id="task_initiator" class="form-control select2">
                                    <option disabled selected value="">Select from the list</option>
                                    <?php 
                                    foreach($all_users as $au){ 
                                        ?>
                                        <option value="<?=$au->user_id?>"><?=$au->username?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="task">Task Status</label>
                                <select name="task_status" id="task_status" class="form-control select2">
                                    <option disabled selected value="">Select from the list</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="activity">Activity</label>
                                <select name="activity" id="activity" class="form-control select2">
                                    <option disabled selected value="">Select from the list</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="activity_status">Activity Status</label>
                                <select name="activity_status" id="activity_status" class="form-control select2">
                                    <option disabled selected value="">Select from the list</option>
                                    <option value="Open">Open</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="priority">Priority</label>
                                <select name="priority" id="priority" class="form-control">
                                    <option disabled selected value="">Select from the list</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="filter_submit">Action</label>
                                <input type="submit" name="filter_submit" value="Search" class="form-control btn btn-primary"/>
                            </div>
                        </form>   
                        
                        <div class="filter_result" style="margin-top:20px">
                            <table id="filter_results" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Task Title</th>
                                            <th>Task start date</th>
                                            <th>Task end date</th>
                                            <th>Task details</th>
                                            <th>Activity title</th>
                                            <th>Activity details</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // echo '<pre>';print_r($fitler_result);
                                        $iter = 1; 
                                        if(isset($fitler_result)){
                                            foreach($fitler_result as $fr){
                                            ?>
                                            <tr>
                                                <td><?=$iter++?></td>
                                                <td><?=$fr->task_title?></td>
                                                <td><?=date('d-m-Y', strtotime($fr->task_start_date))?></td>
                                                <td><?=date('d-m-Y', strtotime($fr->task_end_date))?></td>
                                                <td>
                                                    <b>Task initiator:</b><?=username_from_userid($fr->task_initiator)?><br>
                                                    <b>Task participants:</b><?=($fr->task_members != '') ? username_from_userid($fr->task_members) : '-'?><br>
                                                    <b>Task status:</b><?=$fr->task_status?>
                                                </td>
                                                <td><?=$fr->activity_title?></td>
                                                <td>
                                                    <b>Activity participants:</b><?= ($fr->activity_member != '') ? username_from_userid($fr->activity_member) : '-'?><br>
                                                    <b>Activity status:</b><?=$fr->activity_status?>
                                                </td>
                                                <td>-</td>
                                            </tr>
                                            <?php 
                                            }
                                        }
                                         ?>
                                    </tbody>
                            </table>
                        </div>   
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

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>


    $(document).ready(function() {
        
        $('#filter_results, #activity_notification, #mail_notification').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'excel', 'print'
            ]
        } );
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
    
    $("#task").change(function(){
        $ta_id = $(this).val();
        $.ajax({
            url: "<?= base_url('admin/ajax-fetch-activity-on-task') ?>/"+$ta_id,
            dataType: 'json',
            type: 'POST',
            success: function (returnData) {
                console.log(returnData);
                $.each(returnData, function(index, item) {
                    $str = "<option value='"+item.ta_id+"'>"+item.activity_title+"</option>";
                    $("#activity").append($str)
                });
            }
        })
    });
    
</script>

</body>
</html>