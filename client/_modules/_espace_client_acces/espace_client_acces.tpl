<div style="margin:10px 30px; ">
    <div style="padding:10px 0px; border-bottom:1px solid rgba(0,79,159,1)">
        <div class="row" >
         <div class="col w50"><img src="{$thisSite->DOS_CLIENT_FILES}logo2.png"  /></div>
         <div class="col  txtright" style="vertical-align:middle;"><h5 class="miBold" style="margin:0; padding:0; display:inline;">Votre <b>Espace Client</b></h5></div>
        </div>
    </div>
    <div class="ptm">
        <div class="fl w50 tiny-w100">
            <form action="{$thisSite->pages.7.page_url}" method="post" target="_parent" class="formulaire w90 tiny-w100" id="form_acces">
                <input name="envoyer" type="hidden" id="envoyer" value="1" />
                <input type="hidden" name="token" id="token" value="{$datas_page.token}"/>
                <div class="legBloc mbm">Identifiez-vous</div>
                <div class="mbm">
                    <label>Identifiant<div id="err_login" class="msgErr"></div></label>
                    <input name="login" type="text" id="login" value="{$login}" maxlength="20" class="w100" />
                </div>
                <div class="mbs">
                    <label>Mot de passe<div id="err_mdp" class="msgErr"></div></label>
                    <input name="mdp" type="password" id="mdp" value="{$mdp}" maxlength="20" class="w100" />
                </div>
                <div id="err_acces" class="msgErr clear mbs"></div>
                <div class="line clear mts">
                    <span id="loading" style="display:none; float:left; margin-right:15px;"><img src="{$thisSite->skinImages}loaders/143.gif" width="20" /></span><div id="envoyer_acces" class="bouton-N btn_submit w80" >Valider</div>
                    
                </div>
                
                <div id="mdp_oublie" class="clear mts">Mot de passe oublié ?</div><div id="mdp_oublie_sended" class=" clear mts"></div>
            </form>
            
            <form method="post" class="formulaire w90 tiny-w100" id="form_mdp_oublie" style="display:none">
                <input name="envoyer" type="hidden" id="envoyer" value="1" />
                <input type="hidden" name="token" id="token" value="{$datas_page.token}"/>
                <div class="legBloc mbm">Mot de passe oublié ?</div>
                <div class="mbm">
                    <label>Email<div id="err_email_lost" class="msgErr"></div></label>
                    <input name="email_lost" type="text" id="email_lost" value="{$POST_LIST.email_lost}" maxlength="255" class="w100" />
                </div>
                <div id="err_mdp_oublie" class="msgErr clear mbs"></div>
                <div class="line clear mts">
                    <span id="loading_mpd_oublie" style="display:none; float:left; margin-right:15px;"><img src="{$thisSite->skinImages}loaders/143.gif" width="20" /></span><div id="envoyer_mpd_oublie" class="bouton-N btn_submit w80" >M'envoyer les instructions par email</div>
                    
                </div>
                
            </form>
            
        </div>
        <div class="fl w50 tiny-w100 txtcenter"><br><br><br>
            <h5 class="txtcenter">Tu ne possedes pas encore d’espace client ?</h5>
            <div class="pas"><a href="{$thisSite->pages.12.page_url}" target="_parent" class="bouton-N w80" style="display:block; margin:0 auto; color: #fff; text-decoration: none; text-transform: uppercase;">Créer un compte</a></div>
        </div>
    </div>
</div>
