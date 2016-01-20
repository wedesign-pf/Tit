<?php
include_once("../../../init.php"); 

include_once("../../config_admin.php"); 

include("../../" . DOS_INC_ADMIN . "controle_login.php");

//$actionsPage=array("");
//include(DOS_INCPAGES_ADMIN  . "defaut-init.php");
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
$texte.="id" . $sep;
$texte.="lg" . $sep;
$texte.="Lien page" . $sep;
$texte.="Titre menu" . $sep;
$texte.="Tire page" . $sep;
$texte.="TAG Title" . $sep;
$texte.="TAG Keywords" . $sep;
$texte.="TAG Description" . $sep;
$texte.="Sitemap Freq";
$texte.="\n";

$controle_type="";
$sep2="";
foreach ($thisSite->PAGES_FULL as $p) { 
	$controle_type.=$sep2 . "page_type='" . $p . "'";
	$sep2=" OR ";
} 

// RUBRIQUES
$result_lot = $PDO->free_requete("SELECT * FROM " . $thisSite->PREFIXE_TBL_GEN . "pages" . " WHERE actif=1 AND (" . $controle_type . ") ORDER BY id ASC");

	foreach($result_lot as $enr){

	$id=stripslashes($enr["id"]);
	$lg=stripslashes($enr["lg"]);
	$titre=stripslashes(str_replace($bad_chars, ' - ', $enr["titre"]));
	$titre_page=stripslashes(str_replace($bad_chars, ' - ', $enr["page_titre"]));
	$tag_title=stripslashes(str_replace($bad_chars, ' - ', $enr["page_tag_title"]));
	$tag_keywords=stripslashes(str_replace($bad_chars, ' - ', $enr["page_tag_keywords"]));
	$tag_description=stripslashes(str_replace($bad_chars, ' - ', $enr["page_tag_description"]));
	$page_url=stripslashes($enr["page_url"]);
	$sitemap_changefreq=stripslashes($enr["page_sitemap_changefreq"]);
  	
	$ligne="";
	$ligne.=$id . $sep;
	$ligne.=$lg . $sep;
	$ligne.=$page_url . $sep;
	$ligne.=$titre . $sep;
	$ligne.=$titre_page . $sep;
	$ligne.=$tag_title . $sep;
	$ligne.=$tag_keywords . $sep;
	$ligne.=$tag_description . $sep;
	$ligne.=$sitemap_changefreq;
	$ligne.="\n";

	$datas[] = $ligne;
	
}		

foreach ($datas as $k => $data) { 
	$texte.=$data;

}


//$texte=str_replace(";",",",$texte); // pour éviter les mauvaises colonnes
//$texte=str_replace($sep,";",$texte);
		
header("Content-type: application/vnd.ms-excel; charset=utf-8");
$nom_fichier="export_seo_pages-" . date("y-m-d");
header('Content-disposition: attachment; filename="' . $nom_fichier . '.xls"');

echo utf8_decode($texte);
?>