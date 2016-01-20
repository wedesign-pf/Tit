// --------------------------
// Généralités
// --------------------------

/**
 * Get the value of a querystring
 * @param  {String} field The field to get the value of
 * @param  {String} url   The URL to get the value from (optional)
 * @return {String}       The field value
 */
var getQueryString = function ( field, url ) {
    var href = url ? url : window.location.href;
    var reg = new RegExp( '[?&]' + field + '=([^&#]*)', 'i' );
    var string = reg.exec(href);
    return string ? string[1] : null;
};


$.fn.inView = function(){
    //Window Object
    var win = $(window);
    //Object to Check
    obj = $(this);
    if(obj.length == 0) return false;
    
    //the top Scroll Position in the page
    var scrollPosition = win.scrollTop();
    //the end of the visible area in the page, starting from the scroll position
    var visibleArea = win.scrollTop() + win.height();
    
    var objHeight = 10; // obj.outerHeight()
    //the end of the object to check
    var objEndPos = (obj.offset().top + objHeight);
    return(visibleArea >= objEndPos && scrollPosition <= objEndPos ? true : false)
};

/*$(window).scroll(function(){
    if($("#googlsseMap").inView()) {
       loadGoogleMap();
        console.log("XA");
    } else {
        console.log("XB");
    }
});*/


function loadScript(scriptSrc) {
    var script = document.createElement("script");
    script.src = scriptSrc;
    script.type = "text/javascript";
    document.body.appendChild(script);
    //console.log("loadScript: " + scriptSrc);
}



// appel un lien à la place de la page en cours ou dans une nouvelle fenêtre
function goTargetLink(lien,cible) { 
	if(cible=="_self") {
		document.location.href= lien ;
	} else {
		window.open(lien);
	}
}


// met en majuscule la première lettre d'une chaine
function ucwords(str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
        return $1.toUpperCase();
    });
}

// vérification email
function checkemail(email){
    var reg = new RegExp('^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$', 'i');
	return(reg.test(email));
}

// vérification que des chiffres
function checkchiffres(chaine) { 
	var reg = new RegExp('[^0-9]+', 'g');
	if (reg.test(chaine)) {
		return false
	} else {
	 return true
	}
}


function randomBetween(min,max)  {
    return Math.floor(Math.random()*(max-min+1)+min);
}
