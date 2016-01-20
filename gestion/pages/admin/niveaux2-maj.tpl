{extends file="{$templateParent}"}
{block name=content}
	<section><div class="row"><label class="label col col-2 ">{$datas_lang.niveau0}</label>{$datas_page.titreNiveau0}</div></section>
	<section><div class="row">{$field_id0}</div></section>
	<section><div class="row">{$field_id1}</div></section>
	{if $myAdmin->PRIVILEGE eq 9}{$datas_page.aideLienAdmin}{/if}
	<section><div class="row">{$field_titre}</div></section>
	<section><div class="row">{$field_lien}</div></section>
	<section><div class="row">{$field_param_lien}</div></section>
	<section><div class="row">{$field_cible}</div></section>
	<section><div class="row">{$field_actif}</div></section>
	<section><div class="row">{$field_privilege}</div></section>
	{if $majInsert eq 1 }<section><div class="row">{$field_admin}</div></section>{/if}
	<section><div class="row">{$field_explications}</div></section>
{/block}	
