{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}
	
	{assign var="fieldLg" value="`$this->field``$extlg`"}
	
	<div style='position:relative;' class='lang{$extlg}'>

		{if $this->iconeLangue()==true}
		<i class='icon-prepend iconTxt fa'>{$clg}</i>
		{/if}

		{foreach $datasItemByLg.$clg as $indice=>$datasItem}
			<label style='margin-left:{$datasItem.marginLeft}px' class='radio {$this->state_disabled} {$datasItem.stateDisabled} {$this->addClass}'>
			<input  type='radio' name='{$fieldLg}' id='{$datasItem.idField}'  value='{$datasItem.val}' {$datasItem.checked} {$datasItem.disabled} {$this->str_disabled} {$this->str_javascript} ><i></i>
			{$datasItem.text}
			</label>
		{/foreach}	
	
	{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	</div>

{/foreach}	
{/block}