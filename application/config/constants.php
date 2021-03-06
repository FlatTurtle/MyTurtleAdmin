<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('API_AUTH_ADMIN','auth/admin');
define('API_INFOSCREENS','');
define('API_TURTLE_TYPES','turtles');
define('API_TURTLE_INSTANCES','turtles');
define('API_TURTLE_ORDER','order');
define('API_PLUGIN_STATES','plugins');
define('API_PLUGIN_MESSAGE','plugins/message');
define('API_PLUGIN_CLOCK','plugins/clock');
define('API_PLUGIN_SCREEN_POWER','plugins/screen/power');
define('API_PLUGIN_SCREEN_RELOAD','plugins/screen/reload');
define('API_PLUGIN_FOOTER','plugins/footer');
define('API_PANE_INSTANCES','panes');
define('API_PANE_ORDER','order');
define('API_OPTION','option');


define('LOGO_MAX_WIDTH', 400);
define('LOGO_MAX_HEIGHT', 120);
define('MENU_IMAGE_MAX_WIDTH', 160);
define('MENU_IMAGE_MAX_HEIGHT', 120);
define('SLIDESHOW_PORTRAIT_MAX_HEIGHT', 920);
define('SLIDESHOW_PORTRAIT_MAX_WIDTH', 960);
define('SLIDESHOW_LANDSCAPE_MAX_HEIGHT', 800);
define('SLIDESHOW_LANDSCAPE_MAX_WIDTH', 1200);
define('ERROR_WRONG_USER_PASSWORD','Username and password mismatch!');


define('SIGNAGE_UPLOAD_DIR', BASEPATH. "../uploads/signage/");
define('MENU_IMAGE_UPLOAD_DIR', BASEPATH. "../uploads/menu_images/");
define('SLIDESHOW_UPLOAD_DIR', FCPATH . "uploads/slideshow_images/");

/* End of file constants.php */
/* Location: ./application/config/constants.php */