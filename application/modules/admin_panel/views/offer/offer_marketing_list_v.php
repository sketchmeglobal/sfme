<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$title?> | <?=WEBSITE_NAME;?></title>
    <meta name="description" content="<?=$title?>">

    <!--Data Table-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/css/buttons.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style type="text/css">
        .ic label{text-decoration: underline;cursor: pointer;}
        /*.ic span{text-decoration: none;cursor: default;}*/
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
                <?php if($insert != ''){
                    ?>
                    <div class="badge badge-right"><?=$insert?></div>
                    <?php
                } ?>
            </div>
            <div class="row">
                <div class="col-lg-12 text-right">
                    <!--<a href="< ?= base_url('admin/add-offer') ?>" class="btn btn-success  mx-auto"><i class="fa fa-plus"></i> Add <?=$menu?></a>-->
                    <section class="panel">
                        <div class="panel-body">
                            <table id="offer_table" class="table data-table dataTable">
                                <thead>
                                    <tr>
                                        <th>Offer Name</th>
                                        <th>Offer No.</th>
                                        <th>Offer Date</th>
                                        <th>Offer Age</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
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

<!-- Request modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Send Edit Request</h4>
            </div>
            <div class="modal-body">
                <form id="request_offer" method="post" action="<?=base_url('admin/request-offer')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                    <div class="form-group ">
                        <label class="control-label col-md-4 text-danger">Comment*</label>
                        <div class="col-md-8">
                           <textarea name="comment" id="comment" required="" class="form-control"></textarea>
                           <span class="help-block">Write why you want to have access</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="hidden" name="offer_id" value="" id="offer_id">
                            <input type="submit" name="request-submit" value="Send" id="request-submit" class="btn btn-success pull-right">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Comments modal -->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Resource Comment Details</h4>
            </div>
            <div class="modal-body">
                
                <!-- for auto open of modal if redirected from dashboard -->

                <span id="resolve_offer_id" class="hidden">
                    <?=$this->input->get('oid')?>
                </span>
                <span id="resolve_oc_id"  class="hidden">
                    <?=$this->input->get('ocid')?>
                </span>

                <table id="all_offer_comments" class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Offer</th>
                            <th>Resource Name</th>
                            <th>Comment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>    
                </table>
                
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- View (Settings) modal -->
<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Marketing Details</h4>
            </div>
            <div class="modal-body">
                
                <!-- for auto open of modal if redirected from dashboard -->
                <div class="col-md-12 panel">
                    <h4 class="text-center bg-primary" style="padding: 1%">
                        Offer name <span id="mar_offer_name"></span> is assigned to <span id="mar_offer_assigned_to"></span>
                        with template <span id="mar_offer_assigned_template"></span>
                    </h4>
                    <form method="POST" class="panel-body">
                        <div class="col-lg-3">
                            <label>Select Marketing Personnel</label>
                            <select id="marketing_id" name="marketing_id" class="select2 form-control">
                                <option value="" selected="" disabled="">Select any options</option>
                                <?php foreach($mar_users as $mu){ ?>
                                <option value="<?=$mu->user_id?>"><?=$mu->username?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label>Select Template</label>
                            <select name="vt_id" id="vt_name" class="select2 form-control">
                                <option value="" selected="" disabled="">Select any options</option>
                                <?php foreach($view_templates as $template){ ?>
                                <option value="<?=$template->vt_id?>"><?=$template->template_name?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label>Action</label><br>
                            <input type="submit" class="btn btn-success template_assign_insert" value="Assign" name="template_assign_insert" />
                            <input type="submit" class="btn btn-success hidden template_assign_update" value="Update" name="template_assign_update" />
                            <input type="submit" class="btn btn-info hidden template_assign_update" value="Finalise" name="template_assign_update" />
                            <a target="_blank" href="" class="btn btn-warning view_offer1">View (Comp1)</a>
                            <a target="_blank" href="" class="btn btn-warning view_offer2">View (Comp2)</a>
                        </div>

                        <!-- HIDDEN FIELDS -->  
                        <input type="hidden" name="assigned_template_id" value="" id="assigned_template_id">
                        <input type="hidden" name="template_offer_id" value="" id="template_offer_id">

                    </form>

                </div>
               
                
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
            </div>
        </div>
    </div>
</div>

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<!--form validation-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.validate.min.js"></script>
<!--ajax form submit-->
<script src="<?=base_url();?>assets/admin_panel/js/jquery.form.min.js"></script>
<!--Select2-->
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<script>

    $('.select2').select2();

</script>
<script>
    $(document).ready(function() {
        $('#offer_table').DataTable( {
            "scrollX": false,
            "processing": true,
            "language": {
                processing: '<img src="<?=base_url('assets/img/ellipsis.gif')?>"><span class="sr-only">Processing...</span>',
            },
            "serverSide": true,
            "ajax": {
                "url": "<?=base_url('admin/ajax-offer-marketing-table-data')?>",
                "type": "POST",
                "dataType": "json",
            },
            //will get these values from JSON 'data' variable
            "columns": [
                { "data": "offer_name" },
                { "data": "offer_no" },
                { "data": "offer_date" },
                { "data": "offer_age" },
                { "data": "action" }
            ],
            //column initialisation properties
            "columnDefs": [{
                "targets": [0,1,2,3,4], //disable 'Image','Actions' column sorting
                "orderable": false,
            }],
        } );
    });

    $(document).on('click', '.delete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){

            $offer_id = $(this).data('offer_id');           

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-offer/') ?>",
                dataType: 'json',
                type: 'POST',
                data: {offer_id: $offer_id},
                success: function (returnData) {
                    console.log(returnData);
                    // $this.closest('tr').remove();
                    
                    // obj = JSON.parse(returnData);
                    notification(returnData);

                    //refresh table
                    $("#offer_table").DataTable().ajax.reload();

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }
   
    });
</script>

<script type="text/javascript">

    $(document).on('click', '.settingsModal', function(){
        
        $offer_number = $(this).data('offer_number');
        $offer_name = $(this).data('offer_name');
        $offer_id = $(this).data('offer_id');
        $at_id = $(this).data('at_id');

        $("#template_offer_id").val($offer_id);    
        $("#mar_offer_name").text($offer_name +' ['+ $offer_number + ']');

        $.ajax({
            url: "<?= base_url('admin/ajax-fetch-assigned-templates') ?>/"+$offer_id,
            dataType: 'json',
            type: 'POST',
            success: function (returnData) {
                console.log(returnData);
                returnData = returnData[0];
                // alert(returnData.user_id);
                $("#mar_offer_assigned_to").text(returnData.username)
                $("#mar_offer_assigned_template").text(returnData.template_name)
                $("#marketing_id").val(returnData.user_id).trigger('change')
                $("#vt_name").val(returnData.vt_id).trigger('change')

                if(returnData.user_id != ''){

                    $href1 = "<?=base_url('admin/view-offer')?>/" + $offer_id + "/comp1"
                    $href2 = "<?=base_url('admin/view-offer')?>/" + $offer_id + "/comp2"
                    
                    $("#assigned_template_id").val($at_id)
                    $(".template_assign_update").removeClass('hidden')
                    $(".template_assign_insert").addClass('hidden')
                    $(".view_offer1").attr('href', $href1)
                    $(".view_offer2").attr('href', $href2)

                }else{

                    $(".template_assign_update").addClass('hidden')
                    $(".template_assign_insert").updateClass('hidden')

                }

            },

            error: function (returnData) {

                console.log('return data' + returnData);

                obj = JSON.parse(returnData);
                notification(obj);
                
            }
        });
   
    });

</script>

<script type="text/javascript">
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