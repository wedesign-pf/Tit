<style>
body {
	background-color:#F00;
}	
</style>
<div id="langues">
qsdqsqsqsdqsdqsd
{foreach $liste_liens_langue as $lg=>$r} 
	<a href="{$r.lien}" alt="{$r.titre}" rel="alternate" hreflang="{$lg}"  >{$r.titre}</a>
{/foreach}
</div>