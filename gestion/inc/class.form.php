<?php
class formList{
	
	public $datasList;
	
	public function __construct ($debug=0) {
		global $smarty;
		global $myAdmin;
		
		$smarty->assign("formList", $this);
		$smarty->registerObject('formList',$this);
		
		$this->pagination=true;
	}
	
	///////////////////////////////////
	// préparation des paramètres WHERE de la requete de sélection des éléments à lister
	public function clause_where($debug=0) {
		global $myAdmin;
		
		//$this->whereFull= "lg='" . $myAdmin->LANG_DATAS . "'";
		$this->whereFull= "0=0";

		if(isset($this->where)) { $this->whereFull.=" AND " . $this->where; }
		if(is_array($this->whereValue)) { 
			foreach($this->whereValue as $key=>$datas) {
				$whereValue[$key]=$datas;
			}
		}

		$this->whereValueFull = $whereValue;

		return 1;
		
	} // clause_where
	
	///////////////////////////////////
	// chargement des données
	public function get_datas($debug=0) {
		
		global $myAdmin;
		global $smarty;
		global $__POST;
		global $actionsPage;
		//if($myAdmin->PRIVILEGE==9 && $debug==0 ) { $debug=1; }

		if(isset($__POST["orderby"]) && $__POST["orderby"]!="") {
			$orderby=$__POST["orderby"];
		} else {
			if($myAdmin->getDatasPage("orderby")!="") {
				$orderby=$myAdmin->getDatasPage("orderby");
			} else {
				$orderby=$this->orderby;
			}
		}
		if(!isset($orderby)) { $orderby = $myAdmin->orderbyList; }
		
		

		if(strpos($orderby, "ASC")===false && strpos($orderby, "DESC")===false) {
			$orderby="id ASC";
		}
		
		if(isset($__POST["start"]) && $__POST["start"]!="") {
			$start=$__POST["start"];
		} else {
			if($myAdmin->getDatasPage("start")!="") {
				$start=$myAdmin->getDatasPage("start");
			} else {
				$start=$this->start;
			}
		}
		if(!isset($start)) { $start = 0; }
		
		
		if(isset($__POST["limit"]) && $__POST["limit"]!="") {
			$limit=$__POST["limit"];
		} else {
			if($myAdmin->getDatasPage("limit")!="") {
				$limit=$myAdmin->getDatasPage("limit");
			} else {
				$limit=$this->limit;
			}
		}
		if(!isset($limit)) { $limit = $myAdmin->limitList; }
		
		if(in_array("move", $actionsPage) &&  $this->fields!="*") {
			$this->fields.=",chrono";
		}

		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$this->tables;
		$mySelect->fields=$this->fields;
		//$mySelect->limit=10;
		$mySelect->orderby=$orderby;
		if($this->groupby!="") { $mySelect->groupby = $this->groupby; }
		$mySelect->where=$this->whereFull;
		$mySelect->whereValue=$whereValueFull;
		$result=$mySelect->query($debug);
		foreach($result as $row){ 
			foreach ($row as $k => $v) {
				$k = htmlspecialchars($k, ENT_QUOTES);
				$row[$k] = htmlspecialchars($row[$k], ENT_QUOTES);
			} 

			if($row["id"]!="") {
				$this->datasList[$row["id"]]=$row;
			} else {
				$this->datasList[]=$row;
			}
			//echoa($row);
		}

		// Crop and Limit the items if desired.
		if(count($this->datasList)>0) {
			if ($start || $limit) {
				$this->datasList = array_slice($this->datasList, $start, ($limit ? $limit : false), true);
			}
		}

		if($debug==3) { echoa($this->datasList); }
		
		$count_datas=$mySelect->count(x);
		
		if($this->pagination==true) {
			if ($start || $limit) {
				//Calcul HTML of Pagination links
				$getPagination  = 'Page: ';
				$pages = ceil($count_datas / $limit);
		
				for ($page = 0; $page < $pages; $page++) {
					if($start==($limit * $page)) { $class='class="pagin actif"'; } else { $class='class="pagin"'; }
					$getPagination .= '<a ' .  $class . ' href="' . ($limit * $page) . '">'.($page + 1).'</a>';
				}
		
				$getElmsByPage = 'page de ';
				foreach($myAdmin->elmsByPage as $x){
					if($limit==$x) { $class='class="elmsByPage actif"'; } else { $class='class="elmsByPage"'; }
					$getElmsByPage .= '<a ' .  $class . ' href="' . $x . '">'. ($x == false ? "~" : $x) .'</a>';
				}
			}
		} else {
			$getPagination="";
			$start=0;
			$limit=100;
		}
		
		$smarty->assign("getPagination", $getPagination);
		$smarty->assign("getElmsByPage", $getElmsByPage);
		$smarty->assign("totPagination", ($start + $limit) >  $count_datas ? $count_datas : ($start + $limit));
	
		$smarty->assign("orderby", $orderby);
		$smarty->assign("start", $start);
		$smarty->assign("limit", $limit);
		$smarty->assign("count_datas", $count_datas);

		$myAdmin->setDatasPage("orderby",$orderby);
		$myAdmin->setDatasPage("start",$start);
		$myAdmin->setDatasPage("limit",$limit);
		
		return $count_datas;
		
	} // get_datas

	
} // formList

