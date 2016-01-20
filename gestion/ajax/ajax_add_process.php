<?php
$pathBatch="../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "tags";
$newID=$PDO->getNextID($myTable);
//echoa($__POST);
$first_titre="";
foreach($myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extlg){ 
//echoa($clg);
	$titre= $__POST["newtag" . $extlg];
	if($titre!="") {
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$myTable;
		$mySelect->fields="id," . $BdDfield;
		$mySelect->where="titre='" . addslashes($titre) . "'";
		$qt=$mySelect->count();
		if($qt==0) {
			$myInsert = new myInsert(__FILE__);
			$myInsert->table=$myTable;
			$myInsert->field["id"]=$newID;
			$myInsert->field["lg"]=$clg;
			$myInsert->field["parent"]=$__POST["field"];
			$myInsert->field["titre"]=$titre;
			$lastId=$myInsert->execute();
			if($first_titre=="") { $first_titre=$titre; }
		} else {
			$lastId=0;
		}
	}
}
echo json_encode(['lastId' => $lastId,'titre' => $first_titre]);
?>