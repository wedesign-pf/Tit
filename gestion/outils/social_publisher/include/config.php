<?php

//Url to your app (no slash at the end)
$GLOBALS['app_url'] = 'http://192.168.28.4/Marco/amaramarama/gestion/outils/social_publisher';

//database access
$GLOBALS['db_host'] = $thisSite->SERVEUR_BDD;
$GLOBALS['db_name'] = $thisSite->NOM_BDD;
$GLOBALS['db_user'] = $thisSite->LOGIN_BDD;
$GLOBALS['db_password'] = $thisSite->MDP_BDD;


//Facebook app settings
$GLOBALS['fb_app_id'] = '846550012104087';
$GLOBALS['fb_app_secret'] = '3b8565fd2238a8cd9e569c9a3b22d4e9';

//Twitter app settings
$GLOBALS['twt_consumer_key'] = '';
$GLOBALS['twt_consumer_secret'] = '';

//Admin user
$GLOBALS['admin_username'] = 'admin';
$GLOBALS['admin_password'] = 'admin';

//Google API key used for the shortner
$GLOBALS['shorten_url'] = 0; //possible values: 0 (disabled), 1 (enabled)
//Optional parameter - you can generate a key on: https://code.google.com/apis/console
$GLOBALS['google_api_key'] = '';

$GLOBALS['demo_mode'] = 0; //possible values: 0, 1

/*
System variables
DO NOT MODIFY
*/

$GLOBALS['db_table']['users'] = 'social_publisher';
$GLOBALS['db_table']['history'] = 'social_publisher_history';

//Fb
$GLOBALS['fb_ypbox_path'] = 'include/library/Fb_box'; //not to be modified
$GLOBALS['fb_scope'] = 'publish_actions,manage_pages';
$GLOBALS['fb_connect_redirect'] = '';
$GLOBALS['fb_logout_redirect'] = '';
$GLOBALS['fb_sdk_js_callback'] = '';
$GLOBALS['fb_sdk_lang'] = '';

?>