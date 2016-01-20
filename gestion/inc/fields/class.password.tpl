{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}

	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}

	<label class='input lang{$extlg} {$this->state_disabled}'>
	<i class='icon-prepend fa-lock fa'></i>
	{if $this->tooltip!=""}<i class='icon-append fa-question fa'></i>{/if}
	<input autocomplete='off' class='ctrlg_{$clg} {$this->addClass}' name='{$fieldLg}' id='{$fieldLg}' type='password' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} value='{$valueField}' {$this->str_javascript} >
	{$this->str_tooltip}
	{$this->addCounter({$fieldLg})}
	</label>

{/foreach}	
{/block}