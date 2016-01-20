<?php
$pathAjax="../../";
include($pathAjax  . "init_pages/" . "ajax.php");
?>
<?php
if(!isset($__GET['folder'])) { exit; }
if(!isset($__GET['file'])) { exit; }

$__GET['folder'] = trim($__GET['folder']);
$__GET['file'] = trim($__GET['file']);

$file_extension = "." . get_extension($__GET['file']);
$file_without_extension = basename($__GET['file'], $file_extension);


$smarty->assign("folder", $__GET['folder']);
$smarty->assign("file", $__GET['file']);
$smarty->assign("file_without_extension", $file_without_extension);
$smarty->assign("file_extension", $file_extension);

$smarty->assign("script_tpl", "browse_rename.tpl");

$structure_page= $pathAjax  .  "templates/" . "ajax.tpl";
$smarty->assign("myAdmin", $myAdmin);
$smarty->assign("thisSite", $thisSite);
$smarty->display($structure_page );
?>