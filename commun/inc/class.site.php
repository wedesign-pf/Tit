<?php
class thisSite {

	// création de l'objet
	public function __construct () {
        
		$this->VERSION = "2015.12";
        $this->AUTHOR = "WeDesign - Tahiti";
        $this->EMAILWEBMASTER = "production@wedesign.pf";
                
        $this->LOCALHOST = "192.168.28.4"; // 192.168.28.4/ localhost
        $this->JQUERY1 = "jquery-1.11.3.min.js";
        $this->JQUERY2 = "jquery-2.1.4.min.js";
        $this->JQUERYM = "jquery-migrate-1.2.1.min.js";
        $this->ID_SITE = "99"; // 

        $this->PREFIXE_LG = ""; // si on le modifie, modifier également le htacess ( RewriteRule ^lg-([a-z]{2})/(.*)$ $2 )
        $this->EXTENSIONS_INDEX_OK = "php"; // extensions gérés/autorisés par le script index.php
        $this->NB_NIVEAUX_ARBO = "3"; // nombre de niveaux d'arboresence autorisée dans l'URL, après celui de la langue
        $this->TIMEZONE = "Pacific/Honolulu"; // Heure réglé sur Tahiti

        $this->PREFIXE_TBL = "g_"; // préfixe tables client
        $this->PREFIXE_TBL_CLI = $this->PREFIXE_TBL . "cli_"; // préfixe tables spécifiques au client
        $this->PREFIXE_TBL_ADM = $this->PREFIXE_TBL . "adm_"; // préfixe tables administration
        $this->PREFIXE_TBL_GEN = $this->PREFIXE_TBL . "gen_"; // préfixe tables données générales
        $this->PREFIXE_TBL_PUB = $this->PREFIXE_TBL . "pub_"; // préfixe tables gestion des publicités
        
        $this->DOS_BASE = "commun/"; // dossier pour éléments commun au front et back end
        $this->DOS_CLIENT = "client/"; // dossier pour les éléments spécifiques au client
        $this->DOS_ADMIN = "gestion/"; // dossier de l'administration
        
        $this->DOS_BASE_INC = $this->DOS_BASE . "inc/"; // dossier includes communs
        $this->DOS_BASE_LIB = $this->DOS_BASE . "lib/"; // dossier librairies communes
        $this->DOS_BASE_FCT =  $this->DOS_BASE . "fct/"; // dossier fonctions communes
        $this->DOS_BASE_PUB = $this->DOS_BASE . "pub/"; // dossier includes pour la publicité
        $this->DOS_BASE_INIT = $this->DOS_BASE . "init_pages/"; // Initialisation par type de page
        $this->DOS_BASE_TEMPLATES = $this->DOS_BASE . "templates/"; // dossier contenant les templates générales par type de page
        $this->DOS_CLIENT_FILES = $this->DOS_CLIENT . "files/"; // dossier des fichiers du client (seul dossier dans lequel il peut uploader)
        $this->DOS_CLIENT_FILES_COMMUN = $this->DOS_CLIENT . "files/_commun"; // dossier des fichiers (logos, etc..) que l'on retrouve à chaque projet
        $this->DOS_CLIENT_SKIN = $this->DOS_CLIENT . "skins/"; // dossier des skins
        $this->DOS_CLIENT_INC =$this-> DOS_CLIENT . "inc/"; // dossier include client
        $this->DOS_LOGS = "logs/"; // dossier des logs
     
        $this->cookiesAccept = false;
        
        // $this->errorLog=0; // "0"=>"Affichage à l'écran", "1"=>"Fichier log + email webmaster"
        $this->errorReporting = "E_ALL ^ E_NOTICE"; // E_ALL ^ E_NOTICE
        
        $this->richSnippet = ""; // "\"sameAs\" : [ \"https://www.facebook.com/carrefourtahiti\",\"https://www.youtube.com/user/carrefourtahiti2011\"]  ";
    
        if ($_SERVER['HTTP_HOST'] == $this->LOCALHOST) {
           $this->SERVER="local";
        } else {
           $this->SERVER="prod";
        }
        
        $this->mobile_detect=true; // chargement de la bibliothèque de détection des mobiles
        $this->printCSS=false;  // chargement de la feuille de style pour l'impression
        
        // type de pages à traiter comme des pages complètes, contrairement aux autres qui sont à inclure dans les pages (lightbox, ajax, iframe, ...)
        // Utiliser dans le sitemap, l'export des pages
        $this->PAGES_FULL=array('page'); 

        $this->script_HP="accueil.php";
                
        $this->SMARTY_CACHING=0; // Active la gestion du cache de SMARTY (ATTENTION: METTRE 0 ou 2, mais pas 1)
        $this->CACHE_LIFETIME=3600;// Temps de conservation dans le cache en secondes (-1 n'expire jamais) par défaut
        
        /////////
        ///////// VALEURS CONFIGURABLES ///////////////////////////////////////////////////////
        /////////
        
        $this->LOADER_PAGE=1; // Affichage d'un loader au chargement de chaque page
        $this->LIST_LANG_COMP=array('fr'=>'fr_fr', 'en'=>'en_us');  // utilisé entre autre par TinyMCE

        $this->TYPE_VIDEO_DEFAUT="Vimeo"; // YouTube ou Vimeo
        $this->LIST_TYPE_VIDEO=array('YouTube'=>'YouTube','Vimeo'=>'Vimeo');

        $this->DEFAULT_DIM_VIGS=array("480x600","768x1024","1024x0");  // dimensions standards des vignettes
        
		// extensions des fichiers que l'internaute peut downloader
		$this->UPLOAD_EXTENSIONS=array("jpg","jpeg","gif","png","pdf","vcf","doc","docx","xls","xlsx","odt","ppt","pps","csv","htm","bmp","tiff","swf","zip","txt","mp3");


        // Domaine à préchargement (dns-prefetch)
        $this->DNS_PREFETCH=array();
        $this->DNS_PREFETCH[]="//fonts.googleapis.com";
        $this->DNS_PREFETCH[]="//www.google-analytics.com";
        //$this->DNS_PREFETCH[]="//www.facebook.com";
        //$this->DNS_PREFETCH[]="//connect.facebook.net";
        //$this->DNS_PREFETCH[]="//static.ak.facebook.com";
        //$this->DNS_PREFETCH[]="//static.ak.fbcdn.net";
        //$this->DNS_PREFETCH[]="//s-static.ak.facebook.com";
        //$this->DNS_PREFETCH[]="//graph.facebook.com";
        //$this->DNS_PREFETCH[]="//cdn.api.twitter.com";
        //$this->DNS_PREFETCH[]="//api.pinterest.com"; 
        
        $this->DOMAINE="";
        $this->RACINE="";
        
        // BdD
        $this->SERVEUR_BDD="";
        $this->PORT_BDD="3306";
        $this->LOGIN_BDD="marco";
        $this->MDP_BDD="glopglop";
        
        // PhpMailer
        $this->MAIL_HOST=""; // Set the hostname of the mail server
        $this->SMTPAuth=false;
        $this->MAIL_Username=""; // Username to use for SMTP authentication
        $this->MAIL_Password=""; // Password to use for SMTP authentication
        $this->MAIL_PORT="25"; // Set the SMTP port number - likely to be 25, 465 or 587
        $this->MAIL_SENDMODE="mail"; // Mode d'envoi: mail, smtp
        
        // langues
        $this->LIST_LANG=array('fr'=>'Francais');
        $this->initLangueDefaut();
        $this->INDEX_LANG=0; // MULTI LANGUES uniquement: si =1, le domaine générique pourra être utilisé par exemple pour choisir une langue, si =0: le domaine générique sera automatiquement renvoyé vers la langue par défaut en 302
       
       /////////
       /////////   VALEURS CONFIGURABLES ADMINISTRATION ///////////////////////////////////////////////////////
       /////////

        $this->SEPVAR = "!!"; // Séparateur identifiant une variable dans les contenus
      
       
        
        $this->CHANGE_DROITS_FILES = false;
        $this->DROITS_DOSSIER_ECRITURE = "0775";

        // Type de page possible dans l'administration des pages
        $this->TYPES_PAGE=array();
        $this->TYPES_PAGE["page"]="Page";        
        $this->TYPES_PAGE["ajax"]="Ajax";
        $this->TYPES_PAGE["anchor"]="Ancre";
        $this->TYPES_PAGE["empty"]="Vide";
        $this->TYPES_PAGE["iframe"]="Iframe";
		$this->TYPES_PAGE["lightbox"]="LightBox";
        $this->TYPES_PAGE["nolink"]="Sans lien";
        $this->TYPES_PAGE["firstSrub"]="1ere sous rubrique";

    }
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////

