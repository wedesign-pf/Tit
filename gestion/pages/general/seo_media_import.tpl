{extends file="{$templateParent}"}
{block name=content}
<style type="text/css">
.erreur  {
	color: #FF0000;
}
.ok {
	color: #000;
}
</style>
	<section>{$resultat}</section>
	<section><div class="row">{$field_fichier}</div></section>
	<section><div class="row">{$field_majok}</div></section>
	<section><div class="row">{$field_etat}</div></section>
{/block}	