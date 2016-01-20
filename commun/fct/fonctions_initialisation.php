<?php

function addStructure($type,$valeur) {

	global $smarty;
    
	$smarty->append($type, $valeur);
   
	$arrayType=$smarty->getTemplateVars($type);
	if(is_array($arrayType)) { $smarty->assign($type,array_unique($arrayType)); }
}


/*function OLDprepareMenuLink($lien,$page_type,$class="") {

	// Si lien Ancre dans la page
	if($page_type=="anchor") { $lien="#".$lien; $class.=" linkAnchor";}
	
	// ajout Class suivant le type de page
	if($page_type=="lightbox") { $class.=" boxIframe"; }
	if($page_type=="iframe") { $class.=" boxIframe"; }
	
	return array($lien,$class);
}*/

/*function prepareMenuLinkOLD222($idR,$racineLink,$class="") {
    
    global $thisSite;
    $datasRUB = $thisSite->pages[$idR];

    $page_type=$datasRUB["page_type"];
  
	// Si lien Ancre dans la page
	if($page_type=="anchor") { 
        $link="#".$lien; 
        $class.=" linkAnchor";
    } else if($page_type=="nolink") { 
        $link="javascript:void(0);"; 
    } else {
        $link=$racineLink . $datasRUB["page_url"]; 
    }

	// ajout Class suivant le type de page
	if($page_type=="lightbox") { $class.=" boxIframe"; }
	if($page_type=="iframe") { $class.=" boxIframe"; }
	
	return array($link,$class);
}*/

function prepareMenuLinkClassLI($pageType) {
    
    if($pageType=="page") { $class=" showLoader";  }
    
    return $class;
}

function prepareMenuLinkClassA($pageType) {
	if($pageType=="anchor") { $class=" linkAnchor";  }
	if($pageType=="lightbox") { $class=" boxIframe"; }
	if($pageType=="iframe") { $class=" boxIframe"; }
	
	return $class;
}

function prepareMenuLink($pageType,$racineLink,$pageUrl) {

	if($pageType=="anchor") { 
        $link="#".$pageUrl; 
    } else if($pageType=="nolink") { 
        $link="javascript:void(0);"; 
    } else {
        $link=$racineLink . $pageUrl; 
    }

	return $link;
}
?>
<?php
// retourne le chemin vers un script (soit dans le répertoire client soit dans le répertoire base)
function get_path_pages($page,$p404=1) {
    
    global $thisSite;
    
	if($thisSite->pagesLoaded[$page]=="") {
        
		if (file_exists($thisSite->DOS_CLIENT . "_pages/" . $page)) { 
			$thisSite->pagesLoaded[$page]=$thisSite->DOS_CLIENT . "_pages/" . $page;
		} else if (file_exists($thisSite->DOS_CLIENT . "_pages_std/" . $page)) { 
            $thisSite->pagesLoaded[$page]=$thisSite->DOS_CLIENT . "_pages_std/" . $page;
        } else {
			if($p404==1) { 
			    $thisSite->pagesLoaded[$page]=get_path_pages("404.php");
            } else {
                $thisSite->pagesLoaded[$page]="";	
            }
		}

	}
	
    return $thisSite->pagesLoaded[$page];

}

// retourne le chemin vers un module (soit dans le répertoire client soit dans le répertoire base)
function get_path_modules($module) {
    
    global $thisSite;
    
    if($thisSite->modulesLoaded[$module]=="") {
        
		if (file_exists($thisSite->DOS_CLIENT . "_modules/" . $module)) { 
			$thisSite->modulesLoaded[$module]=$thisSite->DOS_CLIENT . "_modules/" . $module;
		} else if (file_exists($thisSite->DOS_CLIENT . "_modules_std/" . $module)) { 
            $thisSite->modulesLoaded[$module]=$thisSite->DOS_CLIENT . "_modules_std/" . $module;
        } else {
			$thisSite->modulesLoaded[$module]="";
		}

	}
	
    return $thisSite->modulesLoaded[$module];
    
} 

// retourne le chemin vers un outil (soit dans le répertoire client soit dans le répertoire base)
function get_path_outils($outil) {
    
    global $thisSite;
    
    if($thisSite->outilsLoaded[$outil]=="") {
        
		if (file_exists($thisSite->DOS_CLIENT . "_outils/" . $outil)) { 
			$thisSite->outilsLoaded[$outil]=$thisSite->DOS_CLIENT . "_outils/" . $outil;
		} else if (file_exists($thisSite->DOS_CLIENT . "_outils_std/" . $outil)) { 
            $thisSite->outilsLoaded[$outil]=$thisSite->DOS_CLIENT . "_outils_std/" . $outil;
        } else {
			$thisSite->outilsLoaded[$outil]="";
		}

	}
	
    return $thisSite->outilsLoaded[$outil];
} 

// retourne le chemin vers un script (soit dans le répertoire client soit dans le répertoire base)
function get_path($chemin_fichier) {
   
    global $thisSite;
	if (file_exists($thisSite->DOS_CLIENT . $chemin_fichier )) { 
        return $thisSite->DOS_CLIENT . $chemin_fichier;
	} else if (file_exists($thisSite->DOS_BASE . $chemin_fichier )) { 
        return $thisSite->DOS_BASE . $chemin_fichier; 
	} else {
		return false;
	}
	
}


function load_intitules_by_lang() {
    
    global $thisSite;
    
	$intitules_lang=array();

	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "intitules";
	$mySelect->fields="*";
	$mySelect->where="lg=:lg";
	$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
	$result=$mySelect->query();
	foreach($result as $row){
		$intitules_lang[$row["code"]]=add_variables($row["titre"]);
	}

	$thisSite->intitulesLang=$intitules_lang;
	
}
	
function load_data_lang_plus($nom,$chemin){
    
	global $datas_lang;
    global $thisSite;

	$datas = pre_load_data_lang_plus($chemin);

	if(!is_array($datas)) { return false; }

	foreach($datas as $code=>$valeur){
	
		if ($thisSite->SERVER == "local") { 
			if(isset($datas_lang[$code])) { // on vérfie si l'élément n'existe pas déjà
                echo("FCT load_data_lang_plus: Eelement LANG existe déjà : " . $nom . " > " . $code);
	            echo("<hr>");
			}
		}
		$datas_lang[$code]=$valeur;
	
	}
	
} // function load_data_lang_plus

function pre_load_data_lang_plus($chemin) {
    
    global $thisSite;
    
	$datas_lang=array();
	if($thisSite->current_lang!="") {
		if(file_exists($chemin . "/lang/" . $thisSite->current_lang .".php")) {
			@include_once($chemin . "/lang/" . $thisSite->current_lang .".php"); 
		}
	}
	return $datas_lang;
}


?>