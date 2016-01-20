<?php 
global $thisSite;

$liste_langues=array();
if(count($thisSite->LIST_LANG) >1){
		
	// On fait une boucle sur la liste des langues et on génère les liens
	reset($thisSite->LIST_LANG);
	foreach($thisSite->LIST_LANG as $lg=>$liblg){
		if($lg==$thisSite->current_lang) { continue; }
		
			$page_url="";
			// Niveau RUBRIQUE
		  	$mySelect = new mySelect(__FILE__);
			$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
			$mySelect->fields="page_url";
			$mySelect->where="id=:id AND actif=1 AND lg=:lg";
			$mySelect->whereValue["id"]=array($thisSite->current_rub,PDO::PARAM_STR);
			$mySelect->whereValue["lg"]=array($lg,PDO::PARAM_STR);
			$result=$mySelect->query();
			$row = current($result); 

		 	$page_url = stripslashes($row["page_url"]);

		  	// Niveau SOUS RUBRIQUE
			if($thisSite->current_srub!="") {
					$mySelect = new mySelect(__FILE__);
				$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
				$mySelect->fields="page_url";
				$mySelect->where="id=:id AND actif=1 AND lg=:lg";
				$mySelect->whereValue["id"]=array($thisSite->current_srub,PDO::PARAM_STR);
				$mySelect->whereValue["lg"]=array($lg,PDO::PARAM_STR);
				$result=$mySelect->query();
				$row = current($result); 
				
				$page_url .= "/" . stripslashes($row["page_url"]);
			 }
		  	// Niveau SOUS SOUS RUBRIQUE
			if($thisSite->current_ssrub!="") {
					$mySelect = new mySelect(__FILE__);
				$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
				$mySelect->fields="page_url";
				$mySelect->where="id=:id AND actif=1 AND lg=:lg";
				$mySelect->whereValue["id"]=array($thisSite->current_ssrub,PDO::PARAM_STR);
				$mySelect->whereValue["lg"]=array($lg,PDO::PARAM_STR);
				$result=$mySelect->query();
				$row = current($result); 
				
				$page_url .= "/" . stripslashes($row["page_url"]);
			 }
		  
		  	if($lg==$thisSite->LANG_DEF) {  // URL<>LANGDEF
				$lien_reload = $thisSite->RACINE  . $page_url; // langue par défaut
			} else {
				$lien_reload = $thisSite->RACINE . $thisSite->PREFIXE_LG . $lg . "/" . $page_url;
			}
			
			if($thisSite->current_urlQuery!="") { $lien_reload .= "?" . $thisSite->current_urlQuery; }

			$liste_langues[$lg]=array("titre"=>$liblg,"lien"=>$lien_reload);

	}
} 

$smarty->assign("liste_langues",$liste_langues);
?>
