<?php
$filtres=$myAdmin->getDatasPage("Filtres");
$filtresOrigine=$filtres; // pour controle

if(is_array($filtres)) {
	foreach ($filtres as $k => $v) {
		${$k}=$v;
	}
} else {
	$filtres=array();
}

if($__POST["Filtres"]=="1") {
	foreach ($__POST as $k => $v) {
		if(strpos($k, "F__") === 0) {
			//if($__POST["F_niveau0"]!=$Filtres["F_niveau0"]) { $__POST["F_niveau1"]=""; }
			${$k}=$v;
			$filtres[$k]=$v;
		}
	}

	$myAdmin->setDatasPage("Filtres",$filtres);
}
$smarty->assign("filtres", 1);
?>