{assign var=media value=$params_module} 

{if $media.thumb!="" }
    {if $media.imgLiquid!="" }<div class="{$media.imgLiquid} imgLiquid" style="width: 100%; height:100%;">{* important d'avoir une hauteur absolute avant *}{/if} 
    {if $media.button|@count == 0 && ($media.image!="" || $media.legende!="") }
        <a class="hoverMe boxImage" href="{$media.image}" rel="{$media.rel}" title="{$media.legende}" >
        {assign var=closing value="</a>"}
    {else} 
        <figure class="hoverMe">
        {assign var=closing value="</figure>"}
    {/if}  

    <img src="{$media.thumb}" alt="{$media.legende}" class="hmThumb" />

    <div class="hmContent" >
        {if $media.description != ""  || $media.legende != ""}
        <div class="hmDesc">
        {if $media.description != "" }<h7>{$media.legende}</h7>{$media.description}{else}{$media.legende}{/if}
        </div>
        {/if}
    </div>
    {if $media.description == "" }
        {assign var=hmButtonsVerPos value="posM"}
    {else}
        {assign var=hmButtonsVerPos value="posB"}
    {/if}
    <div class="hmButtons {$hmButtonsVerPos}">
        {if $media.image !="" }
            {if $media.button|@count == 0 }
                <span class="hmBtn fa-stack fa-lg"><i class="fa fa-circle  fa-stack-2x"></i><i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i></span>
            {else}
                <a class="hmBtn boxImage" href="{$media.image}" rel="{$media.rel}" title="{$media.legende}" ><span class="fa-stack fa-lg"><i class="fa fa-circle  fa-stack-2x"></i><i class="fa fa-plus-circle fa-stack-1x fa-inverse"></i></span></a>
             {/if}
        {/if}
        {if $media.button.link !="" }
            <a class="hmBtn" href="{$media.button.link.link}" target="{$media.button.link.target}" ><span class="fa-stack fa-lg"><i class="fa fa-circle  fa-stack-2x"></i><i class="fa {if $media.button.link.btn eq ""}fa-link{else}{$media.button.link.btn}{/if} fa-stack-1x fa-inverse"></i></span></a>
        {/if}
        {if $media.button.video !="" }
            <a class="hmBtn boxVideo" href="{$media.button.video.link}" ><span class="fa-stack fa-lg"><i class="fa fa-circle  fa-stack-2x"></i><i class="fa {if $media.button.video.btn eq ""}fa-play-circle{else}{$media.button.video.btn}{/if} fa-stack-1x fa-inverse"></i></span></a>
        {/if}
        {if $media.button.iframe !="" }
            <a class="hmBtn boxIframe" href="{$media.button.iframe.link}" ><span class="fa-stack fa-lg"><i class="fa fa-circle  fa-stack-2x"></i><i class="fa {if $media.button.iframe.btn eq ""}fa-link{else}{$media.button.iframe.btn}{/if} fa-stack-1x fa-inverse"></i></span></a>
        {/if}
    </div>
    
    {if $media.otherImage|@count > 0 }<div class="hmCountImage">+{$media.otherImage|@count}</div>{/if}

    {$closing}
   {if $media.imgLiquid!="" }</div>{/if}
    {foreach $media.otherImage as $x=>$oImage}
        <a class="hidden boxImage" rel="{$media.rel}" href="{$oImage.image}" title="{$oImage.legende}" ></a>
    {/foreach}  {* otherImage *} 
           
{/if} {* media.thumb!="" *}
