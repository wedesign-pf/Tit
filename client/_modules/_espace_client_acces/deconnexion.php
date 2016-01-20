<?php 
include_once("../../../init.php");

if($_SESSION["EC_accesOK"]!="") {

	$_SESSION["EC_accesOK"]="";
	$_SESSION["EC_essaiConnexion"]=0;


	setcookie("EC_login", "", time() - (60 * 60 * 24 * 365), COOKIE_PATH);
    setcookie("EC_mdp", "", time() - (60 * 60 * 24 * 365), COOKIE_PATH);

	echo("<script>document.location.href='" . $thisSite->racineWithLang . "'</script>");

	exit;

}

?>

