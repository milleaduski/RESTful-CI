<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Routes
$route['api/users']['GET'] 			= "UsersController/all_users";
$route['api/users/(:num)']['GET']	= "UsersController/detail_user/$1";
$route['api/register']['POST'] 		= "UsersController/save";
$route['api/user/(:num)']['PUT'] 	= "UsersController/update/$1';
$route['api/user/(:num)']['DELETE'] = "UsersController/delete/$1";
$route['api/login']					= "UsersController/save";



$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
