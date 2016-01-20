<?php
// CUSTOMISATION /////////////////////////////////////////////////
//
// SPECIFIQUES
$thisSite->INFOS_LANG["devises"]=array("fr"=>"&#8364;", "en"=>"$");
$thisSite->INFOS_LANG["timeMode"]=array("fr"=>"24", "en"=>"12");

/////////////////////////
$thisSite->LIST_LANG=array('fr'=>'Français','en'=>'English'); 
$thisSite->DEFAULT_DIM_VIGS=array("480x600","768x1024","1024x0");
$thisSite->TYPE_VIDEO_DEFAUT="Vimeo"; // YouTube ou Vimeo
$thisSite->cookiesAccept = true;
$thisSite->richSnippet = ""; // "\"sameAs\" : [ \"https://www.facebook.com/carrefourtahiti\",\"https://www.youtube.com/user/carrefourtahiti2011\"]  ";
$thisSite->googleAnalytics ="<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-68959556-1', 'auto');
  ga('send', 'pageview');

</script>";

//
$thisSite->mobile_detect=true; // chargement de la bibliothèque de détection des mobiles
$thisSite->printCSS=false; // chargement de la feuille de style pour l'impression

/////////////////////////
if ($thisSite->SERVER == "local") { 

    $thisSite->DOMAINE= "http://" . $thisSite->LOCALHOST; // sans le slash à la fin 
	$thisSite->RACINE= $thisSite->DOMAINE . "/Marco/tit/";
    
    $thisSite->SERVEUR_BDD=$thisSite->LOCALHOST; 
    $thisSite->NOM_BDD="bdd_tit";

    $thisSite->MAIL_SENDMODE="mail";
    $thisSite->MAIL_SENDER="production@wedesign.pf";	
     
}
if ($thisSite->SERVER == "prod") { 

    $thisSite->DOMAINE= "http://www.tahitiislandstravel.com"; // sans le slash à la fin 
	$thisSite->RACINE= $thisSite->DOMAINE . "/demo/";
    
    $thisSite->SERVEUR_BDD="localhost";
    $thisSite->NOM_BDD="c1tit";
    $thisSite->LOGIN_BDD="c1tit";
    $thisSite->MDP_BDD="k0PJiu#1hG";
    
    $thisSite->MAIL_HOST="localhost";
    $thisSite->MAIL_Username="";
    $thisSite->MAIL_Password="";
    $thisSite->SMTPAuth=false;
    $thisSite->MAIL_PORT="25";
    $thisSite->MAIL_SENDMODE="smtp";
    $thisSite->MAIL_SENDER="production@wedesign.pf";
    
}

$thisSite->initLangueDefaut(); // pour être sur

?>