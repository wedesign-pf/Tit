<?php
function testserver() {
echo '<div style="margin: 10px;">';
echo '<div style="width: 580px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
echo '<span style="float: left;width: 300px;">Serveur web</span> ';
echo $_SERVER["SERVER_SOFTWARE"];
echo '<div style="clear:both;"><!-- --></div></div>';
echo '<p style="color: #444444; font-size: 130%;">GD ';

if (function_exists("gd_info")) {

	echo '<span style="color: #00AA00; font-weight: bold;">est installé</span> sur votre serveur!</p>';

	$gd = gd_info();
        echo "<ul>";
	foreach ($gd as $k => $v) {

		echo '<li><div style="width: 380px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
		echo '<span style="float: left;width: 300px;">' . $k . '</span> ';

		if ($v)
			echo '<span style="color: #00AA00; font-weight: bold;">Oui</span>';
		else
			echo '<span style="color: #FF6600; font-weight: bold;">Non</span>';

		echo '<div style="clear:both;"><!-- --></div></div></li>';
	}
echo "</ul>";
} else {

	echo '<span style="color: #EE0000; font-weight: bold;">n\'est pas installé</span> sur votre serveur!</p>';
return 'GD Library n\'est pas installé sur votre système';
}

echo '<div style="width: 380px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
echo '<span style="float: left;width: 300px;">Version PHP</span> ';
if (substr(str_replace('.','',phpversion()),0,5) >= 500){
echo '<span style="color: #00AA00; font-weight: bold;"> '.substr(phpversion(),0,5).' </span>';
} else {
echo '<span style="color: #EE0000; font-weight: bold;"> '.substr(phpversion(),0,5).' </span>';
return 'Votre version php est ancienne, le système risque de rencontrer des problèmes';
}
echo '<div style="clear:both;"><!-- --></div></div>';

echo '<div style="width: 380px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
echo '<span style="float: left;width: 300px;">Fonction file</span> ';
if (function_exists("file")){
echo '<span style="color: #00AA00; font-weight: bold;"> Oui </span>';
} else {
echo '<span style="color: #EE0000; font-weight: bold;"> Non </span>';
return 'La fonction file est désactivée ! veuillez contacter votre hébergeur';
}
echo '<div style="clear:both;"><!-- --></div></div>';

echo '<div style="width: 380px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
echo '<span style="float: left;width: 300px;">Url_fopen</span> ';
if (ini_get('allow_url_fopen')){
echo '<span style="color: #00AA00; font-weight: bold;"> Oui </span>';
} else {
echo '<span style="color: #EE0000; font-weight: bold;"> Non </span>';
return 'Le mode allow_url_fopen est OFF !';
}
echo '<div style="clear:both;"><!-- --></div></div>';

echo '<div style="width: 380px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
echo '<span style="float: left;width: 300px;">Fonction fmod</span> ';
if (function_exists("fmod")){
echo '<span style="color: #00AA00; font-weight: bold;"> Oui </span>';
} else {
echo '<span style="color: #EE0000; font-weight: bold;"> Non </span>';
return 'la fonction fmod n\'est pas activé !';
}
echo '<div style="clear:both;"><!-- --></div></div>';

echo '<div style="width: 380px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
echo '<span style="float: left;width: 300px;">REGISTER_GLOBALS</span> ';
if (!ini_get('register_globals')) {
    echo '<span style="color: #00AA00; font-weight: bold;"> Non </span>';
}else{
    echo '<span style="color: #EE0000; font-weight: bold;"> Oui </span>';
return 'Veuillez désactiver le register_globals';
	}
echo '<div style="clear:both;"><!-- --></div></div>';
echo '<div style="width: 380px; border-bottom: 1px solid #DDDDDD; padding: 2px;">';
echo '<span style="float: left;width: 300px;">SAFE_MODE</span> ';
if (!ini_get('safe_mode')) {
    echo '<span style="color: #00AA00; font-weight: bold;"> Non </span>';
} else {
    echo '<span style="color: #EE0000; font-weight: bold;"> Oui </span>';
return 'Veuillez désactiver le safe_mode';
	}
echo '<div style="clear:both;"><!-- --></div></div>';

echo '</div>';
return 'ok';
}

echo '[Test du serveur]';
$rep = testserver();
if ($rep == 'ok')
echo '<p><b> Le site fonctionnerait parfaitement sur votre serveur [à condition que votre version Mysql est supérieur ou égal à la version 5.0]! connectez vous à votre PHPMYADMIN et executez la requête suivante : <b>SELECT VERSION();</b></p>';
else
echo '<p><b>PROBLEME, LE SITE NE PEUT PAS FONCTIONNER CAR: '.$rep.'</b></p>';

?>
