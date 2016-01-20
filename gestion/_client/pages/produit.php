<?php
$myTable=$thisSite->PREFIXE_TBL_CLI . "produits";
$orderby="id DESC";
$actionsPage=array("ajouter","supprimer");
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
$listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
$listCols[]=array("field"=>"code","label"=>"Code","align"=>"left","width"=>"7%");
if($__POST["F__ile"]=="" || $__POST["F__ile"]=="allItems") { $listCols[]=array("field"=>"ile","label"=>"Ile","align"=>"left","width"=>"10%"); }
if($__POST["F__type"]!="" && $__POST["F__type"]!="allItems" && ($__POST["F__cat"]=="" || $__POST["F__cat"]=="allItems")) { $listCols[]=array("field"=>"cat","label"=>"Catégorie","align"=>"left","width"=>"12%"); }
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
$listCols[]=array("field"=>"produit_image","label"=>"<i class='icon-append fa fa-15x fa-picture-o'>","align"=>"center","width"=>"5%", "action"=>"image"); 
$listCols[]=array("field"=>"texte","label"=>"Textes","align"=>"center","width"=>"5%", "action"=>"texte"); 
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
                
                deleteMediasbyIdParent("produit",$idDel);
                
                $myDelete = new myDelete(__FILE__);
				$myDelete->table=$thisSite->PREFIXE_TBL_CLI . "produits_texte";
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

if($F__type!=$filtresOrigine["F__type"]) { $F__cat=""; $F__souscat=""; }
if($F__cat!=$filtresOrigine["F__cat"]) { $F__souscat=""; }

// Filtre Type
$obj_article = new article("type_produit");
$obj_article->fields="id,titre";
$result=$obj_article->query();
$tab_type_produit=array();
foreach($result as $row){
   $tab_type_produit[$row["id"]]=$row["titre"];
}
$newfield = new select();
$newfield->field="F__type";
$newfield->widthLabel=0;
$newfield->label="Type";
$newfield->allItems=true;
$newfield->items=$tab_type_produit;
$newfield->value=$F__type;
$newfield->javascript="onChange='submitFiltres()'";
$newfield->add();

// Filtre Catégorie
if($F__type!="" && $F__type!="allItems") {
    $obj_article = new article("cat_produit");
    $obj_article->fields="id,titre";
    $obj_article->where="filtre1='" . $F__type . "'";
    $result=$obj_article->query();
    $tab_cat_produit=array();
    foreach($result as $row){
       $tab_cat_produit[$row["id"]]=$row["titre"];
    }
	$newfield = new select();
	$newfield->field="F__cat";
	$newfield->widthLabel=0;
	$newfield->label="Catégorie";
	$newfield->allItems=true;
	$newfield->items=$tab_cat_produit;
	$newfield->value=$F__cat;
	$newfield->javascript="onChange='submitFiltres()'";
	$newfield->add();
}

// Filtre Sous Catégorie
if($F__cat!="" && $F__cat!="allItems") {
    $obj_article = new article("souscat_produit");
    $obj_article->fields="id,titre";
    $obj_article->where="filtre2='" . $F__cat . "'";
    $result=$obj_article->query();
    $tab_souscat_produit=array();
    foreach($result as $row){
       $tab_souscat_produit[$row["id"]]=$row["titre"];
    }
    if(count($tab_souscat_produit)>0) {    
        $newfield = new select();
        $newfield->field="F__souscat";
        $newfield->widthLabel=0;
        $newfield->label="Sous catégorie";
        $newfield->allItems=true;
        $newfield->items=$tab_souscat_produit;
        $newfield->value=$F__souscat;
        $newfield->javascript="onChange='submitFiltres()'";
        $newfield->add();
    }
}


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
if($F__type!="" && $F__type!="allItems") {  $formList->where.=" AND type='" . $F__type . "'"; }
if($F__cat!="" && $F__cat!="allItems") { $formList->where.=" AND cat='" . $F__cat . "'"; }
if($F__souscat!="" && $F__souscat!="allItems") { $formList->where.=" AND souscat='" . $F__souscat . "'"; }
if($F__ile!="" && $F__ile!="allItems") { $formList->where.=" AND ile='" . $F__ile . "'"; }
$formList->clause_where();
$count_datas = $formList->get_datas();

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();
		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");

		// chargement d'autres données /////////////////////////////////////// ????
        $valeurs["cat"]=$tab_cat_produit[$datas["cat"]];
        $valeurs["ile"]=$tab_iles[$datas["ile"]];
        // ajout nombre de textes dans la liste
        $requetex="SELECT count(id) AS cpt FROM " .  $thisSite->PREFIXE_TBL_CLI . "produits_texte" . " WHERE lg='fr' AND id_parent=" . $datas["id"];
		$resultx = $PDO->free_requete($requetex);
		$rowx = $resultx->fetch();
		if($rowx["cpt"]>"0") { $valeurs["texte"]="(" . $rowx["cpt"] . ")"; }
		// fin chargement données manuellement
		
		$listRow[$keyId]=$valeurs;
            
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>