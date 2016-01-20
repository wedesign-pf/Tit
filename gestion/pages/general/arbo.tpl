<div id="filtreList" class="line w100  pbs plm prm">
	<form action="" method="post" id="formAddPage" name="formAddPage" class="sky-form">
	<input type="hidden"  name="Filtres" id="Filtres" value="1">
	<fieldset><legend>{$datas_lang.arboAddPage}</legend>
		<section><div class="row">{$field_menu}</div></section>
		<section><div class="row">{$field_newPage}</div></section>
	</fieldset>
	</form>
</div>
<form action="" method="post" id="formMaj" name="formMaj">
	<input type="hidden"  name="newArbo" id="newArbo" value="">
</form>
<script>
function addPage($this){ 
	$( "#formAddPage" ).submit();
}

{assign var=listtemp value='['}
{assign var=sep value=''}
{foreach $listPagesParent as $page}
	{assign var=listtemp value=$listtemp|cat:$sep}
	{assign var=listtemp value=$listtemp|cat:"'menuItem_"}
	{assign var=listtemp value=$listtemp|cat:$page}
	{assign var=listtemp value=$listtemp|cat:"'"}
	{assign var=sep value=','}
{/foreach}
{assign var=listtemp value=$listtemp|cat:"];"}
var listPagesParent = {$listtemp}
{literal}

$().ready(function(){
		
	var ns = $('ol.sortable').nestedSortable({
		forcePlaceholderSize: true,
		handle: 'div',
		helper:	'clone',
		items: 'li',
		opacity: .6,
		placeholder: 'placeholder',
		revert: 250,
		tabSize: 25,
		tolerance: 'pointer',
		toleranceElement: '> div',
		maxLevels: 4,
		isTree: true,
		disableParentChange : false,
		protectRoot:true,
		excludeRoot:false,
		startCollapsed: false,
		isAllowed:function (placeholder, placeholderParent, currentItem) { if(listPagesParent.indexOf( placeholderParent.attr('id')) != -1) { return true } else {return false } }
	});
	
	$('#btnAppliquer').click(function (event) { 
		event.preventDefault();
		hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
		hiered = JSON.stringify( hiered );
		$( "#newArbo" ).val(hiered); 
		$("#formMaj")[0].submit(); 
	});  
	
	$('.disclose').on('click', function() {
		$(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
		$(this).toggleClass('fa-minus').toggleClass('fa-plus');
	});
		
	
	$('.deleteMenu').click(function(){
		if(confirm('{/literal}{$datas_lang.arboDelete}{literal}')) {
			var id = $(this).attr('data-id');
			$('#menuItem_'+id).remove();
		}
	});

			
});			
</script>
{/literal}
<div class="w50 mlm">
<ol class="sortable ui-sortable mjs-nestedSortable-branch mjs-nestedSortable-expanded">
{foreach $arbo_site as $code_menu=>$nivRub}
	<li style="display: list-item;" class="mjs-nestedSortable-leaf" id="menuItem_{$code_menu}">
		<div class="menuDiv nivMenu">
			<i class="disclose fa fa-minus"></i>
			<span data-id="{$code_menu}" class="itemTitle w100">{$listMenus.$code_menu}</span>
			<i data-id="{$code_menu}" class="deleteMenu fa fa-times"></i>
		</div>
	{if $nivRub|@count gt 0  && $nivRub ne ""}
		<ol>
		{foreach $nivRub as $idRub=>$nivsRub}
		<li style="display: list-item;" class="mjs-nestedSortable-leaf" id="menuItem_{$idRub}">
			<div class="menuDiv">
				<i class="disclose fa fa-minus"></i>
				<span data-id="{$idRub}" class="itemTitle w100">{$listPages.$idRub}</span>
				<i data-id="{$idRub}" class="deleteMenu fa fa-times"></i>
			</div>
			{if $nivsRub|@count gt 0 && $nivsRub ne ""}
				<ol>
				{foreach $nivsRub as $idsRub=>$nivssRub}
					<li style="display: list-item;" class="mjs-nestedSortable-leaf" id="menuItem_{$idsRub}">
						<div class="menuDiv">
						<i class="disclose fa fa-minus"></i>
						<span data-id="{$idsRub}" class="itemTitle w100">{$listPages.$idsRub}</span>
						<i data-id="{$idsRub}" class="deleteMenu fa fa-times"></i>
					</div>
					{if $nivssRub|@count gt 0  && $nivssRub ne ""}
						<ol>
						{foreach $nivssRub as $idssRub=>$x}
							<li style="display: list-item;" class="mjs-nestedSortable-leaf" id="menuItem_{$idssRub}">
								<div class="menuDiv">
									<i class="disclose fa fa-minus"></i>
									<span data-id="{$idssRub}" class="itemTitle w100">{$listPages.$idssRub}</span>
									<i data-id="{$idssRub}" class="deleteMenu fa fa-times"></i>
								</div>
							</li>
						{/foreach}
						</ol>
					{/if}
					</li>
				{/foreach}
				</ol>
			{/if}
		</li>
	{/foreach}
		</ol>
		{/if}
	</li>
{/foreach}
</ol>
</div>   