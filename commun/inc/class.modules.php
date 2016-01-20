<?php
class module {

	// paramètres
	public $module; // code du module
    public $ssModule; // Sous module
	public $debug; // si TRUE affichage des requetes SQL
	
	// propriétés
	public $identifiant; // identifiant (pour gérer plusieurs fois le module dans la même page)
    public $params; //  parammètres supplémentaires
	public $css; //  tableau des feuilles de style à ajouter dans la page
	public $js; //  tableau des scripts JS à ajouter dans la page
	public $head; //  code à insérer dans la balise HEAD de la page
	public $doc_ready; //  code à insérer dans la fct Jquery $(document).ready de la page
	public $win_load; //  code à insérer dans la fct Jquery $(document).win_load de la page
	public $javascript; //  code à insérer dans le code javascript en fin de la page
	public $footer; //  code à insérer en fin de HTML de la page


	// création de l'objet
	public function __construct ($module,$ssModule="",$debug="") {
		
        if($module=="") {
			trigger_error('manque le code du module',E_USER_WARNING);
    	    return;
		}
        
        $this->modulePathName = $module;
        
        if(substr($module,0,1)=="_") { $module = substr($module,1);   }
        
		$this->module = $module;
        
        if($ssModule=="") {
            $this->ssModule = $module;
        } else {
            $this->ssModule = $ssModule;
        }
		$this->debug = $debug;
    
        $identifiant="";
	}
	
	// récupération données articles
	public function load() {

		global $smarty;
		global $datas_lang;
		global $__GET;
		global $__POST;
		global $datas_page;
        global $thisSite;

		$params_module=$this->params; // Permet d'utiliser $params_module dans les modules comme infos spécifiques complémentaires
        $smarty->assign("params_module", $params_module);

		$chemin_module=get_path_modules($this->modulePathName) . "/";
		
		// chargement des données langues du menu
		load_data_lang_plus($this->module,$chemin_module);
	
		$smarty->assign("datas_lang", $datas_lang);
		
		// Execution du module
		$SHOW_module=1; // permet d'arréter le traitement du module après le script PHP (pas de templates, ni d'autres éléments: JS: CSS, Javascript, ...

		if(file_exists($chemin_module . $this->ssModule . ".php")) {
			include($chemin_module . $this->ssModule . ".php");
		}			
        
        $tpl_module="";
	
		if($SHOW_module==1) {

			// chargement de la feuille de sytle suivant la SKIN en cours, sinon on prend defaut
			$style_courant=str_replace($thisSite->DOS_CLIENT_SKIN, "", $thisSite->skin);
			$style_courant=str_replace("/", "", $style_courant);
			
			// Chargement d'une CSS de base
			$listCss=array();
			$listCss[]="defaut.css"; // on essaye d'abord de charger celle ci 
			$listCss[]=$style_courant . ".css"; // sinon celle portant le nom de la Skin en cours
			$listCss[]=$this-module. ".css"; // sinon la CSS portant le même nom que le module
			$listCss = array_unique($listCss);
			
			foreach ($listCss as $css) {
                if($css!="") {
                    $pathCss=$chemin_module . $css;
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
                        $pathCss=$chemin_module . $css;
                        if(file_exists($pathCss)) {
                            addStructure("PAGE_css_client",$pathCss);
                        }
                    }
				}
			}
			
			// JS
            // par défaut, on charge le JS portant le meme nom que le module 
            if(file_exists($chemin_module . $this->module . ".js")) { 
               addStructure("PAGE_js_client",$chemin_module . $this->module . ".js");
            }
            
            // on regarde si il y a d'autres JS à charger
            if(!is_array($this->js) && $this->js!="") {
				$this->js=array($this->js);
			}
           
			if(is_array($this->js)) {
				foreach ($this->js as $k => $js) {
					if (strpos($js, 'http') === 0) {
						addStructure("PAGE_js_client",$js);
					} else if(file_exists($chemin_module . $js) && $js!="") {
						addStructure("PAGE_js_client",$chemin_module . $js);
					}
				}
			}

			if($this->head!="") { addStructure("PAGE_head",$this->head . "\n\n");  }
			if($this->doc_ready!="") { addStructure("PAGE_doc_ready",$this->doc_ready . "\n\n"); }
			if($this->win_load!="") { addStructure("PAGE_win_load",$this->win_load . "\n\n"); }
			if($this->javascript!="") { addStructure("PAGE_javascript",$this->javascript . "\n\n"); }
			if($this->footer!="") { addStructure("PAGE_footer",$this->footer . "\n\n"); }
			
		/////////////////////////////////	
			if($template=="") { $template=$this->ssModule; }
			
			$smarty->assign("datas_page",$datas_page); 
			if(file_exists($chemin_module . $template . ".tpl")) { 
				$tpl_module= $smarty->fetch($chemin_module . $template . ".tpl");
				$smarty->assign("MODULE_" . $template . $this->idendifiant,$tpl_module);
			}
		/////////////////////////////////	
		} //$SHOW_module 
		
		// IMPORTANT pour les modules suivants à traiter
		$template="";
        
        if($this->return==1) return $tpl_module;
	}


}
?>