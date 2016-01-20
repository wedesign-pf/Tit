<?php 
// $pub_force_bandeau : permet de forcer un id d'une bandeau
// $pub_emplacement="1"; indique l'id de l'emplacement à utiliser
// $pub_emplacement_numero="1"; // indique le numéro de l'emplacement (si plusieurs emplacements utilisés sur la même page)
//////////////////////////////////////////////////////////
// EXEMPLE
//$pub_emplacement="1";
//$pub_emplacement_numero="1"; 
//$pub_force_bandeau="1";
//include(get_path_pages("bandeaux.php","")); 
// {$PUBLICITE_11}
//////////////////////////////////////////////////////////
// ordre d'affichage de l'emplacement
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_PUB . "emplacements";
$mySelect->fields="*";
$mySelect->where="id=:id";
$mySelect->whereValue["id"]=array($pub_emplacement,PDO::PARAM_STR);
$result=$mySelect->query();
$row = current($result); 
$hauteur= $row["hauteur"];
$largeur= $row["largeur"];

$date_test=date(Ymd);
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_PUB . "campagnes";
$mySelect->fields="id";
$mySelect->where="( actif=1 AND periode_beg<=" . $date_test . " AND periode_end>=" . $date_test . ")";
$mySelect->where.=" OR ( actif=1 AND periode_beg=0 AND periode_end=0)";
$result=$mySelect->query();
$listBandeaux=array();
foreach($result as $row){ 
	$mySelect1 = new mySelect(__FILE__);
	$mySelect1->tables=$thisSite->PREFIXE_TBL_PUB . "bandeaux";
	$mySelect1->fields="id";
	$mySelect1->where="id_campagne=:id_campagne AND lg=:lg AND actif=1";
	if($pub_force_bandeau!="") {
		$mySelect1->where.=" AND id='" . $pub_force_bandeau . "'";
	}
	$mySelect1->whereValue["id_campagne"]=array($row["id"],PDO::PARAM_INT);
	$mySelect1->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
	
	$result1=$mySelect1->query();
	
	foreach($result1 as $row1){ 
		$listBandeaux[]=$row1["id"];
	}

}

if(!is_array($thisSite->pubDejaPresenteDansLaPage)) { $thisSite->pubDejaPresenteDansLaPage=array(); }
$bandeauChoisi="";
if (count($listBandeaux)>0) {
	 while(count($listBandeaux)>count($thisSite->pubDejaPresenteDansLaPage)) { // vérifie que le bandeau n'est pas déjà présent dans la page
		$key=array_rand($listBandeaux);
		$bandeauChoisi=$listBandeaux[$key];
		if (!in_array($bandeauChoisi, $thisSite->pubDejaPresenteDansLaPage)) {
			$thisSite->pubDejaPresenteDansLaPage[]=$bandeauChoisi;
			break;
		}

	} 
}

if($bandeauChoisi!=="") {

		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$thisSite->PREFIXE_TBL_PUB . "bandeaux";
		$mySelect->fields="*";
		$mySelect->where="id=:id AND lg=:lg";
		$mySelect->whereValue["id"]=array($bandeauChoisi,PDO::PARAM_INT);
		$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
		$result=$mySelect->query();
		$row = current($result); 
	
		$id_campagne=$row["id_campagne"];
		$type_affichage=$row["type_affichage"];
		$couleur_fond=$row["couleur_fond"];
		$image_bandeau=$row["image_bandeau"];
		$script_bandeau=$row["script_bandeau"];
		$lien_destination=$row["lien_destination"];
		$cible_destination=$row["cible_destination"];

		ob_start();
			
			$class_pub="";
			if($type_affichage=="F") { 
				echo("<div id=\"section_pub_" . $pub_emplacement ."\" class=\"section\" style=\"background-color:#" . $couleur_fond . ";\" >"); 
				$class_pub="page";
			}
			echo("<div id=\"pub_" . $pub_emplacement . $pub_emplacement_numero ."\" class=\"" . $class_pub ." type_pub_" . $type_affichage ."\">");
			
			if ($lien_destination!="" ) { 
				$lien= "redirection-pub?id=" . $bandeauChoisi;
				echo("<span style=\"cursor: pointer;\" onclick=\"goTargetLink('$lien','$cible_destination');\">"); 
			}
			if ($image_bandeau!="" ) {
				list($w,$h) = @getimagesize($thisSite->RACINE . $image_bandeau);
				echo("<img src=\"" . $thisSite->RACINE . $image_bandeau . "\" width='$w' height='$h' alt='Pub' />");
			}
			if ($script_bandeau!="" ) {
			 	echo($script_bandeau);
			} 
			if ($lien_destination!="") { echo("</span>"); }
			
			echo("</div>");
			if($type_affichage=="F") { echo("</div>"); }
			
			$temp=ob_get_contents();
			
		ob_end_clean();
		$temp = $temp . "\n\n"; 
		$smarty->assign("PUBLICITE_" . $pub_emplacement . $pub_emplacement_numero ,$temp);
		// MAJ STATS
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$thisSite->PREFIXE_TBL_PUB . "stats";
		$mySelect->where="id_bandeau=:id_bandeau AND aa=:aa AND mm=:mm AND jj=:jj AND lg=:lg";
		$mySelect->whereValue["id_bandeau"]=array($bandeauChoisi,PDO::PARAM_INT);
		$mySelect->whereValue["aa"]=array(date(Y),PDO::PARAM_STR);
		$mySelect->whereValue["mm"]=array(date(m),PDO::PARAM_STR);
		$mySelect->whereValue["jj"]=array(date(d),PDO::PARAM_STR);
		$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);

  	    if ($mySelect->count()==0) {

			$myInsert = new myInsert(__FILE__);
			$myInsert->table=$thisSite->PREFIXE_TBL_PUB . "stats";
			$myInsert->field["id_emplacement"]=$pub_emplacement;
			$myInsert->field["lg"]=$thisSite->current_lang;
			$myInsert->field["id_campagne"]=$id_campagne;
			$myInsert->field["id_bandeau"]=$bandeauChoisi;
			$myInsert->field["aa"]=date(Y);
			$myInsert->field["mm"]=date(m);
			$myInsert->field["jj"]=date(d);
			$myInsert->field["nb_aff"]=1;
			$result=$myInsert->execute();

		} else {

			$myUpdate = new myUpdate(__FILE__);
			$myUpdate->table=$thisSite->PREFIXE_TBL_PUB . "stats";
			$myUpdate->field["nb_aff"]="LITERAL:nb_aff+1";;
			$myUpdate->where="id_bandeau=:id_bandeau AND aa=:aa AND mm=:mm AND jj=:jj AND lg=:lg";
			$myUpdate->whereValue["id_bandeau"]=array($bandeauChoisi,PDO::PARAM_INT);
			$myUpdate->whereValue["aa"]=array(date(Y),PDO::PARAM_STR);
			$myUpdate->whereValue["mm"]=array(date(m),PDO::PARAM_STR);
			$myUpdate->whereValue["jj"]=array(date(d),PDO::PARAM_STR);
			$myUpdate->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
			$result=$myUpdate->execute();
			
		}

} 

// Reset pour la prochaine utilisation
$pub_emplacement="";
$pub_emplacement_numero=""; 
$pub_force_bandeau="";
?>