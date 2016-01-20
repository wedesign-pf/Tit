<form action="" method="post" id="form1browse" class="sky-form">
<input type="hidden"  name="copier_fichier" id="copier_fichier" value="1">
<input type="hidden"  name="fichier_origine" id="fichier_origine" value="{$fichier_origine}">
<section>
{$datas_lang.racineFichierOrigine}: <b>{$fichier_origine}</b>
</section>
<section>{$field_dossier_destination}</section>
<div class="clear pbs"></div>
<section>
<label class="label" from="newfile">{$datas_lang.browseNewName}</label>
<label class="input"><input type="text"  name="newfile" id="newfile" value=""></label>
</section>
<footer>
<button type="submit" name="submitButton" class="button">OK</button>
</footer>
</form>
<script type="text/javascript" >
{literal}
$(function() {

	$("#form1browse").validate({
		rules:	{
			newfile:{required:1,filename: true,nowhitespace: true}
		},
		
		submitHandler: function(form){
			form.submit();
		},

		errorPlacement: function(error, element){
			error.insertAfter(element.parent());
		}
	});	
});
{/literal}
</script>