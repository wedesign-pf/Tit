{extends file="{$templateParent}"}
{block name=filtres}
	<div class="section"><div class="left">{$field_F__niveau0}</div><div class="left plm">{$field_F__niveau1}</div></div>
{/block}
{block name=javascript}
<script type="text/javascript" >
$(document).ready(function () {
	$('.action_copier').click(function (event) { 
		
		if($(this).attr("field")=="copier") {
			var id=$(this).parent().parent().attr("id");
							
			var myModal = new jBox('Modal', {
					minHeight: 150,
					minWidth: 400,
					adjustPosition: true,
					title: '{$datas_lang.copieFichiers}',
					draggable: 'title',
					dragOver: true,
					closeOnEsc: true,
					closeButton: 'title',
					overlay: true,
					reposition: true,
					ajax: {
						url: '{$smarty.const.DOS_AJAX_ADMIN}ajax_copie_page.php',
						data: 'id='+id,
						setContent: true,
						reload: true
					}
				});
				 
				myModal.open();
		}
	});
});
</script>
{/block}