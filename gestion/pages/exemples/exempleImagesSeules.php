<?php
// initialisation des données pour "images"
$idParent=0; // indiquer que c'est une rubrique autonome qui ne dépend pas d'un autre élément.
$fieldMedia = new mediaImage();
$fieldMedia->field="testimagesseules";
$fieldMedia->startFolder="test"; // sous répertoide de Files
$fieldMedia->maxElements=3; // Nombre d'éléments maximum
$fieldMedia->actionDestination="link"; // "file" ou "link" ou rien : Destination d'un click (uniquement si type=image)
$fieldMedia->multiLangType=false; // langues du champ fichier (ou lien_destination)
$fieldMedia->multiLangDestination=false; // langues des champs destination 
$fieldMedia->extensionsAuthorized=""; //  si vide > auto les ext. par défaut sinon indiquer une chaine > exemple: "jpg,png,zip"
$fieldMedia->dimMax="500x400"; // dimension Max des fichiers images
$fieldMedia->dimThumbs=array("0x300","200x"); // dimension des vignettes à créer
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>