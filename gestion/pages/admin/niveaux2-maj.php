<?php
$myTable=$thisSite->PREFIXE_TBL_ADM . "niveaux2";
$myTableAdmin=$thisSite->PREFIXE_TBL_ADM . "administrateurs";
$myTableDroits=$thisSite->PREFIXE_TBL_ADM . "droits";
$actionsPage=array("annuler","valider","appliquer");

?>
<?php
if($__POST["request"]!="") {
    $idCurrent="0";
}

include(DOS_INCPAGES_ADMIN  . "maj-init.php");

if($__POST["newNiveau0"]!="") {
    $filtres["F__niveau0"]=$__POST["newNiveau0"];
}
if($__POST["request"]!="") {
    $filtres["F__niveau1"]=$__POST["request"];
}

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
	
	if($majInsert==1) {
		// ajout droits
		$l_admin=explode(",",$__POST["admin"]);
		foreach($l_admin as $id_admin){
			if($id_admin>0) {
				
				$mySelect = new mySelect(__FILE__);
				$mySelect->tables=$myTableAdmin;
				$mySelect->fields="privilege, niveaux2,niveaux2add,niveaux2mod,niveaux2del";
				$mySelect->where="id=$id_admin";
				$resultx=$mySelect->query();
				$rowx = current($resultx);

				$privilege_admin=$rowx["privilege"];
				$niveaux2=$rowx["niveaux2"];
				$niveaux2add=$rowx["niveaux2add"];
				$niveaux2mod=$rowx["niveaux2mod"];
				$niveaux2del=$rowx["niveaux2del"];
				if($__POST["privilege"]<=$privilege_admin) {
					$niveaux2.=$idCurrent . ",";
					$niveaux2add.=$idCurrent . ",";
					$niveaux2mod.=$idCurrent . ",";
					$niveaux2del.=$idCurrent . ",";
					$resultx = $PDO->free_requete("UPDATE " . $myTableAdmin ." SET niveaux2='" . $niveaux2 . "', niveaux2add='" . $niveaux2add . "', niveaux2mod='" . $niveaux2mod . "', niveaux2del='". $niveaux2del . "' WHERE id=" . $id_admin  );
				}
			}
		}
	}
	
	$myAdmin->menuNavigation=array();
		
	actionFormMaj($__POST["actionForm"]);
}

// chargement des données
$formMaj->get_datas();
?>
<?php
///////////////////////////////
// PREPARATION DES DONNEES

ob_start();
global $smarty;
	include(DOS_INC_ADMIN."aide_lien_admin.php");
	$datas_page["aideLienAdmin"]=ob_get_contents();
ob_end_clean();

// titre niveau 0
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
$mySelect->fields="id,titre";
$mySelect->where="id='" . $filtres["F__niveau0"] . "' AND lg='" . $myAdmin->LANG_DATAS . "'";
$result=$mySelect->query(0);
$row = current($result); 
$datas_page["titreNiveau0"]=$row["titre"];

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_ADM . "niveaux1";
$mySelect->fields="id,titre";
$mySelect->where="id0='" . $filtres["F__niveau0"] . "'";
$result=$mySelect->query();
$listNiveau1=array();
foreach($result as $row){ 
	$listNiveau1[$row["id"]]=$row["titre"];
}
$datas_page["listNiveau1"]=$listNiveau1;

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTableAdmin;
$mySelect->fields="id,login";
$mySelect->orderby="login ASC";
$result=$mySelect->query();
$listAdmin=array();
foreach($result as $row){ 
	$listAdmin[$row["id"]]=$row["login"];
}
$datas_page["listAdmin"]=$listAdmin;
?>
<?php
///////////////////////////////////
// champs de saisie
///////////////////////////////////
$newfield = new hidden();
$newfield->field="id0";
$newfield->multiLang=false;
$newfield->value=$filtres["F__niveau0"];
$newfield->add();

$newfield = new select();
$newfield->field="id1";
$newfield->multiLang=false;
$newfield->label=$datas_lang["niveau1"];
$newfield->items=$datas_page["listNiveau1"];
$newfield->defaultValue=$filtres["F__niveau1"];
$newfield->allItems="Sans";
$data=$newfield->add();

$newfield = new input();
$newfield->field="titre";
$newfield->multiLang=true;
$newfield->label=$datas_lang["titre"];
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="lien";
$newfield->multiLang=false;
$newfield->label=$datas_lang["lien"];
$newfield->add();
$newfield->rule("required",true);

$newfield = new input();
$newfield->field="param_lien";
$newfield->multiLang=false;
$newfield->label=$datas_lang["parametre"];
$newfield->placeholder="code1=valeur1,code1=valeur2";
$newfield->add();

$newfield = new radio();
$newfield->field="cible";
$newfield->multiLang=false;
$newfield->defaultValue="_self";
$newfield->label=$datas_lang["cible"];
$newfield->items=$datas_lang["listeCible"];
$newfield->add();

$newfield = new radio();
$newfield->field="actif";
$newfield->defaultValue=1;
$newfield->multiLang=false;
$newfield->label=$datas_lang["actif"];
$newfield->items=$datas_lang["listeActif"];
$newfield->add();
$newfield->rule("required",true);

$lprivileges=$datas_lang["list_privileges"];

$newfield = new select();
$newfield->field="privilege";
$newfield->multiLang=false;
$newfield->label=$datas_lang["privilege"];
$newfield->items=$lprivileges;
$newfield->defaultValue="3";
$newfield->add();

$newfield = new checkbox();
$newfield->field="admin";
$newfield->multiLang=false;
$newfield->label=$datas_lang["autoriserNiveau"];
$newfield->items=$datas_page["listAdmin"];
$newfield->defaultValue="1";
$newfield->add();

$newfield = new textarea();
$newfield->field="explications";
$newfield->multiLang=true;
$newfield->label=$datas_lang["explications"];
$newfield->add();

?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>