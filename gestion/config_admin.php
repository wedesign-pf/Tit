<?php
$adminActive=true;

define("DOS_BASE_ADMIN",""); // dossier pour éléments de base de l'administration
define("DOS_CLIENT_ADMIN","_client/"); // dossier pour éléments spécifique de l'administration
define("DOS_OUTILS_ADMIN", "outils/"); // dossier pour les outils de base de l'administration
define("SKIN_ADMIN", "defaut"); // skin
define("DOS_SKIN_ADMIN", DOS_BASE_ADMIN . "css/". SKIN_ADMIN . "/"); // dossier des css
define("DOS_INC_ADMIN",DOS_BASE_ADMIN . "inc/"); 
define("DOS_INCPAGES_ADMIN",DOS_BASE_ADMIN . "inc_pages/"); 
define("DOS_AJAX_ADMIN",DOS_BASE_ADMIN . "ajax/"); 
define("DOS_PAGES_ADMIN",DOS_BASE_ADMIN . "pages/"); 

define("PAGE_ACCUEIL",DOS_PAGES_ADMIN . "commun/accueil"); 

define("POIDSMAX",5048576); // poids max des fichiers à upload en octet

define("EDITOR","TM"); // CK (CKeditor) ou TM (TINYMCE)

include_once(DOS_INC_ADMIN . "class.admin.php");
include_once(DOS_INC_ADMIN . "fonctions.php");

if (isset($_SESSION["myAdmin"]) && $__POST["request"]!="initMyAdmin")  { 
	//echoa("existe");
	$myAdmin = unserialize($_SESSION["myAdmin"]); 
} else {  
	$myAdmin = new myAdmin(); 
	//echoa("new");
} 


$myAdmin->LANG_DATAS="en";
$myAdmin->LIST_LANG_CONTROLE=array($myAdmin->LANG_DATAS =>$myAdmin->LIST_LANG_DATAS[$myAdmin->LANG_DATAS]); 

$myAdmin->catIntitule=array("lab"=>"Intitulé","tit"=>"Titre","btn"=>"Bouton","msg"=>"Message","div"=>"Divers"); 

// GESTION DES ERREURS
/*if ($thisSite->SERVER == "prod" && $thisSite->errorLog==1) {
	error_reporting(0);
	set_error_handler('erreursPHP');
	set_exception_handler("exceptionsPHP");
	register_shutdown_function('erreursFatalesPHP');
	$smarty->muteExpectedErrors();
}*/
?>