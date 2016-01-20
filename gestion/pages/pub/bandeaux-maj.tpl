{extends file="{$templateParent}"}
{block name=content}
	<section><div class="row">{$field_actif}</div></section>
	<section><div class="row">{$field_id_emplacement}</div></section>
	<section><div class="row">{$field_id_campagne}</div></section>
	<section><div class="row">{$field_type_affichage}</div></section>
	<section><div class="row">{$field_couleur_fond}</div></section>
	<fieldset><legend></legend>
	<section><div class="row">{$field_image_bandeau}</div></section>
	<section><div class="row">{$field_script_bandeau}</div></section>
	</fieldset>
	<section><div class="row">{$field_lien_destination}</div></section>
	<section><div class="row">{$field_cible_destination}</div></section>
{/block}