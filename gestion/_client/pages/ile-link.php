<?php
$fieldMedia = new mediaLink();
$fieldMedia->field="ile_lien";
$fieldMedia->label=$datas_lang["lien"];
$fieldMedia->multiLangType=true; 
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>
