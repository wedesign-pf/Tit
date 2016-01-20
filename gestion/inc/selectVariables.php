<?php
include(DOS_INC_ADMIN . "controle_login.php");

// ajout selecteur de variables
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "variables";
$mySelect->fields="*";
$mySelect->where="lg>=:lg";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$nb_variables=$mySelect->count();

if ($nb_variables>0) {
	$result=$mySelect->query();
	$data_variables="";
	$data_variables.="<div id='show_variables'>";
	$data_variables.="<select id='liste_variables' onChange=\"javascript:select_variables();\" >";
	$data_variables.="<option>Choisissez une variable...</option>";
	foreach($result as $row){ 	
			$codevar = $thisSite->SEPVAR . stripslashes($row["code"]) . $thisSite->SEPVAR;
			$titrevar = stripslashes($row["titre"]);
			$data_variables.="<option  value='$codevar'>$titrevar</option>";
	}
	$data_variables.="</select>";
	$data_variables.="</div>";

$smarty->assign("data_variables", $data_variables);
} //nb_variables


?>