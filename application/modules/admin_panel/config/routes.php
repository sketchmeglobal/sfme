<?php

	$route['admin/dashboard'] = 'admin_panel/Dashboard/dashboard';
	$route['404'] = 'admin_panel/Dashboard/error_404';
	$route['js_disabled'] = 'admin_panel/Dashboard/js_disabled';
	
	$route['admin/profile'] = 'admin_panel/Profile/profile';
	$route['admin/form_basic_info'] = 'admin_panel/Profile/form_basic_info';
	$route['admin/form_change_pass'] = 'admin_panel/Profile/form_change_pass';
	$route['admin/form_change_email'] = 'admin_panel/Profile/form_change_email';
	$route['admin/change_email/(:any)'] = 'admin_panel/Profile/change_email/$1';
	$route['admin/ajax_username_check'] = 'admin_panel/Profile/ajax_username_check';
	$route['admin/form_change_username'] = 'admin_panel/Profile/form_change_username';
	
	
	// MASTER AREA STARS 
	$route['admin/colors'] = 'admin_panel/Master/colors';
	$route['admin/word-colors'] = 'admin_panel/Master/word_colors';
	$route['admin/units'] = 'admin_panel/Master/units';
	$route['admin/incoterms'] = 'admin_panel/Master/incoterms';
	$route['admin/products'] = 'admin_panel/Master/products';
	$route['admin/bank'] = 'admin_panel/Master/bank';
	$route['admin/offer_status'] = 'admin_panel/Master/offer_status';
	$route['admin/payment_terms'] = 'admin_panel/Master/payment_terms';
	$route['admin/all_clauses'] = 'admin_panel/Master/all_clauses';
	
	$route['admin/account_master'] = 'admin_panel/Master/account_master';
	$route['admin/ports'] = 'admin_panel/Master/ports';
	$route['admin/countries'] = 'admin_panel/Master/countries';
	$route['admin/remark1_offer_validity'] = 'admin_panel/Master/remark1_offer_validity';
	$route['admin/freezing'] = 'admin_panel/Master/freezing';
	$route['admin/packing_types'] = 'admin_panel/Master/packing_types';
	$route['admin/packing_sizes'] = 'admin_panel/Master/packing_sizes';
	$route['admin/glazing'] = 'admin_panel/Master/glazing';
	$route['admin/blocks'] = 'admin_panel/Master/blocks';
	$route['admin/sizes'] = 'admin_panel/Master/sizes';
	$route['admin/currencies'] = 'admin_panel/Master/currencies';
	$route['admin/line_items'] = 'admin_panel/Master/line_items';
	$route['admin/freight_master'] = 'admin_panel/Master/freight_master';

	$route['admin/company'] = 'admin_panel/Master/company';

	$route['admin/responsible-purchase'] = 'admin_panel/Master/responsible_purchase';
	$route['admin/responsible-sales'] = 'admin_panel/Master/responsible_sales';

	$route['admin/responsible-logistic'] = 'admin_panel/Master/responsible_logistic';

	// OFFER COMMENTS

	$route['admin/offer-comments'] = 'admin_panel/Offer/offer_comments';

	// USER MANAGEMENT

	/*list*/
	$route['admin/user-management'] = 'admin_panel/User/user_management';
	$route['admin/ajax-user-table-data'] = 'admin_panel/User/ajax_user_table_data';

		/*add user*/
	$route['admin/add-user'] = 'admin_panel/User/add_user';	
	$route['admin/ajax-unique-username'] = 'admin_panel/User/ajax_unique_username';	
	$route['admin/acc_master-on-usertype'] = 'admin_panel/User/acc_master_on_usertype';		
	$route['admin/form-add-user'] = 'admin_panel/User/form_add_user';	

		/*edit*/
	$route['admin/edit-user/(:num)'] = 'admin_panel/User/edit_user/$1';	
 	$route['admin/form-edit-user'] = 'admin_panel/User/form_edit_user';
 	$route['admin/ajax-unique-username-edit'] = 'admin_panel/User/ajax_unique_username_edit';

		/*delete*/
	$route['admin/ajax-delete-user'] = 'admin_panel/User/ajax_delete_user';	

	// OFFER LIST AREA
	$route['admin/offers'] = 'admin_panel/Offer/offer';
	$route['admin/offer-temp'] = 'admin_panel/Offer/offer_temp';
	$route['admin/ajax-offer-table-data'] = 'admin_panel/Offer/ajax_offer_table_data';
	$route['admin/ajax-update-offer-wip'] = 'admin_panel/Offer/ajax_update_offer_wip';
	$route['admin/request-offer'] = 'admin_panel/Offer/request_offer';
	$route['admin/ajax-show-all-comments'] = 'admin_panel/Offer/ajax_show_all_comments';
	$route['admin/ajax-update-offer-comments'] = 'admin_panel/Offer/ajax_update_offer_comments';

	$route['admin/offers-marketing'] = 'admin_panel/Offer/offers_marketing';
	$route['admin/ajax-offer-marketing-table-data'] = 'admin_panel/Offer/ajax_offer_marketing_table_data';



	// EXPORT LIST AREA
	$route['admin/export-listing'] = 'admin_panel/Export/export';
	$route['admin/ajax-export-table-data'] = 'admin_panel/Export/ajax_export_table_data';
	
	$route['admin/export-list'] = 'admin_panel/Export/export_list';
	$route['admin/export-list-segment/(:any)'] = 'admin_panel/Export/export_list_segment/$1';
	
	$route['admin/export-add'] = 'admin_panel/Export/add_export';
	$route['admin/form-add-export'] = 'admin_panel/Export/form_add_export';
	$route['admin/form-edit-export'] = 'admin_panel/Export/form_edit_export';
	$route['admin/export-edit/(:num)'] = 'admin_panel/Export/export_edit/$1';

	$route['admin/get_price_details'] = 'admin_panel/Export/get_price_details';



	$route['admin/export-list/(:any)'] = 'admin_panel/Export/export_list';
	$route['admin/export-list/(:any)/(:any)'] = 'admin_panel/Export/export_list';
	$route['admin/export-list/(:any)/(:any)/(:any)'] = 'admin_panel/Export/export_list';

	$route['admin/export-report-list/(:num)'] = 'admin_panel/Export/view_export_report_list/$1';

	$route['admin/add-export-product-qty'] = 'admin_panel/Export/add_export_product_qty';

	
	// OFFER ADD AREA
	$route['admin/add-offer'] = 'admin_panel/Offer/add_offer';
	$route['admin/ajax-unique-offer-number'] = 'admin_panel/Offer/ajax_unique_offer_number';
	$route['admin/form-add-offer'] = 'admin_panel/Offer/form_add_offer';

	// OFFER CLONE AREA
	$route['admin/ajax-clone-offer/(:num)'] = 'admin_panel/Offer/ajax_offer_clone/$1';

	// OFFER EDIT AREA
	$route['admin/edit-offer/(:num)'] = 'admin_panel/Offer/edit_offer/$1';
	$route['admin/ajax-unique-offer-number-edit'] = 'admin_panel/Offer/ajax_unique_offer_number_edit';
	$route['admin/form-edit-offer'] = 'admin_panel/Offer/form_edit_offer';
	$route['admin/ajax-offer-details-table-data'] = 'admin_panel/Offer/ajax_offer_details_table_data';
	$route['admin/fetch-offer-details-on-pk'] = 'admin_panel/Offer/fetch_offer_details_on_pk';

	$route['admin/form-add-offer-details'] = 'admin_panel/Offer/form_add_offer_details';
	$route['admin/form-edit-offer-details'] = 'admin_panel/Offer/form_edit_offer_details';
	$route['admin/ajax-fetch-assigned-templates/(:num)'] = 'admin_panel/Offer/ajax_fetch_assigned_templates/$1';
	$route['admin/ajax-fetch-offer-status/(:num)'] = 'admin_panel/Offer/ajax_fetch_offer_status/$1';

	$route['admin/update-final-marketing-approval-status/(:num)'] = 'admin_panel/Offer/update_final_marketing_approval_status/$1';

	// OFFER PRICING AREA - Buying
		/*add*/
	$route['admin/offer-buying-price/(:num)/(:num)'] = 'admin_panel/Pricing/offer_buying_price/$1/$2';	
	$route['admin/fetch-line-items-on-type'] = 'admin_panel/Pricing/fetch_line_items_on_type';
	$route['admin/form-add-buying-price'] = 'admin_panel/Pricing/add_buying_price';

		/*edit*/
	$route['admin/fetch-buying-price-on-pk/(:num)'] = 'admin_panel/Pricing/fetch_buying_price_on_pk/$1';

		/*list*/
	$route['admin/ajax-buying-price-table-data/(:num)'] = 'admin_panel/Pricing/ajax_buying_price_table_data/$1';
	
		/*export*/
	$route['admin/fetch-offer-products-on-offer_id/(:num)'] = 'admin_panel/Pricing/fetch_offer_products_on_offer_id/$1';

	$route['admin/form-export-product-pricing'] = 'admin_panel/Pricing/form_export_product_pricing';

	$route['admin/form-export-product-selling-pricing'] = 'admin_panel/Pricing/form_export_product_selling_pricing';

		/*delete*/
	$route['admin/ajax-delete-buying-price/(:num)'] = 'admin_panel/Pricing/ajax_delete_buying_price/$1';	

	// OFFER PRICING AREA - Selling

	$route['admin/offer-selling-price/(:num)/(:num)'] = 'admin_panel/Pricing/offer_selling_price/$1/$2';

		/*list*/
	$route['admin/ajax-selling-price-table-data/(:num)'] = 'admin_panel/Pricing/ajax_selling_price_table_data/$1';
	$route['admin/ajax-selling-price-details-table-data/(:num)/(:num)'] = 'admin_panel/Pricing/ajax_selling_price_details_table_data/$1/$2';

		/*add*/
	$route['admin/form-add-selling-price'] = 'admin_panel/Pricing/add_selling_price';	
		/*edit*/
	$route['admin/fetch-selling-price-on-pk/(:num)'] = 'admin_panel/Pricing/fetch_selling_price_on_pk/$1';

		/*delete*/
	$route['admin/ajax-delete-selling-price/(:num)'] = 'admin_panel/Pricing/ajax_delete_selling_price/$1';	
	$route['admin/ajax-delete-selling-price-details/(:num)'] = 'admin_panel/Pricing/ajax_delete_selling_price_details/$1';	

		/*marketing*/
	$route['admin/form-add-country-wise-selling-price'] = 'admin_panel/Pricing/add_country_wise_selling_price';

	// OFFER EXPORT AREA
	$route['admin/form-export-offer-details'] = 'admin_panel/Offer/form_export_offer_details';

	// OFFER DELETE AREA
	$route['admin/del-row-offer-details'] = 'admin_panel/Offer/del_row_offer_details';
	$route['admin/del-row-offer-files'] = 'admin_panel/Offer/delete_offer_files';
	$route['admin/ajax-delete-offer'] = 'admin_panel/Offer/ajax_delete_offer';

	// OFFER REPORT
	$route['admin/view-offer/(:num)/(:num)'] = 'admin_panel/Offer/view_offer/$1/$2';


	// OFFER REPORT

	$route['admin/offer-report'] = 'admin_panel/Offer/report';
	$route['admin/generate-offer-report'] = 'admin_panel/Offer/generate_offer_report';

	


	$route['admin/report_filter'] = 'admin_panel/Offer/report_filter';
	
	$route['admin/ajax_get_product_data'] = 'admin_panel/Offer/ajax_get_product_data';
	
	

	$route['admin/report_filter_form'] = 'admin_panel/Offer/report_filter_form';


	$route['admin/report_filter_export'] = 'admin_panel/Offer/report_filter_export';	
	

	$route['admin/report_filter_export_form'] = 'admin_panel/Offer/report_filter_export_form';

	$route['admin/view-report/(:num)/(:any)'] = 'admin_panel/Export/view_report/$1';


    // ACCOUNTS AREA

    $route['admin/sale-contract'] = 'admin_panel/Accounts/proforma_invoice';
    $route['admin/print-sale-contract'] = 'admin_panel/Accounts/proforma_invoice_print';
    $route['admin/add_sale_contract'] = 'admin_panel/Accounts/add_sale_contract';
    $route['admin/edit_sale_contract/(:num)'] = 'admin_panel/Accounts/edit_sale_contract/$1';

    $route['admin/form_add_sale_contract'] = 'admin_panel/Accounts/form_add_sale_contract';
    $route['admin/form_edit_sale_contract'] = 'admin_panel/Accounts/form_edit_sale_contract';
    $route['admin/purchase_order_print'] = 'admin_panel/Accounts/purchase_order_print';

    $route['admin/ajax-clause-on-customer'] = 'admin_panel/Accounts/ajax_clause_on_customer';

    /*purchase order area*/
    	

    $route['admin/purchase-order'] = 'admin_panel/Accounts/purchase_order';

    $route['admin/purchase_order_add'] = 'admin_panel/Accounts/purchase_order_add';

    $route['admin/form_add_purchase_order'] = 'admin_panel/Accounts/form_add_purchase_order';


    

    $route['admin/edit_purchase_order/(:num)'] = 'admin_panel/Accounts/edit_purchase_order/$1';

    $route['admin/form_edit_purchase_order'] = 'admin_panel/Accounts/form_edit_purchase_order';

    $route['admin/print_purchase_order'] = 'admin_panel/Accounts/print_purchase_order';

    $route['admin/show_sc_template/(:num)'] = 'admin_panel/Accounts/show_sc_template/$1';

    $route['admin/show_po_template/(:num)'] = 'admin_panel/Accounts/show_po_template/$1';

    
	//Settings Area
	$route['admin/database-backup'] = 'admin_panel/Settings/database_backup_m';
	$route['admin/view-templates'] = 'admin_panel/Settings/view_templates';
	$route['admin/view_report_filter_templates'] = 'admin_panel/Settings/view_report_filter_templates';

	$route['admin/view-templates-report'] = 'admin_panel/Settings/view_templates_report';
	$route['admin/ajax-delete-view-templates/(:num)'] = 'admin_panel/Settings/ajax_delete_view_templates/$1';
	$route['admin/ajax-delete-view-templates-report/(:num)'] = 'admin_panel/Settings/ajax_delete_view_templates_report/$1';
	$route['admin/ajax_delete_view_templates_report_filter/(:num)'] = 'admin_panel/Settings/ajax_delete_view_templates_report_filter/$1';

	$route['admin/account_templates'] = 'admin_panel/Settings/account_templates';

	$route['admin/ajax_delete_acc_template/(:num)'] = 'admin_panel/Settings/ajax_delete_acc_template/$1';

	$route['admin/ajax_delete_mail_template/(:num)'] = 'admin_panel/Settings/ajax_delete_mail_template/$1';

	$route['admin/mail_templates'] = 'admin_panel/Settings/mail_templates';

	// export report area 

	$route['admin/report'] = 'admin_panel/Export/report';

	$route['admin/generate-report'] = 'admin_panel/Export/generate_report';

	$route['admin/ajax_get_offer_data'] = 'admin_panel/Export/ajax_get_offer_data';


	