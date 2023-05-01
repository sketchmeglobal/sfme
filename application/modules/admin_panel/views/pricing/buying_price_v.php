<?php #echo '<pre>',print_r($offer_buying_price), '</pre>'; die; ?>
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
            
            <div class="row text-enter">
                <span class="badge badge-right">Offer: <?=$offer_name?></span>
                <span class="badge badge-left">Product: <?=$product?></span>
            </div>

            <div class="row text-enter">
                <!-- <span class="badge badge-right">Original incoterm in: < ?=$original_incoterm?></span> -->
                <span class="badge badge-left">Original buying price / incoterm : <?=$product_price?> (<?=$currency_symbol?>) / <?=$original_incoterm?></span>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    
                    <div class="panel">
                    <div class="panel-heading">
                        Buying Price Details
                        <span class="tools pull-right">
                            <a class="t-collapse fa fa-chevron-down" href="javascript:;"></a>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form autocomplete="off" id="form_add_buying_price" method="post" action="<?=base_url('admin/form-add-buying-price')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                            <div class="col-lg-2">
                                <label for="incoterm_id text-danger">Incoterms*</label>
                                <select required="" name="incoterm_id" id="incoterm_id" class="form-control select2">
                                    <option value='' disabled selected>Select your option</option>
                                    <?php 
                                    foreach($incoterms as $in){
                                        if($in->incoterm != $original_incoterm){
                                            $disabled = 'disabled';
                                        }else{
                                            $disabled = 'selected';
                                        }
                                        ?>
                                        <option <?=$disabled?> value="<?=$in->it_id?>"><?=$in->incoterm?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="li_category text-danger">Item Type*</label>
                                <select required="" name="li_category" id="li_category" class="form-control select2">
                                    <option value="" disabled selected>Select your option</option>
                                    <option value="Line Item">Line Item</option>
                                    <option value="First Level">First Level</option>
                                    <option value="Second Level">Second Level</option>
                                    <option value="Third Level">Third Level</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="li_id text-danger">Pricing Type*</label>
                                <select required="" name="li_id" id="li_id" class="form-control select2">
                                    <option value="" disabled selected>Select item type first</option>
                                </select>
                            </div>
                            
                            <div class="col-lg-2">
                                <label for="currency_id text-danger">Currency*</label>
                                <select required="" name="currency_id" id="currency_id" class="form-control select2">
                                    <option value='' disabled selected>Select your option</option>
                                    <?php 
                                    foreach($currencies as $ci){
                                        ?>
                                        <option value="<?=$ci->c_id?>"><?=$ci->currency .' ['.$ci->symbol.']'?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label for="buying_price text-danger">Price* (<?=$currency_symbol?>) </label>
                                <input required="" type="number" id="buying_price" name="buying_price" class="form-control">
                            </div>
                            <div class="col-lg-2">
                                <div class="row text-center">
                                    <div class="col-md-6">
                                        <label for="buying_price_submit" id="bps">Add</label><br>
                                        <input type="submit" id="buying_price_submit" name="buying_price_submit" class="btn btn-success" value="Insert">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="buying_price_update" id="bpu">Update</label><br>
                                
                                        <input type="submit" name="buying_price_submit" class="btn btn-success" value="Update">
                                    </div>
                                </div>
                                <!-- HIDDEN FIELDS -->
                                <input required="" type="hidden" id="product_price" name="product_price" value="<?=$product_price?>">
                                <input required="" type="hidden" id="od_id" name="od_id" value="<?=$od_id?>">
                                <input type="hidden" name="bp_id" id="bp_id" value="">
                            </div>
                        </form>    
                    </div>
                </div> 
                                            
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    
                    <button data-toggle="modal" data-target="#exportPricingModal" data-offer_id="<?=$offer_id?>" href="" class="btn bg-warning badge-right export-pricing"><i class="fa fa-check"></i> Export</button>

                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-right">
                    
                    <section class="panel">
                        <div class="panel-body">

                            <table id="buying_price_table" class="table data-table dataTable">
                                <thead>
                                    <tr>
                                        <th>Incoterm</th>
                                        <th>Currency</th>
                                        <th>Line Item</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                    <tr class="bg-green">
                                        <th colspan="5">Product price: <?=$product_price?> (<?=$currency_symbol?>) / <?=$original_incoterm?></th>
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
<div class="modal fade" id="exportPricingModal" tabindex="-1" role="dialog" aria-labelledby="exportPricingModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Export Pricing to other products</h4>
            </div>
            <div class="modal-body">
                <form id="form_export_pricing" method="post" action="<?=base_url('admin/form-export-product-pricing')?>" enctype="multipart/form-data" class="cmxform form-horizontal tasi-form">
                    <div class="form-group ">
                        <label class="control-label col-md-4 text-danger">Select Products*</label>
                        <div class="col-md-4">
                           <select required="" name="od_id" id="old_products" class="form-control select2">
                               <option value="" selected readonly disabled="">Select from the list</option>
                           </select>
                        </div>
                        <div class="col-md-4">
                            <input type="hidden" name="from_odid" value="<?=$od_id?>" id="from_odid">
                            <input type="submit" name="request-submit" value="Export" id="request-submit" class="btn btn-success">
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

<script src="<?=base_url()?>assets/admin_panel/js/data-table-init.js"></script>
<!--Select2-->
<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>
<script>
    $('.select2').select2();
</script>   

<script>
    $(document).ready(function() {
        
        $od_id = $("#od_id").val();
         var groupColumn = 0;
        $('#buying_price_table').DataTable( {
            "processing": true,
            "language": {
                processing: '<img src="<?=base_url('assets/img/ellipsis.gif')?>"><span class="sr-only">Processing...</span>',
            },
            "serverSide": true,
            "ajax": {
                "url": "<?=base_url('admin/ajax-buying-price-table-data')?>/"+$od_id,
                "type": "POST",
                "dataType": "json",
            },
            //will get these values from JSON 'data' variable
            "columns": [
                { "data": "incoterm" },
                { "data": "line_item" },
                { "data": "currency" },
                { "data": "buying_price" },
                { "data": "action" }
            ],
            //column initialisation properties
            "columnDefs": [{
                "targets": [1,2,3], //disable 'Image','Actions' column sorting
                "orderable": false,
            }],
            "initComplete": function(settings, json) {
                
                // nothing now

              },
              "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;
                    var subTotal = new Array();
                    var groupID = -1;
                    var aData = new Array();
                    var index = 0;
                    
                    api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                    
                      var vals = api.row(api.row($(rows).eq(i)).index()).data();
                      console.log(vals.buying_price);
                      var buying_price = vals.buying_price ? parseFloat(vals.buying_price) : 0;
                       
                        if (typeof aData[group] == 'undefined') {
                         aData[group] = new Array();
                         aData[group].rows = [];
                         aData[group].buying_price = [];
                        }
                  
                        aData[group].rows.push(i); 
                        aData[group].buying_price.push(buying_price); 
                        
                    });
            
                    var idx= 0;              
                    for(var incoterm in aData){
               
                        idx =  Math.max.apply(Math,aData[incoterm].rows);
              
                        var sum = 0; 
                        $.each(aData[incoterm].buying_price,function(k,v){
                            sum = sum + v;
                        });
                        var final = parseFloat($("#product_price").val());
                        console.log(aData[incoterm].buying_price);
                        $(rows).eq( idx ).after(
                            '<tr class="group"><td colspan="3">'+incoterm+' (inclusive product price)</td>'+
                            '<td style="text-align: center">'+ parseFloat(sum+final).toFixed(2)  +' (<?=$currency_symbol?>) </td><td></td></tr>'
                        ); 

                    };
                }
              // "drawCallback": function ( settings ) {
              //       var api = this.api();
              //       var rows = api.rows( {page:'current'} ).nodes();
              //       var last=null;
         
              //       api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
              //           if ( last !== group ) {
              //               $(rows).eq( i ).before(
              //                   '<tr class="group"><td colspan="5">'+group+'</td></tr>'
              //               );
         
              //               last = group;
              //           }
              //       } );
              //   }
        } );
    });

    /*edit area*/

    $(document).on('click', '.buying_price_edit_btn', function(){
        $this = $(this);
        $bp_id = $(this).data('bp_id');  

        $.ajax({
            url: "<?= base_url('admin/fetch-buying-price-on-pk/') ?>/"+$bp_id,
            dataType: 'json',
            type: 'POST',
            // data: {bp_id: $bp_id},
            success: function (data) {

                console.log(data);    
                data = data[0];
                $("#buying_price_table").find('tr').removeClass('bg-green1')
                $this.closest('tr').addClass('bg-green1');

                $("#bp_id").val($bp_id);

                $("#li_category").val(data.line_item_category).trigger('change')
                
                $("#incoterm_id").val(data.incoterm_id).trigger('change');
                $("#currency_id").val(data.currency_id).trigger('change');
                $("#buying_price").val(data.buying_price);

                setTimeout(function(){ 
                    $("#li_id").val(data.li_id).trigger('change');
                }, 500);
            }
        })        

    });

    /* DELETE AREA */
    $(document).on('click', '.delete', function(){
        $this = $(this);
        if(confirm("Are You Sure? This Process Can\'t be Undone.")){

            $bp_id = $(this).data('bp_id');           

            $.ajax({
                url: "<?= base_url('admin/ajax-delete-buying-price') ?>/"+$bp_id,
                dataType: 'json',
                type: 'POST',
                data: {bp_id: $bp_id},
                success: function (returnData) {
                    console.log(returnData);
                                       
                    // obj = JSON.parse(returnData);
                    notification(returnData);

                    //refresh table
                    $("#buying_price_table").DataTable().ajax.reload();

                },
                error: function (returnData) {
                    obj = JSON.parse(returnData);
                    notification(obj);
                }
            });
        }   
    });
