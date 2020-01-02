<?php

function setHeader($_header, $_value) {
	$_SESSTION['headers'][$_header] = $_value;
}

function setData($_name, $_value) {
	$_SESSION['data'][$_name] = $_value;
}


define("ERROR", 0);
define("WARNING", 1);
define("MESSAGE", 2);
function pushMsg($_type, $_msg) {
	$_SESSION['msg'][$_type][] = $_msg;
}
