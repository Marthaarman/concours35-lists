<?php

//	create actions array to be used later
$ACTIONS = array();


//	call upon an action to trigger
function do_action($action, $args = false) {
	global $ACTIONS;

	if(isset($ACTIONS[$action])) {
		$act = $ACTIONS[$action];
		if($act['allow'] == true) {
			if($act['init']['function']) {
				if(is_callable($act['init']['function'])) {
					call_user_func($act['init']['function'], $args, $act['init']['args']);
				}
			}
			$s_acts = $act['actions'];
			usort($s_acts, "usort_by_priority");
			foreach($s_acts as $s_act) {
				if($ACTIONS[$action]['allow'] == true) {
					if(is_callable($s_act['function'])) {
						call_user_func($s_act['function'], $args, $s_act['args']);
					}
				}
			}
		}
		
	}
}

//	prevent specific action from being executed
function prevent_action($action) {
	global $ACTIONS;
	create_action($action);
	$ACTIONS[$action]['allow'] = false;
}

//	create action if it doesn't exist
function create_action($action) {
	global $ACTIONS;
	if(!isset($ACTIONS[$action])) {
		$ACTIONS[$action] = array(
			'allow' => true,
			'init' => array(
				'function' => false,
				'args' => false
			),
			'actions' => array()
		);
	}
}


//	add initializing function to an action, will be triggered as first function
function init_action($action, $function, $args = false) {
	global $ACTIONS;
	
	create_action($action);
	if($ACTIONS[$action]['init']['function'] == false) {
		$ACTIONS[$action]['init']['function'] = $function;
		$ACTIONS[$action]['init']['args'] = $args;
	}
	
}

//	add a function to a given action. All functions for this action will trigger when the action is calles
function add_action($action, $function, $args = false, $priority = false) {
	global $ACTIONS;
	
	create_action($action);
	
	$ACTIONS[$action]['actions'][] = array(
		'function' => $function,
		'args' => $args,
		'priority' => $priority
	);
}

function has_actions($action) {
	global $ACTIONS;
	if(isset($ACTIONS[$action])) {
		return true;
	}else {
		return false;
	}
}


