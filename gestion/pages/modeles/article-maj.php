<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "articles";
if($datasArticle["maxElements"]==1) {
    $actionsPage=array("valider");
} else {
   $actionsPage=array("annuler","valider","appliquer");
}
$variablesAuthorized=true;

if(!isset($datasArticle["image_legendeEnabled"])) { $datasArticle["image_legendeEnabled"]=true; }
if(!isset($datasArticle["video_legendeEnabled"])) { $datasArticle["video_legendeEnabled"]=true; }
if(!isset($datasArticle["file_legendeEnabled"])) { $datasArticle["file_legendeEnabled"]=true; }
if(!isset($datasArticle["link_legendeEnabled"])) { $datasArticle["link_legendeEnabled"]=true; }
if(!isset($datasArticle["upload"])) { $datasArticle["upload"]=true; }
if(!isset($datasArticle["uploadDirect"])) { $datasArticle["uploadDirect"]=true; }
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

	$idSet =$formMaj->set_datas();
	
    if(is_numeric($datasArticle["idPageAssocie"])) { 
        $idPage=$datasArticle["idPageAssocie"];  
    } else if($datasArticle["idPageAssocie"]!="") {
        $idPage=$__POST["id_page"];  
    }
	if($idPage!="") {
		if($__POST["page_titre_fr"]=="") { $__POST["page_titre_fr"]=$__POST["titre_fr"]; }
		$classPage = new classPage();
		$classPage->table=$myTable;
		$classPage->idCurrent=$idSet;
		$classPage->idPageParent=$idPage;
		$classPage->page_genre="G";
		$classPage->addPage(); // ajoute/modifie cet élément à la liste des pages du site et le place dans l'arbo
	}

	if($__POST["actionForm"]=="valider") {
        if($datasArticle["maxElements"]>1 || $datasArticle["maxElements"]=="") {
		    actionFormMaj($__POST["actionForm"]);
        }

	}
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
	$newfield->add();
}
$newfield = new hidden();
$newfield->field="datetime_mod";
$newfield->value=date('Y-m-d H:i:s');
$newfield->add();

$newfield = new hidden();
$newfield->field="art";
$newfield->value=$datasArticle["name"];
$newfield->add();

if(array_key_exists("actif",$datasArticle["fields_show"]) ) {
    $newfield = new radio();
    $newfield->field="actif";
    $newfield->defaultValue=1;
    $newfield->multiLang=false;
    if($datasArticle["fields_show"]["actif"]=="") {
        $newfield->label=$datas_lang["actif"];
    } else {
        $newfield->label=$datasArticle["fields_show"]["actif"];
    }
    $newfield->items=$datas_lang["listeActif"];
    $newfield->add();
} else {
    $newfield = new hidden();
    $newfield->field="actif";
    $newfield->defaultValue="1";
    $newfield->add();
}


if(!is_numeric($datasArticle["idPageAssocie"]) && $datasArticle["idPageAssocie"]!="" ) { // on sélecionne l'id de la page au lieu de la saisie du titre

    $listePages=array();
    $listePages[""]="Choisisez......";
     
    $prefixSrub="-"; // préfixe pour indiquer les sous et sous sous rubriques
    
    // on charge tout les menus    
    $mySelect = new mySelect(__FILE__);
    $mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "arbo";
    $mySelect->fields="*"; 
    $result=$mySelect->query();
    foreach($result as $row){ 
        $code_menu=$row['code_menu'];
        $arbo_menu=unserialize($row['arbo_menu']);
        // pour chaque rub
        foreach($arbo_menu as $idRUB=>$listSRUB) {
            if($thisSite->pages[$idRUB]["page_php"]==$datasArticle["idPageAssocie"]) { // on regarde si la page PHP correspond (pour ne prendre que certaines pages)
                $listePages[$idRUB]=$thisSite->pages[$idRUB]["titre"];
            }
            if(is_array($listSRUB)) { 
                foreach($listSRUB as $idSRUB=>$listSSRUB) {
                    if($thisSite->pages[$idSRUB]["page_php"]==$datasArticle["idPageAssocie"]) {
                       $listePages[$idSRUB]="&nbsp;" . $prefixSrub . "&nbsp;" . $thisSite->pages[$idSRUB]["titre"];
                    }
                    if(is_array($listSSRUB)) { 
                        foreach($listSSRUB as $idSSRUB=>$x) {
                            if($thisSite->pages[$idSSRUB]["page_php"]==$datasArticle["idPageAssocie"]) {
                                $listePages[$idSSRUB]="&nbsp;" .  "&nbsp;" .  $prefixSrub . "&nbsp;" . $thisSite->pages[$idSSRUB]["titre"];
                            }
                        }
                    }
                }
            }
        }
    }
   
   
    $newfield = new select();
    $newfield->field="id_page";
    $newfield->label="Page associée";
    $newfield->multiLang=false;
    $newfield->noneItem=false;
    $newfield->items=$listePages;
    $newfield->add();   
    $newfield->rule("required",true);
    
} else { // sino on demande le titre normalement

    $newfield = new input();
    $newfield->field="titre";
    $newfield->multiLang=true;
    if($datasArticle["fields_show"]["titre"]=="") {
        $newfield->label=$datas_lang["titre"];
    } else {
        $newfield->label=$datasArticle["fields_show"]["titre"];
    }
    $newfield->variablesAuthorized=true;
    if($datasArticle["fields_show"]["titre_tooltip"]!="") { $newfield->tooltip=$datasArticle["fields_show"]["titre_tooltip"]; }
    $newfield->add();
    $newfield->rule("required",true);

}

