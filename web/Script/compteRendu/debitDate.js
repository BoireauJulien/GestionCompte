$( function() {
    $( "#datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
    
  } );
jQuery(function($){
	$.datepicker.regional['fr'] = {
		closeText: 'Fermer',
		prevText: '&#x3c;Préc',
		nextText: 'Suiv&#x3e;',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier','Fevrier','Mars','Avril','Mai','Juin',
		'Juillet','Aout','Septembre','Octobre','Novembre','Decembre'],
		monthNamesShort: ['Jan','Fev','Mar','Avr','Mai','Jun',
		'Jul','Aou','Sep','Oct','Nov','Dec'],
		dayNames: ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
		dayNamesShort: ['Dim','Lun','Mar','Mer','Jeu','Ven','Sam'],
		dayNamesMin: ['Di','Lu','Ma','Me','Je','Ve','Sa'],
		weekHeader: 'Sm',
		dateFormat: 'dd/mm/yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: '',
		
		maxDate: '+12M +0D',
		numberOfMonths: 1,
		showButtonPanel: true,
		onSelect: function(date){
			showCarte(date);
		}
		};
	$.datepicker.setDefaults($.datepicker.regional['fr']);
});



function showCarte(date)
{
	var cartes = document.getElementsByClassName('carteMD');
	var dates = document.getElementsByClassName('dateMD');
	var isCarte = false;
	for(var i = 0; i < cartes.length; i++){
		
		if($(dates[i]).text().trim() == date){
			$(cartes[i]).fadeIn(600);
			$('.noDC').hide();
			isCarte = true;
		} else {
			$(cartes[i]).hide();
		}
	}
	if(!isCarte){
		$('.noDC').hide();
		$('.noDC').fadeIn(600);
	}
}

$(document).ready(function(){
	var windowHeight = $(window).height();
	
	carteStyle();
	
	window.onresize = function()
	{
		windowHeight = $(window).height();
		
		carteStyle();
	}
	
	
	function carteStyle()
	{
		var carteHeight = windowHeight * (2/7);
		var carteWidth = carteHeight * (3/2);
		var montantWidth = (8/10) * carteWidth;
		var leftMontant = (carteWidth - montantWidth) * (1/2);
		var fontSizeMontant = carteHeight * (1/7);
		
		$('.carteDC').css({
			'height': carteHeight + 'px',
			'width': carteWidth + 'px'
		});
		
		$('.montantMD').css({
			'width': montantWidth + 'px',
			'left': leftMontant + 'px',
			'font-size': fontSizeMontant + 'px'
		});
		
		
		
	}
	
});