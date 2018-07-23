$(document).ready(function(){
	var passwords = document.getElementsByClassName('password');
	var viewBtns = document.getElementsByClassName('viewIcon');
	var windowHeight = $(window).height();
	var heightHeader = (1/10) * windowHeight;
	var isProfilOpen = false;
	var isPassType = true;
	
	styleHeader();
	styleProfilUser();
	
	for(var i = 0; i < viewBtns.length; i++){
		$(viewBtns[i]).on('click', togglePassword(i));
	}
	
	$('.userCo').on('click', function(){
		clickUserCo();
		showContainerProfil();
	});
	
	$('.userDeco').on('click', function(){
		clickUserDeco();
		showContainerProfil();
	});
	
	$('.overlayBackground').on('click' , function(event){
		if(!$(event.target).closest('.containerProfil').length && isProfilOpen){
			hideProfil();
		}
	});
	$('.header').on('click' , function(event){
		if(!$(event.target).closest('.containerProfil').length && isProfilOpen){
			hideProfil();
		}
	});
	
	
	function togglePassword(index)
	{
		return function()
		{
			if(isPassType){
				$(passwords[index]).prop('type','text');
				$(viewBtns[index]).text('visibility_off');
				isPassType = false;
			} else {
				$(passwords[index]).prop('type','password');
				$(viewBtns[index]).text('visibility');
				isPassType = true;
			}
		}
	}
	
	function styleHeader()
	{
		var heightInfoUser = (7/10) * heightHeader;
		var topInfoUser = (heightHeader - heightInfoUser) / 2;
		var fontIconUser = (0.6) * heightInfoUser;
		
		$('.header').css({
			'height': heightHeader + 'px'
		});
		
		$('.infoUser').css({
			'height': heightInfoUser +'px',
			'width': heightInfoUser + 'px',
			'top': topInfoUser + 'px'
		});
		
		$('.iconUser').css({
			'font-size': fontIconUser + 'px'
		});
		var topIconUser = (heightInfoUser - $('.iconUser').height())/2;
		$('.iconUser').css({
			'top': topIconUser +'px'
		});
	}
	
	function showContainerProfil()
	{
		$('.containerProfil').animate({
			'top': heightHeader + 5 + 'px'
		}, 300, function(){
			isProfilOpen = true;
		});
		
		$('.overlayBackground').show();
	}
	
	function hideProfil()
	{
		$('.containerProfil').animate({
			'top': '-20%'
		}, 300, function(){
			isProfilOpen = false;
		});
		$('.overlayBackground').hide();
		$('.infoUser').css({
			'box-shadow': '1px 1px 10px 1px rgba(0,0,0,0.5)'
		});
	}
	
	function clickUserCo()
	{
		$('.userCo').css({
			'box-shadow': '0 0 0 2px rgb(22,188,49)'
		});
	}
	
	function clickUserDeco()
	{
		$('.userDeco').css({
			'box-shadow': '0 0 0 2px rgb(222,21,21)'
		});
	}
	
	function styleProfilUser()
	{
		var height = windowHeight * (15/100);
		var width = windowHeight * (30/100);
		var btnLogHeight = height * (3/10);
		var topIconDeco = (btnLogHeight - $('.iconLog').height())/2;
		
		$('.containerProfil').css({
			'height': height + 'px',
			'width': width +'px'
		});
		
		$('.btnLog').css({
			'height': btnLogHeight + 'px',
			'width': btnLogHeight + 'px'
		});
		
		$('.iconLog').css({
			'top': topIconDeco +'px'
		});
	}
});