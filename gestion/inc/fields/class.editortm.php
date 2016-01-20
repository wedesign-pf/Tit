<?php
//////////////////////////////////////////////////////////////////////  
////// TINYMCE EDITOR ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class editor extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=true;
		$this->widthField=8;
		$this->toolbar='Default';
		$this->upload=true;
		$this->type="TM";
		$this->disabled=false;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $myAdmin;
		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		$this->LANG_DATAS=$myAdmin->LANG_DATAS;
		
		parent::add();
		$smarty->assign('this',$this);
		$smarty->assign('param',$param);
		
		$smarty->assign('language',$thisSite->LIST_LANG_COMP[$myAdmin->LANG_INTERFACE]);
		
		$toolbars=array();
		$toolbars["Default"][1] = "cut copy paste pastetext | undo redo | bold italic underline strikethrough | subscript superscript | removeformat | charmap emoticons hr nonbreaking";
	 	$toolbars["Default"][2] = "bullist numlist | outdent indent | alignleft aligncenter alignright alignjustify | image | inserttable tableprops deletetable cell row column | link unlink | anchor  | template  | visualblocks | code";
		$toolbars["Default"][3] = "styleselect  fontselect fontsizeselect | forecolor backcolor";
	 	$toolbars["Basic"][1] = "bold italic underline strikethrough | subscript superscript | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent";
	 	$toolbars["Basic"][2] = "styleselect | link unlink | image charmap | code";
	 	$toolbars["Simple"][1] = "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | link unlink | image charmap | code";
	 	$toolbars["Image"][1] = "image | code";
		$smarty->assign('toolbar',$toolbars[$this->toolbar]);

		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.editortm.tpl');

		addStructure("addJsStructure",DOS_OUTILS_ADMIN . "tinymceJQ/jquery.tinymce.min.js");
		addStructure("addJsStructure",DOS_OUTILS_ADMIN . "tinymceJQ/tinymce.min.js");
		
		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>