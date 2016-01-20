<?php
$actionsPage=array("appliquer");
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php
if($_POST["langue"]!="") {
	
	$resultat="";
	$resultz =  $PDO->get_instante()->prepare("SHOW TABLES");
	$resultz->execute();
	$showTables = $resultz->fetchAll(PDO::FETCH_ASSOC);
	foreach ($showTables as $tables) {
		foreach ($tables as $table) {
			$resultz =  $PDO->get_instante()->prepare("SHOW COLUMNS FROM " . $table . " WHERE field = 'lg'");
			$resultz->execute();
			$raw_column_data = $resultz->fetchAll(PDO::FETCH_ASSOC);  
			if(count($raw_column_data)==1) {
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$table;
				$myDelete->where="lg='". $_POST["langue"] ."'";
				$result=$myDelete->execute();
				if($result==1) {
					$resultat .="<div class='ok'>Suppression OK dans la table <b>$table</b></div>";	
				} else {
					$resultat .="<div class='erreur'>PB suppression dans la table <b>$table</b></div>";	
				}
				
			}
		}
	}

	$smarty->assign("resultat",$resultat);  
}
?>
<?php
$newfield = new input();
$newfield->field="langue";
$newfield->multiLang=false;
$newfield->widthField=0;
$newfield->counter="countType:'characters', maxCount:2, strictMax:true";
$newfield->label="langue à supprimer";
$newfield->add();
$newfield->rule("required",true);
$newfield->rule("alphanumeric",true);
$newfield->rule("maxlength",2);
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>