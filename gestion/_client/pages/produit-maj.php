<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "produits";
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


$obj_article = new article("type_produit");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_type_produit=array();
foreach($result as $row){
   $tab_type_produit[$row["id"]]=$row["titre"];
}
$newfield = new radio();
$newfield->field="type";
$newfield->multiLang=false;
$newfield->label="Type";
$newfield->items=$tab_type_produit;
$newfield->defaultValue=$filtres["F__type"]; 
$newfield->add();
$newfield->rule("required",true);

$obj_article = new article("cat_produit");
$obj_article->fields="id,titre";

if($formMaj->datasForm[$myAdmin->LANG_DATAS]["type"]=="" && $filtres["F__type"]!="" && $filtres["F__type"]!="allItems" ) {
    $obj_article->where="filtre1='" . $filtres["F__type"] . "'";  

} else {
    $obj_article->where="filtre1='" . $formMaj->datasForm[$myAdmin->LANG_DATAS]["type"] . "'";

}
$result=$obj_article->query();
$tab_cat_produit=array();
foreach($result as $row){
   $tab_cat_produit[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="cat";
$newfield->multiLang=false;
$newfield->label="Catégorie";
$newfield->noneItem=true;
$newfield->items=$tab_cat_produit;
$newfield->defaultValue=$filtres["F__cat"]; 
$newfield->add();
$newfield->rule("required",true);


$obj_article = new article("souscat_produit");
$obj_article->fields="id,titre";
if($formMaj->datasForm[$myAdmin->LANG_DATAS]["cat"]=="" && $filtres["F__cat"]!="" && $filtres["F__cat"]!="allItems" ) {
  $obj_article->where="filtre2='" . $filtres["F__cat"] . "'";  
} else {
    $obj_article->where="filtre2='" . $formMaj->datasForm[$myAdmin->LANG_DATAS]["cat"] . "'";
}
$result=$obj_article->query();
$tab_souscat_produit=array();
foreach($result as $row){
   $tab_souscat_produit[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="souscat";
$newfield->multiLang=false;
$newfield->label="Sous Catégorie";
$newfield->items=$tab_souscat_produit;
$newfield->noneItem=true;
$newfield->defaultValue=$filtres["F__souscat"]; 
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
$newfield->add();


$newfield = new input();
$newfield->field="code";
$newfield->multiLang=false;
$newfield->label="Code";
$newfield->widthField=2;
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

$newfield = new input();
$newfield->field="duree";
$newfield->multiLang=false;
$newfield->label="Durée";
$newfield->add();

$newfield = new editor();
$newfield->field="resume";
$newfield->label="Résumé";
$newfield->multiLang=true;
$newfield->height=200;
$newfield->startFolder="produits";
$newfield->variablesAuthorized=true;
$newfield->add();

$fieldMedia = new mediaImage();
$fieldMedia->field="produit_image";
$fieldMedia->label=$datas_lang["image"];
$fieldMedia->startFolder="produits"; 
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

$fieldMedia = new mediaFile();
$fieldMedia->field="produit_fichier";
$fieldMedia->label=$datas_lang["fichier"];
$fieldMedia->fileRequired=false;
$fieldMedia->insideForm=true;
$fieldMedia->startFolder="produits/files"; 
$fieldMedia->multiLangType=true; 
$fieldMedia->extensionsAuthorized=""; 
$fieldMedia->legendeEnabled=true;
$fieldMedia->upload=true;
$fieldMedia->add();

$fieldMedia = new mediaLink();
$fieldMedia->field="produit_lien";
$fieldMedia->label=$datas_lang["lien"];
$fieldMedia->fileRequired=false;
$fieldMedia->insideForm=true;
$fieldMedia->multiLangType=true;
$fieldMedia->legendeEnabled=true;
$fieldMedia->add();
//
//$fieldMedia = new mediaVideo();
//$fieldMedia->field="produit_video";
//$fieldMedia->label=$datas_lang["lienVideo"];
//$fieldMedia->multiLangType=true;
//$fieldMedia->insideForm=true;
//$fieldMedia->fileRequired=false;
//$fieldMedia->legendeEnabled=false;
//$fieldMedia->add();

$newfield = new input();
$newfield->field="contrat";
$newfield->multiLang=false;
$newfield->label="Contrat";
$newfield->add();

$newfield = new input();
$newfield->field="contact";
$newfield->multiLang=false;
$newfield->label="Contact";
$newfield->add();

$newfield = new input();
$newfield->field="email";
$newfield->multiLang=false;
$newfield->label="Email";
$newfield->add();

$newfield = new input();
$newfield->field="telephone";
$newfield->multiLang=false;
$newfield->label="Téléphone";
$newfield->add();

$newfield = new input();
$newfield->field="prestataire";
$newfield->multiLang=false;
$newfield->label="Prestataire";
$newfield->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>