<?php
include(DOS_INC_ADMIN . "controle_login.php");
$typePage="";

if(@$come_by_index!=1) { echo("passer par devant. merci.");	exit; } // sécurité si appel du script PHP sans passer par l'index

$myAdmin->setChronoPages();

$myAdmin->setDatasPage("myTable",$myTable);

$reloadLangue=false;
$smarty->assign("reloadLangue", $reloadLangue);
$smarty->assign("typePage", $typePage);
$smarty->assign("actionsPage", $actionsPage);

?>