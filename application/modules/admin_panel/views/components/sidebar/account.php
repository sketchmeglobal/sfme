<li class="menu-list <?=(($class_name == 'Accounts')) ? 'active' : ''; ?>"><a href=""><i class="fa fa-file-text-o"></i> <span>Accounts</span></a>
    <ul class="child-list">
        <li class="<?= (($class_name == 'Accounts') && ($method_name == 'account_dashboard')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/account-dashboard"><i class="fa fa-vcard-o"></i> <span>Account Dashboard</span></a>
        </li>
        <li class="<?=(($class_name == 'Accounts') && ($method_name == 'proforma_invoice')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/sale-contract"><i class="fa fa-caret-right"></i> <span>Sale Contract (PI)</span></a>
        </li>

        <li class="<?=(($class_name == 'Accounts') && ($method_name == 'purchase_order')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/purchase-order"><i class="fa fa-caret-right"></i> <span>Purchase Order</span></a>
        </li>
        <li class="<?=(($class_name == 'Accounts') && ($method_name == 'payment_intent')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/payment-intent"><i class="fa fa-caret-right"></i> <span>Payment Intent</span></a>
        </li>
    </ul>
</li>