{$this->str_label}
<div class='col rating {$classPlus}'>

{assign var="valueField" value="`$this->getValue('')`"}

{foreach $liste as $indice}
	{assign var="idField" value="`$this->field`_`$indice`"}
	<input type='radio' name='{$this->field}' id='{$idField}' value='{$indice}' {if $valueField == $indice}checked{/if} {$this->str_javascript} {$this->str_disabled}><i></i>
	<label for='{$idField}' class='{$this->addClass} {$this->state_disabled}'><i class='fa fa-star'></i></label>
{/foreach}
{if $this->tooltip!=""}<div class='tooltipInline ptvs'>{$this->tooltip}</div>{/if}
</div>