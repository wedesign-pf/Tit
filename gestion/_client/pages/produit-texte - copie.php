<?php
//$myAdmin->setChronoPages();
//$myAdmin->setDatasPage("myTable",$myTable);

if($idParent!="") { $myAdmin->setDatasPage("idParent",$idParent); }
if($idParent=="") {$idParent= $myAdmin->getDatasPage("idParent"); } //////////////////

if($idParent>"0") {
	$infosParent = getInfosPageParent($myTableParent,$myAdmin->LANG_DATAS,$idParent,"titre");
} else if ($__POST["id_parent"]!="") {
	$idParent=$__POST["id_parent"];
	$infosParent = getInfosPageParent($myTableParent,$myAdmin->LANG_DATAS,$idParent,"titre");	
}
$smarty->assign("idParent", $idParent);
?>
<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "produits_texte";
$orderby="chrono DESC";
$actionsPage=array("ajouter","supprimer","move");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"onglet","label"=>"Onglet","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"sidebar","label"=>"Sidebar","align"=>"center","width"=>"5%","update"=>0);
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
// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->fields="*";
$formList->orderby=$orderby;
$formList->where="lg='" . $myAdmin->LANG_DATAS . "'";
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