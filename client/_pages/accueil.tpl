 <img src="loader_tit2.gif" width="60" height="50" alt=""/>
<select id="devise">
  <option value="1" selected data-symbol="DOL" >Dollars</option>
  <option value="0.85" data-symbol="EUR">Euros</option>
  <option value="1.33" data-symbol="XPF">Franc Pacific</option>
  
</select>
  <div>Package A: <span class="byCurrency" data-prix="10" ></span></div>
  <div>Package B: <span class="byCurrency" data-prix="2000" ></span></div>
  <div>Package C: <span class="byCurrency" data-prix="30000" ></span></div>
  
<script>
$(document).ready(function () {
   prixParDevise();
    
    $( "#devise" ).change(function() {
       prixParDevise();
    });

});	
    
function prixParDevise() {
    {if $thisSite->current_lang eq "fr"} numeral.language('fr'); {/if}
    
    var devise_taux=parseFloat($( "#devise option:selected" ).val());
    var devise_symbole=" " + $( "#devise option:selected" ).attr("data-symbol");
    
    $( ".byCurrency" ).each(function( index ) {
        prix=parseInt($( this ).attr("data-prix"));
        prix=numeral(prix*devise_taux).format('0,0');;
        $( this ).html(prix + devise_symbole);
    });
}
</script>
<hr>
<style>
table {
    border:0px;width:auto;
}

table td {
    font-size:12px; 
     border:0px;  
     border-bottom:2px dotted gold;
     padding:10px 20px;
}

.deus table {
    width:auto;
}
.deus table td {    
     border-bottom:2px dotted red;
}

</style>
<div class='animatedParent animateOnce' style="position:relative">
	<h2 class='animated bounceInDown'>It Works!</h2>
    <div class='animated bounceInDown' style="border:1px yellow solid; position:absolute; left:10px; top:50px;"><img src="client/skins/defaut/images/nophoto.png" width="150" alt=""/></div>
</div>
{for $foo=1 to 50}
    <div>Ligne {$foo}</div>
{/for}
<div class="animatedParent">
<div class="animated  fadeInUp" style="float:right"><img src="client/skins/defaut/images/nophoto.png" width="295" height="295" alt=""/></div>
<div class="prems animated fadeInLeft">{$texte1}</div>
</div>
<hr><hr><hr>
{for $foo=1 to 10}
    <div>Ligne {$foo}</div>
{/for}
<div class="animatedParent">
<div class="deus animated fadeInRight">AAAAAAA{$texte2}BBBBBBBBBB</div>
</div>
<br>
