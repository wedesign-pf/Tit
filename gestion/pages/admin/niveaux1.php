<?php
$myTable=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
$myTable1=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
$myTableAdmin=$thisSite->PREFIXE_TBL_ADM . "administrateurs";
$orderby="chrono ASC";
$actionsPage=array("ajouter","supprimer","move");
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
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable;
				$myDelete->where="id=$idDel";
				$result=$myDelete->execute();
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable1;
				$myDelete->where="id1=$idDel";
				$result=$myDelete->execute();
				$deleteDone=true;
				
				// suppression des droits
				$resultx = $PDO->free_requete("SELECT id,niveaux1 FROM " . $myTableAdmin );
				while ($rowx = $resultx->fetch()) { 
					$niveaux1=str_replace("$idDel,","",$rowx["niveaux1"]);
					if($niveaux1!=$rowx["niveaux1"]) {
						$PDO->free_requete("UPDATE " . $myTableAdmin . " SET niveaux1='$niveaux1' WHERE id=" . $rowx["id"]  );
					}
				}
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
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");
// Controle après préparationd des filtres
if($F__niveau0!=$filtresOrigine["F__niveau0"]) { $F__niveau1=""; }

// Filtre Niveau 0
$list=array();
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
$mySelect->fields="id,titre";
$mySelect->orderby="chrono ASC";
$mySelect->where="lg='" . $myAdmin->LANG_DATAS . "'";
$mySelect->orderby="chrono ASC";
$result=$mySelect->query();
foreach($result as $row){ 
	$list[$row["id"]]=$row["titre"];
}

$newfield = new select();
$newfield->field="F__niveau0";
$newfield->widthLabel=0;
$newfield->label=$datas_lang["niveau0"];
$newfield->noneItem=true;
$newfield->items=$list;
$newfield->value=$F__niveau0;
$newfield->javascript="onChange='submitFiltres()'";
$newfield->add();

if($F__niveau0=="") {
	RemoveActionPage("ajouter");
}
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
if($F__niveau0!="") { $formList->where.=" AND id0='" . $F__niveau0 . "'"; }
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