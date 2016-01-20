<?php
$racine_smarty=$pathAjax . "../";
include_once($pathAjax . "../init.php"); 

include_once($pathAjax . "config_admin.php"); 
include_once($pathAjax . DOS_INC_ADMIN . "class.form.php"); 
include_once($pathAjax . DOS_INC_ADMIN . "class.field.php");
//include(DOS_INC_ADMIN . "controle_login.php");

// initialisation de la langue
include($pathAjax . DOS_BASE_ADMIN . "lang/" . $myAdmin->LANG_INTERFACE .".php");
$smarty->assign("datas_lang", $datas_lang);
?>