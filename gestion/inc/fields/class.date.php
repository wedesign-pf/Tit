<?php
//////////////////////////////////////////////////////////////////////  
////// DATE ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class date extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->multiLang=false;
		$this->rangeDate=false;
		$this->showButtonPanel=true;
		$this->changeYear=false;
		$this->numberOfMonths=1;
		$this->dateFormat="dd/mm/yy"; 
		//http://api.jqueryui.com/datepicker/
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
	
		$smarty->assign('this',$this);

		$src_valueLg=array();
		foreach($this->list_lang as $clg=>$extlg){
			
			$value= $this->getValue($clg);
			$src_value= format_date($value,".");

			$src_valueLg[$clg]=$src_value;
		}
		$smarty->assign('src_valueLg',$src_valueLg);

		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.date.tpl');

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>