<?php 
 function fetch_country_name($cid){
     $sql = "SELECT DISTINCT acc_master.name FROM `sell_price_details` 
     LEFT JOIN acc_master ON acc_master.am_id = sell_price_details.am_id
     WHERE offer_id = $cid";
     $ci = & get_instance();
     $res = $ci->db->query($sql)->result();
     if(isset($res[0])){
        return $res[0]->name; 
     }else{
        return '';    
     }
 }
?>
<?php  ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Report | <?= $template_name ?></title>
    <meta name="description" content="Report">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"/>
    
    <style>
    .table tr:nth-child(even){background-color: #bfb8b8;}
    tr.hide-table-padding td {
    padding: 0;
    }
    .expand-button {
    position: relative;
    }
    .accordion-toggle .expand-button:after
    {
    position: absolute;
    left:.75rem;
    top: 50%;
    transform: translate(0, -50%);
    content: '-';
    }
    .accordion-toggle.collapsed .expand-button:after
    {
    content: '+';
    }
    .modal-body table{width:100%;}
    .modal-body table th, .modal-body table td, .modal-body table tr{border:1px solid;}
    td .table-bordered thead td, .table-bordered thead th{padding:0;font-size: 13px;text-align: center;}
    td table td{font-size:12px;}
    .inner-table{width:100%;}
    .inner-table thead tr{background-color: #2c2c2c!important;}
    .inner-table th,.inner-table td{padding:0!important;}
    table.dataTable tbody th, table.dataTable tbody td{padding: 5px;font-size: 12px;vertical-align: middle;}
    
    .dt-buttons.btn-group{border:1px solid; padding:0 15px;}
    .dt-buttons button:nth-child(1){background: #607d8b;color: #fff;margin-right:6px;}
    .dt-buttons button:nth-child(2){background: #4caf50;color: #fff;margin-right:6px;}
    .dt-buttons button:nth-child(3){background: #ff9800;color: #fff;margin-right:6px;}
    
    .dataTables_length{margin: auto;border: 1px solid;padding: 0 15px;}
    input[type="search"]{border:1px solid;}
    #accordionExample .card{border:1px solid;}
    .dataTables_paginate {margin-left:auto;}
    .previous, .next{background: aliceblue;border: 1px solid #dae4ed;}
    
    tfoot tr input{width:100px;}
    
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
            <div class="col-11 mx-auto">
                
                <div class="bg-dark text-white p-3 mb-5">
                    <?= $template_name ?>
                    <span title="Expand all" id="expand_summary" class="font-weight-bolder btn btn-success float-right px-2 py-1">Summary</span>
                </div>
                
                <!--<div class="accordion mb-5" id="accordionExample">-->
                <!--  <div class="card">-->
                <!--    <div class="card-header" id="headingOne">-->
                <!--      <h2 class="mb-0">-->
                <!--        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">-->
                <!--          <h6 class="my-0">Advanced Search</h6>-->
                <!--        </button>-->
                <!--      </h2>-->
                <!--    </div>-->
                
                <!--    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">-->
                <!--      <div class="card-body">-->
                <!--        <div class="container-fluid">-->
                            
                <!--            <form method="post">-->
                <!--              <div class="row">-->
                <!--                <div class="col">-->
                <!--                    <label>Filter On</label>-->
                <!--                    <select name="date_category" class="form-control">-->
                <!--                      <option value="ddrc">Drafts Doc. Rcv. Date </option>-->
                <!--                      <option value="ddsd">Drafts Doc. Send. Date </option>-->
                <!--                      <option value="etd">ETD</option>-->
                <!--                      <option value="eta">ETA</option>-->
                <!--                      <option value="atd">ATD</option>-->
                <!--                      <option value="ata">ATA</option>-->
                <!--                    </select>-->
                <!--                </div>-->
                <!--                <div class="col">-->
                <!--                    <label>Min date</label>-->
                <!--                    <input class="form-control" type="date" id="min" placeholder="Min date" />-->
                <!--                </div>    -->
                <!--                <div class="col">-->
                <!--                    <label>Max date</label>-->
                <!--                    <input class="form-control" type="date" id="max" placeholder="Max date" />-->
                <!--                </div>-->
                <!--              </div>-->
                <!--            </form>-->
                            
                <!--        </div>-->
                <!--      </div>-->
                <!--    </div>-->
                <!--  </div>-->
                <!--</div>-->
                
            </div>
            
          <div class="col-11 mx-auto">
            <?php  
                // echo "<pre>";
                //   $array = json_decode(json_encode($report_data['export_data']), true);
                //   print_r($array);
                // echo "<pre>";
                                $temp = explode(',', $report_data['template']->export_header_fields);
                ?>
                                <table class="table table-hover table-bordered dataTable">
                                    <thead>
                                        <tr>
                                          <!--<th style="text-transform: capitalize; background-color: #bfb8b8;">Expand</th>-->
                                            <th style="background-color: #bfb8b8;">Sl. No</th>
                                              <?php for ($i=0; $i < @count($temp); $i++) { ?>
                                              <?php if($temp[$i] == "offer_id"){ ?>
                                              <th style="text-transform: capitalize; background-color: #bfb8b8;"><?php echo  "Offer Name" ?></th>
                                              <?php }elseif ($temp[$i] == "name"){ ?>
                                              <th style="text-transform: capitalize; background-color: #bfb8b8;"><?php echo  "Vendor Name"; ?></th>
                                              <?php }else{ ?>
                                              <th style="text-transform: capitalize; background-color: #bfb8b8;"><?php echo  str_replace('_',' ',$temp[$i]) ?></th>
                                              <?php } ?>
                                              <?php } ?>
                                            <th  style="text-transform: capitalize; background-color: #bfb8b8;">Summary</th>  
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <!--<th style="text-transform: capitalize; background-color: #bfb8b8;">Expand</th>-->
                                            <th style="background-color: #bfb8b8;">Sl.NO</th>
                                              <?php for ($i=0; $i < @count($temp); $i++) { ?>
                                              <?php if($temp[$i] == "offer_id"){ ?>
                                              <th style="text-transform: capitalize; background-color: #bfb8b8;"><?php echo  "Offer Name" ?></th>
                                              <?php }elseif ($temp[$i] == "name"){ ?>
                                              <th style="text-transform: capitalize; background-color: #bfb8b8;"><?php echo  "Vendor Name"; ?></th>
                                              <?php }else{ ?>
                                              <th style="text-transform: capitalize; background-color: #bfb8b8;"><?php echo  str_replace('_',' ',$temp[$i]) ?></th>
                                              <?php } ?>
                                              <?php } ?>
                                            <th  style="text-transform: capitalize; background-color: #bfb8b8;">Summary</th>  
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $export_data = json_decode(json_encode($report_data['export_data']), true);
                                        foreach ($export_data as $key => $value) { ?>
                                        <!-- loop start -->
                                        <tr class="accordion-toggle collapsed" id="accordion<?=$key?>" data-toggle="collapse" data-parent="#accordion<?=$key?>" href="#collapseOne<?=$key?>">
                                          <!--<td class="expand-button"></td>-->
                                          <td><?php echo $key + 1 ?></td>
                                          <?php for ($i=0; $i < count($temp); $i++) { ?>
                                          <?php if($temp[$i] == "offer_id"){ ?>
                                          <td><?php echo $value['offer_name']; ?></td>
                                          <?php }elseif($temp[$i] == "customer"){ ?>
                                          <td>
                                              <?= fetch_country_name($value['cusname']) ?>
                                          </td>
                                          <?php }elseif($temp[$i] == "actual_sale_amt"){ ?>
                                          <td>
                                             <?=$value['actual_sale_symbol'] . $value['actual_sale_amt']?>
                                          </td>
                                      <?php }elseif($temp[$i] == "insurance"){ ?>
                                             <td>
                                              <?php
                                                if ($value['insurance'] > 0) {?>
                                                  <?=$value['insurance_currency_symbol'] . $value['insurance']?>
                                               <?php }
                                              ?>
                                            </td>
                
                                      <?php }elseif($temp[$i] == "frieght"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['frieght'] > 0) {?>
                                                      <?=$value['frieght'] . $value['frieght_currency_symbol']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "pi_sales_amt"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['pi_sales_amt'] > 0) {?>
                                                      <?=$value['pi_sales_currency_symbol'] . $value['pi_sales_amt']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "po_purch_amt"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['po_purch_amt'] > 0) {?>
                                                      <?=$value['po_purch_currency_symbol'] . $value['po_purch_amt']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "vend_inv_amt"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['vend_inv_amt'] > 0) {?>
                                                      <?=$value['vend_inv_currency_symbol'] . $value['vend_inv_amt']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "vend_inv_amt"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['vend_inv_amt'] > 0) {?>
                                                      <?=$value['vend_inv_currency_symbol'] . $value['vend_inv_amt']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "adv_amt_to_vendor"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['adv_amt_to_vendor'] > 0) {?>
                                                      <?=$value['adv_vend_currency_symbol'] . $value['adv_amt_to_vendor']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "adv_paid_to_vendor"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['adv_paid_to_vendor'] > 0) {?>
                                                      <?=$value['adv_paid_vend_currency_symbol'] . $value['adv_paid_to_vendor']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "adv_amt_from_cust"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['adv_amt_from_cust'] > 0) {?>
                                                      <?=$value['adv_amt_cust_currency_symbol'] . $value['adv_amt_from_cust']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "adv_amt_from_cust"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['adv_amt_from_cust'] > 0) {?>
                                                      <?=$value['adv_amt_cust_currency_symbol'] . $value['adv_amt_from_cust']?> 
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }elseif($temp[$i] == "adv_recd_from_cust"){ ?>
                                              <td>
                                                  <?php
                                                    if ($value['adv_recd_from_cust'] > 0) {?>
                                                      <?=$value['adv_recd_from_cust_currency_symbol'] . $value['adv_recd_from_cust']?>
                                                   <?php }
                                                  ?>
                                              </td>
                                      <?php }else{ ?>
                                      <td><?php 
                                          if (array_key_exists($temp[$i], $value)) {
                                              echo $value[$temp[$i]];
                                          }
                                      ?></td>
                                      <?php } ?>
                                      <!-- loop end -->
                                      <?php } ?>
                                    <td> 
                                        <div>
                                            <table class="text-center inner-table"> 
                                              <thead class="bg-dark text-white">
                                                <tr>
                                                  <th>Product Name</th>
                                                  <th>Grade</th>
                                                  <th>Pcs</th>
                                                  <th>Size</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                                <?php foreach ($report_data['products'][$key] as $key => $productrow) { ?>
                                                <tr>
                                                  <td><?=$productrow->product_name?></td>
                                                  <td><?=$productrow->grade?></td>
                                                  <td><?=$productrow->pieces?></td>
                                                  <td><?=$productrow->size?></td>
                                                </tr>
                                                <?php } ?>
                                              </tbody>
                                            </table>
                                        </div>
                                    </td>
                                  </tr>
                      
                      <?php } ?>
                                      </tbody>
                                  </table>
                              </div>
                        </div>
                    </div>
            <!--body wrapper end-->
            <!--footer section start-->
            <?php //$this->load->view('components/footer'); ?>
            <!--footer section end-->
            <!-- body content end-->
          </section>
          
          <!--modal area-->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <!--<h4 class="modal-title">Modal Header</h4>-->
                    </div>
                    <div class="modal-body">
                      <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div>
          
          
          <script src="<?=base_url()?>assets/admin_panel/js/jquery-1.10.2.min.js"></script>

          <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

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
          <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.13.4/api/processing().js"></script>
          <!--data table init-->
          <script src="<?=base_url()?>assets/admin_panel/js/data-table-init.js"></script>
          <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>-->
          <!--form validation-->
          <!--<script src="<?=base_url();?>assets/admin_panel/js/jquery.validate.min.js"></script>-->
          <!--ajax form submit-->
          <!--<script src="<?=base_url();?>assets/admin_panel/js/jquery.form.min.js"></script>-->
          <!--Select2-->
          <!--<script src="<?=base_url();?>assets/admin_panel/js/select2.js" type="text/javascript"></script>-->
          
          <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
          <script src="https://cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>
          <script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>
          
          <script type="text/javascript">
              
            //   var minDate, maxDate;

            //     // Custom filtering function which will search data in column four between two values
            //     $.fn.dataTable.ext.search.push(
            //     function( settings, data, dataIndex ) {
                    
            //         var min = minDate.val();
            //         var max = maxDate.val();
                    
            //         str = data[6].slice(10);
            //         if(str == 0){return}
            //         console.log(str)
                    
            //         if (
            //             ( min === null && max === null ) ||
            //             ( min === null && date <= max ) ||
            //             ( min <= date && max === null ) ||
            //             ( min <= date && date <= max )
            //             ) {
            //             return true;
            //         }
            //             return false;
            //     });
                
                $(document).ready(function() {
                    
                    // Create date inputs
                    // minDate = new DateTime($('#min'), {
                    //     format: 'Do MMMM YYYY'
                    // });
                    // maxDate = new DateTime($('#max'), {
                    //     format: 'Do MMMM YYYY'
                    // });
                
                // DataTables initialisation
                $('tfoot th').each(function () {
                    var title = $(this).text();
                    $(this).html('<input type="text" placeholder="'+title+'" />');
                });
                var table = $('.dataTable').DataTable({
                    dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            exportOptions: {
                                // columns: [1, 2, 3, 4, 6]
                                columns: ':not(:last-child)'
                            },
                            action: function(e, dt, button, config) {
                                var that = this;
                                $('table > tbody  > tr').each(function(index, tr) { 
                                   $(this).find('td span.d-none').remove();
                                });
                                dt.processing(true);
                                setTimeout(function() {
                                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(that, e, dt, button, config);
                                    dt.processing(false);
                                }, 10);
                                
                            }
                        },
                        'copy', 'print'
                    ], 
                    aLengthMenu: [
                        [5, 10, 25, 50, 100, 200, -1],
                        ['5 Rows', '10 Rows', '25 Rows', '50 Rows', '100 Rows', '200 Rows', "All"]
                    ],
                    // iDisplayLength: -1,
                    // columnDefs: [ { orderable: false, targets: [1,2,6,7,8,10,11,12] }]
                    initComplete: function () {
                        // Apply the search
                        this.api()
                            .columns()
                            .every(function () {
                                var that = this;
             
                                $('input', this.footer()).on('keyup change clear', function () {
                                    if (that.search() !== this.value) {
                                        that.search(this.value).draw();
                                    }
                                });
                            });
                    },
                });
                
                // Refilter the table
                $('#min, #max').on('change', function () {
                    table.draw();
                });
                });

                
                
                
              $('table tr').click(function(){
                //   console.log($(this))
                //   $str = ($(this).next('tr').find('td:last-child .collapse').html());
                //   $("#myModal .modal-body").html($str);
                //   $("#myModal").modal();
              })
              
              $(".dataTable th:last-child, .dataTable td:last-child").hide();    
              $('#expand_summary').click(function(){
                $(".dataTable th:last-child, .dataTable td:last-child").toggle();    
              })
              
              
          </script>
        </body>
      </html>