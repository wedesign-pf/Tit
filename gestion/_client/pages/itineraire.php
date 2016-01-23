<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "itineraires";
$orderby="id DESC";
$actionsPage=array("ajouter","supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
if($__POST["F__ile"]=="" || $__POST["F__ile"]=="allItems") { $listCols[]=array("field"=>"ile","label"=>"Ile","align"=>"left"); }
if($__POST["F__profil"]=="" || $__POST["F__profil"]=="allItems") { $listCols[]=array("field"=>"profil","label"=>"Profil","align"=>"left"); }
if($__POST["F__theme"]=="" || $__POST["F__theme"]=="allItems") { $listCols[]=array("field"=>"theme","label"=>"Theme","align"=>"left"); }
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
$listCols[]=array("field"=>"overview","label"=>"Overview","align"=>"center","width"=>"5%", "action"=>"overview"); 
$listCols[]=array("field"=>"texte","label"=>"Textes","align"=>"center","width"=>"5%", "action"=>"texte"); 
$listCols[]=array("field"=>"itineraire_image","label"=>"<i class='icon-append fa fa-15x fa-picture-o'>","align"=>"center","width"=>"5%", "action"=>"image"); 
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-init.php");
?>
<?php
// SUPPRESSION /////////////////////////////////////// ????

if($__POST["actionInList"]=="delete") { // suppression

	foreach ($_POST as $k => $v) { 
		if(strpos($k,"deleteMe")===0) {	
			$idDel=substr($k,8);
			if ((int)$idDel) {
				$myDelete = new myDelete(__FILE__);
				$myDelete->table=$myTable;
				$myDelete->where="id=$idDel";
				$result=$myDelete->execute();
				$deleteDone=true;
                
                deleteMediasbyIdParent("itineraire",$idDel);
                
                $myDelete = new myDelete(__FILE__);
				$myDelete->table=$thisSite->PREFIXE_TBL_CLI . "itineraires_texte";
				$myDelete->where="id_parent=$idDel";
				$result=$myDelete->execute();
			}
		}
	}
	$myAdmin->delete_notification($deleteDone,$result);
	$myAdmin->addLogs($myAdmin->pageCurrent,"DEL",$idDel,$result);
		
} // Fin suppression 
?>
<?php
// FILTRES /////////////////////////////////////// ????
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");


$mySelect = new mySelect(__FILE__);
$mySelect->tables=$thisSite->PREFIXE_TBL_CLI . "iles";
$mySelect->fields="id,titre";
$mySelect->where="actif=1 AND lg=:lg";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$result=$mySelect->query();
$tab_iles=array();
foreach($result as $row){
   $tab_iles[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="F__ile";
$newfield->widthLabel=0;
$newfield->label="Ile";
$newfield->allItems=true;
$newfield->items=$tab_iles;
$newfield->value=$F__ile;
$newfield->javascript="onChange='submitFiltres()'";
$newfield->add();


// Filtre profil
$obj_article = new article("profil");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_profils=array();
foreach($result as $row){
   $tab_profils[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="F__profil";
$newfield->widthLabel=0;
$newfield->label="Type";
$newfield->allItems=true;
$newfield->items=$tab_profils;
$newfield->value=$F__profil;
$newfield->javascript="onChange='submitFiltres()'";
$newfield->add();

// Filtre theme
$obj_article = new article("theme");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_themes=array();
foreach($result as $row){
   $tab_themes[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="F__theme";
$newfield->widthLabel=0;
$newfield->label="Type";
$newfield->allItems=true;
$newfield->items=$tab_themes;
$newfield->value=$F__theme;
$newfield->javascript="onChange='submitFiltres()'";
$newfield->add();


/*
if($F__type=="") {
	RemoveActionPage("ajouter");
}*/
// FIN FILTRES //////////////////////////////////////////
?>
<?php
// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->fields="*";
$formList->orderby=$orderby;
$formList->where="lg='" . $myAdmin->LANG_DATAS . "'";
if($F__ile!="" && $F__ile!="allItems") { $formList->where.=" AND ( ile = '" . $F__ile . "' OR ile LIKE '%" . $F__ile . ",%'" . " OR ile LIKE '%," . $F__ile . "%'" . ")"; }
if($F__profil!="" && $F__profil!="allItems") { $formList->where.=" AND ( profil = '" . $F__profil . "' OR profil LIKE '%" . $F__profil . ",%'" . " OR profil LIKE '%," . $F__profil . "%'" . ")"; }
if($F__theme!="" && $F__theme!="allItems") { $formList->where.=" AND ( theme = '" . $F__theme . "' OR theme LIKE '%" . $F__theme . ",%'" . " OR theme LIKE '%," . $F__theme . "%'" . ")"; }
$formList->clause_where();
$count_datas = $formList->get_datas();

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();
		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");

		// chargement d'autres données /////////////////////////////////////// ????
        $l_iles=explode(",",$datas["ile"]);
        $sep="";
        $valeurs["ile"]="";
        foreach($l_iles as $id_ile){
            if($id_ile!="") {
                $valeurs["ile"].=$sep . $tab_iles[$id_ile];
                $sep=", ";
            }
        }
        
        $l_profils=explode(",",$datas["profil"]);
        $sep="";
        $valeurs["profil"]="";
        foreach($l_profils as $id_profil){
            if($id_profil!="") {
                $valeurs["profil"].=$sep . $tab_profils[$id_profil];
                $sep=", ";
            }
        }
        
        $l_themes=explode(",",$datas["theme"]);
        $sep="";
        $valeurs["theme"]="";
        foreach($l_themes as $id_theme){
            if($id_theme!="") {
                $valeurs["theme"].=$sep . $tab_themes[$id_theme];
                $sep=", ";
            }
        }
    
      //  $valeurs["profil"]=$tab_profils[$datas["profil"]];
      //  $valeurs["theme"]=$tab_themes[$datas["theme"]];
        // ajout nombre de textes dans la liste
        $requetex="SELECT count(id) AS cpt FROM " .  $thisSite->PREFIXE_TBL_CLI . "itineraires_texte" . " WHERE lg='fr' AND id_parent=" . $datas["id"];
		$resultx = $PDO->free_requete($requetex);
		$rowx = $resultx->fetch();
		if($rowx["cpt"]>"0") { $valeurs["texte"]="(" . $rowx["cpt"] . ")"; }
        
        $requetex="SELECT count(id) AS cpt FROM " .  $thisSite->PREFIXE_TBL_CLI . "itineraires_overview" . " WHERE lg='fr' AND id_parent=" . $datas["id"];
		$resultx = $PDO->free_requete($requetex);
		$rowx = $resultx->fetch();
		if($rowx["cpt"]>"0") { $valeurs["overview"]="(" . $rowx["cpt"] . ")"; }
        
		// fin chargement données manuellement
		
		$listRow[$keyId]=$valeurs;
            
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>