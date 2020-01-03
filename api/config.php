<?php

require_once 'lib/lib.php';

define('DB_HOST', '');
define('DB_USER', 'libricope');
define('DB_PSW', 'corsocope2016');
define('DB_NAME', 'my_libricope');

$rest_json = file_get_contents("php://input");
$_DATA = json_decode($rest_json, true);
