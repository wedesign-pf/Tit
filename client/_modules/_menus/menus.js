$(document).ready(function () {

	var dropdownHam=0;
	$('input#dropdownHam').click(function (e) { 
		if(dropdownHam==0) { 
        $("#main").addClass('overlay-open');
           // $('#menuFull').slideDown(500, function() { $('#navigation').fadeIn(500); $("#btnHam").addClass('opened'); });
           
            $("#menuFull").animate({width: 'toggle'},500,"swing",function() { $("#btnHam").addClass('opened'); $('#navigation').fadeIn(500);  });
			dropdownHam=1;
		} else {
            
         //   $('#navigation').fadeOut(500, function() { $('#menuFull').slideUp(500); $("#btnHam").removeClass('opened'); });
            $('#navigation').fadeOut(500, function() {$("#btnHam").removeClass('opened'); $("#main").removeClass('overlay-open'); $("#menuFull").animate({width: 'toggle'},500,"swing");  });
			dropdownHam=0;
		}
		
	});

	$( "#menuP" ).find( "a" ).click(function (e) { 
		//if(dropdownHam==1) { 
        //    if($(this).attr('data-type')!="nolink") { $('#menuFull').slideUp(); }
      //  }
        //$("#btnHam").removeClass('opened');
		//dropdownHam=0;
	});
    

    $( '#menuP li:has(ul)' ).doubleTapToGo();
    

});	


// Utilisé lors du click dans le menu principal
var offsetHeader=100;
	
function scrollToAnchor($this){

	var aid= $this.attr('href');
	var parts = aid.split("#");
    var trgt = parts[1];

    var aTag = $("a[id='wp_"+ trgt +"']");

    $('html,body').animate({scrollTop: aTag.offset().top-offsetHeader}, 1000);

}

// Utilisé lors du défilement de la page
function changeAnchor($this){

	var rub= $this.attr('rub');

	$( "#menu_principal" ).find( "a" ).removeClass( "a_rub_actif" );
	$( "#menu_principal" ).find( "a" ).addClass( "a_rub" );

	$("#a_rub"+rub).addClass( "a_rub_actif" );

}

// Utilisé lors du chargement de la page, si Ancre existe
function scrollToAnchor2(){

	if(window.location.hash!="") {
		var parts = window.location.hash.split("#");
		var trgt = parts[1];
	
		var aTag = $("a[id='wp_"+ trgt +"']");

		$('html,body').animate({scrollTop: aTag.offset().top-offsetHeader}, 1000);	

	}

}


/*
	By Osvaldas Valutis, www.osvaldas.info
	Available for use under the MIT License
*/
;(function( $, window, document, undefined )
{   
	$.fn.doubleTapToGo = function( params )
	{
		if( !( 'ontouchstart' in window ) &&
			!navigator.msMaxTouchPoints &&
			!navigator.userAgent.toLowerCase().match( /windows phone os 7/i ) ) return false;

		this.each( function()
		{
			var curItem = false;

			$( this ).on( 'click', function( e )
			{
                    
				var item = $( this );
				if( item[ 0 ] != curItem[ 0 ] )
				{
					e.preventDefault();
					curItem = item;
				}
			});

			$( document ).on( 'click touchstart MSPointerDown', function( e )
			{ 
				var resetItem = true,
					parents	  = $( e.target ).parents();

				for( var i = 0; i < parents.length; i++ )
					if( parents[ i ] == curItem[ 0 ] )
						resetItem = false;

				if( resetItem )
					curItem = false;
			});
		});
		return this;
	};
})( jQuery, window, document );