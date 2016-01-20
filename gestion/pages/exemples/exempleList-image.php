<?php
$fieldMedia = new mediaImage();
$fieldMedia->field="testimage";
$fieldMedia->startFolder="test"; // sous répertoide de Files
$fieldMedia->maxElements=3; // Nombre d'éléments maximum
$fieldMedia->actionDestination="file"; // "file" ou "link" ou rien : Destination d'un click (uniquement si type=image)
$fieldMedia->multiLangType=true; // langues du champ fichier (ou lien_destination)
$fieldMedia->multiLangDestination=true; // langues des champs destination 
$fieldMedia->extensionsAuthorized=""; //  si vide > auto les ext. par défaut sinon indiquer une chaine > exemple: "jpg,png,zip"
$fieldMedia->dimMax="600x400"; // dimension Max des fichiers images
$fieldMedia->dimThumbs=array("100x100","200x"); // dimension des vignettes à créer
$fieldMedia->add();

?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>