<?php
$pathAjax="../";
include($pathAjax  . "init_pages/" . "ajax.php");
?>
<?php

if(!isset($__GET['id'])) { exit; }

$resultx = $PDO->free_requete("SELECT lien FROM " . $thisSite->PREFIXE_TBL_ADM . "niveaux2" . " WHERE id=" . $__GET['id']  );
$rowx = $resultx->fetch();
$fichier_origine=$rowx["lien"];
$smarty->assign("fichier_origine", $fichier_origine);

$lDirs=array();
$lDirs[str_replace("/","",DOS_CLIENT_ADMIN) . "/pages"]="Client";
$repertoire=$pathAjax. DOS_BASE_ADMIN . "pages/";
$handle  = @opendir($repertoire); 
while ($file = @readdir($handle)) {
	if ($file != ".." AND $file != "." AND is_dir($repertoire . $file)) { $lDirs["pages/" . $file]=$file; }
}

$newfield = new select();
$newfield->field="dossier_destination";
$newfield->multiLang=false;
$newfield->defaultValue="";
$newfield->widthLabel=6;
$newfield->pathTemplate="../";
$newfield->label=$datas_lang["dossierDestination"];
$newfield->items=$lDirs;
$newfield->add();


$smarty->assign("id", $__GET['id']);
$smarty->assign("script_tpl", "ajax_copie_page.tpl");

$structure_page= $pathAjax  .  "templates/" . "ajax.tpl";
$smarty->assign("myAdmin", $myAdmin);
$smarty->assign("thisSite", $thisSite);

$smarty->display($structure_page );
?>