<?php
$pathBatch="../../";
include($pathBatch  . "init_pages/" . "batch.php");
?>
<?php

if($__GET["ile"]!="") { 
    
    echo("$('#hebergement').html('');\n");
    echo("$('#scr_hebergement').html('');\n");
    echo("$('#excursion').html('');\n");
    echo("$('#scr_excursion').html('');\n");
    echo("$('#service').html('');\n");
    echo("$('#scr_service').html('');\n");

    $l_iles=explode(",",$__GET["ile"]);
    
    if(count($l_iles)>1) { 
    
        $mySelect = new mySelect(__FILE__);
        $mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "iles";
        $mySelect->fields="id,titre";
        $mySelect->where="actif=1 AND lg=:lg AND id IN (" . $__GET["ile"] .")";
        $mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
        $result=$mySelect->query();
        $tab_iles=array();
        foreach($result as $row){
           $tab_iles[$row["id"]]=$row["titre"];
        }
    
        
    }
        
    foreach($l_iles as $id_ile){
        if($id_ile!="") {
            
            if(count($l_iles)>1) { 
                $optILE='$("<option />", { disabled:true, value: 0 ,text: "' . strtoupper($tab_iles[$id_ile]) . '" })';
            } else {
                $optILE="";
            }
             
            // Hebs
            $mySelect = new mySelect(__FILE__);
            $mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits";
            $mySelect->fields="id,titre";;
            $mySelect->where="actif=1 AND lg=:lg AND type=23 AND ile REGEXP '^([0-9]+,)*" . $id_ile . "(,[0-9]+)*$'";
            $mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
            $result=$mySelect->query();
            if($optILE!="") { echo("$('#scr_hebergement').append(" . $optILE . ");\n"); }
            foreach($result as $row){
                    $opt='$("<option />", { value: ' . $row["id"] . ' ,text: "' . $row["titre"] . '" })';
                    echo("$('#scr_hebergement').append(" . $opt . ");\n");
            }
            
            // Excursions
            $mySelect = new mySelect(__FILE__);
            $mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits";
            $mySelect->fields="id,titre";;
            $mySelect->where="actif=1 AND lg=:lg AND type=24 AND ile REGEXP '^([0-9]+,)*" . $id_ile . "(,[0-9]+)*$'";
            $mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
            $result=$mySelect->query();
            if($optILE!="") { echo("$('#scr_excursion').append(" . $optILE . ");\n"); }
            foreach($result as $row){
                    $opt='$("<option />", { value: ' . $row["id"] . ' ,text: "'  . $row["titre"] . '" })';
                    echo("$('#scr_excursion').append(" . $opt . ");\n");
            }
            
            // Services
            $mySelect = new mySelect(__FILE__);
            $mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "produits";
            $mySelect->fields="id,titre";;
            $mySelect->where="actif=1 AND lg=:lg AND type=25 AND ile REGEXP '^([0-9]+,)*" . $id_ile . "(,[0-9]+)*$'";
            $mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
            $result=$mySelect->query();
            if($optILE!="") { echo("$('#scr_service').append(" . $optILE . ");\n"); }
            foreach($result as $row){
                    $opt='$("<option />", { value: ' . $row["id"] . ' ,text: "'  . $row["titre"] . '" })';
                    echo("$('#scr_service').append(" . $opt . ");\n");
            }
            

        }
    }
    
    echo("$('#scr_hebergement').multipleSelect('refresh');\n");
    echo("$('#scr_excursion').multipleSelect('refresh');\n");
    echo("$('#scr_service').multipleSelect('refresh');\n");

}
?>