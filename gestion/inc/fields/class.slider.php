<?php
//////////////////////////////////////////////////////////////////////  
////// SLIDER ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class slider extends field{

	public function __construct () {
		parent::__construct();
		$this->variablesAuthorized=false;
		$this->multiLang=false;
		$this->min=0;
		$this->max=100;
		$this->step=0;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
		
		$smarty->assign('this',$this);
		
		$rangeLg=array();
		foreach($this->list_lang as $clg=>$extlg){
			
			$value= $this->getValue($clg);
	
			$values=explode(",",$value); 
			if(count($values)==2) {
				$range=1;
			} else if(count($values)==1) {
				$range=0;
			} else {
				return false;	
			}
			$rangeLg[$clg]=$range;
		}
		$smarty->assign('rangeLg',$rangeLg);
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.slider.tpl');

		$this->smartAssign($this->field,$data);
		
		return $data;
	} // add

}
?>