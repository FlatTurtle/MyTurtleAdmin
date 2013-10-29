<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "home";
$route['404_override'] = '';

$route['^[a-z]{2}/?$'] = $route['default_controller'];


$route['^[a-z]{2}/login/do/*'] = 'home/login_post';
$route['^[a-z]{2}/login/*'] = 'home/login';
$route['^[a-z]{2}/logout/*'] = 'home/logout';
$route['^[a-z]{2}/(.*)/settings'] = 'advanced/index/$1';
$route['^[a-z]{2}/(.*)/settings/(.*)'] = 'advanced/$2/$1';
$route['^[a-z]{2}/(.*)/shots/(.*)'] = 'advanced/shots/$1/$2';
$route['^[a-z]{2}/(.*)/shots'] = 'advanced/shots/$1';
$route['^[a-z]{2}/(.*)/left/create/*'] = 'turtles/create/$1';
$route['^[a-z]{2}/(.*)/left/delete/*'] = 'turtles/delete/$1';
$route['^[a-z]{2}/(.*)/left/sort/*'] = 'turtles/sort/$1';
$route['^[a-z]{2}/(.*)/left/update/*'] = 'turtles/update/$1';
$route['^[a-z]{2}/(.*)/left/*'] = 'turtles/index/$1';
$route['^[a-z]{2}/(.*)/right/add/([A-z0-9]+)/*'] = 'panes/add/$1/$2';
$route['^[a-z]{2}/(.*)/right/delete/([0-9]+)/*'] = 'panes/delete/$1/$2';
$route['^[a-z]{2}/(.*)/right/save/([0-9]+)/*'] = 'panes/save/$1/$2';
$route['^[a-z]{2}/(.*)/right/sort/*'] = 'panes/sort/$1';
$route['^[a-z]{2}/(.*)/right/[A-z0-9\-_]*?/([0-9]+)/*'] = 'panes/index/$1/$2';
$route['^[a-z]{2}/(.*)/right/*'] = 'panes/first/$1';
$route['^[a-z]{2}/(.*)/plugin/(.*)'] = 'plugin/$2/$1';
$route['^[a-z]{2}/(.*)/update'] = 'screen/update/$1';
$route['^[a-z]{2}/(.*)/signage/upload/([0-9]+)/(.*)'] = 'turtles/signage_upload_logo/$1/$2/$3';
$route['^[a-z]{2}/(.*)/signage/delete/([0-9]+)/(.*)'] = 'turtles/signage_delete_logo/$1/$2/$3';
$route['^[a-z]{2}/(.*)/menu-image/upload/([0-9]+)/(.*)'] = 'turtles/upload_menu_image/$1/$2/$3';
$route['^[a-z]{2}/(.*)/menu-image/delete/([0-9]+)/(.*)'] = 'turtles/delete_menu_image/$1/$2/$3';
$route['^[a-z]{2}/(.*)/slideshow/upload/([0-9]+)/(.*)'] = 'turtles/slideshow_upload/$1/$2/$3';
$route['^[a-z]{2}/(.*)/slideshow/delete/([0-9]+)/(.*)'] = 'turtles/slideshow_delete/$1/$2/$3';
$route['^[a-z]{2}/(.*)/slideshow/crop/([0-9]+)/(.*)'] = 'turtles/slideshow_crop/$1/$2/$3';
$route['^[a-z]{2}/(.*)'] = 'screen/show/$1';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
