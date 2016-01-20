<?php
if ($myAdmin->PRIVILEGE==9) { $actionsPage=array("appliquer"); } else { $actionsPage=array(); }
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php
$checklist=array();
$checklist["www"]=array("titre"=>"htaccess: changer le nom de domaine","lien"=>"");
$checklist["robotmap"]=array("titre"=>"robots.txt: changer le nom de domaine vers le sitemap","lien"=>"");
$checklist["checkwww"]=array("titre"=>"Vérifier redirection .domaine > www.domaine","lien"=>"");
$checklist["ga"]=array("titre"=>"créer un compte GA et insérer le code dans la table SITE","lien"=>"http://www.google.fr/intl/fr/analytics/");
$checklist["404"]=array("titre"=>"Vérifier l'affichage d'une page 404","lien"=>"");
$checklist["sitemap"]=array("titre"=>"Vérifier le sitemap dans toutes les langues","lien"=>"");
$checklist["partageRS"]=array("titre"=>"Vérifier le partage sur les réseaux sociaux","lien"=>"");
$checklist["w3c"]=array("titre"=>"Passer le site au validator W3C","lien"=>"http://validator.w3.org/");
$checklist["w3cCSS"]=array("titre"=>"Passer le site au validator CSS W3C","lien"=>"http://jigsaw.w3.org/css-validator/");
$checklist["auditMRM"]=array("titre"=>"Audit MyRankingMetrics.com","lien"=>"https://myrankingmetrics.com/seo/audit");
$checklist["siteanalyzer"]=array("titre"=>"Tester performance avec site-analyzer ","lien"=>"https://www.site-analyzer.com");
$checklist["yellowlab"]=array("titre"=>"Tester performance avec Yellowlab ","lien"=>"http://yellowlab.tools/");
$checklist["insights"]=array("titre"=>"Tester performance avec PageSpeed Insights","lien"=>"https://developers.google.com/speed/pagespeed/insights/");
$checklist["gtmetrix"]=array("titre"=>"Tester performance avec Gtmetrix","lien"=>"https://gtmetrix.com/");
$checklist["dareboost"]=array("titre"=>"Tester performance avec Dareboost","lien"=>"https://www.dareboost.com/fr/home");
$checklist["seoimage"]=array("titre"=>"Check Redirections","lien"=>"http://try.seoimage.com/check-server-header-check-redirects-tool/");
$checklist["checklink"]=array("titre"=>"Vérifier les liens brisés","lien"=>"http://iwebtool.com/broken_link_checker");
$checklist["redbot"]=array("titre"=>"Optimiser Headers","lien"=>"https://redbot.org");
$checklist["mobileOK"]=array("titre"=>"W3C Mobile Checker","lien"=>"http://validator.w3.org/mobile/");
$checklist["senseo"]=array("titre"=>"Tester avec SenSeo (plugin en forme de loupe dans FF)","lien"=>"https://addons.mozilla.org/en-US/firefox/addon/senseo/");
$checklist["datastruc"]=array("titre"=>"Tester les Data Structured","lien"=>"https://developers.google.com/structured-data/testing-tool/");
$checklist["dmoz"]=array("titre"=>"ajouter le site à DMOZ","lien"=>"http://www.dmoz.org/World/Fran%C3%A7ais/");
$checklist["gwmt"]=array("titre"=>"ajouter le site à GWMT et vérifier","lien"=>"https://www.google.com/webmasters/tools/home?hl=fr");
$checklist["statsga"]=array("titre"=>"Créer un rapport mensuel à envoyer au client","lien"=>"http://www.google.fr/intl/fr/analytics/");
?>
<?php
if ($myAdmin->PRIVILEGE==9) { 
	// TODOLIST
	if($__POST["actionForm"]=="appliquer") {
	    
       $listChecked="";
       foreach($__POST as $c=>$v) {
            $xx=strpos($c,"checklist-");
           if($xx===0) {
                $listChecked.=$v . ",";
           }
       }

    	$todolist=htmlspecialchars($__POST["todolist"], ENT_QUOTES);
		$PDO->free_requete("UPDATE " . $thisSite->PREFIXE_TBL_GEN . "site SET todolist='" . $todolist ."', checklist='" . $listChecked . "' WHERE id=" . $thisSite->ID_SITE . " AND lg='fr'" );

    }
		
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "site";
	$mySelect->fields="todolist, checklist";
	$mySelect->where="id=" . $thisSite->ID_SITE . " AND lg='fr'";
	$result=$mySelect->query();
	
	$newfield = new textarea();
	$newfield->field="todolist";
	$newfield->multiLang=false;
	$newfield->widthLabel=0;
	$newfield->widthField=8;
	$newfield->rows=15;
	$newfield->value=$result[0]["todolist"];
	$newfield->label="&nbsp;";
	$newfield->add();
    
    //
    $listChecked=explode(",",$result[0]["checklist"]);
    foreach($listChecked as $checked) {
        if($checked !="") { $checklist[$checked]["check"]=1; }
    }
}
?>
<?php
$smarty->assign("checklist", $checklist);

$smarty->assign("mod_expires", apache_module_exists("mod_expires"));
?>
<?php

