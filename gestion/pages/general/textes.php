<?php
$datasArticle=array();

$datasArticle["name"] = "textes"; 
$datasArticle["maxElements"] = 0;
$datasArticle["actionsPage"] = array("ajouter","supprimer"); 
$datasArticle["orderby"] = "id DESC"; // ordre d'affichage dans la liste

// liste des champs de saisie (la valeur indique le label, si � blanc on prend le label par d�faut)
$datasArticle["fields_show"]["actif"]="";
$datasArticle["fields_show"]["titre"]=""; 
//$datasArticle["fields_show"]["sous_titre"]=""; 
//$datasArticle["fields_show"]["date"]="";
//$datasArticle["fields_show"]["periode"]=""; 
$datasArticle["fields_show"]["texte1"]="Texte"; 
//$datasArticle["fields_show"]["texte2"]="";
//$datasArticle["fields_show"]["texte3"]=""; 
//$datasArticle["fields_show"]["auteur"]=""; 
//$datasArticle["fields_show"]["email"]=""; 
//$datasArticle["fields_show"]["input1"]=""; 
//$datasArticle["fields_show"]["input2"]=""; 
//$datasArticle["fields_show"]["input3"]="";
$datasArticle["fields_show"]["image"]="";  
//$datasArticle["fields_show"]["file"]="";
//$datasArticle["fields_show"]["link"]="";
//$datasArticle["fields_show"]["video"]="";
//$datasArticle["fields_show"]["tags"]="";

$datasArticle["fields_show"]["titre_tooltip"]="Ce titre n'est utilis� que dans l'administration, jamais dans le site public"; 

$datasArticle["image_dimMax"] = ""; // par exemple: "1024x768"
//$datasArticle["image_dimThumbs"]=array(); // si pas d�fini, prend les valeurs par d�faut du site
$datasArticle["image_maxElements"] = 1; // nombre d'images  autoris�e (0 = illimit�) 
$datasArticle["video_maxElements"] = 0; // nombre de videos autoris�e (0 = illimit�) 
$datasArticle["file_maxElements"] = 0; // nombre de fichiers autoris� (0 = illimit�) 
$datasArticle["link_maxElements"] = 0;  // nombre de liens autoris� (0 = illimit�) 

$datasArticle["image_legendeEnabled"]=true; // affichage d'un champ "l�gende" sous le champ "image"
$datasArticle["video_legendeEnabled"]=true; // affichage d'un champ "l�gende" sous le champ "video"
$datasArticle["file_legendeEnabled"]=true; // affichage d'un champ "l�gende" sous le champ "fichier"
$datasArticle["link_legendeEnabled"]=true; // affichage d'un champ "l�gende" sous le champ "link"

//$datasArticle["choix1"] = array("label"=>"<i class='fa fa-star'></i>","update"=>2); 
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/init_article.php");
?>