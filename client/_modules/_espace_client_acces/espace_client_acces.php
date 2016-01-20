<?php 
// on récupère les cookies si on est pas déjà identifié et qu'il existe
if($_SESSION["EC_accesOK"]=="" && $_COOKIE['EC_login']!="") {

    $mySelect = new mySelect(__FILE__);
    $mySelect->tables= $thisSite->PREFIXE_TBL_CLI . "espaceclient_acces";
    $mySelect->fields="*";
    $mySelect->where="login=:login AND actif=1";
    $mySelect->whereValue["login"]=array($_COOKIE['EC_login'],PDO::PARAM_STR);
    $result=$mySelect->query();
    $row = current($result); 

	$mdp=md5($row["mdp"]);

	if($mdp==$_COOKIE['EC_mdp']) {
        $smarty->assign("login",$row["login"]);
        $smarty->assign("mdp",$row["mdp"]);
        
	}

}
?>