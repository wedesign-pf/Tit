<?php
//////////////////////////////////////////////////////////////////////  
////// RADIO BOUTON ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class radio extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->multiLang=false;
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
		$smarty->assign('classPlus',"inline-group");

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
				$marginLeft=50;
			} else {
				$marginLeft=0;
			}
			
			$indice=0;
			$datasItem=array();	
			
			foreach($listItems as $val=>$text){ 
	
				$val=delQuotes($val);
				$value=delQuotes($value);
	
				if(in_array($val,$listDisabled)) { $stateDisabled="state-disabled"; $disabled="disabled"; } else { $stateDisabled = ""; $disabled=""; }
              
				if(htmlspecialchars($val, ENT_QUOTES) == $value) { $checked="checked"; } else { $checked=""; }	
				
				$idField= $this->field . $extlg . "_" . $indice; 
			
				$datasItem[$indice]=array("val"=>$val,"text"=>$text,"idField"=>$idField,"stateDisabled"=>$stateDisabled,"disabled"=>$disabled,"checked"=>$checked,"marginLeft"=>$marginLeft);
			
				$indice++;	
				$marginLeft=0;	
			}
			
			//echoa($datasItem);
			$datasItemByLg[$clg]=$datasItem;
			
		}	// lg
		
		$smarty->assign('datasItemByLg',$datasItemByLg);
					
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.radio.tpl');

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>