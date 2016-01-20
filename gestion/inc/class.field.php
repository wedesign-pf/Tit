<?php
//$newfield = new input();
//$newfield->field="titretest"; // nom du clamp (racine pour les multilangues
//$newfield->addClass="group"; // ajoute une classe au champ, utile pour faire un rule require_from_group
//$newfield->placeholder=$datas_lang["xxxx"];
//$newfield->label=$datas_lang["xxxx"];
//$newfield->widthLabel=2; // nom de colonnes de large pour le label
//$newfield->widthField=8; // nombre de colonnes de large pour le champ
//$newfield->counter="countType:'characters', maxCount:10, strictMax:true"; // ajoute d'un compteur de mot ou de car.
//$newfield->multiLang=false;
//$newfield->variablesAuthorized=false; // autorise l'insertion de variables
//$newfield->value=array("fr"=>"xxxx","en"=>"zzzz"); // valeur forcée..soit un string soit un array pour les multilangues
//$newfield->javascript="onChange='test(this)'"; // pour ensuite récuper l'ID de this, utiliser function test($this) { var id = $($this).attr('id'); }
//$newfield->tooltip="eeee";
//$newfield->autocomplete=false;

//$newfield->rule("required",true);
//$newfield->rule("min",1); // valeur minimum
//$newfield->rule("max",10); // valeur maximum
//$newfield->rule("number",true); // float
//$newfield->rule("digits",true); // integer
//$newfield->rule("alphanumeric",true); // alphanuméric
//$newfield->rule("url",true);
//$newfield->rule("email",true);
//$newfield->rule("minlength",1); // nb de caractères minimun
//$newfield->rule("maxlength",10); // nb de caractères maximum
//$newfield->rule("equalTo","'#email'"); // doit être égal à un autre champ
//$newfield->rule("require_from_group",'[X, ".class"]'); //  au moins X champs renseigné dans la class (mettre sur tout les champs)
//$newfield->rule("remote",array("script"=> "remoteTest.php","table"=>$myTable,"valOrigin"=>"FIELD:Finput","params"=>"x=xx"), $datas_lang["existedeja"]);  // appel un script en ajax qui doit retour 0 si false et pas 1 si c'est bon.
//
// le 3° paramètre d'un rule peut être une chaine de caractères correspondant au message personnalisé à afficher.

////////////////////////////
// Propriété spécifique à une DATE
//$newfield->showButtonPanel=false;
//$newfield->changeYear=true;
//$newfield->numberOfMonths=2;
//$newfield->minDate=-5;
//$newfield->maxDate="+1M +2D";
//$newfield->value= date('d.m.Y', strtotime("+1 days"));
//$newfield->dateFormat="dd.mm.yy";
// Propriété spécifique à une RANGE_DATE
//$newfield->value=array(date("d.m.Y"),date('d.m.Y', strtotime("+15 days")));

////////////////////////////
// Propriété spécifique à un SELECT, RADIO, CHECKBOX
//$newfield->items=array("Valeur"=>"texte");
//$newfield->noneItem=true; // affiche un item "Aucun élément" , on peut mettre une string pour personnaliser le texte
//$newfield->allItems="Tous"; // affiche un item "Tous les éléments", on peut mettre une string pour personnaliser le texte
//$newfield->valuesDisabled=array("C"); // item à mettre en disabled, peut être une string ou un tableau
////////////////////////////
// Propriété spécifique à un SELECT MULTIPLE
//$newfield->multiple=true; // Affichage des items sur une ligne
//$newfield->selectAll=false; // Ajoute un item "select All"
//$newfield->single=false; // N'autorise que le choix d'un seul élément == Select normal
//$newfield->filter=true; // Ajoute un moteur de recherche
//$newfield->isOpen=false; // ouvre la liste des items par défaut
//$newfield->keepOpen=false; // garde toujours ouvert la liste des items
//$newfield->minimumCountSelected=3; // Nombre d'éléments à partir du quel on affiche un message "X of Z selected"
//$newfield->countSelected='# of % selected'; // Change le message si minimumCountSelected atteint

////////////////////////////
// Propriété spécifique à un textarea
//$newfield->rows=10;

////////////////////////////
// Propriété spécifique à un slider
//$newfield->min=10;
//$newfield->max=300;
//$newfield->step=2;

////////////////////////////
// Propriété spécifique à un Editor
//$newfield->height=400;
//$newfield->toolbar="Default";

class field{

	public function __construct () {
		$this->widthLabel=2; // largeur par défaut de la colonne Label
		$this->widthField=8; // largeur par défaut de la colonne Field
		$this->disabled=false; 
		$this->typeField=get_class($this);
		$this->template="inc/fields/field.tpl";
				
	}
	
