<?php

require_once 'MySQL.php';
require_once 'VTO/VTO.php';
require_once 'access.php';

define("ERROR", 0);
define("WARNING", 1);
define("MESSAGE", 2);

function setHeader($_header, $_value) {
	$GLOBALS['headers'][$_header] = $_value;
}

function setData($_name, $_value) {
	$GLOBALS['data'][$_name] = $_value;
}

function pushMsg($_msg) {
	$GLOBALS['msgs'][] = $_msg;
}
function pushWarning($_msg) {
	$GLOBALS['warnings'][] = $_msg;
}
function pushError($_msg) {
	$GLOBALS['errors'][] = $_msg;
}

function output()
{
	$r = [
		'data' => $GLOBALS['data'],
		'headers' => $GLOBALS['headers'],
		'msgs' => $GLOBALS['msgs'],
		'warnings' => $GLOBALS['warnings'],
		'errors' => $GLOBALS['errors'],
		'status' => (count($GLOBALS['errors']) > 0 ? false : true)
	];

	return json_encode($r);
}
