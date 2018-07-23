var soldeContainers = document.getElementsByClassName('containerSolde');
var viewContainers = document.getElementsByClassName('containerHugeView');
var compteBtns = document.getElementsByClassName('choiceCompteBtn');
var rows = document.getElementsByClassName('rowScreenAccueil');

$(document).ready(function(){
	var compteLength = compteBtns.length;
	var windowHeight = $(window).height();
	var indexItemActive = 0;
	var colorRowActive;
	var indexRowActive;
	var topValue = 0;
	var littleViewHeight = (57.5/100) * windowHeight;
	
	$('.containerLittleView').css({
		'height': littleViewHeight + 'px'
	});
	initiateRowScreenAccueilHeight();
	$(compteBtns[0]).css({
		'background-color': 'rgb(70,178,206)'
	});
	
	initiateContainerViews();
	
	$('.containerLittleView').on('mousewheel', function(event, delta, deltaX, deltaY){
		// HAUT OU DROITE:
		if(deltaY < 0 || deltaX < 0){
			scrollLongContainer('top', 15);
		//BAS OU GAUCHE:
		}else if( deltaY > 0 || deltaX > 0){
			scrollLongContainer('down', 15);
		}
	});
	
	for( var i = 0; i < compteLength; i++){
		$(compteBtns[i]).on('click', showCompteItems(i));
	}
	
	window.onresize = function(){
		windowHeight = $(window).height();
		littleViewHeight = (60/100) * windowHeight;
		$('.containerLittleView').css({
			'height': littleViewHeight + 'px'
		});
		
		initiateRowScreenAccueilHeight();
	}
	
	function scrollLongContainer(direction, increment){
		var maxTop = $('.containerLittleView').height()-$(viewContainers[indexItemActive]).height();
		if(direction == 'top'){
			if(topValue > maxTop){
				topValue -= increment;
			}
		}else{
			if(topValue < 0){
				topValue += increment;
			}
		}
		$(viewContainers[indexItemActive]).css({
			'top': topValue +'px'
		});
	}
	
	function showCompteItems(index)
	{
		return function(){
			if(($(soldeContainers[index]).css('display') == 'none') && ($(viewContainers[index]).css('display') == 'none')){
				hideCompteItems();
				$(compteBtns[index]).css({
					'background-color': 'rgb(70,178,206)'
				});
				$(soldeContainers[index]).show();
				$(viewContainers[index]).show();
				indexItemActive = index;
				topValue = 0;
			}
		}
	}
	
	function hideCompteItems()
	{
		$(compteBtns[indexItemActive]).css({
			'background-color': 'transparent'
		});
		$(soldeContainers[indexItemActive]).hide();
		$(viewContainers[indexItemActive]).hide();
	}
	
	function initiateContainerViews()
	{
		$(soldeContainers[0]).show();
		$(viewContainers[0]).show();
	}
	
	function initiateRowScreenAccueilHeight()
	{
		var rowHeight = (9.2/100) * littleViewHeight;
		$('.rowScreenAccueil').css({
			'height': rowHeight + 'px'
		});
	}
});