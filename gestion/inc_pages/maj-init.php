<?php
include(DOS_INC_ADMIN . "controle_login.php");
$typePage="maj";

if(@$come_by_index!=1) { echo("passer par devant. merci.");	exit; } // sécurité si appel du script PHP sans passer par l'index

$myAdmin->setChronoPages();

if($__POST["idCurrent"]!="") { $idCurrent=$__POST["idCurrent"];  }
if($idCurrent=="" && $myAdmin->nextID!="") { $idCurrent=$myAdmin->nextID;}
$myAdmin->setDatasPage("idCurrent",$idCurrent);
$myAdmin->setDatasPage("myTable",$myTable);
$smarty->assign("idCurrent", $idCurrent);

// pour savoir si c'est un ajout ou une mise à jour
if($idCurrent==0 && $idCurrent!="" ) {
	$majInsert=1;
} else {
	$majInsert=0;
}
$myAdmin->nextID="";

$filtres = $myAdmin->getDatasPage("Filtres",$myAdmin->getChronoPages(1)); // récup filtres page List

if($variablesAuthorized==true) { include(DOS_BASE_ADMIN . "inc/" . "selectVariables.php"); }

$smarty->assign("majInsert", $majInsert);

if( ($majInsert==1 && $maxElements>1) ||  ($majInsert==1 && $maxElements=="")) {	RemoveActionPage("appliquer"); }

if ($myAdmin->PRIVILEGE<9 && is_array($actionsPageOnlySA)) { 
	foreach($actionsPageOnlySA as $action){ 
	RemoveActionPage($action);
	}
}

if(strpos($myAdmin->niveaux2mod, $myAdmin->newNiveau2.",")===false) {
	RemoveActionPage("appliquer");
	RemoveActionPage("valider");
}

if($myAdmin->paramlienPage!="") {
	$paramsPage=explode(",",$myAdmin->paramlienPage);
	
	foreach ($paramsPage as $paramPage) {
		 list($codpar,$valpar)=explode("=",$paramPage);
		 ${$codpar}=$valpar;
	}
}

$reloadLangue=false;
$smarty->assign("reloadLangue", $reloadLangue);
$smarty->assign("actionsPage", $actionsPage);
$smarty->assign("typePage", $typePage);
$smarty->assign("templateParent", "../../" . DOS_INCPAGES_ADMIN . "maj-prepare.tpl");
?>