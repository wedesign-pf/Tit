<?php
$datasArticle=array();
$datasArticle["name"] = "souscat_produit";
$datasArticle["actionsPage"] = array("ajouter","supprimer","move");
$datasArticle["fields_show"] = array("actif"=>"","titre"=>""); 
$datasArticle["orderby"] = "chrono ASC";

$obj_article = new article("type_produit");
$result=$obj_article->query();
$tab_type_produit=array();
foreach($result as $row){
   $tab_type_produit[$row["id"]]=$row["titre"];
}

$datasArticle["filtre"][1]["type"] = "select"; // select ou date
$datasArticle["filtre"][1]["label"] = "Type produit";
$datasArticle["filtre"][1]["items"]= $tab_type_produit; 


    $obj_article = new article("cat_produit");
   if($__POST["F__filtre_filtre1"]!="" &&  $__POST["F__filtre_filtre1"]!="allItems") { $obj_article->where="filtre1=" . $__POST["F__filtre_filtre1"];}
    $result=$obj_article->query();
    $tab_cat_produit=array();
    foreach($result as $row){
       $tab_cat_produit[$row["id"]]=$row["titre"];
    }
    



    $datasArticle["filtre"][2]["type"] = "select"; // select ou date
    $datasArticle["filtre"][2]["label"] = "Catégorie";
    $datasArticle["filtre"][2]["items"]= $tab_cat_produit; 
?>
<?php
include(DOS_PAGES_ADMIN . "modeles/init_article.php");
?>