<?php
$pathIframe="../../";
include($pathIframe  . "init_pages/" . "iframe.php");
require_once($pathIframe . DOS_OUTILS_ADMIN . 'filelistclass/file_list.class.php');
addStructure("addCssStructure",DOS_SKIN_ADMIN . "file_list.class.css");

/*
Suppression fichiers par case à cocher
Changer Droits
Move fichier

Button: fichier déjà utilisé dans la table

// UPLOAD
Upload autorisé ou non
Extensions autorisées
Redim dans X tailles (taille large, vig1, vig2, etc.) (array)
Poids Max
Interdire (renomer) les fichiers avec des caractères invalides
Gérer et Afficher infos sur redimenssionnement, etc.. comme actuellement
*/
?>
<?php
$racine_root="../../../";
$racine_start=$racine_root . $thisSite->DOS_CLIENT_FILES;
$smarty->assign("width_thumbs", 100);
?>
<?php
// infos du champ d'appel
if(isset($__GET['field'])) { $field=$__GET['field']; }
if($field=="") { die; }
if(isset($__GET['startFolder'])) { $racine=$racine_start . $__GET['startFolder']; }  else { $racine=$racine_start . $__POST['startFolder']; }
if(substr($racine, -1, 1)!="/") { $racine.="/";}

if(isset($__GET['from'])) { $from=$__GET['from']; }
if(isset($__GET['CKEditor'])) { $CKEditor=$__GET['CKEditor']; }
if(isset($__GET['CKEditorFuncNum'])) { $CKEditorFuncNum=$__GET['CKEditorFuncNum']; }
if(isset($__GET['tmfield'])) { $tmfield=$__GET['tmfield']; }
if(isset($__GET['uploadOK'])) { $uploadOK=$__GET['uploadOK']; }
if(isset($__GET['dimMax'])) { 
	$dimMax=$__GET['dimMax']; 
	$dimMaxArray=explode("x",$__GET['dimMax']);
}
if(isset($__GET['dimThumbs'])) { 
	$dimThumbs=$__GET['dimThumbs']; 
	$dimThumbsArray=explode(",",$__GET['dimThumbs']);
}

if($__GET['ext']=="images") {
	$extensionsAuthorized=$myAdmin->extentionsImagesOk;
} else if($__GET['ext']=="") {
	$extensionsAuthorized=$myAdmin->extentionsOk ;
} else {
	$ext=explode(",",$__GET['ext']);
	if(is_array($ext)) { 
		$extensionsAuthorized=$ext; 
	} else {
		$extensionsAuthorized=$myAdmin->extentionsOk;
	}
}

// infos de navigation
$path      = (isset($__POST['path'])  ? $__POST['path']  : $racine );
$order_by  = (isset($__POST['order_by']) ? $__POST['order_by'] : File_List::KEY_DATE);
$order_dir = (isset($__POST['order_dir'])   ? $__POST['order_dir']   : File_List::DESC);
$start     = (isset($__POST['start']) ? $__POST['start'] : 0);
$limit     = (isset($__POST['limit']) ? $__POST['limit'] : 100);
$vignettes = (isset($__POST['vignettes']) ? $__POST['vignettes'] : 0);
$displayMode = (isset($__POST['displayMode']) ? $__POST['displayMode'] : "list");
$displaySizes = (isset($__POST['displaySizes']) ? $__POST['displaySizes'] : 0);
$fileNotUsed = (isset($__POST['fileNotUsed']) ? $__POST['fileNotUsed'] : 0);
$search      = (isset($__POST['search'])  ? $__POST['search']  : $search );

