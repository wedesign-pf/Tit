<?php
// vérifie si un email est valide
function check_mail($email) { 
	if(filter_var($email, FILTER_VALIDATE_EMAIL)=="") { return false; } else { return true; }
} 

// vérifie si une URL est valide
function check_URL($url,$protocole=0) {
	return true;
} 

// vérifie si c'est bien un float non signé
function is_unsigned_float($val) {
	return is_numeric($val); // pas bon, prend les signes...Argg.
}

// vérifie si bien un entier non signé
function is_unsigned_integer($val) {
   return ( preg_match( '/^\d*$/'  , $val) == 1 );
}

// vérifie si c'est bien un float signé
function is_signed_float($val) {
	return is_numeric($val);
}

// vérifie si bien un entier signé
function is_signed_integer($val) {
   return preg_match('@^[-]?[0-9]+$@',$val) === 1;
}

// vérifie si c'est bien que des lettres sans acccent
function is_alpha($val) { 
	if (ctype_alpha($val)) { return 1; } else { return 0; }
}

// vérisie si que des chiffres ou des lettres sans accent
function is_alphanum($val) {
	if (ctype_alnum($val)) { return 1; } else { return 0; }
}

// vérifie si que des chiffres, des lettres et "_" et "-"
function is_valide_code($val) {
	$val = str_replace("_", "", $val);
	$val = str_replace("-", "", $val);
	return is_alphanum($val); 
}


?>