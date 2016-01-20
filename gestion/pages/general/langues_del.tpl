{extends file="{$templateParent}"}
{block name=content}
<style type="text/css">
.erreur  {
	color: #FF0000;
}
.ok {
	color: green;
}
</style>
	<section>{$resultat}</section>
	<section><div class="row">{$field_langue}</div></section>
{/block}	