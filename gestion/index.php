<?php

$racine_smarty="../";
$GESTION=1;

include_once("../init.php"); 
include_once("config_admin.php"); 
include_once(DOS_INC_ADMIN . "class.form.php");
include_once(DOS_INC_ADMIN . "class.field.php");
include_once(DOS_INC_ADMIN . "class.page.php");

$thisSite->current_lang = $thisSite->LANG_DEF;

$thisSite->initSite(); 
//
include(DOS_INC_ADMIN . "controle_login.php"); 
/////////////////////////////////////////////////////////////////////////////////
if($__POST["newNiveau0"]!="") {  $myAdmin->newNiveau0=$__POST["newNiveau0"]; }
if($__POST["newNiveau2"]!="") {  $myAdmin->newNiveau2=$__POST["newNiveau2"]; }
if($__POST["pageNew"]!="" && $__POST["newNiveau2"]=="") {  // si changement de page et niveau 2 inconnu

	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
	$mySelect->fields="id,id1";
	$mySelect->where="actif='1' AND privilege<=:privilege AND lg=:lg AND lien=:lien";
	$mySelect->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
	$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
	$mySelect->whereValue["lien"]=array($__POST["pageNew"],PDO::PARAM_STR);
	$result=$mySelect->query();
	$row = current($result);
	if($row["id"]>0) {
		$mySelect1 = new mySelect(__FILE__);
		$mySelect1->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
		$mySelect1->fields="id0";
		$mySelect1->where="actif='1' AND privilege<=:privilege AND lg=:lg AND id=:id";
		$mySelect1->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
		$mySelect1->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
		$mySelect1->whereValue["id"]=array($row["id1"],PDO::PARAM_STR);
		$result1=$mySelect1->query();
		$row1 = current($result1); 

		$__POST["newNiveau0"]=$row1["id0"];
		$myAdmin->newNiveau0=$row1["id0"];
		$myAdmin->newNiveau2=$row["id"];
	} else {
		$myAdmin->newNiveau2="";
		$__POST["pageNew"]="";
	}
}

if(isset($__POST["pageNew"]) && $__POST["pageNew"]!="" ) { // changement de page
	$pageCurrent=$__POST["pageNew"]; 
	$myAdmin->setDatasPage("start",0); 	// on remet la liste au début 
	$myAdmin->setDatasPage("Filtres",array()); 	// on remet les filtres à blanc
	$myAdmin->addLogs($pageCurrent);
} else {
	if(isset($myAdmin->pageCurrent) && $myAdmin->pageCurrent!="" ) { // on reprend la dernière page
		$pageCurrent=$myAdmin->pageCurrent;
	} else {
		$pageCurrent=PAGE_ACCUEIL; 

	}
}

// Action sur la liste ///////////////
if(isset($__POST["actionOutList"]) && $__POST["actionOutList"]!="annuler"  && $__POST["actionOutList"]!=""  ) { 
	
	$idCurrent=$__POST["actionListId"]; // on sauvegarde l'ID sélectionné
	if(strpos($pageCurrent,"-" . $__POST["actionOutList"])===FALSE) {
		if($__POST["actionListId"]!="") { $idParent=$__POST["actionListId"]; }
		$pageCurrent.= "-" . $__POST["actionOutList"];
	}
	if($__POST["actionOutList"]=="page") {
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
		$mySelect->fields="id";
		$mySelect->where="article_tableId='" . $__POST["myTableParent"] . "." . $__POST["actionListId"] . "'";
		$mySelect->limit=1;
		$result=$mySelect->query();
		$row = current($result);
		if( $row["id"]>"") {
			$idCurrent=$row["id"];
			$pageCurrent=DOS_PAGES_ADMIN . "general/pages-maj";
		}
	}
} 
if($__POST["actionOutList"]=="annuler") {
	$pageCurrent=$myAdmin->getChronoPages(1);
}

// FIN Action sur la liste ///////////////

// Action sur MAJ ///////////////
// si annulation du formulaire
if($__POST["actionForm"]=="annuler") {
	$pageCurrent=$myAdmin->getChronoPages(1);
}
// FIN Action sur MAJ ///////////////
//echoa($pageCurrent);
$myAdmin->pageCurrent=$pageCurrent;

