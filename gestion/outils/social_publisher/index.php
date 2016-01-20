<?php
$currentMenu[0] = 1;
include_once('include/webzone.php');

if(is_admin()) header('Location: ./home.php');

include_once('include/presentation/header.php');

if($GLOBALS['demo_mode']==1) {
	$username = $GLOBALS['admin_username'];
	$password = $GLOBALS['admin_password'];
}

?>

<div class="container">	
	<div class="row">
		
		<div class="span10">
			
			<form id="login_form" name="login_form" class="form-stacked">
				<div id="login_notification"></div>
				<p><label>Username</label><input type="text" id="login" name="login" value="<?php echo $username; ?>"></p>
				<p><label>Password</label><input type="password" id="password" name="password" value="<?php echo $password; ?>"></p>
				<p><input type="submit" value="Login" id="login_btn" class="btn default"></p>
			</form>
			
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