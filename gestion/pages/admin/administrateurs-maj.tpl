{extends file="{$templateParent}"}
{block name=content}

	<section><div class="row">{$field_actif}</div></section>
	<section><div class="row">{$field_login}</div></section>
	<section><div class="row">{$field_mdp}</div></section>
	<section><div class="row">{$field_confirm_mdp}</div></section>
	<section><div class="row">{$field_titre}</div></section>
	<section><div class="row">{$field_email}</div></section>
	<section><div class="row">{$field_privilege}</div></section>
	<section><div class="row">{$field_langues}</div></section>
	
	<fieldset><legend>DROITS D'ACCES</legend>
	<div id="droitsAdmin" class="line">
	<table cellpadding="0" cellspacing="0">
	<tr class="dniveauH">
				<td></td>
				<td class="w10">Autoriser</td>
				<td class="w10">Ajouter</td>
				<td class="w10">Modifer</td>
				<td class="w10">Supprimer</td>
	</tr>
	{foreach $listeNiveaux as $x=>$datasNiv}
		{if $datasNiv.niv eq "0"}
		<tr class="dniveau0" >
			<td colspan="5">
			<input type='checkbox' class='dNiv0' name='niv0_{$datasNiv.id}' data-id="{$datasNiv.id}" id='niv0_{$datasNiv.id}' value='{$datasNiv.id}' {if $formMaj->datasForm[""]['niveaux0']|strstr:$datasNiv.id} checked {/if}><i></i><span class="plvs">{$datasNiv.titre}</span>
			</td>
		</tr>
		{/if}
		{if $datasNiv.niv eq "1"}
			<tr class="dniveau1 tr0_{$datasNiv.id0} {if !$formMaj->datasForm[""]['niveaux0']|strstr:$datasNiv.id0 && !$formMaj->datasForm[""]['niveaux1']|strstr:$datasNiv.id} hideMe {/if}">
				<td colspan="5"><div class="plm"><input type='checkbox' data-id="{$datasNiv.id0}{$datasNiv.id}"  class='dNiv1 n0_{$datasNiv.id0}' name='niv1_{$datasNiv.id}' id='niv1_{$datasNiv.id}' value='{$datasNiv.id}' {if $formMaj->datasForm[""]['niveaux1']|strstr:$datasNiv.id} checked {/if}><i></i><span  class="plvs">{$datasNiv.titre}</span></div>
				</td>
			</tr>
		{/if} 
		{if $datasNiv.niv eq "2"}
			<tr class="dniveau2 tr0_{$datasNiv.id0} tr1_{$datasNiv.id0}{$datasNiv.id1} {if !$formMaj->datasForm[""]['niveaux0']|strstr:$datasNiv.id0 || !$formMaj->datasForm[""]['niveaux1']|strstr:$datasNiv.id1 } hideMe {/if}">
				<td style="text-align:left"><div class="pll">{$datasNiv.titre}</div></td>
				<td><input type='checkbox' data-id="{$datasNiv.id}" class='dNiv2 n0_{$datasNiv.id0} n1_{$datasNiv.id0}{$datasNiv.id1}' name='niv2_{$datasNiv.id}' id='niv2_{$datasNiv.id}' value='{$datasNiv.id}' {if $formMaj->datasForm[""]['niveaux2']|strstr:$datasNiv.id} checked {/if}><i></i></td>
				<td><input type='checkbox' class='n0_{$datasNiv.id0} n1_{$datasNiv.id0}{$datasNiv.id1} n2_{$datasNiv.id}' name='add2_{$datasNiv.id}' id='add2_{$datasNiv.id}' value='{$datasNiv.id}' {if $formMaj->datasForm[""]['niveaux2add']|strstr:$datasNiv.id} checked {/if}><i></i></td>
				<td><input type='checkbox' class='n0_{$datasNiv.id0} n1_{$datasNiv.id0}{$datasNiv.id1} n2_{$datasNiv.id}' name='mod2_{$datasNiv.id}' id='mod2_{$datasNiv.id}' value='{$datasNiv.id}' {if $formMaj->datasForm[""]['niveaux2mod']|strstr:$datasNiv.id} checked {/if}><i></i></td>
				<td><input type='checkbox' class='n0_{$datasNiv.id0} n1_{$datasNiv.id0}{$datasNiv.id1} n2_{$datasNiv.id}' name='del2_{$datasNiv.id}' id='del2_{$datasNiv.id}' value='{$datasNiv.id}' {if $formMaj->datasForm[""]['niveaux2del']|strstr:$datasNiv.id} checked {/if}><i></i></td>
			</tr>
		{/if}
		
	{/foreach}{*listeNiveaux*}
	</table>

	</div>

	</fieldset>
<script type="text/javascript" >

{literal}
$(document).ready(function () {
	
	$(".hideMe").hide();
	//$(".dniveau2").hide();
	
	$('.dNiv0').click(function () { 
		var etat= $(this).prop("checked");
		var $case = $('.n0_'+$(this).attr("data-id"));
		$case.prop("checked", etat);

		var $tr = $('.tr0_'+$(this).attr("data-id"));
		if(etat==true) { $tr.show(); } else { $tr.hide(); }

	});

	$('.dNiv1').click(function () { 
		var etat= $(this).prop("checked");
		var $case = $('.n1_'+$(this).attr("data-id"));
		
		$case.prop("checked", etat);
		
		var $tr = $('.tr1_'+$(this).attr("data-id"));
		if(etat==true) { $tr.show(); } else { $tr.hide(); }
		
	});

	$('.dNiv2').click(function () {
		var etat= $(this).prop("checked");
		var $case = $('.n2_'+$(this).attr("data-id"));
		$case.prop("checked", etat); //!$case.prop("checked")
	});

});
{/literal}
</script>
{/block}	
