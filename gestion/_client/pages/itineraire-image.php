<?php
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
$fieldMedia->add();

$datasMedia["choix1"] = array("label"=>"<i class='fa fa-star'></i>","update"=>1); 
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>