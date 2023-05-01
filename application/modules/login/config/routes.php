<?php
/**
 * Coded by: Pran Krishna Das
 * Social: www.fb.com/pran93
 * CI: 3.0.6
 * Date: 09-07-17
 * Time: 10:00
 */

$route['admin'] = 'login/Login/admin_login';
$route['login'] = 'login/Login/admin_login';

$route['admin_logout'] = 'login/Login/admin_logout';
$route['logout'] = 'login/Login/admin_logout';

$route['change_password/(:any)'] = 'login/Login/change_password/$1';
$route['update_password'] = 'login/Login/update_password';