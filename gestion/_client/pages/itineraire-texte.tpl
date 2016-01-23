{extends file="{$templateParent}"}
{block name=afterList}
<form action="" method="post" id="formMaj" class="sky-form pts">
<input type="hidden"  name="actionForm" id="actionForm" value="">
<input type="hidden" name="idCurrent"  id="idCurrent" value="{$idCurrent}" >
<input type="hidden" name="myTableParent"  id="myTableParent" value="{$myTableParent}" >
<input type="hidden" name="actif"  id="actif" value="1" >
{$field_id_parent}
<section><div class="row">{$field_type_texte}</div></section>
<section><div class="row">{$field_titre}</div></section>
<section><div class="row">{$field_texte}</div></section>
</form>	
<script type="text/javascript" >
jQuery.validator.setDefaults({
	debug: false
});

$(document).ready(function () {
	
	
		$('#btnAppliquer').click(function (event) { 
			event.preventDefault();
			$( "#actionForm" ).val("valider");
			$("#formMaj").submit(); 
		}); 
		
		{if !in_array("ajouter", $actionsPage) || !in_array("appliquer", $actionsPage) }{* si click depuis liste medias *}
			$("#majMedia").hide();
		{/if}
		

	$('.goMaj td').click(function (event) { 
		if (!$(this).hasClass('notGoMaj')) {
			{if in_array("appliquer", $actionsPage)}
				$("#majMedia").show();
				$("#loaderForm").show();
				param="id=" + $(this).parent().attr("id");
				$.ajax({
					type: "GET",
					cache:false,
					url: '{$smarty.const.DOS_CLIENT_ADMIN}pages/ajax_load_texte_itineraire.php',
					data:param,
						success: function(data) {
                          //console.log(data);
							eval(data);
							$("#loaderForm").hide();
						}
				});
			{/if}
		}
	});
	
	
});

$(function() {
		
	$("#formMaj").validate({
		event:'blur',
		rules:	{
			{foreach $allrules as $rules}
				{$rules}
				
			{/foreach}
		},
	
		messages:{
			{foreach $allmessages as $message}
				{$message}
			{/foreach}
		},
							
		submitHandler: function(form){
			$('.btnACacher').hide();
			$('#loaderBtnAction').show();
			$("#loaderForm").show();
			form.submit();
		},
		
		// Do not change code below
		errorPlacement: function(error, element){
			 if (element.attr("type")=="checkbox" || element.attr("type")=="radio" ) {
				 error.insertBefore(element.parent());
			 } else {
				error.insertAfter(element.parent()); 
			 }
			
		},
		groups: {
               
			{$myGroup}
            }
		
	});
	
	{$addClassRules}

	
});

</script>

{/block}
