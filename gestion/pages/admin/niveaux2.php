<?php
$myTable=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
$myTableAdmin=$thisSite->PREFIXE_TBL_ADM . "administrateurs";
$orderby="chrono ASC";
$actionsPage=array("ajouter","supprimer","move");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
$listCols[]=array("field"=>"privilege","label"=>"Priv.","align"=>"center","width"=>"10%");
$listCols[]=array("field"=>"copier","label"=>"Copier","align"=>"center","width"=>"7%", "action"=>"lightbox");
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-init.php");
?>
<?php
// Copie des fichiers
if($__POST['copier_fichier']=="1") {
	
	$p=strrpos($__POST['fichier_origine'],"/");
	$dossier_origine=substr($__POST['fichier_origine'],0,$p);
	$nom_origine=substr($__POST['fichier_origine'],$p+1,100);
	$handle  = @opendir($dossier_origine); 
	while ($file = @readdir($handle)) {
		if ($file != ".." AND $file != "." AND !is_dir($repertoire . $file)) { 
			$p=strpos($file,$nom_origine);
			if($p===0) {
				$newfileName=$__POST['newfile'] . substr($file,strlen($nom_origine),255);
				//echoa($dossier_origine  . "/" . $file . " : " . $__POST['dossier_destination']  . "/" . $newfileName);
				copy($dossier_origine . "/" . $file, $__POST['dossier_destination'] . "/" . $newfileName);
			}
		}
	}
}
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
				// suppression des droits
				$resultx = $PDO->free_requete("SELECT id,niveaux2,niveaux2add,niveaux2mod,niveaux2del FROM " . $myTableAdmin );
				while ($rowx = $resultx->fetch()) { 
					$niveaux2=str_replace("$idDel,","",$rowx["niveaux2"]);
					$niveaux2add=str_replace("$idDel,","",$rowx["niveaux2add"]);
					$niveaux2mod=str_replace("$idDel,","",$rowx["niveaux2mod"]);
					$niveaux2del=str_replace("$idDel,","",$rowx["niveaux2del"]);
					if($niveaux2!=$rowx["niveaux2"] || $niveaux2add!=$rowx["niveaux2add"] || $niveaux2mod!=$rowx["niveaux2mod"] || $niveaux2del!=$rowx["niveaux2del"]) {
						$PDO->free_requete("UPDATE " . $myTableAdmin . " SET niveaux2='$niveaux2', niveaux2add='$niveaux2add', niveaux2mod='$niveaux2mod', niveaux2del='$niveaux2del' WHERE id=" . $rowx["id"]  );
					}
				}
			}
		}
	}
	
	$myAdmin->menuNavigation=array();
	
	$myAdmin->delete_notification($deleteDone,$result);
	$myAdmin->addLogs($myAdmin->pageCurrent,"DEL",$idDel,$result);
		
} // Fin suppression 
// DUPLICATION /////////////////////////////////////// ????

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

// Filtre Niveau 1
if($F__niveau0!="") {
	$list=array();
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
	$mySelect->fields="id,titre";
	$mySelect->orderby="chrono ASC";
	$mySelect->where="lg='" . $myAdmin->LANG_DATAS . "'";
	if($F__niveau0) { $mySelect->where.=" AND id0='" . $F__niveau0 . "'"; }
	$result=$mySelect->query();
	foreach($result as $row){ 
		$list[$row["id"]]=$row["titre"];
	}
	
	$newfield = new select();
	$newfield->field="F__niveau1";
	$newfield->widthLabel=0;
	$newfield->label=$datas_lang["niveau1"];
	$newfield->allItems="Sans";
	$newfield->items=$list;
	$newfield->value=$F__niveau1;
	$newfield->defaultValue="0";
	$newfield->javascript="onChange='submitFiltres()'";
	$newfield->add();
}


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
// Filtres 
$formList->where.="AND id0='" . $F__niveau0 . "'";
$formList->where.="AND id1='" . $F__niveau1 . "'";
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