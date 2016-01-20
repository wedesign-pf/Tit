<div id='majMedia' class='line w100'>
{if $this->insideForm == false}<fieldset><legend>{$this->label}</legend>{/if}
<div class='row pbvs'>{$field_fichier_media}</div>
<div class='row pbvs'>{$field_titre_media}</div>
{if $this->insideForm == false}
	<div class='ptm'><div id='btnAppliquer' name='submitButton'  class='btnAction left btnACacher'>{$datas_lang.valider}</div></div>
	</fieldset>
{/if}
</div><!--majMedia-->
{$fieldMediaField}