$infos="";
$sep="";
$chemin_DOS_CLIENT_FILES = "../" . $thisSite->DOS_CLIENT_FILES;

if ($_SERVER[HTTP_HOST] != $thisSite->LOCALHOST && $thisSite->CHANGE_DROITS_FILES==true) {
	
	$perms_DOS_CLIENT_FILES=get_permissions($chemin_DOS_CLIENT_FILES);
	
	$infos .= $chemin_DOS_CLIENT_FILES . "> $perms_DOS_CLIENT_FILES" . $sep;

	if($perms_DOS_CLIENT_FILES!=$thisSite->DROITS_DOSSIER_ECRITURE) { 
		$res = chmod($chemin_DOS_CLIENT_FILES,octdec($thisSite->DROITS_DOSSIER_ECRITURE));
		$infos .= "<div class='erreur'>Les droits du dossier " . strtoupper($chemin_DOS_CLIENT_FILES) . " ont &eacute;t&eacute; modifi&eacute;s en " . $thisSite->DROITS_DOSSIER_ECRITURE . " ($res)</div>". $sep;
		usleep(1000); 
	}
		
	$arbo = read_tree($chemin_DOS_CLIENT_FILES,1);
	
	foreach($arbo as $dossier=>$fichiers) {
		$dossier=$dossier."/";
		if($dossier==$chemin_DOS_CLIENT_FILES) { continue;}
		$chemin_sous_dossier=$dossier;
		$perms_dossier=get_permissions($chemin_sous_dossier);
		if($perms_dossier!=$thisSite->DROITS_DOSSIER_ECRITURE) { 
			$res = chmod($dossier,octdec($thisSite->DROITS_DOSSIER_ECRITURE)); 
			$infos .= "<div class='erreur'>Les droits du sous dossier " . strtoupper($chemin_sous_dossier) . " ont &eacute;t&eacute; modifi&eacute;s en " . $thisSite->DROITS_DOSSIER_ECRITURE . " ($res)</div>". $sep; 
		} 
		//echo("<hr>$dossier : $perms_dossier<br>");
	}

}


if ($_SERVER[HTTP_HOST] != $thisSite->LOCALHOST) {

//Vérification des droits
	$perms_DOS_CLIENT_FILES=get_permissions($chemin_DOS_CLIENT_FILES);
	$erreur_perms=0;
	
	$arbo = read_tree($chemin_DOS_CLIENT_FILES,1);
	
	foreach($arbo as $dossier=>$fichiers) {
		$dossier=$dossier."/";
		$chemin_sous_dossier=$dossier;
		$perms_dossier=get_permissions($chemin_sous_dossier);
		if($perms_dossier!=$thisSite->DROITS_DOSSIER_ECRITURE) { 
			$infos .= "<div class='erreur'>ATTENTION: Les droits du dossier " . strtoupper($chemin_sous_dossier) . " sont à " . $perms_dossier . " alors qu'ils devraient être à " . $thisSite->DROITS_DOSSIER_ECRITURE . "</div>";
			$erreur_perms=1;
		} 
	}
	
		$chemin_sous_dossier= $racine_smarty . "smarty/templates_c/";
		$perms_dossier=get_permissions($chemin_sous_dossier);
		if($perms_dossier!=$thisSite->DROITS_DOSSIER_ECRITURE) { 
			$infos .= "<div class='erreur'><br>ATTENTION: Les droits du dossier " . strtoupper($chemin_sous_dossier) . " sont à " . $perms_dossier . " alors qu'ils devraient être à " . $thisSite->DROITS_DOSSIER_ECRITURE . "</div>";
			$erreur_perms=1;
		} 
		
		$chemin_sous_dossier= $racine_smarty . "smarty/cache/";
		$perms_dossier=get_permissions($chemin_sous_dossier);
		if($perms_dossier!=$thisSite->DROITS_DOSSIER_ECRITURE) { 
			$infos .= "<div class='erreur'>ATTENTION: Les droits du dossier " . strtoupper($chemin_sous_dossier) . " sont à " . $perms_dossier . " alors qu'ils devraient être à " . $thisSite->DROITS_DOSSIER_ECRITURE . "</div>";
			$erreur_perms=1;
		}
		
		$chemin_sous_dossier= $racine_smarty . $thisSite->DOS_LOGS;
		$perms_dossier=get_permissions($chemin_sous_dossier);
		if($perms_dossier!=$thisSite->DROITS_DOSSIER_ECRITURE) { 
			$infos .= "<div class='erreur'><br>ATTENTION: Les droits du dossier " . strtoupper($chemin_sous_dossier) . " sont à " . $perms_dossier . " alors qu'ils devraient être à " . $thisSite->DROITS_DOSSIER_ECRITURE . "</div>";
			$erreur_perms=1;
		}

	if($erreur_perms==1) {
	 $infos .= "<br><div class='erreur'>CELA PEUT POSER DES PROBLEMES LORS DE L'AJOUT DE FICHIERS (UPLOAD)</div>";
	  $infos .= "<div class='erreur'>CONTACTER LE WEBMASTER POUR QU'IL CORRIGE LE PROBLEME.</div>";
	}
}

$smarty->assign("infos", $infos);
?>