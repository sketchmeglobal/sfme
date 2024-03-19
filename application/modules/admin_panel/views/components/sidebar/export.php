<li class="menu-list <?=($class_name == 'Export') ? 'active' : ''; ?>"><a href=""><i class="fa fa-refresh"></i> <span>Export</span></a>
    <ul class="child-list">
        <li class="<?=(($class_name == 'Export') and ($this->uri->segment(2) == 'export-list')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/export-list"><i class="fa fa-caret-right"></i> <span>Export List</span></a>
            <!-- export-listing -->
        </li>
        <li class="<?=(($class_name == 'Export') and ($this->uri->segment(2) == 'report')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/report"><i class="fa fa-caret-right"></i> <span>Export Report</span></a>
        </li>
        <li class="<?=(($this->uri->segment(2) == 'report_filter_export')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/report_filter_export"><i class="fa fa-caret-right"></i> <span>Offer/Export Report</span></a>
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