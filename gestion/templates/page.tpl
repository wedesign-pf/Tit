<html xmlns="http://www.w3.org/1999/xhtml" lang="{$thisSite->current_lang}">
<head>
<meta charset="utf-8">
<TITLE>{$page_tag_title}</TITLE>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />{* Empeche IE de se mettre en mode de compatibilité et active Chrome Frame dans IE si existe *}
<![endif]-->
<base href="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}" target="_self" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--CSS BASE-->
<link href="{$smarty.const.DOS_BASE_ADMIN}css/reset.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}font-awesome.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}structure.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}responsive.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}sky-forms.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}multiple-select.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}jBox.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}jBox_themes/NoticeBorder.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}colorbox.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}style.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}menus.css" rel="stylesheet" type="text/css" />
{if $addCssStructure[0] ne ""}
{foreach $addCssStructure as $elt}
<link href="{$elt}" rel="stylesheet" type="text/css" />
{/foreach}
{/if}
<!--[if lt IE 9]>
	<link href="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/css/sky-forms-ie8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--JS BASE-->
<!--[if lt IE 9]>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERY1}"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERY2}"></script>
<![endif]-->
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERYM}"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_BASE_ADMIN}js/scripts.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}jBox/jBox.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.form.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.validate.addMethod.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.modal.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/additional-methods.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.simplyCountable.js"></script>
{if $myAdmin->LANG_ADMIN eq "fr"}<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/lang/messages_fr.js"></script>{/if}
{if $myAdmin->LANG_ADMIN eq "fr"}<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/lang/datepicker-fr.js"></script>{/if}
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}colorbox/jquery.colorbox-min.js"></script>
<!--[if lt IE 10]>
	<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.placeholder.min.js"></script>
<![endif]-->	
<!--[if lt IE 9]>
	<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/sky-forms-ie8.js"></script>
<![endif]-->
{if $addJsStructure[0] ne ""}
<!--JS CLIENT-->
{foreach $addJsStructure as $elt}
<script type="text/javascript" src="{$elt}"></script>
{/foreach}
{/if}
</head>
<body>
<form method="post" id="form_navigation" style="display:none">
<input name="newNiveau0" type="hidden" id="newNiveau0" value="">
<input name="newNiveau2" type="hidden" id="newNiveau2" value="">
<input name="pageNew" type="hidden" id="pageNew" value="">
<input name="request" type="hidden" id="request" value="">
</form>
<div id="loaderForm"></div>
<a id="top"></a>
<header id="header">
<div id="header_1">
	<a id="logo" class="left borderRightBGBlack" href="{$smarty.const.PAGE_ACCUEIL}"><img src="{$smarty.const.DOS_SKIN_ADMIN}images/logo_page.png" /></a>
	<h0 class="left pls">{$TITRE_SITE}</h0>
	<div id="infos_header" class="right txtright plrm borderLeftBGBlack">{$dateCurrent} - {$heureCurrent}<br><a href="{$thisSite->RACINE}" target="_blank" >{$datas_lang.access_public} <i class="fa fa-15x fa-angle-right" ></i></a>
    </div>
	 
	<div id="selectAdministrateur" class="right borderLeftBGBlack">
	<ul id="menuAdministrateur">
		<li class='left menuA'>
		<a href="#"><i class="fa fa-15x fa-user mrvs" ></i>{$myAdmin->LOGIN}</a>
			<ul class="sousmenuA">
				<li class="borderTopBGBlack"><a id="btnProfil" href="{$smarty.const.DOS_PAGES_ADMIN}admin/administrateurs"><i class="fa fa-15x fa-user mrvs" ></i>Profil</a></li>
				<li class="borderTopBGBlack"><a href="logout.php"><i class="fa fa-15x fa-power-off mrvs" ></i>Deconnexion</a></li>
				{if $myAdmin->PRIVILEGE eq 9}<li class="borderTopBGBlack"><a href="#" data-request="initMyAdmin" class="requestLink"><i class="fa fa-15x fa-refresh mrvs requestLink" ></i>ReInitialisation</a></li>{/if} 
			</ul>
		</li>
	</ul>
	</div>
     
</div>

<div id="header_2" class="borderBottom">
	<ul id="niveau0" class="borderBottom">
	{foreach $niveaux0 as $id0=>$titre}
		{if $id0 eq $myAdmin->newNiveau0} {$actif="_actif"} {else} {$actif=""}{/if}	
        <li id="li0{$id0}" class='left menu0 li0{$actif} '>
			<a class="left borderRight a0{$actif}" href="{$id0}">{$titre}<i class="fa fa-15x fa-caret-down mlvs" ></i></a>
			<ul class="sousmenu0">
				{foreach $myAdmin->menuNavigation[$id0] as  $id2=>$datasniv2}
				{if $datasniv2.lien eq "" }	
				<li class='li1'>{$datasniv2.titre}</li>
				{else}
				<li class='li2 borderTopBGBlack'><a href="{$datasniv2.lien}" niv0="{$id0}" niv2="{$id2}" target="{$datasniv2.cible}">{$datasniv2.titre}</a></li>
				{/if}
				{/foreach}				
			</ul>
		</li>
    {/foreach}
	</ul>
    <div class="right borderLeft plvs prvs">
    {foreach $myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extlg}
        {if $clg eq $myAdmin->LANG_DATAS} {$actif="actif"} {else} {$actif=""}{/if}	
        <a class="choixLangue left  {$actif}" href="{$extlg}">{$clg}</a>
    {/foreach}
    </div>
