<?php 
$style="dark"; // light ou dark

if($thisSite->current_lang=="fr") {
    $policyText="En savoir plus";
    $text="En poursuivant votre navigation sur ce site, vous acceptez l&acute;utilisation des cookies qui nous permettent de vous proposer des services et une offre adapt&eacute;s &agrave; vos centres d&acute;int&eacute;r&ecirc;ts.";
    $btnText="OK";
    $link=$thisSite->DOS_CLIENT . "_modules/_cookies_accept/cookies_fr.php";
} else {
    $policyText="Privacy policy";
    $text="We use cookies to ensure you get the best experience on our website, if you continue to browse you&acute;ll be acconsent with our";
    $btnText="OK"; 
    $link=$thisSite->DOS_CLIENT . "_modules/_cookies_accept/cookies_en.php";
}

addStructure("PAGE_doc_ready","$(document).herbyCookie({
                        style: '" . $style . "',
                        policyText: '" . $policyText . "',
                        text: '" . $text . "',
                        btnText: '" . $btnText . "',                        
                        link: '" . $link . "',
                        remove: false
                    });" . "\n\n");

?>