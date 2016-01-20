<fieldset style="background-color:#f1f7fa; margin:10px">
<label>AIDE choix du lien:</label>
<section><div class="row">
<?php 
$lFiles=array();
$lDirs=array("");
$Dirs="";

// Dossier CLIENT
$Dirs.="client".",";
$lFiles["client"]=strtoupper("client");
$repertoire=DOS_CLIENT_ADMIN . "pages/";
$handle  = @opendir($repertoire); 
	while ($file = @readdir($handle)) {
	
		$ext= get_extension($file);
		if($ext=="php" || $ext=="htm" || $ext=="html") { $extok=1; } else  { $extok=0; }
		$posunder = strpos($file,"-");

		if($extok==1 && $posunder===false) {
			$xx=explode(".", $file);
			$file = array_shift($xx);
			$lFiles[$repertoire . $dir .$file]=$file;
		}
}
// Dossier BASE
$Dirs.="";
$repertoire=DOS_BASE_ADMIN . "pages/";
$handle  = @opendir($repertoire); 
while ($file = @readdir($handle)) {
	if ($file != ".." AND $file != "." AND is_dir($repertoire . $file)) { $lDirs[]=$file; }
}

foreach($lDirs as $dir) {

	if($dir!=""){
		$Dirs.=$dir.",";
		$lFiles[$dir]=strtoupper($dir);
		$dir.="/";
	}
	
	$handle  = @opendir($repertoire . $dir ); 
	while ($file = @readdir($handle)) {
	
		$ext= get_extension($file);
		if($ext=="php" || $ext=="htm" || $ext=="html") { $extok=1; } else  { $extok=0; }
		$posunder = strpos($file,"-");

		if($extok==1 && $posunder===false) {
			$xx=explode(".", $file);
			$file = array_shift($xx);
			$lFiles[$repertoire . $dir.$file]=$file;
		}
	}
}

$newfield = new select();
$newfield->field="script";
$newfield->multiLang=false;
$newfield->defaultValue="";
$newfield->noneItem=true;
$newfield->label="Script";
$newfield->items=$lFiles;
$newfield->valuesDisabled=$Dirs;
$newfield->javascript="onChange='getScript()'";
echo($newfield->add());
?>
</div></section>
</fieldset>
<script type="text/javascript">
function getScript(){ 
	if($("#titre_fr").val()=="") {
		$("#titre_fr").val(ucfirst($("#script option:selected").text()));
	}
	$("#lien").val($("#script").val());
	$("#param_lien").val("");
}

</script>
