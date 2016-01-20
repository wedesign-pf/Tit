<?php
// pour éviter le login en développement
if ($thisSite->SERVER == "local") {
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables= $thisSite->PREFIXE_TBL_ADM . "administrateurs";
	$mySelect->fields="*";
	$mySelect->where="login='marco'";
	$result=$mySelect->query();
	if(count($result)==1) {
		$row = current($result); 
		$myAdmin->DATAS_LOGIN=array("login"=>$row["login"], "mdp"=>$row["mdp"]);
		$myAdmin->LOGIN=$row["login"];
		$myAdmin->MOTDEPASSE=$row["mdp"];
		$myAdmin->PRIVILEGE=$row["privilege"];
		$myAdmin->niveaux0=$row["niveaux0"];
		$myAdmin->niveaux1=$row["niveaux1"];
		$myAdmin->niveaux2=$row["niveaux2"];
		$myAdmin->niveaux2add=$row["niveaux2add"];
		$myAdmin->niveaux2mod=$row["niveaux2mod"];
		$myAdmin->niveaux2del=$row["niveaux2del"];
	}
}

$erreur=0;

if(!is_array($myAdmin->DATAS_LOGIN))  {
	$erreur=1;
} else {
	if($myAdmin->DATAS_LOGIN["login"] !=$myAdmin->LOGIN || $myAdmin->DATAS_LOGIN["mdp"] != $myAdmin->MOTDEPASSE) {
		$erreur=1;
	}
}

if($erreur==1) {
	echo("<script>window.location.href='login.php';</script>");
	exit;
}
?>