	public function initLangueDefaut() {
		$this->LANG_DEF=key($this->LIST_LANG);
      
        return $this->LANG_DEF;
	}
  /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
      
    public function initSite() {
		
        global $smarty;

        // chagement des outils, menus, rubriques et sous rubriques du site

        $this->load_menus(); 
        $this->load_pages();
        
        load_intitules_by_lang(); //  chargement des intitulés de la langue en cours
    
        // chargement du lien vers la page d'accueil en mémmoire (pour faire des liens rapidement vers cette page
        $mySelect = new mySelect(__FILE__);
        $mySelect->tables=$this->PREFIXE_TBL_GEN . "pages";
        $mySelect->fields="page_url,titre";
        $mySelect->where="page_php='" . $this->script_HP . "' AND actif=1 AND lg=:lg";
        $mySelect->whereValue["lg"]=array($this->current_lang,PDO::PARAM_STR);
        $result=$mySelect->query();
        $row = current($result);     
        $this->homepage=stripslashes($row["page_url"]);
        $this->homepageTitle=stripslashes($row["titre"]);

        //  chargement infos sur le site
        $mySelect = new mySelect(__FILE__);
        $mySelect->tables=$this->PREFIXE_TBL_GEN . "site";
        $mySelect->fields="*";
        $mySelect->where="id=:id AND lg=:lg";
        $mySelect->whereValue["id"]=array($this->ID_SITE,PDO::PARAM_STR);
        $mySelect->whereValue["lg"]=array($this->current_lang,PDO::PARAM_STR);
        $result=$mySelect->query();
        $row = current($result); 
        $this->siteTitle = stripslashes($row["titre"]);
        $this->suffixeTitle = stripslashes($row["suffixe_title"]);
        $this->statut = stripslashes($row["etat"]);
        $this->skin = $this->DOS_CLIENT_SKIN . stripslashes($row["skin"]) ."/";
        $this->skinImages = $this->skin . "images/";
        $this->skinImagesClient = $this->skin . "images_client/";
        $this->socialImage = stripslashes($row["social_image"]);
        
        //// TAGS
		$tags=array();
		$mySelect = new mySelect(__FILE__);
        $mySelect->tables=$this->PREFIXE_TBL_GEN . "tags";
        $mySelect->fields="*";
        $mySelect->where="lg=:lg";
        $mySelect->whereValue["lg"]=array($this->current_lang,PDO::PARAM_STR);
        $result=$mySelect->query();     
		foreach($result as $row){ 

			$id = $row["id"];
			$parent = $row["parent"];
			$titre = $row["titre"];
            $lTags=$tags[$parent];
            $lTags[$id]=$titre;
            $tags[$parent]=$lTags;
            
		} 
		$this->tags=$tags;

        $this->variables="";
        $this->glossaire="";

        // GESTION DES ERREURS
/*        if ($this->errorLog==1) {
           // error_reporting(0);
//            set_error_handler('erreursPHP');
//            set_exception_handler("exceptionsPHP");
//            register_shutdown_function('erreursFatalesPHP');
//            $smarty->muteExpectedErrors();
           //// error_reporting(E_ALL ^ E_NOTICE);
        } else {
           //// error_reporting(E_ALL ^ E_NOTICE);
        }    */
        
        // sauvegarde pour vérifier changement de langue ou DOmaine lors du prochain chargement
        $this->save_current_lang = $this->current_lang;
        $this->save_domaine=$this->DOMAINE;
        $this->save_statut=$this->statut;
        
        
	}
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
    
