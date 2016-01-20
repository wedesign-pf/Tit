<?php 
/*$myDelete = new myDelete(__FILE__);
$myDelete->table="cli_resa";
$myDelete->where="id=:id";
$myDelete->whereValue["id"]=array(125,PDO::PARAM_STR);
$result=$myDelete->execute(1);
echoa($result);*/

/*$myInsert = new myInsert(__FILE__);
$myInsert->table="cli_resa";
$myInsert->field["nom"]="TEST nom 'eee'";
$myInsert->field["prenom"]="TEST prénom";
$myInsert->field["date"]=140819;
$result=$myInsert->execute(1);
echoa($result);*/

/*$myUpdate = new myUpdate(__FILE__);
$myUpdate->table=$thisSite->PREFIXE_TBL_PUB . "stats";
$myUpdate->field["nb_aff"]="LITERAL:nb_aff+1";
$myUpdate->where="id_ban=:id_ban AND aa=:aa AND mm=:mm AND jj=:jj";
$myUpdate->whereValue["id_ban"]=array($id_ban_show,PDO::PARAM_INT);
$myUpdate->whereValue["aa"]=array(date(y),PDO::PARAM_STR);
$myUpdate->whereValue["mm"]=array(date(m),PDO::PARAM_STR);
$myUpdate->whereValue["jj"]=array(date(d),PDO::PARAM_STR);
$result=$myUpdate->execute(1);
*/			
/*$mySelect = new mySelect(__FILE__);
$mySelect->tables="cli_resa";
$mySelect->fields="id,nom,prenom";
$mySelect->where="pays=:pays AND date>=:date AND nom=:nom OR nom=:nom2 OR nom=:nom3";
$mySelect->whereValue["pays"]="Afghanistan";
$mySelect->whereValue["date"]=array(140819,PDO::PARAM_INT);
$mySelect->whereValue["nom"]=array("Marc ééé",PDO::PARAM_STR);
$mySelect->whereValue["nom2"]=array("Marc 'eee'",PDO::PARAM_STR);
$mySelect->whereValue["nom3"]=array("Marc \"eee\"",PDO::PARAM_STR);
$mySelect->orderby="nom DESC";
$mySelect->groupby="";
$mySelect->limit="";
$result=$mySelect->query(1);
echoa($result);*/
//$result=$mySelect->count(1);
//echoa($result);
?>
<?php

class myPDO{

    private  $instancePDO;

	public function __construct () {		
		try { 
        
			global $thisSite;
            
			if ($thisSite->SERVER == "local") {
				$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
			}
			$instancePDO = new PDO('mysql:host='. $thisSite->SERVEUR_BDD . ';port=' . $thisSite->PORT_BDD . ';dbname=' . $thisSite->NOM_BDD, $thisSite->LOGIN_BDD , $thisSite->MDP_BDD, $pdo_options);
			
		} catch(Exception $e) {
			echoa($e->getMessage());
            echoa("Echec de la connexion");
			die();
		}

		$this->instancePDO=$instancePDO;
	}


	public function get_instante() {
		return $this->instancePDO;
	}
	
	
	public function getFieldsName($table) {
        
		$recordset = $this->instancePDO->query("SHOW COLUMNS FROM $table");
		$fields = $recordset->fetchAll(PDO::FETCH_ASSOC);
		foreach ($fields as $field) {
			$fieldNames[] = $field['Field'];
		}
		return $fieldNames;
	}
	
	public function lock_table($table) {
		//$this->instancePDO->exec("LOCK TABLE "  . $table .  " WRITE");
		//print_r($this->get_instante()->errorInfo());
		//echo("zzzzz $x");
	}


	public function unlock_table($table) {
		//$this->instancePDO->exec("UNLOCK TABLES");
		//print_r($this->get_instante()->errorInfo());
	}

