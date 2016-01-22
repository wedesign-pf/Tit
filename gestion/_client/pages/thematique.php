<?php
$datasArticle=array();
$datasArticle["name"] = "theme";
$datasArticle["actionsPage"] = array("ajouter","supprimer","move");
$datasArticle["fields_show"] = array("actif"=>"","titre"=>""); 
$datasArticle["orderby"] = "chrono ASC";
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/init_article.php");
?>