<?php
$pathRacine="../../../";
include($pathRacine . "init.php");

$_SESSION["EC_essaiConnexion"]++;

if($_SESSION["EC_essaiConnexion"]>3) { 

    $myInsert = new myInsert(__FILE__);
    $myInsert->table=$thisSite->PREFIXE_TBL_CLI . "espaceclient_logs";
    $myInsert->field["datetime"]=date('Y-m-d H:i:s');
    $myInsert->field["login"]=$__POST['login'];
    $myInsert->field["action"]="essai_depasse";
    $myInsert->field["commentaires"]="login: " . $__POST['login'] . " / mdp: " . $__POST['mdp'];
    $myInsert->execute();

    $_SESSION["EC_accesOK"]=0;

    echo json_encode(['reponse' => "-1"]);
	exit;
}

if($__POST["login"]=="" || $__POST["mdp"]=="" || strlen($__POST["login"])>20 ||  strlen($__POST["mdp"])>20)  {
    
    $myInsert = new myInsert(__FILE__);
    $myInsert->table=$thisSite->PREFIXE_TBL_CLI . "espaceclient_logs";
    $myInsert->field["datetime"]=date('Y-m-d H:i:s');
    $myInsert->field["login"]=$__POST['login'];
    $myInsert->field["action"]="connexion_invalide";
    $myInsert->field["commentaires"]="login: " . $__POST['login'] . " / mdp: " . $__POST['mdp'];
    $myInsert->execute();
    
    echo json_encode(['reponse' => "0"]);
    exit; 
}

$mySelect = new mySelect(__FILE__);
$mySelect->tables= $thisSite->PREFIXE_TBL_CLI . "espaceclient_acces";
$mySelect->fields="*";
$mySelect->where="login=:login AND mdp=:mdp AND actif=1";
$mySelect->whereValue["login"]=array($__POST['login'],PDO::PARAM_STR);
$mySelect->whereValue["mdp"]=array($__POST['mdp'],PDO::PARAM_STR);
$result=$mySelect->query();

if(count($result)==1)  {
    
    $myInsert = new myInsert(__FILE__);
    $myInsert->table=$thisSite->PREFIXE_TBL_CLI . "espaceclient_logs";
    $myInsert->field["datetime"]=date('Y-m-d H:i:s');
    $myInsert->field["login"]=$__POST['login'];
    $myInsert->field["action"]="connexion_OK";
    $myInsert->field["commentaires"]="";
    $myInsert->execute();
    
    $_SESSION["EC_accesOK"]=1;
    $_SESSION["EC_login"]=$__POST['login'];
	setcookie("EC_login", $__POST['login'], time() + (60 * 60 * 24 * 365), COOKIE_PATH);
	setcookie("EC_mdp", md5($__POST['mdp']), time() + (60 * 60 * 24 * 365), COOKIE_PATH);

    echo json_encode(['reponse' => "1"]);
    
} else {

    $myInsert = new myInsert(__FILE__);
    $myInsert->table=$thisSite->PREFIXE_TBL_CLI . "espaceclient_logs";
    $myInsert->field["datetime"]=date('Y-m-d H:i:s');
    $myInsert->field["login"]=$__POST['login'];
    $myInsert->field["action"]="connexion_inconnu";
    $myInsert->field["commentaires"]="login: " . $__POST['login'] . " / mdp: " . $__POST['mdp'];
    $myInsert->execute();
    
    $_SESSION["EC_accesOK"]=0;
    
    echo json_encode(['reponse' => "0"]);
}
?>

