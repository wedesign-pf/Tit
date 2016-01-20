{extends file="{$templateParent}"}
{block name=content}
<style type="text/css">
.avertissement  {
	color: blue;
}
.erreur  {
	color: red;
}
.maj {
	color: green;
}

.tableResultat  {
    border:none;
}
.tableResultat td {
    padding:2px 5px;
    border:1px solid lightgray;
    font-size:12px;
}
</style>
{if $msgAvertissements|@count > 0}
	<section>
    <div class="plm prm pbs">
    <div class="avertissement"><b>AVERTISSEMENTS</b></div>
    <table class="tableResultat" >
    <tr>
    <td class="w5" align="center"><b>#</b></td>
    <td class="" align="left"><b>Marque - Titre</b></td>
    <td class="" align="left"><b>Message</b></td>
    </tr>
    {foreach $msgAvertissements as $cpt=>$datas}
        <tr>
        <td class="w5" align="center">{$cpt}</td>
        <td align="left">{$datas.titre}</td>
        <td align="left" class="avertissement">{$datas.message}</td>
        </tr>
    {/foreach}
    </table>
    </div>
    </section>
{/if}    
{if $msgErreurs|@count > 0}
	<section>
    <div class="plm prm pbs">
    <div class="erreur"><b>ERREURS</b></div>
    <table class="tableResultat" >
    <tr>
    <td class="w5" align="center"><b>#</b></td>
    <td class="" align="left"><b>Marque - Titre</b></td>
    <td class="" align="left"><b>Message</b></td>
    </tr>
    {foreach $msgErreurs as $cpt=>$datas}
        <tr>
        <td class="w5" align="center">{$cpt}</td>
        <td align="left">{$datas.titre}</td>
        <td align="left" class="erreur">{$datas.message}</td>
        </tr>
    {/foreach}
    </table>
    </div>
    </section>
{/if}

{if $msgMaj|@count > 0}
	<section>
    <div class="plm prm pbs">
    <div class="maj"><b>MISE A JOUR</b></div>
    <table class="tableResultat" >
    <tr>
    <td class="w5" align="center"><b>#</b></td>
    <td class="" align="left"><b>Marque - Titre</b></td>
    <td class="" align="left"><b>Message</b></td>
    </tr>
    {foreach $msgMaj as $cpt=>$datas}
        <tr>
        <td class="w5" align="center">{$cpt}</td>
        <td align="left">{$datas.titre}</td>
        <td align="left" class="maj">{$datas.message}</td>
        </tr>
    {/foreach}
    </table>
    </div>
    </section>
{/if}
{if $cptLus ne "" }
    <section>
    <div class="plm prm pbs">
    <div class=""><b>TOTAUX</b></div>
    <table class="tableResultat" style="width:auto; font-size:14px;">
    <tr>
    <td class="" align="left">Lus</td>
    <td class="" align="left"><b>{$cptLus}</b></td>
    </tr>
    <tr>
    <td class="" align="left">Avertissements</td>
    <td class="avertissement" align="left"><b>{$cptAvertissements}</b></td>
    </tr>
    <tr>
    <td class="" align="left">En erreurs</td>
    <td class="erreur" align="left"><b>{$cptErreurs}</b></td>
    </tr>
    <tr>
    <td class="" align="left">Mis à jour</td>
    <td class="maj" align="left"><b>{$cptMaj}</b></td>
    </tr>
    </table>
    </div>
    </section>
{/if}    
    <section><div class="row">{$field_type}</div></section>
	<section><div class="row">{$field_fichier}</div></section>
	<section><div class="row">{$field_majok}</div></section>
{/block}	