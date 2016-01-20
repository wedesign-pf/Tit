<div style="margin-top:100px; padding:20px;">
{if $thisSite->current_lang eq "fr"}
	<h1>OUPS !!!</h1>
	Page inconnue<br><br>
	<a href="{$thisSite->racineWithLang}">
	Cliquez ici pour être redirigé vers la page d'accueil du site
	</a>
{else}
	<h1>OUPS !!!</h1>
	Page not found<br><br>
	<a href="{$thisSite->racineWithLang}">
	Click here to be redirected to the homepage
	</a>
{/if}
<div>{$thisSite->erreur404}</div>
</div>