<?php

$hoverme=array();

$media=array();
$media["rel"]="groupe1";
$media["legende"]="Maitre Renard par l'odeur alléché, lui tint à peu près ce language. Que vous êtes beau Monsieur Corbeau";
$media["description"]="<b>TEST</b>qdqsdf sdfsdfsdf sdf sd fdsfqsd qsdqs qd Maitre Renard par l'odeur alléché, lui tint à peu près ce language. Que vous êtes beau Monsieur Corbeau sdf sdfsd fssd fdsfsdfsd";
$media["thumb"]="client/files/actualites/test_vig0.jpg";
$media["image"]="client/files/actualites/bigone.jpg";
$media["button"]["link"]=array("link"=>"http://www.glopglop.com","target"=>"_blank");
$media["button"]["video"]=array("link"=>"https://www.youtube.com/embed/fiTSOpAlI60");
$media["otherImage"][]=array("image"=>"client/files/actualites/test.jpg","legende"=>"TEST dqsqsdqsdqsdqsdqsqsd");
$media["otherImage"][]=array("image"=>"client/files/actualites/test1.jpg","legende"=>"TEST test1 ");
$media["otherImage"][]=array("image"=>"client/files/actualites/test2.jpg","legende"=>"TEST test2");
$hoverme[]=$media;

$media=array();
$media["rel"]="groupe2";
$media["legende"]="Maitre Renard par l'odeur alléché, lui tint à peu près ce language. Que vous êtes beau Monsieur Corbeau. Que vous êtes beau Monsieur Corbeau";
$media["thumb"]="client/files/actualites/test1_vig0.jpg";
$media["image"]="client/files/actualites/bigone.jpg";
$hoverme[]=$media;

$media=array();
$media["rel"]="groupe2";
$media["legende"]="Maitre Renard par l'odeur alléché, lui tint à peu près ce language. Que vous êtes beau Monsieur Corbeau. Que vous êtes beau Monsieur Corbeau";
$media["thumb"]="client/files/actualites/test2_vig0.jpg";
$media["image"]="client/files/actualites/bigone.jpg";
$media["button"]["video"]=array("link"=>"https://player.vimeo.com/video/116991571");
$hoverme[]=$media;

$obj_module = new module("_hoverme");
$obj_module->params=$hoverme;
$obj_module->return=true;
$result=$obj_module->load();
$smarty->assign("result1",$result); 
?>