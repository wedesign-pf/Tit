<form action="" method="post" id="form1browse" class="sky-form">
<input type="hidden"  name="racineaddfolder" id="racineaddfolder" value="{$folder}">
<section>
<label class="label" from="newfile">{$datas_lang.browseNewFolder}</label>
<label class="input"><input type="text"  name="addfolder" id="addfolder" value=""></label>
</section>
<footer>
<button type="submit" name="submitButton" class="button">OK</button>
</footer>
</form>
<link href="{$smarty.const.DOS_SKIN_ADMIN}sky-forms.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.form.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.validate.addMethod.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/additional-methods.min.js"></script>
{if $myAdmin->LANG_ADMIN eq "fr"}<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/lang/messages_fr.js"></script>{/if}
{if $myAdmin->LANG_ADMIN eq "fr"}<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/lang/datepicker-fr.js"></script>{/if}

<script type="text/javascript" >
{literal}
$(function() {

	$("#form1browse").validate({
		event:'blur',
		rules:	{
			addfolder:{required:1,filename: true}
		},
		
		submitHandler: function(form){
			form.submit();
		},
		
		// Do not change code below
		errorPlacement: function(error, element){
			error.insertAfter(element.parent());
		}
	});	
});
{/literal}
</script>