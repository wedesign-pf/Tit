<?php
$pathRacine="../../../";
include($pathRacine . "init.php");

if($__POST["email_lost"]=="" || !filter_var($__POST["email_lost"], FILTER_VALIDATE_EMAIL))  {
    
    $myInsert = new myInsert(__FILE__);
    $myInsert->table=$thisSite->PREFIXE_TBL_CLI . "espaceclient_logs";
    $myInsert->field["datetime"]=date('Y-m-d H:i:s');
    $myInsert->field["login"]="";
    $myInsert->field["action"]="mpd_oublie_invalide";
    $myInsert->field["commentaires"]="email saisie invalide: " . $__POST['email_lost'];
    $myInsert->execute();
    
    echo json_encode(['reponse' => "0"]);
    exit; 
}

$mySelect = new mySelect(__FILE__);
$mySelect->tables= $thisSite->PREFIXE_TBL_CLI . "espaceclient_acces";
$mySelect->fields="*";
$mySelect->where="email='" . $__POST['email_lost'] . "' AND actif=1";
$result=$mySelect->query();

if(count($result)==1 )  {

    $row = current($result); 
      
    list($email_expediteur, $nom_expediteur) = getEmail("webmaster");
    $email_destinataire = $__POST['email_lost'];    
    $subject = $thisSite->siteTitle . " | Mot de passe oublié";
    
    
    $fichierTemplate= $thisSite->DOS_CLIENT . "email_templates/mdp_oublie.tpl";
    if(file_exists($pathRacine . $fichierTemplate)) {
        $smarty->assign("pathRacine",$pathRacine);
        $smarty->assign("thisSite",$thisSite);
        //
        $smarty->assign("login",$row["login"]);
        $smarty->assign("mdp",$row["mdp"]);
        $messageHTML=$smarty->fetch($pathRacine . $fichierTemplate);
    }


    $res = sendEmail($email_expediteur,$email_destinataire,$messageHTML,$subject,$attach);

    $myInsert = new myInsert(__FILE__);
    $myInsert->table=$thisSite->PREFIXE_TBL_CLI . "espaceclient_logs";
    $myInsert->field["datetime"]=date('Y-m-d H:i:s');
    $myInsert->field["login"]="";
    $myInsert->field["action"]="mpd_oublie_OK";
    $myInsert->field["commentaires"]="email saisie: " . $__POST['email_lost'];
    $myInsert->execute();
      
    echo json_encode(['reponse' => "1"]);
    
} else {
    
    $myInsert = new myInsert(__FILE__);
    $myInsert->table=$thisSite->PREFIXE_TBL_CLI . "espaceclient_logs";
    $myInsert->field["datetime"]=date('Y-m-d H:i:s');
    $myInsert->field["login"]="";
    $myInsert->field["action"]="mpd_oublie_inconnu";
    $myInsert->field["commentaires"]="email inconnu: " . $__POST['email_lost'];
    $myInsert->execute();
    
    echo json_encode(['reponse' => "0"]);
}
?>