	// A utiliser si les class standards ne peuvent exécuter la requete
	// Attention à protéger les données envoyées
	public function free_requete($requete,$debug=0) {
        
		$requete=preg_replace("#\n|\t|\r#"," ",$requete);
        $requete=ltrim($requete);
        
		if($debug=="1") { echo($requete); }
		if(strtoupper(substr($requete,0,6))=="SELECT"  ) {
			try {
				$result = $this->instancePDO->prepare($requete);
				$result->execute();
				$result->setFetchMode(PDO::FETCH_ASSOC);
                
			} catch(Exception $e) {
				return 0;
			}
			
		} else {
			$result=$this->instancePDO->exec($requete); 
		}
		
		 return $result;
	}
	
	///////////////////////////////////
	public function getNextID($table,$min="",$max="") {
		if($min=="") { $min=0; }
		$where="WHERE id>$min";
		if($max!="") { $where.=" AND id<$max"; } 
		$resultx = $this->free_requete("SELECT MAX(id) AS id FROM " . $table . " " . $where);
		//echoa("SELECT MAX(id) AS id FROM " . $table . " " . $where);
		$rowx = $resultx->fetch();
		if($rowx["id"]==NULL) { return $min + 1; }
		return $rowx["id"] + 1;
	} // getNextID
	
	public function getNextChrono($table,$idCurrent=0) {
		
		$resultz = $this->instancePDO->prepare("SHOW COLUMNS FROM " . $table . " WHERE Field = 'chrono'");
		$resultz->execute();
		$raw_column_data = $resultz->fetchAll(PDO::FETCH_ASSOC);  
		if(count($raw_column_data)==0) {
			return 0;			
		}
			
		if($idCurrent==0) {
			$resultx = $this->free_requete("SELECT MAX(chrono) AS chrono FROM " . $table);
			if($resultx>0) {
				$rowx = $resultx->fetch();
				$newchrono=$rowx["chrono"] + 1;
				if(is_float($newchrono)) { $newchrono=intval($newchrono); }
				return $newchrono;
			} else {
				return 0;
			}
		} else {
			$resultx = $this->free_requete("SELECT chrono FROM " . $table . " WHERE id=" . $idCurrent );
			if($resultx>0) {
				$rowx = $resultx->fetch();
				return $rowx["chrono"];
			} else {
				return 0;
			}				
		}
		
	} // getNextChrono
	
	public function duplication($table,$idDupli,$fieldCopie="",$fieldsExcept="") {

		$newId=$this->getNextID($table);
		$newChrono=0;
		
		$resultD = $this->free_requete("SELECT * FROM " . $table . " WHERE id=" . $idDupli );
		foreach($resultD as $rowD){
			
			$myInsert = new myInsert(__FILE__);
			$myInsert->table=$table;
			
			foreach($rowD as $field=>$val){
				
				if(strpos($fieldsExcept, $field) === false) { 
					
					if(strpos($fieldCopie, $field) !== false) { 
						$myInsert->field[$field]="COPIE DE: " . $val;  
					} else if ($field=="id") { 
						$myInsert->field[$field]= $newId; 
					} else if ($field=="chrono") {
						if($newChrono==0) { $newChrono=$this->getNextChrono($table);  }
						$myInsert->field[$field]= $newChrono; 
					} else {
						$myInsert->field[$field]= $val;
					}
				}
			}
			
			$result=$myInsert->execute();
		}
		
	} // duplication
	
	
} // myPDO


$PDO = new myPDO(); //$instancePDO

///////////////////////////////////////////////////
/// SELECT ////////////////////////////////////////
///////////////////////////////////////////////////
class mySelect{

	public $script;
	
	public function __construct ($script="") {
		$this->script=$script;
		$this->replaceVariables=false;
	}


