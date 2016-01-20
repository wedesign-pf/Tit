<?php
include('../include/webzone.php');

$fb_ids = $_POST['fb_ids'];
$twt_ids = $_POST['twt_ids'];
$status = $_POST['status'];
$link = $_POST['link'];
$image = $_POST['image'];

if($fb_ids!='') {
	echo '<p><b>Facebook posting</b></p>';
	echo '<div style="position:relative;">';
		if($image!='') echo '<img src="'.$image.'" style="position:absolute; left:0px; top:0px; margin-right:10px; width:65px;">';
		echo '<p style="margin-left:80px;">';
		echo $status;
		if($link!='') echo '<br><a href="'.$link.'" target="_blank">'.$link.'</a>';
		echo '</p>';
	echo '</div><div style="clear:both;"></div>';
}

if($twt_ids!='') {
	
	if($link=='') {
		$status = substr($status, 0, 140);
	}
	else {
		if($GLOBALS['shorten_url']==1) {
			$api_url = 'https://www.googleapis.com/urlshortener/v1/url';
			if($GLOBALS['google_api_key']!='') $api_url .= '?key='.$GLOBALS['google_api_key'];		
			$result = json_curl_call($api_url, json_encode(array("longUrl"=>$link)), 'json');
			$result = json_decode($result,true);
			$shortUrl = $result['id'];
			
			if($shortUrl!='') {
				$status = substr($status, 0, 115);
				$status .= ' '.$shortUrl;
			}
			else {
				$status = substr($status, 0, 140);
			}
		}
		else {
			$nb = strlen($link);
			if($nb<20) {
				$status = substr($status, 0, 115);
				$status .= ' '.$link;
			}
			else {
				$status = substr($status, 0, (135-$nb));
				$status .= ' '.$link;
			}
		}		
	}
	
	echo '<br><p><b>Twitter posting</b></p>';
	echo '<div id="twt_status">'.$status.'</div>';
}

?>

<br>
<p><a href="#" id="cancel_publish_btn">Cancel</a> - <input type="submit" id="publish_btn" class="btn btn-primary" value="Publish"></p>