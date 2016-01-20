<form action="" method="post" id="formBrowse" style='display:nsone'>
<input type="hidden"  name="field" id="field" value="{$field}">
<input type="hidden"  name="from" id="from" value="{$from}">
<input type="hidden"  name="startFolder" id="startFolder" value="{$startFolder}">
<input type="hidden"  name="extensionsAuthorized" id="extensionsAuthorized" value="{$extensionsAuthorized}">
<input type="hidden"  name="upload" id="upload" value="{$upload}">
<input type="hidden"  name="dimMax" id="dimMax" value="{$dimMax}">
<input type="hidden"  name="uploadOK" id="uploadOK" value="{$uploadOK}">
<input type="hidden"  name="dimThumbs" id="dimThumbs" value="{$dimThumbs}">
<input type="hidden"  name="CKEditor" id="CKEditor" value="{$CKEditor}">
<input type="hidden"  name="CKEditorFuncNum" id="CKEditorFuncNum" value="{$CKEditorFuncNum}">
<input type="hidden"  name="tmfield" id="tmfield" value="{$tmfield}">
<input type="hidden"  name="path" id="path" value="{$path}">
<input type="hidden"  name="order_by" id="order_by" value="{$order_by}">
<input type="hidden"  name="order_dir" id="order_dir" value="{$order_dir}">
<input type="hidden"  name="start" id="start" value="{$start}">
<input type="hidden"  name="limit" id="limit" value="{$limit}">
<input type="hidden"  name="delItem" id="delItem" value="">
<input type="hidden"  name="vignettes" id="vignettes" value="{$vignettes}">
<input type="hidden"  name="displayMode" id="displayMode" value="{$displayMode}">
<input type="hidden"  name="displaySizes" id="displaySizes" value="{$displaySizes}">
<input type="hidden"  name="fileNotUsed" id="fileNotUsed" value="{$fileNotUsed}">
<input type="hidden"  name="search" id="search" value="{$search}">
</form>
<!-- Begin Breadcrumbs -->
<div id="breadcrumbs">
	{if $getLastError}
		<p align="center" style="color:#f00;">{$getLastError}</p>
	{else}
	<ul>
		<li><a href="javascript:changePath('{$racine_start}');"><i class="fa fa-15x fa-home"></i></a></li>
	{foreach $path_items_filtred as $c_path=>$fold}
		<li><a href="javascript:changePath('{$c_path}');">{$fold}</a></li>
	{/foreach}
	</ul>
	{/if}
