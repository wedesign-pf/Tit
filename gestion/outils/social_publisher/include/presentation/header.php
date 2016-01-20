<!DOCTYPE html>
<head>

<title>Social Publisher</title> 

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta charset="UTF-8" />

<!-- Include CSS files -->
<link rel="stylesheet" href="include/css/bootstrap.min.css" type="text/css">
<link rel="stylesheet" href="include/css/bootstrap-responsive.min.css" type="text/css">
<link rel="stylesheet" href="include/css/style.css" type="text/css">

<!-- Include JS files -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="include/js/bootstrap.min.js"></script>
<script type="text/javascript" src="include/js/script.js"></script>
<script type="text/javascript" src="include/js/json2.js"></script>

<script> 
jQuery(document).ready(function() {
	<?php
	echo $jsOnReady;
	?>
})
</script>

</head>

<body>

<?php
$f1 = new Fb_ypbox();
$f1->loadJsSDK();
$f1->load_js_functions();
?>

<div class="container">
	<h1 style="margin-bottom:5px;">Social Publisher</h1>
	<span style="color: #666;">Save time and manage your different social accounts from one place!</span>
	<hr>
	
	<?php
	if($GLOBALS['demo_mode']==1) {
	?>
		<div class="yellowBox">
			Please note that the delete / add account / and publishing features has been <b>disabled in this demo</b>
		</div>
	<?php
	}
	?>
	
</div>
