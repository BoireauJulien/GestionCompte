$(document).ready(function(){
	var gestionCards = document.getElementsByClassName('gestionCard');
	var gestionBtns = document.getElementsByClassName('btnGestion');
	var gestionForms = document.getElementsByClassName('gestionForm');
	var cardsLength = gestionCards.length;
	var indexFormActive = -1;
	var isAnimated = false;
	
	for(var i = 0; i < cardsLength; i++){
		$(gestionCards[i]).on('click', showFormActive(i));
	}
	
	for(var i = 0; i < cardsLength; i++){
		$(gestionBtns[i]).on('click', showFormActive(i));
	}
	
	function showFormActive(index){
		return function(){
			if(indexFormActive == index){return;}
			
			if($('.containerForm').css('display') == 'none'){
				$('.containerForm').show();
				$('.gestionCard').hide();
				$('.btnGestion').show();
			}
			if(!isAnimated){
				isAnimated = true;
				$(gestionBtns[indexFormActive]).css({
					'background-color': 'rgb(100,100,100)'
				});
				
				$(gestionBtns[index]).css({
					'background-color': 'rgb(232,0,179)'
				});
				
				if(indexFormActive == -1){
					$(gestionForms[index]).animate({
						'top': '0%'
					}, 400, function(){
						isAnimated = false;
					});
				} else {
					$(gestionForms[indexFormActive]).animate({
						'top': '101%'
					}, 400, function(){
						isAnimated = false;
						$(gestionForms[index]).animate({
							'top': '0%'
						}, 400);
					});
				}
				indexFormActive = index;
			}
			
		}
	}
});