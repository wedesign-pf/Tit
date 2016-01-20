<?php
$racine_smarty=$pathIframe . "../";
include_once($pathIframe . "../init.php"); 

include_once($pathIframe . "config_admin.php"); 
include_once($pathIframe . DOS_INC_ADMIN . "class.form.php"); 
include_once($pathIframe . DOS_INC_ADMIN . "class.field.php");

// initialisation de la langue
include($pathIframe . DOS_BASE_ADMIN . "lang/" . $myAdmin->LANG_INTERFACE .".php");
$smarty->assign("datas_lang", $datas_lang);
?>