	public function query($debug=0) {
		
		global $PDO;
        global $thisSite;
		
		//$this->tables > $mySelect->tables="cli_resa AS R, cli_xxx AS xxx";
		//$this->fields > $mySelect->field="id,nom,prenom";
		//$this->where > "pays=:pays AND date=:date AND nom!=''"
		//$this->whereValue > "AX" ou array('AX') ou array(140819,PDO::PARAM_INT)
		//$this->groupby
		//$this->orderby
		//$this->limit
		//$this->keyfield > Champ qui remplira la clé de la table (si rien c'est un auto incrément) 
		//$this->replaceVariables > si true, remplace les variables par leur valeur
		
		if($this->tables=="") { return 0; }
		
		$PDO->unlock_table($this->table);
		
		$l_datas=array();

		if($this->fields=="") { $this->fields = "*"; }
		$requete="SELECT DISTINCT $this->fields FROM $this->tables";
		if($this->where!="") { $requete .= " WHERE " . $this->where . " "; }
		if($this->groupby!="") { $requete .= " GROUP BY " . $this->groupby . " "; }
		if($this->orderby!="") { $requete .= " ORDER BY " . $this->orderby . " "; }
		if($this->limit!="") { $requete .= " LIMIT " . $this->limit . " "; }
		
		try {
			$result = $PDO->get_instante()->prepare($requete);
			if(is_array($this->whereValue)) {
				foreach($this->whereValue as $key=>$value) {
						if(is_array($value)) { list($val,$param)=$value; } else { $val=$value; }
						if($val==NULL) { $val=""; } 
						$result->bindValue($key, $val,$param);
						
				}
			}
			if($debug==1 ) { echoa("<hr>$requete<hr>"); }
			$result->execute();
			$result->setFetchMode(PDO::FETCH_OBJ);
	
			while ($row = $result->fetch()) {
				$l_temp=array();
				
				foreach($row as $key=>$value) {
					if($this->replaceVariables==true) {
						$value=add_variables($value);
					}
					$l_temp[$key] = stripslashes($value);
				}
	
				if($this->keyfield=="") { 
					$l_datas[]=$l_temp; 
				} else { 
					$l_datas[$row->{$this->keyfield}]=$l_temp; 
				}
				
			}
		} catch (Exception $e) {
			
			global $gestionLogs;
			$gestionLogs->erreursPDO($e,$requete,$this->script);
			
		}
		//echoa($l_datas);
		
		if($debug==2 ) { echoa($l_datas); }
		
		return $l_datas;
	} //query
	
	// Compte les enregistrements d'un select
	public function count($debug=0) {
		if($this->tables=="") { return 0; }
		$fields=$this->fields; // on save
		$this->fields="count(*) AS total";
		$result=$this->query($debug);
		$this->fields=$fields; // on remet
		return $result[0]["total"];

	} // count
	
} // mySelect

///////////////////////////////////////////////////
/// INSERT ////////////////////////////////////////
///////////////////////////////////////////////////
class myInsert{

	public $script;
	
	public function __construct ($script="") {
		$this->script=$script;
	}
	
	public function execute($debug=0) {
		
		//$this->table > $myInsert->table="cli_resa";
		//$this->field > $myInsert->field["prenom"]="TEST prénom";
		
		global $PDO;
        global $thisSite;
		
		try {
			
			$PDO->lock_table($this->table);
			
			if($this->table=="") { return 0; }
			if(!is_array($this->field)) { return 0; }
	
			$fields="";
			$params="";
			$sep="";
			foreach($this->field as $key=>$value) {
				$fields.=$sep . $key;
				$params.=$sep . ":f_" . $key;
				$sep=", ";
			}
	
			$requete="INSERT INTO "  . $this->table .  " ( $fields ) VALUES ( $params )";

			$result = $PDO->get_instante()->prepare($requete);
			
			reset($this->field);
			$lastId="";
			foreach($this->field as $key=>$value) {
				if($key=="id") { $lastId=$value;} // dernier ID
				$result->bindValue(':f_'.$key, $value);
				
			}

			if($debug==1) { echoa($requete); }
			
			$r = $result->execute();
			
			// Renvoi le dernier ID
			//$PDO->unlock_table($this->table);
			//$resultx = $PDO->free_requete("SELECT MAX(id) AS id FROM " . $this->table);
			//$rowx = $resultx->fetch();
			//$r = $rowx["id"];
			
		} catch (Exception $e) {
			
			global $gestionLogs;
			$gestionLogs->erreursPDO($e,$requete,$this->script);
			
		}
		
        if($lastId=="") {
            $lastId = $PDO->get_instante()->lastInsertId();
        } 
		return $lastId;

		
		
	} // execute

} // myInsert


