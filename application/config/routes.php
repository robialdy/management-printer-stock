<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// custom url
$route['printer'] = 'PrinterBackup';
$route['replacement'] = 'PrinterReplacement';
$route['registrasi'] = 'Auth/Regis';

$route['damage'] = 'printerdamage';

$route['type'] = 'TypePrinter';

$route['log'] = 'users/user_log';

// perdelete an
$route['delete/(:any)'] = 'users/delete/$1';

