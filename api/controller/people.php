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
  case 'POST':
    switch ($_POST['action']) {
      case 'create':
        $user->create(json_decode($_POST['user'], true), $_FILES['picture']);

        break;
      case 'edit':
        $user->edit(json_decode($_POST['user'], true), $_FILES['picture']);

        break;
      case 'remove':
        $user->remove($_POST['id']);

        break;
      default:
        http_response_code(405);
    }

    break;
  case 'PUT':
    

    break;
  case 'DELETE':
    $user->delete();
  
    break;
	case 'OPTIONS':
    break;
	default:

    break;
}

echo output();