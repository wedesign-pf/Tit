<?php
//////////////////////////////////////////////////////////////////////  
////// MEDIA LINK ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class mediaLink extends field{

	public function __construct () {
		parent::__construct();
		
		global $datas_lang;
		
		$this->type="link";
		$this->insideForm=false;
		$this->multiLangType=true;
		$this->label=$datas_lang["addmajMedia"]; 
		$this->fileRequired=true;
		$this->legendeEnabled=true;
	}
	
	/////////////////////////////////// 
	public function add($param="") { 

		global $myAdmin;
		global $formMaj;
		global $datas_lang;
		global $smarty;
        global $thisSite;
		
		parent::add();
		
		if($this->insideForm==false) {
			$this->fileRequired=true;
			$this->legendeEnabled=true;
		}
		
		if($this->insideForm==true) {
			$prefixe_field=$this->field . "__";
			$mySelect = new mySelect(__FILE__);
			$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "medias";
			$mySelect->fields="*";
			$mySelect->orderby="id DESC"; // pour prendre le premier élément
			$mySelect->where="field_media=:field_media AND id_parent=:id_parent";
			$mySelect->whereValue["field_media"]=array($this->field ,PDO::PARAM_STR); //$formMaj->tables . "." . 
			$id_parent=$formMaj->datasForm[$myAdmin->LANG_DATAS]["id"];
			if($id_parent=="") { $id_parent=$formMaj->datasForm[""]["id"]; }
			$mySelect->whereValue["id_parent"]=array($id_parent,PDO::PARAM_INT);
			$resultmySelect=$mySelect->query();
			foreach($resultmySelect as $rowS){ 
				$lg=$rowS["lg"];
				$value_titre_media[$lg]= $rowS["titre_media"];
				$value_lien_destination[$lg]= $rowS["lien_destination"];
				$value_cible_destination[$lg]= $rowS["cible_destination"];
				if($lg==$myAdmin->LANG_DEF) { // pour les données monolangue
					$value_idMedia= $rowS["id"];
					$value_titre_media[""]= $rowS["titre_media"];
					$value_lien_destination[""]= $rowS["lien_destination"];
					$value_cible_destination[""]= $rowS["cible_destination"];
				}
			}
		} else {
			$prefixe_field="";
		}

		
		
		// champ Titre: légende de l'image, du fichier ou du lien
		if($this->legendeEnabled==true) {
			$newfield = new input();
			$newfield->field=$prefixe_field . "titre_media";
			$newfield->multiLang=true;
			$newfield->value=$value_titre_media;
			$newfield->label=$datas_lang["legende"];
			$newfield->addClass=$this->addClass;
			$newfield->tooltip=$datas_lang["tooltipsLegende"];
			$newfield->widthLabel=2;
			$newfield->widthField=9;
			$result=$newfield->add();
			$field_titre_media=$result;
		}

		$newfield = new input();
		$newfield->field=$prefixe_field . "lien_destination";
		$newfield->multiLang=$this->multiLangType;
		$newfield->label=$datas_lang["lien"];
		$newfield->widthLabel=2;
		$newfield->widthField=9;
		$newfield->value=$value_lien_destination;
		if($this->placeholder!="") { 
			$newfield->placeholder=$this->placeholder;
		} else {
			$newfield->placeholder="http://, https:// ...";
		}
		$result=$newfield->add();
		$field_lien_destination=$result;
		if($this->complete_url==true) { $newfield->rule("complete_url",true); }
		if($this->fileRequired==true) { $newfield->rule("required",true); }
		
		$newfield = new radio();
		$newfield->field=$prefixe_field . "cible_destination";
		$newfield->multiLang=false;
		$newfield->value=$value_cible_destination;
		$newfield->defaultValue="_blank";
		$newfield->label=$datas_lang["cible"];
		$newfield->items=$datas_lang["listeCible"];
		$newfield->widthLabel=2;
		$newfield->widthField=9;
		$result=$newfield->add();
		$field_cible_destination=$result;
		
		$smarty->assign('field_titre_media',$field_titre_media);
		$smarty->assign('field_lien_destination',$field_lien_destination);
		$smarty->assign('field_cible_destination',$field_cible_destination);

		if($this->insideForm==true) {
			$newfield = new hidden();
			$newfield->field="fieldMedia__" . $this->field;
			$newfield->multiLang=false;
			$newfield->value=serialize(array("type"=>$this->type,"field_media"=>$this->field, "idMedia"=>$value_idMedia));
			$result=$newfield->add();
			$smarty->assign('fieldMediaField',$result);
		}
		
		$smarty->assign('this',$this);
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.mediaLink.tpl');

		if($this->insideForm==true) {
			$this->smartAssign($this->field,$data);
		} else {
			$this->smartAssign("media",$data);
		}
		
		return $data;
	} // add

}
?>