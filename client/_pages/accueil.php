<?php
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits_texte";
$mySelect->fields="texte";
$mySelect->where="id=6 AND lg='en'";
$result=$mySelect->query();
$row=current($result);

$smarty->assign("texte1", $row["texte"]);

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits_texte";
$mySelect->fields="texte";
$mySelect->where="id=7 AND lg='en'";
$result=$mySelect->query();
$row=current($result);

$smarty->assign("texte2", $row["texte"]);

?>
