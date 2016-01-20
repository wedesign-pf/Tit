<div id='majMedia' class='line w100'>
{if $this->insideForm == false}<fieldset><legend>{$this->label}</legend>{/if}
<div class='row pbvs'>{$field_fichier_media}</div>
<div class='row pbvs'>{$field_titre_media}</div>
{if $this->actionDestination != ""}
	<div class='pts'></div><legend>{$datas_lang.destination}</legend>
{/if}
{if $this->actionDestination == "file"}
	<div class='row'>{$field_fichier_destination}</div>
{/if}
{if $this->actionDestination == "link"}
	<div class='row'>{$field_lien_destination}</div>
	<div class='row'>{$field_cible_destination}</div>
{/if}
{if $this->insideForm == false}
	<div class='ptm'><div id='btnAppliquer' name='submitButton'  class='btnAction left btnACacher'>{$datas_lang.valider}</div></div>
	</fieldset>
{/if}
</div><!--majMedia-->
{$fieldMediaField}