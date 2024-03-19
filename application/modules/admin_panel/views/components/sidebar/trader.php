<li class="menu-list <?=($class_name == 'Offer') ? 'active' : ''; ?>"><a href=""><i class="fa fa-refresh"></i> <span>Offers</span></a>
    <ul class="child-list">
        <li class="<?=(($class_name == 'Offer')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/offers"><i class="fa fa-caret-right"></i> <span>Offer Details</span></a>
        </li>
        <li class="<?=(($this->uri->segment(2) == 'offer-report')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/offer-report"><i class="fa fa-caret-right"></i> <span>Offer Report</span></a>
        </li>
        <li class="<?=(($class_name == 'Offer')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/offer-comments"><i class="fa fa-caret-right"></i> <span>Offer Comments</span></a>
        </li>
    </ul>
</li>
<li class="menu-list <?=(($class_name == 'Accounts')) ? 'active' : ''; ?>"><a href=""><i class="fa fa-file-text-o"></i> <span>Accounts</span></a>
    <ul class="child-list">
        <li class="<?=(($class_name == 'Accounts') && ($method_name == 'payment_intent')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/payment-intent"><i class="fa fa-caret-right"></i> <span>Payment Intent</span></a>
        </li>
    </ul>
</li>