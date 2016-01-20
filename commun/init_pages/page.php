<?php
if(@$come_by_index!=1) { echo("passer par devant. merci.");	exit; } // sécurité si appel du script PHP sans passer par l'index

if(is_IE6() || is_IE7() || is_IE8()) { 
	$old_IE = "<script type='text/javascript'>alert(\"" . $datas_lang['old_IE'] . "\");</script>";
} 
$smarty->assign("PAGE_old_IE", $old_IE);

if(is_array($thisSite->chronoPages)) { $last_page=end($thisSite->chronoPages); }
$current_page=$thisSite->current_rub . "," . $thisSite->current_srub. "," . $thisSite->current_ssrub;
if($last_page!=$current_page) {
	$thisSite->chronoPages[]=$current_page;
}

// pour tester une skin
if ($__GET["skintest"] !="" ) { $thisSite->skin = $thisSite->DOS_CLIENT_SKIN . $__GET["skintest"] ."/"; } 
?>
