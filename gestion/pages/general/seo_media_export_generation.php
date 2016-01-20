<?php
include_once("../../../init.php"); 

include_once("../../config_admin.php"); 

include("../../" . DOS_INC_ADMIN . "controle_login.php");
?>
<?php  
if (session_id() == "") session_start();
if ( isset($_POST) ) { foreach ($_POST as $k => $v) { ${$k} =  $v; } }
if ( isset($_GET) )	{ foreach ($_GET as $k => $v) { ${$k} =  $v; } }

// Initialisation;
$datas=array();
$bad_chars = array("\t", "\n", "\r");
$sep="\t";

// LIGNE D'ENTETE
$texte="";
$texte.="field" . $sep;
$texte.="id parent" . $sep;
$texte.="id" . $sep;
$texte.="lg" . $sep;
$texte.="type" . $sep;
$texte.="fichier" . $sep;
$texte.="legende";
$texte.="\n";

// RUBRIQUES
$result_lot = $PDO->free_requete("SELECT * FROM " . $thisSite->PREFIXE_TBL_GEN . "medias" . " WHERE actif=1 ORDER BY id ASC");

	foreach($result_lot as $enr){

	$field_media=stripslashes($enr["field_media"]);
    $id_parent=stripslashes($enr["id_parent"]);
    $id=stripslashes($enr["id"]);
	$lg=stripslashes($enr["lg"]);
	$type=stripslashes($enr["type"]);
	$fichier=stripslashes($enr["fichier_media"]);
	$legende=stripslashes($enr["titre_media"]);
  	
	$ligne="";
	$ligne.=$field_media . $sep;
	$ligne.=$id_parent . $sep;
	$ligne.=$id . $sep;
	$ligne.=$lg . $sep;
	$ligne.=$type . $sep;
	$ligne.=$fichier . $sep;
	$ligne.=$legende;
	$ligne.="\n";

	$datas[] = $ligne;
	
}		

foreach ($datas as $k => $data) { 
	$texte.=$data;

}


//$texte=str_replace(";",",",$texte); // pour éviter les mauvaises colonnes
//$texte=str_replace($sep,";",$texte);
		
header("Content-type: application/vnd.ms-excel; charset=utf-8");
$nom_fichier="export_seo_medias-" . date("y-m-d");
header('Content-disposition: attachment; filename="' . $nom_fichier . '.xls"');

echo utf8_decode($texte);
?>