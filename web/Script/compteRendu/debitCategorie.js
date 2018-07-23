$(document).ready(function(){
	var compteBtns = document.getElementsByClassName('compteBtn');
	var containerCards = document.getElementsByClassName('containerCards');
	var monthBtns = document.getElementsByClassName('filterMonth');
	var cartes = document.getElementsByClassName('carteFill');
	var monthYearRows = document.getElementsByClassName('rowMY');
	var currentDate = new Date();
	var currentMonth = currentDate.getMonth();
	var currentYear = currentDate.getFullYear();
	var isAnimated = false;
	
	initiateCompteBtn();
	initiateMonthBtn();
	setWidthPercent();
	
	for(var i = 0; i < compteBtns.length; i++){
		setCompteBtnWidth(i);
		$(compteBtns[i]).on('click', clickCompteBtn(i));
	}
	
	for(var i = 0; i < monthBtns.length; i++){
		$(monthBtns[i]).on('click', clickMonthBtn(i));
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
	
	function setCompteBtnWidth(index)
	{
		var width = 100/compteBtns.length;
		$(compteBtns[index]).css({
			'width': width + '%'
		});
	}
	
	function clickMonthBtn(index)
	{
		return function()
		{
			var month = index + 1;
			
			if(!isAnimated){
				var isCarte = false;
				isAnimated = true;
				$('.carteMC').hide();
				
				$('.filterMonth').css({
					'color': 'rgb(0,0,0)'
				});
				$(monthBtns[index]).css({
					'color': 'rgb(0,150,169)'
				})
				
				for(var j = 0; j < cartes.length; j++){
					if($(monthYearRows[j]).text().trim() == month + '' + currentYear){
						$(cartes[j]).fadeIn(300, function(){
							isAnimated = false;
						});
						isCarte = true;
					}
				}
				if(!isCarte){
					isAnimated = false;
				}
			}
		}
	}
	
	function initiateMonthBtn()
	{
		$(monthBtns[currentMonth]).css({
			'color': 'rgb(0,150,169)'
		});
		
		var month = currentMonth + 1;
		for(var j = 0; j < cartes.length; j++){
			if($(monthYearRows[j]).text().trim() == month + '' + currentYear){
				$(cartes[j]).show();
			}
		}
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