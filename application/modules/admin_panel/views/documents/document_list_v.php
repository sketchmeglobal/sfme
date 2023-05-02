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

    <!-- common head -->
    <?php $this->load->view('components/_common_head'); ?>
    <!-- /common head -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style type="text/css">
        .ic label{text-decoration: underline;cursor: pointer;}
        /*.ic span{text-decoration: none;cursor: default;}*/
        .bg-green2{background: #bebde1;color: #000;border: 1px solid #14a95d;}
        .bg-green3{background: #bdb6b6;color: #000;border: 1px solid #14a95d;}
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
                <div class="col-lg-12 text-right">
                    <a href="<?= base_url('admin/add-document') ?>" class="btn btn-success  mx-auto"><i class="fa fa-plus"></i> Add <?=$menu?></a>
                    <section class="panel">
                        <!-- <div class="panel-body">
                            <table id="user_table" class="table data-table dataTable">
                                <thead>
                                    <tr>
                                        <th>Usertype</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div> -->

                        <div class="panel-body" style="text-align: left;">
                            <h3>Folders</h3>

                            <!-- https://www.w3schools.com/icons/fontawesome_icons_webapp.asp -->

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Documents</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Files</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Photoes</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Music</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Videos</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Projects</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>Downloads</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Payslip</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-folder-o" style="font-size:24px"></i>
                                </br>
                                <span>My Folder</span>
                            </div>
                            

                            

                        </div>

                        

                        <div class="panel-body" style="text-align: left;">
                            <h3>Files</h3>
                            <!-- https://www.w3schools.com/icons/fontawesome_icons_filetype.asp -->

                            <div class="col-lg-2">
                                <i class="fa fa-file-pdf-o" style="font-size:24px"></i>
                                </br>
                                <span>myCV.pdf</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-file-excel-o" style="font-size:24px"></i>
                                </br>
                                <span>student_list.xlsx</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-file-image-o" style="font-size:24px"></i>
                                </br>
                                <span>img-01:02:12.jpeg</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-file-movie-o" style="font-size:24px"></i>
                                </br>
                                <span>screen-record.mp4</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-file-text-o" style="font-size:24px"></i>
                                </br>
                                <span>data.txt</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-file-word-o" style="font-size:24px"></i>
                                </br>
                                <span>holiday.docs</span>
                            </div>

                            <div class="col-lg-2">
                                <i class="fa fa-file-zip-o" style="font-size:24px"></i>
                                </br>
                                <span>all-documents.zip</span>
                            </div>

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


<script>
    /*$(document).ready(function() {
        $('#user_table').DataTable( {
            // "scrollX": true,
            "processing": true,
            "language": {
                processing: '<img src="<?=base_url('assets/img/ellipsis.gif')?>"><span class="sr-only">Processing...</span>',
            },
            "serverSide": true,
            "ajax": {
                "url": "<?=base_url('admin/ajax-user-table-data')?>",
                "type": "POST",
                "dataType": "json",
            },
            "rowCallback": function (row, data) {
                // console.log(data);
                if (data.usertype == 'Resource Developer') {
                    $(row).addClass('bg-green1');
                }
                if (data.usertype == 'Exporter') {
                    $(row).addClass('bg-green2');
                }
                if (data.usertype == 'Marketing') {
                    $(row).addClass('bg-green3');
                }
            },
            //will get these values from JSON 'data' variable
            "columns": [
                { "data": "usertype" },
                { "data": "name" },
                { "data": "username" },
                { "data": "action" }
            ],
            //column initialisation properties
            "columnDefs": [{
                "targets": [1,2,3], //disable 'Image','Actions' column sorting
                "orderable": false,
            },
            // {
            //     "targets": [10],
            //     "visible": false
            // },
            { 
                "className": "nowrap", 
                "targets": [ 3 ] 
            },
            { 
                "className": "ut", 
                "targets": [ 0 ] 
            },
            ],
           
            "initComplete": function(settings, json) {   

              }
        } );
    });*/

   

    $(document).on('click', '.delete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){

            $user_id = $(this).data('user_id');           

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-user/') ?>",
                dataType: 'json',
                type: 'POST',
                data: {user_id: $user_id},
                success: function (returnData) {
                    console.log(returnData);
                   
                    notification(returnData);

                    //refresh table
                    $("#user_table").DataTable().ajax.reload();

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