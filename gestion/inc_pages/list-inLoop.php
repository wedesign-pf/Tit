<?php
// chargement des données qui viennent de la table (si existe)

//if(in_array("move", $actionsPage)) { $listChronos[$datas["id"]]=$datas["chrono"]; }

foreach($listCols as $col=>$datasCol){ 
	if($datasCol["field"]!="") {
	$field=$datasCol["field"];
	
	if(is_array($datasCol["assValues"])) { // si valeur associée définie (exemple: "assValues"=>array("1"=>"Oui","0"=>"Non"))
		$val=$datasCol["assValues"][$datas[$field]];
	} else {
		$val=$datas[$field];
	}
	
	if($datasCol["action"]=="image" || $datasCol["action"]=="file" || $datasCol["action"]=="link" || $datasCol["action"]=="video") {
		$requetex="SELECT count(id) AS cpt FROM " .  $thisSite->PREFIXE_TBL_GEN . "medias" . " WHERE field_media='" . $field . "' AND id_parent='" . $datas["id"] . "' AND lg='" . $myAdmin->LANG_DEF . "'";
		$resultx = $PDO->free_requete($requetex);
		$rowx = $resultx->fetch();
		if($rowx["cpt"]>"0") { $val="(" . $rowx["cpt"] . ")"; }
	}
		
	$valeurs[$field]=$val;
	
	}
} // foreach($listCols
?>
<?php

$valeurs["arrowsMove"]=arrowsMove($myTable,$formList->whereFull,$datas["chrono"]);
?>
<?php
// chargement du nombre de média
// ???????????????????????????????????????????????????????
//foreach($listCols as $col=>$datasCol){ 
//	if($datasCol["field"]!="media") { continue; }
//
//} // foreach($listCols
?>