<?php

define("F_VIEW", 'v');
define("F_CREATE", 'c');
define("F_EDIT", 'e');
define("F_REMOVE", 'd');
define("ACCESS_CODES", ['v' => F_VIEW, 'c' => F_CREATE, 'e' => F_EDIT, 'd' => F_REMOVE]);

function flag2access($flag) {
	$r = [];
	foreach(ACCESS_CODES as $code => $value) {
		$r[$value] = false;
	}

	$codes = explode('-', $flag);
	foreach($codes as $code) {
		$r[ACCESS_CODES[$code]] = true;
	}

	return $r;
}
