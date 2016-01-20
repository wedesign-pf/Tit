<?php
//$obj_article = new article("xxxx");
//if(isset($params_module["id"])) { $obj_article->where="id=" . $params_module["id"];  }
//if(isset($params_module["idPage"])) { $obj_article->where="id_page=" . $params_module["idPage"];  }
//$obj_article->limit="1";
//$obj_article->medias="image,video,file,link";
//$result=$obj_article->query();

class article {
	
	public $article;
	// création de l'objet
	public function __construct ($article) {
       $this->article = $article;
    }
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
 /////////////////////////////////////////////////////////
	public function query($debug="") {
		global $thisSite;
		
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "articles";
		if($this->fields=="") {
			$mySelect->fields="*";
		} else {
			$mySelect->fields=$this->fields;
		}
		
        $mySelect->where="actif=1 AND art = '" . $this->article  . "'";
        
		if($this->lg!="" && $this->lg!="all" ) { // si une langue est indiqué on l'utilise
			$mySelect->where.=" AND lg='" . $this->lg . "'";
		} else if($this->lg=="" ) { 
            $mySelect->where.=" AND lg='" . $thisSite->current_lang . "'";
        }
        
        if($this->id!="") {
			$mySelect->where.=" AND id=" . $this->id;
		}
		if($this->where!="") {
			$mySelect->where.=" AND " . $this->where;
		}
		
		if($this->orderby=="") {
			$mySelect->orderby="id ASC";
		} else {
			$mySelect->orderby=$this->orderby;
		}
		
		if($this->limit!="") {
			$mySelect->limit=$this->limit;
		}
		
		$result=$mySelect->query($debug);
		
		// on ajoute les médias si demandé
		$whatMedias=explode(",",$this->medias);
		if(count($whatMedias)>0) {
			foreach($result as $x=>$row){ 
				foreach($whatMedias as $media){ 
					$thisMedia = new media($this->article . "_" . $media);
					$thisMedia->idParent=$row["id"];
					$dataMedias=$thisMedia->get();
					$result[$x][$media]=$dataMedias;
				}
			}
		}
		
		return $result;
    }
} // thisArticle

?>