<?php
$myTable=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
$myTable1=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
$myTable2=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
$myTableAdmin=$thisSite->PREFIXE_TBL_ADM . "administrateurs";
$orderby="chrono ASC";
$actionsPage=array("ajouter","supprimer","move","duplication");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
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
				$resultx = $PDO->free_requete("SELECT id FROM " . $myTable1 . " WHERE id0=" . $idDel );
                
				foreach($resultx as $rowx){
					$myDelete = new myDelete(__FILE__);
					$myDelete->table=$myTable2;
					$myDelete->where="id1=" . $rowx["id"];
					$result=$myDelete->execute();
				}
                
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable1;
				$myDelete->where="id0=$idDel";
				$result=$myDelete->execute();
				
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable;
				$myDelete->where="id=$idDel";
				$result=$myDelete->execute();
				
				// suppression des droits
				$resultx = $PDO->free_requete("SELECT id,niveaux0 FROM " . $myTableAdmin );
				while ($rowx = $resultx->fetch()) { 
					$niveaux0=str_replace("$idDel,","",$rowx["niveaux0"]);
					if($niveaux0!=$rowx["niveaux0"]) {
						$PDO->free_requete("UPDATE " . $myTableAdmin . " SET niveaux0='$niveaux0' WHERE id=" . $rowx["id"]  );
					}
				}
				
				$deleteDone=true;
			}
		}
	}
	
	$myAdmin->menuNavigation=array();
	
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
$formList->where="lg='" . $myAdmin->LANG_DATAS . "'";
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