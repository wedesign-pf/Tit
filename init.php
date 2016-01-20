<?php

error_reporting(E_ALL);

if (session_id() == "") session_start(); 

include_once("commun/inc/" . "class.site.php");

if (isset($_SESSION["thisSite"]) && !isset($_GET["init"]))  { 
   //echo("existe");
   $thisSite = unserialize($_SESSION["thisSite"]); 
} else {  
	$thisSite = new thisSite(); 
	//echo("new");
}  

include($thisSite->DOS_CLIENT . "config.php");
error_reporting($thisSite->errorReporting);
?>
<?php

date_default_timezone_set($thisSite->TIMEZONE); 

ini_set('session.cookie_httponly', 1); // Prevents javascript XSS attacks aimed to steal the session ID
ini_set('session.use_only_cookies', 1); // Session ID cannot be passed through URLs
ini_set('session.cookie_secure', 0); // Uses a secure connection (HTTPS) if possible
//ini_set('session.use_trans_sid', '0');
ini_set('allow_url_fopen', 1);
ini_set('allow_url_include', 1);

define("COOKIE_EXPIRE", 60 * 60 * 24 * 100); //100 days by default
define("COOKIE_PATH", "/"); //Avaible in whole domain
//// exemple : setcookie("email", $__GET["email"], time() + COOKIE_EXPIRE, COOKIE_PATH);

// Includes
include_once($thisSite->DOS_BASE_FCT . "fonctions_all.php");
include_once($thisSite->DOS_CLIENT_INC  . "fonctions_client.php");
include_once($thisSite->DOS_BASE_INC . "class.modules.php");
include_once($thisSite->DOS_BASE_INC . "class.outils.php");
include_once($thisSite->DOS_BASE_INC . "class.bdd.php");
include_once($thisSite->DOS_BASE_INC . "class.logs.php");
include_once($thisSite->DOS_BASE_INC . "class.medias.php");
include_once($thisSite->DOS_BASE_INC . "class.articles.php");

if($thisSite->mobile_detect) {
    include_once($thisSite->DOS_BASE_LIB . "mobile_detect.php");
    $Mobile_Detect = new Mobile_Detect;
}

// Initialisation Smarty
include_once($thisSite->DOS_BASE_LIB . "Smarty/libs/" . "Smarty.class.php");
$smarty = new Smarty();
$smarty->setTemplateDir($racine_smarty . "smarty/templates/");
$smarty->setCompileDir($racine_smarty . "smarty/templates_c/");
$smarty->setCacheDir($racine_smarty . "smarty/cache/");
$smarty->caching = $thisSite->SMARTY_CACHING;
$smarty->cache_lifetime = $thisSite->CACHE_LIFETIME;
$smarty->compile_check = FALSE;
$smarty->force_compile = TRUE;
$smarty->debugging = FALSE;
$smarty->error_reporting = E_ALL & ~E_NOTICE;
$smarty->muteExpectedErrors();
//

// Traitement des GET et POST
$__GET=array();
$__POST=array();
if ( isset($_GET) )		{ foreach ($_GET as $k => $v) { $__GET[$k] =  ctr_global($v,"strip_tags"); } }
if ( isset($_POST) )	{ foreach ($_POST as $k => $v) { $__POST[$k] =  ctr_global($v); } }
$smarty->assign("__GET",$__GET);
$smarty->assign("__POST",$__POST);

///////////////////////////////////////////////////////////////////////////////
?>