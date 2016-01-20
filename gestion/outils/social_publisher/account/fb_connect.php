<?php
include('../include/webzone.php');

if(is_admin() && $GLOBALS['demo_mode']!=1) {

	$f1 = new Fb_ypbox();
	$result = $f1->fb_connect_flow();
	
	if($result) {
		
		$userData = $f1->getUserData();
		
		if(count($userData)>0) {
			
			$usersIds = array();
			$users = getUsers(array('type'=>1));
			for($i=0; $i<count($users); $i++) {
				$usersIds[] = $users[$i]['user_id'];
			}
			
			//Get long lived token
			$longLivedToken = $f1->getLongLivedToken();
			$token = $longLivedToken['token'];
			$token_expires = $longLivedToken['expires'];
			$type = 1; //1=Facebook
			
			//Insert Facebook account
			if(in_array($userData['id'], $usersIds)) {
				$u1 = new MySqlTable();
				$sql = 'UPDATE '.$GLOBALS['db_table']['users'].' SET token="'.$u1->escape($token).'", token_expires="'.$u1->escape($token_expires).'"
				WHERE user_id="'.$u1->escape($userData['id']).'"';
				$u1->executeQuery($sql);
			}
			else {
				$u1 = new MySqlTable();
				$sql = 'INSERT INTO '.$GLOBALS['db_table']['users'].' (type, user_id, name, token, token_expires, created) VALUES 
				("'.$u1->escape($type).'", "'.$u1->escape($userData['id']).'", "'.$u1->escape($userData['name']).'", "'.$u1->escape($token).'", "'.$u1->escape($token_expires).'", "'.date('Y-m-d H:i:s').'")';
				$u1->executeQuery($sql);
			}
			
			//Facebook pages
			$result = $f1->getFacebookPages(array('token'=>$token));
			for($i=0; $i<count($result); $i++) {
				if(in_array($result[$i]['id'], $usersIds)) {
					$u1 = new MySqlTable();
					$sql = 'UPDATE '.$GLOBALS['db_table']['users'].' SET token="'.$u1->escape($result[$i]['access_token']).'", token_expires="'.$u1->escape($result[$i]['expires']).'"
					WHERE user_id="'.$u1->escape($result[$i]['id']).'"';
					$u1->executeQuery($sql);
				}
				else {
					$sql = 'INSERT INTO '.$GLOBALS['db_table']['users'].' (type, user_id, name, token, token_expires, created) VALUES 
					("'.$u1->escape($type).'", "'.$u1->escape($result[$i]['id']).'", "'.$u1->escape($result[$i]['name']).'", "'.$u1->escape($result[$i]['access_token']).'", "'.$u1->escape($result[$i]['expires']).'", "'.date('Y-m-d H:i:s').'")';
					$u1->executeQuery($sql);					
				}
			}
		}
		
		echo '<script>window.location = "../";</script>';
	}
}

else {
	header('Location: ../');
}

?>