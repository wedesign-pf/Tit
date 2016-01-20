<?php
$myTable=$thisSite->PREFIXE_TBL_PUB . "stats";
$myTableBandeaux=$thisSite->PREFIXE_TBL_PUB . "bandeaux";
$myTableCampagnes=$thisSite->PREFIXE_TBL_PUB . "campagnes";
$myTableEmplacements=$thisSite->PREFIXE_TBL_PUB . "emplacements";
$orderby="id ASC";
$actionsPage=array("");
$actionsPageOnlySA=array("");
$listCols=array();

$listCols[]=array("field"=>"element","label"=>"Jour","align"=>"center","width"=>"10%","class"=>"notGoMaj");
$listCols[]=array("field"=>"compteurs","label"=>"<span style='background:orange; display:inline-block; width:20px; border:1px solid white;'>&nbsp;</span> = Affichages &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style='background:green; display:inline-block; width:20px; border:1px solid white;'>&nbsp;</span> = Clicks","align"=>"left","width"=>"","class"=>"notGoMaj");

?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-init.php");
?>
<?php
// FILTRES /////////////////////////////////////// ????
include(DOS_INCPAGES_ADMIN  . "list-prepareFiltres.php");

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTableCampagnes;
$mySelect->fields="id,titre";
$mySelect->where="actif=1";
if ($myAdmin->ANNONCEUR==1) { 
	$mySelect->where.=" AND annonceur='" . $myAdmin->LOGIN .  "'";
}
$mySelect->orderby="titre ASC";
$result=$mySelect->query();
$listCampagnes=array();
foreach($result as $row){ 
	$listCampagnes[$row["id"]]=$row["titre"];
}
$datas_page["listCampagnes"]=$listCampagnes;

$newfield = new select();
$newfield->field="F__id_campagne";
$newfield->label=$datas_lang["pubCampagne"];
$newfield->widthField=3;
$newfield->items=$listCampagnes;
$newfield->allItems=true;
$newfield->value=${$newfield->field};
$newfield->add();

$mySelect = new mySelect(__FILE__);
$mySelect->tables=$myTableEmplacements;
$mySelect->fields="id,titre";
$mySelect->orderby="titre ASC";
$result=$mySelect->query();
$listEmplacements=array();
foreach($result as $row){ 
	$listEmplacements[$row["id"]]=$row["titre"];
}
$datas_page["listEmplacements"]=$listEmplacements;

$newfield = new select();
$newfield->field="F__id_emplacement";
$newfield->label=$datas_lang["pubEmplacement"];
$newfield->widthField=3;
$newfield->items=$listEmplacements;
$newfield->allItems=true;
$newfield->value=${$newfield->field};
$newfield->add();

$newfield = new select();
$newfield->field="F__lg";
$newfield->label=$datas_lang["langue"];
$newfield->widthField=2;
$newfield->items=$myAdmin->LIST_LANG_DATAS;
$newfield->allItems=true;
$newfield->value=${$newfield->field};
$newfield->add();

$listJours=array();
for($i=0;$i<=31;$i++) {
	if($i<10) $ii="0".$i; else $ii=$i;
	$listJours[$i]=$ii;
}
$newfield = new select();
$newfield->field="F__jour";
$newfield->label="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $datas_lang["jour"];
$newfield->widthLabel=0;
$newfield->widthField=0;
$newfield->items=$listJours;
$newfield->value=${$newfield->field};
$newfield->add();

$listMois=array();
for($i=0;$i<=12;$i++) {
	if($i<10) $ii="0".$i; else $ii=$i;
	$listMois[$i]=$ii;
}
$newfield = new select();
$newfield->field="F__mois";
$newfield->label="&nbsp;&nbsp;&nbsp;" . $datas_lang["mois"];
$newfield->widthLabel=0;
$newfield->widthField=0;
$newfield->items=$listMois;
$newfield->value=${$newfield->field};
$newfield->add();

