<?php
$fieldMedia = new mediaLink();
$fieldMedia->field=$datasArticle["name"]."_link";
$fieldMedia->label=$datas_lang["lien"];
$fieldMedia->multiLangType=false;
$fieldMedia->fileRequired=false;
$fieldMedia->legendeEnabled=true;
if($datasArticle["link_maxElements"]>0) { $fieldMedia->maxElements=$datasArticle["link_maxElements"]; }
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>