<?php
// permet d'afficher un array proprement (mieux qu'un simple print_r
function echoa($array) {
	echo("<pre>");
	print_r($array);
	echo("</pre>");
}

// FONCTION NECESSAIRE A VIMEO. cURL doit etre activité sur le serveur PHP
function curl_get($url) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	$return = curl_exec($curl);
	curl_close($curl);
	return $return;
}

// FONCTION permetttant d'initialiser la page 404 correctement
function config_404($erreur404="") {
    
    global $thisSite;
    
	if(($thisSite->SERVER == "local") && $thisSite->erreur404=="" ){
    	$thisSite->erreur404=$erreur404;
	}
	if($thisSite->current_lang=="") {  $thisSite->current_lang=$thisSite->LANG_DEF; }
    $thisSite->current_tab_paths=array();
    $thisSite->current_tab_paths[0]="404";
    $thisSite->current_typePage="page";

}

/////////////////////////////////////////////////////
//Cette fonction génère, sauvegarde et retourne un token
//Vous pouvez lui passer en paramètre optionnel un nom pour différencier les formulaires
function generer_token($nom = '') {
    
    session_start();
    $token = uniqid(rand(), true);
    $_SESSION[$nom.'_token'] = $token;
    $_SESSION[$nom.'_token_time'] = time();
    return $token;
}


//Cette fonction vérifie le token
//Vous passez en argument le temps de validité (en secondes)
//Le referer attendu (adresse absolue, rappelez-vous :D)
//Le nom optionnel si vous en avez défini un lors de la création du token
function verifier_token($nom, $referer="", $temps=0) {
	
	global $thisSite;
	
	session_start();
	if(!is_unsigned_integer($temps) || $temps==0) { $temps=15*60;}
	
	if(!isset($_SESSION[$nom.'_token'])) return false;
	
	if(isset($_SESSION[$nom.'_token']) && isset($_SESSION[$nom.'_token_time']) && isset($_POST['token']) )
		if($_SESSION[$nom.'_token'] == $_POST['token'])
			if($_SESSION[$nom.'_token_time'] >= (time() - $temps))
				
				if($thisSite->current_lang!="") {
					$HTTP_REFERER=str_replace($thisSite->current_lang."/","",$_SERVER['HTTP_REFERER']);
				} else {
					$HTTP_REFERER=$_SERVER['HTTP_REFERER'];
				}
				//	echo($_SERVER['HTTP_REFERER']."<br>");
				//	echo($HTTP_REFERER."<br>");
				//	echo($referer."<br>");
				if($HTTP_REFERER == $referer || $referer=="") {
					unset($_SESSION[$nom.'_token']);
					return true;
				}
	return false;
}
/////////////////////////////////////////////////////

function is_IE() {
	return(preg_match('/MSIE/i',$_SERVER['HTTP_USER_AGENT']));
}

function is_IE6() {
	return(preg_match('/MSIE 6/i',$_SERVER['HTTP_USER_AGENT']));
}

function is_IE7() {
	return(preg_match('/MSIE 7/i',$_SERVER['HTTP_USER_AGENT']));
}

function is_IE8() {
	return(preg_match('/MSIE 8/i',$_SERVER['HTTP_USER_AGENT']));
}

function is_Chrome() {
	return(preg_match('/Chrome/i',$_SERVER['HTTP_USER_AGENT']));
}

function is_Safari() {
	return(preg_match('/Safari/i',$_SERVER['HTTP_USER_AGENT']));
}


function get_os() {
    
	$u_agent = $_SERVER['HTTP_USER_AGENT']; 
	
	if (preg_match('/linux/i', $u_agent)) {
		$OS = 'linux';
	}
	elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		$OS = 'mac';
	}
	elseif (preg_match('/windows|win32/i', $u_agent)) {
		$OS = 'windows';
	}
	
	return $OS;
}


							 
// conversion et contrôle données passer en _GET ou _POST
function ctr_global($glob, $option="") {
	
	if($option=="strip_tags") { $glob=strip_tags($glob); }
	$glob=xss_clean($glob);
	
	return $glob;
}


// Affichage de toutes les variables de Session en cours
function show_var_session() {
	foreach($_SESSION as $key=>$val) {
	 echo $key.'=>'.$val.'<br>'; 
	 }
}

