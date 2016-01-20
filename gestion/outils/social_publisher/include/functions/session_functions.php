<?php

function get_session() {
	return $_SESSION['session'];
}

function is_admin() {
	if(session_is_live()) {
		$session = get_session();
		if($session['login']==$GLOBALS['admin_username']) return true;
		else return false;
	}
	else return false;
}

function session_is_live() {
	if($_SESSION['session']['user_id']!='') return true;
	else return false;
}

function start_session($criteria=array()) {
	/*
	$user_id = $criteria['user_id'];
	$login = $criteria['login'];
	$privilege = $criteria['privilege'];
	*/
	$_SESSION['session'] = $criteria;
}

function kill_session() {
	$_SESSION['session'] = array();
	unset($_SESSION);
}

?>