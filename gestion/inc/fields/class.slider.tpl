{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}
	<div style='position:relative;' class='lang{$extlg}'>
		{assign var="fieldLg" value="`$this->field``$extlg`"}
		{assign var="valueField" value="`$this->getValue($clg)`"}
		
		{if $this->iconeLangue()==true}<i class='icon-prepend iconTxt fa'>{$clg}</i>{/if}
		
		<input type='hidden' name='{$fieldLg}' id='{$fieldLg}' value='{$valueField}'>		
		<div style='{if $this->iconeLangue()==true}margin-left:50px;{/if}' class='row w100' >
			<div class='col w30 sliderMin' style='margin:0; padding:0'>{$this->min}</div>
			<div class='col w40 txtcenter' ><span class='sliderValue' id='sliderValue{$fieldLg}'></span></div>
			<div class='col w30 txtright sliderMax' style='margin:0; padding:0'>{$this->max}</div>
		</div>
		<div style='{if $this->iconeLangue()==true}margin-left:50px;{/if}' class='clear' id='scr_{$fieldLg}' {$this->state_disabled}></div>
		{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	</div>
	<script>
	$('#sliderValue{$fieldLg}').text('{$valueField}');
	{if $this->disabled!=1}
	$(function(){
		$('#scr_{$fieldLg}').slider({
			step: {$this->step},
			min: {$this->min},
			max: {$this->max},
			{if $rangeLg.$clg==1}
				range: true,
				values: [{$valueField}],
			{else}
				value: [{$valueField}],
			{/if}
			slide: function(event, ui){
			{if $rangeLg.$clg==1}
				$('#{$fieldLg}').val(ui.values[0] + ',' + ui.values[1]);
				$('#sliderValue{$fieldLg}').text(ui.values[0] + ',' + ui.values[1]);
			{else}
				$('#{$fieldLg}').val(ui.value);
				$('#sliderValue{$fieldLg}').text(ui.value);
			{/if}
			}
		});
	});
	{/if}
	</script>
{/foreach}

{/block}