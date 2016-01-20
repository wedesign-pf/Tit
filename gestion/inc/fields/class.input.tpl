{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}

	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}

	<label class='input lang{$extlg} {$this->state_disabled}'>
	{if $this->iconeLangue()==true}<i class='icon-prepend iconTxt fa'>{$clg}</i>{/if}
	{if $this->readonly==false}
		{if $this->tooltip!=""}<i class='icon-append fa-question fa'></i>{/if}
		<input {$this->str_autocomplete} class='ctrlg_{$clg} {$this->addClass}' name='{$fieldLg}' id='{$fieldLg}' type='text' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} value="{$valueField}" {$this->str_javascript} >
		{$this->str_tooltip}
		{$this->addCounter({$fieldLg})}
	{else}
		<label class='label col'><b>{$valueField}</b></label>
		<input name='{$fieldLg}' id='{$fieldLg}' type='hidden' value="{$valueField}"  >
	{/if}
	</label>

{/foreach}	
{/block}