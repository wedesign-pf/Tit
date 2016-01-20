<?php

// test si jjmmaa est valide
function test_date($jj,$mm,$aa) {
	if (!is_unsigned_integer($jj) || !is_unsigned_integer($mm) || !is_unsigned_integer($aa) ) { return false; }
	$aaaa = "20" . $aa;
	if (checkdate(intval($mm), intval($jj), intval($aaaa))) { return true; } 
	return false; 
}

// ajoute des jours à une date au format "aammjj"
function add_jours($date,$plus) { 
	$jj = get_jour($date);
	$mm = get_mois($date);
	$aa = get_annee($date);
	$dateplus = date("ymd", mktime(0, 0, 0, $mm, $jj+$plus,  $aa));
	return $dateplus;
}

// écart de jours entre 2 dates
function ecart_dates ($date1,$date2) {
	
	if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
		
		$jj1 = get_jour($date1);
		$mm1 = get_mois($date1);
		$aa1 = get_annee($date1);
	
		$jj2 = get_jour($date2);
		$mm2 = get_mois($date2);
		$aa2 = get_annee($date2);
	
		$dd='20' . $aa1 . '-' . $mm1 . '-' . $jj1 . ' 20:30:00';
		$df='20' . $aa2 . '-' . $mm2 . '-' . $jj2 . ' 20:30:00';
	
		$d1 = new DateTime($dd);
		$d2 = new DateTime($df);
		$diff = $d1->diff($d2);
		
		$nb_jours = $diff->d; 
		
		return $nb_jours;

	} else {
		
		$jj1 = get_jour($date1);
		$mm1 = get_mois($date1);
		$aaaa1 = get_annee($date1);
			
		if(strlen($date1)==6) {
			$aaaa1="20".$aa1;
		} 
		
		$jj2 = get_jour($date2);
		$mm2 = get_mois($date2);
		$aaaa2 = get_annee($date2);
			
		if(strlen($date2)==6) {
			$aaaa2="20".$aa2;
		}
	
	
		$diff = mktime(0, 0, 0, $mm2, $jj2, $aaaa2) - mktime(0, 0, 0, $mm1, $jj1, $aaaa1);
	
		$nb_jours =($diff / 86400); 
		
		return $nb_jours;
	}

}



// retourne le jour d'une date aammjj ou aaaammjj
function get_jour($date) {
	if(strlen($date)==6) { return substr($date,4,2); }
	if(strlen($date)==8) { return substr($date,6,2); }
	return 0;
}
// retourne le mois d'une date aammjj ou aaaammjj
function get_mois($date) {
	if(strlen($date)==6) { return substr($date,2,2); }
	if(strlen($date)==8) { return substr($date,4,2); }
	return 0;
}
// retourne l'année d'une date aammjj ou aaaammjj
function get_annee($date) {
	if(strlen($date)==6) { return substr($date,0,2); }
	if(strlen($date)==8) { return substr($date,0,4); }
	return 0;
}

// aammjj > jj/mm/aaaa ou  aaaammjj > jj/mm/aaaa
function format_date($date, $sep="/") { 

	if ($date=="" || $date=="0") return "";
	if(strlen($date)==6) {
	return substr($date,4,2) . $sep . substr($date,2,2) . $sep . "20" . substr($date,0,2) ;	
	} 
	if(strlen($date)==8) {
		return substr($date,6,2) . $sep . substr($date,4,2) . $sep . substr($date,0,4) ;
	}
	return 0;
}

// jj/mm/aaaa > aammjj  ou jj/mm/aaaa > aaaammjj
function deformat_date($date) { 
	if ($date=="" || $date=="0") return "";
	if(strlen($date)==6) {
		return substr($date,8,2) . substr($date,3,2) . substr($date,0,2) ;	
	}
	if(strlen($date)==8) {
		return substr($date,6,4) . substr($date,3,2) . substr($date,0,2) ;
	}
	return 0;
}


// aammjj > jour jj mois aaaa
function format_datejour($date,$short=0) { 
	global $datas_lang;
	
	if ($date=="" || $date=="0") return "";
	
	if($short==1) {
		$lMois=$datas_lang["mois_short"];
		$lJours=$datas_lang["jours_short"];
	} else {
		$lMois=$datas_lang["mois"];
		$lJours=$datas_lang["jours"];
	}
	
	$jj = get_jour($date);
	$mm = get_mois($date);
	$aa = get_annee($date);
	$jjsem = date("w", mktime(0, 0, 0, $mm, $jj,  $aa));

	return $lJours[$jjsem] . " " . $jj . " " . $lMois[$mm-1] . " " . $aa ;	
}

