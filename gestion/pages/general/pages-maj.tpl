{extends file="{$templateParent}"}
{block name=content}
{$field_article_tableId}
	<section class="superAdmin"><div class="row">{$field_page_type}</div></section>
	<section class="Cactif"><div class="row">{$field_actif}</div></section>
    <section class="Ctitre"><div class="row">{$field_titre}</div></section>
    <section class="Ctitre"><div class="row">{$field_explications}</div></section>
    <section class="Ctitre"><div class="row">{$field_couleur}</div></section>
	<section class="Cpage_titre"><div class="row">{$field_page_titre}</div></section>
	<section class="Cpage_url"><div class="row">{$field_page_url}</div></section>
	<div class="Cpage_image">{$field_page_image}</div>
	{if $myAdmin->PRIVILEGE eq 9}<fieldset class="Cconfig">{/if}
        <section class="superAdmin"><div class="row">{$field_super_admin_only}</div></section>
        <section class="superAdmin Cpage_recherche"><div class="row">{$field_page_recherche}</div></section>
		<section class="superAdmin Cpage_php"><div class="row">{$field_page_php}</div></section>
		<section class="superAdmin Cpage_tpl"><div class="row">{$field_page_tpl}</div></section>
		{*<section class="superAdmin Cpage_parent"><div class="row">{$field_page_parent}</div></section>*}
		<section class="superAdmin Cshow_sousmenu"><div class="row">{$field_show_sousmenu}</div></section>
		<section class="superAdmin Cshow_in_arbo"><div class="row">{$field_show_in_arbo}</div></section>
        <section class="superAdmin Cadd_menu"><div class="row">{$field_add_menu}</div></section>
	{if $myAdmin->PRIVILEGE eq 9}</fieldset>{/if}
	<fieldset class="Cpage_tag"><legend>META TAGS</legend>
		<section><div class="row">{$field_page_tag_title}</div></section>
		<section><div class="row">{$field_page_tag_keywords}</div></section>
		<section><div class="row">{$field_page_tag_description}</div></section>
		<section><div class="row">{$field_page_tag_robots}</div></section>
		<section><div class="row">{$field_page_sitemap_changefreq}</div></section>
	</fieldset>
{/block}
{block name=javascript}
<script type="text/javascript" >

function change_in_arbo($this) {
    if($('input[name=show_in_arbo]:checked').val()=="0" ){
        $( "#add_menu_0" ).prop( "checked", true );
    }
}

function change_add_menu($this) {
    if($('input[name=add_menu]:checked').val()!="0" ){
        $( "#show_in_arbo_0" ).prop( "checked", true );
    } 
}

hideByType("init")
	
function hideByType($this) {
	$(".Ctitre").show();
	$(".Cpage_titre").show();
	$(".Cpage_url").show();
	$(".Cactif").show();	
	$(".Cpage_recherche").show();	
    $(".Cpage_php").show();	
    $(".Cpage_tpl").show();	 
	$(".Cpage_image").show();
	$(".Cconfig").show();	
	$(".Cpage_parent").show();	
	$(".Cshow_sousmenu").show();	
	$(".Cshow_in_arbo").show();	
	$(".Cpage_tag").show();	
    $(".Cadd_menu").show();	

	if($("#page_type option:selected").val()=="ajax" ){ hideAjax($this); }
	if($("#page_type option:selected").val()=="anchor" ){ hideAnchor($this); }
	if($("#page_type option:selected").val()=="empty" ){ hideEmpty($this); }
	if($("#page_type option:selected").val()=="iframe" ){ hideIframe($this); }
	if($("#page_type option:selected").val()=="lightbox" ){ hideLightbox($this); }
    if($("#page_type option:selected").val()=="nolink" ){ hideNolink($this); }
    if($("#page_type option:selected").val()=="firstSrub" ){ hideFirstSrub($this); }
}


