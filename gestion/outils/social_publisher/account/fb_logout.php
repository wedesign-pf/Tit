<?php
include('../include/webzone.php');

if(is_admin() && $GLOBALS['demo_mode']!=1) {
	unset($_SESSION['ygp_fb_box']);
	
	$user_id = $_GET['id'];
	$type=1;
	$users = getUsers(array('user_id'=>$user_id, 'type'=>$type));
	if(count($users)>0) {
		$u1 = new MySqlTable();
		$sql = 'DELETE FROM '.$GLOBALS['db_table']['users'].' WHERE user_id="'.$u1->escape($user_id).'" AND type="'.$type.'"';
		$u1->executeQuery($sql);
	}
}

header('Location: ../');
?>