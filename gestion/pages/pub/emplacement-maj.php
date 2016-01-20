<?php
$myTable=$thisSite->PREFIXE_TBL_PUB . "emplacements";
$actionsPage=array("annuler","valider","appliquer");
$variablesAuthorized=false;
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php
////////////////////////////////////////////////////////////////
// GESTION DONNEES
$formMaj = new formMaj();
$formMaj->tables=$myTable;
$formMaj->fields="*";
$formMaj->where="id=:id";
$formMaj->whereValue["id"]=array($idCurrent,PDO::PARAM_INT);
$formMaj->multiLang=false;
$formMaj->clause_where();

// Validation du formulaire
if($__POST["actionForm"]!="" &&  $__POST["actionForm"]!="Annuler") {
	$formMaj->set_datas();

	actionFormMaj($__POST["actionForm"]);
}

// chargement des données
$formMaj->get_datas();
?>
<?php
///////////////////////////////
// PREPARATION DES DONNEES

?>
<?php
///////////////////////////////////
// champs de saisie
///////////////////////////////////


$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=false;
$newfield->label=$datas_lang["titre"];
$newfield->add();
$newfield->rule("required",true);


$lDims=array();
$repertoire=DOS_BASE_ADMIN . "pages/pub/_standards";
$handle  = opendir($repertoire); // chemintotal
while ($file = readdir($handle)) {
	if($file!="." && $file!=".." && $file!="Thumbs.db") {
	$pos = strrpos($file,".");
	$nomfic = substr($file,0,$pos);
	$l_infos_image = @getimagesize("$repertoire/$file");
		$lDims[$l_infos_image[0] . "x" . $l_infos_image[1]]=$nomfic;
	}
}

$newfield = new select();
$newfield->field="dimsReference";
$newfield->label=$datas_lang["dimensions"];
$newfield->items=$lDims;
$newfield->noneItem=true; 
$newfield->widthField=2;
$newfield->javascript="onChange='setDims(this)'";
$newfield->add();

$newfield = new input();
$newfield->field="largeur";
$newfield->multiLang=false;
$newfield->widthField=1;
$newfield->label=$datas_lang["pubLargeur"];
$newfield->add();
$newfield->rule("digits",true);

$newfield = new input();
$newfield->field="hauteur";
$newfield->multiLang=false;
$newfield->widthLabel=0;
$newfield->widthField=1;
$newfield->label=$datas_lang["pubHauteur"];
$newfield->add();
$newfield->rule("digits",true);
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>