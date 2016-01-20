<?php
$pathAjax="../../";
include($pathAjax  . "init_pages/" . "ajax.php");
?>
<?php
if(!isset($__GET['folder'])) { exit; }

$smarty->assign("folder", trim($__GET['folder']));

$smarty->assign("script_tpl", "create_folder.tpl");

$structure_page= $pathAjax  .  "templates/" . "ajax.tpl";
$smarty->assign("myAdmin", $myAdmin);
$smarty->assign("thisSite", $thisSite);
$smarty->display($structure_page );
?>