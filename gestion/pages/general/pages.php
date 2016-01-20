<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "pages";
$myTableArbo=$thisSite->PREFIXE_TBL_GEN . "arbo";
$orderby="id ASC";
$actionsPage=array("ajouter","supprimer","dupliquer");
$actionsPageOnlySA=array("ajouter","supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"titre","label"=>"Titre menu","align"=>"left","width"=>"");
if ($myAdmin->PRIVILEGE==9) { 
    $listCols[]=array("field"=>"super_admin_only","label"=>"SA only","align"=>"center","width"=>"5%","update"=>0);
	$listCols[]=array("field"=>"page_type","label"=>"Type","align"=>"center","width"=>"5%");
	$listCols[]=array("field"=>"page_url","label"=>"Url","align"=>"left","width"=>"");
	$listCols[]=array("field"=>"page_php","label"=>"Script PHP","align"=>"left","width"=>"");
} else {
	$listCols[]=array("field"=>"page_url","label"=>"Url","align"=>"left","width"=>"");
}
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-init.php");
?>
<?php
// SUPPRESSION /////////////////////////////////////// ????

if($__POST["actionInList"]=="delete") { // suppression
	foreach ($_POST as $k => $v) { 
		if(strpos($k,"deleteMe")===0) {	
			$idDel=substr($k,8);
			if ((int)$idDel) {
				
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable;
				$myDelete->where="id=$idDel AND page_php!='" . $thisSite->script_HP . "' AND super_admin_only=0";
				$result=$myDelete->execute();

				deleteArbo($idDel);// suppression dans l'arbo
				
				deleteArbo($idDel);// suppression dans l'arbo
				
				$thisSite->reInit=1; // permet la réactualisation du site public pour que les modifications soient prisent en compte

				$deleteDone=true;
			}
		}
	}
	$myAdmin->delete_notification($deleteDone,$result);
	$myAdmin->addLogs($myAdmin->pageCurrent,"DEL",$idDel,$result);
		
} // Fin suppression 
// DUPLICATION /////////////////////////////////////// ????

if($__POST["actionInList"]=="dupliquer" && (int)$__POST["actionListId"]) { 
	$newID = $PDO->duplication($myTable,$__POST["actionListId"],"titre,page_titre", "page_url");
} // Fin Duplication 
?>
<?php
// FILTRES /////////////////////////////////////// ????
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");
$newfield = new input();
$newfield->field="F__titre";
$newfield->multiLang=false;
$newfield->label=$datas_lang["pageTitreMenu"];
$newfield->widthField=4;
$newfield->value=${$newfield->field};
$newfield->javascript="onChange='submitFiltres()'";
$newfield->add();

$newfield = new select();
$newfield->field="F__genre";
$newfield->label="Genre";
$newfield->widthLabel=0;
$newfield->items=$myAdmin->genresPages;
$newfield->value=${$newfield->field};
$newfield->javascript="onChange='submitFiltres()'";
$newfield->add();
// FIN FILTRES //////////////////////////////////////////
?>
<?php
// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->fields="*";
$formList->orderby=$orderby;
$formList->where="lg='" . $myAdmin->LANG_DATAS . "'";
// Filtres /////////////////////////////////////// ????
if($F__titre!="") { $formList->where.=" AND titre LIKE '" . $F__titre . "%'"; }
if ($myAdmin->PRIVILEGE!=9) {  $formList->where.=" AND super_admin_only = 0"; }
if ($F__genre!="C") {  $formList->where.=" AND page_genre = '" . $F__genre . "'"; }
if ($F__genre=="C") {  $formList->where.=" AND page_genre = ''"; }
//
$formList->clause_where();
$count_datas = $formList->get_datas();

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();

		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");

		// chargement d'autres données /////////////////////////////////////// ????

		// fin chargement données manuellement
		
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>