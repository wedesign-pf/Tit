<ul id="menuB">
{foreach $RUBSBas as $datasRUB}
    <li id="rub{$datasRUB.id}"  class="{$datasRUB.classLI}" >
  	<a href="{$datasRUB.lien}" class="{$datasRUB.classA}" >{$datasRUB.titre}</a>
    </li>
{/foreach}
</ul><!--menuB-->