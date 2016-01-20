<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "pages";
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

    foreach($myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extLg){
	    if(isset($__POST["page_titre".$extLg]) && $__POST["page_titre".$extLg]=="") { $__POST["page_titre".$extLg]=$__POST["titre".$extLg]; }
    }
	if($__POST["super_admin_only"]=="1") { 
		$formMaj->nextIdMin=0;
		$formMaj->nextIdMax=10;
	} else {
		$formMaj->nextIdMin=10;
		$formMaj->nextIdMax=100;
	}

	$idSet =$formMaj->set_datas();
	
	// Ajout à l'arboresence hors menu
	if($majInsert==1 && $__POST["show_in_arbo"]=="1") { 
		$classPage = new classPage(); 
		$classPage->idPage=$idSet;
        if($__POST["add_menu"]!="0") { $classPage->code_menu= $__POST["add_menu"]; }
		$classPage->addArbo();
	}
	
	if($__POST["article_tableId"]!="") {

		list($article_table,$article_id)=explode(".", $__POST["article_tableId"]);
		if($article_table!="" && $article_id>0) {
			foreach($myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extLg){
				$myUpdateA = new myUpdate(__FILE__);
				$myUpdateA->table=$article_table;
				$myUpdateA->field["titre"]=$__POST["page_titre".$extLg];
				$myUpdateA->field["actif"]=$__POST["actif"];
				$myUpdateA->where="id=:id AND lg=:lg";
				$myUpdateA->whereValue["id"]=array($article_id,PDO::PARAM_INT);
				$myUpdateA->whereValue["lg"]=array($clg,PDO::PARAM_STR);				
				$resultA=$myUpdateA->execute();
			}
		}
	}
	
	$thisSite->reInit=1; // permet la réactualisation du site public pour que les modifications soient prisent en compte
	
	actionFormMaj($__POST["actionForm"]);
}

// chargement des données
$formMaj->get_datas();
?>
<?php
///////////////////////////////
// PREPARATION DES DONNEES


$data_robots=array();
$data_robots["index,follow"]="index,follow";
$data_robots["index,nofollow"]="index,nofollow";
$data_robots["noindex,nofollow"]="noindex,nofollow";
$data_robots["noindex,follow"]="noindex,follow";

$data_FreqSM=array();
$data_FreqSM["always"]="always";
$data_FreqSM["hourly"]="hourly";
$data_FreqSM["daily"]="daily";
$data_FreqSM["weekly"]="weekly";
$data_FreqSM["monthly"]="monthly";
$data_FreqSM["yearly"]="yearly";
$data_FreqSM["never"]="never";
?>
<?php
///////////////////////////////////
// champs de saisie
///////////////////////////////////
$newfield = new hidden();
$newfield->field="article_tableId";
$newfield->multiLang=false;
$newfield->add();

$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=true;
$newfield->label=$datas_lang["pageTitreMenu"];
$newfield->variablesAuthorized=true;
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="explications";
$newfield->multiLang=true;
$newfield->label="Explications";
$newfield->variablesAuthorized=true;
$newfield->add();

$newfield = new input();
$newfield->field="couleur";
$newfield->multiLang=false;
$newfield->label="Couleur associée";
$newfield->placeholder="#000000 ou rgba(0,0,0,1)";
$newfield->widthField=5;
$newfield->variablesAuthorized=true;
$newfield->add();
$newfield->rule("maxlength",20);

$newfield = new input();
$newfield->field="page_titre";
$newfield->multiLang=true;
$newfield->label=$datas_lang["pageTitrePage"];
$newfield->variablesAuthorized=true;
$newfield->add();
//$newfield->rule("required",true);

$newfield = new input();
$newfield->field="page_url";
$newfield->multiLang=true;
$newfield->label=$datas_lang["pageUrl"];
$newfield->widthField=5;
$newfield->add();
//if ($myAdmin->PRIVILEGE<9) { $newfield->rule("required",true); }
$newfield->rule("urlRewriting",true);
$newfield->rule("maxlength",100);
$newfield->rule("remote",array("script"=>DOS_AJAX_ADMIN . "ajax_checkNotExiste.php","table"=>$myTable,"valOrigin"=>"FIELD:page_url","params"=>""), $datas_lang["existedeja"]);

	$newfield = new select();
	$newfield->field="page_type";
	$newfield->multiLang=false;
	$newfield->defaultValue="_self";
	$newfield->label=$datas_lang["type"];
	$newfield->items=$thisSite->TYPES_PAGE;
	$newfield->defaultValue="page";
	$newfield->javascript="onChange='hideByType(this)'";
	$newfield->add();

	$newfield = new input();
	$newfield->field="page_php";
	$newfield->multiLang=false;
	$newfield->label=$datas_lang["pagePhp"];
	$newfield->widthField=3;
	if ($myAdmin->PRIVILEGE<9) { $newfield->defaultValue="pages.php"; }
	$newfield->add();
	$newfield->rule("maxlength",50);
	$newfield->rule("endsWith","'.php'");
	
	$newfield = new input();
	$newfield->field="page_tpl";
	$newfield->multiLang=false;
	$newfield->label=$datas_lang["pageTpl"];
	$newfield->widthField=3;
	if ($myAdmin->PRIVILEGE<9) { $newfield->defaultValue="pages.tpl"; }
	$newfield->add();
	$newfield->rule("maxlength",50);
	$newfield->rule("endsWith","'.tpl'");

	$newfield = new radio();
	$newfield->field="page_parent";
	$newfield->defaultValue=0;
	$newfield->multiLang=false;
	$newfield->label=$datas_lang["pageParent"];
	$newfield->items=$datas_lang["ouiNon"];
	$newfield->tooltip=$datas_lang["tooltip_pageParent"];
	$newfield->add();
	
	$newfield = new radio();
	$newfield->field="show_sousmenu";
	$newfield->defaultValue=0;
	$newfield->multiLang=false;
	$newfield->label=$datas_lang["show_sousmenu"];
	$newfield->items=$datas_lang["ouiNon"];
	$newfield->tooltip=$datas_lang["tooltip_show_sousmenu"];
	$newfield->add();
	
	$newfield = new radio();
	$newfield->field="show_in_arbo";
	$newfield->defaultValue=1;
	$newfield->multiLang=false;
	$newfield->label=$datas_lang["show_in_arbo"];
	$newfield->items=$datas_lang["ouiNon"];
	$newfield->tooltip=$datas_lang["tooltip_show_in_arbo"];
    $newfield->javascript="onChange='change_in_arbo(this)'";
	$newfield->add();