if(array_key_exists("sous_titre",$datasArticle["fields_show"]) ) {
    $newfield = new input();
    $newfield->field="sous_titre";
    $newfield->multiLang=true;
    if($datasArticle["fields_show"]["sous_titre"]=="") {
        $newfield->label="Sous Titre";
    } else {
        $newfield->label=$datasArticle["fields_show"]["sous_titre"];
    }
    $newfield->variablesAuthorized=true;
    $newfield->add();
}

if(array_key_exists("date",$datasArticle["fields_show"]) ) {
    $newfield = new date();
    $newfield->field="date";
    if($datasArticle["fields_show"]["date"]=="") {
        $newfield->label="Date";
    } else {
        $newfield->label=$datasArticle["fields_show"]["date"];
    }
    $newfield->showButtonPanel=true;
    $newfield->changeYear=true;
    $newfield->numberOfMonths=1;
    $newfield->multiLang=false;
    $newfield->defaultValue= date('Ymd');
    $newfield->add();
}

if(array_key_exists("periode",$datasArticle["fields_show"]) ) {
	$newfield = new periode();
	$newfield->field="periode";
    if($datasArticle["fields_show"]["periode"]=="") {
        $newfield->label="Période";
    } else {
        $newfield->label=$datasArticle["fields_show"]["periode"];
    }
	$newfield->showButtonPanel=true;
	$newfield->changeYear=true;
	$newfield->numberOfMonths=1;
	$newfield->dateFormat="dd.mm.yy";
	$newfield->multiLang=false;
	$newfield->add();
}

if(array_key_exists("texte1",$datasArticle["fields_show"]) ) {
    $newfield = new editor();
    $newfield->field="texte1";
    if($datasArticle["fields_show"]["texte1"]=="") {
        $newfield->label="Texte intro";
    } else {
        $newfield->label=$datasArticle["fields_show"]["texte1"];
    }
    $newfield->multiLang=true;
    $newfield->toolbar="Default";
    $newfield->startFolder=$datasArticle["name"];
    $newfield->extensionsAuthorized="images";
    $newfield->height=250;
    $newfield->add();
}

if(array_key_exists("texte2",$datasArticle["fields_show"]) ) {
    $newfield = new editor();
    $newfield->field="texte2";
    if($datasArticle["fields_show"]["texte2"]=="") {
        $newfield->label="Texte principal";
    } else {
        $newfield->label=$datasArticle["fields_show"]["texte2"];
    }
    $newfield->multiLang=true;
    $newfield->toolbar="Default";
    $newfield->startFolder=$datasArticle["name"];
    $newfield->extensionsAuthorized="images";
    $newfield->height=400;
    $newfield->add();
}

if(array_key_exists("texte3",$datasArticle["fields_show"]) ) {
    $newfield = new editor();
    $newfield->field="texte3";
    if($datasArticle["fields_show"]["texte3"]=="") {
        $newfield->label="Texte 3";
    } else {
        $newfield->label=$datasArticle["fields_show"]["texte3"];
    }
    $newfield->multiLang=true;
    $newfield->toolbar="Default";
    $newfield->startFolder=$datasArticle["name"];
    $newfield->extensionsAuthorized="images";
    $newfield->height=400;
    $newfield->add();
}


if(array_key_exists("auteur",$datasArticle["fields_show"]) ) {
    $newfield = new input();
    $newfield->field="auteur";
    $newfield->multiLang=false;
    if($datasArticle["fields_show"]["auteur"]=="") {
        $newfield->label="Auteur";
    } else {
        $newfield->label=$datasArticle["fields_show"]["auteur"];
    }
    $newfield->variablesAuthorized=true;
    $newfield->add();
}

if(array_key_exists("email",$datasArticle["fields_show"]) ) {
    $newfield = new input();
    $newfield->field="email";
    $newfield->multiLang=false;
    if($datasArticle["fields_show"]["email"]=="") {
        $newfield->label="Email";
    } else {
        $newfield->label=$datasArticle["fields_show"]["email"];
    }
    $newfield->variablesAuthorized=false;
    $newfield->add();
    $newfield->rule("email",true);
}