//////////////////////////////////////////////////////////////////////////////////////////////////
class formMaj{
	
	public $datasForm;
	public $widthLabel;
	
	public function __construct ($debug=0) {
		global $smarty;
		$smarty->assign("formMaj", $this);
		$smarty->registerObject('formMaj',$this);
		
	}
	
	///////////////////////////////////
	// préparation des paramètres WHERE des requetes SELECT et UPDATE
	public function clause_where($debug=0) {
		global $myAdmin;
			
		$this->whereFull=$this->where;
		
		if($this->multiLang==true) {
			$this->whereFull.= " AND lg=:lg";
			$boucle=$myAdmin->LIST_LANG_EXTENSION_FIELD;
		} else {
			$boucle[""]="";
		}

		foreach( $boucle as $clg=>$extlg){
			if(is_array($this->whereValue)) {
				foreach($this->whereValue as $key=>$datas) {
					$whereValue[$key]=$datas;
				}
			}
			if($this->multiLang==true) {  $whereValue["lg"]=array($clg,PDO::PARAM_STR); }
				//echoa($whereValue);
			$this->whereValuebyLg[$clg] = $whereValue;
		}

		return 1;
		
	} // clause_where
	
	///////////////////////////////////
	// chargement des données
	public function get_datas($debug=0) {
		global $myAdmin;
		
		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$this->tables;
		$mySelect->fields=$this->fields;
		$mySelect->limit=1;
		$mySelect->where=$this->whereFull;
		
		foreach( $this->whereValuebyLg as $clg=>$whereValueFull){

			$mySelect->whereValue=$whereValueFull;
			$result=$mySelect->query($debug);
			$row = current($result); 
			//echoa($row);
			if(is_array($row)) {
				foreach ($row as $k => $v) {
					$k = htmlspecialchars($k, ENT_QUOTES);
					$row[$k] = htmlspecialchars($row[$k], ENT_QUOTES);
				} 
				$this->datasForm[$clg]=$row;
			} else {
				$this->datasForm[$clg]=array();
			}
			//echoa($row);
		}
		
		if($debug==3) { echoa($this->datasForm); }
		
		return 1;
		
	} // get_datas
	
	///////////////////////////////////
	public function count_datas($clg) {
		global $myAdmin;

		$mySelect = new mySelect(__FILE__);
		$mySelect->tables=$this->tables;
		$mySelect->where=$this->whereFull;

		$mySelect->whereValue=$this->whereValuebyLg[$clg];
		$result=$mySelect->count();

		return $result;
		
	} // count_datas
	
