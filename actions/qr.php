<?php

add_action('html_head_create_qr', 'qr_css');

function qr_css() {
	echo "<link rel='stylesheet' type='text/css' href='assets/qr.css' />";
}


add_action('create_qr', 'create_qr_func');

function create_qr_func($args = false) {
	back_button();
	qr_title();
	qr_qr($args);
}

function qr_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']} - QR Code<br />".list_title($_GET['list'])."</div>";
}

function qr_qr($args = false) {
	print_r($args);
	$url = 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/'.base64_decode($_GET['link']);
	echo "<div id='qr_code'><img src='functions/qr_img.php?size=400&qr_data=".base64_encode($url)."' /></div>";
}