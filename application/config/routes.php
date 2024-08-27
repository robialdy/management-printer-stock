<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// custom url
$route['printer'] = 'PrinterBackup';
$route['replacement'] = 'PrinterReplacement';
$route['registrasi'] = 'Auth/Regis';
$route['users'] = 'moderator/users';
$route['damage'] = 'printerdamage';
