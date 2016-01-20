<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "menus";
$myTableArbo=$thisSite->PREFIXE_TBL_GEN . "arbo";
$orderby="chrono ASC";
$actionsPage=array("ajouter","supprimer","move");
$actionsPageOnlySA=array("ajouter","supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"code_menu","label"=>"Code","align"=>"center","width"=>"10%");
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
				
				$resultx = $PDO->free_requete("SELECT code_menu FROM " . $myTable . " WHERE id='" . $idDel ."'" );
				$rowx = $resultx->fetch();
				$code_menu=$rowx["code_menu"];

				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable;
				$myDelete->where="id=$idDel";
				$result=$myDelete->execute();
				
				$myDelete2 = new myDelete(__FILE__);
				$myDelete2->table=$myTableArbo;
				$myDelete2->where="code_menu='" . $code_menu . "'";
				$result2=$myDelete2->execute();
				
				$deleteDone=true;
			}
		}
	}
	$myAdmin->delete_notification($deleteDone,$result);
	$myAdmin->addLogs($myAdmin->pageCurrent,"DEL",$idDel,$result);
		
} // Fin suppression 
?>
<?php
// FILTRES /////////////////////////////////////// ????
// FIN FILTRES //////////////////////////////////////////
?>
<?php
// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->fields="*";
$formList->orderby=$orderby;
$formList->where="lg='" . $myAdmin->LANG_DATAS . "' AND code_menu!='horsmenu'";
// Filtres /////////////////////////////////////// ????
//
$formList->clause_where();
$count_datas = $formList->get_datas();

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	//$listChronos=array();
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