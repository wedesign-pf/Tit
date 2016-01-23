<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "itineraires_texte";
$orderby="chrono ASC";

$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"onglet","label"=>"Onglet","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"sidebar","label"=>"Sidebar","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
?>
<?php
include(DOS_INC_ADMIN . "controle_login.php");
$typePage="itineraire";

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
<?php
if($__POST["idCurrent"]!="") { // indique la modification d'un élément
	$idCurrent=$__POST["idCurrent"];
}

$formMaj = new formMaj();
$formMaj->tables=$myTable;
$formMaj->fields="*";
$formMaj->where="id=:id";
$formMaj->whereValue["id"]=array($idCurrent,PDO::PARAM_INT);
$formMaj->multiLang=true;
$formMaj->clause_where();

// si validation du formulaire
if($__POST["actionForm"]!="") {

	$formMaj->set_datas();
}
?>
<?php
$newfield = new hidden();
$newfield->field="id_parent";
$newfield->multiLang=false;
$newfield->defaultValue=$idParent;
$newfield->add();

$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=true;
$newfield->label="Titre (si différent du type)";
$newfield->add();

// on charge tout les types de texte
$obj_article = new article("type_texte_itineraire");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_type_texte_itineraire=array();
foreach($result as $row){
   $tab_type_texte_itineraire[$row["id"]]=$row["titre"];
}
// on charge les types de texte utilisés
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTable;
$mySelect->fields="type_texte";
$mySelect->where="actif=1 AND lg='fr' and id_parent=".$idParent;
$result=$mySelect->query();
$tab_type_texte=array();
foreach($result as $row){
   $tab_type_texte[]=$row["type_texte"];
}

$newfield = new select();
$newfield->field="type_texte";
$newfield->multiLang=false;
$newfield->label="Type texte";
$newfield->noneItem=true;
$newfield->items=$tab_type_texte_itineraire;
$newfield->valuesDisabled=$tab_type_texte;
$newfield->add();

$newfield = new editor();
$newfield->field="texte";
$newfield->label="Texte";
$newfield->height=400;
$newfield->multiLang=true;
$newfield->startFolder="itineraires";
$newfield->variablesAuthorized=true;
$newfield->add();
?>
<?php

////////////////////////////////////////////////////////////////
// Action sur la liste ///////////////
if($__POST["actionInList"]=="delete") { // suppression
	foreach ($_POST as $k => $v) { 
		if(strpos($k,"deleteMe")===0) {	
			$idDel=substr($k,8);
			if ((int)$idDel) {
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable;
				$myDelete->where="id=$idDel";
				$result=$myDelete->execute();
				$deleteDone=true;
			}
		}
	}
	$myAdmin->delete_notification($deleteDone,$result);
		
} // Fin suppression 
?>
<?php
// FILTRES //////////////////////////////////////////

// FIN FILTRES //////////////////////////////////////////
?>
<?php 
// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->fields="*";
$formList->orderby=$orderby;
$formList->where="lg='". $myAdmin->LANG_DATAS . "'";
$formList->where.=" AND id_parent=" . $idParent;
$formList->clause_where();
$count_datas = $formList->get_datas();

// on interdit l'ajout si nombre max dépassé
if($count_datas >= $fieldMedia->maxElements && $fieldMedia->maxElements>0) {
	RemoveActionPage("ajouter");
}

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	//$listChronos=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();

		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");

        if($valeurs["titre"]=="") { 
            $valeurs["titre"]=$tab_type_texte_itineraire[$datas["type_texte"]];
        } else {
            $valeurs["titre"].= " [" . $tab_type_texte_itineraire[$datas["type_texte"]] . "]";
        }
        
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
$smarty->assign("listCols", $listCols);
$smarty->assign("listRow", $listRow);
//$smarty->assign("listChronos", $listChronos);
$smarty->assign("myTable", $myTable);
$smarty->assign("boutons", $boutons);
$smarty->assign("clauseWhere", urlencode($formList->where));
?>