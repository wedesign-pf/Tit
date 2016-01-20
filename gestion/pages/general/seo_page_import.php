<?php
$actionsPage=array("appliquer");
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php

$cpt_entete="1";
$sep_champs=";";

$fic=$_FILES['fichier']['tmp_name'];

if( $fic!="") {
	
	$cptok=0;
	$cpterr=0;
	$cpt=0;
	$resultat="<div id='tableList'  class='plrm'>";
	$resultat.="<div>ERREURS A L'INTEGRATION</div>";
	$resultat.="<table class='' border='1' cellpadding='3' cellspacing='0'>";
	$resultat.="<thead><tr>";	
	$resultat.="<td class='w10' align='center'>id</td>";
	$resultat.="<td >titre_menu</td>";
	$resultat.="<td >Erreur(s)</td>";
	$resultat.="</tr></thead><tbody>";
	
	$handle = fopen($fic, "r");
	while (($ligne = fgetcsv($handle, 100000, $sep_champs)) !== FALSE) {	
	
		$cpt = $cpt+1; // pour etre juste
		
		if($cpt<=$cpt_entete) { continue; }
		
		$ligne = str_replace("\"", "\'", $ligne);
		
		$id="";
		$lg="";
		$page_lien="";
		$titre_menu="";
		$titre_page="";
		$tag_title="";
		$tag_keywords="";
		$tag_description="";
		$sitemap_changefreq="";
		
		$id=addslashes($ligne[0]);
		$lg=addslashes($ligne[1]);
		$page_url=addslashes($ligne[2]);
		$titre=addslashes(utf8_encode($ligne[3]));
		$page_titre=addslashes(utf8_encode($ligne[4]));
		$page_tag_title=addslashes(utf8_encode($ligne[5]));
		$page_tag_keywords=addslashes(utf8_encode($ligne[6]));
		$page_tag_description=addslashes(utf8_encode($ligne[7]));
		$page_sitemap_changefreq=addslashes($ligne[8]);

		$msg_erreur="";
		
		$page_lien_ctr=full_sanitize_string($page_lien);
		if($page_lien!=$page_lien_ctr) {
			$msg_erreur="Lien invalide: $page_lien > $page_lien_ctr";	
		}

		if ($msg_erreur!="") { 
			$resultat.="<tr>";
			$cpterr++;
			$resultat.="<tr>";			
			$resultat.="<td align='center' class=\"erreur\"><b>$id</b></td>";
			$resultat.="<td >$titre &nbsp;</td>";
			$resultat.="<td class=\"erreur\">$msg_erreur</td>";
			$resultat.="</tr>";
		} else {
			if($_POST["majok"]=="1") {

                $myUpdate = new myUpdate(__FILE__);
                $myUpdate->table=$thisSite->PREFIXE_TBL_GEN . "pages";
                $myUpdate->field["page_url"]=$page_url;
                $myUpdate->field["titre"]=$titre;
                $myUpdate->field["page_titre"]=$page_titre;
                $myUpdate->field["page_tag_title"]=$page_tag_title;
                $myUpdate->field["page_tag_keywords"]=$page_tag_keywords;
                $myUpdate->field["page_tag_description"]=$page_tag_description;
                $myUpdate->field["page_sitemap_changefreq"]=$page_sitemap_changefreq;
                $myUpdate->where="id=" . $id  . " AND lg='" . $lg . "'";
                $result = $myUpdate->execute();

				if ($result=="1") {
					$resultat.="<tr>";			
					$resultat.="<td align='center'>$id</td>";
					$resultat.="<td >$titre &nbsp;</td>";
					$resultat.="<td class=\"ok\">OK</td>";
					$resultat.="</tr>";
				   $cptok++;
				} else {
					$resultat.="<tr>";			
					$resultat.="<td align='center'>$id</td>";
					$resultat.="<td >$titre &nbsp;</td>";
					$resultat.="<td class=\"erreur\">Pb lors de l'Update</td>";
					$resultat.="</tr>";
				   $cpterr++;
				}
			} 
		}
	
	} // fin boucle ligne	
	
	$resultat.="</tbody></table>";
	$resultat.="Total lus: <b>" . ($cpt-$cpt_entete) . "</b><br>"; 
	$resultat.="Total int&eacute;gr&eacute;s: <b>$cptok</b><br>";
	$resultat.="Total non int&eacute;gr&eacute;s : <b>$cpterr</b><br>";
	$resultat.="<hr>"; 
	$resultat.="</div>"; 
	
$smarty->assign("resultat", $resultat);

}
?>
<?php

$fieldMedia = new file();
$fieldMedia->field="fichier";
$fieldMedia->label=$datas_lang["fichier"];
$fieldMedia->multiLangType=false; 
$fieldMedia->browse=false; 
$fieldMedia->add();

$newfield = new radio();
$newfield->field="majok";
$newfield->label=$datas_lang["majBdD"];
$newfield->items=$datas_lang["ouiNon"];
$newfield->defaultValue="0";
$newfield->add();
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>