</div>
</header>
<div id="mainContent" class="">
	<div id="navigationPage" class="borderRight" >
    {if $myAdmin->PRIVILEGE==9}
    <a href="javascript: void(0)" id="n1-" class="n1"><span class="addNiv2" niv0="{$myAdmin->newNiveau0}" niv1="0" niv2="6352" href="pages/admin/niveaux2-maj">[+]</span></a>
    {/if}
	{foreach $menuNavigation as $id=>$datasNav}
		{if $datasNav.lien eq "" }
			{$sepfin=""}
			{$sep}
			<li>
                <a href="javascript: void(0)" id="n1-{$id}" class="n1 {if $datasNav.ferme eq 0 }open{/if}">{$datasNav.titre}
                {if $myAdmin->PRIVILEGE==9}<span class="addNiv2 mlvs" niv0="{$myAdmin->newNiveau0}" niv1="0" niv2="6352" href="pages/admin/niveaux2-maj">[+]</span>{/if}
                </a>
                <ul  {if $datasNav.ferme eq 1 }style="display:none"{/if}>
			{$sep="</ul></li>"}
			{$sepfin="</ul>"}
		{else}
			{if $id eq $myAdmin->newNiveau2} {$actif="actif"} {else} {$actif=""}{/if}
			<li><a href="{$datasNav.lien}" niv2="{$id}"  niv0="{$myAdmin->newNiveau0}" target="{$datasNav.cible}" class="n2 {$actif} borderBottom">{$datasNav.titre}</a></li>
		{/if}
	{/foreach}
	{$sepfin}
	</div>
	<div id="mainContentPage" >
		<div id="headerContent" class="borderBottom">
			<h1 class="left plrs">{$myAdmin->titrePage}</h1>
			<div class="right">
				{include file="{$smarty.const.DOS_INC_ADMIN}selectVariables.tpl"}
			</div>
			<div class="clear"></div>
		</div><!--headerContent-->
		<div id="contentPage" class="">
		{if $myAdmin->explicationsPage ne ""}<div id="explicationsPage" class="borderBottom pas clear w100">{$myAdmin->explicationsPage}</div>{/if}
{* ------------ Contenu de la page en cours --------------------- *}
{if $script_tpl ne ""} {include file="{$script_tpl}"} {/if}
{* ------------  FIN contenu de la page en cours --------------------- *}
			<div id="footerContent" class="borderTop">
					<div id="bloc_action_haut" class="right txtright plrm">
						{if $typePage ne "medias"}
						{if in_array("valider", $actionsPage)}<div id="btnValider" class="right btnAction btnACacher">{$datas_lang.valider}</div>{/if}
						{if in_array("appliquer", $actionsPage)}<div id="btnAppliquer" class="right btnAction btnACacher">{$datas_lang.appliquer}</div>{/if}
                        {if in_array("appliquerAndAjout", $actionsPage)}<div id="btnAppliquerAndAjout" class="right btnAction btnACacher">{$datas_lang.appliquerAndAjout}</div>{/if}
						{if in_array("annuler", $actionsPage)}<div id="btnAnnuler" class="right btnAction btnACacher">{$datas_lang.annuler}</div>{/if}
						{/if}
						<div id="loaderBtnAction"></div>
						<div class="clear"></div>
					</div>
				</div>
				<div class="clear"></div>
			</div><!--footerContent-->
		</div><!--contentPage-->
	</div><!--mainContentPage-->
</div><!--mainContent-->
<script type="text/javascript" >

    var lgActiveSuffixe = new String("_{$myAdmin->LANG_DATAS}");
    
// déclaration des langues PHP en JS
// langues administration
{assign var=listLg value='['}
{assign var=sep value=''}
{foreach $myAdmin->LIST_LANG_DATAS as $clg=>$titlg}
	{assign var=listLg value=$listLg|cat:$sep}
	{assign var=listLg value=$listLg|cat:"'"}
	{assign var=listLg value=$listLg|cat:$clg}
	{assign var=listLg value=$listLg|cat:"'"}
	{assign var=sep value=','}
{/foreach}
{assign var=listLg value=$listLg|cat:"];"}
var lang_admin = {$listLg}

