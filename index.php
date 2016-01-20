<?php
$come_by_index=1; // permet de vérifier qu'on est bien passé par l'index (en cas d'appel d'un script php directement)

include_once("init.php"); 

//////////////////////////
// Découpage de l'URL entre le sous niveaux et la langue
$parse_url=parse_url($_SERVER['REQUEST_URI']);
$parse_url = str_replace("sitemap.xml","sitemap.php",$parse_url); ///// GESTION DU SITEMAP
$path_uri = substr($parse_url["path"], strlen( dirname($_SERVER['PHP_SELF']))); // on supprime le chemin de la racine si nécessaire
$path_uri = trim($path_uri, '/');
$temp = explode('/', $path_uri);

$thisSite->current_tab_paths = array_filter($temp);
$thisSite->current_tab_paths_full = array_filter($temp);
$thisSite->current_urlQuery=$parse_url["query"];

// VERIFIE Si fichier avec une extension et si elle est autorisée.
// CHANGE de script principal si il y a une extension valide
$typeURL="redirect";
$last_elt=$thisSite->current_tab_paths[count($thisSite->current_tab_paths)-1];
$pos = strrpos($last_elt,".");
if($pos>0) {
	$ext=strtolower(substr($last_elt,$pos+1,strlen($last_elt)-$pos));
	if($ext!="") {
		if(strpos($thisSite->EXTENSIONS_INDEX_OK,$ext)===FALSE) {
            $thisSite->current_scriptPHP="404.php";
            config_404("index.php: strpos($thisSite->EXTENSIONS_INDEX_OK,$ext)===FALSE >" . $_SERVER['REQUEST_URI']);
		} else {
			// extension existe et autorisée
            $typeURL="direct";
		}
		
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


if(count($thisSite->LIST_LANG)>1){ // SITE MULTILANGUES

	// vérification si premier niveau est celui de la langue (site multi langues)
	$lg_from_path = $thisSite->current_tab_paths[0]; // on récupére la langue du chemin et on l'enleve du chemin
	$lg_from_path = substr($lg_from_path, strlen($thisSite->PREFIXE_LG)); // on enleve le Prefixe de la langue.

	if($lg_from_path!="") { // langue trouvé dans l'URL
 		if (array_key_exists($lg_from_path,$thisSite->LIST_LANG)) { 
			array_shift($thisSite->current_tab_paths); // on enleve la langue du chemin
			$thisSite->current_lang = $lg_from_path; // on stock la langue détectée dans le chemin
		} else {
            $thisSite->current_lang = $thisSite->LANG_DEF;
           // if($typeURL=="redirect") { 
              //  config_404("index.php: Langue invalide: " . $_SERVER['REQUEST_URI']);
           // }
        }
        
	} else { // langue pas trouvée dans l'URL
		
		if($thisSite->INDEX_LANG==0) { // si pas de page de choix de langue ou utilise la langue par défaut // URL<>LANGDEF
			$thisSite->current_lang = $thisSite->LANG_DEF;
			//$lien_reload = $thisSite->RACINE . $thisSite->PREFIXE_LG . $thisSite->LANG_DEF . "/" . $thisSite->script_HP;
			//header('Location:'. $lien_reload,true,302);
			//exit();
		}
        
		if($thisSite->INDEX_LANG==1) { // si page de langue demandée

			$mySelect = new mySelect(__FILE__);
			$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
			$mySelect->fields="page_url";
			$mySelect->where="page_php='index_langue.php' AND actif=1 AND lg=:lg";
			$mySelect->whereValue["lg"]=array($thisSite->LANG_DEF,PDO::PARAM_STR);
			$result=$mySelect->query();
			$row = current($result); 
			$thisSite->current_tab_paths[0]= $row["page_url"];
			// on cherche la langue du navigateur
			$lg_from_browser=substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,2);
			if (array_key_exists($lg_from_browser,$thisSite->LIST_LANG)) { 
				$thisSite->current_lang=$lg_from_browser;
			} else {
				$thisSite->current_lang=$thisSite->LANG_DEF;
			}
			$thisSite->save_current_lang=""; 
		}
	}
	
	if($thisSite->current_lang==$thisSite->LANG_DEF) { // URL<>LANGDEF
		$thisSite->racineWithLang= $thisSite->RACINE ; 
	} else {
		$thisSite->racineWithLang= $thisSite->RACINE . $thisSite->PREFIXE_LG . $thisSite->current_lang . "/"; 
	}

	
} else { // SITE MONOLANGUE

	$thisSite->current_lang=$thisSite->LANG_DEF;
	$thisSite->racineWithLang=$thisSite->RACINE;

} // FIN SITE MULTILANGUES OU MONOLANGUE
			
///////////////////////////////////////
// INITIALISATION DES DONNEES SITE

if($thisSite->save_current_lang!=$thisSite->current_lang && $thisSite->save_current_lang!=""  
|| $thisSite->save_domaine != $thisSite->DOMAINE
|| $thisSite->save_statut != $thisSite->statut
|| $thisSite->SERVER == "local"
|| $thisSite->reInit == 1
|| $_GET["init"]==1 ) {
    $thisSite->initSite(); // Initialisation données de base du site
}

//$thisSite->current_urlCanonical=$thisSite->RACINE . $path_uri;
////////////////////////

if($typeURL=="redirect") { 
	include_once("index-redirect.php"); 
} else {
	include_once("index-direct.php"); 
}
?>