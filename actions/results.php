<?php 


add_action('html_head', 'results_css');

function results_css() {
	//echo "<link rel='stylesheet' type='text/css' href='assets/results.css' />";
}


add_action('show_result_files', 'show_results_func');

function show_results_func() {
	show_results_title();
	show_results_back();
	show_results_lists();
}

function show_results_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']}</div>";
}

function show_results_back() {
	
}

function show_results_lists() {
	do_action('show_lists', 'results');
}