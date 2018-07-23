$(document).ready(function(){
	var opCards = document.getElementsByClassName('opCard');
	var opBtns = document.getElementsByClassName('opBtnCardL');
	var opForms = document.getElementsByClassName('opForm');
	var opDebitFields = document.getElementsByClassName('opDebitField');
	var opCreditFields = document.getElementsByClassName('opCreditField');
	var indexFormActive = -1;
	var indexFieldActive = 0;
	var opLength = opCards.length;
	var opFieldLength = opDebitFields.length;
	var isAnimated = false;
	
	
	
	initiateFieldActive();
	
	for (var i = 0; i < opLength; i++){
		$(opCards[i]).on('click', showFormActive(i));
	}
	
	for(var i = 0; i < opLength; i++){
		$(opBtns[i]).on('click', showFormActive(i));
	}
	
	$('.opDebitForm .opNav .btnBack').on('click', function(){
		showFieldActive("back", opDebitFields);
	});
	
	$('.opDebitForm .opNav .btnNext').on('click', function(){
		showFieldActive("next", opDebitFields);
	});
	
	$('.opCreditForm .opNav .btnBack').on('click', function(){
		showFieldActive("back", opCreditFields);
	});
	
	$('.opCreditForm .opNav .btnNext').on('click', function(){
		showFieldActive("next", opCreditFields);
	});
	
	function gestionBackNextVisibility()
	{
		if(indexFieldActive == 0){
			$('.btnBack').hide();
		} else {
			$('.btnBack').show();
		}
		if(indexFieldActive == opFieldLength-1){
			$('.btnNext').hide();
		} else {
			$('.btnNext').show();
		}
	}
	
	function initiateFieldActive()
	{
		indexFieldActive = 0;
		for(var i = 0; i < opDebitFields.length; i++){
			$(opDebitFields[i]).css({
				'left': '101%'
			});
		}
		for(var i = 0; i < opCreditFields.length; i++){
			$(opCreditFields[i]).css({
				'left': '101%'
			});
		}
		$(opDebitFields[indexFieldActive]).css({
			'left': '0%'
		});
		
		$(opCreditFields[indexFieldActive]).css({
			'left': '0%'
		});
		$('.btnBack').hide();
	}
	
	function showFieldActive(direction, opFields)
	{
		if(direction == "next"){
			if(indexFieldActive < opFieldLength - 1){
				$(opFields[indexFieldActive]).animate({
					'left': '-101%'
				}, 400);
				indexFieldActive += 1;
				$(opFields[indexFieldActive]).animate({
					'left': '0%'
				}, 400);
			}
		} else {
			if(indexFieldActive > 0){
				$(opFields[indexFieldActive]).animate({
					'left': '101%'
				}, 400);
				indexFieldActive -= 1;
				$(opFields[indexFieldActive]).animate({
					'left':'0%'
				}, 400);
			}
		}
		gestionBackNextVisibility();
	}
	
	function showFormActive(index)
	{
		return function(){
			//Si on clique le bouton actif alors on ne fait rien:
			if(indexFormActive == index){return;}
			
			// Sinon on applique ces directives
			indexFieldActive = 0;
			//Si on repère un clique sur une carte (container du formulaire caché):
			if($('.containerForm').css('display') == 'none'){
				$('.containerForm').show();
				$('.opCard').hide();
				$('.opBtnCardL').show();
			}
			
			// Sinon on applique ces directives:
			
			
			if(!isAnimated){
				isAnimated = true;
				//Si l'index du formulaire actif n'est pas défini:
				if(indexFormActive == -1){
					$(opForms[index]).animate({
						'top': '0%'
					}, 400, function(){
						isAnimated = false;
					});
				} else {
					isAnimated = true;
					$(opForms[indexFormActive]).animate({
						'top': '101%'
					}, 400, function(){
						initiateFieldActive();
						$(opForms[index]).animate({
							'top': '0%'
						}, 400);
						isAnimated = false;
					});
				}
				$(opBtns[indexFormActive]).css({
					'background-color': 'rgb(100,100,100)'
				});
				$(opBtns[index]).css({
					'background-color': 'rgb(232,0,179)'
				});
				indexFormActive = index;
			}
			
			
			
		}
	}
});