if(array_key_exists("input1",$datasArticle["fields_show"]) ) {
    $newfield = new input();
    $newfield->field="input1";
    $newfield->multiLang=true;
    if($datasArticle["fields_show"]["input1"]=="") {
        $newfield->label="Input 1";
    } else {
        $newfield->label=$datasArticle["fields_show"]["input1"];
    }
    $newfield->variablesAuthorized=true;
    $newfield->add();
     $newfield->rule("required",true);
}
if(array_key_exists("input2",$datasArticle["fields_show"]) ) {
    $newfield = new input();
    $newfield->field="input2";
    $newfield->multiLang=true;
    if($datasArticle["fields_show"]["input2"]=="") {
        $newfield->label="Input 2";
    } else {
        $newfield->label=$datasArticle["fields_show"]["input2"];
    }
    $newfield->variablesAuthorized=true;
    $newfield->add();
}
if(array_key_exists("input3",$datasArticle["fields_show"]) ) {
    $newfield = new input();
    $newfield->field="input3";
    $newfield->multiLang=false;
    if($datasArticle["fields_show"]["input3"]=="") {
        $newfield->label="Input 3";
    } else {
        $newfield->label=$datasArticle["fields_show"]["input3"];
    }
    $newfield->variablesAuthorized=true;
    $newfield->add();
}

if(array_key_exists("image",$datasArticle["fields_show"]) ) {
    $fieldMedia = new mediaImage();
    $fieldMedia->field=$datasArticle["name"]."_image";
    if($datasArticle["fields_show"]["image"]=="") {
        $fieldMedia->label=$datas_lang["image"];
    } else {
        $fieldMedia->label=$datasArticle["fields_show"]["image"];
    }
    $fieldMedia->startFolder=$datasArticle["name"]; 
    $fieldMedia->multiLangType=false; 
    $fieldMedia->multiLangDestination=false; 
    $fieldMedia->dimMax=$datasArticle["image_dimMax"]; 
    if($datasArticle["image_dimThumbs"]=="") {
        $fieldMedia->dimThumbs=$thisSite->DEFAULT_DIM_VIGS;
    } else {
        $fieldMedia->dimThumbs=$datasArticle["image_dimThumbs"];
    }
    $fieldMedia->insideForm=true;
    $fieldMedia->fileRequired=false;
    $fieldMedia->legendeEnabled=$datasArticle["image_legendeEnabled"];
    $fieldMedia->upload=$datasArticle["upload"]=true;
    $fieldMedia->uploadDirect=$datasArticle["uploadDirect"]=true;
    $fieldMedia->add();
}


if(array_key_exists("video",$datasArticle["fields_show"]) ) {
    $fieldMedia = new mediaVideo();
    $fieldMedia->field=$datasArticle["name"]."_video";
    $fieldMedia->multiLangType=false;
    $fieldMedia->insideForm=true;
    $fieldMedia->fileRequired=false;
    $fieldMedia->legendeEnabled=$datasArticle["video_legendeEnabled"];
    $fieldMedia->add();
}

if(array_key_exists("file",$datasArticle["fields_show"]) ) {
    $fieldMedia = new mediaFile();
    $fieldMedia->field=$datasArticle["name"]."_file";
    
    if($datasArticle["fields_show"]["file"]=="") {
        $fieldMedia->label=$datas_lang["fichier"];
    } else {
        $fieldMedia->label=$datasArticle["fields_show"]["file"];
    }
    $fieldMedia->insideForm=true;
    $fieldMedia->fileRequired=false;
    $fieldMedia->multiLangType=false; 
    $fieldMedia->startFolder=$datasArticle["name"] . "/fichiers";
    $fieldMedia->legendeEnabled=$datasArticle["file_legendeEnabled"];
    $fieldMedia->upload=$datasArticle["upload"];
    $fieldMedia->add();
}

if(array_key_exists("link",$datasArticle["fields_show"]) ) {
    $fieldMedia = new mediaLink();
    $fieldMedia->field=$datasArticle["name"]."_link";
    if($datasArticle["fields_show"]["link"]=="") {
        $fieldMedia->label=$datas_lang["lien"];
    } else {
        $fieldMedia->label=$datasArticle["fields_show"]["link"];
    }
    $fieldMedia->multiLangType=false;
    $fieldMedia->insideForm=true;
    $fieldMedia->fileRequired=false;
    $fieldMedia->legendeEnabled=$datasArticle["link_legendeEnabled"];
    $fieldMedia->add();
}

if(array_key_exists("tags",$datasArticle["fields_show"]) ) {
    $newfield = new selectMCols();
    $newfield->field="tags";
    if($datasArticle["fields_show"]["tags"]=="") {
        $newfield->label="Tags";
    } else {
        $newfield->label=$datasArticle["fields_show"]["tags"];
    }
    $newfield->multiLang=false;
    $newfield->tags=true;

    $newfield->selectAll=false;
    $newfield->add();
}
///////////////////////////////////////////
if(is_array($datasArticle["filtre"])) { 
	 foreach($datasArticle["filtre"] as $f=>$filtre) {
		if(is_array($filtre["items"])) { 
			reset($filtre["items"]);
			$newfield = new select();
			$newfield->field=$filtre["field"];
			$newfield->label=$filtre["label"];
			$newfield->multiLang=false;
			$newfield->noneItem=true;
			$newfield->items=$filtre["items"];
			$newfield->value=${$newfield->field};
			$newfield->defaultValue=$filtres["F__filtre_".$filtre["field"]];
			$datasArticle["filtre"][$f]["HTML"]=$newfield->add();
			$newfield->rule("required",true);
		 }
	 }
}
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>