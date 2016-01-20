<?php
//////////////////////////////////////////////////////////////////////  
////// INPUT ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class input extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=true;
		$this->readonly=false;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
		
		$smarty->assign('this',$this);

		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.input.tpl');

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>