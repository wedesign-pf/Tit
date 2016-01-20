<?php
include('tmhOAuth.php');
include('tmhUtilities.php');

class Twt_box
{
	var $tmhOAuth='';
	var $twt_consumer_key='';
	var $twt_consumer_secret='';
	
	function Twt_box($criteria=array()) {
		$twt_consumer_key = $criteria['twt_consumer_key'];
		$twt_consumer_secret = $criteria['twt_consumer_secret'];
		
		$this->twt_consumer_key = $twt_consumer_key;
		$this->twt_consumer_secret = $twt_consumer_secret;
		if($this->twt_consumer_key=='') $this->twt_consumer_key = $GLOBALS['twt_consumer_key'];
		if($this->twt_consumer_secret=='') $this->twt_consumer_secret = $GLOBALS['twt_consumer_secret'];
		
		$this->tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => $this->twt_consumer_key,
		  'consumer_secret' => $this->twt_consumer_secret,
		));
	}
	
	//Check if the user is connected
	function is_connected() {
		if(isset($_SESSION['access_token']) && $_SESSION['access_token']!='') {
			return true;
		}
		else {
			return false;
		}
	}
	
	//Friends list
	function getFriendsList($criteria=array()) {
		$user_id = $criteria['user_id'];
		$cursor = $criteria['cursor'];
		$token = $criteria['token'];
		$token_secret = $criteria['token_secret'];
		
		if($cursor=='') $cursor = -1;
		
		$data = $this->getDataFromAPI(array('connection'=>'friends/list', 'params'=>array('user_id'=>$user_id, 'cursor'=>$cursor), 'token'=>$token, 'token_secret'=>$token_secret));
		return $data;
	}
	
	//Followers list
	function getFollowersList($criteria=array()) {
		$user_id = $criteria['user_id'];
		$cursor = $criteria['cursor'];
		$token = $criteria['token'];
		$token_secret = $criteria['token_secret'];
		
		if($cursor=='') $cursor = -1;
		
		$data = $this->getDataFromAPI(array('connection'=>'followers/list', 'params'=>array('user_id'=>$user_id, 'cursor'=>$cursor, 'token'=>$token, 'token_secret'=>$token_secret)));
		return $data;
	}
	
	//Publish a Tweet
	function publishTweet($criteria=array()) {
		$status = $criteria['status'];
		$token = $criteria['token'];
		$token_secret = $criteria['token_secret'];
		
		if($token=='') $token = $_SESSION['access_token']['oauth_token'];
		if($token_secret=='') $token_secret = $_SESSION['access_token']['oauth_token_secret'];
		
		if($this->twt_consumer_key=='') $this->twt_consumer_key = $GLOBALS['twt_consumer_key'];
		if($this->twt_consumer_secret=='') $this->twt_consumer_secret = $GLOBALS['twt_consumer_secret'];
		if($token=='') $token = $_SESSION['access_token']['oauth_token'];
		if($token_secret=='') $token_secret = $_SESSION['access_token']['oauth_token_secret'];
		
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => $this->twt_consumer_key,
		  'consumer_secret' => $this->twt_consumer_secret,
		  'user_token'      => $token,
		  'user_secret'     => $token_secret,
		));
		
		$code = $tmhOAuth->request('POST', $tmhOAuth->url('1.1/statuses/update'), array(
		  'status' => $status
		));
		
		$response = json_decode($tmhOAuth->response['response']);
		return $response;
	}
	
	//Get a user data
	function getUserData($criteria=array()) {
		$user_id = $criteria['user_id'];
		
		if($user_id=='') {
			if($_SESSION['twt_box']['user_data']['id_str']=='') {
				$user_id = $_SESSION['access_token']['user_id'];
				$data = $this->getDataFromAPI(array('connection'=>'users/show', 'params'=>array('user_id'=>$user_id)));
				
				$data['profile_url'] = 'http://www.twitter.com/'.$_SESSION['access_token']['screen_name'];
				$data['token'] = $_SESSION['access_token']['oauth_token'];
				$data['token_secret'] = $_SESSION['access_token']['oauth_token_secret'];
			}
			else {
				$data = $_SESSION['twt_box']['user_data'];
			}
		}
		else {
			$data = $this->getDataFromAPI(array('connection'=>'users/show', 'params'=>array('user_id'=>$user_id)));
		}
		
		return $data;
	}
	
	function getDataFromAPI($criteria=array()) {
		$connection = $criteria['connection'];
		$params = $criteria['params'];
		$token = $criteria['token'];
		$token_secret = $criteria['token_secret'];
		
		if($this->twt_consumer_key=='') $this->twt_consumer_key = $GLOBALS['twt_consumer_key'];
		if($this->twt_consumer_secret=='') $this->twt_consumer_secret = $GLOBALS['twt_consumer_secret'];
		if($token=='') $token = $_SESSION['access_token']['oauth_token'];
		if($token_secret=='') $token_secret = $_SESSION['access_token']['oauth_token_secret'];
		
		$tmhOAuth = new tmhOAuth(array(
		  'consumer_key'    => $this->twt_consumer_key,
		  'consumer_secret' => $this->twt_consumer_secret,
		  'user_token'      => $token,
		  'user_secret'     => $token_secret,
		));
		
		$code = $tmhOAuth->request('GET', $tmhOAuth->url('1.1/'.$connection.'.json'), $params);
		$data = $tmhOAuth->response['response'];
		$data = json_decode($data, true);
		
		return $data;
	}
	
	/*
	function getDataFromUrl($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to make it support SSL calls on some servers
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
	*/
	
	//############################
	//START Authentication process
	function connect_process() {	
		if (isset($_REQUEST['oauth_verifier'])) $this->access_token($this->tmhOAuth);
		
		$_SESSION['twt_box']['redirect'] = $this->currentPageURL();
		
		if(isset($_SESSION['access_token']) && $_SESSION['access_token']!='') {
			return 1;
		}
		else {
			$this->request_token($this->tmhOAuth);
		}
	}
		
	function outputError($tmhOAuth) {
	  	echo 'There was an error: ' . $tmhOAuth->response['response'] . PHP_EOL;
	}
	
	// Step 1: Request a temporary token
	function request_token($tmhOAuth) {
	  	
	  	$_SESSION['twt_box']['current_url'] = $this->currentPageURL();
	  	
	  	$code = $tmhOAuth->request(
	    	'POST',
	    	$tmhOAuth->url('oauth/request_token', ''),
	    	array(
	      'oauth_callback' => $_SESSION['twt_box']['current_url']
	      )
	    );
	    
	    if ($code == 200) {
	    	$_SESSION['oauth'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
	    	$this->authorize($tmhOAuth);
	    }
	    else {
	    	$this->outputError($tmhOAuth);
	    }
	}
	
	// Step 2: Direct the user to the authorize web page
	function authorize($tmhOAuth) {
	  	$authurl = $tmhOAuth->url("oauth/authenticate", '') .  "?oauth_token={$_SESSION['oauth']['oauth_token']}";
	  	
	  	header("Location: {$authurl}");
	  	// in case the redirect doesn't fire
	  	echo '<script>window.location="'.$authurl.'";</script>';
	}
	
	// Step 3: This is the code that runs when Twitter redirects the user to the callback. Exchange the temporary token for a permanent access token
	function access_token($tmhOAuth) {
	  	$tmhOAuth->config['user_token']  = $_SESSION['oauth']['oauth_token'];
	  	$tmhOAuth->config['user_secret'] = $_SESSION['oauth']['oauth_token_secret'];
	  	
	  	$code = $tmhOAuth->request(
	    	'POST',
	    	$tmhOAuth->url('oauth/access_token', ''),
	    	array('oauth_verifier' => $_REQUEST['oauth_verifier'])
	    );
	    
	    if ($code == 200) {
	    	$_SESSION['access_token'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
	    	unset($_SESSION['oauth']);
	    	header('Location: ' . $_SESSION['twt_box']['redirect']);
	    }
	    else {
			$this->outputError($tmhOAuth);
		}
		
		return 1;
	}
	
	//get current page URL
	function currentPageURL() {
		$pageURL = 'http';
		if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}
}

?>