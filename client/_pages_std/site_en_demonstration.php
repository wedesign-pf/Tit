<?php 
include_once("init.php");
include($thisSite->DOS_BASE_FCT . "fonctions_all.php");
@include($thisSite->DOS_BASE . "lang/" . $thisSite->current_lang .".php");
?>
<?php 
$email_webmaster = getEmail('webmaster');

$msg="";
$affich_form="oui";

if(!isset($_SESSION["tentatives"])) { $_SESSION["tentatives"]=0; }

if(isset($__POST["action"]) && $__POST["action"] == "valid_form"){
	
	$mySelect = new mySelect(__FILE__);
	$mySelect->tables= $thisSite->PREFIXE_TBL_ADM . "administrateurs";
	$mySelect->fields="*";
	$mySelect->where="login=:login AND mdp>=:mdp AND actif=1";
	$mySelect->whereValue["login"]=array($__POST['identifiant'],PDO::PARAM_STR);
	$mySelect->whereValue["mdp"]=array(md5($__POST['password']),PDO::PARAM_STR);
	$result=$mySelect->query();

	if(count($result)==1) {
		$row = current($result); 
		$check = "ok";
		$affich_form="non";
		$_SESSION["login_OK"]=$row["login"];
		$_SESSION["is_logged_OK"]="oui";
		$_SESSION['nom_OK']=$row["titre"];
		$_SESSION['id_OK']=$row["id"];
		$_SESSION['privilege_OK']=$row["privilege"];
		$ltemp = explode(",",$row["langues"]);
		echo("<script>window.location.href=window.location.href</script>");
	} else {
		$smarty->assign("msgErreur", $datas_lang["erreuridentification"]);
		$_SESSION["tentatives"]++;
		if ($_SESSION["tentatives"]>2) {
			echo("Nombre maximum de tentatives atteint.");
			exit;
		}
	}
	
	if ($check != "ok") {
		$affich_form="oui";
		$msg="Identifiant ou Mot de passe invalide";
	}
}
if($affich_form == "oui") {?>
<html>
<head>
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<style>
*,
*:after,
*:before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0;
    margin: 0;
}

.clearfix:after {
    content: "";
    display: table;
    clear: both;
}

body {
	background-color: #f080a4;
	background-image: url(commun/css/fond_repeat.png);
	background-repeat: repeat;
	font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
	font-size: 12px;
	color: #404040;
}

a {
	color: #000;
	text-decoration: none;
}
a:hover{

	text-decoration: underline;
}


#container {
	position: absolute;
	top: 50%;
	left: 50%;
	margin: -150px 0 0 -230px;
	width: 460px;
	background-color: rgba(255,255,255,0.85);
	padding:10px 15px;
	text-align:center;
}

.form-2 {
	/* Size and position */
	margin: auto;
	padding: 10px;
	position: relative;
}

.form-2 h1 {
    font-size: 14px;
    font-weight: bold;
    color: #E1014A;
    padding-bottom: 8px;
    border-bottom: 1px solid #EBE6E2;

}

.form-2 .float {
    width: 50%;
    float: left;
    padding-top: 15px;

}

.form-2 .float:first-of-type {
    padding-right: 15px;
}

.form-2 .float:last-of-type {
    padding-left: 5px;
}

.form-2 label {
    display: block;
    padding: 0 0 5px 2px;
    cursor: pointer;

    font-weight: 400;
    font-size: 11px;
}



.form-2 input[type=text],
.form-2 input[type=password] {
    font-size: 13px;
    font-weight: 400;
    display: block;
    width: 100%;
    padding: 5px;
    margin-bottom: 5px;
    border: 3px solid #ebe6e2;
    border-radius: 5px;
    -webkit-transition: all 0.3s ease-out;
    -moz-transition: all 0.3s ease-out;
    -ms-transition: all 0.3s ease-out;
    -o-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
}

.form-2 input[type=text]:hover,
.form-2 input[type=password]:hover {
    border-color: #CCC;
}

.form-2 label:hover ~ input {
    border-color: #CCC;
}

.form-2 input[type=text]:focus,
.form-2 input[type=password]:focus {
    border-color: #BBB;
    outline: none; /* Remove Chrome's outline */
}

.form-2 input[type=submit] {
    /* Size and position */
	width: 90%;
    height: 30px;

    position: relative;

   
    border-radius: 3px;
    cursor: pointer;

    /* Font styles */

    font-size: 13px;
    line-height: 30px; /* Same as height */
    text-align: center;
    font-weight: bold;

    margin-right: 15px;
	
    background: #E1014A; 

    border: none;
    color: #fff;
}

.form-2 input[type=submit]:hover {
background: #F080A4; 
}

.form-2 p:last-of-type {
    clear: both;    
}

.form-2 .opt {
    text-align: right;
    margin-right: 3px;
}

.form-2 label[for=showPassword] {
    display: inline-block;
    font-size: 11px;
    font-weight: 400;
s
}

.form-2 input[type=checkbox] {
    vertical-align: middle;
    margin: -1px 5px 0 1px;
}
</style>
</head>
<body>
<?php if ($_SESSION["tentatives"]>2) {
	echo("Nombre maximum de tentative atteint. Veuillez fermer votre navigateur pour faire de nouveaux essais");
	exit;
}
?>&nbsp;
<div id="container">
			<section class="main">
				<form class="form-2" action="" method="post">
                <input type="hidden" name="action" value="valid_form">
					<h1><span class="log-in">SITE EN CONSTRUCTION -SITE UNDER CONSTRUCTION</span></h1>
					<p class="float">
						<label for="identifiant">IDENTIFIANT</label>
						<input type="text" name="identifiant" placeholder="">
					</p>
					<p class="float">
						<label for="password">MOT DE PASSE</label>
						<input type="password" name="motdepasse" placeholder="" class="showpassword">
					</p>
					<p class="clearfix">
                    <p class="float">
                    <input type="submit" name="submit" value="ENVOYER">
                    </p> 
                    <p class="float" style="text-align:right; line-height:30px;">
                    <a class="text" href="mailto:<?php echo $email_webmaster[0]; ?>?subject=Mot de passe oublié&amp;body=Indiquez votre identifiant: ">Mot de passe oublié ?</a>
						</p>
					</p><p class="clearfix text">
                        <font color="#FF0000"><?php echo $msg;?></font>
                        </p>
				</form>​​
			</section>
			<div id="copyright"><?php echo($datas_lang["copyright_author"]); ?></div>
        </div>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript">
			$(function(){
			    $(".showpassword").each(function(index,input) {
			        var $input = $(input);
			        $("<p class='opt'/>").append(
			            $("<input type='checkbox' class='showpasswordcheckbox' id='showPassword' />").click(function() {
			                var change = $(this).is(":checked") ? "text" : "password";
			                var rep = $("<input placeholder='Password' type='" + change + "' />")
			                    .attr("id", $input.attr("id"))
			                    .attr("name", $input.attr("name"))
			                    .attr('class', $input.attr('class'))
			                    .val($input.val())
			                    .insertBefore($input);
			                $input.remove();
			                $input = rep;
			             })
			        ).append($("<label for='showPassword'/>").text("Voir le mot de passe")).insertAfter($input.parent());
			    });

			});
		</script>
</body>
</html>
<?php } ?>