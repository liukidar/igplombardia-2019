<?php

require_once '../config.php';
require_once '../model/user.php';

header('Access-Control-Allow-Origin: '.ORIGIN_SITE);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Headers: origin, content-type, accepts, X-HTTP-Method-Override');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

$sql = new MySQL(DB_HOST, DB_USER, DB_PSW, DB_NAME);
$vtm = new VTM($sql);
$user = new User($vtm);

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST':
		$user->requestAuthToken($_POST['username'], $_POST['password']);
		
		break;
	case 'DELETE':
		$user->clearAuthToken($_SERVER[HTTP_AUTH_TOKEN]);

		break;
	case 'OPTIONS':
    break;
	default:
		http_response_code(405);

    break;
}

echo output();