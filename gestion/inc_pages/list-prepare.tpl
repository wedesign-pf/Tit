<div id="contentList" class="line w100 pts plm prm">
{block name=infosParent}{$infosParent}{/block}
{if $filtres eq 1 }
<div id="filtreList" class="line w100">
	<form action="" method="post" id="formFiltres" class="sky-form">
	<input type="hidden"  name="Filtres" id="Filtres" value="1">
	<fieldset><legend>{$datas_lang.filtres}</legend>
{block name=filtres}{/block}
	</fieldset>
	</form>
</div>
{/if}
<form action="" method="post" id="formList">
<input type="hidden"  name="actionOutList" id="actionOutList" value="">
<input type="hidden"  name="actionInList" id="actionInList" value="">
<input type="hidden"  name="actionListId" id="actionListId" value="">
<input type="hidden"  name="orderby" id="orderby" value="{$orderby}">
<input type="hidden"  name="start" id="start" value="{$start}">
<input type="hidden"  name="limit" id="limit" value="{$limit}">
<input type="hidden" name="myTableParent"  id="myTableParent" value="{$myTableParent}" >
<input type="hidden" name="id_parent"  id="id_parent" value="{$idParent}" >
<div id="tableList" class="clear w100">
<div class="w100 mtbs">
	{if $maxElements>0}<div id="maxElements" class="left mrs">{$maxElements} {$datas_lang.maxElements}</div>{/if}
	{if in_array("ajouter", $actionsPage) && $typePage ne "medias"  && $typePage ne "produit" && $typePage ne "itineraire" }<div id="btnAjouter" class="left btnAction" >{$datas_lang.ajouter}</div>{/if}
	{foreach $boutons as $bouton}
	{if in_array($bouton.assAction, $actionsPage)}<div class="left btnAction btnExtra" action="{$bouton.action}" target="{$bouton.target}" >{$bouton.label}</div>{/if}
	{/foreach}
	<div id="nbElements" class="right mrs">{$count_datas} {$datas_lang.nbElements}</div>
	<div class="clear"></div>
</div>
{if $listRow|@count > 0}
<TABLE width="100%" id="datasTable" class="{$width_liste} ptvs" cellpadding="0" cellspacing="0" >
	<THEAD>
		<TR>
			{foreach $listCols as $datasCol}
				<TD width="{$datasCol.width}" align="{$datasCol.align}" {if {$datasCol.orderOk} eq 1  } class="orderby" field="{$datasCol.field}" {/if}>{$datasCol.label}{if $datasCol.update > 0} ({$datasCol.update}){/if} </TD>
			{/foreach}
			
			{if in_array("move", $actionsPage)}<TD width="8%" align="center" class="orderby" field="chrono"><i class="icon-append fa fa-15x fa-retweet"></i></TD>{/if}
			{if in_array("dupliquer", $actionsPage)}<TD width="5%" align="center"><i class="icon-append fa fa-15x fa-copy"></TD>{/if}
			{if in_array("supprimer", $actionsPage)}<TD width="5%" align="center"><i id="allDel" class="icon-append fa fa-15x fa-trash-o"></TD>{/if}
		</TR>
	</THEAD>
	<TBODY>
		{foreach $listRow as $keyId=>$datasRow}
			<TR class="goMaj" id="{$keyId}" {if in_array("move", $actionsPage)} data-id="{$datasRow["chrono"]}" {/if}>
				{foreach $listCols as $col=>$datasCol}
					{if $datasCol.update >= "0" } {* affichage case à cocher pour update en ligne *}
						<TD align="{$datasCol.align}" class="notGoMaj {$datasCol.class}">
							{$etat=""}
							{if $datasRow[$datasCol.field] eq 1 } {* case cochée *}
								{$etat="checked"}
							{else}
								{if $datasCol.update eq 0 || $datasCol.countTrue<$datasCol.update } 
									{$etat=""}
								{else}
									{$etat="disabled"}
								{/if}
							{/if}
							<input type="checkbox"  {$etat} class="checkboxUpdate" id="{$datasCol.field}_{$keyId}"  name="{$datasCol.field}"  value="{$keyId}" update="{$datasCol.update}" ><i class="actionInListInProgress fa fa-15x fa-cog fa-spin"></i>
						</TD>
					{else} {* affichage normal *}
						{if $datasCol.action ne "" }
							{if $datasCol.action eq "lightbox" }
								<TD align="{$datasCol.align}" class="notGoMaj {$datasCol.class}"><input class="btnLighBoxList action_{$datasCol.field}" field="{$datasCol.field}" type="radio">{$datasRow[$datasCol.field]}</TD>
							{else}
								<TD align="{$datasCol.align}" class="notGoMaj {$datasCol.class}"><input class="btnActionList action_{$datasCol.field}" field="{$datasCol.field}" action="{$datasCol.action}" type="radio">{$datasRow[$datasCol.field]}</TD>
							{/if}
						{else}
							<TD align="{$datasCol.align}" class="{$datasCol.class}">{$datasRow[$datasCol.field]}</TD>
						{/if}
						
					{/if}
				{/foreach}
				
				{if in_array("move", $actionsPage)}<TD align="center" class="notGoMaj">{$datasRow["arrowsMove"]}</TD>{/if}
				{if in_array("dupliquer", $actionsPage)}<TD align="center" class="notGoMaj"><input type="radio" class="dupliquer" value="{$keyId}" ></TD>{/if}
				{if in_array("supprimer", $actionsPage)}<TD align="center" class="notGoMaj"><input type="checkbox" class="checkboxDel" id="deleteMe{$keyId}"  name="deleteMe{$keyId}"  value="{$keyId}" ></TD>{/if}
			</TR>
		{/foreach}
	</TBODY>

