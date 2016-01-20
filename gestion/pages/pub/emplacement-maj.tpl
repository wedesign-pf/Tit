{extends file="{$templateParent}"}
{block name=content}

	<section><div class="row">{$field_titre}</div></section>
	<section><div class="row">{$field_dimsReference}</div></section>
	<section><div class="row">{$field_largeur}{$field_hauteur}</div></section>
	<script>
function setDims($this){ 
	var v_dimstd=document.getElementById('dimsReference').options[document.getElementById('dimsReference').selectedIndex].value;
	x= v_dimstd.indexOf("x");
	lg=v_dimstd.substring(0,x);
	ht=v_dimstd.substring(x+1,10);
	if (lg!="") { document.getElementById('largeur').value = lg; }
	if (ht!="") { document.getElementById('hauteur').value = ht; }

}
</script>
{/block}