if($__POST['path']!="") { 
   // si on a changé de dossiers, on le sauvegarde pour revenir dessus la prochaine fois
     if($myAdmin->newNiveau2!="") { $_SESSION["browsePath"][$myAdmin->newNiveau2]=$path; }  
 } else {
    if($myAdmin->newNiveau2!="") { 
        if($_SESSION["browsePath"][$myAdmin->newNiveau2]!="" && !strstr($path,$_SESSION["browsePath"][$myAdmin->newNiveau2])) {
            //echoa("N2 " . $myAdmin->newNiveau2 . " > " . $_SESSION["browsePath"][$myAdmin->newNiveau2]);
            $path=$_SESSION["browsePath"][$myAdmin->newNiveau2];
        }
    }
 }
//echoa("POST" . $__POST['path']);
//echoa("path" . $path);
//echoa($_SESSION["browsePath"]);
?>
<?php
// ACTIONS SUR DOSSIER ET FICHIERS

// rename un fichier
if(isset($__POST['newfile']) && $__POST['oldfile']!=$__POST['newfile'] ) { 
	$oldname=$racine_root . $__POST['folder'] . $__POST['oldfile'];
	$newname=$racine_root . $__POST['folder'] . $__POST['newfile'];
	@rename("$oldname","$newname");

	$oldname_extension = "." . get_extension($oldname);
	$newname_extension = "." . get_extension($newname);
	
	for($i=-1;$i<10;$i++) {
		if($i==-1) { $num=""; } else { $num=$i; }
		$oldname_vig=str_replace($oldname_extension , $myAdmin->suffixeVignettes . $num . $oldname_extension ,$oldname);
		$oldname_vig=str_replace($myAdmin->suffixeVignettes . $num . $oldname_extension, $myAdmin->suffixeVignettes . $num . $oldname_extension,$oldname_vig);

		if(file_exists($oldname_vig)) {
			$newname_vig=str_replace($newname_extension , $myAdmin->suffixeVignettes . $num . $newname_extension ,$newname);
			$newname_vig=str_replace($myAdmin->suffixeVignettes . $num . $newname_extension, $myAdmin->suffixeVignettes . $num . $newname_extension,$newname_vig);
			//echoa($oldname_vig . " " . $newname_vig);
			@rename("$oldname_vig","$newname_vig");
			
		}
	}
	
	$path=$racine_root . $__POST['folder'];
	
}
// créer un dossier
if(isset($__POST['addfolder']) && isset($__POST['racineaddfolder']) ) { 
	if($__POST['racineaddfolder']=="") { $__POST['racineaddfolder']=$racine_start;  }
	$newfolder=$__POST['racineaddfolder'] . $__POST['addfolder'];
	if (!file_exists($newfolder)) {
		$res = mkdir($newfolder);
		chmod($newfolder,octdec($thisSite->DROITS_DOSSIER_ECRITURE));
	}
	$path=$__POST['racineaddfolder'];
}

// Suppression d'un fichier
if(isset($__POST['delItem']) && $__POST['delItem']!="") { 

	$delItem = $racine_root . $__POST['delItem'];
	$delItem = urldecode($delItem);

	if (is_dir($delItem)) {
		$repertoire = opendir($delItem); 
		while (false !== ($fic2del = readdir($repertoire)))	{
			$chemin2del = $delItem."/".$fic2del; 
			if ($fic2del != ".." AND $fic2del != "." AND !is_dir($chemin2del)) { unlink($chemin2del); }
		}
		
		closedir($repertoire);
		if (@!rmdir($delItem)) echo "<script>window.alert('Impossible de supprimer le repertoire..verifier qu il soit bien vide.');</script>"; 
		
	} else { 
	
		unlink($delItem);
			
		$delItem_extension = "." . get_extension($delItem);
		for($i=0;$i<10;$i++) {
			if($i==-1) { $num=""; } else { $num=$i; }
			$delItem_vig=str_replace($delItem_extension , $myAdmin->suffixeVignettes . $num . $delItem_extension ,$delItem);
			$delItem_vig=str_replace($myAdmin->suffixeVignettes . $num . $delItem_extension,$myAdmin->suffixeVignettes . $num . $delItem_extension,$delItem_vig);

			if(file_exists($delItem_vig)) { unlink($delItem_vig); }
		}
	}

} // suppression d'un fichier
	
