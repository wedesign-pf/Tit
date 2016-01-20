<?php
//////////////////////////////////////////////////////////////////////  
////// PASSWORD ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
//http://stackoverflow.com/questions/18746234/jquery-validate-plugin-password-check-minimum-requirements-regex
class password extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->widthField=4;
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
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.password.tpl');

		$this->smartAssign($this->field,$data);
			
		return $data;
	} // add

} 
?>