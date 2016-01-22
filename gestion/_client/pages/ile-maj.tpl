{extends file="{$templateParent}"}
{block name=content}
{$field_login_add}{$field_login_mod}{$field_datetime_add}{$field_datetime_mod}
	<section><div class="row">{$field_actif}</div></section>
   	<section><div class="row">{$field_archipel}</div></section>
    <section><div class="row">{$field_ile_reelle}</div></section>
    <section><div class="row">{$field_titre}</div></section>
    <section><div class="row">{$field_sous_titre}</div></section>
    <section><div class="row">{$field_lat_lgn}</div></section>
    <section><div class="row">{$field_resume}</div></section>
    <section><div class="row">{$field_texte}</div></section>
    <section><div class="row">{$field_points_forts}</div></section>
    <section><div class="row">{$field_highlight}</div></section>
    <fieldset><legend>Carte et infos</legend>
    <section><div class="row">{$field_ile_carte}</div></section>
    <section><div class="row">{$field_infos}</div></section>
    </fieldset>
    <section><div class="row">{$field_ile_image}</div></section>
    <section><div class="row">{$field_ile_fichier}</div></section>
    <section><div class="row">{$field_ile_lien}</div></section>
    <section><div class="row">{$field_ile_video}</div></section>
{/block}
