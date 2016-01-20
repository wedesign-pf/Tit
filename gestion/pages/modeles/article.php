<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "articles";
$orderby=$datasArticle["orderby"];
$actionsPage=$datasArticle["actionsPage"];
$listCols=array();
$listCols[]=array("field"=>"id","label"=>"#","align"=>"center","width"=>"5%");
if(array_key_exists("actif",$datasArticle["fields_show"]) ) {
    $listCols[]=array("field"=>"actif","label"=>"Actif","align"=>"center","width"=>"5%","update"=>0);
}
//if($__POST["F__filtre"]!="" && $__POST["F__filtre"]!="allItems" || count($datasArticle["filtre"])==0 ) { 
    if(is_array($datasArticle["choix1"])) {
	    $listCols[]=array("field"=>"choix1","label"=>$datasArticle["choix1"]["label"],"align"=>"center","width"=>"5%","update"=>$datasArticle["choix1"]["update"]); 
    }
    if(is_array($datasArticle["choix2"])) {
	    $listCols[]=array("field"=>"choix2","label"=>$datasArticle["choix2"]["label"],"align"=>"center","width"=>"5%","update"=>$datasArticle["choix2"]["update"]); 
    }
   if(is_array($datasArticle["choix3"])) {
	    $listCols[]=array("field"=>"choix3","label"=>$datasArticle["choix3"]["label"],"align"=>"center","width"=>"5%","update"=>$datasArticle["choix3"]["update"]); 
    }
	
//} else {
    // Supprimer pour la page "Alerte Intrusive"....à voir si ca sert ailleurs et si c'est utile
    /*if(is_array($datasArticle["filtre"]) ) {
		foreach($datasArticle["filtre"] as $f=>$filtre) { 
	    	$listCols[]=array("field"=>$filtre["field"],"label"=>$filtre["label"],"align"=>"left"); //,"width"=>"15%"
		}
    }*/
//}
$listCols[]=array("field"=>"titre","label"=>"Titre","align"=>"left","width"=>"");
//$listCols[]=array("field"=>"$myTable","label"=>"<i class='icon-append fa fa-15x fa-sitemap'>","align"=>"center","width"=>"5%", "action"=>"page");
if(array_key_exists("image",$datasArticle["fields_show"]) && ($datasArticle["image_maxElements"]>1 || $datasArticle["image_maxElements"]==0) ) { 
    $listCols[]=array("field"=>$datasArticle["name"] . "_image","label"=>"<i class='icon-append fa fa-15x fa-picture-o'>","align"=>"center","width"=>"5%", "action"=>"image");
}
if(array_key_exists("file",$datasArticle["fields_show"]) && ($datasArticle["file_maxElements"]>1 || $datasArticle["file_maxElements"]==0) ) { 
    $listCols[]=array("field"=>$datasArticle["name"] . "_file","label"=>"<i class='icon-append fa fa-15x fa-file-o'>","align"=>"center","width"=>"5%", "action"=>"file");
}
if(array_key_exists("link",$datasArticle["fields_show"]) && ($datasArticle["link_maxElements"]>1 || $datasArticle["link_maxElements"]==0) ) { 
    $listCols[]=array("field"=>$datasArticle["name"] . "_link","label"=>"<i class='icon-append fa fa-15x fa-link'>","align"=>"center","width"=>"5%", "action"=>"link");
}
if(array_key_exists("video",$datasArticle["fields_show"]) && ($datasArticle["video_maxElements"]>1 || $datasArticle["video_maxElements"]==0) ) { 
    $listCols[]=array("field"=>$datasArticle["name"] . "_video","label"=>"<i class='icon-append fa fa-15x fa-video-camera'>","align"=>"center","width"=>"5%", "action"=>"video");
}
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

				deleteMediasbyIdParent($datasArticle["name"],$idDel);
				
				deletePagebyArticle($myTable,$idDel); // supprimer cet élément à la liste des pages du site

				
				$deleteDone=true;
			}
		}
	}
	$myAdmin->delete_notification($deleteDone,$result);
	$myAdmin->addLogs($myAdmin->pageCurrent,"DEL",$idDel,$result);
		
} // Fin suppression 
// DUPLICATION /////////////////////////////////////// ????
if($__POST["actionInList"]=="dupliquer" && (int)$__POST["actionListId"]) { 
	$newID = $PDO->duplication($myTable,$__POST["actionListId"],"titre", "");
} // Fin Duplication 
?>
<?php
// FILTRES /////////////////////////////////////// ????
if(count($datasArticle["filtre"])>0) {
	include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");

	foreach($datasArticle["filtre"] as $f=>$filtre) {
		if($filtre["type"]=="select") { 
			reset($filtre["items"]);
			$newfield = new select();
			$newfield->field="F__filtre_".$filtre["field"];
			$newfield->label=$filtre["label"];
			$newfield->widthLabel=1;
			$newfield->multiLang=false;
			$newfield->javascript="onChange='submitFiltres()'";
			$newfield->allItems=true;
			$newfield->items=$filtre["items"];
			$newfield->value=${$newfield->field};
			$datasArticle["filtre"][$f]["HTML_Filtre"]=$newfield->add();
		}
		
		if($filtre["type"]=="date") { 
			$newfield = new date();
			$newfield->field="F__filtre_".$filtre["field"];
			$newfield->label=$filtre["label"];
			$newfield->widthLabel=1;
			$newfield->changeYear=true;
			$newfield->numberOfMonths=1;
			$newfield->dateFormat="dd.mm.yy";
			$newfield->javascript="onChange='submitFiltres()'";
			$newfield->value=${$newfield->field};
			$datasArticle["filtre"][$f]["HTML_Filtre"]=$newfield->add();
		}
		
	}
}


// FIN FILTRES //////////////////////////////////////////
?>
<?php 
// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->fields="*";
$formList->orderby=$orderby;
$formList->where="art='" . $datasArticle["name"] . "'";
$formList->where.=" AND lg='" . $myAdmin->LANG_DATAS . "'";
// Filtres ///////////////////////////////////////
if(is_array($datasArticle["filtre"])) { 
	foreach($datasArticle["filtre"] as $f=>$filtre) {
		if($filtre["type"]=="select") { 
			if(${"F__filtre_".$filtre["field"]}!="" && ${"F__filtre_".$filtre["field"]}!="allItems") { $formList->where.=" AND " . $filtre["field"] . " = '" . ${"F__filtre_".$filtre["field"]} . "'"; }
		}
		if($filtre["type"]=="date") { 
			if(${"F__filtre_".$filtre["field"]}!="") { 
				$formList->where.=" AND ( (periode_beg<=" . ${"F__filtre_".$filtre["field"]} . " AND periode_end>=" . ${"F__filtre_".$filtre["field"]} . ")" . " OR (periode_beg<=" . ${"F__filtre_".$filtre["field"]} . " AND periode_end=0) OR (periode_beg=0 AND periode_end>=" . ${"F__filtre_".$filtre["field"]} . ") OR (periode_beg=0 AND periode_end=0)" . ")";
			}
		}
	}
}
$formList->clause_where();
$count_datas = $formList->get_datas();

if(count($formList->datasList)>0) {

	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();
		$datas[$datasArticle["filtre"]["field"]]=$datasArticle["filtre"]["items"][$datas[$datasArticle["filtre"]["field"]]];
        if($datas["titre"]=="" && $datas["id_page"]!="") { $datas["titre"]=$thisSite->pages[$datas["id_page"]]["titre"]; }
		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");

		// chargement d'autres données /////////////////////////////////////// ????

		// fin chargement données manuellement
		
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList
	
} //count($formList->datasList)
// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>