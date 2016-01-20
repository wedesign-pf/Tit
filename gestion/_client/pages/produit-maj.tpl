{extends file="{$templateParent}"}
{block name=content}
{$field_login_add}{$field_login_mod}{$field_datetime_add}{$field_datetime_mod}
	<section><div class="row">{$field_actif}</div></section>
   	<section><div class="row">{$field_type}</div></section>
    <section><div class="row">{$field_cat}</div></section>
    <section><div class="row">{$field_souscat}</div></section>
    <section><div class="row">{$field_ile}</div></section>
    <section><div class="row">{$field_code}</div></section>
    <section><div class="row">{$field_titre}</div></section>
    <section><div class="row">{$field_sous_titre}</div></section>
    <section><div class="row">{$field_lat_lgn}</div></section>
    <section><div class="row">{$field_resume}</div></section>
    <section><div class="row">{$field_produit_fichier}</div><hr></section>
    <section><div class="row">{$field_produit_lien}</div><hr></section>
    <section><div class="row">{$field_produit_video}</div><hr></section>
{/block}
{block name=javascript}
<script type="text/javascript" >

$(document).ready(function () {
	
    $("input[name=type]").change(function (event) { 
		$.ajax({
			type: "GET",
			cache:false,
			url: '{$smarty.const.DOS_CLIENT_ADMIN}pages/ajax_change_caract_produit.php',
			data: 'type='+$(this).val(),
            dataType: 'json',
            success: function(data) {
                $("#cat").empty();
                $("#souscat").empty();
                $("#cat").append('<option value="noneItem">Choisissez...</option>');
                $.each(data, function(index, value) { 
                    $("#cat").append('<option value="'+ index +'">'+ value +'</option>');
                });
            }
		}); 
	});
    
     $("#cat").change(function (event) { 
		$.ajax({
			type: "GET",
			cache:false,
			url: '{$smarty.const.DOS_CLIENT_ADMIN}pages/ajax_change_caract_produit.php',
			data: 'cat='+$(this).val(),
            dataType: 'json',
            success: function(data) {
                $("#souscat").empty();
                $("#souscat").append('<option value="noneItem">Choisissez...</option>');
                $.each(data, function(index, value) { 
                    $("#souscat").append('<option value="'+ index +'">'+ value +'</option>');
                });
            }
		});
	});
    
    
});
</script>
{/block}