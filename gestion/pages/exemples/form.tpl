{extends file="{$templateParent}"}
{block name=content}
<style>
input.addClassTest{
  font-size:24px;
  background-color:rgba(255,1,5,1.00);
}
</style>

{$field_Fhidden}
<section><div class="row">{$field_FselectMCols}</div></section>
<section><div class="row">{$field_Finput}</div></section>
<section><div class="row">{$field_Fpassword}</div></section>
<section><div class="row">{$field_Fconfirm_password}</div></section>
<section><div class="row">{$field_Ftextarea}</div></section>
<section><div class="row">{$field_Fradio}</div></section>
<section><div class="row">{$field_Fcheckbox}</div></section>
<section><div class="row">{$field_Fselect}</div></section>
<section><div class="row">{$field_FselectM}</div></section>
<section><div class="row">{$field_Fdate}</div></section>
<section><div class="row">{$field_Fperiode}</div></section>
<section><div class="row">{$field_Frating}</div></section>
<section><div class="row">{$field_Fslider}</div></section>
<section><div class="row">{$field_Feditor}</div></section>
<section><div class="row">{$field_Ffile}</div></section>
<section><div class="row">{$field_FmediaImage}</div><hr></section>
<section><div class="row">{$field_FmediaFile}</div><hr></section>
<section><div class="row">{$field_FmediaLink}</div><hr></section>
<section><div class="row">{$field_FmediaVideo}</div><hr></section>
<script>
function test(xthis) {
	alert(xthis);	
}
</script>
{/block}	

