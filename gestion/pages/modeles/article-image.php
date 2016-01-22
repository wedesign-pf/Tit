<?php
if(!isset($datasArticle["upload"])) { $datasArticle["upload"]=true; }
if(!isset($datasArticle["uploadDirect"])) { $datasArticle["uploadDirect"]=true; }

$fieldMedia = new mediaImage();
$fieldMedia->field=$datasArticle["name"]."_image";
$fieldMedia->label=$datas_lang["image"];
$fieldMedia->startFolder=$datasArticle["name"]; 
$fieldMedia->multiLangType=false; 
$fieldMedia->multiLangDestination=false; 
$fieldMedia->dimMax=$datasArticle["image_dimMax"]; 
if($datasArticle["image_dimThumbs"]=="") {
    $fieldMedia->dimThumbs=$thisSite->DEFAULT_DIM_VIGS;
} else {
    $fieldMedia->dimThumbs=$datasArticle["image_dimThumbs"];
}
$fieldMedia->fileRequired=false;
$fieldMedia->legendeEnabled=$datasArticle["image_legendeEnabled"];
if($datasArticle["image_maxElements"]>0) { $fieldMedia->maxElements=$datasArticle["image_maxElements"]; }
$fieldMedia->upload=$datasArticle["upload"]; 
$fieldMedia->uploadDirect=$datasArticle["uploadDirect"]; 
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>