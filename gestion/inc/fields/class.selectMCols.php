<?php
//////////////////////////////////////////////////////////////////////  
////// SELECT MULTIPLE EN COLONNE ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class selectMCols extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->multiLang=false;
		$this->tags=false;
		$this->selectAll=true;
		$this->filter=false;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 
		
		if(!is_array($this->items) && $this->tags!=true) return 0;
		
		global $myAdmin;
		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		if($this->tags==true) {
			$this->multiLang=false; // multilangue géré par la table des tags
		}
				
		
		$this->LIST_LANG_EXTENSION_FIELD=$myAdmin->LIST_LANG_EXTENSION_FIELD;

		parent::add();

		$smarty->assign('this',$this);
			
		$listDisabled=array();
		if(!is_array($this->valuesDisabled)) {
			$valuesDisabled=explode(",",$this->valuesDisabled);
			$listDisabled=$valuesDisabled; 
		} else {
			$listDisabled=$this->valuesDisabled; 
		}

		foreach($this->list_lang as $clg=>$extlg){ 
			
			$value= $this->getValue($clg);
			
			$values=explode(",",$value);
			
			if(!is_array($values)) { $values=array(); }
			
			if($this->tags==true) {
				if($listItems=="") {
					$listItems=array();
					$mySelect2 = new mySelect(__FILE__);
					$mySelect2->tables=$thisSite->PREFIXE_TBL_GEN . "tags";
					$mySelect2->fields="*";
					$mySelect2->where="parent=:parent AND lg=:lg";
					$mySelect2->whereValue["parent"]=array($this->field,PDO::PARAM_STR);
					$mySelect2->whereValue["lg"]=array("fr",PDO::PARAM_STR);
					$mySelect2->orderby="titre ASC";
					$result2=$mySelect2->query();
					foreach($result2 as $row2){
						$listItems[$row2['id']]=$row2['titre'];
					}
				}
			} else {
				$listItems=$this->items;
			}
			if($this->iconeLangue()==true || $this->tags==true) { 
				$smarty->assign('marginLeft',50);
			} else {
				$smarty->assign('marginLeft',0);
			}
			
			$indice=0;
			$datasItem=array();	
			$count_items=count($listItems);
			
			$myGroup="";
			foreach($listItems as $val=>$text){ 
	
				$val=delQuotes($val);
				$value=delQuotes($value);
				
				if(in_array($val,$listDisabled)) { $stateDisabled="state-disabled"; $disabled="disabled"; } else { $stateDisabled = ""; $disabled=""; }
				if(in_array(htmlspecialchars($val, ENT_QUOTES),$values)) { $selected="selected"; } else { $selected=""; }	
				
				if($count_items==1) { $str_indice=""; } else  { $str_indice="_" . $indice; }
				
				$idField= $this->field . $extlg . $str_indice; 
			
				$datasItem[$indice]=array("val"=>$val,"text"=>$text,"idField"=>$idField,"stateDisabled"=>$stateDisabled,"disabled"=>$disabled,"selected"=>$selected);

				$myGroup=$idField;
				$indice++;	
				$marginLeft=0;	
			}
			
			//echoa($datasItem);
			$datasItemByLg[$clg]=$datasItem;
			
		}	// lg
		
		$smarty->assign('datasItemByLg',$datasItemByLg);

		$allmyGroup = $smarty->getTemplateVars("myGroup");
		$allmyGroup .=$this->field . $extlg . ":\"" .  $myGroup . "\",\n";
		$smarty->assign("myGroup",$allmyGroup);
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.selectMCols.tpl');
	
		addStructure("addCssStructure",DOS_SKIN_ADMIN . "multi-select.css");
		addStructure("addJsStructure",DOS_OUTILS_ADMIN . "multi-select/jquery.multi-select.js");

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>