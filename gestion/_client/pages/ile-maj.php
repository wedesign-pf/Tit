<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "iles";
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
//echoa($__POST);
	$idSet =$formMaj->set_datas();
	
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
if($majInsert==1) {
	$newfield = new hidden();
	$newfield->field="datetime_add";
	$newfield->value=date('Y-m-d H:i:s');
    $newfield->multiLang=false;
	$newfield->add();
    
    $newfield = new hidden();
	$newfield->field="login_add";
	$newfield->value=$myAdmin->LOGIN;
    $newfield->multiLang=false;
	$newfield->add();
    
}
$newfield = new hidden();
$newfield->field="datetime_mod";
$newfield->value=date('Y-m-d H:i:s');
$newfield->multiLang=false;
$newfield->add();

$newfield = new hidden();
$newfield->field="login_mod";
$newfield->value=$myAdmin->LOGIN;
$newfield->multiLang=false;
$newfield->add();
    

$newfield = new radio();
$newfield->field="actif";
$newfield->defaultValue=1;
$newfield->multiLang=false;
$newfield->label=$datas_lang["actif"];
$newfield->items=$datas_lang["listeActif"];
$newfield->add();

$obj_article = new article("archipel");
$result=$obj_article->query();
$tab_archipel=array();
foreach($result as $row){
   $tab_archipel[$row["id"]]=$row["titre"];
}

$newfield = new radio();
$newfield->field="archipel";
$newfield->multiLang=false;
$newfield->label="Archipel";
$newfield->items=$tab_archipel;
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=true;
$newfield->label=$datas_lang["titre"];
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="sous_titre";
$newfield->multiLang=true;
$newfield->label=$datas_lang["sous_titre"];
$newfield->add();

$newfield = new input();
$newfield->field="lat_lgn";
$newfield->multiLang=false;
$newfield->label="Local. Google Map";
$newfield->placeholder="-17.640112, -149.427854";
$newfield->add();

$newfield = new editor();
$newfield->field="resume";
$newfield->label="Résumé";
$newfield->multiLang=true;
$newfield->height=200;
$newfield->startFolder="iles";
$newfield->variablesAuthorized=true;
$newfield->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>