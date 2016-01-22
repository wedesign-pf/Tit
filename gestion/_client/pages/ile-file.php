<?php
$fieldMedia = new mediaFile();
$fieldMedia->field="ile_fichier";
$fieldMedia->label=$datas_lang["fichier"];
$fieldMedia->startFolder="iles/files"; 
$fieldMedia->multiLangType=true; 
$fieldMedia->legendeEnabled=true;
$fieldMedia->maxElements=0;
$fieldMedia->upload=true; 
$fieldMedia->uploadDirect=true; 
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>