// aammjj > mois aaaa
function format_datemois($date,$short=0) { 
	global $datas_lang;
	
	if ($date=="" || $date=="0") return "";
	$jj = get_jour($date);
	$mm = get_mois($date);
	$aa = get_annee($date);
	
	if($short==1) {
		$lMois=$datas_lang["mois_short"];
	} else {
		$lMois=$datas_lang["mois"];
	}
	
	return $jj . " " . $lMois[$mm-1] . " " . $aa ;
	
}


// FONCTIONS HEURE
// hhmnss > hh:mn:ss
function format_heure($heure) { 
	if ($heure=="" || $heure=="0") return "";
	return substr($heure,0,2) . ":" . substr($heure,2,2) . ":" . substr($heure,4,2) ;	
}


// retourne le n° de la semaine
function numero_semaine($jour,$mois,$annee) {
    /*
     * Norme ISO-8601:
     * - La semaine 1 de toute année est celle qui contient le 4 janvier ou que la semaine 1 de toute année est celle qui contient le 1er jeudi de janvier.
     * - La majorité des années ont 52 semaines mais les années qui commence un jeudi et les années bissextiles commençant un mercredi en possède 53.
     * - Le 1er jour de la semaine est le Lundi
     */ 
    
    // Définition du Jeudi de la semaine
    if (date("w",mktime(12,0,0,$mois,$jour,$annee))==0) // Dimanche
        $jeudiSemaine = mktime(12,0,0,$mois,$jour,$annee)-3*24*60*60;
    else if (date("w",mktime(12,0,0,$mois,$jour,$annee))<4) // du Lundi au Mercredi
        $jeudiSemaine = mktime(12,0,0,$mois,$jour,$annee)+(4-date("w",mktime(12,0,0,$mois,$jour,$annee)))*24*60*60;
    else if (date("w",mktime(12,0,0,$mois,$jour,$annee))>4) // du Vendredi au Samedi
        $jeudiSemaine = mktime(12,0,0,$mois,$jour,$annee)-(date("w",mktime(12,0,0,$mois,$jour,$annee))-4)*24*60*60;
    else // Jeudi
        $jeudiSemaine = mktime(12,0,0,$mois,$jour,$annee);
    
    // Définition du premier Jeudi de l'année
    if (date("w",mktime(12,0,0,1,1,date("Y",$jeudiSemaine)))==0) // Dimanche
    {
        $premierJeudiAnnee = mktime(12,0,0,1,1,date("Y",$jeudiSemaine))+4*24*60*60;
    }
    else if (date("w",mktime(12,0,0,1,1,date("Y",$jeudiSemaine)))<4) // du Lundi au Mercredi
    {
        $premierJeudiAnnee = mktime(12,0,0,1,1,date("Y",$jeudiSemaine))+(4-date("w",mktime(12,0,0,1,1,date("Y",$jeudiSemaine))))*24*60*60;
    }
    else if (date("w",mktime(12,0,0,1,1,date("Y",$jeudiSemaine)))>4) // du Vendredi au Samedi
    {
        $premierJeudiAnnee = mktime(12,0,0,1,1,date("Y",$jeudiSemaine))+(7-(date("w",mktime(12,0,0,1,1,date("Y",$jeudiSemaine)))-4))*24*60*60;
    }
    else // Jeudi
    {
        $premierJeudiAnnee = mktime(12,0,0,1,1,date("Y",$jeudiSemaine));
    }
        
    // Définition du numéro de semaine: nb de jours entre "premier Jeudi de l'année" et "Jeudi de la semaine";
    $numeroSemaine =     ( 
                    ( 
                        date("z",mktime(12,0,0,date("m",$jeudiSemaine),date("d",$jeudiSemaine),date("Y",$jeudiSemaine))) 
                        -
                        date("z",mktime(12,0,0,date("m",$premierJeudiAnnee),date("d",$premierJeudiAnnee),date("Y",$premierJeudiAnnee))) 
                    ) / 7 
                ) + 1;
    
    // Cas particulier de la semaine 53
    if ($numeroSemaine==53)
    {
        // Les années qui commence un Jeudi et les années bissextiles commençant un Mercredi en possède 53
        if (date("w",mktime(12,0,0,1,1,date("Y",$jeudiSemaine)))==4 || (date("w",mktime(12,0,0,1,1,date("Y",$jeudiSemaine)))==3 && date("z",mktime(12,0,0,12,31,date("Y",$jeudiSemaine)))==365))
        {
            $numeroSemaine = 53;
        }
        else
        {
            $numeroSemaine = 1;
        }
    }
        
    //echo $jour."-".$mois."-".$annee." (".date("d-m-Y",$premierJeudiAnnee)." - ".date("d-m-Y",$jeudiSemaine).") -> ".$numeroSemaine."<BR>";
            
    return sprintf("%02d",$numeroSemaine);
}
?>