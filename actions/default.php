<?php

add_action('html_head', 'default_css');

function default_css() {
	echo "<link rel='stylesheet' type='text/css' href='assets/default.css?rnd=1' />";
}


add_action('show_default', 'show_default_func');

function show_default_func() {
	show_default_title();
	show_default_buttons();
	show_default_lists();
}

function show_default_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']}</div>";
}

function show_default_buttons() {
	echo "
		<div id='default_buttons'>
			<a href='index.php?type=starts'><div class='default_button button'>Startlijsten</div></a>
			<a href='index.php?type=results'><div class='default_button button'>Uitslagen</div></a>
		</div>
	";
}



function show_default_lists() {
	do_action('show_lists', 'none');
}