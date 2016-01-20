<?php 
if(count($thisSite->current_tab_paths)>$thisSite->NB_NIVEAUX_ARBO) {
    config_404("index-nophp.php: count(" . $thisSite->current_tab_paths . ")>NB_NIVEAUX_ARBO");
}
//////////////////////////////////////////////// 
// SI LE CHEMIN et lA LANGUE SONT OK:::::
//
// RAZ Données spécifiques à la page
$thisSite->current_rub="";
$thisSite->current_srub="";
$thisSite->current_ssrub="";
$thisSite->current_typePage="";
$thisSite->current_scriptPHP="";
$thisSite->current_scriptTPL="";
$thisSite->current_scriptJS="";
$thisSite->current_data=array();
$thisSite->page=array();
$thisSite->erreur404="";
$thisSite->pubDejaPresenteDansLaPage="";

// gestion Niveau RUBRIQUE
$boucleNiveaux=array($thisSite->current_tab_paths[0],"404");
foreach ($boucleNiveaux as $niveau) { 
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
	$mySelect->fields="*";
	$mySelect->where="page_url=:page_url AND actif=1 AND lg=:lg";
	$mySelect->whereValue["page_url"]=array($niveau,PDO::PARAM_STR);
	$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
	$result=$mySelect->query();
	if(count($result)>0) { break; } // si trouvé on quitte la boucle
}
$row = current($result); 

if($row["page_url"]=="404") {
	config_404("index-nophp.php: Niveau rub inconnu");
}

$thisSite->current_rub = stripslashes($row["id"]);
$thisSite->current_typePage=$row["page_type"];
$thisSite->current_scriptPHP = $row["page_php"];
$thisSite->current_scriptTPL = $row["page_tpl"];

// Gestion niveau SOUS RUBRIQUE
if($thisSite->current_tab_paths[1]!="") {
    $boucleNiveaux=array($thisSite->current_tab_paths[1]); //,"404"
    foreach ($boucleNiveaux as $niveau) { 
        $mySelect = new mySelect(__FILE__);
        $mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
        $mySelect->fields="*";
        $mySelect->where="page_url=:page_url AND actif=1 AND lg=:lg";
        $mySelect->whereValue["page_url"]=array($niveau,PDO::PARAM_STR);
        $mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
        $result=$mySelect->query();
        if(count($result)>0) { break; } // si trouvé on quitte la boucle
    }   
         
    $row = current($result); 

    if($row["page_url"]=="404") {
       config_404("index-nophp.php: Niveau Srub inconnu");
    }
    
    $thisSite->current_srub = stripslashes($row["id"]);
    if($row["page_php"]!="") { $thisSite->current_scriptPHP = stripslashes($row["page_php"]); }
    if($row["page_tpl"]!="") { $thisSite->current_scriptTPL = stripslashes($row["page_tpl"]); }
    if($row["page_type"]!="") { $thisSite->current_typePage=stripslashes($row["page_type"]);}


} // FIN Gestion niveau SOUS RUBRIQUE

// Gestion niveau SOUS SOUS RUBRIQUE
if($thisSite->current_tab_paths[2]!="") {
    $boucleNiveaux=array($thisSite->current_tab_paths[2]); //,"404"
    foreach ($boucleNiveaux as $niveau) { 
        $mySelect = new mySelect(__FILE__);
        $mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
        $mySelect->fields="*";
        $mySelect->where="page_url=:page_url AND actif=1 AND lg=:lg";
        $mySelect->whereValue["page_url"]=array($niveau,PDO::PARAM_STR);
        $mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
        $result=$mySelect->query();
        if(count($result)>0) { break; } // si trouvé on quitte la boucle
    }   
    
	$row = current($result); 

    if($row["page_url"]=="404") {
        config_404("index-nophp.php: Niveau SSrub inconnu");
    }
    
    $thisSite->current_ssrub = stripslashes($row["id"]);
    if($row["page_php"]!="") { $thisSite->current_scriptPHP = stripslashes($row["page_php"]); }
    if($row["page_tpl"]!="") { $thisSite->current_scriptTPL = stripslashes($row["page_tpl"]); }
    if($row["page_type"]!="") { $thisSite->current_typePage=stripslashes($row["page_type"]);}

} // FIN Gestion niveau SOUS RUBRIQUE

