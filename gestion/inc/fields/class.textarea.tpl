{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}

	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}

	<label class='textarea lang{$extlg} {$this->state_disabled}'>
	{if $this->iconeLangue()==true}<i class='icon-prepend iconTxt fa'>{$clg}</i>{/if}
	{if $this->tooltip!=""}<i class='icon-append fa-question fa'></i>{/if}
	<textarea rows='{$this->rows}' class='ctrlg_{$clg} {$this->addClass}' name='{$fieldLg}' id='{$fieldLg}' type='textarea' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} {$this->str_javascript} >
{$valueField}</textarea>
	{$this->str_tooltip}
	{$this->addCounter({$fieldLg})}
	</label>

{/foreach}	
{/block}