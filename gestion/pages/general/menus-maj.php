<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "menus";
$myTableArbo=$thisSite->PREFIXE_TBL_GEN . "arbo";
$actionsPage=array("annuler","valider","appliquer");
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php
////////////////////////////////////////////////////////////////
// GESTION DONNEES
$formMaj = new formMaj();
$formMaj->tables=$myTable;
$formMaj->fields="*";
$formMaj->where="id=:id";
$formMaj->whereValue["id"]=array($idCurrent,PDO::PARAM_INT);
$formMaj->multiLang=true;
$formMaj->clause_where();

// Validation du formulaire
if($__POST["actionForm"]!="" &&  $__POST["actionForm"]!="Annuler") {
	$formMaj->set_datas();
	
	// Ajout à l'arboresence	
	$resultx = $PDO->free_requete("SELECT id FROM " . $myTableArbo . " WHERE code_menu='" . $__POST["code_menu"] ."'" );
	$rowx = $resultx->fetch();
	if($rowx["id"]==0) {
		$myInsert = new myInsert(__FILE__);
		$myInsert->table=$myTableArbo;
		$myInsert->field["code_menu"]=$__POST["code_menu"];
		$result=$myInsert->execute();
	}
    
	actionFormMaj($__POST["actionForm"]);
}

// chargement des données
$formMaj->get_datas();
?>
<?php
///////////////////////////////
// PREPARATION DES DONNEES

?>
<?php
///////////////////////////////////
// champs de saisie
///////////////////////////////////

$newfield = new input();
$newfield->field="code_menu";
$newfield->multiLang=false;
$newfield->widthField=3;
$newfield->counter="countType:'characters', maxCount:20, strictMax:true";
$newfield->label=$datas_lang["code"];
$newfield->add();
$newfield->rule("required",true);
$newfield->rule("alphanumeric",true);
$newfield->rule("maxlength",20);
$newfield->rule("remote",array("script"=>DOS_AJAX_ADMIN . "ajax_checkNotExiste.php","table"=>$myTable,"valOrigin"=>"FIELD:code_menu","params"=>""), $datas_lang["existedeja"]);

$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=true;
$newfield->label=$datas_lang["titre"];
$newfield->add();
$newfield->rule("required",true);

$newfield = new radio();
$newfield->field="actif";
$newfield->defaultValue=1;
$newfield->multiLang=false;
$newfield->label=$datas_lang["actif"];
$newfield->items=$datas_lang["ouiNon"];
$newfield->add();
$newfield->rule("required",true);


?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>