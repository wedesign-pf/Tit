<?php
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
$fieldMedia->add();
$mainSelect=0;
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>