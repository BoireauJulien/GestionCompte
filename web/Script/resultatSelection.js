$(document).ready(function(){
	var compteTitles = document.getElementsByClassName('compteTitle');
	var colMontants = document.getElementsByClassName('colMontantS');
	var coches = document.getElementsByClassName('iconCoche');
	var totaux = document.getElementsByClassName('montantTotalS');
	var arrayRows = [];
	var arrayCoches = [];
	var montantsTotaux = [];
	
	for(var i = 0; i < compteTitles.length; i++){
		index = i + 1;
		var arrayMontants = $('.container'+index + ' .rowDataLC .colMontantS');
		var arrayCoche = $('.container'+index + ' .rowDataLC .colMontantS .iconCoche');
		arrayRows.push(arrayMontants);
		arrayCoches.push(arrayCoche);
		montantsTotaux.push(0);
	}
	
	for (var i = 0; i < arrayRows.length; i++){
		for(var j = 0; j < arrayRows[i].length; j++){
			$(arrayCoches[i][j]).on('click', onCocheClick(i,j));
		}
	}
	
	function onCocheClick(indexI, indexJ)
	{
		return function()
		{
			if($(arrayCoches[indexI][indexJ]).css('color') == 'rgba(0, 0, 0, 0)'){
				$(arrayCoches[indexI][indexJ]).css({
					'color': 'rgb(232,0,200)'
				});
				montantsTotaux[indexI] += parseFloat($(arrayRows[indexI][indexJ]).text());
				$(totaux[indexI]).text(montantsTotaux[indexI].toFixed(2));
				
			} else{
				$(arrayCoches[indexI][indexJ]).css({
					'color': 'transparent'
				});
				montantsTotaux[indexI] -= parseFloat($(arrayRows[indexI][indexJ]).text());
				$(totaux[indexI]).text(montantsTotaux[indexI].toFixed(2));
			}
		}
	}
});