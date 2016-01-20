<?php
//////////////////////////////////////////////////////////////////////  
////// HIDDEN ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class hidden extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->multiLang=false;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
		
		$smarty->assign('this',$this);
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.hidden.tpl');

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>