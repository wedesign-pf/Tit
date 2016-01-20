<?php
$currentMenu[0] = 1;
include_once('include/webzone.php');

if(!is_admin()) header('Location: ./');
$jsOnReady = '$("#status").focus();';

include_once('include/presentation/header.php');
?>

<div class="container">	
	<div class="row">
		
		<div class="span5">
			
			<form id="posting_box">
				<p>Connected as admin (<a href="./listeners/logout.php">logout</a>) - <a href="history.php">History</a></p>
				<div style="margin-bottom:5px;"><b>Message / status:</b></div>
				<div><textarea id="status" style="width:100%; height:120px;"></textarea></div>
				<div><b>Link:</b><br><input type="text" id="link" style="width:100%;"></div>
				<div><b>Image URL:</b><br><input type="text" id="image" style="width:100%;"></div>
				<input type="submit" id="post_btn" class="btn btn-primary" value="Preview postings">
			</form>
			
			<div id="preview_posting_box" style="display:none;"></div>
			
		</div>
		
		<div class="span5">
			<div style="margin-left:30px;">
				<?php
				$users = getUsers(array('type'=>1));
				
				if(count($users)>0) echo '<p><b>Facebook</b> (<a href="./account/fb_connect.php">update</a>)</p>';
				else echo '<p><b>Facebook</b> (<a href="./account/fb_connect.php">connect</a>)</p>';
				
				if(count($users)>0) {
					for($i=0; $i<count($users); $i++) {
						
						$picture = 'https://graph.facebook.com/'.$users[$i]['user_id'].'/picture';
						$link = 'http://www.facebook.com/profile.php?id='.$users[$i]['user_id'];
						
						if($users[$i]['token_expires']==0 || $users[$i]['token_expires']>time()) {
							echo '<label>';
							echo '<img src="'.$picture.'" style="vertical-align:middle; width:25px; margin-right:5px;">';
							echo '<input type="checkbox" name="fb_accounts[]" data-user-id="'.$users[$i]['user_id'].'"> ';
							echo $users[$i]['name'].' (<a href="./account/fb_logout.php?id='.$users[$i]['user_id'].'">delete</a>)';
							echo '</label>';							
						}
					}					
				}
				
				$users = getUsers(array('type'=>2));
				if(count($users)>0) echo '<br><p><b>Twitter</b> (<a href="./account/twt_connect.php">add new</a>)</p>';
				else echo '<br><p><b>Twitter</b> (<a href="./account/twt_connect.php">connect</a>)</p>';
				
				if(count($users)>0) {
					for($i=0; $i<count($users); $i++) {
						
						$link = 'http://twitter.com/'.$users[$i]['username'];
						
						echo '<label>';
						echo '<img src="'.$users[$i]['picture'].'" style="vertical-align:middle; width:25px; margin-right:5px;">';
						echo '<input type="checkbox" name="twt_accounts[]" data-user-id="'.$users[$i]['user_id'].'"> ';
						echo $users[$i]['username'].' (<a href="./account/twt_logout.php?id='.$users[$i]['user_id'].'">delete</a>)';
						echo '</label>';				
					}
				}
				?>
			</div>
			
		</div>
		
		<div class="span2" style="text-align:right;">
			
			<p>Some of our other apps</p>
			
			<a href="http://codecanyon.net/item/advanced-php-store-locator/244349?ref=yougapi" target="_blank"><img src="./include/graph/advanced-store-locator-mini.png" style="margin-bottom:10px;"></a>
			<a href="http://codecanyon.net/item/jquery-carousel-evolution-for-wordpress/702228?ref=yougapi" target="_blank"><img src="./include/graph/carousel-wpress-mini.png" style="margin-bottom:10px;"></a>
			&nbsp;<a href="http://codecanyon.net/item/domains-names-checker/3298128?ref=yougapi" target="_blank"><img src="./include/graph/domains-checker-mini.png" style="margin-bottom:10px;"></a>
			<a href="http://codecanyon.net/item/facebook-images-gallery/3281185?ref=yougapi" target="_blank"><img src="./include/graph/fb-gallery-mini.png" style="margin-bottom:10px;"></a>
			
			<br>
			
			<p>Featured mobile apps</p>
			<a href="http://codecanyon.net/item/mobile-site-builder/491023?ref=yougapi" target="_blank"><img src="./include/graph/mobile-builder-mini.png" style="margin-bottom:10px;"></a>
			<a href="http://codecanyon.net/item/mobile-store-locator/239351?ref=yougapi" target="_blank"><img src="./include/graph/mobile-store-locator-mini.png" style="margin-bottom:10px;"></a>
			
		</div>
		
	</div>
</div>

<?php
include_once('include/presentation/footer.php');
?>