<?php
$myTable="__exemple_list";
$orderby="chrono ASC";
$actionsPage=array("ajouter","supprimer","move");
$maxElements=100; // Nombre d'éléments maximum
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"50px","orderOk"=>0); //orderOk=0
$listCols[]=array("field"=>"test","label"=>"Test","align"=>"center","width"=>"5%","update"=>1); //update=1
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0); //update=0
$listCols[]=array("field"=>"niv1","label"=>"notGoMaj","align"=>"left","width"=>"","class"=>"notGoMaj"); // class=notGoMaj
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
$listCols[]=array("field"=>"copier","label"=>"lightbox","align"=>"center","width"=>"7%", "action"=>"lightbox"); // lightbox
$listCols[]=array("field"=>"lg","label"=>"actifAss","assValues"=>$thisSite->LIST_LANG,"align"=>"left","width"=>""); // assValues
//$listCols[]=array("field"=>"$myTable","label"=>"action=page","align"=>"center","width"=>"10%", "action"=>"page"); // action=page
$listCols[]=array("field"=>"testimage","label"=>"<i class='icon-append fa fa-15x fa-picture-o'>","align"=>"center","width"=>"5%", "action"=>"image"); // action=image
$listCols[]=array("field"=>"testfichier","label"=>"<i class='icon-append fa fa-15x fa-file-o'>","align"=>"center","width"=>"5%", "action"=>"file");
$listCols[]=array("field"=>"testlink","label"=>"<i class='icon-append fa fa-15x fa-link'>","align"=>"center","width"=>"5%", "action"=>"link");
$listCols[]=array("field"=>"testvideo","label"=>"<i class='icon-append fa fa-15x fa-video-camera'>","align"=>"center","width"=>"5%", "action"=>"video");
$listCols[]=array("field"=>"testin","label"=>"action=IN","align"=>"center","width"=>"10%", "action"=>"inList"); //action=inList
// Explications sur les propriétés de $listCols:
// 
// la propriété "width" peut être soit en px soit en %
// la propriété "update" doit être un chiffre pour indiquer le nombre d'occurence autorisée, mettre 0 pour illimité
// la proprité "class" permet d'indiquer une classe CSS à ajouter à la colonne (pour personnaliser l'affichage) ou mettre "notGoMaj" pour ne pas autoriser le click vers la page de mise à jour (pratique si il y a une action spécifique au click dans cette colonne).
// la propriété "orderOk" permet d'autoriser (1) ou non (0) le tri sur cette colonne (en cliquant sur le nom de la colonne).
// la propriété "assValues" permet d'attribuer une liste de valeurs à une colonne (par exemple pour afficher un titre au lieu d'un identifiant)
// la propriété "action" peut contenir:
// - image, file, link, video : affiche automatiquement un lien vers le type de média correspondant
// - inList :  permet de valider la liste avec la valeur du champ dans $__POST["actionInList"]
// - page : // NE PAS UTILISER
// - lightbox : permet d'afficher une lightbox, voir l'exemple script JS à ajouter dans exempleList.tpl 



// Boutons supplémentaires à coté du bouton Ajouter
$boutons[]=array("label"=>"Export","action"=>DOS_CLIENT_ADMIN ."remoteTest.php","assAction"=>"ajouter");

if($__POST["actionInList"]=="testin") {
	echoa("eeeeeeeeeeeeee");
}
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-init.php");
?>
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
				deleteMediasbyIdParent("xxxx",$idDel);

				$deleteDone=true;
			}
		}
	}
	$myAdmin->delete_notification($deleteDone,$result);
		
} // Fin suppression 
?>
<?php
// FILTRES //////////////////////////////////////////
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");
// Controle après préparationd des filtres
if($F__niveau0!=$filtresOrigine["F__niveau0"]) { $F__niveau1=""; }

// Filtre Niveau 0
$list=array();
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
$mySelect->fields="id,titre";
$result=$mySelect->query();
foreach($result as $row){ 
	$list[$row["id"]]=$row["titre"];
}

$newfield = new select();
$newfield->field="F__niveau0";
$newfield->widthLabel=0;
$newfield->label="Niveau 0";
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
	if($F__niveau0) { $mySelect->where="id0='" . $F__niveau0 . "'"; }
	$result=$mySelect->query();
	foreach($result as $row){ 
		$list[$row["id"]]=$row["titre"];
	}
	
	$newfield = new select();
	$newfield->field="F__niveau1";
	$newfield->widthLabel=0;
	$newfield->label="Niveau 1";
	$newfield->noneItem=true;
	$newfield->items=$list;
	$newfield->value=$F__niveau1;
	$newfield->javascript="onChange='submitFiltres()'";
	$newfield->add();
}

$newfield = new date();
$newfield->field="F__date";
$newfield->label="Date";
$newfield->widthLabel=0;
$newfield->changeYear=true;
$newfield->numberOfMonths=1;
$newfield->dateFormat="dd.mm.yy";
$newfield->value=$F__date;
$newfield->add();

if($F__niveau1=="") {
//	RemoveActionPage("ajouter");
//	$F__niveau1="-1*";
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
$formList->pagination=true;
// Filtres
if($F__niveau1!="") { $formList->where.=" AND id1='" . $F__niveau1 . "'"; }
//
$formList->clause_where();
$count_datas = $formList->get_datas();

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	//$listChronos=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();

		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");;
		//////////////////////////////////////
		// chargement d'autres données
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
		$mySelect->fields="titre";
		$mySelect->where="id=:id AND lg=:lg";
		$mySelect->whereValue["lg"]=array($myAdmin->LANG_DATAS,PDO::PARAM_STR);
		$mySelect->whereValue["id"]=array($datas["id1"],PDO::PARAM_INT);
		$result=$mySelect->query();
		$row = current($result); 
		$valeurs["niv1"]=stripslashes($row["titre"]);
		
		// fin chargement données manuellement
		//////////////////////////////////////
		
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
//echoa($formList->datasList);
//echoa($listRow);
//echoa($listCols);
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>