<?php
include(DOS_INC_ADMIN . "controle_login.php");
$typePage="list";

if(@$come_by_index!=1) { echo("passer par devant. merci.");	exit; } // sécurité si appel du script PHP sans passer par l'index

$myAdmin->setChronoPages();

$myAdmin->setDatasPage("myTable",$myTable);
addStructure("addCssStructure",DOS_SKIN_ADMIN . "style_list.css");


if ($myAdmin->PRIVILEGE<9 && is_array($actionsPageOnlySA)) { 
	foreach($actionsPageOnlySA as $action){ 
		RemoveActionPage($action);
	}
}

if(strpos($myAdmin->niveaux2add, $myAdmin->newNiveau2.",")===false) {
	RemoveActionPage("ajouter");
	RemoveActionPage("dupliquer");		
}
if(strpos($myAdmin->niveaux2del, $myAdmin->newNiveau2.",")===false) {
	RemoveActionPage("supprimer");	
}

if($myAdmin->paramlienPage!="") {
	$paramsPage=explode(",",$myAdmin->paramlienPage);
	
	foreach ($paramsPage as $paramPage) {
		 list($codpar,$valpar)=explode("=",$paramPage);
		 ${$codpar}=$valpar;
	}
}

$smarty->assign("reloadLangue", $reloadLangue);
$smarty->assign("actionsPage", $actionsPage);
$smarty->assign("typePage", $typePage);

if($__POST["actionInList"]=="move") { moveList($myTable,$__POST["actionListId"]); }

$smarty->assign("templateParent", "../../" . DOS_INCPAGES_ADMIN . "list-prepare.tpl");
?>