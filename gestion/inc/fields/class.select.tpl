{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}
	
	{assign var="fieldLg" value="`$this->field``$extlg`"}
	
	<div style='position:relative;' class='lang{$extlg}'>

		{if $this->iconeLangue()==true}
		<i class='icon-prepend iconTxt fa'>{$clg}</i>
		{/if}
		
		<label style='margin-left:{$marginLeft}px' class='select {$this->state_disabled} {$this->addClass}'>
		<select class='ctrlg_{$clg}' name='{$fieldLg}' id='{$fieldLg}' {$this->str_javascript} {$this->str_placeholder} {$this->str_disabled} >
		{foreach $datasItemByLg.$clg as $indice=>$datasItem}
			<option value='{$datasItem.val}' {$datasItem.disabled} {$datasItem.selected} >{$datasItem.text}</option>
		{/foreach}
		</select><i></i>	
		</label>
	
	{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	</div>

{/foreach}	
{/block}