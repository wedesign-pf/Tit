<ul id="menuP">
{foreach $RUBS as $datasRUB}
  	<li id="rub{$datasRUB.id}" class='col {$datasRUB.classLI}' >
		<a class="{$datasRUB.classA}" data-type='{$datasRUB.page_type}' href="{$datasRUB.lien}"><div class="row"><div class="col tit">{$datasRUB.titre}</div></div><div class="exp">{$datasRUB.explications}</div></a>
		{if $datasRUB.SRUBS|@count gt 0}
			<ul class="sRubs" {if $datasRUB.couleur ne ""}style="background-color:{$datasRUB.couleur}"{/if}>
				{foreach $datasRUB.SRUBS as $datasSRUB}
					<li id="srub{$datasSRUB.id}" class='{$datasSRUB.classLI}' >
						<a  href="{$datasSRUB.lien}" class='{$datasSRUB.classA}' >{$datasSRUB.titre}</a>
						{if $datasSRUB.sRubs|@count gt 0}
							<ul class="ssRubs">
								{foreach $datasSRUB.sRubs as $datasSSRUB}
									<li id="ssrub{$datasSSRUB.id}" class='{$datasSSRUB.classLI}'>
										<a href="{$datasSSRUB.lien}" class='{$datasSSRUB.classA}' ><i class="fa fa-caret-right"></i>{$datasSSRUB.titre}</a>
									</li>
								{/foreach}
							</ul>
						{/if}
					</li>
				{/foreach}
			</ul>
		{/if}
    </li>
{/foreach}
</ul><!--menuP-->