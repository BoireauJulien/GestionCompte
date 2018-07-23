$(document).ready(function(){
	var compteBtns = document.getElementsByClassName('compteBtn');
	var containerCards = document.getElementsByClassName('containerCards');
	var currentYear = parseInt($('.selectYear').text());
	var cartes = document.getElementsByClassName('carteFill');
	var years = document.getElementsByClassName('year');
	var isAnimated = false;
	
	initiateCompteBtn();
	initiateCarteForCurrentYear();
	setWidthPercent();
	
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
	
	for(var i = 0; i < compteBtns.length; i++){
		setCompteBtnWidth(i);
		$(compteBtns[i]).on('click', clickCompteBtn(i));
	}
	
	function initiateCarteForCurrentYear(){
		for (var i = 0; i < cartes.length; i++){
			if(currentYear == parseInt($(years[i]).text())){
				$(cartes[i]).show();
			}
		}
	}
	
	function switchCarte()
	{
		var isCarte = false;
		isAnimated = true;
		
		$('.carteFill').hide();
		for (var i = 0; i < cartes.length; i++){
			if(currentYear == parseInt($(years[i]).text())){
				$(cartes[i]).fadeIn(300, function(){
					isAnimated = false;
				});
				isCarte = true;
			}
		}
		if(!isCarte){
			isAnimated = false;
		}
	}
	
	function clickCompteBtn(index)
	{
		return function()
		{
			$('.containerCards').hide();
			$('.compteBtn').css({
				'background-color': 'rgb(0,153,170)'
			});
			$(containerCards[index]).show();
			$(compteBtns[index]).css({
				'background-color':'rgb(0,180,199)' 
			});
		}
	}
	
	function initiateCompteBtn()
	{
		$('.containerCards').hide();
		$('.compteBtn').css({
			'background-color': 'rgb(0,153,170)'
		});
		$(containerCards[0]).show();
		$(compteBtns[0]).css({
			'background-color':'rgb(0,180,199)' 
		});
	}
	
	function setCompteBtnWidth(index)
	{
		var width = 100/compteBtns.length;
		$(compteBtns[index]).css({
			'width': width + '%'
		});
	}
	
	function setWidthPercent()
	{
		var percents = document.getElementsByClassName('nbPercent');
		var nbPercents = document.getElementsByClassName('rowNbPercent');
		
		for (var i = 0; i < percents.length; i++){
			var nb = parseFloat($(nbPercents[i]).text());
			$(percents[i]).css({
				'width': nb + '%'
			});
		}
	}
});