<?php
if(is_array($datasArticle["filtre"])) { 
    foreach($datasArticle["filtre"] as $f=>$filtre) {
        if($datasArticle["filtre"][$f]["field"]=="") {
            $datasArticle["filtre"][$f]["field"] = "filtre".$f; 
        }
    }
}

// si période demandée pour l'article, on ajoute un filtre automatiquement
if(array_key_exists("periode",$datasArticle["fields_show"]) ) { 
	$datasArticle["filtre"][0]["field"] = "date";
	$datasArticle["filtre"][0]["type"] = "date";
	$datasArticle["filtre"][0]["label"] = "Date";
}

if(is_array($datasArticle["filtre"])) { ksort($datasArticle["filtre"]); }

if($datasArticle["maxElements"]==1) {
 
    $mySelect = new mySelect(__FILE__);
    $mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "articles";
    $mySelect->fields="id";
    $mySelect->where="art='" . $datasArticle["name"] . "'";
    $res=$mySelect->query();
    $rowx = current($res); 
    $idCurrent=$rowx["id"];
    //           
    $extensionPageCurrent="-maj";
}

$maxElements=$datasArticle["maxElements"];

$forceTemplate = DOS_PAGES_ADMIN . "modeles/article" . $extensionPageCurrent;

include($forceTemplate . ".php");
$smarty->assign("datasArticle",$datasArticle);
?>