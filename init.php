<?php

//	make sure character output is correct:
header("Content-Type: text/html; charset=ISO-8859-1");

//	include settings.php
include_once('settings.php');


//	include all function files
$files = glob('functions/*.php');
foreach($files as $file) {
	include_once($file);
}

//	include all action files
$files = glob('actions/*.php');
foreach($files as $file) {
	include_once($file);
}
