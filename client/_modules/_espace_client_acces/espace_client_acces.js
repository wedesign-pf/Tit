
$(document).ready(function () {
    
    $("#mdp_oublie_sended").hide();
    $(".msgErr").hide();
	
	$('#envoyer_acces').click(function (e) { 
		e.preventDefault();
		
		var erreur=""; 
		var $scTop="";
        $(".msgErr").hide();
        $(".msgErr").html('');
        
        if($('#login').val()=="" ) { $("#err_login").html("Obligatoire");  $("#err_login").show(); erreur=1; }
        if($('#mdp').val()=="" ) { $("#err_mdp").html("Obligatoire");  $("#err_mdp").show(); erreur=1; }
        
        //erreur=""; 
		if(erreur==1)  { 
        
        } else {
			$(".msgErr").hide();
			$("#envoyer_acces").hide();
			$("#loading").show();

			$.ajax({
				type: "POST",
				url: 'client/_modules/espace_client_acces/validation.php',
				data:$('#form_acces').serialize(),
				dataType: 'json',
					success: function(json) {
                        if(json.reponse==1) {
                          $( "#form_acces" ).submit();
                          //window.parent.location.reload();  
                        } else if(json.reponse==-1) {
                            $("#envoyer_acces").show();
                            $("#loading").hide();
                            $("#err_acces").html("Nombre maximal de tentatives dépassé");
                            $("#err_acces").show();
                        } else if(json.reponse==0) {
                            $("#envoyer_acces").show();
                            $("#loading").hide();
                            $("#err_acces").html("Identifiant ou Mot de passe invalide");
                            $("#err_acces").show();
                        }
					}
			});
		}
	});
    
    
    $('#mdp_oublie').click(function (e) { 
		e.preventDefault();
		$("#form_acces").hide();
		$("#form_mdp_oublie").show();
	});
    
    
    $('#envoyer_mpd_oublie').click(function (e) { 
		e.preventDefault();
		
		var erreur=""; 
		var $scTop="";
        $(".msgErr").hide();
        $(".msgErr").html('');
        
        if($('#email_lost').val()=="") { 
			$("#err_email_lost").html("Obligatoire"); $("#err_email_lost").show();
            erreur=1; 
		} else if (checkemail($('#email_lost').val())==false) { 
            $("#err_email_lost").html("Invalide"); $("#err_email_lost").show();
            erreur=1; 
		}
        
        //erreur=""; 
		if(erreur==1)  { 
        
        } else {
			$(".msgErr").hide();
			$("#envoyer_mpd_oublie").hide();
			$("#loading_mpd_oublie").show();

			$.ajax({
				type: "POST",
				url: 'client/_modules/espace_client_acces/validation_mpd_oublie.php',
				data:$('#form_mdp_oublie').serialize(),
				dataType: 'json',
					success: function(json) {
                        if(json.reponse==0) {
                            $("#envoyer_mpd_oublie").show();
                            $("#loading_mpd_oublie").hide();
                            $("#err_mdp_oublie").html("Email inconnu");
                            $("#err_mdp_oublie").show();
                        } else {
                            $(".msgErr").hide();
                            $("#form_acces").show();
		                    $("#form_mdp_oublie").hide();
                            $("#mdp_oublie_sended").html("Vous avons envoyé un message avec les instructions à suivre.");
                            $("#mdp_oublie_sended").show();
                        }
					}
			});
		}
	});


});