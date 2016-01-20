<ul id="langues">
	{foreach $liste_langues as $lg=>$data}
	<li><a href="{$data.lien}" title="{$data.titre}">{$lg}</a></li>
	{/foreach}
</ul>