</TABLE>
<div id="footerList">
	<div class="left w33 infos">
		{if $count_datas gt $limit || $start ne 0}{$getPagination}&nbsp;&nbsp;|&nbsp;&nbsp;{/if}
		{$getElmsByPage}
	</div>
	{if $count_datas gt $limit && $limit}<div class="left w33 txtcenter infos">{$start+1} à {$totPagination} de {$count_datas} élements</div>{/if}
	{if in_array("supprimer", $actionsPage)}
		<div class="right">
			{if in_array("supprimer", $actionsPage)}<div id="btnDelete" class="btnAction" onmouseup="{if $alertConfDel ne ""}window.alert('{$alertConfDel}'); {/if} confirme_del();">{$datas_lang.delete}</div>{/if}
		</div>
	{/if}
	<div class="clear"></div>
</div>
</div>
{else}
	{$datas_lang.aucunelements}
{/if}
</form>
{block name=afterList}{/block}
</div><!--contentList-->
<script type="text/javascript" >
jQuery.validator.setDefaults({
	debug: false
});

$(document).ready(function () {
	
	// Datepicker’s Today button problem
	var _gotoToday = jQuery.datepicker._gotoToday;
	jQuery.datepicker._gotoToday = function(a){
	    var target = jQuery(a);
	    var inst = this._getInst(target[0]);
	    _gotoToday.call(this, a);
	    jQuery.datepicker._selectDate(a, jQuery.datepicker._formatDate(inst,inst.selectedDay, inst.selectedMonth, inst.selectedYear));
	}


	// on active ou désactive toutes les cases à cocher de suppression
	$('#allDel').click(function () { 
		$('.checkboxDel').each(function () { this.checked = !this.checked; });
	});
	
	// Pagination
	$('.pagin').click(function (event) { 
		event.preventDefault();
		$("#start").val($(this).attr("href"));
		submitList();
	});
	
	// Elements par page
	$('.elmsByPage').click(function (event) { 
		event.preventDefault();
		$("#limit").val($(this).attr("href"));
		submitList();
	});
	
	// Changement d'order
	$('.orderby').click(function () {
		var orderbyArray = $('#orderby').val().split(" ");
		if(orderbyArray[0]==$(this).attr("field")) {
			if(orderbyArray[1]=="ASC") { var newdir = "DESC"; } else { var newdir = "ASC"; }
		} else {
			var newdir = orderbyArray[1];
		}
		$("#orderby").val($(this).attr("field") + " " + newdir);
		submitList();
	});
		
	// affectation class suivant l'order by
	var orderbyArray = $('#orderby').val().split(" ");
	$( "td[field='" + orderbyArray[0] + "']" ).addClass("order_" + orderbyArray[1])
	
	// on appel la page de mise à jour
	{if $typePage ne "medias" &&  $typePage ne "produit"  && $typePage ne "itineraire"  }
		$('.goMaj td').click(function (event) { 
			if (!$(this).hasClass('notGoMaj')) {
				$("#actionOutList").val("maj");
				$("#actionListId").val($(this).parent().attr("id"));
				submitList();
			}
		});
	{/if}
	
	$('#btnFiltre').click(function (event) { 
		event.preventDefault();
		submitFiltres();
	});
	
	$('#btnAjouter').click(function (event) { 
		$("#actionOutList").val("maj");
		$("#actionListId").val(0);
		submitList();
	});
	
	$('.btnActionList').click(function (event) { 
		if($(this).attr("action")=="inList") {
			$("#actionInList").val($(this).attr("field")); 
		} else {
			$("#actionOutList").val($(this).attr("action"));
			if($(this).attr("action")=="page") {
				$("#myTableParent").val($(this).attr("field"));
			}
		}
		$("#actionListId").val($(this).parent().parent().attr("id"));
		$("#orderby").val("");
		$("#start").val("");
		$("#limit").val("");
		submitList();
	});
	
	$('.btnLighBoxList').click(function (event) { 
		$(this).val(['0']);
		$("#actionListId").val($(this).parent().parent().attr("id"));
	});
	
	$('#btnRetourList').click(function (event) { 
		$("#actionOutList").val("annuler");
		$("#orderby").val("");
		$("#start").val("");
		$("#limit").val("");
		submitList();
	});
	
	$('.btnExtra').click(function (event) { 
        if($(this).attr("target")=="_blank") {
		    window.open($(this).attr("action"));
            
        } else if($(this).attr("target")=="_self") {
           top.location.href=$(this).attr("action") 
           
        } else {
            window.open($(this).attr("action") ,'','menubar=no, status=no, scrollbars=yes, menubar=no, width=10, height=10, top=0,left=0'); 
        }
	});
	
	// on appel l'update 
	$('.checkboxUpdate').click(function (event) { 

		var $this=$(this)
		$this.hide();
		$this.next().show();
		var param="table={$myTable}";
		param+="&field=" + $(this).attr("name");
		param+="&id=" + $(this).attr("value");
		param+="&checked=" + $(this).is(':checked');
		param+="&update=" + $(this).attr("update");
		param+="&where={$clauseWhere}";

		var myName=$(this).attr("name");
		//alert(param);
		$.ajax({
			type: "GET",
			cache:false,
			url: '{$smarty.const.DOS_AJAX_ADMIN}ajax_update_list.php',
			data:param,
				success: function(data) {
					if(data==1) { // on active les cases car on a pas atteint la limite
						$( "input[name='" + myName + "']:not(:checked)" ).removeAttr("disabled");
					} else { // on désactive les cases non cochés
						$( "input[name='" + myName + "']:not(:checked)" ).attr("disabled", true);	
					}
					$this.next().hide();
					$this.show();
				}
		});
	});
	
	// Move Up
	$('.arrowup').click(function (event) { 
		event.preventDefault();
		$("#actionListId").val($(this).parent().parent().attr("id")+">"+$(this).parent().parent().prev().attr("id"));
		$("#actionInList").val("move");
		submitList();
	});
	// Move Down
	$('.arrowdown').click(function (event) { 
		event.preventDefault();
		$("#actionListId").val($(this).parent().parent().attr("id")+">"+$(this).parent().parent().next().attr("id"));
		$("#actionInList").val("move");
		submitList();
	});
	
	$('.dupliquer').click(function (event) { 
		event.preventDefault();
		$("#actionListId").val($(this).parent().parent().attr("id"));
		$("#actionInList").val("dupliquer");
		$("#orderby").val("");
		$("#start").val("");
		$("#limit").val("");
		submitList();
	});
	
});

function confirme_del(){ // suppression d'élements d'une liste
	if(confirm('{$datas_lang.confirmDelete}')) {
		$("#actionInList").val("delete");
		$("#loaderForm").show();
		submitList();
	}
}
</script>
{block name=javascript}{/block}