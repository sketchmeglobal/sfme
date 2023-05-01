
<?php
$class_name = $this->router->fetch_class();
$method_name = $this->router->fetch_method();
$user_type = $this->session->usertype;
?>
<style>
    .affix{width:240px;height: 100%;overflow:scroll;}
     .affix::-webkit-scrollbar {
      width: 10px;
    }
    
    /* Track */
     .affix::-webkit-scrollbar-track {
      background: #f1f1f1; 
    }
     
    /* Handle */
     .affix::-webkit-scrollbar-thumb {
      background: #888; 
    }
    
    /* Handle on hover */
     .affix::-webkit-scrollbar-thumb:hover {
      background: #555; 
    }
</style>
<div class="sidebar-left">
    <!--responsive view logo start-->
    <div class="logo theme-logo-bg visible-xs-* visible-sm-*">
        <a href="<?=base_url();?>" target="_blank">
            <img src="<?=base_url();?>assets/img/logo_20px.png" alt="Shilpa Logo">
<!--            <i class="fa fa-home"></i>-->
            <span class="brand-name"><strong><?=WEBSITE_NAME_SHORT;?></strong></span>
        </a>
    </div>
    <!--responsive view logo end-->

    <div class="sidebar-left-info affix">
        <!-- visible small devices start-->
        <div class=" search-field">  </div>
        <!-- visible small devices end-->

        <!--sidebar nav start-->
        <ul class="nav nav-pills nav-stacked side-navigation">

            <!-- ONLY ADMIN RIGHTS -->
            <?php if($user_type == 1){?>

            <li><h3 class="navigation-title">Menu</h3></li>
            <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a>
            </li>

            <li class="<?= (($class_name == 'Profile') && ($method_name == 'profile')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/profile"><i class="fa fa-vcard-o"></i> <span>Profile</span></a>
            </li>

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
                    
                    <li class="<?=(($class_name == 'Master') && ($method_name == 'all_clauses')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/all_clauses"><i class="fa fa-caret-right"></i> All Clauses</a>
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
            
            <li class="menu-list <?=($class_name == 'Accounts') ? 'active' : ''; ?>"><a href=""><i class="fa fa-file-text-o"></i> <span>Accounts</span></a>
                <ul class="child-list">
                    <li class="<?=(($class_name == 'Accounts')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/sale-contract"><i class="fa fa-caret-right"></i> <span>Sale Contract</span></a>
                    </li>
        
                    <li class="<?=(($class_name == 'Accounts')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/purchase-order"><i class="fa fa-caret-right"></i> <span>Purchase Order</span></a>
                    </li>
                </ul>
            </li>

            <li class="menu-list <?=($class_name == 'Settings') ? 'active' : ''; ?>"><a href=""><i class="fa fa-cog"></i> <span>Settings</span></a>
                <ul class="child-list">
                    <li class="<?=(($class_name == 'User') && ($method_name == 'user_managemnt')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/user-management"><i class="fa fa-caret-right"></i> User Management</a>
                    </li>
                    <li class="<?=(($class_name == 'Settings') && ($method_name == '')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/view-templates"><i class="fa fa-caret-right"></i> Templates Report (Offer)</a>
                    </li>
                    <li class="<?=(($class_name == 'Settings') && ($method_name == '')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/view-templates-report"><i class="fa fa-caret-right"></i> Templates Report (Export)</a>
                    </li>
                    <li class="<?=(($class_name == 'Settings') && ($method_name == 'account_templates')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/account_templates"><i class="fa fa-caret-right"></i> Template (SC/PO)</a>
                    </li>

                    <li class="<?=(($class_name == 'Settings') && ($method_name == 'view_report_filter_templates')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/view_report_filter_templates"><i class="fa fa-caret-right"></i> Report Filter Temp</a>
                    </li>
                    
                   <!-- <li class="< ?=(($class_name == 'Settings') && ($method_name == 'mail_templates')) ? 'active' : ''; ?>">
                        <a href="< ?=base_url();?>admin/mail_templates"><i class="fa fa-caret-right"></i> Mail Template</a>
                    </li>-->
                    <li class="<?=(($class_name == 'Settings') && ($method_name == '')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/database-backup"><i class="fa fa-caret-right"></i> Database Backup</a>
                    </li>
                </ul>
            </li>
            <?php } 
            // <!-- ONLY RESOURCE RIGHTS -->
            else if($user_type == 2){ ?>

            <li><h3 class="navigation-title">Menu</h3></li>
            <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a>
            </li>

            <li class="<?= (($class_name == 'Profile') && ($method_name == 'profile')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/profile"><i class="fa fa-vcard-o"></i> <span>Profile</span></a>
            </li>
            
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


            // <!-- ONLY MARKETING RIGHTS -->

            <?php } else if($user_type == 3){ ?>

            <li><h3 class="navigation-title">Menu</h3></li>
            <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a>
            </li>
            <li class="<?= (($class_name == 'Profile') && ($method_name == 'profile')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/profile"><i class="fa fa-vcard-o"></i> <span>Profile</span></a>
            </li>
            <li class="menu-list <?=($class_name == 'Offer') ? 'active' : ''; ?>"><a href=""><i class="fa fa-refresh"></i> <span>Offers</span></a>
                <ul class="child-list">
                    <li class="<?=(($class_name == 'Offer')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/offers-marketing"><i class="fa fa-caret-right"></i> <span>Offer Details</span></a>
                    </li>
        
                    <li class="<?=(($class_name == 'Offer')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/offer-comments"><i class="fa fa-caret-right"></i> <span>Offer Comments</span></a>
                    </li>
                </ul>
            </li>

            <?php } else{ ?>
                
            <li><h3 class="navigation-title">Menu</h3></li>
            <li class="<?=(($class_name == 'Dashboard')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/dashboard"><i class="fa fa-tachometer"></i> <span>Dashboard</span></a>
            </li>
            <li class="<?= (($class_name == 'Profile') && ($method_name == 'profile')) ? 'active' : ''; ?>">
                <a href="<?=base_url();?>admin/profile"><i class="fa fa-vcard-o"></i> <span>Profile</span></a>
            </li>
            <li class="menu-list <?=($class_name == 'Export') ? 'active' : ''; ?>"><a href=""><i class="fa fa-refresh"></i> <span>Export</span></a>
                <ul class="child-list">
                    <li class="<?=(($class_name == 'Export') and ($this->uri->segment(2) == 'export-list')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/export-list"><i class="fa fa-caret-right"></i> <span>Export List</span></a>
                        <!-- export-listing -->
                    </li>
                    <li class="<?=(($this->uri->segment(2) == 'report_filter_export')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/report_filter_export"><i class="fa fa-caret-right"></i> <span>Export Filter</span></a>
                    </li>
                    <li class="<?=(($class_name == 'Export') and ($this->uri->segment(2) == 'report')) ? 'active' : ''; ?>">
                        <a href="<?=base_url();?>admin/report"><i class="fa fa-caret-right"></i> <span>Export Report</span></a>
                        <!-- export-listing -->
                    </li>
                </ul>
            </li>    
                
            <?php } ?>
        </ul>
        <!--sidebar nav end-->

        <!--sidebar widget start-->
        <div class="sidebar-widget">
            <h4>Account Information</h4>
            <ul class="list-group">
                <li>
                    <p>
                        <strong><i class="fa fa-user-circle-o"></i> <span class="username"><?=$this->session->username;?></span></strong>
                        <br/>
                        <strong><i class="fa fa-envelope"></i> <?=$this->session->email;?></strong>
                    </p>
                </li>
                
                <li>
                    <a href="<?=base_url();?>admin/profile" class="btn btn-info btn-sm addon-btn">Edit Info. <i class="fa fa-vcard pull-left"></i></a>
                </li>
            </ul>
        </div>
        <!--sidebar widget end-->

    </div>
</div>