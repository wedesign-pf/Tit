<?php
$myTable=$thisSite->PREFIXE_TBL_ADM . "administrateurs";
$orderby="id ASC";
$actionsPage=array("ajouter","supprimer","dupliquer");
$actionsPageOnlySA=array("ajouter","supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"login","label"=>"Login","align"=>"left","width"=>"");
$listCols[]=array("field"=>"titre","label"=>"titre","align"=>"left","width"=>"");
$listCols[]=array("field"=>"langues","label"=>"langues","align"=>"left","width"=>"10%");
$listCols[]=array("field"=>"privilege","label"=>"Priv.","align"=>"center","width"=>"10%");

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
// DUPLICATION /////////////////////////////////////// ????
if($__POST["actionInList"]=="dupliquer" && (int)$__POST["actionListId"]) { 
	$newID = $PDO->duplication($myTable,$__POST["actionListId"],"titre", "mdp");
} // Fin Duplication 
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
$formList->where="privilege<='" . $myAdmin->PRIVILEGE . "'";
// Filtres /////////////////////////////////////// ????
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
		$valeurs["privilege"]=$datas_lang["list_privileges"][$datas["privilege"]];
		
		// fin chargement données manuellement
		
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>