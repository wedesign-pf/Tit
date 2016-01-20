<?php
// FONCTIONS DE TRANSFORMATION, CONVERSION, ...

function startsWith($haystack, $needle) {
    return !strncmp($haystack, $needle, strlen($needle));
}


//$chaine="&é\"'(-è_çà)=$ AA ^ô*ù!:;,~#{B[|`\^@]}C¤°+£Ö¨µ%§/.";
// Nettoie complétement une chaine de caractère
function full_sanitize_string($texte){
	$texte = strtolower($texte);
	$texte = strtr($texte, 'áàâäãåçéèêëíìîïñóòôöõúùûüýÿ', 'aaaaaaceeeeiiiinooooouuuuyy');
	$texte = preg_replace('/ /','-', $texte);
	$texte = preg_replace('/[^a-zA-Z0-9-_\.]/','', $texte);
	return $texte;
}


function sanitize_string_for_url($texte){

	$texte = strtolower($texte);
	$texte = str_replace("+", "-", $texte);
    $texte = str_replace(" ", "-", $texte);
    $texte = str_replace("'", "-", $texte);
    $texte = str_replace("'", "-", $texte);
    $texte = str_replace("/", "-", $texte);
    $texte = str_replace("\\", "-", $texte);
    $texte = str_replace("$", "-", $texte);
    $texte = str_replace("*", "-", $texte);
    $texte = str_replace("\"", "", $texte);
    $texte=utf8_decode($texte);
    
	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ?';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-';
    $texte=strtr($texte,utf8_decode($a), $b);
    
    $texte=utf8_decode($texte);
    
    $a = "&~#{([|`\^])}$¤£µ*ù%§!:/;,?<>.°''\"";
    $b = "                                   ";
    $texte=strtr($texte,$a, $b);

    $texte = str_replace("###antiSlashe###t", " ", $texte);
    $texte = preg_replace("!\s+!", "-", $texte);

    $texte = str_replace(" ", "", $texte);
    $texte = str_replace("--", "-", $texte);
    $texte = str_replace("--", "-", $texte);
    $texte = str_replace("__", "_", $texte);
    $texte = str_replace("__", "_", $texte);
    
    if($texte[0]=="-") { $texte[0]="";}
    if($texte[strlen($texte)-1]=="-") { $texte[strlen($texte)-1]="";}

	return $texte;
}


// Supression des quotes et doubles quote
function delQuotes($texte) {
	$texte = str_replace("'", "", $texte);
	$texte = str_replace("\"", "", $texte);
	return $texte;
}
			
// transforme un caractère minuscule accentué en Majuscule accentué
function accent_majuscule($texte) {
	$texte = utf8_decode($texte); 
	$texte = strtoupper($texte);
	$a = 'äâàáåãéèëêòóôõöøìíîïùúûüýñçþÿæœð';
    $b = 'ÄÂÀÁÅÃÉÈËÊÒÓÔÕÖØÌÍÎÏÙÚÛÜÝÑÇ';
	$texte = strtr($texte, utf8_decode($a), utf8_decode($b));
	return utf8_encode($texte);
}

// transforme un caractère minuscule accentué en Majuscule NON accentué
function suppression_accent_majuscule($texte) {
	$texte = utf8_decode($texte); 
	$texte = strtoupper($texte);
	$a = 'äâàáåãéèëêòóôõöøìíîïùúûüýñçþÿæœðø';
    $b = 'AAAAAAEEEEEOOOOOIIIIUUUUYNC';
	$texte = strtr($texte, utf8_decode($a), utf8_decode($b));
	return utf8_encode($texte);
}

// supprime tous les accents
function suppression_accent($texte){
	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $texte = utf8_decode($texte);    
    $texte = strtr($texte, utf8_decode($a), $b);
    return utf8_encode($texte);
}

// transforme les caractères en HTML compatible UTF 8 et inversement
function translate_chaine($chaine, $sens="iso_utf8") {
	if($sens=="iso_utf8") { $chaine = html_entity_decode($chaine, ENT_QUOTES, "utf-8"); }
	if($sens=="utf8_iso") { $chaine = htmlentities($chaine, ENT_QUOTES, "utf-8"); }
	return $chaine;
}

// remplace <br> par nl (fonction inverse de nl2br)
function br2nl($chaine) {
	return preg_replace("/\<br\s*\/?\>/i", "\n", $chaine);
	// preg_replace(« /(<br\s*\/?\>){2,}/ », « \n », $foo); // pour 2 <br> à la suite ????
}



