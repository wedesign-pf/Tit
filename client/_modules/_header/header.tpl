{if $fond_header ne ""}
<style>
@media only screen and (min-width: 1024px) {
    #header2 {
        background-image: url({$fond_header});
        background-repeat: repeat-x;
        background-position: left top;
    }
} 

#header2 .container{
    background-image: url({$image_header});
    background-repeat: no-repeat;
    background-size: contain;
}
</style>
{/if}
<header>
    {if $MODULE_marquee ne ""}
    <div id="alerte_produit">
        <div class="container clear ">
            <div class="fl label pls prs"><div class="fl" ><i class=" fa fa-exclamation-circle fa-2x mrs"></i></div><div class="fl">RAPPEL EN COURS</div></div>
            <div id="marquee_alerte_produit">{$MODULE_marquee}</div>
        </div>
    </div>
    {/if}
    {if $MODULE_marquee1 ne ""}
    <div id="alerte_emploi">
        <div class="container clear ">
            <div class="fl label pls prs"><div class="fl" ><i class=" fa fa-bullhorn fa-2x mrs"></i></div><div class="fl">EMPLOIS</div></div>
            <div id="marquee_alerte_emploi">{$MODULE_marquee1}</div>
        </div>
    </div>
    {/if}
    <div id="header1">
        <div class="container clear">
            <a id="logoscrollToFixed" class="showLoader mls" href="{$thisSite->racineWithLang}{$thisSite->homepage}" title="{$thisSite->homepageTitle}" >
              <img src="{$thisSite->DOS_CLIENT_FILES}logoscrollToFixed.png" alt="{$thisSite->homepageTitle}" />
              </a>
            <!-- Mobile-Tablet Navigation / Start -->
            <input type="checkbox" id="dropdownHam">
            <div id="menuHam" class="right mrs">
                <label for="dropdownHam" id="btnHam" ><i class="fa fa-2x fa-bars"></i></label>
            </div>
            <!-- Mobile-Tablet Navigation / End -->  
             {$MODULE_boutons_rs}
            <a class="insNl right boxIframe mrs pls prs" href="http://eepurl.com/byRDAn"><i><span>Inscrivez-vous à notre </span><b>Newsletter</b></i></a>
            {if $thisSite->SERVER eq "local" }
                {if $smarty.session.EC_accesOK eq 1 }
                    <a id="conexClient" class="right plm prm" href="{$thisSite->pages.7.page_url}">{$thisSite->pages.7.titre}</a>
                {else}
                    <a id="conexClient" class="right boxAcces plm prm" href="{$thisSite->pages.6.page_url}">{$thisSite->pages.6.titre}</a>
                {/if}
            {/if}
            <div class="clear"></div>
        </div>
    </div>
    <div id="header2">
       <div class="container clear" style="max-width: 1000px; width: 100%; max-height: 100%;">
           <div style="width:14%">
             <a id="logo" class="showLoader" href="{$thisSite->racineWithLang}{$thisSite->homepage}" title="{$thisSite->homepageTitle}" >
              <img id="logo_img" width="140" style=" height: auto; max-width: 100%;" src="{$thisSite->DOS_CLIENT_FILES}logo.png" alt="{$thisSite->homepageTitle}" />
              </a>
           </div>
       </div>
    </div>
    <div id="header3">
		<nav id="navigation" class="container" >{$MODULE_menu_principal}</nav>
	</div>
</header>
<main id="main" class="pas"><div class="container clear" ><div class="pageContent {if $thisSite->current_rub ne 10}MorepageContentMargin{/if}" >