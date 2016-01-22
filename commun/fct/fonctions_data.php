<?php
// Renvoi un texte Divers
function getTexte($id) {
    
    global $thisSite;
    
//  $mySelect = new mySelect(__FILE__);
//	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "textes";
//	$mySelect->fields="texte";
//	$mySelect->where="id=:id AND lg=:lg";
//	$mySelect->whereValue["id"]=array($id,PDO::PARAM_STR);
//	$mySelect->whereValue["lg"]=array($thisSite->current_lang,PDO::PARAM_STR);
//	$result=$mySelect->query();
//	$row = current($result); 
//	return stripslashes($row["texte"]);
    
    $obj_article = new article("textes");
    $obj_article->where="id=" . $id ."  AND lg='". $thisSite->current_lang . "'";
    $result=$obj_article->query();
	$row = current($result); 
	return $row;
    
}

// Renvoi une image Divers
function getImage($id) {
    
    global $thisSite;

    $thisMedia = new media("images");
    $thisMedia->idMedia=$id;
    $media=$thisMedia->get();

	return current($media);
}

// Renvoi une fichier Divers
function getFile($id) {

    $thisMedia = new media("files");
    $thisMedia->idMedia=$id;
    $media=$thisMedia->get();
    
	return current($media);
}

function getEmail($code) {
    
    global $thisSite;
    
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables=$thisSite->PREFIXE_TBL_GEN . "emails";
	$mySelect->fields="*";
	$mySelect->where="code=:code";
	$mySelect->whereValue["code"]=array($code,PDO::PARAM_STR);
	$result=$mySelect->query();
	$row = current($result); 
			
	$titre = $row["titre"];
	$email = $row["email"];
	$ltemp=array();
	array_push($ltemp,$email);
	array_push($ltemp,$titre);
	return $ltemp;
}



function sendEmail($expediteur,$destinataires,$messageHTML,$objet="",$attachmentEmail="") {

    global $thisSite;
    global $pathRacine;
    
	if($expediteur=="") return 0;
	if($destinataires=="") return 0;
	
	if(!is_array($destinataires)){
           $destinataires=array($destinataires);
    }

	require_once $pathRacine . $thisSite->DOS_BASE_LIB . 'phpmailer/PHPMailerAutoload.php';
	
	$mail = new PHPMailer;

    if($thisSite->MAIL_SENDMODE=="smtp") {
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        //$mail->Debugoutput = 'html';
        $mail->Host = $thisSite->MAIL_HOST; //Set the hostname of the mail server
        $mail->Port = $thisSite->MAIL_PORT; //Set the SMTP port number - likely to be 25, 465 or 587
        $mail->SMTPAuth = $thisSite->SMTPAuth; //Whether to use SMTP authentication
        $mail->Username = $thisSite->MAIL_Username; //Username to use for SMTP authentication
        $mail->Password = $thisSite->MAIL_Password; //Password to use for SMTP authentication
    } else if($thisSite->MAIL_SENDMODE=="mail") {
        $mail->isMail();
    } else if($thisSite->MAIL_SENDMODE=="sendmail") {   
        $mail->isSendmail();
    }
   	
	$mail->From = $thisSite->MAIL_SENDER;
    $mail->addReplyTo($expediteur, $expediteur);
    $mail->From = $expediteur;
    
	$mail->FromName = '';
	foreach ($destinataires as $destinataire) { 
		$mail->addAddress($destinataire);
	}
	$mail->isHTML(true); 
	
	$mail->Subject = utf8_decode($objet);
	$mail->Body = utf8_decode($messageHTML);

	if(is_array($attachmentEmail)) {
		foreach ($attachmentEmail as $fichier) { 
		    $rr=$mail->addAttachment($fichier);
        }
	}

	if(!$mail->send()) {
		$res=$mail->ErrorInfo;
	} else {
		$res=true;
	}
	
	return $res;
}

// ajoute des éléments pour alimenter la page "plan du site"
function add_plan_du_site($menu="",$id_rub="",$lien_rub="",$titre_rub="",$SRUBS=array()) {

	global $thisSite;
	
	$tableau=array();
	$tableau["id_rub"]=$id_rub;
	$tableau["lien_rub"]=$lien_rub;
	$tableau["titre_rub"]=$titre_rub;
	$tableau["SRUBS"]=$SRUBS;

	$thisSite->siteMap[$menu][$id_rub]=$tableau;

}


?>