///////////////////////////////////////////////////////////////////////////////////

$smarty->assign("dateCurrent", date("d/m/y"));
$smarty->assign("heureCurrent", date("H:i"));

$webmaster = getEmail("webmaster");
$smarty->assign("email_webmaster", $webmaster[0]);
$smarty->assign("nom_webmaster", $webmaster[1]);

// initialisation de la langue
include_once(DOS_INC_ADMIN . "loadLang.php");

//  infos sur le site
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "site";
$mySelect->fields="*";
$mySelect->where="id=:id AND lg=:lg";
$mySelect->whereValue["id"]=array($thisSite->ID_SITE,PDO::PARAM_STR);
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$row = current($result); 

$smarty->assign("page_tag_title", "ADMINISTRATION " . stripslashes($row["titre"]));
if ($myAdmin->PRIVILEGE==9) { 
	$smarty->assign("TITRE_SITE", stripslashes($row["titre"]) . " (" . $thisSite->NOM_BDD . ")");
} else {
	$smarty->assign("TITRE_SITE", stripslashes($row["titre"]));
}

//   niveau 0
$liste=array();
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
$mySelect->fields="id,titre";
$mySelect->where="actif='1' AND privilege<=:privilege AND lg=:lg";
$mySelect->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$mySelect->orderby="chrono ASC";
$result=$mySelect->query();
foreach($result as $row){ 
	if(strpos($myAdmin->niveaux0, $row['id'].",")!==false) {
		if($myAdmin->newNiveau0=="") { $myAdmin->newNiveau0=$row['id']; }
		if($myAdmin->newNiveau0==$row['id']) { 
			/*if($row['pagedef']!="") {
				$pageCurrent=$row['pagedef'];
				$myAdmin->pageCurrent=$pageCurrent;
			}*/
		}
		$liste[$row['id']] = $row['titre'];   
	}
} 
$smarty->assign("niveaux0", $liste);

if(count($myAdmin->menuNavigation)==0 || $thisSite->SERVER == "local") { 

	$mySelect0 = new mySelect(__FILE__);
	$mySelect0->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
	$mySelect0->fields="*";
	$mySelect0->where="actif='1' AND privilege<=:privilege AND lg=:lg";
	$mySelect0->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
	$mySelect0->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
	$mySelect0->orderby="chrono ASC";
	$result0=$mySelect0->query();
	foreach($result0 as $row0){
	
		$menuNavigation=array();
		
		// niveau 2 sans niveau 1
		$mySelect2 = new mySelect(__FILE__);
		$mySelect2->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
		$mySelect2->fields="*";
		$mySelect2->where="actif='1' AND privilege<=:privilege AND lg=:lg AND id0=:id0 AND id1=0";
		$mySelect2->whereValue["id0"]=array($row0['id'],PDO::PARAM_STR);
		$mySelect2->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
		$mySelect2->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
		$mySelect2->orderby="chrono ASC";
		$result2=$mySelect2->query();
		foreach($result2 as $row2){
			if(strpos($myAdmin->niveaux2, $row2['id'].",")!==false) {
				$menuNavigation[$row2['id']] = array("titre"=>$row2['titre'], "lien"=>$row2['lien'], "cible"=>$row2['cible']);  
			}
		}
			
		$mySelect1 = new mySelect(__FILE__);
		$mySelect1->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
		$mySelect1->fields="id,titre,defaut_ferme";
		$mySelect1->where="actif='1' AND privilege<=:privilege AND lg=:lg AND id0=:id0";
		$mySelect1->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
		$mySelect1->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
		$mySelect1->whereValue["id0"]=array($row0['id'],PDO::PARAM_STR);
		$mySelect1->orderby="chrono ASC";
		$result1=$mySelect1->query(0);
		foreach($result1 as $row1){ 
			if(strpos($myAdmin->niveaux1, $row1['id'].",")!==false) {

               if(!isset($myAdmin->niv1Closed[$row1['id']])) { $myAdmin->niv1Closed[$row1['id']]=$row1['defaut_ferme']; } // on charge l'état par défaut uniquement la première fois

				$menuNavigation[$row1['id']] = array("titre"=>$row1['titre'],"ferme"=>$myAdmin->niv1Closed[$row1['id']]);
			} else {
				continue;
			}
			// niveau 2
			$mySelect2 = new mySelect(__FILE__);
			$mySelect2->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
			$mySelect2->fields="*";
			$mySelect2->where="actif='1' AND privilege<=:privilege AND lg=:lg AND id1=:id1";
			$mySelect2->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
			$mySelect2->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
			$mySelect2->whereValue["id1"]=array($row1['id'],PDO::PARAM_STR);
			$mySelect2->orderby="chrono ASC";
			$result2=$mySelect2->query();
			foreach($result2 as $row2){
				if(strpos($myAdmin->niveaux2, $row2['id'].",")!==false) {
					if($myAdmin->newNiveau2==$row2['id']) { 
						$myAdmin->titrePage=$row2['titre'];
						$myAdmin->explicationsPage=$row2['explications'];
						$myAdmin->paramlienPage=$row2['param_lien'];
					}
					$menuNavigation[$row2['id']] = array("titre"=>$row2['titre'], "lien"=>$row2['lien'], "cible"=>$row2['cible']);  
				}
			} 
			 
		}
		$myAdmin->menuNavigation[$row0['id']]=$menuNavigation;
	}

}