// Remplace une chaine de caractere dans un texte
function remplace_text($texte, $val, $par) {
	$texte = utf8_decode($texte);
	$val = utf8_decode($val);
	$par = utf8_decode($par);
	$txt = str_replace($par,$val,$texte);
	return utf8_encode($txt); 
}

// tronque un texte à nbc caractères
function tronc_texte($texte,$nbc) {
	$texte = utf8_decode($texte);
	if (strlen($texte)>=$nbc) { 
		$texte = substr($texte,0,$nbc) . "...";
	} 
	return utf8_encode($texte); 
}


// complète les liens si lien email
function complete_lien($lien) {
	if($lien=="") return "";
	if (substr_count($lien,"@")>0) {
		if ( strpos($lien,"mailto:")==0 )  $lien = "mailto:".$lien;	
	}
	 return $lien;
}


// mise en forme d'un nombre
function format_num($valeur,$decimal,$virgule,$millier) {
    if($valeur!="") {
        return number_format($valeur,$decimal,$virgule,$millier); 
    } else {
        return "";
    }
}

// http://freddychesnel.fr/ressources/20-crypter-et-decrypter-une-chaine-de-caracteres/
function crypt_string($private_key, $str_to_crypt) {
    
    if($str_to_crypt=="") { return $str_to_crypt; }
    
	$private_key = md5($private_key);
	$letter = -1;
	$new_str = '';
	$strlen = strlen($str_to_crypt);

	for ($i = 0; $i < $strlen; $i++) {
		$letter++;
		if ($letter > 31) {
			$letter = 0;
		}
		$neword = ord($str_to_crypt{$i}) + ord($private_key{$letter});
		if ($neword > 255) {
			$neword -= 256;
		}
		$new_str .= chr($neword);
	}
	return base64_encode($new_str);
}

function decrypt_string($private_key, $str_to_decrypt) {
    if($str_to_decrypt=="") { return $str_to_decrypt; }
    
	$private_key = md5($private_key);
	$letter = -1;
	$new_str = '';
	$str_to_decrypt = base64_decode($str_to_decrypt);
	$strlen = strlen($str_to_decrypt);
	for ($i = 0; $i < $strlen; $i++) {
		$letter++;
		if ($letter > 31) {
			$letter = 0;
		}
		$neword = ord($str_to_decrypt{$i}) - ord($private_key{$letter});
		if ($neword < 1) {
			$neword += 256;
		}
		$new_str .= chr($neword);
	}
	return $new_str;
}

// remplacement des variables dans un texte
function add_variables($texte) {
	global $PDO;
    global $thisSite;
	
	if(!is_array($thisSite->variables)) { // la première fois qu'on l'utilise, on charge la liste en session
		
		if($thisSite->current_lang!="") { $lg=$thisSite->current_lang; } else { $lg=$thisSite->LANG_DEF; }

		$l_vars=array();
		
		$result = $PDO->free_requete("SELECT * FROM " . $thisSite->PREFIXE_TBL_GEN . "variables WHERE lg='" . $lg ."'" );
		foreach($result as $row){ 
			$codevar = $thisSite->SEPVAR . stripslashes($row["code"]) . $thisSite->SEPVAR;
			$valeur = stripslashes($row["valeur"]);
			$l_vars[$codevar]=$valeur;
		} 
		$thisSite->variables=$l_vars;
	}
	
	reset($thisSite->variables);
	foreach($thisSite->variables as $key=>$val) {
		$val=htmlspecialchars_decode($val);
		$texte = str_replace($key, $val , $texte);
	}
	return $texte;
	
}


// remplacement des termes du glossaire dans un texte
function add_glossaire($texte) {
	global $PDO;
    global $thisSite;
	
	if(!is_array($thisSite->glossaire)) { // la première fois qu'on l'utilise, on charge la liste en session
		
		if($thisSite->current_lang!="") { $lg=$thisSite->current_lang; } else { $lg=$thisSite->LANG_DEF; }

		$glossaire=array();
		
		$result = $PDO->free_requete("SELECT * FROM " . $thisSite->PREFIXE_TBL_GEN . "glossaire WHERE lg='" . $lg ."'" );
		foreach($result as $row){ 
			$terme = stripslashes($row["terme"]);
			$explications = ($row["explications"]);
			$glossaire[$terme]=$explications;
		} 
		$thisSite->glossaire=$glossaire;
        
       // echoa($thisSite->glossaire);
	}
	
	reset($thisSite->glossaire);
	foreach($thisSite->glossaire as $terme=>$explications) {
        $reponse = "<span class=\"glossaire\" data-text=\"" . htmlspecialchars_decode($explications) . "\" >$terme</span>";
		$texte = str_replace($terme, $reponse , $texte);
	}
	return $texte;
	
}


?>