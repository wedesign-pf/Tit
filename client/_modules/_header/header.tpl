<div id="menuFull"><nav id="navigation" >{$MODULE_menu_principal}</nav></div>
<header>
    
        <div class="container clear">
            <!-- Mobile-Tablet Navigation / Start -->
            <input type="checkbox" id="dropdownHam">
            <div id="menuHam" class="right mrs">
                <label for="dropdownHam" id="btnHam" ><span></span><span></span><span></span></label>
            </div>
            <!-- Mobile-Tablet Navigation / End -->  
             {$MODULE_boutons_rs}
            <a class="insNl right boxIframe mrs pls prs" href="http://eepurl.com/byRDAn"><i><span>Inscrivez-vous à notre </span><b>Newsletter</b></i></a>
                {if $smarty.session.EC_accesOK eq 1 }
                    <a id="conexClient" class="right plm prm" href="{$thisSite->pages.7.page_url}">{$thisSite->pages.7.titre}</a>
                {else}
                    <a id="conexClient" class="right boxAcces plm prm" href="{$thisSite->pages.6.page_url}">{$thisSite->pages.6.titre}</a>
                {/if}
            <div class="clear"></div>
        </div>

       <div class="container clear" style="max-width: 1000px; width: 100%; max-height: 100%;">
           <div style="width:14%">
             <a id="logo" class="showLoader" href="{$thisSite->racineWithLang}{$thisSite->homepage}" title="{$thisSite->homepageTitle}" >
              <img id="logo_img" width="140" style=" height: auto; max-width: 100%;" src="{$thisSite->DOS_CLIENT_FILES}logo.png" alt="{$thisSite->homepageTitle}" />
              </a>
           </div>
       </div>
</header>
<main id="main" class="pas"><div class="container clear" ><div class="pageContent" >111