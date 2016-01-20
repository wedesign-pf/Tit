<?php
$pathAjax="../../";
include($pathAjax  . "init_pages/" . "ajax.php");
?>
<?php
if(!isset($__GET['folder'])) { exit; }
if(!isset($__GET['file'])) { exit; }

$fic=$__GET['folder'] . $__GET['file'];

$nom_fic=get_nom_fichier($fic);

$fic = str_replace(" ", "%20", $fic);
$fic = str_replace("http", "", $fic);
$fic = str_replace("ftp", "", $fic);

$fic= "../../../" . $fic;

if(file_exists($fic)){

	$extension_nom_fic=get_extension($nom_fic);
	$extension=get_extension($fic);

	if(!in_array($extension_nom_fic,$myAdmin->extentionsOk )) { exit; }
	if(!in_array($extension,$myAdmin->extentionsOk )) { exit; }

	header('Content-Description: File Transfer');
	header("Pragma:  public");
	header("Expires: 0");
	header('Cache-Control: must-revalidate');
	header("Content-Type: application/octet-stream\n");
	header("Content-Length: ".filesize($fic)."\n");
	header("Content-Disposition: attachment; filename=" . $nom_fic ."\n");
	header('Content-Transfer-Encoding: binary');

	ob_clean();
	flush();
	readfile($fic);
	exit;
	
} else {
	exit;
}
?>