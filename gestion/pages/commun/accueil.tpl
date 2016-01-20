{extends file="{$templateParent}"}
{block name=content}
    
    {if $infos ne ""}
    	<fieldset><legend>ERREURS DROITS DOSSIERS</legend>
    	<section>{$infos}</section>
    	</fieldset>
	{/if}
    {if $myAdmin->PRIVILEGE eq 9}
        <div style="margin-left:15px;">
        {if $mod_expires ne "1"}
            <fieldset><legend>AVERTISSEMENT</legend>
            <section>le module <b>Expires de APACHE</b> n'est pas activé</section>
            </fieldset>
        {/if}
    
        <fieldset><legend>ToDoList</legend>
    	<section><div class="row">{$field_todolist}</div></section>
        </fieldset>
	    {foreach $thisSite->LIST_LANG as $lg=>$ligbLg}
		    {if $lg eq $thisSite->LANG_DEF}{$lg=""}{/if}
    		<li><a href="{$thisSite->RACINE}{$this->PREFIXE_LG}{$lg}/sitemap.xml" target="_blank">SiteMap {$ligbLg}</a></li>
	    {/foreach}
	    
	
        <fieldset><legend>CheckList avant Recette > <a href="http://webdevchecklist.com/" target="_blank">webdevchecklist.com</a></legend>
        <div id="checklist">
	    {foreach $checklist as $code=>$checklistItem}
    		<div class="checklistItem">
            <input name="checklist-{$code}" type="checkbox" id="checklist-{$code}" value="{$code}" {if $checklistItem.check eq "1"}checked {/if}>
            &nbsp;&nbsp;&nbsp;{$checklistItem.titre}
            {if $checklistItem.lien ne ""} 
                &nbsp;&nbsp;>&nbsp;<a href={$checklistItem.lien} target="_blank">lien</a>
            {/if}
            </div>
	    {/foreach}
        </div>
	    </fieldset>
	
    </div>
    {/if}


{/block}