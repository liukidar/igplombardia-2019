<?php

require_once '../config.php';
require_once '../model/post.php';
require_once '../model/user.php';

header('Access-Control-Allow-Origin: '.ORIGIN_SITE);
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 3628800');
header('Access-Control-Allow-Headers: origin, content-type, accepts, X-HTTP-Method-Override');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');


$sql = new MySQL(DB_HOST, DB_USER, DB_PSW, DB_NAME);
$vtm = new VTM($sql);
$post = new Post(
	$vtm,
	$_PROTOCOL . $_SERVER['HTTP_HOST'],
  $_SERVER['DOCUMENT_ROOT'],
	'/data/'
);
$user = new User($vtm);

switch ($_SERVER['REQUEST_METHOD']) {
	case 'GET':
		$post->list();

		break;
  case 'POST':
    $token = $user->checkAuthToken($_SERVER[HTTP_AUTH_TOKEN]);
    if (!$token) {
      http_response_code(401);

      break;
    }

    switch ($_POST['action']) {
      case 'create':
        if ($token[F_CREATE]) {
          $post->create(json_decode($_POST['post'], true), $_FILES['picture']);
        } else {
          pushError("UNAUTHORIZED");
          http_response_code(403);
        }

        break;
      case 'edit':
        if ($token[F_EDIT]) {
          $post->edit(json_decode($_POST['post'], true), $_FILES['picture']);
        } else {
          pushError("UNAUTHORIZED");
          http_response_code(403);
        }

        break;
      case 'remove':
        if ($token[F_REMOVE]) {
          $post->remove($_POST['id']);
        } else {
          pushError("UNAUTHORIZED");
          http_response_code(403);
        }

        break;
      default:
        http_response_code(405);
    }

    break;
	case 'OPTIONS':
    break;
	default:
		http_response_code(405);

    break;
}

echo output();