function hideAjax($this) {
	$(".Cpage_titre").hide();	
	$(".Cactif").hide();	
	$(".Cpage_recherche").hide();	 
	$(".Cpage_image").hide();	
	$(".Cpage_parent").hide();	
	$(".Cshow_sousmenu").hide();	
	$(".Cshow_in_arbo").hide();	
	$(".Cpage_tag").hide();	
	
	if($this!="init") {
		$("#page_recherche_1").attr('checked','checked');
		$("#page_parent_1").attr('checked','checked');
		$("#show_sousmenu_1").attr('checked','checked');
		$("#show_in_arbo_1").attr('checked','checked');
	}
}

function hideAnchor($this) {
	$(".Cpage_recherche").hide();	
	$(".Cpage_tag").hide();	
	
	if($this!="init") {
		$("#page_recherche_1").attr('checked','checked');
		$("#page_parent_1").attr('checked','checked');
		$("#show_sousmenu_1").attr('checked','checked');
		$("#show_in_arbo_1").attr('checked','checked');
	}
}

function hideEmpty($this) {
	$(".Cpage_titre").hide();	
	$(".Cpage_recherche").hide();	 
	$(".Cpage_image").hide();	
	$(".Cpage_parent").hide();	
	$(".Cshow_sousmenu").hide();	
	$(".Cshow_in_arbo").hide();	
	$(".Cpage_tag").hide();	
	
	if($this!="init") {
		$("#page_recherche_1").attr('checked','checked');
		$("#page_parent_1").attr('checked','checked');
		$("#show_sousmenu_1").attr('checked','checked');
		$("#show_in_arbo_1").attr('checked','checked');
	}
}

function hideIframe($this) {
	$(".Cpage_recherche").hide();	
	$(".Cpage_tag").hide();	
	
	if($this!="init") {
		$("#page_recherche_1").attr('checked','checked');
		$("#page_parent_1").attr('checked','checked');
		$("#show_sousmenu_1").attr('checked','checked');
		$("#show_in_arbo_1").attr('checked','checked');
	}
}

function hideLightbox($this) {
	$(".Cpage_recherche").hide();	
	$(".Cpage_tag").hide();	
	
	if($this!="init") {
		$("#page_recherche_1").attr('checked','checked');
		$("#page_parent_1").attr('checked','checked');
		$("#show_sousmenu_1").attr('checked','checked');
		$("#show_in_arbo_1").attr('checked','checked');
	}
}

function hideNolink($this) {
	$(".Cpage_titre").hide();	
	$(".Cpage_recherche").hide();	 
	$(".Cpage_image").hide();	
    $(".Cpage_url").hide();
	$(".Cpage_tag").hide();	
	
	if($this!="init") {
		$("#page_recherche_1").attr('checked','checked');
		$("#page_parent_0").attr('checked','checked');
		$("#show_sousmenu_0").attr('checked','checked');
		$("#show_in_arbo_0").attr('checked','checked');
	}
}

function hideFirstSrub($this) {
	$(".Cpage_titre").hide();	
	$(".Cpage_recherche").hide();	 
	$(".Cpage_image").hide();	
	$(".Cpage_tag").hide();	
	$(".Cpage_php").hide();	
    $(".Cpage_tpl").hide();	 
    
	if($this!="init") {
		$("#page_recherche_1").attr('checked','checked');
		$("#page_parent_0").attr('checked','checked');
		$("#show_sousmenu_0").attr('checked','');
		$("#show_in_arbo_0").attr('checked','checked');
	}
}

function initScriptsAndUrl($this) {

	{if $idCurrent ne 0 } return false; // si update on ne fait rien {/if}

	var valok =sanitize_string($this.val());
	var valok2 = valok+".php";
	var valok3 = valok+".tpl";
	var extLg = $this.attr('id').substr($this.attr('id').length - 3);
	var idx = lang_extension.indexOf(extLg);

	if(idx != -1) {
		if($('#page_url'+extLg).val()=="") { $('#page_url'+extLg).val(valok); };
	}
	if($('#page_php').val()=="") { $('#page_php').val(valok2); };
	if($('#page_tpl').val()=="") { $('#page_tpl').val(valok3); };

}

$(document).ready(function () {
{foreach $myAdmin->LIST_LANG_DATAS as $clg=>$extlg}
	$('#titre_{$clg}').change(function () { 
		initScriptsAndUrl($(this));
	});
{/foreach} 
});
</script>
{/block}

