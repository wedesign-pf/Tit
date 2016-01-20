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
$formList->where="lg='". $myAdmin->LANG_DATAS . "' AND field_media='". $fieldMedia->field . "' AND type like '". $fieldMedia->type . "%'";
if($idParent!="") {
	$formList->where.=" AND id_parent=" . $idParent;
}
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