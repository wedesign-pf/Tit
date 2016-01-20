<!DOCTYPE html><!--structure ajax-->
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
</head>
<body>
{if $script_tpl ne ""} {include file="{$script_tpl}"} {/if}
</body>
</html>