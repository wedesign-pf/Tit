<?php
$myTable=$thisSite->PREFIXE_TBL_PUB . "bandeaux";
$myTableCampagnes=$thisSite->PREFIXE_TBL_PUB . "campagnes";
$myTableEmplacements=$thisSite->PREFIXE_TBL_PUB . "emplacements";
$orderby="id ASC";
$actionsPage=array("ajouter","supprimer");
$actionsPageOnlySA=array("ajouter","supprimer");
$listCols=array();

$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
if($__POST["F__id_campagne"]=="" || $__POST["F__id_campagne"]=="allItems") { 
	$listCols[]=array("field"=>"campagne","label"=>"Campagne","align"=>"left","width"=>"");
}
if($__POST["F__id_emplacement"]=="" || $__POST["F__id_emplacement"]=="allItems") { 
	$listCols[]=array("field"=>"emplacement","label"=>"Emplacement","align"=>"left","width"=>"");
}

$listCols[]=array("field"=>"image_bandeau","label"=>"Image","align"=>"left","width"=>"");

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
// FILTRES /////////////////////////////////////// ????
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTableCampagnes;
$mySelect->fields="id,titre";
$mySelect->where="actif=1";
$mySelect->orderby="titre ASC";
$result=$mySelect->query();
$listCampagnes=array();
foreach($result as $row){ 
	$listCampagnes[$row["id"]]=$row["titre"];
}
$datas_page["listCampagnes"]=$listCampagnes;

$newfield = new select();
$newfield->field="F__id_campagne";
$newfield->label=$datas_lang["pubCampagne"];
$newfield->widthField=4;
$newfield->javascript="onChange='submitFiltres()'";
$newfield->items=$listCampagnes;
$newfield->allItems=true;
$newfield->value=${$newfield->field};
$newfield->add();

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTableEmplacements;
$mySelect->fields="id,titre";
$mySelect->orderby="titre ASC";
$result=$mySelect->query();
$listEmplacements=array();
foreach($result as $row){ 
	$listEmplacements[$row["id"]]=$row["titre"];
}
$datas_page["listEmplacements"]=$listEmplacements;

$newfield = new select();
$newfield->field="F__id_emplacement";
$newfield->label=$datas_lang["pubEmplacement"];
$newfield->widthField=4;
$newfield->javascript="onChange='submitFiltres()'";
$newfield->items=$listEmplacements;
$newfield->allItems=true;
$newfield->value=${$newfield->field};
$newfield->add();


// FIN FILTRES //////////////////////////////////////////
?>
<?php
// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->fields="*";
// Filtres /////////////////////////////////////// ????
$formList->where="lg='" . $myAdmin->LANG_DATAS . "'";
if($F__id_campagne!="" && $F__id_campagne!="allItems") { $formList->where.=" AND id_campagne='" . $F__id_campagne . "'"; }
if($F__id_emplacement!="" && $F__id_emplacement!="allItems") { $formList->where.=" AND id_emplacement='" . $F__id_emplacement . "'"; }
//
$formList->orderby=$orderby;
// Filtres /////////////////////////////////////// ????
//
$formList->clause_where();
$count_datas = $formList->get_datas(0);

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();

		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");

		// chargement d'autres données /////////////////////////////////////// ????
		$resultx = $PDO->free_requete("SELECT titre FROM " . $myTableCampagnes . " WHERE id=".$datas["id_campagne"] );
		$rowx = $resultx->fetch();
		$valeurs["campagne"]=$rowx["titre"];
		$resultx = $PDO->free_requete("SELECT titre FROM " . $myTableEmplacements . " WHERE id=".$datas["id_emplacement"] );
		$rowx = $resultx->fetch();
		$valeurs["emplacement"]=$rowx["titre"];
		// fin chargement données manuellement
		
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>