// extensions langues
{assign var=listLg value='['}
{assign var=sep value=''}
{foreach $myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extlg}
	{assign var=listLg value=$listLg|cat:$sep}
	{assign var=listLg value=$listLg|cat:"'_"}
	{assign var=listLg value=$listLg|cat:$clg}
	{assign var=listLg value=$listLg|cat:"'"}
	{assign var=sep value=','}
{/foreach}
{assign var=listLg value=$listLg|cat:"];"}
var lang_extension = {$listLg}

// langues controles
{assign var=listLg value='['}
{assign var=sep value=''}
{foreach $myAdmin->LIST_LANG_CONTROLE as $clg=>$extlg}
	{assign var=listLg value=$listLg|cat:$sep}
	{assign var=listLg value=$listLg|cat:"'"}
	{assign var=listLg value=$listLg|cat:$clg}
	{assign var=listLg value=$listLg|cat:"'"}
	{assign var=sep value=','}
{/foreach}
{assign var=listLg value=$listLg|cat:"];"}
var lang_controle = {$listLg}

$(document).ready(function () {

    
	// Accueil
	$('#logo').click(function (event) { 
		event.preventDefault();
		$("#pageNew").val($(this).attr('href'));
		$( "#form_navigation" ).submit(); 
	});
	
	$('.requestLink').click(function(event) {
		event.preventDefault();
		$("#request").val($(this).attr('data-request'));
		$( "#form_navigation" ).submit(); 
	});
    
	// Ne pas afficher les champs SuperAdmin
	{if $myAdmin->PRIVILEGE<9}$('.superAdmin').hide();{/if}

	// on cache tous les champs les langues sauf la langue en cours
	{foreach $myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extlg}
		{if $clg ne $myAdmin->LANG_DATAS} { $(".lang{$extlg}").hide();  }{/if}		
	{/foreach}
			
	// on change de langues des champs
	$('.choixLangue').click(function (event) { 
    	event.preventDefault();
		var newExtlg= $(this).attr('href');
        lgActiveSuffixe = newExtlg;
	{if $reloadLangue==false}	
		{foreach $myAdmin->LIST_LANG_EXTENSION_FIELD as $clg=>$extlg}
			$(".lang{$extlg}").slideUp(); 	
    	{/foreach}
		$(".choixLangue").removeClass("actif"); 
        
		$(this).addClass("actif");    
		$(".lang"+newExtlg).slideDown(); 
	{/if} 
	{if $reloadLangue==true}
		$.ajax({

			type: "POST",
			cache:false,
			url: '{$smarty.const.DOS_AJAX_ADMIN}ajax_change_langue.php',
			data: 'newextlg='+newExtlg,
				success: function(data) {
					window.location.reload()
				}
		});
	{/if}		
	});
				
	// Changement de niveau 1
	$('#niveau0 a.a0').click(function (event) { 
		event.preventDefault();
		$("#newNiveau0").val($(this).attr('href'));
		$( "#form_navigation" ).submit(); 
	});
    
    
    $('.addNiv2').click(function(event) {
        event.stopPropagation();
        $("#pageNew").val($(this).attr('href'));
		$("#newNiveau2").val($(this).attr('niv2'));
		$("#newNiveau0").val($(this).attr('niv0'));
        $("#request").val($(this).attr('niv1'));
		$( "#form_navigation" ).submit(); 
	});
	
    			
	// Changement de niveau 2
	$('#navigationPage li a.n2, .sousmenu0 a').click(function (event) { 
		var xxx=$(this).attr('href');
		if(xxx.match('http:') || xxx.match('https:')){
			//alert(xxx);
		} else { 
			event.preventDefault();
			$("#pageNew").val($(this).attr('href'));
			$("#newNiveau2").val($(this).attr('niv2'));
			$("#newNiveau0").val($(this).attr('niv0'));
			$( "#form_navigation" ).submit(); 
		}
	});
	
	$('#btnProfil').click(function (event) { 
		event.preventDefault();
		$("#pageNew").val($(this).attr('href'));  
		$( "#form_navigation" ).submit(); 
	});	

	// gestion niveau du menu de navigation

	$('#navigationPage li a.n1').click(function () {
 
		if(!$(this).hasClass("open")) {
			$(this).siblings('ul').slideDown('slow');
			$(this).addClass('open');
            var closed=0;	
		} else {
			$(this).siblings('ul').slideUp('slow');
			$(this).removeClass('open');
             var closed=1;	
		}
        
        var n1=$(this).attr("id");
        $.ajax({
			type: "POST",
			cache:false,
			url: '{$smarty.const.DOS_AJAX_ADMIN}ajax_niv1_closed.php',
			data: 'n1='+ n1 + '&closed=' + closed
		});

		return false;

	});

			
	// on affiche une notification si elle existe 
	{if $myAdmin->notification ne ''}
		show_notification("{$myAdmin->notification}","{$myAdmin->notificationClass}");
	{/if}
});

</script>

</body>
</html>