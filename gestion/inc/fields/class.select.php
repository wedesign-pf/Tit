<?php
//////////////////////////////////////////////////////////////////////  
////// SELECT ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class select extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->multiLang=false;
		$this->widthField=0;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 
		
		if(!is_array($this->items)) return 0;

		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
		
		$smarty->assign('this',$this);

		$listDisabled=array();
		if(!is_array($this->valuesDisabled)) {
			$valuesDisabled=explode(",",$this->valuesDisabled);
			$listDisabled=$valuesDisabled; 
		} else {
			$listDisabled=$this->valuesDisabled; 
		}

		$listItemsByLg=array();
		
		foreach($this->list_lang as $clg=>$extlg){ 
			
			$value= $this->getValue($clg);
			
			$listItems=array();
			if(isset($this->noneItem)) {
				if($this->noneItem===true) { $listItems["noneItem"]=$datas_lang["noneItem"]; } else { $listItems["noneItem"]=$this->noneItem; }
			}
			if(isset($this->allItems)) {
				if($this->allItems===true) { $listItems["allItems"]=$datas_lang["allItems"]; } else { $listItems["allItems"]=$this->allItems; }
			}
		
			$listItems+=$this->items;
			
			if($this->iconeLangue()==true) { 
				$smarty->assign('marginLeft',50);
			} else {
				$smarty->assign('marginLeft',0);
			}
			
			$indice=0;
			$datasItem=array();	
			
			foreach($listItems as $val=>$text){ 
	
				$val=delQuotes($val);
				$value=delQuotes($value);
	
				if(in_array($val,$listDisabled)) { $stateDisabled="state-disabled"; $disabled="disabled"; } else { $stateDisabled = ""; $disabled=""; }
				if(htmlspecialchars($val, ENT_QUOTES) == $value) { $selected="selected"; } else { $selected=""; }	
				
				$idField= $this->field . $extlg . "_" . $indice; 
			
				$datasItem[$indice]=array("val"=>$val,"text"=>$text,"idField"=>$idField,"stateDisabled"=>$stateDisabled,"disabled"=>$disabled,"selected"=>$selected);
			
				$indice++;	
				$marginLeft=0;	
			}
			
			//echoa($datasItem);
			$datasItemByLg[$clg]=$datasItem;
			
		}	// lg
		
		$smarty->assign('datasItemByLg',$datasItemByLg);
					
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.select.tpl');
		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>