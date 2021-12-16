<?php

if(isset($_GET['qr_data'])) {
	$url = base64_decode($_GET['qr_data']);
	$size = isset($_GET['size']) ? $_GET['size'] : 400;
	$apiUrl = 'https://chart.googleapis.com/chart?';
	$data = preg_match("#^https?\:\/\/#", $url) ? $url :    "http://{$url}";
	
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $apiUrl."chs={$size}x{$size}&cht=qr&chl=" . urlencode($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$img = curl_exec($ch);
	curl_close($ch);


	if ($img) {
		header("Content-type: image/png");
		print $img;
	}
}