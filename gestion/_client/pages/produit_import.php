<?php
$actionsPage=array("appliquer");
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-init.php");
?>
<?php

$obj_article = new article("cat_produit");
$obj_article->fields="id,titre";
$obj_article->lg="en";
$result=$obj_article->query();
$tab_cat_produit=array();
foreach($result as $row){
   $tab_cat_produit[$row["titre"]]=$row["id"];
}
//echoa($tab_cat_produit);

$obj_article = new article("souscat_produit");
$obj_article->fields="id,titre";
$obj_article->lg="en";
$result=$obj_article->query();
$tab_souscat_produit=array();
foreach($result as $row){
   $tab_souscat_produit[$row["titre"]]=$row["id"];
}
//echoa($tab_souscat_produit);


$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "iles";
$mySelect->fields="id,titre";
$mySelect->where="actif=1 AND lg='en'";
$result=$mySelect->query();
$tab_iles=array();
foreach($result as $row){
   $tab_iles[$row["titre"]]=$row["id"];
}
//echoa($tab_iles);

$cpt_entete=4;
$sep_champs=";";
$showResulatsMaj=1;

$fic=$_FILES['fichier']['tmp_name'];

if( $fic!="") {
	
    $msgErreurs=array();
    $msgAvertissements=array();
    $msgMaj=array();
    
    $sep_erreur="<br>";
    $sep_avertissement="<br>";

	$cpt=0;
    $cptMaj=0;
	
	$handle = fopen($fic, "r");
	while (($ligne = fgetcsv($handle, 100000, $sep_champs)) !== FALSE) {	
	    
        if($ligne=="") { continue; }
   
		$cpt = $cpt+1; // pour etre juste
		
		if($cpt<=$cpt_entete) { continue; }
		
		$ligne = str_replace("\"", "'", $ligne);
		
		$code="";
		$iles="";
		$titre="";
		$cat="";
		$souscat="";
		$contrat="";
		$contact="";
		$email="";
		$telephone="";
        $duree="";
        $prestataire="";
        //
        $id_cat="";
        $id_souscat="";
		$id_iles="";
        
        $i=0;        
        if($_POST["type"]==23) { // HEBERGEMENTS
            $code=addslashes(utf8_encode($ligne[$i]));$i++;
            $iles=addslashes(utf8_encode($ligne[$i]));$i++;
            $titre=addslashes(utf8_encode($ligne[$i]));$i++;
            $cat=addslashes(utf8_encode($ligne[$i]));$i++;
            $souscat=addslashes(utf8_encode($ligne[$i]));$i++;
            $contrat=addslashes(utf8_encode($ligne[$i]));$i++;
            $i++;
            $i++;
            $i++;
            $i++;
            $i++;
            $contact=addslashes(utf8_encode($ligne[$i]));$i++;
            $email=addslashes(utf8_encode($ligne[$i]));$i++;
            $telephone=addslashes(utf8_encode($ligne[$i]));$i++;
        }
        if($_POST["type"]==24) { // EXCURSIONS
            $code=addslashes(utf8_encode($ligne[$i]));$i++;
            $iles=addslashes(utf8_encode($ligne[$i]));$i++;
            $titre=addslashes(utf8_encode($ligne[$i]));$i++;
            $duree=addslashes(utf8_encode($ligne[$i]));$i++;
            $cat=addslashes(utf8_encode($ligne[$i]));$i++;
            $souscat=addslashes(utf8_encode($ligne[$i]));$i++;
            $prestataire=addslashes(utf8_encode($ligne[$i]));$i++;
            $contrat=addslashes(utf8_encode($ligne[$i]));$i++;
            $i++;
            $i++;
            $i++;
            $i++;
            $i++;
            $contact=addslashes(utf8_encode($ligne[$i]));$i++;
            $email=addslashes(utf8_encode($ligne[$i]));$i++;
            $telephone=addslashes(utf8_encode($ligne[$i]));$i++;
        }
        if($_POST["type"]==25) { // SERVICES
            $code=addslashes(utf8_encode($ligne[$i]));$i++;
            $iles=addslashes(utf8_encode($ligne[$i]));$i++;
            $titre=addslashes(utf8_encode($ligne[$i]));$i++;
            $cat=addslashes(utf8_encode($ligne[$i]));$i++;
            $contrat=addslashes(utf8_encode($ligne[$i]));$i++;
            $i++;
            $i++;
            $i++;
            $i++;
            $i++;
            $prestataire=addslashes(utf8_encode($ligne[$i]));$i++;
            $contact=addslashes(utf8_encode($ligne[$i]));$i++;
            $email=addslashes(utf8_encode($ligne[$i]));$i++;
            $telephone=addslashes(utf8_encode($ligne[$i]));$i++;
        }
        

        $code=trim($code);
        $iles=trim($iles);
        $titre=trim($titre);
        $cat=trim($cat);
        $souscat=trim($souscat);
        $contrat=trim($contrat);
        $contact=trim($contact);
        $email=trim($email);
        $telephone=trim($telephone);
        $prestataire=trim($prestataire);
        
        if($titre=="") { continue; }

        $id_cat=$tab_cat_produit[$cat];
        $id_souscat=$tab_souscat_produit[$souscat];
        
        $l_iles=explode(",",$iles);
        $sepi="";
        foreach($l_iles as $ile){ 
            $ile=trim($ile);
            if($ile!="") {
    
                $id_ile=$tab_iles[$ile];
                
                if($id_ile=="") {
                    $newIdx=$PDO->getNextID("g_cli_iles");
                    $chronox=$PDO->getNextChrono("g_cli_iles");
                    foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){ 
                        $myInsert = new myInsert(__FILE__);
                        $myInsert->table="g_cli_iles";
                        $myInsert->field["id"]=$newIdx;
                        $myInsert->field["lg"]=$clg;
                        $myInsert->field["chrono"]=$chronox;  
                        $myInsert->field["login_add"]=$myAdmin->LOGIN;                  
                        $myInsert->field["datetime_add"]=date('Y-m-d H:i:s');
                        $myInsert->field["actif"]=1;
                        $myInsert->field["titre"]=$ile;
                        $id_ile=$myInsert->execute();
                    }
                    $tab_iles[$ile]=$id_ile;
                    $msgAvertissements[$cpt]["message"].="Ajout Ile ($ile)" . $sep_avertissement;
      
                }
            
                if($id_ile!="") {
                    $id_iles.=$sepi . $id_ile;
                    $sepi=",";
                }
            }
        }
   
        if($_POST["type"]==25) { $id_souscat=""; }
        
        if($id_cat=="" && $cat!="") {
            
            $newIdx=$PDO->getNextID($thisSite->PREFIXE_TBL_GEN . "articles");
            $chronox=$PDO->getNextChrono($thisSite->PREFIXE_TBL_GEN . "articles");
            foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){ 
                $myInsert = new myInsert(__FILE__);
                $myInsert->table=$thisSite->PREFIXE_TBL_GEN . "articles";
                $myInsert->field["art"]="cat_produit";
                $myInsert->field["id"]=$newIdx;
                $myInsert->field["lg"]=$clg;
                $myInsert->field["chrono"]=$chronox;                    
                $myInsert->field["datetime_add"]=date('Y-m-d H:i:s');
                $myInsert->field["actif"]=1;
                $myInsert->field["filtre1"]=$_POST["type"];
                $myInsert->field["titre"]=$cat;
                $id_cat=$myInsert->execute();
            }
            $tab_cat_produit[$cat]=$id_cat;
            $msgAvertissements[$cpt]["message"].="Ajout catégorie ($cat)" . $sep_avertissement;
        } 
        if($id_souscat=="" && $souscat!="") {
            
            $newIdx=$PDO->getNextID($thisSite->PREFIXE_TBL_GEN . "articles");
            $chronox=$PDO->getNextChrono($thisSite->PREFIXE_TBL_GEN . "articles");
            foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){ 
                $myInsert = new myInsert(__FILE__);
                $myInsert->table=$thisSite->PREFIXE_TBL_GEN . "articles";
                $myInsert->field["art"]="souscat_produit";
                $myInsert->field["id"]=$newIdx;
                $myInsert->field["lg"]=$clg;
                $myInsert->field["chrono"]=$chronox;                    
                $myInsert->field["datetime_add"]=date('Y-m-d H:i:s');
                $myInsert->field["actif"]=1;
                $myInsert->field["filtre1"]=$_POST["type"];
                $myInsert->field["filtre2"]=$id_cat;
                $myInsert->field["titre"]=$souscat;
                $id_souscat=$myInsert->execute();
            }
            $tab_souscat_produit[$souscat]=$id_souscat;
            $msgAvertissements[$cpt]["message"].="Ajout Sous catégorie ($souscat)" . $sep_avertissement;
        }


        if($code=="") { $msgAvertissements[$cpt]["message"].="Code obligatoire" . $sep_avertissement; }
        if($titre=="") { $msgErreurs[$cpt]["message"].="Titre obligatoire" . $sep_avertissement; }

		if ($msgErreurs[$cpt]=="") {  
        
			if($_POST["majok"]=="1") {
                
                $newId=$PDO->getNextID("g_cli_produits");
                $chrono=$PDO->getNextChrono("g_cli_produits");
                
               foreach($myAdmin->LIST_LANG_DATAS as $clg=>$nlg){ 
                    $myInsert = new myInsert(__FILE__);
                    $myInsert->table="g_cli_produits";
                    $myInsert->field["id"]=$newId;
                    $myInsert->field["lg"]=$clg;
                    $myInsert->field["chrono"]=$chrono;
                    $myInsert->field["login_add"]=$myAdmin->LOGIN;
                    $myInsert->field["datetime_add"]=date('Y-m-d H:i:s');
                    $myInsert->field["type"]=$__POST['type'];
                    $myInsert->field["code"]=$code;
                    $myInsert->field["actif"]=1;
                    $myInsert->field["titre"]=$titre;
                    $myInsert->field["ile"]=$id_iles;
                    $myInsert->field["cat"]=$id_cat;
                    $myInsert->field["souscat"]=$id_souscat;
                    $myInsert->field["contrat"]=$contrat;
                    $myInsert->field["contact"]=$contact;
                    $myInsert->field["email"]=$email;
                    $myInsert->field["telephone"]=$telephone;
                    $myInsert->field["duree"]=$duree;
                    $myInsert->field["prestataire"]=$prestataire;
                    $result=$myInsert->execute();
                }

				if ($result=="0") {
                    $msgErreurs[$cpt]["message"].="Pb Mise à jour: " . $requete . $sep_avertissement;
				} else {
                    if($showResulatsMaj==1) { $msgMaj[$cpt]["message"].="OK"; }
                    $cptMaj++;
				}
                
			} 
		}
        
        if ($msgAvertissements[$cpt]["message"]!="") { 
            $msgAvertissements[$cpt]["titre"]=$code . " - " . $titre;
        }
        if ($msgErreurs[$cpt]["message"]!="") { 
            $msgErreurs[$cpt]["titre"]=$code . " - " . $titre;
        }
        if ($msgMaj[$cpt]["message"]!="") {
            $msgMaj[$cpt]["titre"]=$code . " - " . $titre;
         }
	
	} // fin boucle ligne	
	


    $smarty->assign("cptLus", ($cpt-$cpt_entete));
    $smarty->assign("cptAvertissements", count($msgAvertissements));
    $smarty->assign("cptErreurs", count($msgErreurs));
    $smarty->assign("cptMaj", $cptMaj);
    
    $smarty->assign("msgAvertissements", $msgAvertissements);
    $smarty->assign("msgErreurs", $msgErreurs);
    $smarty->assign("msgMaj", $msgMaj);

}
?>
<?php

$fieldMedia = new file();
$fieldMedia->field="fichier";
$fieldMedia->label=$datas_lang["fichier"];
$fieldMedia->multiLangType=false; 
$fieldMedia->browse=false; 
$fieldMedia->upload=false; 
$fieldMedia->add();
$fieldMedia->rule("required",true);

$newfield = new radio();
$newfield->field="majok";
$newfield->label=$datas_lang["majBdD"];
$newfield->items=$datas_lang["ouiNon"];
$newfield->defaultValue="0";
$newfield->add();

$obj_article = new article("type_produit");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_type_produit=array();
foreach($result as $row){
   $tab_type_produit[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="type";
$newfield->label="Type";
$newfield->noneItem=true;
$newfield->items=$tab_type_produit;
$newfield->add();
$newfield->rule("required",true);
?>
<?php
include(DOS_INCPAGES_ADMIN  . "maj-prepare.php");
?>