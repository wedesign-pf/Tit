function submitFiltres() {
	$( "#formFiltres" ).submit(); 
}

function submitList() {
	$( "#formList" ).submit(); 
}

// met en majuscule la première lettre d'une chaine
function ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

function ucfirst(str) {
    var firstLetter = str.substr(0, 1);
    return firstLetter.toUpperCase() + str.substr(1);
}


function getExtension(string,param) {
	re = /(?:\.([^.]+))?$/;
	ext = re.exec(string)[1];
	
	if(param=='image' && ext!='jpg' && ext!='jpeg' && ext!='png' && ext!='gif') {
		return '';
	}
	
	return ext;

}


function show_notification(a,b) {
	if(a=="") return;
	new jBox('Notice', {
		content: a,
		addClass:b
	});
}

function ctype_alnum (text) {
    // http://kevin.vanzonneveld.net
   return true;
}

function sanitize_string(chaine) {

	chaine = chaine.toLowerCase();
	chaine = strtr(chaine, "+", "-");
	chaine = strtr(chaine, " ", "-");
    chaine=strtr(chaine,"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ","aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn");
    chaine=strtr(chaine,"&~#{([|`\^])}$¤£µ*ù%§!:;,?<>.°\"","");
	chaine=strtr(chaine,"/","-");
	chaine=strtr(chaine,"'","-");
	chaine=strtr(chaine,"'","-");
	chaine=strtr(chaine,"\\","-");
	chaine=chaine.replace(/-+/g,'-');
	chaine=chaine.replace(/_+/g,'_');
	
	return (chaine);
}


function strtr (str, from, to) {
    // http://kevin.vanzonneveld.net
    // +   original by: Brett Zamir (http://brett-zamir.me)
    // +      input by: uestla
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Alan C
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +      input by: Taras Bogach
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // +      input by: jpfle
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // -   depends on: krsort
    // -   depends on: ini_set
    // *     example 1: $trans = {'hello' : 'hi', 'hi' : 'hello'};
    // *     example 1: strtr('hi all, I said hello', $trans)
    // *     returns 1: 'hello all, I said hi'
    // *     example 2: strtr('äaabaåccasdeöoo', 'äåö','aao');
    // *     returns 2: 'aaabaaccasdeooo'
    // *     example 3: strtr('ääääääää', 'ä', 'a');
    // *     returns 3: 'aaaaaaaa'
    // *     example 4: strtr('http', 'pthxyz','xyzpth');
    // *     returns 4: 'zyyx'
    // *     example 5: strtr('zyyx', 'pthxyz','xyzpth');
    // *     returns 5: 'http'
    // *     example 6: strtr('aa', {'a':1,'aa':2});
    // *     returns 6: '2'
    var fr = '',
        i = 0,
        j = 0,
        lenStr = 0,
        lenFrom = 0,
        tmpStrictForIn = false,
        fromTypeStr = '',
        toTypeStr = '',
        istr = '';
    var tmpFrom = [];
    var tmpTo = [];
    var ret = '';
    var match = false;

    // Received replace_pairs?
    // Convert to normal from->to chars
    if (typeof from === 'object') {
        tmpStrictForIn = this.ini_set('phpjs.strictForIn', false); // Not thread-safe; temporarily set to true
        from = this.krsort(from);
        this.ini_set('phpjs.strictForIn', tmpStrictForIn);

        for (fr in from) {
            if (from.hasOwnProperty(fr)) {
                tmpFrom.push(fr);
                tmpTo.push(from[fr]);
            }
        }

        from = tmpFrom;
        to = tmpTo;
    }

    // Walk through subject and replace chars when needed
    lenStr = str.length;
    lenFrom = from.length;
    fromTypeStr = typeof from === 'string';
    toTypeStr = typeof to === 'string';

    for (i = 0; i < lenStr; i++) {
        match = false;
        if (fromTypeStr) {
            istr = str.charAt(i);
            for (j = 0; j < lenFrom; j++) {
                if (istr == from.charAt(j)) {
                    match = true;
                    break;
                }
            }
        } else {
            for (j = 0; j < lenFrom; j++) {
                if (str.substr(i, from[j].length) == from[j]) {
                    match = true;
                    // Fast forward
                    i = (i + from[j].length) - 1;
                    break;
                }
            }
        }
        if (match) {
            ret += toTypeStr ? to.charAt(j) : to[j];
        } else {
            ret += str.charAt(i);
        }
    }

    return ret;
}
//////////////////////////////////////////////////////////////////
/// GESTION DES VARIABLES DANS UN CHAMPS DE SAISIE
var last_focused="";
function have_focus(field) {

	if(field==undefined) {
		last_focused = document.activeElement.id; 
	} else {
		last_focused = field; 
	}
	//$("#liste_variables").show();
	
}

function loose_focus(field) {

	//	$("#liste_variables").hide();
}

function select_variables(zevar){ 

	if(last_focused!="") { 
		var zevar=document.getElementById('liste_variables').options[document.getElementById('liste_variables').selectedIndex].value;

		if(zevar!="") { 
			
			if( $("#"+last_focused).attr("type") == "CK") { // si editor CkEditor
				insertion(last_focused, zevar);
			} if( $("#"+last_focused).attr("type") == "TM") { // si Editor TinyMce
				tinyMCE.activeEditor.insertContent(zevar);
			} else { 
				$("#"+last_focused).insertAtCaret(zevar);
			}
		}
	}
	last_focused = "";
	document.getElementById('liste_variables').selectedIndex=0;
}

jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  })
}
});

// permet d'insérer un texte dans un autre texte à la position du curseur
function insertion(cinput, sel_var_inside) {
  var input = document.forms['formMaj'].elements[cinput];
  input.focus();
  /* pour l'Explorer Internet  */
  if(typeof document.selection != 'undefined') {
    /* Insertion du code de formatage */
    var range = document.selection.createRange();
    var insText = range.text;
    range.text = sel_var_inside;
    /* Ajustement de la position du curseur  */
    range = document.selection.createRange();
    if (insText.length == 0) {
      range.move('character', -sel_var_inside.length);
    } else {
      range.moveStart('character', sel_var_inside.length + sel_var_inside.length);
    }
    range.select();
  }
  /* pour navigateurs plus récents basés sur Gecko */
  else if(typeof input.selectionStart != 'undefined')
  {
    /* Insertion du code de formatage  */
    var start = input.selectionStart;
    var end = input.selectionEnd;
    var insText = input.value.substring(start, end);
    input.value = input.value.substr(0, start) + sel_var_inside + insText + input.value.substr(end);
    /* Ajustement de la position du curseur  */
    var pos;
    if (insText.length == 0) {
      pos = sel_var_inside + sel_var_inside.length;
    } else {
      pos = start + sel_var_inside.length + insText.length;
    }
    input.selectionStart = pos;
    input.selectionEnd = pos;
  }
  /* pour les autres navigateurs  */
  else
  {
    /* requête de la position d'insertion  */
    var pos;
    var re = new RegExp('^[0-9]{0,3}$');
    while(!re.test(pos)) {
      pos = prompt("Insertion à la position (0.." + input.value.length + "):", "0");
    }
    if(pos > input.value.length) {
      pos = input.value.length;
    }
    /* Insertion du code de formatage  */
    var insText = prompt("Veuillez entrer le texte à formater:");
    input.value = input.value.substr(0, pos) + sel_var_inside + insText + input.value.substr(pos);
  }
}
/// FIN GESTION DES VARIABLES DANS UN CHAMPS DE SAISIE
//////////////////////////////////////////////////////////////////
