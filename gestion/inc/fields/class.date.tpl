{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}

	{assign var="fieldLg" value="`$this->field``$extlg`"}
	{assign var="valueField" value="`$this->getValue($clg)`"}
	
	<section class='col'>
	<input name='{$fieldLg}' id='{$fieldLg}' type='text' value='{$valueField}' style="position:absolute; top:-10000px" >
	<label class='input lang{$extlg} {$this->state_disabled}'>
	{if $this->iconeLangue()==true}<i class='icon-prepend iconTxt fa'>{$clg}</i>{/if}
	<i class='icon-append fa fa-calendar'></i>
	<input class='left ctrlg_{$clg} {$this->addClass}' name='scr_{$fieldLg}' id='scr_{$fieldLg}' type='input' value='{$src_valueLg.$clg}' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} {$this->str_javascript} >
	{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	</label>
	</section>
<script>
$(function() {
	$('#scr_{$fieldLg}').datepicker({
		altField: '#{$fieldLg}',
		altFormat: 'yymmdd',
		dateFormat: '{$this->dateFormat}',
		numberOfMonths: {$this->numberOfMonths},
		showButtonPanel: '{$this->showButtonPanel}',
        closeText: 'Clear', // Text to show for "close" button
            onClose: function () {
                var event = arguments.callee.caller.caller.arguments[0];
                if ($(event.delegateTarget).hasClass('ui-datepicker-close')) {
                    $(this).val(''); $('#{$fieldLg}').val('');
                }
            },
		changeYear: '{$this->changeYear}',
		{if $this->minDate !=""}minDate: '{$this->minDate}',{/if}
		{if $this->maxDate !=""}maxDate: '{$this->maxDate}',{/if}
		{if $this->controleRange !=""}{$this->controleRange}{/if}
		prevText: '<i class=\"fa fa-chevron-left\"></i>',
		nextText: '<i class=\"fa fa-chevron-right\"></i>'
	});
});
</script>	
{/foreach}	
{/block}