</div>
<div id="globalAction">
<input  name="searchChars" type="text" id="searchChars" value="{$search}" size="15" maxlength="20" placeholder='Recherche' >
<a href="#" folder="{$c_path}" class="createFolder" alt="{$datas_lang.createFolder}"  title="{$datas_lang.createFolder}"><i class="fa fa-1x fa-plus" ></i><i class="fa fa-1x fa-folder-o" ></i></a>
<a href="#" class="changeDisplaySizes"><i class="fa fa-1x {if $displaySizes eq '1'}fa-minus-square{else}fa-plus-square{/if}" alt="{$datas_lang.changeDisplaySizes}"  title="{$datas_lang.changeDisplaySizes}" ></i></a>
<a href="#" class="changeDisplayMode"><i class="fa fa-1x {if $displayMode eq 'list'}fa-th-large{else}fa-list-ul{/if}" alt="{$datas_lang.changeDisplayMode}"  title="{$datas_lang.changeDisplayMode}" ></i></a>
<a href="#" class="showNotUsed"><i class="fa fa-1x {if $fileNotUsed eq 1}fa-flag-o{else}fa-flag{/if}" alt="{$datas_lang.showNotUsed}"  title="{$datas_lang.showNotUsed}" ></i></a>
<a href="#" class="showVignettes"><i class="fa fa-1x {if $vignettes eq 1}fa-minus-square-o{else}fa-plus-square-o{/if}" alt="{$datas_lang.showVignettes}"  title="{$datas_lang.showVignettes}" ></i></a>
</div>
<!-- End Breadcrumbs -->
<div class="clear"></div>
<div id="main">
{if $getLastItemCount}
	<table border="0" width="800" cellspacing="0">
	<thead>
		<tr>
			<td width="{if $displayMode eq "list"}20{else}{$width_thumbs+10}{/if}px"  >&nbsp;</td>
			<td><a {if $order_by eq "name"}class='order_{$order_dir}'{/if} href="javascript:changeOrder({$getOrderLink_KEY_NAME});">{$datas_lang.browseName}</a></td>
			<td width="15%" align='center'><a {if $order_by eq "date"}class='order_{$order_dir}'{/if} href="javascript:changeOrder({$getOrderLink_KEY_DATE});">{$datas_lang.browseDate}</a></td>
			{if $displaySizes eq "1"}
				<td width="10%" align='center'><span>{$datas_lang.LxH}</span></td>
				<td width="10%" align='center'><a {if $order_by eq "size"}class='order_{$order_dir}'{/if} href="javascript:changeOrder({$getOrderLink_KEY_SIZE});">{$datas_lang.browseSize}</a></td>
			{/if}
			<td width="10%"><span>{$datas_lang.browseActions}</span></td>
		</tr>
	</thead>
	<tbody>
		{foreach $listing_filtred as $xx=>$datas}
			<tr class="{$datas.image_disabled}" >
			{if $displayMode eq "list" || $datas.typefic eq "folder"}
			<td><img src="{$smarty.const.DOS_OUTILS_ADMIN}filelistclass/{$datas.icone}" /></td>
			{else}
			<td><img src="{$thisSite->RACINE}{$datas.real_path}{$datas.KEY_NAME_urlencode}" style="width:{$width_thumbs}px" /></td>
			{/if}
			{if $datas.typefic eq "folder"}
				<td><a href="javascript:changePath('{$datas.path}{$datas.KEY_NAME}/');">{$datas.KEY_NAME_htmlsc}</a></td> 
			{else}
				<td class="fic" {if $datas.image_disabled eq ""} CKEditorFuncNum="{$CKEditorFuncNum}" from="{$from}" tmfield="{$tmfield}"  field="{$field}" file="{$datas.real_path}{$datas.KEY_NAME}">{/if}<span id="item_{$xx}" >{$datas.KEY_NAME_htmlsc}</span></td>
			{/if}
			<td class="date">{$datas.KEY_DATE}</td>
			{if $displaySizes eq "1"}
				<td class="imagesize">{$datas.imagesize}</td>
				<td >{$datas.niceSize}</td>
			{/if}
			<td><a href="javascript:delFile('{$datas.real_path}{$datas.KEY_NAME_urlencode}','{$datas.typefic}');"><i class="fa fa-1x fa-times" alt="{$datas_lang.delete}"  title="{$datas_lang.delete}" ></i></a>
			{if $datas.typefic eq "file"}
				<a href="#" folder="{$datas.real_path}" file="{$datas.KEY_NAME_htmlsc}" class="callEditable">&nbsp;<i  alt="{$datas_lang.rename}"  title="{$datas_lang.rename}" class="fa fa-1x fa-pencil-square-o" ></i></a>
				<a href="{$thisSite->RACINE}{$datas.real_path}{$datas.KEY_NAME_htmlsc}" target="_blank" class="callDownload">&nbsp;<i  alt="{$datas_lang.download}"  title="{$datas_lang.download}" class="fa fa-1x fa-download" ></i></a>
				{if $datas.preview eq 1}
					<a href="{$thisSite->RACINE}{$datas.real_path}{$datas.KEY_NAME_urlencode}" class="callPreview">&nbsp;<i  alt="{$datas_lang.preview}"  title="{$datas_lang.preview}" class="fa fa-1x fa-eye" ></i></a>
				{/if}
			{/if}
			</td>
			</tr>
			{/foreach}
			</tbody>						
			</table>
		<div id="tfoot">
			{if $getLastItemCount gt $limit || $start ne 0}
				<div class="left">{$getPagination}</div>
			{else}
				<div class="left">&nbsp;</div>
			{/if}
			<div class="right">{$start+1} à {$totPagination} de {$getLastItemCount} fichiers</div>
		</div>
		<div class="clear"></div>
	{else}
    	<div style="text-align:center;padding:10px;">{$datas_lang.noFileInFolder}</div>
	{/if}
</div>
{if $uploadOK eq 1}
<div id="blocUpload">
	{$upload_prop.info}
    <div class="mts">
    {include file="uploadifive.tpl"}
    </div>
</div>
{/if}
<script type="text/javascript" >
function reloadBrowse() {
	$( "#formBrowse" ).submit(); 
}

function delFile(delItem,type) {

	if(type=='folder'){
		if(confirm('{$datas_lang.confirmDelFolder}' + delItem)) { 
			$("#delItem").val(delItem);
			reloadBrowse();
		}
	} else {
		if(confirm('{$datas_lang.confirmDelFile}' + delItem)) { 
			$("#delItem").val(delItem);
			reloadBrowse();
		}
	}
 
}


function changePath(path) {
	$("#path").val(path);
	reloadBrowse(); 
}