if($myAdmin->newNiveau0!="") { 
	$smarty->assign("menuNavigation", $myAdmin->menuNavigation[$myAdmin->newNiveau0]);
} else {
	$smarty->assign("menuNavigation", current($myAdmin->menuNavigation));
}

if($myAdmin->newNiveau2!="") { 
	$mySelect2 = new mySelect(__FILE__);
	$mySelect2->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
	$mySelect2->fields="*";
	$mySelect2->where="actif='1' AND privilege<=:privilege AND lg=:lg AND id=:id";
	$mySelect2->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
	$mySelect2->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
	$mySelect2->whereValue["id"]=array($myAdmin->newNiveau2,PDO::PARAM_STR);
	$result2=$mySelect2->query();
	$row2 = current($result2);
	$myAdmin->titrePage=$row2['titre'];
	$myAdmin->explicationsPage=$row2['explications'];
	$myAdmin->paramlienPage=$row2['param_lien'];
}

//////////////////
$fichier_php=$pageCurrent . ".php";
$fichier_tpl=$pageCurrent . ".tpl";

if(!file_exists($pageCurrent . ".php")) { 
    $xx=explode("-", $pageCurrent);
    $fichier_php=array_shift($xx) . ".php";
} else {
    $fichier_php=$pageCurrent . ".php";
}

// Extention du script (rien ou -maj ou -xxx)
$xx=explode("-", $pageCurrent);
if(count($xx)>1) {
    $extensionPageCurrent="-" . $xx[count($xx)-1];
}

// CONTENU DE LA PAGE
if($fichier_php!="") {

	$datas_page=array();

    $smarty->assign("thisSite", $thisSite);
	$_SESSION["thisSite"] = serialize($thisSite);

	$come_by_index=1; ////////// IMPORTANT: permet de vérifier que l'on passe bien par l'index

	if(file_exists(DOS_BASE_ADMIN . $fichier_php)) {  include(DOS_BASE_ADMIN . $fichier_php);}

    if($forceTemplate!="") { $fichier_tpl=$forceTemplate . ".tpl"; }
	
    $smarty->assign("datas_page",$datas_page);  

	if(file_exists($fichier_tpl)) {	
		$smarty->assign("script_tpl", $fichier_tpl);
       
	} else {
		$smarty->assign("script_tpl", "");
        
	}

	$smarty->assign("myAdmin", $myAdmin);

	$structure_page= DOS_BASE_ADMIN . "templates/" . "page.tpl";


	$smarty->display($structure_page );

}

//
if($__POST["actionForm"]!="valider") {
	$myAdmin->notification="";
}
$_SESSION["myAdmin"] = serialize($myAdmin);
?>