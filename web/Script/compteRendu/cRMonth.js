$(document).ready(function(){
	var windowHeight = $(window).height();
	var monthBtns = document.getElementsByClassName('filterMonth');
	carteStyle();
	
	for(var i = 0; i < monthBtns.length; i++){
		var indexMonth = i + 1;
		$(monthBtns[i]).on('click', showCarte(indexMonth));
	}
	
	window.onresize = function()
	{
		var windowHeight = $(window).height();
		carteStyle();
	}
	
	function carteStyle()
	{
		var carteHeight = (2/5) * windowHeight;
		var carteWidth = (3/4) * carteHeight;
		var mcdContentHeight = (3/10)*carteHeight;
		var leftmcdContent = (carteWidth - mcdContentHeight)*(1/2);
		var fontSizeMCD = (1/14) * carteHeight;
		var topMCD = (mcdContentHeight - fontSizeMCD - 5) * (1/2);
		
		$('.carteMM').css({
			'height': carteHeight + 'px',
			'width': carteWidth + 'px'
		});
		
		$('.MCDContent').css({
			'height' : mcdContentHeight + 'px',
			'width' : mcdContentHeight + 'px',
			'left' : leftmcdContent + 'px'
		});
		
		$('.contentMCDCenter').css({
			'font-size': fontSizeMCD + 'px',
			'top': topMCD
		});
	}
	
	function showCarte(monthIndex)
	{
		return function()
		{
			var cartes = document.getElementsByClassName('carteFill');
			var months = document.getElementsByClassName('monthIndex');
			var isCarte = false;
			var isAnimated = false;
			
			$('.containerSelection').hide();
			$('.filterMonth').css({
				'color': 'black'
			});
			$(monthBtns[monthIndex - 1]).css({
				'color': 'rgb(0,150,200)'
			});
			
			for(var i = 0; i < cartes.length; i++){
				if($(months[i]).text() == monthIndex){
					$(cartes[i]).fadeIn(600);
					isCarte = true;
					$('.carteEmpty').hide();
				} else {
					$(cartes[i]).hide();
				}
			}
			
			if(!isCarte){
				$('.carteEmpty').hide();
				$('.carteEmpty').fadeIn(600);
			}
		}
	}
});