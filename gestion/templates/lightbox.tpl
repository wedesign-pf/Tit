<!DOCTYPE html><!--structure lightbox-->
<!--[if IE 9]> <html class="no-js ie9" lang="fr"> <![endif]-->
<!--[if gt IE 9]> <!--><html class="no-js" lang="{$myAdmin->LANG_ADMIN}"> <!--<![endif]-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$myAdmin->LANG_ADMIN}">
<head>
<meta charset="utf-8">
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
<link href="{$smarty.const.DOS_SKIN_ADMIN}colorbox.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}jBox.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}jBox_themes/NoticeBorder.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}style.css" rel="stylesheet" type="text/css" />
{if $addCssStructure[0] ne ""}
<!--CSS CLIENT-->
{foreach $addCssStructure as $elt}
<link href="{$elt}" rel="stylesheet" type="text/css" />
{/foreach}
{/if}
<!--JS BASE-->
<!--[if lt IE 9]>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERY1}"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERY2}"></script>
<![endif]-->
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERYM}"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}jBox/jBox.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_BASE_ADMIN}js/scripts.js"></script>
{if $addJsStructure[0] ne ""}
<!--JS CLIENT-->
{foreach $addJsStructure as $elt}
<script type="text/javascript" src="{$elt}"></script>
{/foreach}
{/if}
</head>
<body>
{if $script_tpl ne ""} {include file="{$script_tpl}"} {/if}
</body>
</html>