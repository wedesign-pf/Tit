<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "textes";
$actionsPage=array("annuler","valider","appliquer");
$variablesAuthorized=true;
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
$formMaj->multiLang=true;
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
$newfield->tooltip="Ce titre n'est utilisé que dans l'administration, jamais dans le site public";

$newfield->add();
$newfield->rule("required",true);

$newfield = new editor();
$newfield->field="texte";
$newfield->multiLang=true;
$newfield->label=$datas_lang["texte"];
$newfield->startFolder="textes";
$newfield->extensionsAuthorized="";
$newfield->height=400;
$newfield->toolbar="Default";
$newfield->add();
$newfield->rule("required",true);

?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>