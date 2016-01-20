<?php
$fichier_php = implode("/",$thisSite->current_tab_paths);

$script_php=get_path($fichier_php,0); 
if($script_php=="") {	$script_php=get_path_pages($fichier_php,0);  }
if($script_php=="") {	$script_php=$fichier_php;  } 

if(!file_exists($script_php) || $script_php=="" ) {	
	$thisSite->current_scriptPHP=get_path_pages("404.php",0);
    config_404("index-php.php: page_php inconnue: " . $thisSite->RACINE . $script_php);
} else {

    $thisSite->current_scriptPHP=$script_php;
}

$thisSite->current_scriptTPL=remove_extension($thisSite->current_scriptPHP) . ".tpl"; 

include_once($thisSite->DOS_BASE_INIT . "init_commun.php"); // initialisation commune à tout les types de page

include($thisSite->current_scriptPHP);

$smarty->assign("thisSite", $thisSite);

$_SESSION["thisSite"] = serialize($thisSite);

if(file_exists($thisSite->current_scriptTPL)) {	
    $smarty->display($thisSite->current_scriptTPL);
} 

?>