    // CHARGEMENT DES MENUS
    public function load_menus($debug=0){

       // if(is_array($this->menus)) { return false; } // si existe déjà, on passe
    
        $arbo_menu=array();
    
        $mySelect = new mySelect(__FILE__);
        $mySelect->tables=$this->PREFIXE_TBL_GEN . "arbo";
        $mySelect->fields="*"; 
        $result=$mySelect->query();
        foreach($result as $row){ 
            $arbo_menu[$row['code_menu']]=unserialize($row['arbo_menu']);
        }
    
        $this->menus=$arbo_menu;
        if($debug==1) { echoa($arbo_menu); }
        
        
        return true;
        
    } 
   /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
  
    // CHARGEMENT DES PAGES
    public function load_pages($debug=0){

     //   if(is_array($this->pages)) { return false; } // si existe déjà, on passe
    
        $pages=array();
        $mySelect = new mySelect(__FILE__);
        $mySelect->tables=$this->PREFIXE_TBL_GEN . "pages";
        $mySelect->fields="*";
        $mySelect->where="lg=:lg AND actif=1";
        $mySelect->whereValue["lg"]=array($this->current_lang,PDO::PARAM_STR);
        $mySelect->orderby="id ASC";
        $result=$mySelect->query();
        foreach($result as $row){ 
        
            $idPage = stripslashes($row["id"]); 
            $datasPages=$row;
            
            // si tag_title vide : tag_title = page_titre
            if($datasPages["page_tag_title"]=="") { $datasPages["page_tag_title"]=$datasPages["page_titre"]; }
            
            // page_url = URL simple sans arbo ni type de page
            // insert chemin absolue si !!racine!!
            $datasPages["page_url"] = str_replace($this->SEPVAR . "racine" . $this->SEPVAR, $this->RACINE , $datasPages["page_url"]);

            $pages[$idPage]=$datasPages;
    
        }
        
        $this->pages=$pages;
        
        $this->loadUrlPages();
        	
        if($debug==1) { echoa($pages); }
        return true;
        
    } // function load_pages
    
    
     public function loadUrlPages() {
       // page_url_menu = tableau par Menu des URL a utiliser dans les menus (avec arbo et type de page)
       // page_url_arbo = tableau par Menu des URL dans l'arborescence (sans le type de page)

            foreach($this->menus as $menu=>$pagesByMenu){ 

                foreach($pagesByMenu as $idRUB=>$listSRUB) {
                    
                    $datasRUB = $this->pages[$idRUB];  
                    $racinelienRub="";
                    
                    $lienRub=prepareMenuLink($datasRUB["page_type"],$racinelienRub,$datasRUB["page_url"]);
                    $classLI=prepareMenuLinkClassLI($datasRUB["page_type"]);
                    $classA=prepareMenuLinkClassA($datasRUB["page_type"]);

                    if($datasRUB["page_type"]=="page") { $racinelienRub=$lienRub . "/"; }

                    if($datasRUB["page_type"]=="firstSrub" && is_array($listSRUB)) {
                        if(count($listSRUB)>0) {  
                            $temp=array_keys($listSRUB); 
                            $lienRub=$lienRub."/".$this->pages[$temp[0]]["page_url"];
                            $classLI=prepareMenuLinkClassLI($this->pages[$temp[0]]["page_type"]);
                            $classA=prepareMenuLinkClassA($this->pages[$temp[0]]["page_type"]);
                        }
                     }
                     
                     $this->pages[$idRUB]["page_url_menu"][$menu]=$lienRub;
                     $this->pages[$idRUB]["page_url_arbo"][$menu]=$datasRUB["page_url"];
                     $this->pages[$idRUB]["classLI"]=$classLI;
                     $this->pages[$idRUB]["classA"]=$classA;

                     if(is_array($listSRUB) && count($listSRUB)>0) {
			            foreach($listSRUB as $idSRUB=>$listSSRUB) { 
                          
				            $datasSRUB = $this->pages[$idSRUB];
                            $racinelienSRub="";
                            
                            $lienSRub=prepareMenuLink($datasSRUB["page_type"],$racinelienRub,$datasSRUB["page_url"]);
                            $classLI=prepareMenuLinkClassLI($datasRUB["page_type"]);
                            $classA=prepareMenuLinkClassA($datasRUB["page_type"]);
                      
                            if($datasSRUB["page_type"]=="page") { $racinelienSRub=$racinelienRub . $lienSRub . "/"; }
                         
                            $this->pages[$idSRUB]["page_url_menu"][$menu]=$lienSRub;
                            $this->pages[$idSRUB]["page_url_arbo"][$menu]=$datasRUB["page_url"] . "/" . $datasSRUB["page_url"] ;
                            $this->pages[$idSRUB]["classLI"]=$classLI;
                            $this->pages[$idSRUB]["classA"]=$classA;
                            
                            if(is_array($listSSRUB) && count($listSSRUB)>0) {
                                foreach($listSSRUB as $idSSRUB=>$nada) { 
                                  
                                    $datasSSRUB = $this->pages[$idSSRUB];
                                    
                                    $lienSSRub=prepareMenuLink($datasSSRUB["page_type"], $racinelienSRub ,$datasSSRUB["page_url"]);
                                    $classLI=prepareMenuLinkClassLI($datasRUB["page_type"]);
                                    $classA=prepareMenuLinkClassA($datasRUB["page_type"]);
                            
                                    $this->pages[$idSSRUB]["page_url_menu"][$menu]=$lienSSRub;
                                    $this->pages[$idSSRUB]["page_url_arbo"][$menu]=$datasRUB["page_url"] . "/" . $datasSRUB["page_url"] . "/" . $datasSSRUB["page_url"] ;
                                    $this->pages[$idSSRUB]["classLI"]=$classLI;
                                    $this->pages[$idSSRUB]["classA"]=$classA;
                  
                                } // foreach($listSSRUB
                             } // count($listSSRUB)>0   
                            
                        } // foreach($listSRUB
                     } // count($listSRUB)>0
                     
        
                } // foreach($pagesByMenu
            } // foreach($this->menus
            
    }
    
   /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
 	
	

} // SITE

?>