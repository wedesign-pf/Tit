<?php
$datasArticle=array();
$datasArticle["name"] = "infos_pra";
$datasArticle["actionsPage"] = array("ajouter","supprimer","move");
$datasArticle["fields_show"] = array("actif"=>"","titre"=>"","texte1"=>"Texte"); 
$datasArticle["orderby"] = "chrono ASC";
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/init_article.php");
?>