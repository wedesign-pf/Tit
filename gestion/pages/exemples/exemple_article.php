<?php
$datasArticle=array();

$datasArticle["name"] = "exemple"; // nom de l'article (également nom du dossier pour les fichiers)
$datasArticle["maxElements"] = 0; // nombre d'éléments maximum autorisé (0 = illimité) 
$datasArticle["actionsPage"] = array("ajouter","supprimer","move"); // actions autorisées
$datasArticle["orderby"] = "id DESC"; // ordre d'affichage dans la liste

// liste des champs de saisie (la valeur indique le label, si à blanc on prend le label par défaut)
$datasArticle["fields_show"]["actif"]="";
$datasArticle["fields_show"]["titre"]=""; // multilangue et obligatoire
$datasArticle["fields_show"]["sous_titre"]=""; // multilangue
$datasArticle["fields_show"]["date"]="";
$datasArticle["fields_show"]["periode"]=""; // dans ce cas un Filtre Date est automatiquement ajoutée
$datasArticle["fields_show"]["texte1"]=""; // multilangue
$datasArticle["fields_show"]["texte2"]=""; // multilangue
$datasArticle["fields_show"]["texte3"]=""; // multilangue
$datasArticle["fields_show"]["auteur"]=""; // multilangue
$datasArticle["fields_show"]["email"]=""; // controle email valide
$datasArticle["fields_show"]["input1"]=""; // champ libre (255c) // multilangue et obligatoire
$datasArticle["fields_show"]["input2"]=""; // champ libre (255c) // multilangue 
$datasArticle["fields_show"]["input3"]=""; // champ libre (255c)
$datasArticle["fields_show"]["image"]="";  
$datasArticle["fields_show"]["file"]="";
$datasArticle["fields_show"]["link"]="";
$datasArticle["fields_show"]["video"]="";
$datasArticle["fields_show"]["tags"]="";

$datasArticle["image_dimMax"] = ""; // par exemple: "1024x768"
$datasArticle["image_dimThumbs"]=array(); // si pas défini, prend les valeurs par défaut du site
$datasArticle["image_maxElements"] = 0; // nombre d'images  autorisée (0 = illimité) 
$datasArticle["video_maxElements"] = 0; // nombre de videos autorisée (0 = illimité) 
$datasArticle["file_maxElements"] = 0; // nombre de fichiers autorisé (0 = illimité) 
$datasArticle["link_maxElements"] = 0;  // nombre de liens autorisé (0 = illimité) 

$datasArticle["image_legendeEnabled"]=true; // affichage d'un champ "légende" sous le champ "image"
$datasArticle["video_legendeEnabled"]=true; // affichage d'un champ "légende" sous le champ "video"
$datasArticle["file_legendeEnabled"]=true; // affichage d'un champ "légende" sous le champ "fichier"
$datasArticle["link_legendeEnabled"]=true; // affichage d'un champ "légende" sous le champ "link"

// Association d'un article à une page du site (doit exister dans l'arbo)
// On peut mettre soit l'ID de la page (attribution automatique), soit un script PHP (propose une liste déroulante de toute les pages ayant ce script PHP)
//$datasArticle["idPageAssocie"]="nos_produits.php";

// Maximum de 3 cases à cocher à ajouter dans la liste (si update=0  : illimité)
$datasArticle["choix1"] = array("label"=>"<i class='fa fa-star'></i>","update"=>2); 
//$datasArticle["choix2"] = array("label"=>"Test","update"=>0); 
//$datasArticle["choix3"] = array("label"=>"Test","update"=>0); 

// Maximum de 3 Filtres (ajouter en filtre de la liste et comme champs de saisie
// Filtre 1
$datasArticle["filtre"][1]["type"] = "select"; // select ou date
$datasArticle["filtre"][1]["label"] = "xxxxxx";
$datasArticle["filtre"][1]["items"]= array("O"=>"Oui","N"=>"Non"); // doit être une array associée ( exemple: array("O"=>"Oui","N"=>"Non") )
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/init_article.php");
?>