$newfield = new input();
$newfield->field="page_tag_title";
$newfield->multiLang=true;
$newfield->label="Tag Title";
$newfield->counter="countType:'characters', maxCount:70, strictMax:false";
$newfield->variablesAuthorized=true;
$newfield->add();

$newfield = new input();
$newfield->field="page_tag_keywords";
$newfield->multiLang=true;
$newfield->label="Tag Keyword";
$newfield->tooltip=$datas_lang["tooltip_pageTagKW"];
$newfield->counter="countType:'characters', maxCount:160, strictMax:false";
$newfield->variablesAuthorized=true;
$newfield->add();

$newfield = new textarea();
$newfield->field="page_tag_description";
$newfield->multiLang=true;
$newfield->rows=10;
$newfield->label="Tag Description";
$newfield->counter="countType:'characters', maxCount:160, strictMax:false";
$newfield->variablesAuthorized=true;
$newfield->add();

$newfield = new select();
$newfield->field="page_tag_robots";
$newfield->multiLang=false;
$newfield->defaultValue="index,follow";
$newfield->label="Tag Robots";
$newfield->items=$data_robots;
$newfield->add();
	
$newfield = new select();
$newfield->field="page_sitemap_changefreq";
$newfield->multiLang=false;
$newfield->defaultValue="monthly";
$newfield->label="Sitemap changefreq";
$newfield->items=$data_FreqSM;
$newfield->add();


$newfield = new radio();
$newfield->field="page_recherche";
$newfield->defaultValue=1;
$newfield->multiLang=false;
$newfield->label=$datas_lang["pageRecherche"];
$newfield->items=$datas_lang["ouiNon"];
//$newfield->tooltip=$datas_lang["tooltip_pageRecherche"];
$newfield->add();

$newfield = new radio();
$newfield->field="actif";
$newfield->defaultValue=1;
$newfield->multiLang=false;
$newfield->label=$datas_lang["actif"];
$newfield->items=$datas_lang["listeActif"];
$newfield->add();

$newfield = new radio();
$newfield->field="super_admin_only";
$newfield->defaultValue=0;
$newfield->multiLang=false;
$newfield->label=$datas_lang["super_admin_only"];
$newfield->items=$datas_lang["listeActif"];
$newfield->add();

$fieldMedia = new mediaImage();
$fieldMedia->field="page_image";
$fieldMedia->label="Image de la page";
$fieldMedia->insideForm=true;
$fieldMedia->startFolder="pages"; 
$fieldMedia->multiLangType=true; 
$fieldMedia->dimMax="600x400";
$fieldMedia->fileRequired=false;
$fieldMedia->legendeEnabled=false;
$fieldMedia->variablesAuthorized=true;
$fieldMedia->add();

if($majInsert==1) { // Création
    $listMenus=array();
    $listMenus["0"] = "Aucun";
    $mySelect2 = new mySelect(__FILE__);
    $mySelect2->tables=$thisSite->PREFIXE_TBL_GEN . "menus";
    $mySelect2->fields="id,code_menu,titre";
    $mySelect2->where="lg=:lg AND code_menu!='horsmenu'";
    $mySelect2->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
    $mySelect2->orderby="id ASC";
    $result2=$mySelect2->query();
    foreach($result2 as $row2){
        $val=$row2['titre'];
        $listMenus[$row2['code_menu']] = $val;
    }
    
    $newfield = new radio();
    $newfield->field="add_menu";
    $newfield->defaultValue=0;
    $newfield->multiLang=false;
    $newfield->label="Ajouter à un menu";
    $newfield->items=$listMenus;    
    $newfield->javascript="onChange='change_add_menu(this)'";
    $newfield->add();
    
}
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>