	///////////////////////////////////
	// mise à jour des données
	public function set_datas($debug=0) {
		
		global $myAdmin;
		global $PDO;
		global $__POST;
		global $datas_lang;
		global $idCurrent;
		global $majInsert;

		$this->TableFields =$PDO->getFieldsName($this->tables);

		foreach( $this->whereValuebyLg as $clg=>$whereValueFull){

			$extlg = $myAdmin->LIST_LANG_EXTENSION_FIELD[$clg];

			if($this->count_datas($clg)>0) { // UPDATE

				$myUpdate = new myUpdate(__FILE__);
				$myUpdate->table=$this->tables;
				$myUpdate->where=$this->whereFull;
				$myUpdate->whereValue=$whereValueFull;

				//echoa($TableFields);
				//echoa($__POST);
				$fields = $this->prepare_maj_fields($extlg,"update");
				foreach($fields as $fieldName=>$value) {
					$myUpdate->field[$fieldName]=$value;
				}
				
				$result=$myUpdate->execute();
				
			}  else { // INSERT

				$myInsert = new myInsert(__FILE__);
				$myInsert->table=$this->tables;

				if($this->multiLang==true) { $myInsert->field["lg"]=$clg; }

				if($idCurrent>0) {  
					$myInsert->field["id"]=$idCurrent;
					$chrono=$PDO->getNextChrono($this->tables,$idCurrent);
					if($chrono>0) {	$myInsert->field["chrono"]=$chrono;	}
					
				} else { // on recherche le dernier ID et on ajoute 1
				
					$idCurrent=$PDO->getNextID($this->tables, $this->nextIdMin, $this->nextIdMax);
					$myInsert->field["id"]=$idCurrent;
					$chrono=$PDO->getNextChrono($this->tables);
					if($chrono>0) {	$myInsert->field["chrono"]=$chrono;	}
				} 
	
				$fields = $this->prepare_maj_fields($extlg,"insert");
				foreach($fields as $fieldName=>$value) {
					$myInsert->field[$fieldName]=$value;
				}
				
				$result=$myInsert->execute();
			
			} // $this->count_datas($clg)>0
	
		} // langue 
		
		if($this->maj_media_inside==false) { $this->maj_media_inside($idCurrent); } // pour éviter la récurcivité
		
		if($majInsert==1) { $action="INS"; } else { $action="UPD"; }
		$myAdmin->addLogs($myAdmin->pageCurrent,$action,$idCurrent,$result);
		
	//////
	// Fin de la mise à jour
	// Choix Notification et reroutage éventuel
		
		$notification="";
		if($result===false || !isset($result)) {
			$notificationClass="jBox-Notice-red";
			$notification=("<div><i class='fa fa-times mrs'></i>" . $datas_lang["majKo"] . "</div>");
		} else {
			$notificationClass="jBox-Notice-green";
			$notification=("<div><i class='fa fa-check mrs'></i>" . $datas_lang["majOk"] . "</div>");
		}
		
		$notification=addslashes($notification);
		$myAdmin->notification=$notification;
		$myAdmin->notificationClass=$notificationClass;

		if($_POST["actionForm"]=="valider" && $notification=="" ) { 
			exit;
		}
		
		return $idCurrent;
	} // set_datas
	
	///////////////////////////////////
	// préparation des champs pour la mise à jour
	public function prepare_maj_fields($extlg,$typeMaj) {
		
		global $myAdmin;
		global $__POST;
		
		$fieldMaj=array();
		
		foreach($this->TableFields as $x=>$fieldName) {
			// on regarde si le champ existe avec l'extension de la langue
			if (array_key_exists($fieldName . $extlg, $__POST)) {
				$value=$__POST[$fieldName . $extlg];
				$fieldMaj[$fieldName]=$value;
				//echo("$fieldName : $value<br>");	
			} else if (array_key_exists($fieldName, $__POST)) { // sinon on vérifie si il existe sans l'extension de la langue
				$value=$__POST[$fieldName];
				$fieldMaj[$fieldName]=$value;
				//echo("$fieldName : $value<br>");	
			}
		}

		// traitement des champs supplémentaires à ajouter à un INSERT
		if($typeMaj=="insert" && is_array($this->fieldInsert)) {
			foreach($this->fieldInsert as $key=>$value) {
				$fieldMaj[$key]=$value;
			}
		}
		
		// traitement des champs supplémentaires à ajouter à un UPDATE
		if($typeMaj=="update" && is_array($this->fieldUpdate)) {
			foreach($this->fieldUpdate as $key=>$value) {
				$fieldMaj[$key]=$value;
			}
		}
		
		return $fieldMaj;
		
		
	} // prepare_maj_fields
	
