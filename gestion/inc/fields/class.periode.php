<?php
//////////////////////////////////////////////////////////////////////  
////// PERIODE DE DATES ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 

class periode extends date{

	public function __construct () {
		parent::__construct();
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $formMaj;
		global $datas_lang;
		global $smarty;
		global $thisSite;
		
		$fieldRacine = $this->field;
		
		$fieldBegin = $fieldRacine . "_beg";
		$fieldEnd = $fieldRacine . "_end";
		$data="";
		// date départ
		$this->field=$fieldBegin;
		
		$this->value= $this->valuesPeriode[0];
		$this->defaultValue=$this->defaultValuesPeriode[0];
		$value= $this->getValue("");
		$this->controleRange="onSelect: function( selectedDate ){\$('#scr_" . $fieldEnd . "').datepicker('option', 'minDate', selectedDate);},";
		$this->widthField=0;
		parent::add();
        if(strpos($this->required,"beg")===0) { $this->rule("required",true); } 
		$smarty->assign('this',$this);
		$data.= $smarty->fetch($this->pathTemplate .'inc/fields/class.date.tpl');

		// date fin
		$this->field=$fieldEnd;
		$this->value= $this->valuesPeriode[1];
		$this->defaultValue=$this->defaultValuesPeriode[1];
		$value= $this->getValue("");
		$this->controleRange="onSelect: function( selectedDate ){\$('#scr_" . $fieldBegin . "').datepicker('option', 'maxDate', selectedDate);},";
		$this->widthField=0;
		parent::add();
        if(strpos($this->required,"end")) { $this->rule("required",true); }
		$this->str_label="<label class='label col'><i class='fa fa-caret-right'></i></label>";
		$smarty->assign('this',$this);
		$data.= $smarty->fetch($this->pathTemplate .'inc/fields/class.date.tpl');

		$this->smartAssign($fieldRacine,$data);
						
		return $data;
	} // add

}
?>