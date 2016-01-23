<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "itineraires_overview";
$orderby="chrono ASC";

$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"ile","label"=>"Ile(s)","align"=>"left","width"=>"20%");
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
$newfield->label="Titre";
$newfield->placeholder="Si vide, le titre sera 'JOUR 99'";
$newfield->add();

// on charge toutes les iles
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "iles";
$mySelect->fields="id,titre";
$mySelect->where="actif=1 AND lg=:lg";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$tab_iles_full=array();
foreach($result as $row){
   $tab_iles_full[$row["id"]]=$row["titre"];
}
// on charge les iles définies pour l'itinéraire
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "itineraires";
$mySelect->fields="ile";
$mySelect->where="actif=1 AND lg='fr' and id=".$idParent;
$result=$mySelect->query();
$tab_iles=array();
foreach($result as $row){
    $l_iles=explode(",",$row["ile"]);
    foreach($l_iles as $id_ile){
        if($id_ile!="") {
            $tab_iles[$id_ile]=$tab_iles_full[$id_ile];
        }
    }
}

$newfield = new selectM();
$newfield->field="ile";
$newfield->multiLang=false;
$newfield->label="Ile(s)";
$newfield->items=$tab_iles;
$newfield->selectAll=false;
$newfield->add();

// Hébergements
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits";
$mySelect->fields="id,titre";
$mySelect->where="actif=1 AND lg=:lg AND type=23";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$tab_hebergements=array();
foreach($result as $row){
   $tab_hebergements[$row["id"]]=$row["titre"];
}
$newfield = new selectM();
$newfield->field="hebergement";
$newfield->multiLang=false;
$newfield->label="Hébergement";
$newfield->items=$tab_hebergements;
$newfield->selectAll=false;
$newfield->filter=true;
$newfield->add();

// Excursions
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits";
$mySelect->fields="id,titre";
$mySelect->where="actif=1 AND lg=:lg AND type=24";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$tab_excursions=array();
foreach($result as $row){
   $tab_excursions[$row["id"]]=$row["titre"];
}
$newfield = new selectM();
$newfield->field="excursion";
$newfield->multiLang=false;
$newfield->label="Excursion(s)";
$newfield->items=$tab_excursions;
$newfield->selectAll=false;
$newfield->filter=true;
$newfield->add();


// Services
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits";
$mySelect->fields="id,titre";
$mySelect->where="actif=1 AND lg=:lg AND type=25";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$tab_services=array();
foreach($result as $row){
   $tab_services[$row["id"]]=$row["titre"];
}
$newfield = new selectM();
$newfield->field="service";
$newfield->multiLang=false;
$newfield->label="Service(s)";
$newfield->items=$tab_services;
$newfield->selectAll=false;
$newfield->filter=true;
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

$day=0;
if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	//$listChronos=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();

		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");
        
        $day++;
        if($valeurs["titre"]=="") { 
            $valeurs["titre"]="[" . "Jour ".$day . "]";
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