<?php
$racine_smarty=$pathBatch . "../";
include_once($pathBatch . "../init.php"); 

include_once($pathBatch . "config_admin.php"); 

// initialisation de la langue
include($pathBatch . DOS_BASE_ADMIN . "lang/" . $myAdmin->LANG_INTERFACE .".php");
$smarty->assign("datas_lang", $datas_lang);
?>