	///////////////////////////////////
	// Mise à jour de données Media si intégré dans un formulaire
	public function maj_media_inside($idParent) { 

		global $myAdmin;
		global $__POST;
		global $idCurrent;
        global $thisSite;

		$copy__POST=$__POST;
		$copy__POST2=$__POST;
		foreach($copy__POST as $field=>$val) { // on cherche les champs commencant par fieldMedia__ qui indique qu'il y a des champs médias
        
			if(strpos($field, "fieldMedia__")===0) {
 				$liste=unserialize($val); 
                
				if($liste["type"]=="video") {
					$type=$liste["type"]. "-" . $copy__POST["typeVideo"];
				} else {
					$type=$liste["type"];
				}
                
  
//echoa("<hr>");              
//echoa($type);
//echoa($liste["field_media"]);
//echoa($__POST);

				$field_media=$liste["field_media"];
				$idMedia=$liste["idMedia"];
				$prefixe=substr($field,strlen("fieldMedia__"),100) . "__";
				$len_prefixe = strlen($prefixe);
				
                // on vide avant de remplir avec les données d'un nouveau média
                $__POST["fichier_media"]="";
                $__POST["titre_media"]="";
                $__POST["fichier_destination"]="";
                $__POST["lien_destination"]="";
                $__POST["cible_destination"]="";
                if(count($myAdmin->LIST_LANG_DATAS)>1) {
                    foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){ 
                        $__POST["fichier_media_".$clg]="";
                        $__POST["titre_media_".$clg]="";
                        $__POST["fichier_destination_".$clg]="";
                        $__POST["lien_destination_".$clg]="";
                        $__POST["cible_destination_".$clg]="";
                    }
                }
                
               // echoa($copy__POST2);
                $emptyControl=array();
				foreach($copy__POST2 as $field2=>$val2) { // on cherche les champs médias correspondant
					
					if(strpos($field2, $prefixe)===0) { 
                        // echoa($field2." : ".$val2);
						$fieldOk=substr($field2,$len_prefixe,100);
                        
                        // on ajoute des éléments avec un nom de champs que set_datas pourra exploiter
						$__POST[$fieldOk]=$val2;  
                        foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){
                            $__POST[$fieldOk . "_" . $clg]=$val2;
                        }
                        //echoa("." . $fieldOk . " : " . $val2);
                        
                        if($liste["type"]=="link" && strpos($fieldOk,"lien_destination")===0 ) {
                            $emptyControl[]=$fieldOk;
                        }
                        if($liste["type"]!="link" && strpos($fieldOk,"fichier_media")===0 ) {
                            $emptyControl[]=$fieldOk;
                        }
					}
					
				} //$__POST 2
				//echoa($emptyControl);
               
             // echoa($__POST);
	
               $empty=0;
               foreach($emptyControl as $fieldOk) {
                  //  echoa("-" . $liste["field_media"]."__" . $fieldOk);
                    if($copy__POST2[$liste["field_media"]."__" . $fieldOk]=="") {
                        $empty++;   
                    }
               }            
               
              // echoa($empty);
              
               if($empty==count($emptyControl)) { 
               
                    if($idMedia!="") { // on supprime le media 
                        $myDeleteM = new myDelete(__FILE__);
                        $myDeleteM->table=$thisSite->PREFIXE_TBL_GEN . "medias";
                        $myDeleteM->where="id=:id";
                        $myDeleteM->whereValue["id"]=array($idMedia,PDO::PARAM_STR);
                        $result=$myDeleteM->execute();
                    }
                    
                    continue;
               
               }
                
				$idCurrent=0; // attention, on remet à blanc l'IdCurrent du parent. (on le remet à jour à la fin)
				
				$formMaj2 = new formMaj();
				$formMaj2->maj_media_inside=true;
				$formMaj2->tables=$thisSite->PREFIXE_TBL_GEN . "medias";
				$formMaj2->fields="*";
				$formMaj2->where="id=:id";
				$formMaj2->whereValue["id"]=array($idMedia,PDO::PARAM_INT);
				$formMaj2->multiLang=true;
				$formMaj2->clause_where();
				
				// attribution par défaut si première image de l'Id_parent
				$formList2 = new formList();
				$formList2->tables=$thisSite->PREFIXE_TBL_GEN . "medias";
				$formList2->fields="id";
				$formList2->where="lg='". $myAdmin->LANG_DATAS . "' AND field_media='". $field_media . "' AND type='". $type . "'";
				if($idParent>0) {
					$formList2->where.=" AND id_parent=" . $idParent;
				}
				$formList2->clause_where();
				$count_datas = $formList2->get_datas();
				if($count_datas==0) {
					if($type=="image" || $type=="video") {
						$__POST["image_principale"]=1;
					}
				}
				if(!isset($__POST["actif"])) { $__POST["actif"]=1; }
				$__POST["type"]=$type;
				$__POST["field_media"]=$field_media; //$this->tables . "." . 
				$__POST["id_parent"]=$idParent;
				
				$formMaj2->set_datas();
				$idCurrent=$idParent; // on remet à jour l'IdCurrent du parent.
			} // if(strpos($field, "fieldMedia__")===0)
			
		} //$__POST

		
		
	} // maj_media_inside
	
} // formMaj

?>