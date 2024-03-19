
<li class="menu-list <?=($class_name == 'Master') ? 'active' : ''; ?>"><a href=""><i class="fa fa-wrench"></i> <span>Master Tables</span></a>
    <ul class="child-list">

        <li class="<?=(($class_name == 'Master') && ($method_name == 'account_master')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/account_master"><i class="fa fa-caret-right"></i> Account Masters</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'bank')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/bank"><i class="fa fa-caret-right"></i> Bank </a>
        </li>

            <li class="<?=(($class_name == 'Master') && ($method_name == 'company')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/company"><i class="fa fa-caret-right"></i> Company </a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'units')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/units"><i class="fa fa-caret-right"></i> Units</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'color')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/colors"><i class="fa fa-caret-right"></i> Colors</a>
        </li>
        
        <li class="<?=(($class_name == 'Master') && ($method_name == 'word_color')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/word-colors"><i class="fa fa-caret-right"></i> Word Colors</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'responsible_purchase')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/responsible-purchase"><i class="fa fa-caret-right"></i> Responsible Purchase</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'responsible_sales')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/responsible-sales"><i class="fa fa-caret-right"></i> Responsible Sales</a>
        </li>


        <li class="<?=(($class_name == 'Master') && ($method_name == 'responsible_logistic')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/responsible-logistic"><i class="fa fa-caret-right"></i> Responsible Logistic</a>
        </li>

        
        <li class="<?=(($class_name == 'Master') && ($method_name == 'incoterms')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/incoterms"><i class="fa fa-caret-right"></i> Incoterms</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'countries')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/countries"><i class="fa fa-caret-right"></i> Countries</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'ports')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/ports"><i class="fa fa-caret-right"></i> Ports</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'freezing')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/freezing"><i class="fa fa-caret-right"></i> Freezing</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'packing_types')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/packing_types"><i class="fa fa-caret-right"></i> Packing Types</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'packing_sizes')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/packing_sizes"><i class="fa fa-caret-right"></i> Packing Sizes</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'glazing')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/glazing"><i class="fa fa-caret-right"></i> Glazing</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'blocks')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/blocks"><i class="fa fa-caret-right"></i> Blocks</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'sizes')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/sizes"><i class="fa fa-caret-right"></i> Sizes</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'currencies')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/currencies"><i class="fa fa-caret-right"></i> Currencies</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'products')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/products"><i class="fa fa-caret-right"></i> Products</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'remark1_offer_validity')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/remark1_offer_validity"><i class="fa fa-caret-right"></i> Offer Validity (Remark 1)</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'line_items')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/line_items"><i class="fa fa-caret-right"></i> Line items</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'freight_master')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/freight_master"><i class="fa fa-caret-right"></i> Freight Master</a>
        </li>

            <li class="<?=(($class_name == 'Master') && ($method_name == 'offer_status')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/offer_status"><i class="fa fa-caret-right"></i> Offer Status</a>
        </li>
        
        <li class="<?=(($class_name == 'Master') && ($method_name == 'payment_terms')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/payment_terms"><i class="fa fa-caret-right"></i> Payment Terms</a>
        </li>
        
        <li class="<?=(($class_name == 'Master') && ($method_name == 'payment_types')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/payment_types"><i class="fa fa-caret-right"></i> Payment Types</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'all_clauses')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/all_clauses"><i class="fa fa-caret-right"></i> All Clauses</a>
        </li>

        <li class="<?=(($class_name == 'Master') && ($method_name == 'all_remakrs')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/all-remarks"><i class="fa fa-caret-right"></i> All Remarks</a>
        </li>
        
    </ul>
</li>
    
<li class="menu-list <?=($class_name == 'Offer') ? 'active' : ''; ?>"><a href=""><i class="fa fa-refresh"></i> <span>Offers</span></a>
    <ul class="child-list">
        <li class="<?=(($this->uri->segment(2) == 'offers')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/offers"><i class="fa fa-caret-right"></i> <span>Offer Details</span></a>
        </li>

        <li class="<?=(($this->uri->segment(2) == 'offer-comments')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/offer-comments"><i class="fa fa-caret-right"></i> <span>Offer Comments</span></a>
        </li>
        <li class="<?=(($this->uri->segment(2) == 'offer-report')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/offer-report"><i class="fa fa-caret-right"></i> <span>Offer Report</span></a>
        </li>

        <li class="<?=(($this->uri->segment(2) == 'report_filter')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/report_filter"><i class="fa fa-caret-right"></i> <span>Offer Filter</span></a>
        </li>
    </ul>
</li>

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

<li class="menu-list <?=($class_name == 'Settings') ? 'active' : ''; ?>"><a href=""><i class="fa fa-file-pdf-o"></i> <span>Templates</span></a>
    <ul class="child-list">
        
        <li class="<?=(($class_name == 'Settings') && ($method_name == '')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/view-templates"><i class="fa fa-caret-right"></i> Templates Report (Offer)</a>
        </li>
        <li class="<?=(($class_name == 'Settings') && ($method_name == '')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/view-templates-report"><i class="fa fa-caret-right"></i> Templates Report (Export)</a>
        </li>
        <li class="<?=(($class_name == 'Settings') && ($method_name == 'account_templates')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/account_templates"><i class="fa fa-caret-right"></i> Template Report (SC/PO)</a>
        </li>

        <li class="<?=(($class_name == 'Settings') && ($method_name == 'view_report_filter_templates')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/view_report_filter_templates"><i class="fa fa-caret-right"></i> Template Report (Offer/Export)</a>
        </li>
        
        <!-- <li class="< ?=(($class_name == 'Settings') && ($method_name == 'mail_templates')) ? 'active' : ''; ?>">
            <a href="< ?=base_url();?>admin/mail_templates"><i class="fa fa-caret-right"></i> Mail Template</a>
        </li>-->
    </ul>
</li>    
<li class="menu-list <?=($class_name == 'Settings') ? 'active' : ''; ?>"><a href=""><i class="fa fa-cog"></i> <span>Settings</span></a>
    <ul class="child-list">
        <li class="<?=(($class_name == 'User') && ($method_name == 'user_managemnt')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/user-management"><i class="fa fa-caret-right"></i> User Management</a>
        </li>
        <li class="<?=(($class_name == 'Settings') && ($method_name == '')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/database-backup"><i class="fa fa-caret-right"></i> Database Backup</a>
        </li>
    </ul>
</li>