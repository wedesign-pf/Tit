<?php
$pathBatch="../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php

if(!isset($__GET['table'])) { exit; }
if(!isset($__GET['field'])) { exit; }
if(!isset($__GET['id'])) { exit; }
if(!isset($__GET['checked'])) { exit; }
if(!isset($__GET['update'])) { exit; }

if($__GET['checked']=="true") { $val=1; } else { $val=0; }

$myUpdate = new myUpdate(__FILE__);
$myUpdate->table=$__GET['table'];
$myUpdate->field[$__GET['field']]=$val;
$myUpdate->where="id=" . $__GET['id'];
$result=$myUpdate->execute();

// on gère l'ACTIF dans les pages si l'élément existe
if($__GET['field']=="actif" && $__GET['table']!=$thisSite->PREFIXE_TBL_GEN . "pages" ) {
	$myUpdate = new myUpdate(__FILE__);
	$myUpdate->table=$thisSite->PREFIXE_TBL_GEN . "pages";
	$myUpdate->field["actif"]=$val;
	$myUpdate->where="article_tableId='" . $__GET['table'] . "." . $__GET['id'] . "'";
	$result=$myUpdate->execute();	
}
// on gère l'ACTIF dans les tables annexes si on est dans la gestion des pages
if($__GET['field']=="actif" && $__GET['table']==$thisSite->PREFIXE_TBL_GEN . "pages" ) {
	
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
	$mySelect->fields="article_tableId";
	$mySelect->limit=1;
	$mySelect->where="id=:id_page";
	$mySelect->whereValue["id_page"]=array($__GET['id'],PDO::PARAM_INT);
	$result=$mySelect->query();
	$row = current($result);
	
	if($row["article_tableId"]!="") {
		list($article_table,$article_id)=explode(".", $row["article_tableId"]);
		$myUpdateA = new myUpdate(__FILE__);
		$myUpdateA->table=$article_table;
		$myUpdateA->field["actif"]=$val;
		$myUpdateA->where="id=:id";
		$myUpdateA->whereValue["id"]=array($article_id,PDO::PARAM_INT);
		$resultA=$myUpdateA->execute();	
	}
}

	
if($__GET['update']>0) {
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$__GET['table'];
	$mySelect->fields=$__GET['field'];
	if($__GET['where']=="") {		
		$mySelect->where=$__GET['field'] . "=1";
	} else {
		$mySelect->where= $__GET['where'] .  " AND " . $__GET['field'] . "=1";
	}
	$countTrue=$mySelect->count();
	if($countTrue<$__GET['update'] || $countTrue==0 ) {
		echo("1");
	} else {
		echo("0");
	}

} else {
	echo("1");
}
?>

