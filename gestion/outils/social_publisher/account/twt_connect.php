<?php
include_once('../include/webzone.php');

if(is_admin() && $GLOBALS['demo_mode']!=1) {
	$t1 = new Twt_box();
	
	if($t1->is_connected()===true) {
		$user_data = $t1->getUserData();
		
		if($user_data['id_str']!='') {
			
			$type=2; //2=Twitter
			$users = getUsers(array('user_id'=>$user_data['id_str'], 'type'=>$type));
			
			if(count($users)==0) {
				$u1 = new MySqlTable();
				$sql = "INSERT INTO ".$GLOBALS['db_table']['users']." (type, user_id, username, name, picture, token, token_secret, created) VALUES 
				('".$u1->escape($type)."', '".$u1->escape($user_data['id_str'])."', '".$u1->escape($user_data['screen_name'])."', '".$u1->escape($user_data['name'])."', '".$u1->escape($user_data['profile_image_url'])."',
				'".$u1->escape($user_data['token'])."', '".$u1->escape($user_data['token_secret'])."', '".date('Y-m-d H:i:s')."')";
				$u1->executeQuery($sql);
			}
			else {
				echo 'The account "<b>'.$user_data['screen_name'].'</b>" is already connected<br>
				To connect another Twitter account, please close your <a href="http://twitter.com" target="_blank">Twitter session</a> and try again.<br>';
				echo '<a href="../">Back</a>';
				exit();
			}
		}
		
		header('Location: ../');
	}
	else {
		$t1->connect_process();
	}
}
else {
	header('Location: ../');
}

?>