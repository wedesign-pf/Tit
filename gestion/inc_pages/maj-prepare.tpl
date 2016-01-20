<form action="" method="post" id="formMaj" class="sky-form" enctype="multipart/form-data">
<input type="hidden"  name="actionForm" id="actionForm" value="">
<input type="hidden" name="idCurrent"  id="idCurrent" value="{$idCurrent}" >
<div id="showID">#{$idCurrent}</div>
<div id="contentMaj" class="left col w100 pas">
{block name=content}{/block}
</div><!--contentMaj-->
</form>	
<script type="text/javascript" >
jQuery.validator.setDefaults({
	debug: false
});

$(document).ready(function () {
	
		$('.showFieldFile').click(function (event) {
			event.preventDefault();

			fullfile='{$thisSite->RACINE}' + $("#" + $(this).attr('href')).val();
			ext = getExtension(fullfile,'image');

			{literal}
			if(ext!=undefined && ext!='') { 
				$(this).colorbox({href:fullfile ,transition:'fade',opacity:0.7,loop:false, maxWidth:'95%', maxhheight:'95%'});
			}
			{/literal}
		});
			
			
	// Datepicker’s Today button problem
	var _gotoToday = jQuery.datepicker._gotoToday;
	jQuery.datepicker._gotoToday = function(a){
	    var target = jQuery(a);
	    var inst = this._getInst(target[0]);
	    _gotoToday.call(this, a);
	    jQuery.datepicker._selectDate(a, jQuery.datepicker._formatDate(inst,inst.selectedDay, inst.selectedMonth, inst.selectedYear));
	}
	
	$('#btnValider').click(function (event) { 
		event.preventDefault();
		$( "#actionForm" ).val("valider");
		$("#formMaj").submit();  
	});
	
	$('#btnAppliquer').click(function (event) { 
		event.preventDefault();
		$( "#actionForm" ).val("appliquer");
		$("#formMaj").submit();
	});  
    
    $('#btnAppliquerAndAjout').click(function (event) { 
		event.preventDefault();
		$( "#actionForm" ).val("appliquerAndAJout");
		$("#formMaj").submit();
	});   
	
	$('#btnAnnuler').click(function (event) { 
		event.preventDefault();
		$("#actionForm").val("annuler");
		$("#formMaj")[0].submit();
	});  

	
});



$(function() {
		
	$("#formMaj").validate({
		
		focusInvalid: false,
		invalidHandler: function(form, validator) {
	
			if (!validator.numberOfInvalids())
				return;
	
			$('html, body').animate({
				scrollTop: $(validator.errorList[0].element).offset().top-100
			}, 500);
	
		},
	
		event:'blur',
		{if $myAdmin->LIST_LANG_DATAS|@count >1}	
				ignore: 
		{assign var=sep value=''}
		{foreach $myAdmin->LIST_LANG_DATAS as $clg=>$extlg}
			{if !array_key_exists($clg, $myAdmin->LIST_LANG_CONTROLE)}
				{$sep}".ctrlg_{$clg}"
				{assign var=sep value=','}
			{/if}
		{/foreach}
				,
		{/if}		
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
{block name=javascript}{/block}