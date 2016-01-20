<?php
$myTable=$thisSite->PREFIXE_TBL_PUB . "campagnes";
$myTableBandeaux=$thisSite->PREFIXE_TBL_PUB . "bandeaux";
$orderby="id ASC";
$actionsPage=array("ajouter","supprimer");
$actionsPageOnlySA=array("ajouter","supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"annonceur","label"=>"Annonceur","align"=>"left","width"=>"");
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
$listCols[]=array("field"=>"statut","label"=>"Statut","align"=>"center","width"=>"");

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
				$myDelete->table=$myTableBandeaux;
				$myDelete->where="id_campagne=$idDel";
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
// FILTRES /////////////////////////////////////// ????
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");
$newfield = new input();
$newfield->field="F__annonceur";
$newfield->multiLang=false;
$newfield->label=$datas_lang["pubAnnonceur"];
$newfield->widthField=4;
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
// Filtres /////////////////////////////////////// ????
if($F__annonceur!="") { $formList->where.="annonceur LIKE '" . $F__annonceur . "%'"; }
//
$formList->orderby=$orderby;
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
		$today=date("Ymd");
		$date_jour=date_create(date("Y-m-d"));
		$date_fin=date_create(format_date($datas["periode_end"],"-"));
		$diff=date_diff($date_fin,$date_jour);
		$jour_restant=$diff->days;
		if($diff->invert==0) { $jour_restant=$jour_restant*-1;}
		
		if($today>=$datas["periode_beg"]){ $valeurs["statut"]="en cours"; }
		if($datas["periode_end"]!="" && $jour_restant>=0){ $valeurs["statut"]="reste $jour_restant jours"; }
		if($datas["periode_end"]!="" && $jour_restant<0){ $valeurs["statut"]="terminé"; }
		if($datas["periode_end"]==""){ $valeurs["statut"]="no limit"; }
		// fin chargement données manuellement
		
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>