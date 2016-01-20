<?php 
include_once("init.php");

$fic= $__GET["fic"];

$nom_fic=get_nom_fichier($fic);
$nom = full_sanitize_string($nom_fic);

$fic20 = str_replace(" ", "%20", $fic);
$fic = str_replace("http", "", $fic);
$fic = str_replace("ftp", "", $fic);

if(file_exists($fic)){

	$extension_nom_fic=get_extension($nom_fic);
	$extension=get_extension($fic);
	
	if(!in_array($extension_nom_fic,$thisSite->UPLOAD_EXTENSIONS)) { exit; }
	if(!in_array($extension,$thisSite->UPLOAD_EXTENSIONS)) { exit; }

	header('Content-Description: File Transfer');
	header("Pragma:  public");
	header("Expires: 0");
	header('Cache-Control: must-revalidate');
	header("Content-Type: application/octet-stream\n");
	header("Content-Length: ".filesize($fic)."\n");
	header("Content-Disposition: attachment; filename=" . $nom ."\n");
	header('Content-Transfer-Encoding: binary');

	ob_clean();
	flush();
	readfile($thisSite->RACINE . $fic20);
	exit;
	
} else {
	exit;
}
?>