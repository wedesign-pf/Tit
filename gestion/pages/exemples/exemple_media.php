<?php
$datasMedia=array();

$datasMedia["name"] = "exemple"; // nom du média ou de l'article (également nom du dossier de stockage des fichiers)
$datasMedia["type"]="image"; // image ou video, file ou link
$datasMedia["maxElements"]=0; // nombre éléments maximum, 0= illimité
$datasMedia["dimThumbs"]=array("100x100","500x0");
$datasMedia["dimMax"] = "1024x0";
$datasMedia["multiLangType"]=false;
$datasMedia["multiLangDestination"]=false;
$datasMedia["actionDestination"]="link";  // "file" ou "link" ou rien : Destination d'un click (uniquement si type=image)
$datasMedia["extensionsAuthorized"]="jpg,png,zip"; //  si vide: auto les ext. par défaut sinon indiquer "images" ou une chaine > exemple: "jpg,png,zip"
$datasMedia["actif"] = array("label"=>"Actif","update"=>0); 
$datasMedia["choix1"] = array("label"=>"<i class='fa fa-star'></i>","update"=>1); 
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/media.php");
?>
