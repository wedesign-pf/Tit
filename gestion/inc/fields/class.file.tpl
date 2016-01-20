{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}

	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}
	{assign var="paramsBrowse" value="`$this->prepareParamsBrowse($extlg)`"}

	<label class='input input-file lang{$extlg} {$this->state_disabled}' for='{$fieldLg}'>
	{if $this->browse==true}
		<div class='button'>
		<input type='file' name='browse_{$fieldLg}' multiple id='browse_{$fieldLg}' >{$datas_lang.parcourir}
		</div>
		{if $this->iconeLangue()==true}<i class='icon-prepend iconTxt fa'>{$clg}</i>{/if}
		<input class='ctrlg_{$clg} {$this->addClass}' name='{$fieldLg}' id='{$fieldLg}' type='text' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} value='{$valueField}' {$this->str_javascript} >
		{$this->str_tooltip}
		{if $this->showImage==true}<a class='showFieldFile' href='{$fieldLg}'><i class='fa fa-eye fa-15x'></i></a>{/if}
	{/if}
	{if $this->browse==false}
		<div class='button'>
		<input type='file' name='{$fieldLg}' multiple id='{$fieldLg}' onchange='this.parentNode.nextSibling.value = this.value' >{$datas_lang.parcourir}
		</div><input class='ctrlg_{$clg} {$this->addClass}' readlonly name='{$fieldLg}' id='{$fieldLg}' type='text' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} value='{$valueField}' {$this->str_javascript} >
		{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	{/if}
	</label>
	{if $this->browse==true}
<script>
	$(document).ready(function(){
		$('#browse_{$fieldLg}').click(function (event) { 
			event.preventDefault();
			$(this).colorbox({ href:'{$smarty.const.DOS_OUTILS_ADMIN}browse/browse.php?from=file{$paramsBrowse}', iframe:true,transition:'fade',opacity:0.7,loop:false, width:'75%', height:'75%' });
			
		});
	});
</script>	
	{/if}
{/foreach}	
{if $this->upload eq 1 && $this->uploadDirect eq 1}
<div id="blocUpload">
	{$upload_prop.info}
    <div class="mts">
    {include file="../../outils/browse/uploadifive.tpl"}
    </div>
</div>
{/if}
{/block}