	///////////////////////////////////
	// ajout d'un champ de saisie
	public function add($param="") {
		
		global $myAdmin;
		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		$smarty->assign('classPlus',"");
		
		// largeur du label		
		if(is_unsigned_integer($this->widthLabel) && $this->widthLabel!="" ) {
			$this->str_widthLabel="col-" . $this->widthLabel;
		} else {
			$this->str_widthLabel="col-" . $formMaj->widthLabel;
		}
		// largeur du champ	
		if(is_unsigned_integer($this->widthField) && $this->widthField!="") {
			$this->str_widthField="col-" . $this->widthField;
		} else {
			$this->str_widthField="";
		}
		// Variables autorisée à être ajouté au champ
		if($this->variablesAuthorized==true) {
			$this->str_variablesAuthorized=" onfocus='have_focus()' onblur='loose_focus()'";
		} else {
			$this->str_variablesAuthorized="";
		}
		// placeholder
		if($this->placeholder!="") { 
			$this->str_placeholder=" placeholder='" . $this->placeholder . "' ";
		} else {
			$this->str_placeholder="";
		}

		if($this->multiLang==true) {
			$this->list_lang= $myAdmin->LIST_LANG_EXTENSION_FIELD;
		} else {
			$this->list_lang=array(""=>"");
		}
		
		if($this->disabled==true) {
			$this->str_disabled = " disabled=disabled";
			$this->state_disabled = " state-disabled";
		} else {
			$this->str_disabled="";
			$this->state_disabled="";
		}
		
		if($this->javascript!="") {
			$this->str_javascript= $this->javascript;
		} else {
			$this->str_javascript="";
		}
		
		if($this->tooltip!="") {
			$this->str_tooltip="<b class='tooltip tooltip-bottom-left'>" . $this->tooltip  . "</b>";
		} else {
			$this->str_tooltip="";
		}

		
		if($this->label=="") {
			$this->str_label=""; 
		} else { 
			$this->str_label="<label style='" . $this->addStyleLabel  . "' class='label col " . $this->str_widthLabel  . "'>" . $this->label . "</label>";
		}
		
		
		
		// autocomplete
		if($this->autocomplete===false) { 
			$this->str_autocomplete=" autocomplete='off' ";
		} else {
			$this->str_autocomplete="";
		}
				
	} // add
	
	///////////////////////////////////
	// assign un champ à smarty
	public function smartAssign($field,$data) {
		
		global $myAdmin;
		global $smarty;
		
		$smarty->assign("field_" . $field, $data);

	} // smartAssign
	
	///////////////////////////////////
	// ajoute des controles à un champ
	public function rule($type,$val,$message="") {
		
		global $myAdmin;
		global $smarty;
		global $formMaj;
        global $thisSite;

		$allrules = $smarty->getTemplateVars("allrules");
		$addClassRules = $smarty->getTemplateVars("addClassRules");

		foreach($this->list_lang as $clg=>$extlg){

			if(get_class($this)=="editor" && $type=="required") {
				$type=EDITOR."required";
			}
            
            if(get_class($this)=="select" && $type=="required") {
				$type="selectRequired";
			}
			
			if($type=="remote") {
				$valeur="";
				if($val["script"]!="") { 
					$valeur= "'" . $val["script"];
					$sepp="?";
					if($val["table"]!="") { $valeur.=$sepp . "table=" . $val["table"]; $sepp="&"; }
					if($val["params"]!="") { $valeur.=$sepp . $val["params"]; $sepp="&"; }
					if($val["valOrigin"]!="") { 
						list($const,$field) = explode(":",$val["valOrigin"]);
						if($const=="FIELD") {
							$valOriginLg=$formMaj->datasForm[$clg][$field];
							if($valOriginLg=="") { $valOriginLg=$formMaj->datasForm[""][$field]; }
							if($valOriginLg=="") { $valOriginLg=$formMaj->datasForm[$thisSite->LANG_DEF][$field]; }
							$valeur.=$sepp . "valOrigin=" . $valOriginLg; $sepp="&";
						} else {
							$valeur.=$sepp . "valOrigin=" . $val["valOrigin"]; $sepp="&";
						}
					}
					$valeur.= "'";
				}
				
			} else {
				$valeur=$val;
			}
			
			$rules=$allrules[$this->field . $extlg];
			
			if($rules=="") {
				$rules=$this->field . $extlg . ":{"; // on ajoute les infos d'entete du Rule (name:)
				$sep="";
			} else {
				$rules=substr($rules, 0, -2); // on supprime les infos de fin du Rule (;})
				$sep=", ";
			}
			
			if($this->typeField=="checkbox" && $type=="required") {
				$class=$this->field . $extlg;
				$addClassRules.= "$.validator.addClassRules('" . $class ."', { require_from_group: [1, '." . $class ."']});\n";
			} else { // normal
				$rules .=  $sep . $type . ":" . $valeur;
			}
			$rules .= "},"; // on rajoute les infos de fin du Rule

			$allrules[$this->field . $extlg]=$rules;
		}
		
		$smarty->assign("allrules", $allrules);
		$smarty->assign("addClassRules", $addClassRules);
		
		// ajout des messages
		if($message!="") {
			$allmessages = $smarty->getTemplateVars("allmessages");
			
			foreach($this->list_lang as $clg=>$extlg){
				
				$messages=$allmessages[$this->field . $extlg];
	
				if($messages=="") {
					$messages=$this->field . $extlg . ":{"; // on ajoute les infos d'entete du messages (name:)
					$sep="";
				} else {
					$messages=substr($messages, 0, -2); // on supprime les infos de fin du messages (;})
					$sep=", ";
				}
		
				$messages .=  $sep . $type . ":'" . addslashes($message) . "'";
				$messages .= "},"; // on rajoute les infos de fin du messages
	
				$allmessages[$this->field . $extlg]=$messages;
			}
				$smarty->assign("allmessages", $allmessages);
		}

	} // rule
	