// renvoi l'extension
function get_extension($fichier,$only_image=0) {
	$pos = strrpos($fichier,".");
	$extension = substr($fichier,$pos+1,strlen($fichier)-$pos);
	$extension = strtolower($extension);
	
	if($only_image==1) {
		$extension_images=array("jpeg","jpg","gif","png");
		if(!in_array($extension,$extension_images)) {
			return false;	
		}
	}
	
	return $extension;
}

// Supprime l'extension d'un fichier
function remove_extension($fichier){
	$p=strrpos($fichier,".");
	$name=substr($fichier,0,$p);
	
	return $name;
}

// renvoi le nom d'un fichier, sans le chemin
function get_nom_fichier($fichier) {
	return basename($fichier);
}

// retourne le poids d'un fichier dans le format le plus lisible
function format_poids_fichier($poids) {
	if($poids == 0)						$format = "";
	else if($poids <= 1024)				$format = $poids." oc.";
	else if($poids < (10*1024))			$format = sprintf ("%.2f k%s",($poids/1024),"o");
	else if($poids < (100*1024))		$format = sprintf ("%.1f k%s",($poids/1024),"o");
	else if($poids < (1024*1024))		$format = sprintf ("%d k%s",($poids/1024),"o");
	else if($poids < (10*1024*1024))	$format = sprintf ("%.2f M%s",($poids/(1024*1024)),"o");
	else if($poids <= (100*1024*1024))	$format = sprintf ("%.1f M%s",($poids/(1024*1024)),"o");
	else								$format = sprintf ("%d M%s",($poids/(1024*1024)),"o");

	return $format;
}


// : Retourne des dimensions en respectant des contraintes
function resize_me($img,$wmax,$hmax=0) { 

	list($wi,$hi) = getimagesize($img);
	
	$w = $wi;
	$h = $hi;
		
	if ($wi>$wmax && $wmax>0 ){
		$w = $wmax;
		$h = round($wmax / ($wi/$hi));
	}
	
	if ($hi>$hmax && $hmax>0 && $h>$hmax){
		$h = $hmax;
		$w = round($hmax / ($hi/$wi));
	}	
	
	$t=array($w,$h);
	return $t;
}

// Retourne l'arborescence d'un dossier
function read_tree($dossier,$raz=1){
	if(($dir=opendir($dossier))===false) return;

	if($dossier[strlen($dossier)-1]=="/") { $dossier=substr($dossier ,0,strlen($dossier)-1); }

	if($raz=="1") { $_SESSION['arbo']=array(); }

	while($name=readdir($dir)){
		if($name==='.' or $name==='..' or $name==='Thumbs.db') { continue; }
		
		$full_name=$dossier."/".$name;

		if(is_dir($full_name)) {
		//	echo(strtoupper("<hr><b>$full_name</b><br>"));
			$_SESSION['arbo'][$full_name]=array();
			read_tree($full_name,0);
		} else {
		//	if(!is_array($arbo[$dossier])) { $arbo[$dossier]=array();echo("eeeeeeeeeeeeeeeee"); echoa($arbo);}
	//		echo(" - $dossier > $name<br>");

			$_SESSION['arbo'][$dossier][]=$name;
		}
	}

	closedir($dir);
	
	ksort($_SESSION['arbo']);
	
	return $_SESSION['arbo'];

}

// supprime une arborescence de dossier (sous dossiers et fichiers)
function del_tree($dossier,$not_racine=""){
	
	if(($dir=opendir($dossier))===false) return;

	while($name=readdir($dir)){
		if($name==='.' or $name==='..')
			continue;
		$full_name=$dossier.'/'.$name;

		if(is_dir($full_name))
			del_tree($full_name);
		else unlink($full_name);
		}

	closedir($dir);

	if($not_racine=="") { @rmdir($dossier); }
}


