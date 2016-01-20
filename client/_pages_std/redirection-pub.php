<?php 

$myUpdate = new myUpdate(__FILE__);
$myUpdate->table=$thisSite->PREFIXE_TBL_PUB . "stats";
$myUpdate->field["nb_click"]="LITERAL:nb_click+1";
$myUpdate->where="id_bandeau=:id_bandeau AND aa=:aa AND mm=:mm AND jj=:jj AND lg=:lg";
$myUpdate->whereValue["id_bandeau"]=array($__GET["id"],PDO::PARAM_INT);
$myUpdate->whereValue["aa"]=array(date(Y),PDO::PARAM_STR);
$myUpdate->whereValue["mm"]=array(date(m),PDO::PARAM_STR);
$myUpdate->whereValue["jj"]=array(date(d),PDO::PARAM_STR);
$myUpdate->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
$result=$myUpdate->execute();

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_PUB . "bandeaux";
$mySelect->fields="lien_destination";
$mySelect->where="id=:id_bandeau AND lg=:lg";
$mySelect->whereValue["id_bandeau"]=array($__GET["id"],PDO::PARAM_INT);
$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
$result=$mySelect->query();
$row = current($result);
$lien_destination=stripslashes($row["lien_destination"]);

if ($lien_destination!="") {
	$parse_lien = parse_url($lien_destination);
	if ($parse_lien["scheme"]=="" ) { $lien_destination = $thisSite->RACINE . $lien_destination; }
	header("Location: $lien_destination");
}
?>