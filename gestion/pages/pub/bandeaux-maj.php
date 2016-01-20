<?php
$myTable=$thisSite->PREFIXE_TBL_PUB . "bandeaux";
$myTableCampagnes=$thisSite->PREFIXE_TBL_PUB . "campagnes";
$myTableEmplacements=$thisSite->PREFIXE_TBL_PUB . "emplacements";
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
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTableCampagnes;
$mySelect->fields="id,titre";
$mySelect->where="actif=1";
$mySelect->orderby="titre ASC";
$result=$mySelect->query();
$listCampagnes=array();
foreach($result as $row){ 
	$listCampagnes[$row["id"]]=$row["titre"];
}
$datas_page["listCampagnes"]=$listCampagnes;

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTableEmplacements;
$mySelect->fields="id,titre";
$mySelect->orderby="titre ASC";
$result=$mySelect->query();
$listEmplacements=array();
foreach($result as $row){ 
	$listEmplacements[$row["id"]]=$row["titre"];
}
$datas_page["listEmplacements"]=$listEmplacements;

?>
<?php
///////////////////////////////////
// champs de saisie
///////////////////////////////////
$newfield = new radio();
$newfield->field="actif";
$newfield->label=$datas_lang["actif"];
$newfield->items=$datas_lang["ouiNon"];
$newfield->defaultValue="1"; 
$newfield->add();

$newfield = new select();
$newfield->field="id_emplacement";
$newfield->label=$datas_lang["pubEmplacement"];
$newfield->items=$listEmplacements;
//$newfield->noneItem=true;
$newfield->defaultValue=$filtres["F__id_emplacement"]; 
$newfield->add();
$newfield->rule("required",true);

$newfield = new select();
$newfield->field="id_campagne";
$newfield->label=$datas_lang["pubCampagne"];
$newfield->items=$listCampagnes;
//$newfield->noneItem=true;
$newfield->defaultValue=$filtres["F__id_campagne"];
$newfield->add();

$newfield = new file();
$newfield->field="image_bandeau";
$newfield->multiLang=true;
$newfield->startFolder="pub";
$newfield->upload=true;
$newfield->disabled=false;
$newfield->browse=true;
$newfield->extensionsAuthorized="images";
$newfield->variablesAuthorized=true; 
$newfield->addClass="pub";
$newfield->add();
$newfield->rule("required",true);
$newfield = new textarea();
$newfield->field="script_bandeau";
$newfield->multiLang=true;
$newfield->rows=10;
$newfield->addClass="pub";
$newfield->add();


$newfield = new input();
$newfield->field="lien_destination";
$newfield->multiLang=true;
$newfield->label=$datas_lang["lien"];
$newfield->placeholder="http://, https:// ...";
$result=$newfield->add();
$newfield->rule("complete_url",true);

$newfield = new radio();
$newfield->field="cible_destination";
$newfield->multiLang=false;
$newfield->defaultValue="_blank";
$newfield->label=$datas_lang["cible"];
$newfield->items=$datas_lang["listeCible"];
$result=$newfield->add();


$newfield = new radio();
$newfield->field="type_affichage";
$newfield->label=$datas_lang["pubTypeAffichage"];
$newfield->items=$datas_lang["pubTypes"];
$newfield->defaultValue="N"; 
$newfield->add();

$newfield = new input();
$newfield->field="couleur_fond";
$newfield->multiLang=false;
$newfield->widthField=3;
$newfield->label=$datas_lang["pubCouleurFond"];
$newfield->placeholder=$datas_lang["pubCouleurFond_placeholder"];
$newfield->tooltip=$datas_lang["pubCouleurFond_tooltip"];
$result=$newfield->add();
$newfield->rule("alphanumeric",true);
$newfield->rule("minlength",6); 
$newfield->rule("maxlength",6); 
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>