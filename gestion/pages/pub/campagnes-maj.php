<?php
$myTable=$thisSite->PREFIXE_TBL_PUB . "campagnes";
$actionsPage=array("annuler","valider","appliquer");
$variablesAuthorized=false;
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php
//echoa($__POST);
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

$newfield = new input();
$newfield->field="annonceur";
$newfield->multiLang=false;
$newfield->label=$datas_lang["pubAnnonceur"];
$newfield->add();
$newfield->rule("required",true);
$newfield->rule("alphanumeric",true);
$newfield->rule("minlength",5);
$newfield->rule("maxlength",20);

$newfield = new radio();
$newfield->field="actif";
$newfield->label=$datas_lang["actif"];
$newfield->items=$datas_lang["ouiNon"];
$newfield->defaultValue="1"; 
$newfield->add();

$newfield = new periode();
$newfield->field="periode";
$newfield->label=$datas_lang["periodeAffichage"];
$newfield->changeYear=false;
$newfield->numberOfMonths=1;
$newfield->minDate=0;
$newfield->defaultValues=array(date("Ymd"),date("Ymd",strtotime("+1 years")));
$newfield->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>