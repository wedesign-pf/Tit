<?php
class gestionLogs {
	
	public $email_erreur;
	
	// création de l'objet
	public function __construct () {
        global $thisSite;       
         
		$this->email_erreur = $thisSite->EMAILWEBMASTER;
	}

	public function erreursPDO($exception,$requete="",$script="") {
		
        global $thisSite;
        
		// affichage des erreurs en LOCAL
		if ($thisSite->SERVER == "local") {
			echo("ERREUR PDO: " . $script);
			echo("<br>");
			echo($exception->getMessage());
			echo("<br>");
			echo($requete);
			echo("<hr>");
			return;
		}

		$message=$exception->getMessage();
		//$fichier=$exception->getFile();
		$ligne=$exception->getLine();
		$save=1;

		$erreur = date("d.m.Y H:i:s") . " > " . $_SERVER['REQUEST_URI'] . " : " . $message . "> ligne " . $ligne . " (" . $script . ")\n";
		
		if($save == 1){ 
			$prefixe_log="PDO_";
			$this->addlog($prefixe_log,$erreur);
		}
	}
	
	public function erreursPHP($cat, $type, $message, $fichier, $ligne) {
		
        global $thisSite;
        
		$prefixe_log="";
		$save = 1;
		
		switch($type) {
			case E_ERROR:
			case E_PARSE:
			case E_CORE_ERROR:
			case E_CORE_WARNING:
			case E_COMPILE_ERROR:
			case E_COMPILE_WARNING:
			case E_USER_ERROR:
				$type_erreur = "Erreur";
				break;
	
			case E_WARNING:
				$type_erreur = "Avertissement";
				break;
			case E_USER_WARNING:
				$type_erreur = "Avertissement";
				break;
	
			case E_NOTICE:
			case E_USER_NOTICE:
			case 8:
				$type_erreur = "Notice";
				$save = 0;
				break;
	
			case E_STRICT:
				$type_erreur = "Syntaxe Obsolète";
				break;
	
			default:
				$type_erreur = "Erreur inconnue";
		}

		$erreur = date("d.m.Y H:i:s") . " > " . $_SERVER['REQUEST_URI'] . " - " . $cat . "_" . $type_erreur. " : " . $message . " ligne " . $ligne . " (" . $fichier . ")\n";
		
		if($save == 1){ 
			$this->addlog($prefixe_log,$erreur);
		}
	}
	
	// 
	public function addlog($prefixe_log,$erreur) {
        
        global $thisSite;
        
		if($adminActive ==true) { $prefixe="adm_"; $path="../"; } else { $prefixe=""; $path=""; }
		// Enregistrement de l'erreur dans un fichier txt
		$file_log = $path . $thisSite->DOS_LOGS . $prefixe . 'logs' . $prefixe_log . "_"  . date('Y-m-d') . '.txt';
		$handle = @fopen($file_log, "a");
		//
		if($handle){
			$xx=fwrite($handle,$erreur);
			fclose($handle);
		}else{
			//echo("Erreur d'ouverture du fichier.");
			echoa("$erreur");
		}

		//$this->mail_send('no-reply@no-reply.com',$this->email_erreur,$erreur,'LOGS PDO SITE ' . $thisSite->RACINE . " : " . $type_erreur );
	}
	
	// Envoi un mail avec une template prédéfinie
	private function mail_send($from, $email, $content, $objet){
        
        global $thisSite;
        
		$message = $content;
		$headers = "From: ".$from."\n"."MIME-Version: 1.0"."\n"."Content-type: text; charset=utf-8"."\n";
		$mail_subject = "=?utf-8?B?". base64_encode($objet) ."?=";
		
		return mail($email, $objet, $message, $headers);
	}
	
	
} // Logs

//// Initialisation des logs
$gestionLogs = new gestionLogs();

/////////////////////////////////////////////// ERREUR PHP

function erreursPHP($type, $message, $fichier, $ligne) {
	global $gestionLogs;

	$gestionLogs->erreursPHP("err",$type, $message, $fichier, $ligne); 
}

function exceptionsPHP($exception) {
	global $gestionLogs;
	$gestionLogs->erreursPHP("excep",E_USER_ERROR, $exception->getMessage(), $exception->getFile(), $exception->getLine()); 
}

function erreursFatalesPHP() {
	global $gestionLogs;

	if(is_array($e = error_get_last()))	{
		if(isset($e['type'])){$type = $e['type'];}else{$type = 0;}
		if(isset($e['message'])){$message = $e['message'];}else{$message = '';}
		if(isset($e['file'])){$fichier = $e['file'];}else{$fichier = '';}
		if(isset($e['line'])){$ligne = $e['line'];}else{$ligne = '';}

		if ($type > 0){$gestionLogs->erreursPHP("fatal",$type, $message, $fichier, $ligne); }
	}
}
?>