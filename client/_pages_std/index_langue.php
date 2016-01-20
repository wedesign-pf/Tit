<?php 
// On fait une boucle sur la liste des langues et on génère les liens

$liste_liens_langue=array();
	
reset($thisSite->LIST_LANG);
foreach($thisSite->LIST_LANG as $lg=>$liblg){
	
	$page_url="";

  	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
	$mySelect->fields="page_url";
	$mySelect->where="page_php='" . $thisSite->script_HP . "' AND actif=1 AND lg=:lg";
	$mySelect->whereValue["lg"]=array($lg,PDO::PARAM_STR);
	$result=$mySelect->query();
	$row = current($result); 
		
	$page_url = stripslashes($row["page_url"]);

	$lien = $thisSite->RACINE . $thisSite->PREFIXE_LG . $lg . "/" . $page_url;

	$liste_liens_langue[$lg] = array("titre"=>$liblg,"lien"=>$lien);
		
}
	
	$smarty->assign("liste_liens_langue",$liste_liens_langue);
?>