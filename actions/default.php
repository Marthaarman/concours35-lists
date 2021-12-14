<?php

add_action('show_default', 'show_default_func');

function show_default_func() {
	show_default_buttons();
	show_default_lists();
}

function show_default_buttons() {
	
}



function show_default_lists() {
	do_action('show_lists', 'none');
}