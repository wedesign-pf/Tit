<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "glossaire";
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
$newfield->field="terme";
$newfield->multiLang=true;
$newfield->label="Terme";
$newfield->add();
$newfield->rule("required",true);
$newfield->rule("remote",array("script"=>DOS_AJAX_ADMIN . "ajax_checkNotExiste.php","table"=>$myTable,"valOrigin"=>"FIELD:terme","params"=>""), $datas_lang["existedeja"]);

$newfield = new editor();
$newfield->field="explications";
$newfield->label="Explications";
$newfield->multiLang=true;
$newfield->height=400;
$newfield->toolbar="Default";
$newfield->startFolder="glossaire";
$newfield->extensionsAuthorized="images";
$newfield->variablesAuthorized=true; 
$newfield->upload=true;
$newfield->add();


?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>