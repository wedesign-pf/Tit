<?php
$pathBatch="../../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php
$json = array();

if($__GET["type"]!="") { 
    $obj_article = new article("cat_produit");
    $obj_article->fields="id,titre";
    $obj_article->where="filtre1='" . $__GET["type"] . "'";
    $result=$obj_article->query();
    foreach($result as $row){
       $json[$row["id"]]=$row["titre"];
    }
}

if($__GET["cat"]!="") { 
    $obj_article = new article("souscat_produit");
    $obj_article->fields="id,titre";
    $obj_article->where="filtre2='" . $__GET["cat"] . "'";
    $result=$obj_article->query();
    foreach($result as $row){
       $json[$row["id"]]=$row["titre"];
    }
}

echo json_encode($json);
?>