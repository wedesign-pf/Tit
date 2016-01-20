<?php
$myTable=$thisSite->PREFIXE_TBL_GEN . "arbo";
$myTableMenus=$thisSite->PREFIXE_TBL_GEN . "menus";
$myTablePages=$thisSite->PREFIXE_TBL_GEN . "pages";
$actionsPage=array("appliquer");

addStructure("addCssStructure", DOS_SKIN_ADMIN . "nestedSortable.css");
addStructure("addJsStructure", $thisSite->RACINE . $thisSite->DOS_ADMIN . DOS_OUTILS_ADMIN . "nestedSortable/jquery-ui-1.10.4.custom.min.js");
addStructure("addJsStructure", $thisSite->RACINE . $thisSite->DOS_ADMIN . DOS_OUTILS_ADMIN . "nestedSortable/jquery.mjs.nestedSortable.js");
?>
<?php
include(DOS_INCPAGES_ADMIN  . "defaut-init.php");
?>
<?php
//echoa($__POST);
// Ajout d'une page dans l'arbo
if($__POST["newPage"]!="") {
	$classPage = new classPage(); 
	$classPage->idPage=$__POST["newPage"];
	$classPage->code_menu=$__POST["menu"];
	$classPage->addArbo();
}
if($__POST["newArbo"]!="") {

	$posts = json_decode(stripslashes($__POST["newArbo"]));
	//echoa($posts );
	if(is_array($posts)) {
		foreach($posts as $nivMenu) {
			$menu=$nivMenu->id;
			$Rubs=array();
			$sRubs=array();
			$arbo_menu=array();	
			if(is_array($nivMenu->children)) {
				foreach($nivMenu->children as $nivRub) {
					$arbo_menu[$nivRub->id]="";	
					$sRubs=array();
					if(is_array($nivRub->children)) {
						foreach($nivRub->children as $nivsRub) {
							$sRubs[$nivsRub->id]="";
							$ssRubs=array();
							
							if(is_array($nivsRub->children)) {
								foreach($nivsRub->children as $nivssRub) {
									//echoa($nivssRub);
									$ssRubs[$nivssRub->id]="";
								}
								$sRubs[$nivsRub->id]=$ssRubs;
								$arbo_menu[$nivRub->id][$nivsRub->id]=$ssRubs;	
							}
						}
						$arbo_menu[$nivRub->id]=$sRubs;	
					}
				}
			}
			
			$myUpdate = new myUpdate(__FILE__);
			$myUpdate->table=$myTable;
			$myUpdate->field["arbo_menu"]=serialize($arbo_menu);
			$myUpdate->where="code_menu='" . $menu . "'";
			$result=$myUpdate->execute();
			
			$thisSite->reInit=1; // permet la réactualisation du site public pour que les modifications soient prisent en compte

			//echoa($arbo_menu);
		}
			
	}
	
}

// chargement des pages que l'on peut ajouter.
// sachant qu'elles sont automatiquement ajoutée lors de leur création, mais ca permet d'ajouter la meme page à plusieurs endroits dans l'arborescence.

$listPages=array();
$listPagesParent=array();
$mySelect2 = new mySelect(__FILE__);
$mySelect2->tables=$myTablePages;
$mySelect2->fields="id,titre,page_parent";
$mySelect2->where="lg=:lg AND show_in_arbo=1";
$mySelect2->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$mySelect2->orderby="id DESC";
$result2=$mySelect2->query();
foreach($result2 as $row2){
	if($myAdmin->PRIVILEGE==9) { 
	$val = $row2['id'] . " - " . $row2['titre'];
	} else {
	$val=$row2['titre'];
	}
	$listPages[$row2['id']] = $val;
	//if($row2['page_parent']==1) { 
        $listPagesParent[] = $row2['id']; 
    //}
}

//
$listMenus=array();
$mySelect2 = new mySelect(__FILE__);
$mySelect2->tables=$myTableMenus;
$mySelect2->fields="id,code_menu,titre";
$mySelect2->where="lg=:lg";
$mySelect2->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$mySelect2->orderby="id ASC";
$result2=$mySelect2->query();
foreach($result2 as $row2){
	$val=$row2['titre'];
	$listMenus[$row2['code_menu']] = $val;
	$listPagesParent[] = $row2['code_menu'];
}

// Champs ajout d'une page
$newfield = new select();
$newfield->field="menu";
$newfield->label=$datas_lang["menu"];
$newfield->widthLabel=0;
$newfield->noneItem=true;
$newfield->items=$listMenus;
$newfield->add();

$newfield = new select();
$newfield->field="newPage";
$newfield->label=$datas_lang["page"];
$newfield->widthLabel=0;
$newfield->noneItem=true;
$newfield->items=$listPages;
$newfield->javascript="onChange='addPage(this)'";
$newfield->add();

// chargement de l'arbo
$arbo_site=array();
$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTable;
$mySelect->fields="*";
$mySelect->whereValue["lg"]=array($myAdmin->LANG_ADMIN,PDO::PARAM_STR);
$mySelect->orderby="id ASC";
$result=$mySelect->query();
foreach($result as $row){
	$arbo_site[$row['code_menu']]=unserialize($row['arbo_menu']);
}

//echoa($arbo_site);

$smarty->assign("listMenus", $listMenus);
$smarty->assign("listPages", $listPages);
$smarty->assign("listPagesParent", $listPagesParent);

$smarty->assign("arbo_site", $arbo_site);
?>