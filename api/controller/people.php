<?php

require_once '../config.php';
require_once '../model/user.php';

header('Access-Control-Allow-Origin: '.ORIGIN_SITE);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: origin, content-type, accepts, X-HTTP-Method-Override');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

$sql = new MySQL(DB_HOST, DB_USER, DB_PSW, DB_NAME);
$vtm = new VTM($sql);
$user = new User(
	$vtm,
	$_PROTOCOL . $_SERVER['HTTP_HOST'],
  $_SERVER['DOCUMENT_ROOT'],
	'/data/'
);

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		$user->list();

		break;
	case 'OPTIONS':
    break;
	default:
		http_response_code(405);

    break;
}

echo output();