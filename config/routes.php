<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//For Restrict action for free user. Need to update array defined in Utility::hacAction function
$route['parts/parts-detail/(:any)']='parts_front/parts_detail/$1';
$route['parts/parts-list']='parts_front/parts_list';
$route['parts/parts-list/(:any)']='parts_front/parts_list/$1';
$route['parts/parts-list/(:any)/(:any)']='parts_front/parts_list/$1/$2';
$route['parts/(:any)']='parts_front/$1';

//Parts Admin Routes
$route['user/parts/payment-conformation']='parts_admin/payment_conformation';
$route['user/parts/(:any)']='parts_admin/$1';
$route['parts-invoice-pdf/(:num)/(:num)']='parts_admin/parts_invoice_pdf/$1/$2';
//Make Routes
$route['user/make_(:any)']='make/make_$1'; 
//Uplaod Image
$route['user/upload-image/(:any)/(:any)/(:any)']='user/uploadFile/$1/$2/$3';
// User Routes
$route['user/reset-password/(:any)']='user/reset_password';
$route['user/register-thankyou']='user/register_thankyou'; 
$route['user/(:any)']='user/$1';
$route['dashboard']='user/dashboard';
$route['payment-thank-you']='parts_admin/payment_thank_you'; 
$route['default_controller'] = 'front/home';
$route['404_override'] = 'error/page_not_found';
$route['translate_uri_dashes'] = FALSE;
