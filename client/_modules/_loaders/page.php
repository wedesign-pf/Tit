<?php
addStructure("PAGE_head","<link href='https://www.google.com/fonts#UsePlace:use/Collection:Open+Sans:400,700,400italic,700italic' rel='stylesheet' type='text/css'>");
?>
<?php
/////////////////////// INITIALISATION des MODULES de BASE //////////////////////////////////////////////

if ($thisSite->SERVER != "local") {
    $obj_module = new module("_boutons_partage");
	$obj_module->doc_ready="$(\".shareIcons\").jsSocials({showLabel: false, showCount: false , shares: [\"facebook\", \"twitter\", \"googleplus\", \"linkedin\"]});"; 
    $obj_module->load(); 
}

$obj_module = new module("_cookies_accept");
$obj_module->js="herbyCookie.js";
$obj_module->load();

$obj_module = new module("_favicon");
$obj_module->load();

$obj_module = new module("_boutons_rs");
$obj_module->load();

$obj_module = new module("_header");
$obj_module->load();

$obj_module = new module("_footer");
$obj_module->load(); 

$obj_outil = new outil("royalslider");
$obj_outil->css=array("royalslider.css","rs-default.css");
$obj_outil->js="jquery.royalslider.min.js";
$obj_outil->load();

/////////////////////// INITIALISATION des OUTILS de BASE  //////////////////////////////////////////////
$obj_outil = new outil("colorbox");
$obj_outil->css="noir.css";
$obj_outil->js="jquery.colorbox-min.js";
$obj_outil->load();

////////////////////////////////////////////////////////////////////////////////////////////////////////
// gestion d'éléments fixes lors du défilement
$obj_outil = new outil("scrolltofixed");
$obj_outil->js="jquery-scrolltofixed-min.js";
$obj_outil->doc_ready="$('#header1').scrollToFixed({marginTop: 0});  $('#header3').scrollToFixed({marginTop: 40, preFixed: function() { $('#logoscrollToFixed').css('opacity', 1) }, postFixed: function() { $('#logoscrollToFixed').css('opacity', 0) } }); ";
$obj_outil->load();

// Positionnement des images dans leur conteneur https://github.com/karacas/imgLiquid
$obj_outil = new outil("imgliquid");
$obj_outil->doc_ready="$('.imgLiquidFill').imgLiquid({fill:true}); $('.imgLiquidNoFill').imgLiquid({fill:false});";
$obj_outil->load();

?>
