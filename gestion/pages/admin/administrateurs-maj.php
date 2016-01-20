<?php
$myTable=$thisSite->PREFIXE_TBL_ADM . "administrateurs";
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
$formMaj->multiLang=false;
$formMaj->clause_where();
//echoa($__POST);
// Validation du formulaire
if($__POST["actionForm"]!="" &&  $__POST["actionForm"]!="Annuler") {
	
    if($__POST["mdp"]!="") { 
        $__POST["mdp"]=md5($__POST["mdp"]);
    } else {
        unset($__POST["mdp"]);
    }

	//
	$niveaux0="";
	$niveaux1="";
	$niveaux2="";
	$niveaux2add="";
	$niveaux2mod="";
	$niveaux2del="";
	foreach ($__POST as $k => $v) {
		if(strpos($k, "niv0_") === 0) {
			$niveaux0.=$v.",";
		}
		if(strpos($k, "niv1_") === 0) {
			$niveaux1.=$v.",";
		}
		if(strpos($k, "niv2_") === 0) {
			$niveaux2.=$v.",";
		}
		if(strpos($k, "add2_") === 0) {
			$niveaux2add.=$v.",";
		}
		if(strpos($k, "mod2_") === 0) {
			$niveaux2mod.=$v.",";
		}
		if(strpos($k, "del2_") === 0) {
			$niveaux2del.=$v.",";
		}
	}
	$__POST["niveaux0"]=$niveaux0;
	$__POST["niveaux1"]=$niveaux1;
	$__POST["niveaux2"]=$niveaux2;
	$__POST["niveaux2add"]=$niveaux2add;
	$__POST["niveaux2mod"]=$niveaux2mod;
	$__POST["niveaux2del"]=$niveaux2del;
	//
	$formMaj->set_datas();

	actionFormMaj($__POST["actionForm"]);
}

// chargement des données
$formMaj->get_datas();
//echoa($formMaj->datasForm);
?>
<?php
///////////////////////////////
// PREPARATION DES DONNEES
//
$listeNiveaux=array();

$mySelect0 = new mySelect(__FILE__);
$mySelect0->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
$mySelect0->fields="id,titre";
$mySelect0->where="actif='1' AND privilege<=:privilege AND lg=:lg";
$mySelect0->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
$mySelect0->whereValue["lg"]=array($myAdmin->LANG_DATAS,PDO::PARAM_STR);
$mySelect0->orderby="chrono ASC";
$result0=$mySelect0->query();
foreach($result0 as $row0){ 
	$listeNiveaux[] = array("niv"=>0,"id"=>$row0['id'], "titre"=>$row0['titre']); 
	// niveau 1
	$mySelect1 = new mySelect(__FILE__);
	$mySelect1->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
	$mySelect1->fields="id,titre,id0";
	$mySelect1->where="actif='1' AND privilege<=:privilege AND lg=:lg AND id0=:id0";
	$mySelect1->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
	$mySelect1->whereValue["lg"]=array($myAdmin->LANG_DATAS,PDO::PARAM_STR);
	$mySelect1->whereValue["id0"]=array($row0['id'],PDO::PARAM_STR);
	$mySelect1->orderby="id0 ASC, chrono ASC";
	$result1=$mySelect1->query();
	
	// ajout pour les niveaux 2 sans niveau 1
	array_unshift($result1, array(id=>0,titre=>"-------",id0=>$row0['id']));

	foreach($result1 as $row1){ 
		$listeNiveaux[] = array("niv"=>1,"id"=>$row1['id'],"id0"=>$row1['id0'], "titre"=>$row1['titre']); 
		// niveau 2
		$mySelect2 = new mySelect(__FILE__);
		$mySelect2->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
		$mySelect2->fields="id,titre,id1";
		$mySelect2->where="actif='1' AND privilege<=:privilege AND lg=:lg AND id0=:id0 AND id1=:id1";
		$mySelect2->whereValue["privilege"]=array($myAdmin->PRIVILEGE,PDO::PARAM_STR);
		$mySelect2->whereValue["lg"]=array($myAdmin->LANG_DATAS,PDO::PARAM_STR);
		$mySelect2->whereValue["id0"]=array($row0['id'],PDO::PARAM_STR);
		$mySelect2->whereValue["id1"]=array($row1['id'],PDO::PARAM_STR);
		$mySelect2->orderby="chrono ASC";
		$result2=$mySelect2->query();
		foreach($result2 as $row2){
			
			$listeNiveaux[] = array("niv"=>2,"id"=>$row2['id'],"id0"=>$row1['id0'],"id1"=>$row2['id1'], "titre"=>$row2['titre']); 
		} // niv 2
	
	} // niv 1

} // niv 0
	
	 
	$smarty->assign("listeNiveaux", $listeNiveaux);
	//echoa($listeNiveaux);
?>
<?php
///////////////////////////////////
// champs de saisie
///////////////////////////////////
$newfield = new radio();
$newfield->field="actif";
$newfield->defaultValue=1;
$newfield->multiLang=false;
$newfield->label=$datas_lang["actif"];
$newfield->items=$datas_lang["listeActif"];
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="login";
$newfield->multiLang=false;
$newfield->label=$datas_lang["identifiant"];
$newfield->counter="countType:'characters', maxCount:20, strictMax:true";
$newfield->autocomplete=false;
$newfield->add();
$newfield->rule("required",true);
$newfield->rule("alphanumeric",true);
$newfield->rule("minlength",5);
$newfield->rule("maxlength",20);
$newfield->rule("remote",array("script"=>DOS_AJAX_ADMIN . "ajax_checkNotExiste.php","table"=>$myTable,"valOrigin"=>"FIELD:login","params"=>""), $datas_lang["existedeja"]);

$newfield = new password();
$newfield->field="mdp";
$newfield->multiLang=false;
$newfield->label=$datas_lang["motdepasse"];
$newfield->value="";
$newfield->add();
if($majInsert==1) { $newfield->rule("required",true); }
$newfield->rule("alphanumeric",true);
$newfield->rule("minlength",5);
$newfield->rule("maxlength",20);

$newfield = new password();
$newfield->field="confirm_mdp";
$newfield->label=$datas_lang["modepasseconfirmation"];
$newfield->add();
$newfield->rule("equalTo","'#mdp'");

$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=false;
$newfield->label=$datas_lang["titre"];
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="email";
$newfield->multiLang=false;
$newfield->label=$datas_lang["email"];
$newfield->add();
$newfield->rule("email",true);

$lprivileges=$datas_lang["list_privileges"];
$lprivileges =array();
while (list($c,$v) = each($datas_lang["list_privileges"])) { // on affiche que les privilege égale ou en dessous
	if ($c<=$myAdmin->PRIVILEGE) {$lprivileges[$c] = $v;}
}

$newfield = new select();
$newfield->field="privilege";
$newfield->multiLang=false;
$newfield->label=$datas_lang["privilege"];
$newfield->items=$lprivileges;
$newfield->defaultValue="0";
$newfield->add();

/*$newfield = new checkbox();
$newfield->field="langues";
$newfield->multiLang=false;
$newfield->label=$datas_lang["lgAutorise"];
$newfield->items=$myAdmin->LIST_LANG_DATAS;
$newfield->add();
$newfield->rule("required",true);*/

?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>