// retourne le nom du fichier vignette à partir d'un fichier image
function get_vignette($fichier_image,$indice=0) { 

	$fichier_image=stripslashes($fichier_image);
	
	if($fichier_image=="") { return ""; }

	$p=strpos($fichier_image,"-vig" . $indice. ".");
	if($p>0) { return $fichier_image; }

	$p=strrpos($fichier_image,".");
	$deb_fichier_image=substr($fichier_image,0,$p);
	$fin_fichier_image=substr($fichier_image,$p);
	
	if(file_exists($deb_fichier_image . "-vig" . $indice. $fin_fichier_image)) {
		return $deb_fichier_image . "-vig" . $indice. $fin_fichier_image;
	} else {
		return $fichier_image;	
	}
}

// retourne le nom du fichier image
function get_image($fichier_image) { 
	$fichier_image=stripslashes($fichier_image);
	
	if($fichier_image=="") { return ""; }
	
	$p=strpos($fichier_image,"-vig.");
	if($p==0) { return $fichier_image; }

	$deb_fichier_image=substr($fichier_image,0,$p);
	$fin_fichier_image=substr($fichier_image,$p +strlen("-vig"));
	return $deb_fichier_image  . $fin_fichier_image;
}

// récupérer les droits d'un fichier ou d'un dossier (par exemple ,retourne: 0755)
function get_permissions($file) {
 
 clearstatcache();
 $ss=@stat($file);
 if(!$ss) return false; //Couldnt stat file
 
 $ts=array(
  0140000=>'ssocket',
  0120000=>'llink',
  0100000=>'-file',
  0060000=>'bblock',
  0040000=>'ddir',
  0020000=>'cchar',
  0010000=>'pfifo'
 );
 
 $p=$ss['mode'];
 $t=decoct($ss['mode'] & 0170000); // File Encoding Bit
 
 $str =(array_key_exists(octdec($t),$ts))?$ts[octdec($t)]{0}:'u';
 $str.=(($p&0x0100)?'r':'-').(($p&0x0080)?'w':'-');
 $str.=(($p&0x0040)?(($p&0x0800)?'s':'x'):(($p&0x0800)?'S':'-'));
 $str.=(($p&0x0020)?'r':'-').(($p&0x0010)?'w':'-');
 $str.=(($p&0x0008)?(($p&0x0400)?'s':'x'):(($p&0x0400)?'S':'-'));
 $str.=(($p&0x0004)?'r':'-').(($p&0x0002)?'w':'-');
 $str.=(($p&0x0001)?(($p&0x0200)?'t':'x'):(($p&0x0200)?'T':'-'));
 
 $s=sprintf("0%o", 0777 & $p);
 clearstatcache();
 return $s;
}

