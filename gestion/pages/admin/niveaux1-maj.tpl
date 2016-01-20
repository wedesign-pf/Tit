{extends file="{$templateParent}"}
{block name=content}
	<section><div class="row">{$field_id0}</div></section>
	<section><div class="row">{$field_titre}</div></section>
	<section><div class="row">{$field_actif}</div></section>
	<section><div class="row">{$field_privilege}</div></section>
    <section><div class="row">{$field_defaut_ferme}</div></section>
	{if $majInsert eq 1 }<section><div class="row">{$field_admin}</div></section>{/if}
{/block}	
