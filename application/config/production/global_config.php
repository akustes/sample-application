<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Application
 *
 * @package     Application
 * @author      Andrew Kustes
 * @copyright   Copyright (c) 2014, Andrew Kustes
 * @since       Version 1.0
 * @category    Config
 * @description Global Configuration
 */

// ------------------------------------------------------------------------


/*
|--------------------------------------------------------------------------
| DATE/TIME: Daylight Savings and Time Format
|--------------------------------------------------------------------------
|
| Enables Daylight Savings for Date/Time Output
| Options are TRUE or FALSE (boolean)
| Time Formats us, euro
|
*/

$config['daylight_savings'] = FALSE;
$config['time_format'] = 'us';


/*
|--------------------------------------------------------------------------
| THEME: Current Theme for Site
|--------------------------------------------------------------------------
|
| Set the site wide theme
|
*/

$config['theme'] = 'default';

/*
|--------------------------------------------------------------------------
| Credit Card Payment Gateway
|--------------------------------------------------------------------------
|
| Set the Gateway Credentials
|
*/

$config['cc_gateway_username'] = '';
$config['cc_gateway_password'] = '';


/*
|--------------------------------------------------------------------------
| SMTP Settings for Email
|--------------------------------------------------------------------------
|
| Set the SMTP Credentials
|
*/

$config['smtp_gateway_api'] = TRUE;
$config['smtp_gateway_smtp'] = FALSE;
$config['smtp_gateway_host'] = 'smtp.sendgrid.net';
$config['smtp_gateway_username'] = 'akustes';
$config['smtp_gateway_password'] = 'VA000047!';
$config['smtp_gateway_port'] = '587'; // Default 25
$config['smtp_gateway_timeout'] = '5'; // Default 5
$config['smtp_gateway_crlf'] = "\r\n";
$config['smtp_gateway_newline'] = "\r\n";


/* End of file global_config.php */
/* Location: ./system/application/config/global_config.php */