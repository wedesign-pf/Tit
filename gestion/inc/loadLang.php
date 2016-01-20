<?php
$datas_lang=array();
include(DOS_BASE_ADMIN . "lang/" . $myAdmin->LANG_INTERFACE . ".php");
include(DOS_CLIENT_ADMIN . "lang/" . $myAdmin->LANG_INTERFACE . ".php");
$smarty->assign("datas_lang", $datas_lang);
?>