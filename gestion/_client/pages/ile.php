<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "iles";
$orderby="chrono ASC";
$actionsPage=array("ajouter","supprimer","move");
$actionsPageOnlySA=array("supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
$listCols[]=array("field"=>"ile_image","label"=>"<i class='icon-append fa fa-15x fa-picture-o'>","align"=>"center","width"=>"5%", "action"=>"image"); 
$listCols[]=array("field"=>"ile_fichier","label"=>"<i class='icon-append fa fa-15x fa-file-o'>","align"=>"center","width"=>"5%", "action"=>"file");
$listCols[]=array("field"=>"ile_lien","label"=>"<i class='icon-append fa fa-15x fa-link'>","align"=>"center","width"=>"5%", "action"=>"link");
$listCols[]=array("field"=>"ile_video","label"=>"<i class='icon-append fa fa-15x fa-video-camera'>","align"=>"center","width"=>"5%", "action"=>"video");
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
                
                deleteMediasbyIdParent("produit",$idDel);
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

// Filtre Type
$obj_article = new article("archipel");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_archipels=array();
foreach($result as $row){
   $tab_archipels[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="F__archipel";
$newfield->widthLabel=0;
$newfield->label="Archipel";
$newfield->allItems=true;
$newfield->items=$tab_archipels;
$newfield->value=$F__archipel;
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
if($F__archipel!="" && $F__archipel!="allItems") {  $formList->where.=" AND archipel='" . $F__archipel . "'"; }
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