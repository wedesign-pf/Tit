<div class="texte row">
	<div class="contenu col {if $sidebar eq "1" }w70 prl {else}w100 pls prm{/if} mbm">
        <h1>{$dataStd.titre}{$h1plus}</h1>
        {if $dataStd.sous_titre ne "" }<h2>{$dataStd.sous_titre}</h2>{/if}
        {$dataStd.texte1}
        {if $dataStd.videos|@count >0}
        <div class="listVideos line ptm">
        <div class="{if $dataStd.videos|@count==1}grid-2{/if}{if $dataStd.videos|@count==2}grid-2{/if}{if $dataStd.videos|@count>2}grid-3{/if}">
          {foreach $dataStd.videos as $x=>$allVideos}
              <div class="video {if $dataStd.videos|@count==1}video1{/if}{if $dataStd.videos|@count==2}video2{/if} mbs">
                  {$allVideos.imgHover}
              </div>
          {/foreach}
        </div>
        </div>
        {/if}
        {if $dataStd.images|@count >0}
        <div class="listImages line mtm">
        <div class="{if $dataStd.images|@count==1}w100 line{/if}{if $dataStd.images|@count==2}grid-2{/if}{if $dataStd.images|@count>2}grid-3{/if}">
          {foreach $dataStd.images as $x=>$allImages}
              <div class="image {if $dataStd.images|@count==1}image1{/if}{if $dataStd.images|@count==2}image2{/if} mbs">
                  {$allImages.imgHover}
              </div>
          {/foreach}
        </div>
        </div>
        {/if}
        {if $dataStd.texte2 ne ""}<div class="mtm">{$dataStd.texte2}</div>{/if}
        {if $blocsContenu ne ""}<div class="mtm">{$blocsContenu}</div>{/if}
        {if $dataStd.tags ne ""}<div class="tags w100 mts"><b>Tags:</b>&nbsp;&nbsp;{$dataStd.tags}</div>{/if}
        {if $dataStd.files|@count>0 || $dataStd.links|@count >0 }
        <div class="filesAndLInks row mtm ">
            {if $dataStd.files|@count>0}
            <div class="listFiles col pam">
              <h6 class="mbs"><b>Documents</b> à consulter</h6>
              {foreach $dataStd.files as $allFiles}
                  <div class="mbvs">
                      <a class="lien" href="download?fic={$allFiles.fichier}" title="{$allFiles.legende}" target="_blank" >
                      <i class="fa fa-file-o mrs"></i>{$allFiles.legende}
                      </a>
                  </div>
              {/foreach}
            </div>
            {/if}
            {if $dataStd.links|@count >0}
            <div class="listLinks col pam">
              <h6 class="mbs"><b>Liens</b> à voir</h6>
              {foreach $dataStd.links as $allLinks}
                  <div class="mbvs">
                      <a class="lien" href="{$allLinks.lien}" title="{$allLinks.legende}" target="{$allLinks.cible}">
                      <i class="fa fa-link mrs"></i>{$allLinks.legende}
                      </a>
                  </div>
              {/foreach}
            </div>
            {/if}
        </div>
        {/if}
</div>
    {if $sidebar eq "1" }
        <div class="sidebar col w30 ">
        <div class="txtSideBar mbs">{$dataStd.texte3}</div>
        {$blocsSidebar}
        </div>
    {/if}
</div>