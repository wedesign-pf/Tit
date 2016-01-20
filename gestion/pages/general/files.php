<?php
// initialisation des données pour "File"
$idParent=0; // indiquer que c'est une rubrique autonome qui ne dépend pas d'un autre élément.
$fieldMedia = new mediaFile();
$fieldMedia->field="files";
$fieldMedia->startFolder="files"; // sous répertoide de Files
$fieldMedia->actionDestination=""; // "file" ou "link" ou rien : Destination d'un click (uniquement si type=image)
$fieldMedia->multiLangType=true; // langues du champ fichier (ou lien_destination)
$fieldMedia->upload=true; 
$fieldMedia->uploadDirect=false;

$fieldMedia->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "medias-init.php");
include(DOS_INCPAGES_ADMIN  . "medias-maj-prepare.php");
include(DOS_INCPAGES_ADMIN  . "medias-list-prepare.php");
?>