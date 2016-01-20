<?php
if($__POST["idCurrent"]!="") { // indique la modification d'un élément
	$idCurrent=$__POST["idCurrent"];
}

$formMaj = new formMaj();
$formMaj->tables=$myTable;
$formMaj->fields="*";
$formMaj->where="id=:id";
$formMaj->whereValue["id"]=array($idCurrent,PDO::PARAM_INT);
$formMaj->multiLang=true;
$formMaj->clause_where();

// si validation du formulaire
if($__POST["actionForm"]!="") {
	
	// attribution par défaut si première image de l'Id_parent
	$formList2 = new formList();
	$formList2->tables=$myTable;
	$formList2->fields="id";
	if($__POST["typeVideo"]!="") {
		$type=$fieldMedia->type . "-" . $__POST["typeVideo"];
	} else {
		$type=$fieldMedia->type;
	}
	$formList2->where="lg='". $myAdmin->LANG_DATAS . "' AND field_media='". $fieldMedia->field . "' AND type LIKE '". $fieldMedia->type . "%'";
	if($idParent>0) {
		$formList2->where.=" AND id_parent=" . $idParent; 
	}
	$formList2->clause_where();
	$count_datas = $formList2->get_datas();
	if($count_datas==0) {
		if($fieldMedia->type=="image" || $fieldMedia->type=="video") {
			$__POST["image_principale"]=1;
		}
	}

	$__POST["type"]=$type;
	$__POST["field_media"]=$fieldMedia->field;
   
	$formMaj->set_datas();
}


?>
<?php
$newfield = new hidden();
$newfield->field="id_parent";
$newfield->multiLang=false;
$newfield->defaultValue=$idParent;
$newfield->add();
?>
