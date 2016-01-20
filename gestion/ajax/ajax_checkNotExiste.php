<?php
$pathBatch="../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php
// récupération données standard
$table=$__GET["table"];
$valOrigin=$__GET["valOrigin"];

end($__GET);
$field = key($__GET);
$valField = $__GET[$field]; 

// champ de la base de donnée: on enleve l'extension langue du champ si existe
if(in_array(substr($field, strrpos($field,"_")),$myAdmin->LIST_LANG_EXTENSION_FIELD)) {
	$BdDfield=substr($field, 0 , strrpos($field,"_"));
} else {
	$BdDfield=$field;
}
		
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$table;
$mySelect->fields="id," . $BdDfield;
$mySelect->where=$BdDfield . "='" . addslashes($valField) . "' AND " . $BdDfield . "!='" . addslashes($valOrigin) . "'";
$qt=$mySelect->count();

if($qt>0) {
	echo("false");	
} else {
	echo("true");	
}
?>