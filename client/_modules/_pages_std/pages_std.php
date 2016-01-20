<?php
global $thisSite;

$obj_article = new article($params_module["article"]);
if(isset($params_module["id"])) { $obj_article->where="id=" . $params_module["id"];  }
if(isset($params_module["idPage"])) { $obj_article->where="id_page=" . $params_module["idPage"];  }
$obj_article->limit="1";
$obj_article->medias="image,video,file,link";
$result=$obj_article->query();

$row = current($result); 

$dataStd=array();
$dataStd["titre"]=$row["titre"];
$dataStd["sous_titre"]=$row["sous_titre"];
$dataStd["date"]=explode(" ",format_datejour($row["date"],1)); // Mar 28 Jul 2015

$dataMedias["images"]=$row["image"];
$dataMedias["videos"]=$row["video"];
$dataStd["files"]=$row["file"];
$dataStd["links"]=$row["link"];

$dataStd["texte1"]=add_glossaire($row["texte1"]);
$dataStd["texte2"]=add_glossaire($row["texte2"]);
$dataStd["texte3"]=add_glossaire($row["texte3"]);   
 
if($row["tags"]!="") {
    $lTags=explode(",",$row["tags"]);
    $tags="";
    $sep="";
    foreach($lTags as $idTag){ 
        $tags.= $sep . "<a class='tag' href='recherche?searchMe=" .  $thisSite->tags["tags"][$idTag] . "'>" . $thisSite->tags["tags"][$idTag] . "</a>";
        $sep=" / ";
    }
    
    $dataStd["tags"]=$tags;
}

$i=1;
if(is_array($dataMedias["videos"])) {
	foreach($dataMedias["videos"] as $x=>$video){ 
	    $media=array();
		$media["legende"]=$video["legende"];
		$media["thumb"]=$video["thumb"];
		$media["button"]["video"]=array("link"=>$video["player"]);
		$obj_module = new module("_hoverme");
		$obj_module->params=$media;
		$obj_module->return=true;
		$dataStd["videos"][$i]["imgHover"]=$obj_module->load();
		$i++;
	}
}
if(is_array($dataMedias["images"])) {
	foreach($dataMedias["images"] as $x=>$image){ echoa($params_module["noFirstImage"]);
    if($params_module["noFirstImage"]==true && $x==1) { continue; }
		$media=array();
		$media["legende"]=$image["legende"];
		$media["thumb"]=$image["vig0"];
		$media["image"]=$image["image"];
        $media["rel"]='group';
		$media["imgLiquid"]="imgLiquidFill";
		$obj_module = new module("_hoverme");
		$obj_module->params=$media;
		$obj_module->return=true;
		$dataStd["images"][$i]["imgHover"]=$obj_module->load();
		$i++;
	}
}

$smarty->assign("dataStd",$dataStd);

// Modules contenus
$blocsContenu=load_blocsModules($params_module["modulesContenu"]);
$smarty->assign("blocsContenu",$blocsContenu);

/////////////////////////// side bar ///////////////////////////////////////
$blocsSidebar=load_blocsModules($params_module["modulesSideBar"]);
$smarty->assign("blocsSidebar",$blocsSidebar);

if($dataStd["texte3"]!="" || $blocsSidebar!="") { $sidebar=1; } else { $sidebar=0; }
$smarty->assign("sidebar",$sidebar);
?>    