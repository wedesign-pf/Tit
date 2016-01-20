{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}
	
	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}
			
	<div style='position:relative;' class='lang{$extlg}'>

		{if $this->iconeLangue()==true}
		<i class='icon-prepend iconTxt fa'>{$clg}</i>
		{/if}
		{if $this->tags==true}
		<i  id="addTag{$fieldLg}" class='icon-prepend fa fa-plus-square fa-2x addTag' ></i>
		<div id="blocAddTag{$fieldLg}" style='display:none; margin-left:{$marginLeft}px'><fieldset>
			{foreach $this->LIST_LANG_EXTENSION_FIELD as $clgT=>$extlgT}
				<section>
				<label class="label" from="newfile">Tag {$clgT}</label>
				<label class="input"><input type="text"  name="newtag_{$this->field}{$extlgT}" id="newtag_{$this->field}{$extlgT}" value=""></label>
				</section>
			{/foreach}
			<div id="btnAddTag{$fieldLg}" class="btnAddTag left btnAction">OK</div><div class="loaderBtn"></div>
			</fieldset>
		</div>
		{/if}
		<input name='{$fieldLg}' id='{$fieldLg}' type='hidden' class='ctrlg_{$clg}' value='{$valueField}' >
		<label style='margin-left:{$marginLeft}px' class='select {$this->state_disabled} {$this->addClass}'>
		<select name='scr_{$fieldLg}' id='scr_{$fieldLg}' multiple='multiple' {$this->str_javascript} {$this->str_disabled}  >
		{foreach $datasItemByLg.$clg as $indice=>$datasItem}
			<option value='{$datasItem.val}' {$datasItem.disabled} {$datasItem.selected} >{$datasItem.text}</option>
		{/foreach}	
		</select>
		</label>
	{if $this->tooltip!=""}<div class='tooltipInline' style='margin-left:{$marginLeft}px'>{$this->tooltip}</div>{/if}
	</div>
<script>
$(function(){
	
	$('#scr_{$fieldLg}').multiSelect({
		selectableHeader: "<div class='custom-header'>{$datas_lang.selectableElements} {if $this->selectAll eq 1 }<a href='#' class='right' id='all_{$fieldLg}'>{$datas_lang.tous}</a>{/if}</div>",
		selectionHeader: "<div class='custom-header'>{$datas_lang.selectedElements}</div>",
		afterSelect: function(value){
			var val = $('#{$fieldLg}').val();
			if(val=="") {
				$('#{$fieldLg}').val(value);	
			} else {
				$('#{$fieldLg}').val(val+","+value);
			}
  		  
  		}
	});

	$('#all_{$fieldLg}').click(function(){
	  $('#scr_{$fieldLg}').multiSelect('select_all');
	  return false;
	});
	
});
</script>
{/foreach}

<script type="text/javascript" >
$(document).ready(function () {
	$('#addTag{$fieldLg}').click(function (event) { 
		$('#blocAddTag{$fieldLg}').slideToggle();
	});

	$('#btnAddTag{$fieldLg}').click(function (event) { 
		var $this=$(this);
		$this.hide();
		$('.loaderBtn').show();
		
		var ajaxData='field={$this->field}';
		{foreach $this->LIST_LANG_EXTENSION_FIELD as $clgT=>$extlgT}
		ajaxData+='&newtag_{$clgT}='+$('#newtag_{$this->field}{$extlgT}').val();
		{/foreach}
		
		$.ajax({
			type: "POST",
			cache:false,
			url: '{$smarty.const.DOS_AJAX_ADMIN}ajax_add_process.php',
			dataType: 'json',
			data: ajaxData,
				success: function(data) {
					$('#blocAddTag{$fieldLg}').slideToggle();
					{foreach $this->LIST_LANG_EXTENSION_FIELD as $clgT=>$extlgT}
					$('#newtag_{$this->field}{$extlgT}').val("");
					{/foreach}
					$this.show();
					$('.loaderBtn').hide();
					//
					if(data.lastId!=0) {
						$('#scr_{$fieldLg}').multiSelect('addOption', { value: data.lastId, text: data.titre, index: 0 });
						$('#scr_{$fieldLg}').multiSelect('select', [data.lastId]);
						
					}
				}
		});
	
	});
});
</script>
{/block}