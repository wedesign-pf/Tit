<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "tags";
$orderby="id ASC";
$actionsPage=array("ajouter","supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"parent","label"=>"Parent","align"=>"left","width"=>"15%");
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
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
				$myDelete->where="id=$idDel";
				$result=$myDelete->execute();

				$deleteDone=true;
			}
		}
	}
	$myAdmin->delete_notification($deleteDone,$result);
	$myAdmin->addLogs($myAdmin->pageCurrent,"DEL",$idDel,$result);
		
} // Fin suppression 
?>
<?php
// FILTRES /////////////////////////////////////// 
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");

	$list=array();
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$myTable;
	$mySelect->fields="parent";
	$mySelect->where="lg='" . $myAdmin->LANG_DATAS . "'";
	if($forceTag!="") { $mySelect->where.=" AND parent='" . $forceTag . "'"; }
	$mySelect->orderby="parent ASC";
	$mySelect->groupby="parent";
	$result=$mySelect->query();
	foreach($result as $row){ 
		$list[$row["parent"]]=$row["parent"];
	}
	$newfield = new select();
	$newfield->field="F__parent";
	$newfield->widthLabel=0;
	$newfield->label="Champ parent";
	$newfield->items=$list;
	$newfield->value=$F__parent;
	if($forceTag=="") { $newfield->noneItem=true; }
	$newfield->defaultValue="0";
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
if($F__parent!="" && $F__parent!="noneItem") { $formList->where.=" AND parent='" . $F__parent . "'"; }
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