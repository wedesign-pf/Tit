<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "emails";
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
$newfield->field="code";
$newfield->multiLang=false;
$newfield->counter="countType:'characters', maxCount:20, strictMax:true";
$newfield->label=$datas_lang["code"];
$newfield->add();
$newfield->rule("required",true);
$newfield->rule("alphanumeric",true);
$newfield->rule("maxlength",20);
$newfield->rule("remote",array("script"=>DOS_AJAX_ADMIN . "ajax_checkNotExiste.php","table"=>$myTable,"valOrigin"=>"FIELD:code","params"=>""), $datas_lang["existedeja"]);

$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=false;
$newfield->label=$datas_lang["titre"];
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="email";
$newfield->multiLang=false;
$newfield->label=$datas_lang["email"];
$newfield->add();
$newfield->rule("email",true);


?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>