// Get started looking for files
if (!file_exists($path)) {
	$res = mkdir($path);
	chmod($path,octdec($thisSite->DROITS_DOSSIER_ECRITURE));
}
$file_list = new File_List();

if(strlen($search)>2) { 
    $listing   = $file_list->getListing($path, File_List::TYPE_BOTH, $order_by, $order_dir, 0,1000,$displaySizes);
} else {
    $listing   = $file_list->getListing($path, File_List::TYPE_BOTH, $order_by, $order_dir, $start, $limit,$displaySizes);  
}



// preparation template
$smarty->assign("field", $field);
$smarty->assign("startFolder", $startFolder);
$smarty->assign("from", $from);
$smarty->assign("CKEditor", $CKEditor);
$smarty->assign("CKEditorFuncNum", $CKEditorFuncNum);
$smarty->assign("tmfield", $tmfield);
$smarty->assign("path", $path);
$smarty->assign("order_by", $order_by);
$smarty->assign("order_dir", $order_dir);
$smarty->assign("start", $start);
$smarty->assign("limit", $limit);
$smarty->assign("vignettes", $vignettes);
$smarty->assign("displayMode", $displayMode);
$smarty->assign("displaySizes", $displaySizes);
$smarty->assign("fileNotUsed", $fileNotUsed);
$smarty->assign("extensionsAuthorized", $extensionsAuthorized);
$smarty->assign("uploadOK", $uploadOK);
$smarty->assign("dimMax", $dimMax);
$smarty->assign("dimThumbs", $dimThumbs);
//Breadcrumbs
$smarty->assign("racine_start", $racine_start);
$smarty->assign("racine", $racine);
$smarty->assign("getLastError", $file_list->getLastError());

$short_path=str_replace($racine_start,"",$path);
$path_items   = explode('/', $short_path);
$current_path = $racine_start;
$path_items_filtred=array();
foreach ($path_items as $folder) {
	if($folder==".." || $folder=="." || $folder=="") { continue; }
	$current_path .= $folder . "/";
	$path_items_filtred[$current_path]=htmlspecialchars($folder);
}
$smarty->assign("path_items_filtred", $path_items_filtred);
$smarty->assign("search", $search);

// file table
$smarty->assign("getOrderLink_KEY_NAME", getOrderLink(File_List::KEY_NAME));
$smarty->assign("getOrderLink_KEY_DATE", getOrderLink(File_List::KEY_DATE));
$smarty->assign("getOrderLink_KEY_SIZE", getOrderLink(File_List::KEY_SIZE));

