<?php
$id = $_POST['id'];
$feed = $_POST['feed'];
$token = $_POST['token'];
$url = $_POST['url'];
$connected_user_id = $_POST['connected_user_id']; //tell if a user is connected or no

$f1 = new Fb_ypbox();

if($url!='') {
	$data = $f1->getDataFromUrl($url);
	$data = json_decode($data, true);
}
else {
	$data = $f1->get_fb_api_results(array('object'=>$id, 'connection'=>$feed, 'token'=>$token));	
}

/*
$page_data = $f1->get_fb_api_results(array('object'=>$id, 'token'=>$token));	
echo 'Likes: <b>'.$page_data['likes'].'</b><br>';
echo 'Talking about this: <b>'.$page_data['talking_about_count'].'</b><br>';
echo 'New likes: <b>'.$page_data['new_like_count'].'</b><br>';
if($page_data['description']!='') echo 'Description: '.$page_data['description'].'<br>';
//print_r($page_data);
*/

$d1 = new Fb_ypbox_display();
$posts = $d1->formatFacebookPosts($data);
$d1->displayTimeline(array('posts'=>$posts, 'user_id'=>$id, 'connected_user_id'=>$connected_user_id));

if($data['paging']['next']!='') {
	echo '<a href="#" id="loadMorePosts" data-url="'.$data['paging']['next'].'" class="btn btn-primary">Load more</a>';
}

?>