// récupérer propriétés sur un fichier ou un dossier
function prop_fichier($file) {
 
 clearstatcache();
 $ss=@stat($file);
 if(!$ss) return false; //Couldnt stat file
 
 $ts=array(
  0140000=>'ssocket',
  0120000=>'llink',
  0100000=>'-file',
  0060000=>'bblock',
  0040000=>'ddir',
  0020000=>'cchar',
  0010000=>'pfifo'
 );
 
 $p=$ss['mode'];
 $t=decoct($ss['mode'] & 0170000); // File Encoding Bit
 
 $str =(array_key_exists(octdec($t),$ts))?$ts[octdec($t)]{0}:'u';
 $str.=(($p&0x0100)?'r':'-').(($p&0x0080)?'w':'-');
 $str.=(($p&0x0040)?(($p&0x0800)?'s':'x'):(($p&0x0800)?'S':'-'));
 $str.=(($p&0x0020)?'r':'-').(($p&0x0010)?'w':'-');
 $str.=(($p&0x0008)?(($p&0x0400)?'s':'x'):(($p&0x0400)?'S':'-'));
 $str.=(($p&0x0004)?'r':'-').(($p&0x0002)?'w':'-');
 $str.=(($p&0x0001)?(($p&0x0200)?'t':'x'):(($p&0x0200)?'T':'-'));
 
 $s=array(
 'perms'=>array(
  'umask'=>sprintf("%04o",@umask()),
  'human'=>$str,
  'octal1'=>sprintf("%o", ($ss['mode'] & 000777)),
  'octal2'=>sprintf("0%o", 0777 & $p),
  'decimal'=>sprintf("%04o", $p),
  'fileperms'=>@fileperms($file),
  'mode1'=>$p,
  'mode2'=>$ss['mode']),
 
 'owner'=>array(
  'fileowner'=>$ss['uid'],
  'filegroup'=>$ss['gid'],
  'owner'=>
  (function_exists('posix_getpwuid'))?
  @posix_getpwuid($ss['uid']):'',
  'group'=>
  (function_exists('posix_getgrgid'))?
  @posix_getgrgid($ss['gid']):''
  ),
 
 'file'=>array(
  'filename'=>$file,
  'realpath'=>(@realpath($file) != $file) ? @realpath($file) : '',
  'dirname'=>@dirname($file),
  'basename'=>@basename($file)
  ),

 'filetype'=>array(
  'type'=>substr($ts[octdec($t)],1),
  'type_octal'=>sprintf("%07o", octdec($t)),
  'is_file'=>@is_file($file),
  'is_dir'=>@is_dir($file),
  'is_link'=>@is_link($file),
  'is_readable'=> @is_readable($file),
  'is_writable'=> @is_writable($file)
  ),
 
 'device'=>array(
  'device'=>$ss['dev'], //Device
  'device_number'=>$ss['rdev'], //Device number, if device.
  'inode'=>$ss['ino'], //File serial number
  'link_count'=>$ss['nlink'], //link count
  'link_to'=>($s['type']=='link') ? @readlink($file) : ''
  ),
 
 'size'=>array(
  'size'=>$ss['size'], //Size of file, in bytes.
  'blocks'=>$ss['blocks'], //Number 512-byte blocks allocated
  'block_size'=> $ss['blksize'] //Optimal block size for I/O.
  ),
 
 'time'=>array(
  'mtime'=>$ss['mtime'], //Time of last modification
  'atime'=>$ss['atime'], //Time of last access.
  'ctime'=>$ss['ctime'], //Time of last status change
  'accessed'=>@date('Y M D H:i:s',$ss['atime']),
  'modified'=>@date('Y M D H:i:s',$ss['mtime']),
  'created'=>@date('Y M D H:i:s',$ss['ctime'])
  ),
 );
 
 clearstatcache();
 return $s;
}


// Conversion d'un tableau PHP en JS
// echo var_to_js("liste_prix",$liste_prix);
function var_to_js($jsname,$a){
    $ret='';
    if (is_array($a)) {
        $ret.=$jsname.'= new Array();
        ';
         
        foreach ($a as $k => $a) {
            if (is_int($k) || is_integer($k))
                $ret.= var_to_js($jsname.'['.$k.']',$a);
            else
                $ret.= var_to_js($jsname.'[\''.$k.'\']',$a);
        }
         
    }
    elseif (is_bool($a)) {
        $v=$a ? "true" : "false";
        $ret.=$jsname.'='.$v.';
        ';
    }
    elseif (is_int($a) || is_integer($a) || is_double($a) || is_float($a)) {
       $ret.=$jsname.'='.$a.';
        ';
    }
    elseif (is_string($a)) {
       $ret.=$jsname.'=\''.html_to_js_var($a).'\';
        ';
    }
    return $ret;
}

function html_to_js_var($t){
    return str_replace('</script>','<\/script>',addslashes(str_replace("\r",'',str_replace("\n","",$t))));
}

/*
* XSS filter
https://gist.github.com/mbijon/1098477
*
* This was built from numerous sources
* (thanks all, sorry I didn't track to credit you)
*
* It was tested against *most* exploits here: http://ha.ckers.org/xss.html
* WARNING: Some weren't tested!!!
* Those include the Actionscript and SSI samples, or any newer than Jan 2011
*
*
* TO-DO: compare to SymphonyCMS filter:
* https://github.com/symphonycms/xssfilter/blob/master/extension.driver.php
* (Symphony's is probably faster than my hack)
*/
 
function xss_clean($data)
{
// Fix &entity\n;
$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
$data = html_entity_decode($data, ENT_COMPAT, 'utf-8');
 
// Remove any attribute starting with "on" or xmlns
$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
 
// Remove javascript: and vbscript: protocols
$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
 
// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
 
// Remove namespaced elements (we do not need them)
$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
 
do
{
// Remove really unwanted tags
$old_data = $data;
$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
}
while ($old_data !== $data);
 
// we are done...
return $data;
}
?>