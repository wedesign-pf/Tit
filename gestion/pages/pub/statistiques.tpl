{extends file="{$templateParent}"}
{block name=filtres}
<section><div class="row pbvs">{$field_F__id_emplacement}</div><section>
<section><div class="row">{$field_F__id_campagne}</div></section>
<section><div class="row">{$field_F__lg}{$field_F__jour}{$field_F__mois}{$field_F__annee}</div></section>
<section><div class="row"></div></section>
<div class="clear"><div id="btnFiltre" class="left btnAction">{$datas_lang.filtrer}</div></div>
{/block}