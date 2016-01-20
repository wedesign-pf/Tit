<?php
//////////////////////////////////////////////////////////////////////  
////// MEDIA IMAGE ///////////////////////////////////  
////////////////////////////////////////////////////////////////////// 
class mediaImage extends field{

	public function __construct () {
		parent::__construct();
		
		global $datas_lang;
		
		$this->type="image";
		$this->insideForm=false;
		$this->multiLangType=true;
		$this->multiLangDestination=true; 
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
				$value_fichier_destination[$lg]= $rowS["fichier_destination"];
				$value_lien_destination[$lg]= $rowS["lien_destination"];
				$value_cible_destination[$lg]= $rowS["cible_destination"];
				if($lg==$myAdmin->LANG_DEF) { // pour les données monolangue
					$value_idMedia= $rowS["id"];
					$value_fichier_media[""]= $rowS["fichier_media"];
					$value_titre_media[""]= $rowS["titre_media"];
					$value_fichier_destination[""]= $rowS["fichier_destination"];
					$value_lien_destination[""]= $rowS["lien_destination"];
					$value_cible_destination[""]= $rowS["cible_destination"];
				}
			}
		} else {
			$prefixe_field="";
		}

		$newfield = new file();
		$newfield->field=$prefixe_field . "fichier_media";
		$newfield->multiLang=$this->multiLangType;
		if($this->insideForm==true) { 
			$newfield->label=$this->label; 
		} else {
			$newfield->label=$datas_lang["fichier_media"];
		}
		$newfield->value=$value_fichier_media;
		$newfield->startFolder=$this->startFolder;
		$newfield->placeholder=$this->placeholder;
		$newfield->tooltip=$this->tooltip;
		$newfield->addClass=$this->addClass;
		$newfield->showImage=true;
		$newfield->dimMax=$this->dimMax;
		$newfield->dimThumbs=$this->dimThumbs;
        $newfield->multi=$this->multi;
        $newfield->upload=$this->upload;
        $newfield->uploadDirect=$this->uploadDirect;
		$newfield->extensionsAuthorized="images";
		if($this->extensionsAuthorized!="") {
			$newfield->extensionsAuthorized=$this->extensionsAuthorized;
		}
		$newfield->widthLabel=2;
		$newfield->widthField=9;
		$result=$newfield->add();
		$field_fichier_media=$result;
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
		
		// champ file destination
		if($this->actionDestination=="file") {
			$newfield = new file();
			$newfield->field=$prefixe_field . "fichier_destination";
			$newfield->multiLang=$this->multiLangDestination;
			$newfield->value=$value_fichier_destination;
			$newfield->label=$datas_lang["fichier"];
			$newfield->startFolder=$this->startFolder . "/fichiers";
            $newfield->multi=$this->multi;
            $newfield->upload=$this->upload;
            $newfield->uploadDirect=false;
			$newfield->widthLabel=2;
			$newfield->widthField=9;
			$result=$newfield->add();
			$field_fichier_destination=$result;
		}
		
		// champ link destination
		if($this->actionDestination=="link") {
			$newfield = new input();
			$newfield->field=$prefixe_field . "lien_destination";
			$newfield->multiLang=$this->multiLangDestination;
			$newfield->label=$datas_lang["lien"];
			$newfield->widthLabel=2;
			$newfield->widthField=9;
			$newfield->value=$value_lien_destination;
			$newfield->placeholder="http://, https:// ...";
			$result=$newfield->add();
			$field_lien_destination=$result;
			//$newfield->rule("complete_url",true);
			
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
		}

		$smarty->assign('field_fichier_media',$field_fichier_media);
		$smarty->assign('field_titre_media',$field_titre_media);
		$smarty->assign('field_fichier_destination',$field_fichier_destination);
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
		
		$data = $smarty->fetch($this->pathTemplate .'inc/fields/class.mediaImage.tpl');

		if($this->insideForm==true) {
			$this->smartAssign($this->field,$data);
		} else {
			$this->smartAssign("media",$data);
		}
		
		return $data;
	} // add

}
?>