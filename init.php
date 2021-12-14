<?php

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
