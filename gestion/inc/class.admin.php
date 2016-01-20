<?php
class myAdmin{
	
	public $datas;

	public function __construct () {

        global $thisSite;
		
		$this->datasPage=array();

		$this->LANG_INTERFACE="fr";
		$this->LIST_LANG_DATAS=$thisSite->LIST_LANG;
		$this->LANG_DEF=$thisSite->LANG_DEF; // Langue par défaut 
		$this->LANG_ADMIN=$this->LANG_DEF; // langue de l'interface
		$this->LANG_DATAS=$this->LANG_DEF; // langue des contenus de l'interface
        
          
        // langues à contrôler dans les formulaires de l'administration
        $firstLangValue=$this->LIST_LANG_DATAS[$this->LANG_DATAS];
        $this->LIST_LANG_CONTROLE=array($this->LANG_DATAS =>$firstLangValue); 
  
  
		// extension langues pour les champs de saisie
		$this->LIST_LANG_EXTENSION_FIELD==array();
		foreach($this->LIST_LANG_DATAS as $clg=>$nlg){ 
			$this->LIST_LANG_EXTENSION_FIELD[$clg]="_" . $clg;
		}
		
		// extension reconnues et uploadable	
		$this->extentionsOk=array("jpg","jpeg","gif","png","pdf","vcf","doc","docx","xls","xlsx","odt","ppt","pps","csv","htm","bmp","tif","swf","zip","txt","mp3","wmv","m4a"); 
		
		$this->extentionsImagesOk=array("jpg","jpeg","gif","png");
		$this->suffixeVignettes="-vig";
		
		$this->chronoPages==array();
		
		$this->orderbyList="id ASC";
		$this->limitList=20;
		$this->elmsByPage=array(10,20,50,100,false);
		
		$this->genresPages=array("C"=>"Page créées","G"=>"Pages générées");
	}

	// Ajout à l'historique des pages
	public function setChronoPages($page="") {

		if(count($this->chronoPages)>20) { array_splice($this->chronoPages,0, 10); }

		if($page=="") { $page=$this->pageCurrent;}
		if(count($this->chronoPages)>0) { $last_page=end($this->chronoPages); }
		if($last_page!=$page) {
			$this->chronoPages[]=$page;
		}
	} // setChronoPages
	
	// Récupère un élément dans l'historique
	public function getChronoPages($indiceBack=0) {
		$countHisto=count($this->chronoPages);
		$indice=$countHisto-$indiceBack-1;
		if($indice<0) { $indice=0;}
		return $this->chronoPages[$indice];
	} // getChronoPages
	
	public function setDatasPage($key,$val,$page="") {
		if($page=="") { $page=$this->pageCurrent;}
		
		$datasPage=$this->datasPage[$page];
		$datasPage[$key]=($val);
		
		$this->datasPage[$page]=$datasPage;
		//echoa($this->datasPage);
	} // setDatasPage
	

	public function getDatasPage($key="",$page="") {
		if($page=="") { $page=$this->pageCurrent;}
		
		$datasPage=$this->datasPage[$page];
		
		if($key=="") {
			return 	$datasPage;
		} else {
			return $datasPage[$key];
		}
		
	} // getDatasPage
	
	
	///////////////////////////////////
	// Affichage Notification après une suppression
	public function delete_notification($deleteDone,$result) {
        
		global $myAdmin;
		global $datas_lang;
        global $thisSite;
        
		if($deleteDone) {
			$notification="";
			if($result===false || !isset($result)) {
				$notificationClass="jBox-Notice-red";
				$notification=("<div><i class='fa fa-times mrs'></i>" . $datas_lang["delKo"] . "</div>");
			} else {
				$notificationClass="jBox-Notice-green";
				$notification=("<div><i class='fa fa-check mrs'></i>" . $datas_lang["delOk"] . "</div>");
			}
			
			$notification=addslashes($notification);
			$myAdmin->notification=$notification;
			$myAdmin->notificationClass=$notificationClass;
		}
	} // delete_notification
	
	// Ajouter aux logs
	public function addLogs($page="",$action="",$idCurrent=0,$msg="") {
		
        global $thisSite;
        
		if($thisSite->SERVER == "local") return;
		
		if($page=="") { $page=$myAdmin->pageCurrent; }
		if($page==$this->lastPageLog && $action=="") { return 0; }
		
		$this->lastPageLog=$page;
		
		$myInsert = new myInsert(__FILE__);
		$myInsert->table=$thisSite->PREFIXE_TBL_ADM . "logs";;
		$myInsert->field["date"]=date("Ymd");
		$myInsert->field["heure"]=date("His");
		$myInsert->field["login"]=$this->LOGIN;
		$myInsert->field["page"]=$page;
		$myInsert->field["action"]=$action;
		$myInsert->field["idCurrent"]=$idCurrent;
		$myInsert->field["msg"]=$msg;
		
		$result=$myInsert->execute();

	} // addLogs
} 
?>