<?php
//////////////////////////////////////////////////////////////////////  
////// FILE ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class file extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=true;
		$this->upload=true;
        $this->uploadDirect=true;
        $this->multi=0;
		$this->browse=true;
		$this->showImage=false;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
        
        $this->preparePropUpload("",1);
            		
		$smarty->assign('this',$this);

		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.file.tpl');

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>