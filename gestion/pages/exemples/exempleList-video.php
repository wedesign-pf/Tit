<?php
// initialisation des données pour "link"
$fieldMedia = new mediaVideo();
$fieldMedia->field="testvideo";
$fieldMedia->maxElements=15; // Nombre d'éléments maximum
$fieldMedia->multiLangType=false; // langues du champ fichier (ou lien_destination)
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>