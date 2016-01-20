<?php
$pathBatch="../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php
$lg=str_replace("_","",$__POST["newextlg"]);
$myAdmin->LANG_DATAS=$lg;
$_SESSION["myAdmin"] = serialize($myAdmin);
?>