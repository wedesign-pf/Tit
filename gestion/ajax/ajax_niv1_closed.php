<?php
$pathBatch="../";
?>
<?php
$racine_smarty=$pathBatch . "../";
include_once($pathBatch . "../init.php"); 
include_once($pathBatch . "config_admin.php"); 
?>
<?php
$n1=substr($__POST['n1'],3);
$myAdmin->niv1Closed[$n1]=$__POST['closed'];
$_SESSION["myAdmin"] = serialize($myAdmin);
?>