</script>

<!-- NEW BUYING PRICE ADD -->

<script type="text/javascript">

    $('#li_category').on('change', function(){
        $type = $(this).val();
        $.ajax({
            url: "<?= base_url('admin/fetch-line-items-on-type/') ?>",
            dataType: 'json',
            type: 'POST',
            data: {type: $type},
            success: function (returnData) {
                console.log(returnData);                
                $("#li_id").html("<option value='' disabled selected>Select your option</option>");
                $.each(returnData, function (index, itemData) {
                   $str = '<option value="'+itemData.li_id+'">'+itemData.line_item_name+'</option>';
                   $("#li_id").append($str);
                });
                // $("#li_id").select2("open")
            }
        })

    });

    $("#form_add_buying_price").validate({
        rules: {
            li_category: {
                required: true,
            },
            incoterm_id: {
                required: true
            },
            li_id: {
                required: true
            },
            buying_price: {
                required: true
            },
            currency_id: {
                required: true
            }
        },
        messages: {

        }
    });
    $('#form_add_buying_price').ajaxForm({
        beforeSubmit: function () {
            return $("#form_add_buying_price").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            obj = JSON.parse(returnData);
            notification(obj);

            $("#bp_id").val("");

            //refresh table
            $('#buying_price_table').DataTable().ajax.reload();
        }
    });
</script>

<!-- Export  -->
<script type="text/javascript">
    
    $(".export-pricing").click(function(){
        
        $offer_id = $(this).data('offer_id');

        $.ajax({
            url: "<?= base_url('admin/fetch-offer-products-on-offer_id/') ?>/"+$offer_id,
            dataType: 'json',
            type: 'POST',
            // data: {type: $type},
            success: function (returnData) {
                console.log(returnData);                
                $("#old_products").html("<option value='' disabled selected>Select your option</option>");
                $.each(returnData, function (index, itemData) {

                    if(itemData.od_id != <?=$od_id?>){
                        $str = '<option value="'+itemData.od_id+'">'+itemData.product_name+ ' ['+itemData.scientific_name+']'+'</option>';
                         $("#old_products").append($str);
                    }
                   
                  
                });
                // $("#old_products").select2("open")
            }
        })

    });

    $("#form_export_pricing").validate({
        rules: {
            old_products: {
                required: true
            }
        },
        messages: {

        }
    });
    $('#form_export_pricing').ajaxForm({
        beforeSubmit: function () {
            return $("#form_export_pricing").valid(); // TRUE when form is valid, FALSE will cancel submit
        },
        success: function (returnData) {
            obj = JSON.parse(returnData);
            notification(obj);
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