// Iterate over the items in this folder
if ($file_list->getLastItemCount()) {
	$real_path=str_replace("../","",$path);
	$xx=0;
	$listing_filtred=array();

	foreach ($listing as $item) {
		$xx++;
		$datas=array();
		
		if ($item[File_List::KEY_TYPE] == File_List::TYPE_FILE) { // si c'est un fichier
			if(!in_array($item[File_List::KEY_EXT],$extensionsAuthorized)) { continue; }
			if($search!="" && strpos(strtolower($item[File_List::KEY_NAME]),strtolower($search))=== false) { continue; }
			
		}
		
		if($fileNotUsed==1) {
			$requetex= "SELECT id FROM " . $thisSite->PREFIXE_TBL_GEN . "medias";
			$requetex.= " WHERE fichier_media='" . $real_path . $item[File_List::KEY_NAME] . "'" ;
			$requetex.= " LIMIT 1";
			$resultx = $PDO->free_requete($requetex);

			$rowx = $resultx->fetch();
			if($rowx["id"] > 0) {
				continue;
			}
		}
		

		if(in_array($item[File_List::KEY_EXT],$myAdmin->extentionsImagesOk)) { // si c'est une image
			if($vignettes==0 && strpos($item[File_List::KEY_NAME], $myAdmin->suffixeVignettes )!== false) { continue; }
			if($displaySizes==1) {
				list($width, $height) = getimagesize(htmlspecialchars($thisSite->RACINE. str_replace(' ', '%20', $real_path) . str_replace(' ', '%20', $item[File_List::KEY_NAME]))); 
	
				$datas["image_disabled"]="image_disabled";
				if ( $dimMaxArray[0]==0 && $dimMaxArray[1]==0) { $datas["image_disabled"]=""; } 
				if ( $dimMaxArray[0]>0 && $width<=$dimMaxArray[0] && $dimMaxArray[1]==0) { $datas["image_disabled"]=""; } 
				if ( $dimMaxArray[1]>0 && $height<=$dimMaxArray[1] && $dimMaxArray[0]==0) { $datas["image_disabled"]=""; }
				if ( $dimMaxArray[1]>0 && $height<=$dimMaxArray[1] && $dimMaxArray[0]>0 && $width<=$dimMaxArray[0]) { $datas["image_disabled"]=""; } 
	
				$datas["imagesize"]="<span class=\"dimen\">" . $width ."x" . $height . "</span>";
			}
			$datas["preview"]=1;
		}
		
		if($fileUsed==1) { // Voir que les fichiers Non utilisés
			$requetex="SELECT count(id) AS cpt FROM " .  $thisSite->PREFIXE_TBL_GEN . "medias" . " WHERE fichier_media='" . $real_path . $item[File_List::KEY_NAME] . "'";
			$resultx = $PDO->free_requete($requetex);
			$rowx = $resultx->fetch();
			if($rowx["cpt"]>"0") { continue; }
		}
		
		$datas["icone"]=$item[File_List::KEY_TYPE] == File_List::TYPE_FOLDER ? 'folder.png' : 'file.png';
		$datas["typefic"]=$item[File_List::KEY_TYPE] == File_List::TYPE_FOLDER ? 'folder' : 'file';
		if($displaySizes==1) { $datas["niceSize"]=$item[File_List::KEY_TYPE] == File_List::TYPE_FILE   ? niceSize($item[File_List::KEY_SIZE]) : '&nbsp;'; }
		$datas["path"]=$path;
		$datas["real_path"]=$real_path;
		$datas["real_path_urlencode"]=urlencode($real_path);
		$datas["KEY_TYPE"]=$item[File_List::KEY_TYPE];
		$datas["KEY_NAME"]=$item[File_List::KEY_NAME];
		$datas["KEY_NAME_htmlsc"]=htmlspecialchars($item[File_List::KEY_NAME]);
		$datas["KEY_NAME_urlencode"]=urlencode($item[File_List::KEY_NAME]);
		$datas["KEY_DATE"]=date('d/m/y H:i:s', $item[File_List::KEY_DATE]);

		$listing_filtred[$xx]=$datas;
	}
	$smarty->assign("listing_filtred", $listing_filtred);
}
	
$smarty->assign("getLastItemCount", $file_list->getLastItemCount());
$smarty->assign("getPagination", getPagination($file_list->getLastItemCount(), $start, $limit));
$smarty->assign("totPagination", ($start + $limit) >  $file_list->getLastItemCount() ? $file_list->getLastItemCount() : ($start + $limit));


////////////////////////// PREPARATION UPLOAD ///////////////////////////////
upload_info("browse",$path,$dimMaxArray,$dimThumbs,$extensionsAuthorized);

