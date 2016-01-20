<?php
/*
UploadiFive
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
*/

error_reporting(E_ALL ^ E_NOTICE);
if (session_id() == "") session_start(); 

require_once("_fonctions.php");

$uploadDir = $_POST["path"]; 
$extensions = explode(",",$_POST["exts"]);
$badExtensions=array("php","php3","php4","php5","php7","js","asp");
$imagesExtentions=array("jpg","jpeg","gif","png");

if(!(int)$_POST["wMax"]) $_POST["wMax"]=0;
if(!(int)$_POST["hMax"]) $_POST["hMax"]=0;


if (!empty($_FILES)) {
	
    $tempFile   = $_FILES['Filedata']['tmp_name'];
	$fileParts = pathinfo($_FILES['Filedata']['name']);

    $extensionFile=strtolower($fileParts['extension']);
    $fileName = sanitize_filename($fileParts["filename"]);
    $targetFileName=$fileName . "." . $extensionFile;
    $targetFile =  $uploadDir . $targetFileName;
    $targetFileFromRacine =  str_replace("../","",$targetFile);

    $idResultat=0;
    
    if (!in_array($extensionFile, $extensions)) {
        $idResultat=1;
    } 
    
    if (in_array($extensionFile, $badExtensions)) {
        $idResultat=2;
    } 

    // si pas d'erreurs détectées, on uploader le fichier
    if($idResultat==0) {

        if(move_uploaded_file($tempFile, $targetFile)) {
				
				// Redimnesionnement Image principal //////////////////////////////
				list($width_targetFile, $height_targetFile) = getimagesize($targetFile); 

				$width_new=$width_targetFile;
				$height_new=$height_targetFile;

				if ($height_new>$_POST["hMax"] && $_POST["hMax"]>0){
					$height_new = $_POST["hMax"];
					$width_new = round($_POST["hMax"] / ($height_targetFile/$width_targetFile));
				} 
				if ($width_new>$_POST["wMax"] && $_POST["wMax"]>0 ){
					$width_new = $_POST["wMax"];
					$height_new = round($_POST["wMax"] / ($width_targetFile/$height_targetFile));
				} 


				if($width_new!=$width_targetFile || $height_new!=$height_targetFile) { 
					resizeImage( $width_new, $height_new, $targetFile, $targetFile); 
				}
        
        } //if(move_uploaded_file($tempFile, $targetFile))
        
        
        //generate thumbnails after the main file is uploaded
        if($_POST["dimThumbs"]!="" && in_array($extensionFile, $imagesExtentions)) {
            
            $l_dimThumbs = explode(",", $_POST["dimThumbs"]);
            
            if($_POST["foldThumbs"]!="") { $l_foldThumbs = explode(",", $_POST["foldThumbs"]); }
            if($_POST["cropThumbs"]!="") { $l_cropThumbs = explode(",", $_POST["cropThumbs"]); }
            
            $result["dimThumbs"] = array();
            $imageFile= $targetFile;            
            for($i=0; $i<count($l_dimThumbs); $i++) {
                
                $dimensions = explode("x", trim($l_dimThumbs[$i]));
                
                $destinationFile = (trim($l_foldThumbs[$i])!="" ? trim($l_foldThumbs[$i]):$uploadDir) . $fileName .  $_POST["svig"] . $i .  "." . $extensionFile;
                resizeImage($dimensions[0], $dimensions[1], $imageFile, $destinationFile,array(),array(),$_POST["cropThumbs"]); // $l_cropThumbs[$i]							
                $result["dimThumbs"][] = $fileName . $_POST["svig"] . $i . "." . $extensionFile;

                
            } //for($i=0; $i<count($l_dimThumbs); $i++)

        }  // if($_POST["dimThumbs"]!="")
        
    } // $idResultat==0
    
    
    // affichage résultats
     
    $texte="";
    switch ($idResultat) {
          case 0:
              $texte="";
              break;
          
          case 1:
              $texte="Type de fichier invalide";
              break;
              
         case 2:
              $texte="Type de fichier interdit";
              break;
                 
          default:
            
      }
    
    $message="";
    if($texte!="" && $idResultat==0) {
        $message = "<div class='ok'>". $texte . "</div>";
    }
    
    if($texte!="" && $idResultat>0) {
         $message = "<div class='ko'>". $texte . "</div>";
    }
    

}

echo json_encode(['message' => $message, 'targetFile' => $targetFileFromRacine]);

?>