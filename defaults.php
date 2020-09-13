<?php
	ini_set('display_errors', '1');
	date_default_timezone_set('Europe/Paris');
	$script_tz = date_default_timezone_get();
	ini_set('display_startup_errors', '1');
	//error_reporting (E_ALL);
	error_reporting (E_ALL ^ E_NOTICE);
?>