function changeOrder(order_by, order_dir) {
	$("#order_by").val(order_by);
	$("#order_dir").val(order_dir);
	reloadBrowse(); 
}

function changePagination(start) {
	$("#start").val(start);
	reloadBrowse(); 
}

function switchCLass($this,class1, class2) {
	if ( $this.hasClass(class1) ) {
	$this.removeClass(class1).addClass(class2);
	} else {
		$this.removeClass(class2).addClass(class1);
	}
}

$(document).ready(function () {
	
	$('#searchChars').keypress(function (event) {
		if(event.keyCode == 13) {
			$("#search").val($(this).val());
			reloadBrowse();
		}
	});
	
	$('.showNotUsed').click(function (event) {
		 	event.preventDefault(); 
			switchCLass($(this).children('i'),'fa-flag', 'fa-flag-o');
			if($("#fileNotUsed").val()==1) { $("#fileNotUsed").val(0); } else { $("#fileNotUsed").val(1); };
			reloadBrowse();
	});
	
	$('.changeDisplayMode').click(function (event) {
		 	event.preventDefault(); 
			switchCLass($(this).children('i'),'fa-plus-square', 'fa-minus-square');
			if($("#displayMode").val()=="list") { $("#displayMode").val("thumbs"); } else { $("#displayMode").val("list"); };
			reloadBrowse();
	});
	
	$('.changeDisplaySizes').click(function (event) {
		 	event.preventDefault(); 
			switchCLass($(this).children('i'),'fa-list-ul', 'fa-th-large');
			if($("#displaySizes").val()=="1") { $("#displaySizes").val("0"); } else { $("#displaySizes").val("1"); };
			reloadBrowse();
	});
	
	$('.showVignettes').click(function (event) {
		 	event.preventDefault(); 
			switchCLass($(this).children('i'),'fa-plus-square-o', 'fa-minus-square-o');
			if($("#vignettes").val()==1) { $("#vignettes").val(0); } else { $("#vignettes").val(1); };
			reloadBrowse();
	});

	
	$('.callPreview').click(function (event) {

		 	event.preventDefault(); 

			var image=$(this).attr("href");
						
			var myModal = new jBox('Modal', {
				adjustPosition: false,
				title: '{$datas_lang.preview}',
				draggable: 'title',
				dragOver: true,
				closeOnEsc: true,
				closeButton: 'title',
				overlay: false,
				reposition: false,
				content:'<img style="max-width:500px" src="' + image + '"  />'
			});
			 
			myModal.open();
	});

	
		$('.callEditable').click(function (event) {
		 	event.preventDefault(); 
			
			var folder=$(this).attr("folder");
			var file=$(this).attr("file");
						
			var myModal = new jBox('Modal', {
				minHeight: 150,
				minWidth: 400,
				adjustPosition: true,
				title: '{$datas_lang.browseRenameTitle}',
				draggable: 'title',
				dragOver: true,
				closeOnEsc: true,
				closeButton: 'title',
				overlay: false,
				reposition: true,
				ajax: {
					url: '{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}browse/browse_rename.php',
					data: 'folder='+folder + '&file=' + file,
					setContent: true,
					reload: true
				}
			});
			 
			myModal.open();
	});

  
  $('.createFolder').click(function (event) {
		 	event.preventDefault(); 
			
			var folder=$(this).attr("folder");
						
			var myModal = new jBox('Modal', {
				minHeight: 150,
				minWidth: 400,
				adjustPosition: true,
				title: '{$datas_lang.createFolder}',
				draggable: 'title',
				dragOver: true,
				closeOnEsc: true,
				closeButton: 'title',
				overlay: false,
				reposition: true,
				ajax: {
					url: '{$thisSite->RACINE}{$thisSite->DOS_ADMIN}{$smarty.const.DOS_OUTILS_ADMIN}browse/create_folder.php',
					data: 'folder='+folder,
					setContent: true,
					reload: true
				}
			});
			 
			myModal.open();
	});
  
	$('.fic').click(function (event) { 
		//alert($(this).attr("from"));
		//alert($(this).attr("field"));

		if($(this).attr("from")=="file") {

			var x = $(window.self.top.document).find("#" + $(this).attr("field"));
			x.val($(this).attr("file"));
			parent.$.colorbox.close();
		}
		if($(this).attr("from")=="ck") {
			window.opener.CKEDITOR.tools.callFunction($(this).attr("CKEditorFuncNum"), $(this).attr("file"));
			top.window.close();
		}
		if($(this).attr("from")=="tinymce") {
			parent.document.getElementById($(this).attr("tmfield")).value = $(this).attr("file");
			parent.$.colorbox.close();
		}
	});
	

});
</script> 