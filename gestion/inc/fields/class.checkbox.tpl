{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}
	
	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}
	
	<div style='position:relative;' class='lang{$extlg}'>

		{if $this->iconeLangue()==true}
		<i class='icon-prepend iconTxt fa'>{$clg}</i>
		{/if}
		
		<input name='{$fieldLg}' id='{$fieldLg}' type='hidden' value='{$valueField}' >

		{foreach $datasItemByLg.$clg as $indice=>$datasItem}
			<label style='margin-left:{$datasItem.marginLeft}px' class='checkbox {$this->state_disabled} {$datasItem.stateDisabled} {$this->addClass}'>
			<input  type='checkbox' name='{$datasItem.idField}' id='{$datasItem.idField}' class='{$fieldLg}' value='{$datasItem.val}' {$datasItem.checked} {$datasItem.disabled} {$this->str_disabled} {$this->str_javascript} ><i></i>
			{$datasItem.text}
			</label>
		{/foreach}	
	
	{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	</div>
<script>
$(function(){
	$('.{$fieldLg}').change(function(e){
		var r='';
		var sep='';
		$('.{$fieldLg}').each(function(i){
			if($(this).attr('checked')) {
				//alert($(this).val());
				r+=sep + $(this).val();
				sep=',';
			}
			$('#{$fieldLg}').val(r);
		});	
	});	
});
</script>
{/foreach}	
{/block}