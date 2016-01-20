<?php
//////////////////////////////////////////////////////////////////////  
////// CKEDITOR ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class editor extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=true;
		$this->widthField=8;
		$this->height=200;
		$this->toolbar='Default';
		$this->upload=true;
		$this->type="CK";
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $myAdmin;
		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
		
		$smarty->assign('this',$this);
		$smarty->assign('param',$param);
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.editorck.tpl');

		addStructure("addJsStructure",DOS_OUTILS_ADMIN . "ckeditor/ckeditor.js");
		addStructure("addJsStructure",DOS_OUTILS_ADMIN . "ckeditor/adapters/jquery.js");
		
		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>