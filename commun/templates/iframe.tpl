<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$thisSite->current_lang}">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<base href="{$thisSite->racineWithLang}" target="_self" />
<meta name="robots" content="noindex,nofollow" />
{if $thisSite->googleAnalytics ne "" && $thisSite->SERVER ne "local" }
{$thisSite->googleAnalytics}
{/if}
{if $thisSite->CSS_OPTIMIZE eq ""}
<link href="{$thisSite->DOS_CLIENT_SKIN}reset.css" rel="stylesheet" type="text/css" />
<link href="{$thisSite->skin}base.css" rel="stylesheet" type="text/css" />
<link href="{$thisSite->skin}style.css" rel="stylesheet" type="text/css" />
<link href="{$thisSite->skin}responsive.css" rel="stylesheet" type="text/css" />
<link href="{$thisSite->skin}font-awesome.css" rel="stylesheet" type="text/css" />
{else}
<link href="{$thisSite->skin}{$thisSite->CSS_OPTIMIZE}" rel="stylesheet" type="text/css" />
{/if}
{if $thisSite->printCSS==true}<link href="{$thisSite->skin}print.css" rel="stylesheet" type="text/css" media="print"/>{/if}

{if $PAGE_css_client[0] ne ""}
{foreach $PAGE_css_client as $elt}
<link href="{$elt}" rel="stylesheet" type="text/css" />
{/foreach}
{/if}

</head>
<body>
{* ------------ Contenu de la page en cours --------------------- *}
{if $thisSite->current_scriptTPL ne ""} {include file="{$thisSite->current_scriptTPL}"} {/if}
{if $current_scriptTPL ne ""} {include file="{$current_scriptTPL}"} {/if}
{* ------------  FIN contenu de la page en cours --------------------- *}
</body>
</html>
<script type="text/javascript" >
{if $PAGE_javascript[0] ne ""}

{foreach $PAGE_javascript as $elt}
	{if $elt ne ""} {$elt} {/if}
{/foreach}

{/if}
{if $PAGE_doc_ready[0] ne ""}

$(document).ready( function(){
{foreach $PAGE_doc_ready as $elt}
	{if $elt ne ""} {$elt} {/if}
{/foreach}
});
{/if}
{if $PAGE_win_load[0] ne ""}

$(window).on("load", function() {
{foreach $PAGE_win_load as $elt}
	{if $elt ne ""} {$elt} {/if}
{/foreach}
});
{/if}
</script>