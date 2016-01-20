<?php
include('../include/webzone.php');

$fb_ids = $_POST['fb_ids'];
$twt_ids = $_POST['twt_ids'];
$status = $_POST['status'];
$link = $_POST['link'];
$image = $_POST['image'];
$twt_status = $_POST['twt_status'];

$created = date('Y-m-d H:i:s');

if(is_admin() && $GLOBALS['demo_mode']!=1) {
	
	if($fb_ids!='') {
		$users = getUsers(array('type_id'=>1));
		$tokensTab = array();
		for($i=0; $i<count($users); $i++) {
			$tokensTab[$users[$i]['user_id']]['token'] = $users[$i]['token'];
			$tokensTab[$users[$i]['user_id']]['name'] = $users[$i]['name'];
		}
		
		$f1 = new Fb_ypbox();
		$fb_idsTab = explode(',', $fb_ids);
		$nb_fb_updates=0;
		
		for($i=0; $i<count($fb_idsTab); $i++) {
			$fb_user_id = $fb_idsTab[$i];
			$token = $tokensTab[$fb_user_id]['token'];
			$name = $tokensTab[$fb_user_id]['name'];
			
			//update
			if($token!='') {
				$result = $f1->updateFacebookStatus(array('fb_id'=>$fb_user_id, 'message'=>$status, 'link'=>$link, 'picture'=>$image), $token);
				$result = json_decode($result, true);
			}
			
			if($result['id']!='') {
				$message = '';
				$message_id = $result['id'];
				$nb_fb_updates++;
			}
			else {
				if(is_array($result)) $message = json_encode($result);
				$message_id = '';
			}
			
			//History update
			$u1 = new MySqlTable();
			$sql = 'INSERT INTO '.$GLOBALS['db_table']['history'].' (type, user_id, name, result, message_id, created) VALUES 
			("1", "'.$u1->escape($fb_user_id).'", "'.$u1->escape($name).'", "'.$u1->escape($message).'",
			"'.$u1->escape($message_id).'", "'.$created.'")';
			$u1->executeQuery($sql);
		}
		
		echo $nb_fb_updates." Facebook updates\n";
	}
	
	if($twt_ids!='') {
		$users = getUsers(array('type_id'=>2));
		$tokensTab = array();
		for($i=0; $i<count($users); $i++) {
			$tokensTab[$users[$i]['user_id']]['token'] = $users[$i]['token'];
			$tokensTab[$users[$i]['user_id']]['token_secret'] = $users[$i]['token_secret'];
			$tokensTab[$users[$i]['user_id']]['username'] = $users[$i]['username'];
		}
		
		$t1 = new Twt_box();
		$twt_idsTab = explode(',', $twt_ids);
		$nb_twt_updates=0;
		
		for($i=0; $i<count($twt_idsTab); $i++) {
			$twt_user_id = $twt_idsTab[$i];
			$token = $tokensTab[$twt_user_id]['token'];
			$token_secret = $tokensTab[$twt_user_id]['token_secret'];
			$username = $tokensTab[$twt_user_id]['username'];
			
			//update
			if($token!='' && $token_secret!='') {
				$result = $t1->publishTweet(array('status'=>$twt_status, 'token'=>$token, 'token_secret'=>$token_secret));
				
				if($result->id_str!='') {
					$message = '';
					$message_id = $result->id_str;
					$nb_twt_updates++;
				}
				else {
					$message = $result->errors[0]->message;
					$message_id = '';
				}
				
				//History update
				$u1 = new MySqlTable();
				$sql = 'INSERT INTO '.$GLOBALS['db_table']['history'].' (type, user_id, name, result, message_id, created) VALUES 
				("2", "'.$u1->escape($twt_user_id).'", "'.$u1->escape($username).'", "'.$u1->escape($message).'",
				"'.$u1->escape($message_id).'", "'.$created.'")';
				$u1->executeQuery($sql);
			}
		}
		
		echo $nb_twt_updates." Twitter updates";
	}	
}
else {
	echo 'Feature disabled in demo mode';
}

?>
