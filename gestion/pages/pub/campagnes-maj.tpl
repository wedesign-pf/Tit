{extends file="{$templateParent}"}
{block name=content}
	<section><div class="row">{$field_actif}</div></section>
	<section><div class="row">{$field_titre}</div></section>
	<section><div class="row">{$field_annonceur}</div></section>
	<section><div class="row">{$field_motdepasse}</div></section>
	<fieldset><legend>{$datas_lang.filtres}</legend>
	<section><div class="row">{$field_periode_beg}{$field_periode_end}</div></section>
	</fieldset>
{/block}