<ul id="langues">
	{foreach $liste_langues as $lg=>$data}
	<li><a href="{$data.lien}" title="{$data.titre}">{$data.titre}</a></li>
	{/foreach}
</ul>