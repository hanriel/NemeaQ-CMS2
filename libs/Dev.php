<?php

defined('_USE_NQ_CMS') or Die('Direct Access to this location is not allowed.');

$debug = false;
ini_set('display_errors', $debug ? 1 : 0);
error_reporting(E_ALL);

/**
 * @param $str
 */
function debug($str) {
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
	exit;
}