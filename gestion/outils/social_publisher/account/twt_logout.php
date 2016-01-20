<?php
include_once('../include/webzone.php');

if(is_admin() && $GLOBALS['demo_mode']!=1) {
	$user_id = $_GET['id'];
	$type=2;
	$users = getUsers(array('user_id'=>$user_id, 'type'=>$type));
	if(count($users)>0) {
		$u1 = new MySqlTable();
		$sql = 'DELETE FROM '.$GLOBALS['db_table']['users'].' WHERE user_id="'.$u1->escape($user_id).'" AND type="'.$type.'"';
		$u1->executeQuery($sql);
	}
	
	unset($_SESSION['access_token']);
	unset($_SESSION['twt_box']);
}

header('Location: ../');
?>