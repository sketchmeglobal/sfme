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
    if($documents[0]->shared_with_me != ''){
        $documents1 = $documents[0]->shared_with_me;
        $documents = json_decode($documents1);
        
        $folders = $documents->folders;

        $files = $documents->files;
        }else{
            $folders = array();
            $files = array();
        } 
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
                echo "<li><a href='".base_url().'admin/shared-with-me/0'."'>Home</a></li>".$breadcum_ul_li;
            }
            ?>
            
        </ul>

            <div class="row">
                <div class="col-lg-12 text-right">
                    <!-- <a href="<?= base_url('admin/add-document/'.$parentFolderId.'') ?>" class="btn btn-success  mx-auto"><i class="fa fa-plus"></i> Add <?=$menu?></a> -->
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
                                    <a href="<?= base_url('admin/shared-with-me/'.$folders[$i]->fold_id.'') ?>" >
                                        <i class="fa fa-folder-o" style="font-size:24px"></i>
                                    </a>
                                    </br>
                                    <span><?=$folders[$i]->folderName?> </span>
                                    </br>
                                </div>
                            <?php }//end if
                            }//end for
                            
                            if($fdc == 0){
                                ?>
                                <h5>No Folders shared with you. </h5>
                               <?php
                           }
                            }else{ ?>
                                <h5>No Folders shared with you. </h5>

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
                                    <a href="<?= base_url('admin/shared-with-me/'.$parentFolderId.'') ?>" >
                                        <i class='fa fa-download'></i>
                                    </a>                                    
                                </span>
                            </div>
                            <?php }//end if
                            }//end for

                            if($fc == 0){
                                ?>
                                 <h5>No Files shared with you.</h5>
                                <?php
                            }
                            }else{ ?>
                                <h5>No Files shared with you.</h5>
                            <?php } ?>

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


</body>
</html>