<?php
class classPage{

	public function __construct () {

	}

	// Ajoute une page  //////////////////////////////////////////////
	// $this->table : Table d'origine des données
	// $this->idCurrent : ID dans la Table d'origine 
	// $this->idPageParent : ID Parent de la page dans l'arbo (utiliser uniquement si ajout dand l'arbo)
	// $this->code_menu : Code du menu dans lequel insérer la page dans l'arbo (utiliser uniquement si ajout dand l'arbo)
	// $this->page_type : Type de la page à créer
	// $this->page_recherche : booleen
	// $this->page_parent : booleen
	// $this->show_sousmenu : booleen
	// $this->show_in_arbo : booleen. Autorise l'ajout de la page dans l'arbo
	// $this->page_php
	// $this->page_tpl
	// $this->page_genre : G pour les pages générées
	
	public function addPage() {
	
		global $myAdmin;
		global $PDO;
		global $__POST;
        global $thisSite;
		
		if($this->idCurrent==0) { return false; }

		if($this->page_type=="") { $this->page_type="page"; }
		if($this->page_recherche=="") { $this->page_recherche=1; }
		if($this->page_parent=="") { $this->page_parent=0; }
		if($this->show_sousmenu=="") { $this->show_sousmenu=0; }
		if($this->show_in_arbo=="") { $this->show_in_arbo=0; }
		if($this->page_php=="") { $this->page_php=""; }
		if($this->page_tpl=="") { $this->page_tpl=""; }
		if($this->page_genre=="") { $this->page_genre=""; }
		
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$this->table;
		$mySelect->fields="id_page";
		$mySelect->where="id=:idCurrent";
		$mySelect->whereValue["idCurrent"]=array($this->idCurrent,PDO::PARAM_INT);
		$mySelect->limit=1;
		$result=$mySelect->query();
		$row = current($result);
		$this->idPage=$row["id_page"];
		
		if($this->idPage>0) {
			$mySelect = new mySelect(__FILE__);
			$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "pages";
			$mySelect->fields="id";
			$mySelect->where="id=:id_page AND lg=:lg";
			$mySelect->whereValue["id_page"]=array($this->idPage,PDO::PARAM_INT);
			$mySelect->whereValue["lg"]=array($myAdmin->LANG_DEF,PDO::PARAM_STR);
			$result=$mySelect->count(); 
			if($result>0) {
				$mode="update";	
			} else {
				$mode="insert";
			}
		} else {
			if($this->idPage==0) {
				$this->idPage = $PDO->getNextID($thisSite->PREFIXE_TBL_GEN . "pages",$this->nextIdMin,$this->nextIdMax);
				$mode="insert";
			} else {
				$mode="update";
			}
		}

		$actif=$__POST["actif"];
		if($actif!="1" && $actif!="0") { $actif=1; } 
	
		foreach($myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extLg){ 
			
			if($mode=="update") {
				$myUpdate = new myUpdate(__FILE__);
				$myUpdate->table=$thisSite->PREFIXE_TBL_GEN . "pages";
				if($__POST["titre".$extLg]!="") { $myUpdate->field["titre"]=$__POST["titre".$extLg]; } 
				if($__POST["titre".$extLg]!="") { $myUpdate->field["page_titre"]=$__POST["titre".$extLg]; } 
				$myUpdate->field["actif"]=$actif;
				$myUpdate->where="id=:id_page AND lg=:lg";
				$myUpdate->whereValue["id_page"]=array($this->idPage,PDO::PARAM_INT);
				$myUpdate->whereValue["lg"]=array($clg,PDO::PARAM_STR);
				$result=$myUpdate->execute();
			}
			
			if($mode=="insert") {
				$page_url = sanitize_string_for_url($__POST["titre".$extLg]);
			
				$myInsert = new myInsert(__FILE__);
				$myInsert->table=$thisSite->PREFIXE_TBL_GEN . "pages";
				$myInsert->field["id"]=$this->idPage;
				$myInsert->field["lg"]=$clg;
				$myInsert->field["titre"]=$__POST["titre".$extLg];
				$myInsert->field["page_titre"]=$__POST["titre".$extLg];
				$myInsert->field["actif"]=$actif;
				$myInsert->field["page_genre"]=$this->page_genre;
				$myInsert->field["page_type"]=$this->page_type;
				$myInsert->field["page_url"]=$page_url;
				$myInsert->field["page_php"]=$this->page_php;
				$myInsert->field["page_tpl"]=$this->page_tpl;
				$myInsert->field["page_tag_title"]=$__POST["titre".$extLg];
				$myInsert->field["page_tag_keywords"]="";
				$myInsert->field["page_tag_description"]="";
				$myInsert->field["page_tag_robots"]="index,follow";
				$myInsert->field["page_sitemap_changefreq"]="monthly";
				$myInsert->field["page_recherche"]=$this->page_recherche;
				$myInsert->field["page_parent"]=$this->page_parent;
				$myInsert->field["show_sousmenu"]=$this->show_sousmenu;
				$myInsert->field["show_in_arbo"]=$this->show_in_arbo;
				$myInsert->field["article_tableId"]=$this->table . "." . $this->idCurrent ;
				$result=$myInsert->execute();
				
				$myUpdate = new myUpdate(__FILE__);
				$myUpdate->table=$this->table;
				$myUpdate->field["id_page"]=$this->idPage;
				$myUpdate->where="id=:idCurrent AND lg=:lg";
				$myUpdate->whereValue["idCurrent"]=array($this->idCurrent,PDO::PARAM_INT);
				$myUpdate->whereValue["lg"]=array($clg,PDO::PARAM_STR);
				$result=$myUpdate->execute();
				
	
				
			}
			
		}
		
		if($mode=="insert" && $this->show_in_arbo==1) {
			 $this->addArbo();
		}
		
		return $this->idPage;
	}
	
	
	// ajout d'une page à l'arborescence du site //////////////////////////////////////////////
	// $this->idPage : ID de la page
	// $this->idPageParent : ID Parent de la page dans l'arbo
	// $this->code_menu : Code du menu dans lequel insérer la page dans l'arbo
	public function addArbo() {
        global $thisSite;
        
		if($this->idPage==0 || $this->idPage=="" ) { return false; }

		$myTable=$thisSite->PREFIXE_TBL_GEN . "arbo";
		
		if($this->idPageParent=="") { $this->idPageParent=0; }
		if($this->code_menu=="noneItem" || $this->code_menu=="" ) { $this->code_menu="horsmenu"; }

		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$myTable;
		$mySelect->fields="arbo_menu";
		$mySelect->where="code_menu='" . $this->code_menu . "'";
		$result=$mySelect->query();	
		$row = current($result);
		$arbo_menu=unserialize($row['arbo_menu']);
	
		if(is_array($this->idPageParent)) {
			$arbo_menu[$this->idPageParent[0]][$this->idPageParent[1]][$this->idPage]="";
		} else if($this->idPageParent>0) {
			$arbo_menu[$this->idPageParent][$this->idPage]="";
		} else {
			$arbo_menu[$this->idPage]="";
		}
		$myUpdate = new myUpdate(__FILE__);
		$myUpdate->table=$myTable;
		$myUpdate->field["arbo_menu"]=serialize($arbo_menu);
		$myUpdate->where="code_menu='" . $this->code_menu . "'";
		$result=$myUpdate->execute();
	}

	
} 
?>