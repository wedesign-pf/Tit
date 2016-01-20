<?php
$myTable=$thisSite->PREFIXE_TBL_ADM . "niveaux0";
$myTableAdmin=$thisSite->PREFIXE_TBL_ADM . "administrateurs";
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
	if($majInsert==1) {
		// ajout droits
		$l_admin=explode(",",$__POST["admin"]);
		foreach($l_admin as $id_admin){
			if($id_admin>0) {
				$resultx = $PDO->free_requete("SELECT privilege, niveaux0 FROM " . $myTableAdmin . " WHERE id=" . $id_admin  );
				$rowx = $resultx->fetch();
				$privilege_admin=$rowx["privilege"];
				$niveaux0=$rowx["niveaux0"];
				if($__POST["privilege"]<=$privilege_admin) {
					$niveaux0.=$idCurrent . ",";
					$resultx = $PDO->free_requete("UPDATE " . $myTableAdmin . " SET niveaux0='" . $niveaux0 . "' WHERE id=" . $id_admin  );
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
$newfield->add();

?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>