//
//$upload_info = $datas_lang["upload_infoPoids"] . "<br>";
//
//if ($dimMaxArray[0]==0 && $dimMaxArray[1]==0 ) { 
//	$upload_info.= $datas_lang["upload_info0"];
//} else {
//	if ($dimMaxArray[0]>0 && $dimMaxArray[1]==0 ) {	$upload_info.= $datas_lang["upload_info1"]; }
//	if ($dimMaxArray[0]==0 && $dimMaxArray[1]>0 ) {	$upload_info.= $datas_lang["upload_info2"]; }
//	if ($dimMaxArray[0]>0 && $dimMaxArray[1]>0 ) {	$upload_info.= $datas_lang["upload_info3"]; }
//} 
//
//if ($dimThumbs!="") { $upload_info.= "<br>" . $datas_lang["upload_infoThumbs"]; } 
//
//$upload_info= str_replace("!!poidsmax!!", niceSize(POIDSMAX), $upload_info);
//$upload_info= str_replace("!!wMax!!", $dimMaxArray[0], $upload_info);
//$upload_info= str_replace("!!hMax!!", $dimMaxArray[1], $upload_info);
//$upload_info= str_replace("!!dimThumbs!!", $dimThumbs, $upload_info);
//
//$upload_info .= "<br>" . $datas_lang["upload_infoExtension"];
//$exts=implode(",",$extensionsAuthorized);
//$upload_info= str_replace("!!extensions!!", $exts, $upload_info);
//
//$smarty->assign("upload_info",$upload_info);
//$smarty->assign("wMax",$dimMaxArray[0]);
//$smarty->assign("hMax",$dimMaxArray[1]);
//$smarty->assign("poidsmax", POIDSMAX);
//$smarty->assign("extensionsAuthorized", $exts);
//$smarty->assign("dimThumbs", $dimThumbs);

////////////////////////// FIN UPLOAD ///////////////////////////////
?>
<?php
    /**
     * sanitizePath
     * Removes relative items from the path
     *
     * @access public
     * @param  string  $path
     * @return string
     */
	function sanitizePath($path) {
       $path = trim($path, '/');
        //$path = str_replace('../', '', $path);
        $path = str_replace('\\',  '/', $path);
        $path = trim($path, '.');
        $path = str_replace('//', '/', $path);
        $path = trim($path, '/');
        return $path;
    }


    /**
     * getOrderLink
     * Returns a URL with parameters for ordering based on what is currently selected
     *
     * @access public
     * @param  bool   $column
     * @param  bool   $change_direction
     * @return string
     */
    function getOrderLink($column = false, $change_direction = true) {
        global $order_by, $order_dir;

        if (!$column) {
            $column = $order_by;
        }

        if ($order_by == $column) {
            if ($change_direction) {
                $new_order_dir = ($order_dir == File_List::ASC ? File_List::DESC : File_List::ASC);
            } else {
                $new_order_dir = $order_dir;
            }
        } else {
            $new_order_dir = File_List::ASC;
        }

        //return $_SERVER['PHP_SELF'].'?order='.$column.'&dir='.$new_order_dir;
		return "'" . $column . "','" . $new_order_dir . "'";
    }


    
    /**
     * getPagination
     * Returns HTML of Pagination links
     *
     * @access public
     * @param  int    $total_items
     * @param  int    $offset
     * @param  int    $rows_per_page
     * @return string
     */
    function getPagination($total_items, $offset, $rows_per_page) {
        global $path;
		 global $start;

        $html  = 'Page: ';
        $pages = ceil($total_items / $rows_per_page);

        for ($page = 0; $page < $pages; $page++) {
			if($start==($rows_per_page * $page)) { $class='class="actif"'; } else { $class=''; }
			$html .= ' &nbsp; <a ' .  $class . ' href="javascript:changePagination(\'' . ($rows_per_page * $page) . '\');">'.($page + 1).'</a>';
        }

        return $html; 
    }

?>
<?php

$smarty->assign("script_tpl", "browse.tpl");

$structure_page= $pathIframe  .  "templates/" . "iframe.tpl";
$smarty->assign("myAdmin", $myAdmin);
$smarty->assign("thisSite", $thisSite);
$smarty->display($structure_page );
?>