<?php

//	include init.php which does:
//	include initial files (functions, handlers, actions, etc)
//	initialize settings
include_once('init.php');


//	check if type of lists is given
$type = isset($_GET['type']) ? $_GET['type'] : false;

switch($type){
	case 'qr':
		//show qr code content
		$action = 'create_qr';
		index_content($action);
		break;
	case 'show_starts':
	case 'starts':
		//show start files or starts
		if(isset($_GET['list'])) {
			$action = 'show_starts';
		}else{
			$action = 'show_start_files';
		}
		index_content($action);
		break;
	case 'show_results':
	case 'results':
		//show result files or results
		if(isset($_GET['list'])) {
			$action = 'show_results';
		}else{
			$action = 'show_result_files';
		}
		index_content($action);
		break;
	case false:
	default:
		$action = 'show_default';
		index_content($action);
		//show option for start files, result files and show all files
		break;
}



function index_content($action) {
	global $SETTINGS;
	echo "
		<!doctype html>
		<html>
			<head>
				<meta charset='utf-8'>
				<title>{$SETTINGS['site_title']}</title>
				<!--<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>!-->
				<link rel='stylesheet' type='text/css' href='assets/layout.css' />
				";
	
				//	add action to allow input in the header
				// both action specific and general
				do_action("html_head");
				do_action("html_head_".$action);
			
				echo "
			</head>
			<body>";
				//	wrapper around page
				echo "<div id='page_wrap'>";

					// call action for pre page content
					do_action("pre_page_content");
		
					echo "<div id='page_content'>";
		
					//call action for this page
					do_action($action);
		
					echo "</div>";
		
					// call action for post page content
					do_action("post_page_content");

					//	footer
					echo "
					<div id='page_footer_spacer'></div>
					<div id='page_footer'>
						Door MHWD.nl & weedo.nu, vrijwilligers planning
					</div>
					";
				
				// end page wrap
				echo "</div>";

			echo "
			</body>
		</html>
	";
}