///////////////////////////////////////////////////
/// UPDATE ////////////////////////////////////////
///////////////////////////////////////////////////
class myUpdate{
	
	public $script;
	
	public function __construct ($script="") {
		$this->script=$script;
	}

	public function execute($debug=0) {

		global $PDO;
        global $thisSite;
		
		try {
			
			$PDO->lock_table($this->table);
			
			if($this->table=="") { return 0; }
			if(!is_array($this->field)) { return 0; }
	
			$fieldsParams="";
			$sep="";
			foreach($this->field as $key=>$value) {
				if(startsWith($value,"LITERAL:")) {
					$fieldsParams.=$sep . $key ."=" . substr($value,8);
				} else {
					$fieldsParams.=$sep . $key ."=" . ":f_" . $key ;
				}
				$sep=", ";
			}
	
			$requete="UPDATE "  . $this->table .  " SET $fieldsParams";
			if($this->where!="") { $requete .= " WHERE " . $this->where . " "; }
			$result = $PDO->get_instante()->prepare($requete);
			
			reset($this->field);
			foreach($this->field as $key=>$value) {
				if(!startsWith($value,"LITERAL:")) { $result->bindValue(':f_'.$key, $value);}
			}
	
			if(is_array($this->whereValue)) {
				foreach($this->whereValue as $key=>$value) {
						if(is_array($value)) { list($val,$param)=$value; } else { $val=$value; }
						if($val==NULL) { $val=""; } 
						$result->bindValue(':'.$key, $val,$param);
				}
			}
	
	
			if($debug==1) { echoa($requete); }
			
			$r = $result->execute();
	
			$PDO->unlock_table($this->table);
			
		} catch (Exception $e) {
			
			global $gestionLogs;
			$gestionLogs->erreursPDO($e,$requete,$this->script);
			
		}
		return $r;

		
		
	}

} // myUpdate


///////////////////////////////////////////////////
/// DELETE ////////////////////////////////////////
///////////////////////////////////////////////////
class myDelete{

	public $script;
	
	public function __construct ($script="") {
		$this->script=$script;
	}

	public function execute($debug=0) {
		
		//$this->table > table="cli_resa";
		//$this->where > "pays=:pays AND date=:date AND nom!=''"
		//$this->whereValue > "AX" ou array('AX') ou array(140819,PDO::PARAM_INT)
		
		global $PDO;
        global $thisSite;
		
		try {
			
			$PDO->lock_table($this->table);
			
			if($this->table=="") { return 0; }
	
			$requete="DELETE FROM "  . $this->table;
			if($this->where!="") { $requete .= " WHERE " . $this->where . " "; }
			$result = $PDO->get_instante()->prepare($requete);
			
			if(is_array($this->whereValue)) {
				foreach($this->whereValue as $key=>$value) {
						if(is_array($value)) { list($val,$param)=$value; } else { $val=$value; }
						$result->bindValue(':'.$key, $val,$param);
				}
			}
	
			if($debug==1) { echoa($requete); }
			
			$r = $result->execute();
	
			$PDO->unlock_table($this->table);
			
		} catch (Exception $e) {
			
			global $gestionLogs;
			$gestionLogs->erreursPDO($e,$requete,$this->script);
			
		}
		
		return $r;
		
	}

} // myDelete

?>
