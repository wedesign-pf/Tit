<?php
// initialisation des données pour "images"
$idParent=0; // indiquer que c'est une rubrique autonome qui ne dépend pas d'un autre élément.
$fieldMedia = new mediaImage();
$fieldMedia->field="images";
$fieldMedia->startFolder="images"; // sous répertoide de Files
$fieldMedia->actionDestination=""; // "file" ou "link" ou rien : Destination d'un click (uniquement si type=image)
$fieldMedia->multiLangType=true; // langues du champ fichier (ou lien_destination)
$fieldMedia->multiLangDestination=true; // langues des champs destination 
$fieldMedia->dimThumbs=$thisSite->DEFAULT_DIM_VIGS; // dimension des vignettes à créer
$fieldMedia->upload=true; 
$fieldMedia->uploadDirect=true;
$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>