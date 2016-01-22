<?php
$datasArticle=array();
$datasArticle["name"] = "type_produit";
$datasArticle["actionsPage"] = array("ajouter","supprimer","move");
$datasArticle["fields_show"] = array("actif"=>"","titre"=>"","image"=>"Icone"); 
$datasArticle["orderby"] = "chrono ASC";
$datasArticle["image_dimThumbs"]=array();
$datasArticle["image_dimMax"] = "480x480"; 
$datasArticle["image_legendeEnabled"]=false;
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/init_article.php");
?>