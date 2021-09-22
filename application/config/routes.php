<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller']   = 'Home';
$route['404_override']         = '';
$route['translate_uri_dashes'] = TRUE;

$route[FADMIN] = FADMIN.'/login';
$route[FADMIN.'/logout'] = FADMIN.'/login/logout';
$route[FADMIN.'/forgot'] = FADMIN.'/login/forgot';
$route[FADMIN.'/profile'] = FADMIN.'/user/profile';

$route['home'] = 'home/index';
$route['home/([0-9]+)'] = 'home/index/$1';
$route['pages/([a-z0-9-]+)'] = 'pages/index/$1';
$route['about-us'] = 'pages/index/about-us';
$route['contact'] = 'contact/index';
$route['category/([a-z0-9-]+)'] = 'category/index/$1';
$route['category/([a-z0-9-]+)/([0-9]+)'] = 'category/index/$1/$2';
$route['tag/([a-z0-9-]+)'] = 'tag/index/$1';
$route['tag/([a-z0-9-]+)/([0-9]+)'] = 'tag/index/$1/$2';
$route['search/([^/]*)'] = 'search/index/$1';
$route['search/([^/]*)/([0-9]+)'] = 'search/index/$1/$2';
$route['video/play/([a-z0-9-]+)'] = 'video/play/$1';
$route['gallery'] = 'gallery/index';
$route['gallery/([a-z0-9-]+)'] = 'gallery/album/$1';

require_once APPPATH . 'cache/routes.php';