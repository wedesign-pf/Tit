<?php
// initialisation des données pour "file"
$fieldMedia = new mediaFile();
$fieldMedia->field="testfichier";
$fieldMedia->startFolder="test"; // sous répertoide de Files
$fieldMedia->maxElements=15; // Nombre d'éléments maximum
$fieldMedia->multiLangType=true; // langues du champ fichier (ou lien_destination)
$fieldMedia->extensionsAuthorized=""; //  si vide > auto les ext. par défaut sinon indiquer une chaine > exemple: "jpg,png,zip"
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>