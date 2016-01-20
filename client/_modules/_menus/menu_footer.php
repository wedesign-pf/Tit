<?php
$menu="footer";
$menuPages =$thisSite->menus[$menu];
/////////////////////////////////////////////////
foreach($menuPages as $idRUB=>$listSRUB) {

	$datasRUB = $thisSite->pages[$idRUB];

	$RUBS=array();
	$RUBS["id"]=$idRUB;
    $RUBS["classLI"]=$datasRUB["classLI"];
	$RUBS["classA"]=$datasRUB["classA"];
	$RUBS["lien"]=$datasRUB["page_url_menu"][$menu];
	$RUBS["titre"]=$datasRUB["titre"];

	add_plan_du_site($menu,$idRUB,$lienRub,$datasRUB["titre"],$SRUBS);

	$smarty->append("RUBSBas",$RUBS);

}
?>