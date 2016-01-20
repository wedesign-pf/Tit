<?php
include('../include/webzone.php');

$login = $_POST['login'];
$password = $_POST['password'];

if($login=='' || $password=='') {
	$display .= '<div class="alert fade in alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>';
	$display .= 'Missing login and/or password';
	$display .= '</strong></div>';
	$d['display'] = $display;
	$d['code'] = 0;
	echo json_encode($d);
}
else {
	if( ($login==$GLOBALS['admin_username']) AND ($password==$GLOBALS['admin_password']) ) {
		start_session(array('user_id'=>'99999', 'login'=>$login));
		
		$d['code'] = 1; //success
		echo json_encode($d);
	}
	else {
		$display .= '<div class="alert fade in alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>';
		$display .= 'The user and/or password are incorrect';
		$display .= '</strong></div>';
		$d['display'] = $display;
		$d['code'] = 0;
		echo json_encode($d);
	}
}

?>