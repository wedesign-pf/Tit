<?php
class outil {

	// paramètres
	public $outil; // code du outil
	public $ssOutil; // Sous outil
	public $debug; // si TRUE affichage des requetes SQL
	
	// propriétés
	public $params; //  parammètres supplémentaires
	public $css; //  tableau des feuilles de style à ajouter dans la page
	public $js; //  tableau des scripts JS à ajouter dans la page
	public $head; //  code à insérer dans la balise HEAD de la page
	public $doc_ready; //  code à insérer dans la fct Jquery $(document).ready de la page
	public $win_load; //  code à insérer dans la fct Jquery $(document).win_load de la page
	public $javascript; //  code à insérer dans le code javascript en fin de la page
	public $footer; //  code à insérer en fin de HTML de la page


	// création de l'objet
	public function __construct ($outil,$ssOutil="",$debug="") {
		if($outil=="") {
			trigger_error('manque le code de l\'outil',E_USER_WARNING);
    	    return;
		}
        
        $this->outilPathName = $outil;
        
        if(substr($outil,0,1)=="_") { $outil = substr($outil,1); }
        
		$this->outil = $outil;
        if($ssOutil=="") {
            $this->ssOutil = $outil;
        } else {
            $this->ssOutil = $ssOutil;
        }
		$this->debug = $debug;

	}
	
	// récupération données articles
	public function load() {

		global $smarty;
		global $datas_lang;
		global $__GET;
		global $__POST;
        global $thisSite;
	
		$params_outil=$this->params; // Permet d'utiliser $params_outil dans les outils comme infos spécifiques complémentaires

		$chemin_outil=get_path_outils($this->outilPathName) . "/";
		
		// chargement des données langues du menu
		load_data_lang_plus($this->outil,$chemin_outil);
	
		$smarty->assign("datas_lang", $datas_lang);

		// Execution du outil
		$SHOW_outil=1; // permet d'arréter le traitement du outil après le script PHP (pas de templates, ni d'autres éléments: JS: CSS, Javascript, ...
		
		if(file_exists($chemin_outil . $this->ssOutil . ".php")) {
			include($chemin_outil . $this->ssOutil . ".php");
		}
		if($SHOW_outil==1) {

			// chargement de la feuille de sytle suivant la SKIN en cours, sinon on prend defaut
			$style_courant=str_replace($thisSite->DOS_CLIENT_SKIN, "", $thisSite->skin);
			$style_courant=str_replace("/", "", $style_courant);

			// Chargement d'une CSS de base
			$listCss=array();
			$listCss[]="defaut.css"; // on essaye d'abord de charger celle ci 
			$listCss[]=$style_courant . ".css"; // sinon celle portant le nom de la Skin en cours
			$listCss[]=$this->outil . ".css"; // sinon la CSS portant le même nom que l'outil
			$listCss = array_unique($listCss);
			
			foreach ($listCss as $css) {
                if($css!="") {
                    $pathCss=$chemin_outil . $css;
                    if(file_exists($pathCss)) {
                        addStructure("PAGE_css_client",$pathCss);	
                        break;
                    }
                }
			}
				
			// Chargement de CSS supplémentaires
			$listCss=array();
			if(!is_array($this->css)) {
				$listCss=array($this->css);
			} else {
				$listCss=$this->css;
			}
			
			if(is_array($listCss)) {
				foreach ($listCss as $css) {
                    if($css!="") {
                        $pathCss=$chemin_outil . $css;
                        if(file_exists($pathCss)) {
                            addStructure("PAGE_css_client",$pathCss);
                        }
                    }
				}
			}
			
			
			// JS
			
            // par défaut, on charge le JS portant le meme nom que le module 
            if(file_exists($chemin_outil . $this->outil . ".js")) { 
               addStructure("PAGE_js_client",$chemin_outil . $this->outil . ".js");
            }
            
            // on regarde si il y a d'autres JS à charger
			if(!is_array($this->js) && $this->js!="") {
				$this->js=array($this->js);
			}
			if(is_array($this->js)) {
				foreach ($this->js as $k => $js) {
					if (strpos($js, 'http') === 0) {
						addStructure("PAGE_js_client",$js);	
					} else if(file_exists($chemin_outil . $js) && $js!="") {
						addStructure("PAGE_js_client",$chemin_outil . $js);	
					}
				}
			}

			if($this->head!="") { addStructure("PAGE_head",$this->head . "\n\n"); }
			if($this->doc_ready!="") { addStructure("PAGE_doc_ready",$this->doc_ready . "\n\n"); }
			if($this->win_load!="") { addStructure("PAGE_win_load",$this->win_load . "\n\n"); }
			if($this->javascript!="") { addStructure("PAGE_javascript",$this->javascript . "\n\n"); }
			if($this->footer!="") { addStructure("PAGE_footer",$this->footer . "\n\n"); }
	
			if($outil_template=="") { $outil_template=$this->ssOutil; }
			
			if(file_exists($chemin_outil . $outil_template . ".tpl")) {
				$tpl_outil= $smarty->fetch($chemin_outil . $outil_template . ".tpl");
				$smarty->assign("outil_" . $outil_template,$tpl_outil);
			}
		
		} //$SHOW_outil 
		
		// IMPORTANT pour les outils suivants à traiter
		$outil_template="";
	}


}
?>