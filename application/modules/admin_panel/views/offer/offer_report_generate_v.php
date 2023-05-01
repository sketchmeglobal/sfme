<?php  ?>
<?php  ?>
<?php  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Report | <?=WEBSITE_NAME;?></title>
    <meta name="description" content="Report">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

    <!--Data Table-->
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/DataTables-1.10.18/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Buttons-1.5.6/css/buttons.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/admin_panel/js/DataTables/Responsive-2.2.2/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <!--Select2-->
    <link href="<?=base_url();?>assets/admin_panel/css/select2.css" rel="stylesheet">
    <link href="<?=base_url();?>assets/admin_panel/css/select2-bootstrap.css" rel="stylesheet">

    <!-- common head -->
    <?php //$this->load->view('components/_common_head'); ?>
    <!-- /common head -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

    <style>
      /*.table tr:nth-child(even){background-color: #bfb8b8;}*/


      .tradertbl th{
        font-size: 12px;
        text-transform: capitalize;
        text-align: center;
      }
    </style>
    
</head>

<body >

<section>
    <!-- body content start-->

        <!--body wrapper start-->
        <div class="container-fluid pl-0" >
         <!--  <div class="row ">
                <div class="col-lg-12 ">
                  <div class=" bg-success text-white text-center ">
                        <h4 style="padding: 47px;">Generate Report</h4>
                    </div>
                </div>
          </div>     -->    
          <div class="row mt-3">
              <div class="col-12">
                <div class="row p-3">
                  <!-- <div class="col-lg-12 text-right">
                    <button type="button" class="btn btn-success" onclick="offerPrint()">Print</button>
                  </div> -->
                </div>
              	<?php  /*echo "<pre>";
                $array = json_decode(json_encode($report_data['export_data']), true);
                print_r($array);*/
                 //die();

               //echo "<pre>";

                $temp = explode(',', $report_data['template'][0]->offer_header_fields);


                /*echo "<pre>";

                print_r($report_data['offer_data']);

                die();*/

                if (count($report_data['offer_data']) < 2) {
                ?>

                <div class="row p-3">
                  <div class="col-lg-12">
                    <table class="table table-hover table-bordered ">
                  <?php $offer_data = json_decode(json_encode($report_data['offer_data']), true); ?>
                   <?php foreach ($offer_data as $key => $value) { ?>
                    <?php for ($i=0; $i < count($temp); $i++) { ?>

                   <?php if($temp[$i] == "am_id"){ ?>
                   <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','supplier_name')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['supplier_name']; ?></td>
                   </tr>

                   <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','supplier_code')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['supplier_code']; ?></td>
                   </tr>

                   
                   <?php }elseif ($temp[$i] == "c_id") {?>
                    <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','currency')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['currency']; ?></td>
                   </tr>

                   <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','currency_code')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['currency_code']; ?></td>
                   </tr>
                   
                 <?php }elseif ($temp[$i] == "country_id") { ?>
                 <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','destination_country_name')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['destination_country_name']; ?></td>
                  </tr>
                  <tr>
                      <th style="border: 1px solid black;">ISO</th>
                      <td style="border: 1px solid black;"><?php echo $value['destination_country_iso']; ?></td>
                  </tr>
                 <?php }elseif ($temp[$i] == "destination_c_id") {?>


                   <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','source_country_name')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['source_country_name']; ?></td>
                  </tr>
                  <tr>
                      <th style="border: 1px solid black;">ISO</th>
                      <td style="border: 1px solid black;"><?php echo $value['source_country_iso']; ?></td>
                  </tr>
                  


                 <?php }elseif ($temp[$i] == "resource_id") { ?>

                  <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','Resource Developer Name')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['firstname']." ".$value['lastname']; ?></td>
                  </tr>
                <?php }elseif ($temp[$i] == "remarks_1") { ?>
                  <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','Offer Validity')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['remark']; ?></td>
                  </tr>
                <?php }elseif ($temp[$i] == "incoterm_id") { ?>

                  <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ','incoterm')) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value['incoterm']; ?></td>
                  </tr>
                <?php }else if($temp[$i] == "destination_country"){?>

                  <tr>
                      <th style="border: 1px solid black;">Destination Country</th>
                      <td style="border: 1px solid black;">
                        <?php
                          $myArray = explode(',', $value['destination_c_id']);
                          $this->db->select('name');
                          $this->db->where_in('country_id', $myArray);
                          foreach ($this->db->get('countries')->result() as $key => $countriesvalue) {
                            echo $countriesvalue->name.' ';
                          }
                          //echo $value['destination_c_id']; 
                        ?>
                      </td>
                  </tr>
                   
                   <?php 
                 }else if ($temp[$i] == "source_country") {
                  ?>

                  <tr>
                      <th style="border: 1px solid black;">Source Country</th>
                      <td style="border: 1px solid black;">
                        <?php
                          $myArray = explode(',', $value['country_id']);
                          $this->db->select('name');
                          $this->db->where_in('country_id', $myArray);
                          foreach ($this->db->get('countries')->result() as $key => $scountriesvalue) {
                            echo $scountriesvalue->name.' ';
                          }
                        ?>
                      </td>
                  </tr>


                <?php }else if($temp[$i] == "buying_incoterm"){ ?>
                    <tr>
                      <th style="border: 1px solid black;">Bying Incoterm</th>
                      <td style="border: 1px solid black;">
                        <?php
                          //$myArray = explode(',', $value['country_id']);
                          $this->db->select('incoterm');
                          $this->db->where('it_id', $value['incoterm_id']);
                          foreach ($this->db->get('incoterms')->result() as $key => $incoterm_val) {
                            echo $incoterm_val->incoterm.' ';
                          }
                        ?>
                      </td>
                    </tr>
                <?php }else{ ?>

                  <tr>
                      <th style="border: 1px solid black;"><?php echo  ucwords(str_replace('_',' ',$temp[$i])) ?></th>
                      <td style="border: 1px solid black;"><?php echo $value[$temp[$i]]; ?></td>
                  </tr>


                <?php }}} ?>

                </table>
                  </div>
                </div>
              <?php }else{ ?>

                <table class="table table-hover table-bordered ">
                  <thead>
                    <tr>
                      <th style="background-color: #bfb8b8;">Sl.NO</th>
                      <?php for ($i=0; $i < count($temp); $i++) { ?>
                      <th scope="col" style="text-transform: capitalize; background-color: #bfb8b8;"><?php echo  str_replace('_',' ',$temp[$i]) ?></th>
                    <?php } ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $offer_data = json_decode(json_encode($report_data['offer_data']), true);
                    foreach ($offer_data as $key => $value) { ?>
                    <tr>
                      <td><?php echo $key + 1 ?></td>
                      <?php for ($i=0; $i < count($temp); $i++) { ?>
                      <td><?php echo $value[$temp[$i]]; ?></td>
                    <?php } ?>
                    </tr>
                     <?php } ?>
                  </tbody>
                </table>

              <?php } ?>

                <!-- resource developer product start -->
                <?php if(!empty($report_data['resuorce_developer']) && count($report_data['resuorce_developer']) > 0){ ?>
                  <div class="row p-3">
                    <div class="col-lg-12">
                        <table class="table table-hover table-bordered w-100 ">
                          <thead>
                          <tr>
                            <th colspan="16" class="text-center">RESOURCE DEVELOPER PRODUCT DETAILS</th>
                          </tr>
                          <tr class="tradertbl">
                            <th>Product Name</th>
                            <th>Incoterm  </th>
                            <th>Freezing Type </th>
                            <th>Packing type (primary)</th>
                            <th>Packing type (secondary)</th>
                            <th>Packing Sizes </th>
                            <th>Freezing Method </th>
                            <th>Glazing</th>
                            <th>Block</th>
                            <th>Sizes</th>
                            <th>Size before Glaze </th>
                            <th>Size after Glaze</th>
                            <th>Cartons Offered</th>
                            <th>Quantity Offered</th>
                            <th>Product Price </th>
                            <th>Total Value</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $offer_data = $report_data['offer_data'][0]; ?>
                          <?php foreach ($report_data['resuorce_developer'] as $key => $resuorce_developer) { ?>
                            <tr>
                              <td width="350px"><?= $resuorce_developer->product_name; ?></td>
                              <td><?= $offer_data->incoterm; ?></td>
                              <td><?= $resuorce_developer->freezing_type; ?></td>
                              <td><?= $resuorce_developer->packing_type; ?></td>
                              <td><?= $resuorce_developer->pts; ?></td>
                              <td><?= $resuorce_developer->packing_size; ?></td>
                              <td><?= $resuorce_developer->freezing_method; ?></td>
                              <td><?= $resuorce_developer->glazing; ?></td>
                              <td><?= $resuorce_developer->block_size; ?></td>
                              <td width="100px"><?= $resuorce_developer->size.'<br>('.$resuorce_developer->unit.')'; ?></td>
                              <td><?= $resuorce_developer->size_before_glaze; ?></td>
                              <td><?= $resuorce_developer->size_after_glaze; ?></td>
                              <td><?= $resuorce_developer->cartons_offered; ?></td>
                              <td><?= $resuorce_developer->quantity_offered; ?></td>
                              <td><?= $resuorce_developer->product_price.'  '.$offer_data->currency.'('.$offer_data->currency_symbol.')'; ?></td>
                              <td><?= $resuorce_developer->quantity_offered * $resuorce_developer->product_price; ?></td>
                            </tr>
                          <?php } ?>
                          

                        </tbody>
                        </table>
                    </div>
                  </div>
              <?php } ?>
              <!-- resource developer product end -->
                <!-- trader product start -->
                <?php if(!empty($report_data['trader']) && count($report_data['trader']) > 0){ ?>
                <div class="row p-3">
                    <div class="col-lg-12">
                        <table class="table table-hover table-bordered w-100 ">
                        <thead>
                          <tr>
                            <th colspan="16" class="text-center">TRADER PRODUCT DETAILS</th>
                          </tr>
                          <tr class="tradertbl">
                            <th>Product Name</th>
                            <th>Incoterm  </th>
                            <th>Freezing Type </th>
                            <th>Packing type (primary)</th>
                            <th>Packing type (secondary)</th>
                            <th>Packing Sizes </th>
                            <th>Freezing Method </th>
                            <th>Glazing</th>
                            <th>Block</th>
                            <th>Sizes</th>
                            <th>Size before Glaze </th>
                            <th>Size after Glaze</th>
                            <th>Cartons Offered</th>
                            <th>Quantity Offered</th>
                            <th>Product Price </th>
                            <th>Total Value</th>
                          </tr>
                        </thead>

                        <tbody>
                          <?php $offer_data = $report_data['offer_data'][0]; ?>
                          <?php foreach ($report_data['trader'] as $key => $trader) { ?>
                            <tr>
                              <td width="350px"><?= $trader->product_name; ?></td>
                              <td><?= $offer_data->incoterm; ?></td>
                              <td><?= $trader->freezing_type; ?></td>
                              <td><?= $trader->packing_type; ?></td>
                              <td><?= $trader->pts; ?></td>
                              <td><?= $trader->packing_size; ?></td>
                              <td><?= $trader->freezing_method; ?></td>
                              <td><?= $trader->glazing; ?></td>
                              <td><?= $trader->block_size; ?></td>
                              <td width="100px"><?= $trader->size.'<br>('.$trader->unit.')'; ?></td>
                              <td><?= $trader->size_before_glaze; ?></td>
                              <td><?= $trader->size_after_glaze; ?></td>
                              <td><?= $trader->cartons_offered; ?></td>
                              <td><?= $trader->quantity_offered; ?></td>
                              <td><?= $trader->product_price.'  '.$offer_data->currency.'('.$offer_data->currency_symbol.')'; ?></td>
                              <td><?= $trader->quantity_offered * $trader->product_price; ?></td>
                            </tr>
                          <?php } ?>
                          

                        </tbody>
                      </table>
                    </div>
                </div>
              <?php } ?>
              <!-- trader product end -->
              </div>
          </div>

        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <?php //$this->load->view('components/footer'); ?>
        <!--footer section end-->

    <!-- body content end-->
</section>

<!-- Request modal -->


<!-- Comments modal -->


<!-- View (Settings) modal -->


<!-- Status modal -->


<!-- Placed js at the end of the document so the pages load faster -->
<script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>

<!-- common js -->

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


    function offerPrint(){
      window.print();
    }


   // $(".table").dataTable();

</script>

</body>
</html>