$listAnnees=array();
$listAnnees["0000"]="0000";	
$resultx = $PDO->free_requete("SELECT aa FROM " . $myTable . " GROUP BY aa");
foreach($resultx as $rowx){
	$listAnnees[$rowx["aa"]]=	$rowx["aa"];	
}
$newfield = new select();
$newfield->field="F__annee";
$newfield->label="&nbsp;&nbsp;&nbsp;" . $datas_lang["annee"];
$newfield->widthLabel=0;
$newfield->widthField=0;
$newfield->items=$listAnnees;
$newfield->value=${$newfield->field};
$newfield->add();
// FIN FILTRES //////////////////////////////////////////
?>
<?php
//for($i=0;$i<=101;$i++) {
//	$lg = array_rand($myAdmin->LIST_LANG_DATAS, 1);
//	$e = array_rand($listEmplacements, 1);
//	$c = array_rand($listCampagnes, 1);
//	$b = rand(1, 5);
//	$aa = rand(2014, 2015);
//	$mm = rand(1, 12);
//	$jj = rand(1, 30);
//	
//	$nb_aff = rand(0, 500);
//	$nb_click = rand(0, 50);
//
//	$resultx = $PDO->free_requete("INSERT INTO " . $myTable . " (lg, id_emplacement, id_campagne, id_bandeau, aa, mm, jj, nb_aff, nb_click) VALUES ('$lg', $e, $c, $b, $aa, $mm, $jj, $nb_aff, $nb_click)");
//}

// CHARGEMENT LISTE //////////////////////////////////////////
$formList = new formList();
$formList->tables=$myTable;
$formList->pagination=false;

// Filtres /////////////////////////////////////// ????
$formList->where="0=0";
if($F__id_emplacement!="" && $F__id_emplacement!="allItems") { $formList->where.=" AND id_emplacement='" . $F__id_emplacement . "'"; }
if($F__id_campagne!="" && $F__id_campagne!="allItems") { $formList->where.=" AND id_campagne='" . $F__id_campagne . "'"; }
if($F__lg!="" && $F__lg!="allItems") { $formList->where.=" AND lg='" . $F__lg . "'"; }
$formList->where.=" AND aa='" . $F__annee . "'"; $groupby="mm";  $label="Mois";
if($F__mois!="" && $F__mois!="0") { $formList->where.=" AND mm='" . $F__mois . "'"; $groupby="jj";  $label="Jour"; }
if($F__jour!="" && $F__jour!="0") { $formList->where.=" AND jj='" . $F__jour . "'"; $groupby="";   }

if ($groupby=="") {
	$formList->fields="jj AS element, count(id) AS cpt, sum(nb_aff) AS cpt_nb_aff, sum(nb_click) AS cpt_nb_click";
	$formList->orderby=$orderby;
} else {
	$formList->fields="$groupby AS element, count(id) AS cpt, sum(nb_aff) AS cpt_nb_aff, sum(nb_click) AS cpt_nb_click";
	$formList->groupby=$groupby;
	$listCols[0]["label"]=$label;
}
//
//
	
// Filtres /////////////////////////////////////// ????
//
$formList->clause_where();
$count_datas = $formList->get_datas();
//echoa($formList->datasList);

$barmax=600;
$affmax=0;

if(count($formList->datasList)>0) {
	foreach($formList->datasList as $keyId=>$datas){ 
	 if ($datas["cpt_nb_aff"]>$affmax) {$affmax=$datas["cpt_nb_aff"];}
	}
	
	include(DOS_INCPAGES_ADMIN  . "list-beforeLoop.php");

	$listRow=array();
	foreach($formList->datasList as $keyId=>$datas){ 
		$valeurs=array();

		include(DOS_INCPAGES_ADMIN  . "list-inLoop.php");
		
		$lgbar_aff=($datas["cpt_nb_aff"]*$barmax)/$affmax;
		$lgbar_click=($datas["cpt_nb_click"]*$barmax)/$affmax;
		if ($lgbar_aff<1) {$lgbar_aff=1; }
		if ($lgbar_click<1) {$lgbar_click=1; }
		$pour_click=0;
		if ($aff>0) { $pour_click = round(($datas["cpt_nb_click"]*100)/$datas["cpt_nb_aff"],2); }
		
		$valeurs["compteurs"]="<div class='bar_stats'>";
		$valeurs["compteurs"].="<div class='bar'><div style='background:orange; width:" . $lgbar_aff . "px; '>&nbsp;</div>" . $datas["cpt_nb_aff"] . "</div>";
		$valeurs["compteurs"].="<div class='bar'><div style='background:green; width:" . $lgbar_click . "px;'>&nbsp;</div>" . $datas["cpt_nb_click"] . "</div>";
		$valeurs["compteurs"].="</div>";
		$listRow[$keyId]=$valeurs;
	
	} // fin lecture dataList

} //count($formList->datasList)

// FIN CHARGEMENT LISTE //////////////////////////////////////////
?>
<?php
include(DOS_INCPAGES_ADMIN  . "list-prepare.php");
?>