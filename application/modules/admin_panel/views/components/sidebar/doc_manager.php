<li class="menu-list <?=(($class_name == 'Accounts')) ? 'active' : ''; ?>"><a href=""><i class="fa fa-file-text-o"></i> <span>Accounts</span></a>
    <ul class="child-list">
        <li class="<?=(($class_name == 'Accounts') && ($method_name == 'payment_intent')) ? 'active' : ''; ?>">
            <a href="<?=base_url();?>admin/payment-intent"><i class="fa fa-caret-right"></i> <span>Payment Intent</span></a>
        </li>
    </ul>
</li>