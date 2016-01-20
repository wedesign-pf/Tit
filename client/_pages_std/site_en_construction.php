<?php 
include_once("init.php");
include($thisSite->DOS_BASE_FCT . "fonctions_all.php");
@include($thisSite->DOS_BASE . "lang/" . $thisSite->current_lang .".php");
?>
<?php 
$email_webmaster = getEmail('webmaster');

if($__POST["email"]!="" && check_mail($__POST["email"])) {
	$headers = "From: ".$__POST["email"]."\n"."MIME-Version: 1.0"."\n"."Content-type: text; charset=utf-8"."\n";
	$objet = "Souhaite être informé de l'ouverture de votre site " . $thisSite->DOMAINE;
	$destinataire = $email_webmaster;
	mail($destinataire[0], $objet, "", $headers);
	$envoi=1;
}
?>
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
*,
*:after,
*:before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
    margin: 0;
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}

body {
	background-color: #f080a4;
	background-image: url(commun/css/fond_repeat.png);
	background-repeat: repeat;
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 12px;
	color: #404040;
}

a {
	color: #000;
	text-decoration: none;
}
a:hover{
	text-decoration: underline;
}

.text {
	padding:10px 0px;	
}

#container {
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -150px 0 0 -230px;
	width: 460px;
	background-color: rgba(255,255,255,0.85);
	padding:10px 15px;
	text-align:center;
}
.form-2 {
	margin: auto;
	padding: 10px;
	position: relative;
}

.form-2 h1 {
    font-size: 14px;
    font-weight: bold;
    color: #E1014A;
    padding-bottom: 8px;
    border-bottom: 1px solid #EBE6E2;

}

.form-2 .float {
    width: 50%;
    float: left;
    padding-top: 15px;

}


.form-2 .float:last-of-type {
    padding-left: 15px;
}



.form-2 input[type=text]{
    font-size: 13px;
    display: block;
    width: 100%;
    padding: 5px;
    margin-bottom: 5px;
    border: 3px solid #ebe6e2;
    border-radius: 5px;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
}

.form-2 input[type=text]:hover,
.form-2 input[type=password]:hover {
    border-color: #CCC;
}

.form-2 label:hover ~ input {
    border-color: #CCC;
}

.form-2 input[type=text]:focus,
.form-2 input[type=password]:focus {
    border-color: #BBB;
    outline: none; /* Remove Chrome's outline */
}

.form-2 input[type=submit] {
    /* Size and position */
	width: 90%;
    height: 30px;

    position: relative;

   
    border-radius: 3px;
    cursor: pointer;

    /* Font styles */

    font-size: 13px;
    line-height: 30px; /* Same as height */
    text-align: center;
    font-weight: bold;

    margin-right: 15px;
	
    background: #E1014A; 

    border: none;
    color: #fff;
}

.form-2 input[type=submit]:hover {
background: #F080A4; 
}

</style>
</head>
<body>
<div id="container">
			<section class="main">
				<form class="form-2" action="" method="post">
					<h1><span class="log-in">SITE EN CONSTRUCTION -SITE UNDER CONSTRUCTION</span></h1>
					<?php if($envoi==1) { ?>
					<p class="clearfix text">
					Merci de votre intêret pour notre futur site internet<br>
					Thank you for your interest in our future website
					</p>
					<?php } else { ?>
					<p class="clearfix text">
					Si vous souhaitez être informé de l'ouverture de ce site<br>
					If you wish to be informed of the opening of this site
					</p>
					<p class="float">
					<input type="text" name="email" placeholder="Email">
					</p>
                    <p class="float">
                    <input type="submit" name="submit" value="ENVOYER">
                    </p> 
                    <?php } ?>
				</form>​​
			</section><p class="clearfix text">
			<div id="copyright"><?php echo($datas_lang["copyright_author"]); ?></div>
			</p>
        </div>
        
</body>
</html>