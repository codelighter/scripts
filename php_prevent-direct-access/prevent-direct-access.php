<?php
// kill the page if the access variable doesn't exists
// or if the access variable does exist but is not set to true
if(!isset($_SESSION['can_access']) || (isset($_SESSION['can_access']) && $_SESSION['can_access'] !== true))
{
   die('Error: Direct access not allowed.'); // kill the page display error
}

// kill the page if the HTTP Request isn't an xmlhttprequest
define('AJAX_REQUEST', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'); if(!AJAX_REQUEST) {die();}

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
