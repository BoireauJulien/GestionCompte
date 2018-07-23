$(document).ready(function(){
	var currentYear = parseInt($('.selectYear').text());
	var windowHeight = $(window).height();
	var cartes = document.getElementsByClassName('carteFill');
	var years = document.getElementsByClassName('rowYear');
	carteStyle();
	defHeightGraphs();
	initiateCarteForCurrentYear();
	
		$('.lessBtn').on('click', function(){
			
			currentYear--;
			$('.selectYear').text(currentYear);
			switchCarte();
		});
	
		$('.moreBtn').on('click', function(){
			currentYear++;
			$('.selectYear').text(currentYear);
			switchCarte();
		});
	window.onresize = function()
	{
		windowHeight = $(window).height();
		carteStyle();
		defHeightGraphs();
	}
	
	function switchCarte()
	{
		var cartesDisplayed = [];
		var isCarte = false;
		
		$('.carteFill').hide();
		$('.carteEmpty').hide();
		for (var i = 0; i < cartes.length; i++){
			if(currentYear == parseInt($(years[i]).text())){
				cartesDisplayed.push($(cartes[i]));
				isCarte = true;
			}
		}
		if(!isCarte){
			cartesDisplayed.push($('.carteEmpty'));
		}
		$('.carteEmpty').hide();
		for (var i = 0; i < cartesDisplayed.length; i++){
			cartesDisplayed[i].fadeIn(600);
		}
	}
	
	function carteStyle()
	{
		var carteHeight = (2/5) * windowHeight;
		var carteWidth = (3/4) * carteHeight;
		
		$('.carteMY').css({
			'height': carteHeight + 'px',
			'width': carteWidth + 'px'
		});
	}
	
	function initiateCarteForCurrentYear(){
		for (var i = 0; i < cartes.length; i++){
			if(currentYear == parseInt($(years[i]).text())){
				$(cartes[i]).show();
			}
		}
	}
	
	function defHeightGraphs()
	{
		var arrayMontantC = document.getElementsByClassName('montantC');
		var arrayMontantD = document.getElementsByClassName('montantD');
		var arrayGraphD = document.getElementsByClassName('graphDebit');
		var arrayGraphC = document.getElementsByClassName('graphCredit');
		var arrayLength = arrayMontantC.length;
		
		for (var i = 0; i < arrayLength; i++){
			var montantC = parseInt($(arrayMontantC[i]).text());
			var montantD = -parseInt($(arrayMontantD[i]).text());
			var heightC = 0;
			var heightD = 0;
			
			if(montantC > montantD){
				heightC = 100;
				heightD = montantD * 100 / montantC;
			} else {
				heightD = 100;
				heightC = montantC * 100 / montantD;
			}
			
			$(arrayGraphC[i]).css({
				'height': heightC +'%'
			});
			$(arrayGraphD[i]).css({
				'height': heightD + '%'
			});
		}
		
	}
});