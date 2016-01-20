<?php

error_reporting(E_ALL ^ E_NOTICE);

function sanitize_string($string) {
	$string = strip_tags($string);
    $string = str_replace("'", "", $string);
	$string = str_replace("\"", "", $string);
    
	$string = utf8_decode($string);
	$string = strtolower($string);
    $string = preg_replace('`\s+`', '-', trim($string));
	$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ?';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-';
    $string=strtr($string,utf8_decode($a), $b);
	$c = "&~#{([|`\^])}$¤£µ*ù%§!:/;,?<>.°''\"";
	$string=strtr($string,utf8_decode($c),"");
	$string=strtr($string,"+","_");
	
	$string=preg_replace('/([-])\1+/', '-', $string);
	$string=preg_replace('/([_])\1+/', '_', $string);
	return utf8_encode($string);
}




use Hazzard\Filepicker\Uploader;
use Hazzard\Filepicker\Http\Event;
use Hazzard\Filepicker\Http\Handler;
use Intervention\Image\ImageManager;
use Hazzard\Config\Repository as Config;
use Symfony\Component\HttpFoundation\Request;

// Include the autoloader.
require '../vendor/autoload.php';

// Create a new uploader instance.
$uploader = new Uploader($config = new Config, new ImageManager);

// Create a new http handler instance.
$handler = new Handler($uploader);

/**
 * Set some configuration options.
 *
 * http://docs.hazzardweb.com/filepicker/1.0/configphp
 */

if ($_SERVER['HTTP_HOST'] == "192.168.28.4" || $_SERVER['HTTP_HOST'] == "localhost") {
   define("SERVERMODE", "local");
} else {
   define("SERVERMODE", "prod");
}

 if (SERVERMODE == "local") { 
    $relatifPath='../../';
} else {
    $relatifPath='../';
}

$pathFile=__DIR__ . $relatifPath  .$_POST['path'];
$pathFileVigs=__DIR__ . $relatifPath  .$_POST['thumbnailsFolders'];
$fileExt=str_replace(",","|",$_POST['fileExt']);
$lVigs=explode(",",$_POST['thumbnails']);

$config['debug'] = true;
$config['upload_dir'] = $pathFile;
$config['mkdir_mode'] = '0775';
$config['max_file_size'] = $_POST['maxSize'];
$config['accept_file_types'] = $fileExt;
$config['php_download'] = true;

$temp = array(
            'auto_orient' => true,
            'crop' => false,
            'max_width' => $_POST['wMax'],
            'max_height' => $_POST['hMax']
        );

$image_versions['']=$temp;

$svig=str_replace("-","",$_POST['svig']);

$iVig=0;
foreach ($lVigs as $dimsVig) {   
    list($wVig,$hVig)=explode("x",$dimsVig); 

    $temp = array(
            'upload_dir' => $pathFileVigs,
            'upload_url' => $pathFileVigs,
            'crop' => false,
            'auto_orient' => true,
            'crop' => false
        );

    if($wVig>0)  $temp['max_width']=$wVig;
    if($hVig>0)  $temp['max_height']=$hVig;
    
    $image_versions[$svig . $iVig]=$temp;
    


    $iVig++;
}  
        
$config['image_versions'] = $image_versions;

//print_r($config);


$config['messages'] = array(
    'no_file' => 'Aucun fichier téléchargé.',
    'max_width' => 'Dépasse la largeur maximum de %d pixels.',
    'min_width' => 'Nécessite une largeur minimale de %d pixels.',
    'max_height' => 'Dépasse la hauteur maximum de %d pixels.',
    'min_height' => 'Nécessite une hauteur minimale de %d pixels.',
    'image_resize' => 'Impossible de redimensionner l\'image (%s).',
    'upload_failed' => 'Imposible de charger le fichier (error %d).',
    'max_file_size' => 'Fichier trop lourd (limit is %d KB).',
    'min_file_size' => 'Fchier trop petit',
    'accept_file_types' => 'Type de fichier interdit',
    'max_number_of_files' => 'Nombre maximum de fichiers atteint',
    'error' => 'Oups! Quelque chose c\'est mal passé',
    'abort' => 'L\'action a été arrêtée',
    '404' => 'Fichier non trouvé',
    '401' => 'Interdit',
);

/**
 * Listen for events.
 *
 * http://docs.hazzardweb.com/filepicker/1.0/handler#events
 */


/**
 * Event fired before the file upload starts.
 */
$handler->on('upload.before', function(Event $e) {
    // gère le renomage si le fichier existe déjà
    $file = $e->getFile();
    $newFileName=sanitize_string($file->getClientOriginalName());
    $e->setFilename($newFileName, false);
});

/**
 * Event fired for a successfully upload.
 */
$handler->on('upload.success', function(Event $e) {

});

/**
 * Called if the upload fails.
 */
$handler->on('upload.fail', function(Event $e) {

});

/**
 * Event fired on file access.
 */
$handler->on('file.get', function(Event $e) {

});

/**
 * Event fired on file download.
 */
$handler->on('file.download', function(Event $e) {

});

/**
 * Event fired on file deletion.
 */
$handler->on('file.delete', function(Event $e) {

});

/**
 * Event fired before the crop starts.
 */
$handler->on('crop.before', function(Event $e) {

});

/**
 * Event fired on crop completion.
 */
$handler->on('crop.after', function(Event $e) {

});

// Handle an incoming HTTP request and send the response.
$handler->handle(Request::createFromGlobals())->send();
?>