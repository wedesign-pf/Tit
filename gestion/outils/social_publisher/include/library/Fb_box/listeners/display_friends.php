<?php
$token = $_POST['token'];
$url = $_POST['url'];

if($url!='') {
	$f1 = new Fb_ypbox();
	$data = $f1->getDataFromUrl($url);
	$data = json_decode($data, true);
}
else {
	$f1 = new Fb_ypbox();
	$data = $f1->get_fb_api_results(array('object'=>$id, 'connection'=>'taggable_friends', 'token'=>$token));	
}

//print_r($data);

$friends = $data['data'];

if($url=='' && count($friends)>0) {
	echo '<div><h3>'.count($friends).' friends</h3></div>';
}

for($i=0; $i<count($friends); $i++) {
	$id = $friends[$i]['id'];
	$name = $friends[$i]['name'];
	$image = $friends[$i]['picture']['data']['url'];
	
	echo '<div style="position:relative; overflow:hidden;">';
	echo '<img src="'.$image.'" style="margin-right:10px; margin-bottom:10px; float:left;">';
	echo '<div>'.$name.'</div>';
	echo '<span style="position:absolute; right:0px; top:15px;">';
	echo '</span>';
	echo '</div>';
	echo '<hr style="margin-top:0px; margin-bottom:5px;">';
}

if($data['paging']['next']!='') {
	echo '<div id="displayMoreFriendsBox"><a href="#" class="loadMoreFriendsBtn btn" data-url="'.$data['paging']['next'].'" class="btn">Load more</a></div>';
}

?>