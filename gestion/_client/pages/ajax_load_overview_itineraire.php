<?php
$pathBatch="../../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php
//echoa($_REQUEST);

foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){ 
    $mySelect = new mySelect(__FILE__);
    $mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "itineraires_overview";
    $mySelect->where="id=" . $_GET["id"] . " AND lg='" . $clg . "'";
    $result=$mySelect->query();
    $row = current($result);
    
    $row["texte"] = str_replace("\n", "", $row["texte"]);
    $row["texte"] = str_replace("\r\n", "", $row["texte"]);
    $row["texte"] = str_replace("\r", "", $row["texte"]); 
    $row["texte"] = str_replace(CHR(10),"",$row["texte"]);
    $row["texte"] = str_replace(CHR(13),"",$row["texte"]);

    if($row["id"]>0) {
        echo("$('#idCurrent').val('" . $row["id"] . "');\n");
        echo("$('#titre_" . $clg . "').val(\"" . addslashes($row["titre"]) . "\");\n");
        echo("tinyMCE.get('texte_" . $clg . "').setContent(\"" . addslashes($row["texte"]) . "\");\n");
        
        echo("$('#scr_ile').multipleSelect(\"setSelects\", [" . $row["ile"] . "]);\n");
        echo("$('#scr_hebergement').multipleSelect(\"setSelects\", [" . $row["hebergement"] . "]);\n");
        echo("$('#scr_excursion').multipleSelect(\"setSelects\", [" . $row["excursion"] . "]);\n");
        echo("$('#scr_service').multipleSelect(\"setSelects\", [" . $row["service"] . "]);\n");
        
    }
}
?> 