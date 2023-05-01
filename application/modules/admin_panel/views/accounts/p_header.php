    <?php 
        // echo '<pre>', print_r($header), '</pre>';
        echo (isset($company->company_logo)) ? '<img style="margin: auto;display: block;" src="'.base_url().'assets/img/'.$company->company_logo .'"/>' : '';
    ?>
    
    
    <div class="row text-center text-uppercase mar_bot_3">
        <h3 class="head_font"><?=(!empty($company->company_name)?$company->company_name:'')?></h3>
        <small><?=(!empty($company->company_name)?$company->address:'')?></small>
    </div>
    <div class="row">
        <hr style="border-bottom: 2px solid #000; margin: 0 0 5px">
    </div>
    <div class="row border_bottom mar_bot_3">
        <h4 class="mar_0 bold">Attention: <?= $header[0]->order_to_contact ?></h4>
    </div>
    <div class="row border-bottom-double text-center mar_bot_3">
        <h4 class="mar_0 bold">Sales Contract</h4>
    </div>