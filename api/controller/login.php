<?php

require_once '../config.php';
require_once '../model/user.php';

header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: origin, content-type, accepts, X-HTTP-Method-Override');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

$sql = new MySQL(DB_HOST, DB_USER, DB_PSW, DB_NAME);
$vtm = new VTM($sql);
$user = new User($vtm);

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST':
		if ($_DATA['action'] == 'login') {
			$user->requestAuthToken($_DATA['username'], $_DATA['password']);
		} else if ($_DATA['action'] == 'logout') {
			$user->clearAuthToken($_SERVER['HTTP_AUTH_TOKEN']);
		} else {
			http_response_code(400);
		}
		
		break;
	case 'OPTIONS':
    break;
	default:
		http_response_code(405);
    break;
}

echo output();