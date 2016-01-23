{extends file="{$templateParent}"}
{block name=content}
{$field_login_add}{$field_login_mod}{$field_datetime_add}{$field_datetime_mod}
	<section><div class="row">{$field_actif}</div></section>
    <section><div class="row">{$field_ile}</div></section>
    <section><div class="row">{$field_profil}</div></section>
    <section><div class="row">{$field_theme}</div></section>
    <section><div class="row">{$field_titre}</div></section>
    <section><div class="row">{$field_sous_titre}</div></section>
    <section><div class="row">{$field_prix}</div></section>
    <section><div class="row">{$field_duree}</div></section>
    <section><div class="row">{$field_resume}</div></section>
    <section><div class="row">{$field_itineraire_image}</div></section>
    <section><div class="row">{$field_itineraire_video}</div></section>
    <fieldset><legend>Informations commerciales</legend>
    	
    </fieldset>
{/block}
{block name=javascript}
{/block}