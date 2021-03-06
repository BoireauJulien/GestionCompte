$(document).ready(function(){
	var windowHeight = $(window).height();
	
	initiateCartes();
	
	window.onresize = function(){
		windowHeight = $(window).height();
		
		initiateCartes();
	}
	
	
	function initiateCartes()
	{
		var carteHeight = (1/4) * windowHeight;
		var fontIcon = (1/2) * carteHeight;
		$('.userCarte').css({
			'height': carteHeight,
			'width': carteHeight
		});
		
		$('.userProfileIcon').css({
			'font-size': fontIcon
		});
		
		var topIcon = (carteHeight - $('.userProfileIcon').height()) / 2;
		
		$('.userProfileIcon').css({
			'margin-top': topIcon +'px'
		});
	}
	
});