	///////////////////////////////////
	// Ajoute un compteur de car ou de mot à un champ
	public function addCounter($field) {
		
		global $myAdmin;
		global $datas_lang;
        global $thisSite;
		
		if(is_unsigned_integer($this->counter)) {
			$dataCounter="countType:'characters', maxCount:" . $this->counter . ", strictMax:true";
		} else {
			$dataCounter=$this->counter;
		}

		if($this->counter!="") {
			$data="<div class='counter'>" . $datas_lang["counter_characters"] . "<span id='counter_" . $field . "'></span></div>";
			$data.="<script>$('#" . $field . "').simplyCountable({ counter:'#counter_" . $field . "', " . $dataCounter . "});</script>";
			return $data;
		}
	} // addCounter
			
	///////////////////////////////////
	// attribution des valeurs d'un champ suivant la langue
	public function getValue($x) {
		
		global $myAdmin;
		global $formMaj;
		global $datas_lang;
        global $thisSite;
		
		/*if($this->field=="sliderx") {
			echoa($this->value);
		}*/

		if(!isset($this->value)) {
			$value= $formMaj->datasForm[$x][$this->field];
            
			if ($x=="" && $value=="") { // si on trouve pas la valeur et que $x est à blanc, on cherche dans la langue par defaut
				$value= $formMaj->datasForm[$myAdmin->LANG_DATAS][$this->field];
			}
		} else {
			if(is_array($this->value)) {
				$value= $this->value[$x];
			} else {
				$value= $this->value;
			}
		}
		
		if($value=="") {
			if(is_array($this->defaultValue)) {
				$value= $this->defaultValue[$x];
			} else {
				$value= $this->defaultValue;
			}
		}
		
		return $value;
	} // getValue

	// preparation des paramètres Query de l'url qui appelle browse.php (pour champ File et EDITOR)
	public function prepareParamsBrowse($extlg) {
		
		global $myAdmin;
        global $thisSite;
        global $smarty;
		
		if(is_array($this->extensionsAuthorized)) { $ext=implode(",",$this->extensionsAuthorized); } else { $ext=$this->extensionsAuthorized; }
		
        $dimMax=$this->dimMax;
        $dimMaxArray=explode("x",$dimMax);
        
		if(is_array($this->dimThumbs)) { $dimThumbs=implode(",",$this->dimThumbs); } else { $dimThumbs=$this->dimThumbs; }

		return "&field=" . $this->field . $extlg . "&startFolder=" . $this->startFolder . "&uploadOK=" . $this->upload  . "&dimMax=" . $dimMax  . "&dimThumbs=" . $dimThumbs  . "&ext=" . $ext;
	}
    
    // preparation des paramètres  de l'url qui appelle l'outil d'upload
	public function preparePropUpload($src="",$multi=0) {

        global $thisSite;

        $dimMaxArray=explode("x",$this->dimMax);
        
		if(is_array($this->extensionsAuthorized)) { $ext=implode(",",$this->extensionsAuthorized); } else { $ext=$this->extensionsAuthorized; }

		if(is_array($this->dimThumbs)) { $dimThumbs=implode(",",$this->dimThumbs); } else { $dimThumbs=$this->dimThumbs; }
    
        upload_info($src, "../../../" . $thisSite->DOS_CLIENT_FILES . $this->startFolder . "/",$dimMaxArray,$dimThumbs,$ext,$multi);
        
	}
	
	///////////////////////////////////
	// Affichage icone Langue associé au champs
	public function iconeLangue() {
		if($this->multiLang==true && count($this->list_lang)>1) {
		 return true;	
		}
		return false;
	} // iconeLangue
		
} // field

include("fields/class.input.php");
include("fields/class.hidden.php");
include("fields/class.password.php");
include("fields/class.textarea.php");
include("fields/class.radio.php");
include("fields/class.checkbox.php");
include("fields/class.select.php");
include("fields/class.selectM.php");
include("fields/class.selectMCols.php");
include("fields/class.date.php");
include("fields/class.periode.php");
include("fields/class.rating.php");
include("fields/class.slider.php");
if(EDITOR=="CK") { include("fields/class.editorck.php"); }
if(EDITOR=="TM") { include("fields/class.editortm.php"); }
include("fields/class.file.php");
include("fields/class.mediaImage.php");
include("fields/class.mediaFile.php");
include("fields/class.mediaLink.php");
include("fields/class.mediaVideo.php");
?>