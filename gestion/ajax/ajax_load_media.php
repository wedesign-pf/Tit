<?php
$pathBatch="../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php
//echoa($_REQUEST);
foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){ 
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "medias";
	$mySelect->where="id=" . $_GET["id"] . " AND lg='" . $clg . "'";
	$result=$mySelect->query();
	$row = current($result);
	if($row["id"]>0) {
	 echo("$('#idCurrent').val('" . $row["id"] . "');");

	 $typeVideo=explode("-",$row["type"]);
	 if(count($typeVideo)==2) { echo("$('#typeVideo_" . $clg . "').val(\"" . $typeVideo[1] . "\");"); }
	 echo("$('#fichier_media_" . $clg . "').val(\"" . addslashes($row["fichier_media"]) . "\");");
	 echo("$('#titre_media_" . $clg . "').val(\"" . addslashes($row["titre_media"]) . "\");");
	 echo("$('#fichier_destination_" . $clg . "').val(\"" . addslashes($row["fichier_destination"]) . "\");");
	 echo("$('#lien_destination_" . $clg . "').val(\"" . addslashes($row["lien_destination"]) . "\");");

	 // si monolangues
	 if(count($typeVideo)==2) { echo("$('#typeVideo').val(\"" . $typeVideo[1] . "\");"); }
	 echo("$('#fichier_media').val(\"" . addslashes($row["fichier_media"]) . "\");");
	 echo("$('#titre_media').val(\"" . addslashes($row["titre_media"]) . "\");");
	 echo("$('#fichier_destination').val(\"" .addslashes($row["fichier_destination"]) . "\");");
	 echo("$('#lien_destination').val(\"" . addslashes($row["lien_destination"]) . "\");");
	 //
	 if($row["cible_destination"]=="_self") {
		 echo("$('#cible_destination_0').prop('checked', true);");
	 } else {
		  echo("$('#cible_destination_1').prop('checked', true);");
	 }

	}
}
?>