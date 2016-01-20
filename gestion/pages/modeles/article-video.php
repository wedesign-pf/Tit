<?php
// initialisation des données pour "video"
$fieldMedia = new mediaVideo();
$fieldMedia->field=$datasArticle["name"]."_video";
$fieldMedia->label="Code " . $thisSite->TYPE_VIDEO_DEFAUT;
$fieldMedia->multiLangType=false; 
$fieldMedia->fileRequired=false;
$fieldMedia->legendeEnabled=true;
if($datasArticle["video_maxElements"]>0) { $fieldMedia->maxElements=$datasArticle["video_maxElements"]; }
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>