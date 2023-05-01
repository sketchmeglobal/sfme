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
        .modal-dialog{width:90%}
    </style>
    
    <style>
        
        
        /* The actual timeline (the vertical ruler) */
        .timeline {
          position: relative;
          max-width: 1200px;
          margin: 0 auto;
        }
        
        /* The actual timeline (the vertical ruler) */
        .timeline::after {
          content: '';
          position: absolute;
          width: 6px;
          background-color: #000;
          top: 0;
          bottom: 0;
          left: 49.5%;
          outline: 3px solid #dce1fb;
          outline-offset: 1px;
          /*margin-left: -3px;*/
        }
        
        /* Container around content */
        .tcontainer {
          padding: 10px 40px;
          position: relative;
          background-color: inherit;
          width: 49.50%;
        }
        
        /* The circles on the timeline */
        .tcontainer::after { 
          content: '';
          position: absolute;
          width: 25px;
          height: 25px;
          right: -17px;
          background-color: white;
          border: 4px solid #FF9F55;
          top: 15px;
          border-radius: 50%;
          z-index: 1;
        }
        .tbreak{ width: 100%;z-index: 1;text-align: center;position: relative; }
        .tbreak .tcontent{padding:0;background: #607d8b;color: #fff;}
        
        /* Place the container to the left */
        .tleft {
          left: 0;
        }
        
        /* Place the container to the right */
        .tright {
          left: 50%;
        }
        
        /* Add arrows to the left container (pointing right) */
        .tleft::before {
          content: " ";
          height: 0;
          position: absolute;
          top: 22px;
          width: 0;
          z-index: 1;
          right: 30px;
          border: medium solid #c7aeae;
          border-width: 10px 0 10px 10px;
          border-color: transparent transparent transparent #c7aeae;
        }
        
        /* Add arrows to the right container (pointing left) */
        .tright::before {
          content: " ";
          height: 0;
          position: absolute;
          top: 22px;
          width: 0;
          z-index: 1;
          left: 30px;
          border: medium solid #c7aeae;
          border-width: 10px 10px 10px 0;
          border-color: transparent #c7aeae transparent transparent;
        }
        
        /* Fix the circle for containers on the right side */
        .tright::after {
          left: -16px;
        }
        
        /* The actual content */
        .tcontent {
          padding: 20px 30px;
          background-color: #c7aeae;
          position: relative;
          border-radius: 6px;
        }
        
        .tcontent-active{
            outline: 3px dotted red;
            outline-offset: -6px;
            border-radius: 10px;
        }
        
        /* Media queries - Responsive timeline on screens less than 600px wide */
        @media screen and (max-width: 600px) {
          /* Place the timelime to the left */
          .timeline::after {
            left: 31px;
          }
          
          /* Full-width containers */
          .tcontainer {
              width: 100%;
              padding-left: 70px;
              padding-right: 25px;
          }
          
          /* Make sure that all arrows are pointing leftwards */
          .tcontainer::before {
              left: 60px;
              border: medium solid white;
              border-width: 10px 10px 10px 0;
              border-color: transparent white transparent transparent;
          }
        
          /* Make sure all circles are at the same spot */
          .tleft::after, .right::after {
            left: 15px;
          }
          
          /* Make all right containers behave like the left ones */
          .tright {
            left: 0%;
          }
        }
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
                    <?php
                    if($this->session->usertype != 3){
                    ?>
                        <!-- <a href="< ?= base_url('admin/add-offer') ?>" class="btn btn-success  mx-auto"><i class="fa fa-plus"></i> Add <?=$menu?></a> -->
                    <?php
                    }
                    ?>
                    <section class="panel">
                        <div class="panel-body">
                            <table id="export_table" class="table data-table dataTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Offer Name</th>
                                        <th>Offer No.</th>
                                        <th>Offer Date</th>
                                        <th>Offer Age</th>
                                        <th>Supplier Name</th>
                                        <th>Country</th>
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
                <h4 class="modal-title">Assign Templates</h4>
            </div>
            <div class="modal-body">
                
                <!-- for auto open of modal if redirected from dashboard -->
                <div class="col-md-12 panel">
                    <h4 class="text-center bg-primary" style="padding: 1%">
                        Offer name <span id="mar_offer_name"></span> is assigned to <span id="mar_offer_assigned_to"></span>
                        with template <span id="mar_offer_assigned_template"></span>
                    </h4>
                    <form method="POST" class="panel-body">
                        
                        <div class="col-lg-2">
                            <label>Select Resource Developer</label>
                            <select multiple="" id="resource_id" name="resource_id[]" class="select2 form-control">
                                <option value="" selected="" disabled="">Select any options</option>
                                <?php foreach($res_users as $mu){ ?>
                                <option value="<?=$mu->user_id?>"><?=$mu->username?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <label>Select Marketing Personnel</label>
                            <select multiple="" id="marketing_id" name="marketing_id[]" class="select2 form-control">
                                <option value="" selected="" disabled="">Select any options</option>
                                <?php foreach($mar_users as $mu){ ?>
                                <option value="<?=$mu->user_id?>"><?=$mu->username?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-lg-2">
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

<!-- Status modal -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Offer Status</h4>
            </div>
            <div class="modal-body">
                
                <div class="col-md-12 panel">
                    
                    <div class="timeline">
                      <div class="tbreak">
                        <div class="tcontent">
                          <h3>Resource Developer</h3>
                          <p id="sent_to_trader"></p>
                        </div>
                      </div>
                      
                      <div class="tcontainer tleft">
                        <div class="tcontent">
                          <h4>Offer creation</h4><hr>
                          <p id="rd_name_and_date">Raja Das on 13-10-2021</p>
                        </div>
                      </div>
                      
                      <div class="tcontainer tright">
                        <div class="tcontent">
                          <h4>Offer finalisation</h4><hr>
                          <p id="rd_finalise">On 13-10-2021</p>
                        </div>
                      </div>
                      
                      <div class="tcontainer tleft">
                        <div class="tcontent">
                          <h4>Offer requests (pending)</h4><hr>
                          <p id="rd_access_pending">Yes, from 15-09-2021</p>
                        </div>
                      </div>
                      
                      <div class="tbreak">
                        <div class="tcontent">
                          <h3>Trader</h3>
                          <p id="sent_to_trader"></p>
                        </div>
                      </div>
                      
                      <div class="tcontainer tright">
                        <div class="tcontent">
                          <h4>Buying price</h4><hr>
                          <p id="trader_buying_price">Total No of products: <br> Buying price added: </p>
                        </div>
                      </div>
                      <div class="tcontainer tleft">
                        <div class="tcontent">
                          <h4>Selling price</h4><hr>
                          <p id="trader_selling_price">Total No of products: <br> Selling price added: </p>
                        </div>
                      </div>
                      <div class="tcontainer tright">
                        <div class="tcontent">
                          <h4>Templating</h4><hr>
                          <p id="trader_template">Template assigned and finalised: Yes</p>
                        </div>
                      </div>
                      <div class="tcontainer tleft">
                        <div class="tcontent">
                          <h4>Mailing permission</h4><hr>
                          <p id="mail_permission">Mailing permission provided: Yes </p>
                        </div>
                      </div>
                      <div class="tbreak">
                        <div class="tcontent">
                          <h3>Marketer</h3>
                          <p id="sent_to_trader"></p>
                        </div>
                      </div>
                      <div class="tcontainer tright">
                        <div class="tcontent">
                          <h4>Client communication</h4><hr>
                          <p id="trader_template">Mailing status: Done</p>
                        </div>
                      </div>
                      <div class="tcontainer tleft">
                        <div class="tcontent">
                          <h4>Invoicing</h4><hr>
                          <p id="trader_selling_price">PO/PI status: Done </p>
                        </div>
                      </div>
                       <div class="tbreak">
                        <div class="tcontent">
                          <h3>Offer Closed</h3>
                          <p id="sent_to_trader"></p>
                        </div>
                      </div>
                    </div>
                        
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

    $(document).on('click', '.clone', function(){

        $offer_id = $(this).data('offer_id');

         $.ajax({
            url: "<?= base_url('admin/ajax-clone-offer') ?>/"+$offer_id,
            dataType: 'json',
            type: 'POST',
            data: {offer_id: $offer_id},

            success: function (returnData) {
                console.log(returnData);                    
                // obj = JSON.parse(returnData);
                notification(returnData);

                //refresh table
                $("#export_table").DataTable().ajax.reload();

                 if(parseInt(returnData.insert_id) > 0){

                    if(returnData.type == 'error'){
                        setTimeout(function(){ 
                            window.location.href = '<?=base_url()?>admin/edit-offer/'+returnData.insert_id; 
                            }, 3000);
                    }else{
                        window.location.href = '<?=base_url()?>admin/edit-offer/'+returnData.insert_id;
                    }               
                }

            },

            error: function (returnData) {

                console.log('return data' + returnData);

                obj = JSON.parse(returnData);
                notification(obj);
                
            }
        });

    })

</script>
<script>
    $(document).ready(function() {
        $('#export_table').DataTable( {
            "scrollX": true,
            "processing": true,
            "language": {
                processing: '<img src="<?=base_url('assets/img/ellipsis.gif')?>"><span class="sr-only">Processing...</span>',
            },
            "serverSide": true,
            "ajax": {
                "url": "<?=base_url('admin/ajax-export-table-data')?>",
                "type": "POST",
                "dataType": "json",
            },
            "rowCallback": function (row, data) {
                console.log(data);
                if (data.coi != null) {
                    $(row).addClass('bg-green1');
                }
            },
            //will get these values from JSON 'data' variable
            "columns": [
                { "data": "offer_name" },
                { "data": "offer_no" },
                { "data": "offer_date" },
                { "data": "offer_age" },
                { "data": "supplier_name" },
                { "data": "country" },
                { "data": "action" }
            ],
            //column initialisation properties
            "columnDefs": [{
                "targets": [3,4,5], //disable 'Image','Actions' column sorting
                "orderable": false,
            },
            
            ],
           
            "initComplete": function(settings, json) {
                
                var roi = $("#resolve_offer_id").text().trim();
                // var roci = $("#resolve_oc_id").text().trim();

                $("#export_table tr").each(function() { 
                    var pointer = $(this).find('td:last').children('button.all_comments');
                    var oid = $(this).find('td:last').children('button.all_comments').data('offer_id');
                    if(roi == oid){
                        pointer.trigger('click');
                    }
                });

              }
        } );
    });

    $(document).on('click', '.ic', function(){
        
        $full = $(this).find('span').text();
        $(this).html('<span>'+$full+'</span>')

    })

    $(document).on('click', '.finalise', function(){
        $this = $(this);
        if(confirm("This will send current offer data to Admin. You won't be able to edit once you perform the action. Are You Sure?")){

            $offer_id = $(this).data('offer_id');
           
            // alert($co_id +'..'+$inv_id);

            $.ajax({
                url: "<?= base_url('admin/ajax-update-offer-wip') ?>",
                dataType: 'json',
                type: 'POST',
                data: {offer_id: $offer_id},
                success: function (returnData) {
                    // console.log(returnData);                    
                    // obj = JSON.parse(returnData);
                    notification(returnData);

                    //refresh table
                    $("#export_table").DataTable().ajax.reload();

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }
   
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
                    // console.log(returnData);
                    // $this.closest('tr').remove();
                    
                    // obj = JSON.parse(returnData);
                    notification(returnData);

                    //refresh table
                    $("#export_table").DataTable().ajax.reload();

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

    $(document).on('click', '.all_comments', function(){
        $offer_id = $(this).data('offer_id');
        $.ajax({
            url: "<?= base_url('admin/ajax-show-all-comments/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {offer_id: $offer_id},
            success: function (returnData) {
                // console.log(returnData);
                $("#all_offer_comments tbody").html("");
                $.each(returnData, function(index, item) {
                    if(item.status == 1){
                        $actions = "<button data-oc_id="+item.oc_id+" data-permission='accept' class='reedit btn btn-info'>Accept permission</button>";
                        $actions += "<button data-oc_id="+item.oc_id+" data-permission='deny' class='reedit btn btn-danger'>Deny permission</button>";
                    }else{
                        $actions = "Updated on " + item.modified_date;
                    }
                    
                    $str = "<tr><td>"+item.offer_name+"</td><td>"+item.username+"</td><td>"+ item.comment+"</td><td>"+$actions+"</td></tr>";

                    $("#all_offer_comments tbody").append($str);

                });

            },
            error: function (returnData) {
                obj = JSON.parse(returnData);
                notification(obj);
            }
        });
    });

    $(document).on('click', '.reedit', function(){
        $oc_id = $(this).data('oc_id');
        $permission = $(this).data('permission');
        
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){
            $.ajax({
                url: "<?= base_url('admin/ajax-update-offer-comments/') ?>",
                dataType: 'json',
                type: 'POST',
                data: {oc_id: $oc_id, permission: $permission},
                success: function (returnData) {
                    // console.log(returnData);                    
                    // obj = JSON.parse(returnData);
                    notification(returnData);
                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                    $("#commentModal").modal('hide');
                    //refresh table
                    $("#export_table").DataTable().ajax.reload();
                }
            });

        }

    });

    $(document).on('click', '.request', function(){
        $("#offer_id").val($(this).data('offer_id'));
    });

    //add-item-form validation and submit
    $("#request_offer").validate({
        
        rules: {
            comment: {
                required: true
            }
        },
        messages: {

        }
    });
    $('#request_offer').ajaxForm({
        beforeSubmit: function () {
            return $("#request_offer").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            obj = JSON.parse(returnData);
            notification(obj);
        }
    });


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
                mid = returnData.marketing_id.split(',');
                rid = returnData.resource_id.split(',');
                // console.log(mid);
                $("#mar_offer_assigned_to").text(returnData.username)
                $("#mar_offer_assigned_template").text(returnData.template_name)
                $("#marketing_id").val(mid).trigger('change')
                $("#resource_id").val(rid).trigger('change')
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
    
    $(document).on('click', '.statusModal', function(){
        
        $offer_id = $(this).data('offer_id');

        $.ajax({
            url: "<?= base_url('admin/ajax-fetch-offer-status') ?>/"+$offer_id,
            dataType: 'json',
            type: 'POST',
            success: function (returnData) {
                console.log(returnData);
                
                $or_header = returnData.offer_resource_headers[0];
                $str1 = "<i class='fa fa-dot-circle-o'></i> <b> "+ $or_header.offer_name + "</b> is created by <b>" + $or_header.firstname + " " + $or_header.lastname + " </b>on <b>" + $or_header.offer_date + "</b>";
                $str2 = "<br><i class='fa fa-dot-circle-o'></i> <b> " + returnData.rd_product_count + " </b>products(s) incorporated";
                $("#rd_name_and_date").html($str1+$str2);

                $o_header = returnData.offer_headers[0];
                if($o_header.resource_edit_status == 1){
                    $str3 = "<i class='fa fa-dot-circle-o'></i> Offer is <b>not finalised</b> by the Resource Developer"; 
                }else{
                    $str3 = "<i class='fa fa-dot-circle-o'></i> Offer is <b>finalised</b> by the Resource Developer";
                }
                $("#rd_finalise").html($str3);

                $rd_access = returnData.rd_access;
                if($rd_access == 1){
                    $str4 = "<i class='fa fa-dot-circle-o'></i> Offer access grant permission is <b>pending</b> from Trader"; 
                }else{
                    $str4 = "<i class='fa fa-dot-circle-o'></i> Offer access grant permission is <b>not asked</b> to Trader";
                }
                $("#rd_access_pending").html($str4);


                /* TRADER */
                
                $tpc = returnData.trader_product_count;
                $tbpc = returnData.trader_buying_pricing_count;
                $str5 = "<i class='fa fa-dot-circle-o'></i> Total of <b>"+ $tpc + "</b> product(s) are being handled by the Trader";
                $str6 = "<br><i class='fa fa-dot-circle-o'></i> Total of <b>"+ $tbpc + "</b> product(s) buying prices are being handled by the Trader";
                $("#trader_buying_price").html($str5 + $str6);
                
                $tpc = returnData.trader_product_count;
                $tspc = returnData.trader_selling_pricing_count;
                $str7 = "<i class='fa fa-dot-circle-o'></i> Total of <b>"+ $tpc + "</b> product(s) are being handled by the Trader";
                $str8 = "<br><i class='fa fa-dot-circle-o'></i> Total of <b>"+ $tspc + "</b> product(s) buying prices are being handled by the Trader";
                $("#trader_selling_price").html($str7 + $str8);
                
                $tac = returnData.template_assign_count;
                $tfc = returnData.template_finalise_count;
                if($tac == 1){
                    $str9 = "<i class='fa fa-dot-circle-o'></i> Template <b>is assigned</b> by the Trader";    
                }else{
                    $str9 = "<i class='fa fa-dot-circle-o'></i> Template <b>is not assigned</b> by the Trader";    
                }
                
                if($tfc == 1){
                    $str10 = "<br><i class='fa fa-dot-circle-o'></i> Template <b>is finalised  (sent to marketing)</b> by the Trader";    
                }else{
                    $str10 = "<br><i class='fa fa-dot-circle-o'></i> Template <b>is not finalised (sent to marketing)</b> by the Trader";    
                }
                $("#trader_template").html($str9 + $str10);
                
                if($o_header.final_marketing_approval_status == 1){
                    $str11 = "<i class='fa fa-dot-circle-o'></i> Mailing facility is <b>activated</b> by the Trader"; 
                }else{
                    $str11 = "<i class='fa fa-dot-circle-o'></i> Mailing facility is <b>not activated</b> by the Trader"; 
                }
                $("#mail_permission").html($str11);
                
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