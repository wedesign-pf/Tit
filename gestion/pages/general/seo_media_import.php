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
	$resultat.="<td >Fichier</td>";
	$resultat.="<td >Erreur(s)</td>";
	$resultat.="</tr></thead><tbody>";
	
	$handle = fopen($fic, "r");
	while (($ligne = fgetcsv($handle, 100000, $sep_champs)) !== FALSE) {	
	
		$cpt = $cpt+1; // pour etre juste
		
		if($cpt<=$cpt_entete) { continue; }
		
		$ligne = str_replace("\"", "\'", $ligne);
		
		$field_media="";
		$id_parent="";
		$id="";
		$lg="";
		$type="";
		$fichier="";
		$legende="";
		
		$field_media=addslashes($ligne[0]);
		$id_parent=addslashes($ligne[1]);
		$id=addslashes($ligne[2]);
		$lg=addslashes($ligne[3]);
		$type=addslashes($ligne[4]);
		$fichier=addslashes($ligne[5]);
		$legende=addslashes(utf8_encode($ligne[6]));

		$msg_erreur="";

		if ($msg_erreur!="") { 
			$resultat.="<tr>";
			$cpterr++;
			$resultat.="<tr>";			
			$resultat.="<td align='center' class=\"erreur\"><b>$id</b></td>";
			$resultat.="<td >$fichier &nbsp;</td>";
			$resultat.="<td class=\"erreur\">$msg_erreur</td>";
			$resultat.="</tr>";
		} else {
			if($_POST["majok"]=="1") {

                $myUpdate = new myUpdate(__FILE__);
                $myUpdate->table=$thisSite->PREFIXE_TBL_GEN . "medias";
                $myUpdate->field["titre_media"]=$legende;
                $myUpdate->where="id=" . $id  . " AND lg='" . $lg . "'";
                $result = $myUpdate->execute();

				if ($result=="1") {
					$resultat.="<tr>";			
					$resultat.="<td align='center'>$id</td>";
					$resultat.="<td >$fichier &nbsp;</td>";
					$resultat.="<td class=\"ok\">OK</td>";
					$resultat.="</tr>";
				   $cptok++;
				} else {
					$resultat.="<tr>";			
					$resultat.="<td align='center'>$id</td>";
					$resultat.="<td >$fichier &nbsp;</td>";
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