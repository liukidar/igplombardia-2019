<?php

require_once '../config.php';
require_once '../model/cms.php';
require_once '../model/user.php';

header('Access-Control-Allow-Origin: http://localhost:8080');
header('Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: origin, content-type, accepts, X-HTTP-Method-Override');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

$sql = new MySQL(DB_HOST, DB_USER, DB_PSW, DB_NAME);
$vtm = new VTM($sql);

// Model
$user = new User($vtm);
$filemanager = new CMS(
  $_PROTOCOL . $_SERVER['HTTP_HOST'],
  $_SERVER['DOCUMENT_ROOT'],
  '/data/uploads/',
  ['image/png', 'image/gif', 'image/jpg', 'image/jpeg']
);

// Handle request
switch ($_SERVER['REQUEST_METHOD']) {
  // Get list of files
  case 'GET':
    $access = $user->checkAuthToken($_SERVER[HTTP_AUTH_TOKEN]);
    if($access[F_VIEW] == false) {
			pushError('NOT_AUTHORIZED');
			http_response_code(401);
    } else {
			$filemanager->list();
		}

    break;

  // Upload new files
  case 'POST':
    $access = $user->checkAuthToken($_SERVER[HTTP_AUTH_TOKEN]);
    if($access[F_CREATE] == false) {
			pushError('NOT_AUTHORIZED');
			http_response_code(401);
    } else {
			$filemanager->create($_FILES, $_POST['env'], $_POST['previews']);
		}

    break;
  
  // Delete existing files
  case 'DELETE':
    $access = $user->checkAuthToken($_SERVER[HTTP_AUTH_TOKEN]);
    if($access[F_REMOVE] == false) {
			pushError('NOT_AUTHORIZED');
      http_response_code(401);
    } else {
			$filemanager->remove($_GET['id']);
		}

    break;
  
  case 'OPTIONS':
    break;

  default:
    http_response_code(405);
    break;
}

echo output();