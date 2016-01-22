{extends file="{$this->pathTemplate}{$this->pathTemplate}{$this->template}"}
{block name=field}
{foreach $this->list_lang as $clg=>$extlg}
	
	{assign var="valueField" value="`$this->getValue($clg)`"}
	{assign var="fieldLg" value="`$this->field``$extlg`"}
	{assign var="paramsBrowse" value="`$this->prepareParamsBrowse($extlg)`"}

	
	<label class='input lang{$extlg} {$this->state_disabled}'>
	{if $this->iconeLangue()==true}<i style='margin-right:-30px' class='icon-append iconTxt fa'>{$clg}</i>{/if}
	<textarea type="TM" class='ctrlg_{$clg} {$this->addClass}' name='{$fieldLg}' id='{$fieldLg}' {$this->str_variablesAuthorized} {$this->str_placeholder} {$this->str_disabled} {$this->str_javascript} >
	
	{$valueField}
	</textarea>
	{if $this->tooltip!=""}<div class='tooltipInline'>{$this->tooltip}</div>{/if}
	</label>
<script>
$(document).ready(function () {
	
	tinymce.init({
		selector: "textarea#{$fieldLg}",
		language : '{$language}',
		theme: "modern",
		body_id: "bodyEditor",
		menubar: true, {* //obligatoire pour l'option TABLE *}
		forced_root_block : false, {* // <p>true ou <br>false sur Enter  *}
		keep_styles: false,
		protect: [
			/\<\/?(if|endif)\>/g, // Protect <if> & </endif>
			/\<xsl\:[^>]+\>/g, // Protect <xsl:...>
			/<\?php.*?\?>/g // Protect php code
		],
		width: '100%',
		{if $this->height ne "" && $this->height ne "0"}
		height: {$this->height},
		{else}
		{assign var="autoresize" value="autoresize"}
		{/if}
		{foreach $toolbar as $x=>$tb}
		toolbar{$x}: "{$tb}", 
		{/foreach}
		image_advtab: true,
		{include file="{$smarty.const.DOS_CLIENT_ADMIN}tmtemplates.tpl"}
		{include file="{$smarty.const.DOS_CLIENT_ADMIN}tmstyles.tpl"}
		style_formats_merge: false,
		preview_styles: false,
		readonly : {if $this->disabled==true}1{else}0{/if}, {* // http://stackoverflow.com/questions/13881812/make-readonly-disable-tinymce-textarea *}
		importcss_append: true,
		importcss_selector_filter: ".aucune",
		content_css: "client/skins/defaut/base.css,client/skins/defaut/style.css", // "path/myfile.css?" + new Date().getTime(),
		document_base_url: "{$thisSite->RACINE}",
		file_browser_callback: function(field_name, url, type, win) { 
			jQuery.colorbox({ href:'{$smarty.const.DOS_OUTILS_ADMIN}browse/browse.php?from=tinymce&tmfield='+field_name+'{$paramsBrowse}', iframe:true,transition:'fade',opacity:0.7,loop:false, width:'75%', height:'75%' });
		},
		setup: function(editor) {
    	    editor.on('focus', function(e) {
        	   have_focus('{$fieldLg}')
			});
			editor.on('blur', function(e) {
        	   loose_focus('{$fieldLg}')
			});
	    },
		plugins: [
			 "{$autoresize} importcss link autolink paste emoticons image charmap hr lists preview  anchor visualblocks code nonbreaking table template textcolor contextmenu",
	   ]
	 });
	
	
	{*
     // PLUGIN email media advlist pagebreak spellchecker searchreplace wordcount visualchars fullscreen insertdatetime media save directionality colorpicker wordcount

	 //http://www.tinymce.com/wiki.php/Configuration:entity_encoding
	 //http://www.tinymce.com/wiki.php/Plugin:importcss
	 //http://www.tinymce.com/wiki.php/Configuration:file_browser_callback
	 //http://www.tinymce.com/wiki.php/Configuration:document_base_url
	 *}

});
</script>
{/foreach}	

{/block}