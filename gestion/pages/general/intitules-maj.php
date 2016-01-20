<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "intitules";
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
$newfield->field="code";
$newfield->multiLang=false;
$newfield->counter="countType:'characters', maxCount:50, strictMax:true";
$newfield->label=$datas_lang["code"];
$newfield->add();
$newfield->rule("required",true);
$newfield->rule("alphanumeric",true);
$newfield->rule("maxlength",50);
$newfield->rule("remote",array("script"=>DOS_AJAX_ADMIN . "ajax_checkNotExiste.php","table"=>$myTable,"valOrigin"=>"FIELD:code","params"=>""), $datas_lang["existedeja"]);

$newfield = new textarea();
$newfield->field="titre";
$newfield->multiLang=true;
$newfield->label="Intitulé";
$newfield->add();
$newfield->rule("required",true);

$newfield = new textarea();
$newfield->field="explications";
$newfield->multiLang=false;
$newfield->label="Explications";
$newfield->tooltip="Explications sur l'utilisation de l'intitulé";
$newfield->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>