{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}

{foreach $this->list_lang as $clg=>$extlg}
	
	{if $clg==""}{assign var="clgCK" value="`{$myAdmin->LANG_DATAS}`"}{else}{assign var="clgCK" value="`$clg`"}{/if} 
	
	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}
	{assign var="paramsBrowse" value="`$this->prepareParamsBrowse($extlg)`"}

	
	<label class='input lang{$extlg} {$this->state_disabled}'>
	{if $this->iconeLangue()==true}<i style='margin-right:-30px' class='icon-append iconTxt fa'>{$clg}</i>{/if}
	<textarea type="CK" class='ctrlg_{$clg} {$this->addClass}' name='{$fieldLg}' id='{$fieldLg}' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} {$this->str_javascript} >
	{$valueField}
	</textarea>
	{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	</label>
<script>
$(document).ready(function () {
	CKi_{$fieldLg} = CKEDITOR.replace( '{$fieldLg}', {
		baseHref: '{$thisSite->RACINE}',	
		resize_enabled: true,		
		entities: true,
		contentsCss: '{$thisSite->RACINE}{$thisSite->DOS_CLIENT_SKIN}defaut/base.css',		
		defaultLanguage: '{$clgCK}',		
		contentsLanguage: '{$clgCK}',	
		enterMode : CKEDITOR.ENTER_BR,	
		shiftEnterMode : CKEDITOR.ENTER_P,	
		filebrowserBrowseUrl : '{$smarty.const.DOS_OUTILS_ADMIN}browse/browse.php?from=ck{$paramsBrowse}',	
		templates_replaceContent : false,
		templates_files : ['{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_CLIENT_ADMIN}cktemplates.js'],
		stylesSet : 'styles:{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_CLIENT_ADMIN}ckstyles.js',	
		toolbarCanCollapse : false,
		bodyId : 'bodyEditor',
		height: {$this->height},
		toolbar: '{$this->toolbar}'
	});

	CKi_{$fieldLg}.on('focus', function() { have_focus('CKi_{$fieldLg}')})
	CKi_{$fieldLg}.on('blur', function() { loose_focus('CKi_{$fieldLg}')})
});
</script>
{/foreach}	
{/block}