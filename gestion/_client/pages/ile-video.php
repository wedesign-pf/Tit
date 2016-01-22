<?php
$fieldMedia = new mediaVideo();
$fieldMedia->field="ile_video";
$fieldMedia->label=$datas_lang["lienVideo"];
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