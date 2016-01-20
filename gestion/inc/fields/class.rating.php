<?php
//////////////////////////////////////////////////////////////////////  
////// RATING ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class rating extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->multiLang=false;
		$this->max=5;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $formMaj;
		global $datas_lang;
		global $smarty;
		global $thisSite;
        
		parent::add();
		
		$smarty->assign('this',$this);
		
		$liste=array();
		for ($indice = $this->max; $indice >= 1; $indice--) {
		//for ($indice = 1; $indice <= $this->max; $indice++) {			
			$liste[]=$indice;
		}
		$smarty->assign('liste',$liste);
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.rating.tpl');

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>