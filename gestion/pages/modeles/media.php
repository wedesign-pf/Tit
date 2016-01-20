<?php
if(!isset($datasMedia["multiLangType"])) { $datasMedia["multiLangType"]=true; }
if(!isset($datasMedia["multiLangDestination"])) { $datasMedia["multiLangDestination"]=true; }
if(!isset($datasMedia["upload"])) { $datasMedia["upload"]=true; }
if(!isset($datasMedia["uploadDirect"])) { $datasMedia["uploadDirect"]=true; }

if(!isset($datasMedia["dimThumbs"])) { $datasMedia["dimThumbs"]=$thisSite->DEFAULT_DIM_VIGS; }

$fieldName=$datasMedia["name"]  . "_" . $datasMedia["type"];

// initialisation des données pour "images"
$idParent=0; // indiquer que c'est une rubrique autonome qui ne dépend pas d'un autre élément.
if($datasMedia["type"]=="image") { $fieldMedia = new mediaImage(); }
if($datasMedia["type"]=="video") { $fieldMedia = new mediaVideo(); }
if($datasMedia["type"]=="file") { $fieldMedia = new mediaFile(); }
if($datasMedia["type"]=="link") { $fieldMedia = new mediaLink(); }
if($fieldMedia!="") {
    $fieldMedia->field=$fieldName;
    $fieldMedia->startFolder=$fieldName; // sous répertoide de Files
    $fieldMedia->maxElements=$datasMedia["maxElements"]; // Nombre d'éléments maximum
    $fieldMedia->dimThumbs= $datasMedia["dimThumbs"]; 
    $fieldMedia->dimMax=$datasMedia["dimMax"]; 
    $fieldMedia->multiLangType=$datasMedia["multiLangType"]; // langues du champ fichier (ou lien_destination)
    $fieldMedia->multiLangDestination=$datasMedia["multiLangDestination"]; // langues des champs destination 
    $fieldMedia->actionDestination=$datasMedia["actionDestination"]; // "file" ou "link" ou rien : Destination d'un click (uniquement si type=image)
    $fieldMedia->extensionsAuthorized=$datasMedia["extensionsAuthorized"];
    $fieldMedia->upload=$datasMedia["upload"]; 
    $fieldMedia->uploadDirect=$datasMedia["uploadDirect"]; 
    $fieldMedia->add();
}
$idParent="";
?>
<?php
$forceTemplate = DOS_PAGES_ADMIN . "modeles/media";
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>