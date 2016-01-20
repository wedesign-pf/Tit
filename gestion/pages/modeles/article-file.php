<?php
if(!isset($datasArticle["upload"])) { $datasArticle["upload"]=true; }

$fieldMedia = new mediaFile();
$fieldMedia->field=$datasArticle["name"]."_file";
$fieldMedia->label=$datas_lang["fichier"];
$fieldMedia->fileRequired=false;
$fieldMedia->multiLangType=false; 
$fieldMedia->startFolder=$datasArticle["name"] . "/fichiers";
if($datasArticle["file_maxElements"]>0) { $fieldMedia->maxElements=$datasArticle["file_maxElements"]; }
$fieldMedia->upload=$datasArticle["upload"]; 
$fieldMedia->uploadDirect=false; 
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>
