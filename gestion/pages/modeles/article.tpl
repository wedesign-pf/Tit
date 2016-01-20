{extends file="{$templateParent}"}
{block name=filtres}
{foreach $datasArticle.filtre as $f=>$filtre}
<section class="line"><div>{$filtre.HTML_Filtre}</div></section>
{/foreach}
{/block}