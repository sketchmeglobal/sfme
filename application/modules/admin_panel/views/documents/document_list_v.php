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
<?php
    if(sizeof($documents) > 0){
    $document_id = $documents[0]->document_id;
    $documents1 = $documents[0]->documents;
    $documents = json_decode($documents1);
    
    $folders = $documents->folders;

    $files = $documents->files;
    }else{
        $folders = array();
        $files = array();
    }  

?>

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
        <ul class="breadcrumb">
            <?php if($parentFolderId == 0){?>
            <li><a href="#">Home</a></li>
            <?php } else if($parentFolderId > 0){
                echo "<li><a href='".base_url().'admin/my-documents/0'."'>Home</a></li>".$breadcum_ul_li;
            }
            ?>
            
        </ul>

            <div class="row">
                <div class="col-lg-12 text-right">
                    <a href="<?= base_url('admin/add-document/'.$parentFolderId.'') ?>" class="btn btn-success  mx-auto"><i class="fa fa-plus"></i> Add <?=$menu?></a>
                    <section class="panel">

                        <div class="panel-body" style="text-align: left;">
                            <h3>Folders</h3>

                            <!-- https://www.w3schools.com/icons/fontawesome_icons_webapp.asp -->

                            <?php
                            if(sizeof($folders) > 0){
                                $fdc = 0;
                                
                            for($i = 0; $i < sizeof($folders); $i++){
                                if($folders[$i]->parentFolderId == $parentFolderId){
                                    $fdc++;

                            ?>
                            
                                <div class="col-lg-2">
                                    <a href="<?= base_url('admin/my-documents/'.$folders[$i]->fold_id.'') ?>" >
                                        <i class="fa fa-folder-o" style="font-size:24px"></i>
                                    </a>
                                    </br>
                                    <span id="foldNameSpan_<?=$folders[$i]->fold_id?>"><?=$folders[$i]->folderName?> </span>
                                    </br>
                                    <span id="foldNameInputSpan_<?=$folders[$i]->fold_id?>" style="display: none;"> <input type="text" name="folderNameEdit_<?=$folders[$i]->fold_id?>" id="folderNameEdit_<?=$folders[$i]->fold_id?>" value="<?=$folders[$i]->folderName?>" onBlur="folderNameUpdate('<?=$folders[$i]->fold_id?>')"></span>
                                    </br>
                                    <span>
                                        <a href="javascript: void(0)" id="folderEdit" fold_id="<?=$folders[$i]->fold_id?>"  folderName="<?=$folders[$i]->folderName?>">
                                            <i class='fa fa-edit'></i>
                                        </a>
                                        <a href="javascript:void(0)" id="folderDelete" fold_id="<?=$folders[$i]->fold_id?>" parentFolderId="<?=$parentFolderId?>">
                                            <i class='fa fa-trash'></i>
                                        </a> 
                                        <a href="javascript: void(0)" id="rootFolderId" fold_id="<?=$folders[$i]->fold_id?>">
                                            <i class='fa fa-share'  data-toggle="modal" data-target=".bd-example-modal-lg"></i>
                                        </a>
                                    </span>
                                </div>
                            <?php }//end if
                            }//end for
                            
                            if($fdc == 0){
                                ?>
                                <h5>No Folders available, please add new.</h5>
                               <?php
                           }
                            }else{ ?>
                                <h5>No Folders available, please add new.</h5>
                            <?php } ?>

                        </div>

                        

                        <div class="panel-body" style="text-align: left;">
                            <h3>Files</h3>
                            <!-- https://www.w3schools.com/icons/fontawesome_icons_filetype.asp -->
                            <?php
                            if(sizeof($files) > 0){
                                $fc = 0;
                                $extType = '';
                            for($j = 0; $j < sizeof($files); $j++){                                
                                if($files[$j]->parentFolderId == $parentFolderId){
                                    $fc++;
                                    $file_ext = $files[$j]->meta_data->file_ext;
                                    if($file_ext == '.xlsx'){
                                        $extType = '-excel';
                                    }else if($file_ext == '.png' || $file_ext == '.jpg' || $file_ext == '.jpeg' || $file_ext == '.bmp'){
                                        $extType = '-image';
                                    }else if($file_ext == '.mp4'){
                                        $extType = '-movie';
                                    }else if($file_ext == '.docx'){
                                        $extType = '-word';
                                    }else if($file_ext == '.zip'){
                                        $extType = '-zip';
                                    }else if($file_ext == '.pdf'){
                                        $extType = '-pdf';
                                    }else if($file_ext == '.txt'){
                                        $extType = '-text';
                                    }else{
                                        $extType = '';
                                    }    

                            ?>
                            <div class="col-lg-2">
                                <i class="fa fa-file<?=$extType?>-o" style="font-size:24px"></i>
                                </br>
                                <span><?=$files[$j]->file_name?></span>
                                </br>
                                <span>
                                    <a href="<?= base_url('upload/documents//'.$files[$j]->file_name.'') ?>" download>
                                        <i class='fa fa-download'></i>
                                    </a>
                                    <a href="javascript:void(0)" id="fileDelete" file_id="<?=$files[$j]->file_id?>" parentFolderId="<?=$parentFolderId?>">
                                        <i class='fa fa-trash'></i>
                                    </a>
                                    
                                </span>
                            </div>
                            <?php }//end if
                            }//end for

                            if($fc == 0){
                                ?>
                                 <h5>No Files available, please add new.</h5>
                                <?php
                            }
                            }else{ ?>
                                <h5>No Files available, please add new.</h5>

                            <?php } ?>

                        </div>

                    </section>
                </div>
            </div>

        </div>
        <!--body wrapper end-->

        <!-- Modal Start -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Share With</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <select title="If none selected then permission for all" multiple="" name="sharedWith[]" id="sharedWith" class="form-control select2" style="min-height: 600px; padding-left: 17px;">                                            
                <?php
                if($user_details[0]->usertype != 4){                
                    foreach($acc_masters as $am){
                        ?>
                        <option value="<?=$am->am_id?>"><?=$am->name. ' ['.$am->am_code.']'?></option>
                        <?php
                    }                
                }else{                
                    foreach($acc_masters as $am){
                        ?>
                        <option value="<?=$am->offer_id?>"><?=$am->offer_name. ' ['.$am->offer_fz_number.']'?></option>
                        <?php
                    }                
                }                
                ?>            
            </select>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="shareDocument">Share</button>
            </div>
            </div>
        </div>
        </div>
        <!-- Modal End -->

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
    //Edit Folder
    $(document).on('click', '#folderEdit', function(){
        $this = $(this);

        $fold_id = $(this).attr('fold_id');  
        $folderName = $(this).attr('folderName');   
        
        $('#foldNameSpan_'+$fold_id).hide();
        $('#foldNameInputSpan_'+$fold_id).show();

        
    });  

    function folderNameUpdate($fold_id){
        $folderNameEdit = $('#folderNameEdit_'+$fold_id).val();
        $('#foldNameSpan_'+$fold_id).html($folderNameEdit);
        $('#foldNameSpan_'+$fold_id).show();
        $('#foldNameInputSpan_'+$fold_id).hide();

        $.ajax({
            url: "<?= base_url('admin/ajax-edit-document/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {fold_id: $fold_id, folderNameEdit: $folderNameEdit},
            success: function (returnData) {
                //console.log(returnData);  
                //obj = JSON.parse(returnData); 
                if(returnData.type == 'success'){                
                    notification(returnData);                    
                }

            },
            error: function (returnData) {
                obj = JSON.parse(returnData);
                notification(obj);
            }
        });

    }//end

    //Delete Folder
    $(document).on('click', '#folderDelete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){

            $fold_id = $(this).attr('fold_id');  
            $parentFolderId = $(this).attr('parentFolderId');         

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-document/') ?>",
                dataType: 'json',
                type: 'POST',
                data: {fold_id: $fold_id, parentFolderId: $parentFolderId},
                success: function (returnData) {
                    console.log(returnData);  
                    //obj = JSON.parse(returnData);                 
                    notification(returnData);
                    if(returnData.type == 'success'){
                    console.log('parentFolderId: '+returnData.parentFolderId);
                        //refresh table Files
                        setTimeout(function(){
                            window.location.href = '<?=base_url()?>admin/my-documents/'+ $parentFolderId;
                        }, 3000);
                    }

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }   
    });  

    //Delete File
    $(document).on('click', '#fileDelete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){

            $file_id = $(this).attr('file_id');  
            $parentFolderId = $(this).attr('parentFolderId');         

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-document/') ?>",
                dataType: 'json',
                type: 'POST',
                data: {file_id: $file_id, parentFolderId: $parentFolderId},
                success: function (returnData) {
                    console.log(returnData);  
                    //obj = JSON.parse(returnData);                 
                    notification(returnData);
                    if(returnData.type == 'success'){
                        //refresh table Files
                        setTimeout(function(){
                            window.location.href = '<?=base_url()?>admin/my-documents/'+ $parentFolderId;
                        }, 3000);
                    }

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }   
    });

    //shareDocument 
    $(document).on('click', '#shareDocument', function(){
        $this = $(this); 

        $dataSharedWith = [];
        $el = $("#sharedWith");
        $el.find('option:selected').each(function(){
            $dataSharedWith.push({value:$(this).val(), text:$(this).text()});
        });
        console.log($dataSharedWith);

        $.ajax({
            url: "<?= base_url('admin/ajax-share-document/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {dataSharedWith: $dataSharedWith, rootFolderId: $rootFolderId},
            success: function (returnData) {
                //console.log(returnData);  
                //obj = JSON.parse(returnData);                 
                notification(returnData);
                if(returnData.type == 'success'){
                    //refresh table Files
                $('.modal').modal('hide');
                }

            },
            error: function (returnData) {
                obj = JSON.parse(returnData);
                notification(obj);
            }
        });
        
    });

    //rootFolderId
    $(document).on('click', '#rootFolderId', function(){
        $this = $(this); 
        $rootFolderId = $(this).attr('fold_id');
        console.log('rootFolderId: '+$rootFolderId)
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