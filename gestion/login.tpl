<html xmlns="http://www.w3.org/1999/xhtml" lang="{$thisSite->current_lang}">
<head>
<meta charset="utf-8">
<TITLE>{$page_tag_title}</TITLE>
<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />{* Empeche IE de se mettre en mode de compatibilité et active Chrome Frame dans IE si existe *}
<![endif]-->
<base href="{$thisSite->RACINE}{$thisSite->DOS_ADMIN}" target="_self" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--CSS BASE-->
<link href="{$smarty.const.DOS_BASE_ADMIN}css/reset.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}font-awesome.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}structure.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}responsive.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}sky-forms.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}multiple-select.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}jBox.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}jBox_themes/NoticeBorder.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}colorbox.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}style.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.DOS_SKIN_ADMIN}menus.css" rel="stylesheet" type="text/css" />
{if $addCssStructure[0] ne ""}
{foreach $addCssStructure as $elt}
<link href="{$elt}" rel="stylesheet" type="text/css" />
{/foreach}
{/if}
<!--[if lt IE 9]>
	<link href="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/css/sky-forms-ie8.css" rel="stylesheet" type="text/css" />
<![endif]-->
<!--JS BASE-->
<!--[if lt IE 9]>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERY1}"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERY2}"></script>
<![endif]-->
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/{$thisSite->JQUERYM}"></script>
<script type="text/javascript" src="{$thisSite->RACINE}{$thisSite->DOS_BASE}js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_BASE_ADMIN}js/scripts.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}jBox/jBox.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.form.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.validate.addMethod.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.modal.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/additional-methods.min.js"></script>
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.simplyCountable.js"></script>
{if $myAdmin->LANG_ADMIN eq "fr"}<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/lang/messages_fr.js"></script>{/if}
{if $myAdmin->LANG_ADMIN eq "fr"}<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/lang/datepicker-fr.js"></script>{/if}
<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}colorbox/jquery.colorbox-min.js"></script>
<!--[if lt IE 10]>
	<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/jquery.placeholder.min.js"></script>
<![endif]-->	
<!--[if lt IE 9]>
	<script type="text/javascript" src="{$smarty.const.DOS_OUTILS_ADMIN}skyforms/js/sky-forms-ie8.js"></script>
<![endif]-->
{if $addJsStructure[0] ne ""}
<!--JS CLIENT-->
{foreach $addJsStructure as $elt}
<script type="text/javascript" src="{$elt}"></script>
{/foreach}
{/if}

</head>
<style>
html, body {
	background-color: #9acee0;
}
a {
	text-decoration: underline;
}
a:hover {
	text-decoration: none;
}


.body-s {
    margin-top:15%;
	padding: 20px;
	max-height:280px;
	max-width: 400px;
	background: rgba(255,255,255,0.5);vertical-align: middle;
}


.sky-form .bloc {
    display: block;
    padding: 20px 30px;
    border-top: 1px solid #fcfcfc;
    background: #ffffff;
}

.note {
 float:right;
}
.sky-form .button {
	display:block;
	float:left;
	margin:0;
	margin-top:10px;
}
@media screen and (max-width: 600px) {
	.body {
		padding: 10px;
	}
}
</style>
<body>

<section class="flex-container-v" style="vertical-align: middle;">
		<div class="body-s center w50">
			<form action="" method="post" class="sky-form" id="sky-form">
				<input type="hidden" name="token" id="token" value="{$datas_page.token}"/>
				<legend>Identification</legend>
				<div class="bloc">	
					<label class="input">
						<i class="icon-append fa fa-15x fa-user"></i>
						<input type="identifiant" name="identifiant" placeholder="{$datas_lang.identifiant}">
					</label>
					<div class="clear pts"></div>
					<label class="input">
						<i class="icon-append fa fa-lock"></i>
						<input type="password" name="password" placeholder="{$datas_lang.motdepasse}">
					</label>
					<div class="note">
						<a class="text" href="mailto:{$email_webmaster}?subject=Mot de passe oublié&amp;body=Indiquez votre identifiant: ">{$datas_lang.motdepasseoublie}</a>
					</div>
					<div class="clear"></div>
					<button type="submit" class="button">{$datas_lang.valider}</button>
					<div class="clear pts" style="color: red;">{$msgErreur}</div>
				</div>
			</form>			
		</div>
        </section>

		<script type="text/javascript">
			$(function()
			{
				// Validation for login form
				$("#sky-form").validate(
				{					
					// Rules for form validation
					rules:
					{
						identifiant:
						{
							required: true
						},
						password:
						{
							required: true,
							minlength: 3,
							maxlength: 20
						}
					},
					
					// Ajax form submition					
					submitHandler: function(form)
					{
						form.submit();
					},		
					
					// Do not change code below
					errorPlacement: function(error, element)
					{
						error.insertAfter(element.parent());
					}
				});

			});			
		</script>
	</body>
</html>