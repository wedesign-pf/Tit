<?php
// Chargement total element à updater en ligne pour controle
foreach($listCols as $col=>$datasCol){ 
	if($datasCol["update"]>0) {
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$myTable;
		$mySelect->fields=$datasCol["field"];
		if($formList->where=="") {		
			$mySelect->where=$datasCol["field"] . "=1";
		} else {
			$mySelect->where=$formList->where . " AND " . $datasCol["field"] . "=1";
		}
		$countTrue=$mySelect->count();
		$listCols[$col]["countTrue"]=$countTrue;
	}
}
?>
<?php
// recherche des colonnes existant dans la table et qui donc peuvent être utilisé pour le tri par colonne
foreach($listCols as $col=>$datasCol){ 
	if($datasCol["field"]!="") {
		$field=$datasCol["field"];
		$oneDatasList=current($formList->datasList);
		if(isset($oneDatasList[$field]) && !isset($listCols[$col]["orderOk"])) {
			$listCols[$col]["orderOk"]=1;
		}
	}
}
?>