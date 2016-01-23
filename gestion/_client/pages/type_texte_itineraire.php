<?php
$datasArticle=array();
$datasArticle["name"] = "type_texte_itineraire";
$datasArticle["actionsPage"] = array("ajouter","supprimer","move");
$datasArticle["fields_show"] = array("actif"=>"","titre"=>""); 
$datasArticle["orderby"] = "chrono ASC";
$datasArticle["choix1"] = array("label"=>"Onglet","update"=>0); 
$datasArticle["choix2"] = array("label"=>"Sidebar","update"=>0); 
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/init_article.php");
?>