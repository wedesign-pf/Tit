{extends file="{$templateParent}"}
{block name=content}
    {$field_datetime_add}{$field_datetime_mod}
	{$field_art}
    {if $field_date ne ""}<section><div class="row">{$field_date}</div></section>{/if}
	{if $field_actif ne ""}<section><div class="row">{$field_actif}</div></section>{/if}
	{if $field_periode ne ""}<section><div class="row">{$field_periode}</div></section>{/if}
	{foreach $datasArticle.filtre as $f=>$filtre}
	<section><div class="row">{$filtre.HTML}</div></section>
	{/foreach}
    {if $field_id_page ne ""}<section><div class="row">{$field_id_page}</div></section>{/if}
	{if $field_titre ne ""}<section><div class="row">{$field_titre}</div></section>{/if}
	{if $field_sous_titre ne ""}<section><div class="row">{$field_sous_titre}</div></section>{/if}
    {if $field_input1 ne ""}<section><div class="row">{$field_input1}</div></section>{/if}
    {if $field_input2 ne ""}<section><div class="row">{$field_input2}</div></section>{/if}
    {if $field_input3 ne ""}<section><div class="row">{$field_input3}</div></section>{/if}
    {if $field_email ne ""}<section><div class="row">{$field_email}</div></section>{/if}
	{if $field_texte1 ne ""}<section><div class="row">{$field_texte1}</div></section>{/if}
	{if $field_texte2 ne ""}<section><div class="row">{$field_texte2}</div></section>{/if}
    {if $field_texte3 ne ""}<section><div class="row">{$field_texte3}</div></section>{/if}
    {if $field_auteur ne ""}<section><div class="row">{$field_auteur}</div></section>{/if}
    {if $field_tags ne ""}<section><div class="row">{$field_tags}</div></section>{/if}
	{if 'image'|array_key_exists:$datasArticle.fields_show OR 'video'|array_key_exists:$datasArticle.fields_show  OR 'file'|array_key_exists:$datasArticle.fields_show  OR  'link'|array_key_exists:$datasArticle.fields_show }
    <fieldset>
	{if 'video'|array_key_exists:$datasArticle.fields_show}<section><div class="row">{$field_{$datasArticle.name}_video}</div><hr></section>{/if}
    {if 'image'|array_key_exists:$datasArticle.fields_show}<section><div class="row">{$field_{$datasArticle.name}_image}</div><hr></section>{/if}
	{if 'file'|array_key_exists:$datasArticle.fields_show}<section><div class="row">{$field_{$datasArticle.name}_file}</div><hr></section>{/if}
	{if 'link'|array_key_exists:$datasArticle.fields_show}<section><div class="row">{$field_{$datasArticle.name}_link}</div><hr></section>{/if}
	</fieldset>
    {/if}
{/block}

