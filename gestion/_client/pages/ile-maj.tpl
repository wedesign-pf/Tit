{extends file="{$templateParent}"}
{block name=content}
{$field_login_add}{$field_login_mod}{$field_datetime_add}{$field_datetime_mod}
	<section><div class="row">{$field_actif}</div></section>
   	<section><div class="row">{$field_archipel}</div></section>
    <section><div class="row">{$field_titre}</div></section>
    <section><div class="row">{$field_sous_titre}</div></section>
    <section><div class="row">{$field_lat_lgn}</div></section>
    <section><div class="row">{$field_resume}</div></section>
{/block}
