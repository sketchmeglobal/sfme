
    <?php 
    function username_from_userid($str){
        $CI =& get_instance();
        $userids = explode(",", $str);
        $fstr = '';
        foreach($userids as $ui){
            $fstr .= '#<u>' . $CI->db->get_where('users', array('user_id' => $ui))->row()->username . '</u>';
        }
        return substr($fstr, 1);
    }

    function fetch_attachments($tcid,$thid){
        $CI =& get_instance();
        $documents = $CI->db->get_where('task_communication_attachments', array('tc_id' => $tcid, 'task_header_id' => $thid))->result();
        $str = '';
        foreach($documents as $doc){
            $str .= ', <br><a target="_blank" href="'.base_url('upload/communication').'/'. $doc->document . '">'.$doc->document.'</a>'; 
        }
        return substr($str, 6);
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
                // echo '<pre>',print_r($task_details),'<pre>';
                // print_r($to_members);
                if(!empty($msg)){
                    ?>
                    <div class="col-lg-12">
                        <h5 class="btn-warning pull-right" style="padding:1%"><?=$msg?></h5>
                    </div>
                    <?php
                }
                ?>
                <div class="" style="width:100%;display:block">
                    <div class="col-lg-6">
                        <div class="highlight">
                            <h5 class="">
                                Task <b><?= $task_details->task_title?></b>, started on <u><?=date('d-m-Y', strtotime($task_details->task_start_date))?> </u>
                                and about to be closed on <u><?=date('d-m-Y', strtotime($task_details->task_end_date))?></u> 
                                still have <u><?=$task_details->task_priority?></u> priority.
                            </h5>
                            <hr>
                            <h5>
                                <b>Initiated by:</b> <?=$task_details->username?><br>
                                <b>Participants:</b> <?=str_replace("#"," and ",$to_members);?>
                            </h5>
                        </div>
                    </div>
                    <div class="col-lg-6 highlight">
                        <h5>
                            <b>Details:</b> <?=$task_details->task_details?>
                        </h5>
                    </div>
                </div>    

                <div class="col-lg-12">
                    
                    
                    
                    <section class="panel">
                        <header class="panel-heading" id="msg_reply" style="background-color: rgb(100, 174, 100); color: white;">
                            Reply Now
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <div class="panel-body" style="display: block;">
                            <form method="post" id="reply_box_form" enctype="multipart/form-data">
                                <label for="">Reply:</label>
                                <textarea id="msg_reply_textfield" name="reply" class="ckeditor form-control"></textarea>
                                <div class="col-lg-4">
                                    <label for="">Select Participants</label>
                                    <select name="participant[]" id="" multiple class="select2 form-control">
                                        <option disabled seelcted value="">Select User</option>
                                        <?php foreach($all_users as $au){ ?>
                                            <option value="<?=$au->user_id?>"><?=$au->username?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-lg-6">
                                    <label for="">Upload attachments</label>
                                    <input type="file" class="form-control" name="files[]" multiple/>
                                </div>
                                <div class="col-lg-2">
                                    <input type="hidden" value="<?= $task_details->tc_id ?>" name="tc_id">
                                    <input type="hidden" value="<?= $task_details->task_header_id ?>" name="th_id">
                                    <label for="">Action</label>
                                    <input type="submit" name="reply_submit" id="" class="form-control btn btn-primary" value="Reply">
                                </div>
                            </form>
                        </div>
                    </section>

                    <section class="panel">
                        <header class="panel-heading" id="general_activities" style="background-color: rgb(100, 174, 100); color: white;">
                            Mail Trail
                            <span class="tools pull-right">
                                <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                            </span>
                        </header>
                        <?php 
                        // echo '<pre>', print_r($task_reply), '</pre>';
                        ?>
                        <?php foreach($task_reply as $tr){ ?>
                        <div class="panel-body" style="display: block; border:1px solid; margin-bottom:10px">
                            <div class="col-lg-3">
                                <label>Reply Info.</label><hr>
                                <b>Date:</b> <?=date('d-m-Y H:i:s', strtotime($tr->created_date))?> <br>
                                <b>Initiated:</b> <?= $tr->username ?> <br>
                                <b>Forwarded To:</b> <?= str_replace("#", " and " ,username_from_userid($tr->to_id)) ?>
                            </div>
                            <div class="col-lg-6">
                                <label>Reply Massage:</label><hr>
                                <?=$tr->comment?>
                            </div>
                            <div class="col-lg-3">
                                <label>attachments</label><hr>
                                <?= fetch_attachments($tr->tc_id, $tr->task_header_id) ?>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
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