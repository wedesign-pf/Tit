<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
<style>
body, table, td {
	font-family: Helvetica, Arial, sans-serif;
	font-size: 12px;
	line-height: 16px;
	overflow: visible;
	font-weight: normal;
	color: #1b2e81;

}
table {
	border:none;

}
td,th {
	border:1px solid lightgray;

}
</style>
</head>
<body>
Ia orana {$__POST.prenom},
<br><br>
Nous vous remercions de l’intérêt que vous portez à nos magasins Carrefour. Vous trouverez ci-dessous un récapitulatif de votre demande d’information faite sur le site de Carrefour.
<br>
Nous nous engageons à vous répondre dans les plus brefs délais.
<br>
<br>
<table border="0" cellpadding="5" cellspacing="0">
  <tbody>
    <tr>
      <th colspan="2" align="left" valign="top" scope="row">DEMANDE</th>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">Objet</th>
      <td align="left" valign="middle">{$__POST['objet']}</td>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">Magasin</th>
      <td align="left" valign="middle">{$__POST['magasin']}</td>
    </tr>
    <!--<tr>
      <th align="left" valign="top" scope="row">Services</th>
      <td align="left" valign="middle">{$__POST['but']}</td>
    </tr>-->
    <tr>
      <th align="left" valign="top" scope="row">Message</th>
      <td align="left" valign="top">{$__POST['message']|nl2br}</td>
    </tr>
    <tr>
      <th colspan="2" align="left" valign="top" scope="row"><br>COORDONNEES</th>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">Civilité</th>
      <td align="left" valign="middle">{$__POST['civilite']}</td>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">Nom</th>
      <td align="left" valign="middle">{$__POST['nom']}</td>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">Prénom</th>
      <td align="left" valign="middle">{$__POST['prenom']}</td>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">N° portable</th>
      <td align="left" valign="middle">{$__POST['portable']}</td>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">Commune</th>
      <td align="left" valign="middle">{$__POST['commune']}</td>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">E-mail</th>
      <td align="left" valign="middle">{$__POST['email']}</td>
    </tr>
    <tr>
      <th align="left" valign="top" scope="row">N° Carte Fidélité</th>
      <td align="left" valign="middle">{$__POST['carte_fi']}</td>
    </tr>
  </tbody>
</table>
    {if $__POST['optin']==1}
    <p><b>J'accepte de recevoir les offres promotionnelles</b></p>
    {/if}

<p>
Merci pour votre confiance et votre fidélité.
<br>
<img src="{$thisSite->RACINE}{$thisSite->DOS_CLIENT}files/logo2.png" />
</p>
</body>
</html>