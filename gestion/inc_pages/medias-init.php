<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "medias";
$orderby="chrono DESC";

$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");

 if(is_array($datasMedia["actif"])) {
	$listCols[]=array("field"=>"actif","label"=>$datasMedia["actif"]["label"],"align"=>"center","width"=>"7%","update"=>$datasMedia["actif"]["update"]);
}
 if(is_array($datasMedia["choix1"])) {
	if($fieldMedia->type=="image" || $fieldMedia->type=="video") {
		$listCols[]=array("field"=>"image_principale","label"=>$datasMedia["choix1"]["label"],"align"=>"center","width"=>"8%","update"=>$datasMedia["choix1"]["update"]);
	}
}
if($fieldMedia->type=="link") {
	$listCols[]=array("field"=>"lien_destination","label"=>"Lien","align"=>"left","width"=>"");
} else {
	$listCols[]=array("field"=>"fichier_media","label"=>"Fichier","align"=>"left","width"=>"");
}
$listCols[]=array("field"=>"titre_media","label"=>"Legende","align"=>"left","width"=>"");
?>
<?php
include(DOS_INC_ADMIN . "controle_login.php");
$typePage="medias";
if(@$come_by_index!=1) { echo("passer par devant. merci.");	exit; } // sécurité si appel du script PHP sans passer par l'index

$myAdmin->setChronoPages();

$myAdmin->setDatasPage("myTable",$myTable);
if($idParent!="") { $myAdmin->setDatasPage("idParent",$idParent); }
if($idParent=="") {$idParent= $myAdmin->getDatasPage("idParent"); } //////////////////

if($idParent>"0") {
	$myTableParent=$myAdmin->getDatasPage("myTable",$myAdmin->getChronoPages(1));
	$infosParent = getInfosPageParent($myTableParent,$myAdmin->LANG_DATAS,$idParent,"titre");
} else if ($__POST["id_parent"]!="") {
	$idParent=$__POST["id_parent"];
	$myTableParent=$__POST["myTableParent"];
	$infosParent = getInfosPageParent($myTableParent,$myAdmin->LANG_DATAS,$idParent,"titre");	
}

addStructure("addCssStructure",DOS_SKIN_ADMIN . "style_list.css");
addStructure("addJsStructure", $thisSite->RACINE . $thisSite->DOS_ADMIN . DOS_OUTILS_ADMIN . "sortable/jquery-sortable-min.js");

$actionsPage=array("ajouter","appliquer","supprimer","move");

if(strpos($myAdmin->niveaux2add, $myAdmin->newNiveau2.",")===false) {
	RemoveActionPage("ajouter");	
}
if(strpos($myAdmin->niveaux2del, $myAdmin->newNiveau2.",")===false) {
	RemoveActionPage("supprimer");	
}

if(strpos($myAdmin->niveaux2mod, $myAdmin->newNiveau2.",")===false) {
	RemoveActionPage("appliquer");
	RemoveActionPage("valider");	
}

$filtres = $myAdmin->getDatasPage("Filtres",$myAdmin->getChronoPages(1)); // récup filtres page List

include(DOS_BASE_ADMIN . "inc/" . "selectVariables.php");

if($__POST["actionInList"]=="move") { moveList($myTable,$__POST["actionListId"]); }

$smarty->assign("reloadLangue", $reloadLangue);
$smarty->assign("actionsPage", $actionsPage);
$smarty->assign("typePage", $typePage);
$smarty->assign("idParent", $idParent);
$smarty->assign("myTableParent", $myTableParent);
$smarty->assign("templateParent", "../../" . DOS_INCPAGES_ADMIN . "list-prepare.tpl");
$smarty->assign("maxElements", $fieldMedia->maxElements);
?>