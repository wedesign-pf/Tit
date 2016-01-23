<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "itineraires";
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


$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "iles";
$mySelect->fields="id,titre";
$mySelect->where="actif=1 AND lg=:lg";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$tab_iles=array();
foreach($result as $row){
   $tab_iles[$row["id"]]=$row["titre"];
}
$newfield = new selectM();
$newfield->field="ile";
$newfield->multiLang=false;
$newfield->label="Ile(s)";
$newfield->items=$tab_iles;
$newfield->noneItem=true;
$newfield->defaultValue=$filtres["F__ile"]; 
$newfield->selectAll=false;
$newfield->add();


$obj_article = new article("profil");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_profils=array();
foreach($result as $row){
   $tab_profils[$row["id"]]=$row["titre"];
}
$newfield = new selectM();
$newfield->field="profil";
$newfield->multiLang=false;
$newfield->label="Profil(s)";
$newfield->items=$tab_profils;
$newfield->noneItem=true;
$newfield->defaultValue=$filtres["F__profil"]; 
$newfield->selectAll=false;
$newfield->add();
$newfield->rule("required",true);

$obj_article = new article("theme");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_themes=array();
foreach($result as $row){
   $tab_themes[$row["id"]]=$row["titre"];
}
$newfield = new selectM();
$newfield->field="theme";
$newfield->multiLang=false;
$newfield->label="Theme(s)";
$newfield->items=$tab_themes;
$newfield->noneItem=true;
$newfield->defaultValue=$filtres["F__theme"]; 
$newfield->selectAll=false;
$newfield->add();




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
$newfield->field="prix";
$newfield->multiLang=false;
$newfield->label="Prix";
$newfield->widthField=2;
$newfield->add();
$newfield->rule("digits",true);

$newfield = new input();
$newfield->field="duree";
$newfield->multiLang=false;
$newfield->label="Durée";
$newfield->widthField=4;
$newfield->add();

$newfield = new editor();
$newfield->field="resume";
$newfield->label="Résumé";
$newfield->multiLang=true;
$newfield->height=200;
$newfield->startFolder="itineraires";
$newfield->variablesAuthorized=true;
$newfield->add();

$fieldMedia = new mediaImage();
$fieldMedia->field="itineraire_image";
$fieldMedia->label=$datas_lang["image"];
$fieldMedia->startFolder="itineraires"; 
$fieldMedia->multiLangType=false; 
$fieldMedia->multiLangDestination=false; 
$fieldMedia->dimMax="1280x0"; 
$fieldMedia->dimThumbs=$thisSite->DEFAULT_DIM_VIGS;
$fieldMedia->fileRequired=false;
$fieldMedia->legendeEnabled=true;
$fieldMedia->maxElements=0;
$fieldMedia->upload=true; 
$fieldMedia->uploadDirect=true; 
$fieldMedia->insideForm=true;
$fieldMedia->add();

$fieldMedia = new mediaVideo();
$fieldMedia->field="itineraire_video";
$fieldMedia->label=$datas_lang["lienVideo"];
$fieldMedia->multiLangType=true;
$fieldMedia->insideForm=true;
$fieldMedia->fileRequired=false;
$fieldMedia->legendeEnabled=false;
$fieldMedia->add();

?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>