// facilite l'acces aux infos de la page en cours
if($thisSite->current_srub=="" ) { 
    $thisSite->idPage=$thisSite->current_rub;
} else if($thisSite->current_ssrub=="" ) {  
    $thisSite->idPage=$thisSite->current_srub;
} else if($thisSite->current_ssrub!="" ) {
    $thisSite->idPage=$thisSite->current_ssrub;  
}	
$thisSite->page=$thisSite->pages[$thisSite->idPage];
////////////

if($thisSite->current_scriptPHP=="") {
    $thisSite->current_scriptPHP="404.php";
    config_404("index-nophp.php: page_php==''");
}


$fichier_php=get_path_pages($thisSite->current_scriptPHP,0);
if($fichier_php=="") { $thisSite->current_scriptTPL=""; }

// Templating
if($thisSite->current_scriptTPL=="") { 		
    $thisSite->current_scriptTPL=remove_extension($fichier_php) . ".tpl"; 
} else { 
    $thisSite->current_scriptTPL=get_path_pages($thisSite->current_scriptTPL,0);
}

$my_cache_id = $thisSite->current_lang . "_" . implode($thisSite->current_tab_paths,"_");
$my_cache_id = md5($my_cache_id);

if($thisSite->current_scriptTPL=="") {
    $isCached=0;
} else {
    $isCached=$smarty->isCached($thisSite->current_scriptTPL,$my_cache_id);
}

// Ne pas mettre plus loin
$smarty->assign("thisSite", $thisSite);
           
if($isCached==0) {

    $datas_page=array();
  
    include_once($thisSite->DOS_BASE_INIT . "init_commun.php"); // initialisation commune à tout les types de page
    @include_once($thisSite->DOS_BASE_INIT . $thisSite->current_typePage . ".php"); // initialisation suivant le type de page

    $obj_module = new module("_loaders",$thisSite->current_typePage);
    $obj_module->load();

    if($fichier_php!="") { 
        if(file_exists($fichier_php)) { include($fichier_php);   }
    }	

    $smarty->assign("datas_page",$datas_page);  

}


// Permet d'éviter les doublons dans le HTML
$PAGE_css_client=$smarty->getTemplateVars("PAGE_css_client");
if(is_array($PAGE_css_client)) { $smarty->assign("PAGE_css_client",array_unique($PAGE_css_client)); }

$PAGE_js_client=$smarty->getTemplateVars("PAGE_js_client");
if(is_array($PAGE_js_client)) { $smarty->assign("PAGE_js_client",array_unique($PAGE_js_client)); }

$PAGE_type_action=$smarty->getTemplateVars("PAGE_head");
if(is_array($PAGE_type_action)) { $smarty->assign("PAGE_head",array_unique($PAGE_type_action)); }
$PAGE_type_action=$smarty->getTemplateVars("PAGE_javascript");
if(is_array($PAGE_type_action)) { $smarty->assign("PAGE_javascript",array_unique($PAGE_type_action)); }
$PAGE_type_action=$smarty->getTemplateVars("PAGE_doc_ready");
if(is_array($PAGE_type_action)) { $smarty->assign("PAGE_doc_ready",array_unique($PAGE_type_action)); }
$PAGE_type_action=$smarty->getTemplateVars("PAGE_win_load");
if(is_array($PAGE_type_action)) { $smarty->assign("PAGE_win_load",array_unique($PAGE_type_action)); }
$PAGE_type_action=$smarty->getTemplateVars("PAGE_footer");
if(is_array($PAGE_type_action)) { $smarty->assign("PAGE_footer",array_unique($PAGE_type_action)); }

if(!file_exists($thisSite->current_scriptTPL)) { $thisSite->current_scriptTPL="";	}

// Script JS associé à la page
$fichier_js=remove_extension($thisSite->current_scriptPHP) . ".js"; 

if(file_exists($thisSite->DOS_CLIENT . "js/" . $fichier_js)) {
    $thisSite->current_scriptJS=$thisSite->DOS_CLIENT . "js/" . $fichier_js;
}

$structure_page=$thisSite->DOS_BASE_TEMPLATES . $thisSite->current_typePage . ".tpl";

$_SESSION["thisSite"] = serialize($thisSite);
       
if(file_exists($structure_page)) {
    $smarty->display($structure_page,$my_cache_id);
} 
		
?>