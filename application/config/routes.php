<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']   = 'Home';
$route['404_override']         = 'Error_404';
$route['translate_uri_dashes'] = TRUE;

// ADMIN.
$route[FADMIN] = FADMIN.'/auth';
$route[FADMIN.'/login'] = FADMIN.'/auth';
$route[FADMIN.'/auth-validation'] = FADMIN.'/auth/validation/user';
$route[FADMIN.'/logout'] = FADMIN.'/auth/logout';
$route[FADMIN.'/forgot'] = FADMIN.'/auth/forgot';
$route[FADMIN.'/permissions'] = FADMIN.'/permissions/index';
$route[FADMIN.'/permissions/group/edit/([a-z0-9]+)'] = FADMIN.'/permissions/edit_group/$1';
$route[FADMIN.'/permissions/group/add'] = FADMIN.'/permissions/add_group';
$route[FADMIN.'/permissions/group/([a-z0-9]+)'] = FADMIN.'/permissions/detail_group/$1';
$route[FADMIN.'/permissions/role/([a-z0-9]+)'] = FADMIN.'/permissions/role/$1';
$route[FADMIN.'/permissions/edit-role/([0-9]+)/([a-z0-9]+)'] = FADMIN.'/permissions/edit_group_role/$1/$2';
$route[FADMIN.'/permissions/edit-role/([0-9]+)'] = FADMIN.'/permissions/edit_list_role/$1';


// WEB.
$route['index/([0-9-]+)'] = 'index/index/$1';
$route['home/([0-9]+)'] = 'home/index/$1';
$route['contact'] = 'contact/index';
$route['pages/([a-z0-9-]+)'] = 'pages/index/$1';
$route['category/([a-z0-9-]+)'] = 'category/index/$1';
$route['category/([a-z0-9-]+)/([0-9]+)'] = 'category/index/$1/$2';
$route['tag/([a-z0-9-]+)'] = 'tag/index/$1';
$route['tag/([a-z0-9-]+)/([0-9]+)'] = 'tag/index/$1/$2';
$route['search/([^/]*)'] = 'search/index/$1';
$route['search/([^/]*)/([0-9]+)'] = 'search/index/$1/$2';
$route['gallery'] = 'gallery/index';
$route['gallery/([a-z0-9-]+)'] = 'gallery/album/$1';

// dinamic routes.
foreach(glob(APPPATH."/config/routes/*.php") as $routes_file)
{
	require_once $routes_file;
}
