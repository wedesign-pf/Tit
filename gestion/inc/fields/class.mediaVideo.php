<?php
//////////////////////////////////////////////////////////////////////  
////// MEDIA VIDEO ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class mediaVideo extends field{

	public function __construct () {
		parent::__construct();
		
		global $datas_lang;
		
		$this->type="video";
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
				$value_fichier_media[$lg]= $rowS["fichier_media"];
				$value_titre_media[$lg]= $rowS["titre_media"];
				if($lg==$myAdmin->LANG_DEF) { // pour les données monolangue
					$value_idMedia= $rowS["id"];
					$value_fichier_media[""]= $rowS["fichier_media"];
					$value_titre_media[""]= $rowS["titre_media"];
				}
			}
		} else {
			$prefixe_field="";
		}

		$newfield = new select();
		$newfield->field="typeVideo";
		$newfield->widthLabel=2;
		$newfield->widthField=2;
		$newfield->addStyleLabel="margin-right:10px;"; 
		$newfield->label="";
		$newfield->multiLang=false;
		$newfield->defaultValue=$thisSite->TYPE_VIDEO_DEFAUT;
		$newfield->items=$thisSite->LIST_TYPE_VIDEO;
		$result=$newfield->add();
		$field_fichier_media=$result;


		$newfield = new input();
		$newfield->field=$prefixe_field . "fichier_media";
		$newfield->multiLang=$this->multiLangType;
		/*if($this->insideForm==true) { 
			$newfield->label=$this->label; 
		} else {
			$newfield->label=$datas_lang["lienVideo"];
		}*/
		$newfield->value=$value_fichier_media;
		$newfield->widthLabel=0;
		$newfield->widthField=3;
		$newfield->addClass=$this->addClass;
		if($this->placeholder=="") { 
			$newfield->placeholder=$datas_lang["placeholderVideo"];
		} else {
			$newfield->placeholder=$this->placeholder;
		}
		$newfield->tooltip=$this->tooltip;
		$result=$newfield->add();
		$field_fichier_media.=$result;
		if($this->fileRequired==true) { $newfield->rule("required",true); }

		
		// champ Titre: légende de l'image, du fichier ou du lien
		if($this->legendeEnabled==true) {
			$newfield = new input();
			$newfield->field=$prefixe_field . "titre_media";
			$newfield->multiLang=true;
			$newfield->value=$value_titre_media;
			$newfield->label=$datas_lang["legende"];
			$newfield->tooltip=$datas_lang["tooltipsLegende"];
			$newfield->widthLabel=2;
			$newfield->widthField=9;
			$result=$newfield->add();
			$field_titre_media=$result;
		}
		

		$smarty->assign('field_fichier_media',$field_fichier_media);
		$smarty->assign('field_titre_media',$field_titre_media);
		
		if($this->insideForm==true) {
			$newfield = new hidden();
			$newfield->field="fieldMedia__" . $this->field;
			$newfield->multiLang=false;
			$newfield->value=serialize(array("type"=>$this->type,"field_media"=>$this->field, "idMedia"=>$value_idMedia));
			$result=$newfield->add();
			$smarty->assign('fieldMediaField',$result);
		}
		
		$smarty->assign('this',$this);
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.mediaVideo.tpl');

		if($this->insideForm==true) {
			$this->smartAssign($this->field,$data);
		} else {
			$this->smartAssign("media",$data);
		}
		
		return $data;
	} // add


}
?>