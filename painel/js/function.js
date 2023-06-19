$(function(){

escondeAside();
menuSelect();
/*-----------------------------------------------------------------------------------------------*/
function escondeAside(){
	var iconeMenu = $('.icone-menu');
	var main = $('main');
	var aside = $('aside');
	var open  = true;
	var windowSize = $(window)[0].innerWidth;
	var targetSizeMenu = (windowSize <= 400) ? 200 : 250;

	if(windowSize <= 972){
		aside.css('width','0');
		open = false;
	}

	iconeMenu.click(function(){
		if(open){
			//O menu está aberto, precisamos fechar e adaptar nosso conteudo geral do painel
			aside.css('width','0').css('transition','0.4s');
			open = false;
			main.css('width','100%').css('left',0).css('transition','0.4s');
			open = false;
		}else{
			//O menu está fechado
			aside.css('width',targetSizeMenu+'px').css('transition','0.4s');
			open = true;
			if(windowSize > 972)
				main.css('width','calc(100% - 250px)').css('transition','0.4s');
				main.animate({'left':targetSizeMenu+'px'},'500',function(){
				open = true;
			});
		}
	})

	$(window).resize(function(){
		if($(window)[0].innerWidth != windowSize){
		windowSize = $(window)[0].innerWidth;
		targetSizeMenu = (windowSize <= 400) ? 200 : 250;
		if(windowSize <= 972){
			aside.css('width','0');
			main.css('width','100%').css('left','0');
			open = false;
		}else{
			aside.animate({'width':targetSizeMenu+'px'},function(){
				open = true;
			});

			main.css('width','calc(100% - 250px)');
			main.animate({'left':targetSizeMenu+'px'},function(){
			open = true;
			});
		}
		}
	})
}
	
/*-----------------------------------------------------------------------------------------------*/
function menuSelect(){

	$('.side-menus h2, .side-menus h2 a').click(function(){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		}else{
			//siblings remove a classe dos irmãos
			$(this).siblings().removeClass('active');
			$(this).addClass('active');
		}

	})

}
/*-----------------------------------------------------------------------------------------------*/
/*para formatar data*/
$('[formato=data]').mask('99/99/9999');
/*-----------------------------------------------------------------------------------------------*/
$('[actionBtn=deletar]').click(function(){
	var txt;
	var r = confirm("Tem certeza de que deseja deletar o registro?");
	if(r == true){
		return true;
	}else{
		return false;
	}
});

/*modo dark*/
darkModeColor();
function darkModeColor(){
	const el = [
	'aside',
	'main',
	'aside i',
	'.box-content i',
	'.box-content h2',
	'.box-content',
	'.row',
	'header i',
	'header',
	'header a',
	'label',
	'a.active',
	'.btn-log > a:first',
	'.box-content div h2:nth-of-type(2)',
	'input[type=submit]'
	];
	const classe = [
	'sideBar-color',
	'fundo-main',
	'icon-color',
	'',
	'',
	'objeto-color',
	'',
	'color-texto',
	'',
	'',
	'',
	'',
	'',
	'color-texto-content',
	''
	];
	const classeD = [
	'sideBar-dark',
	'fundo-dark',
	'icon-dark',
	'icon-dark',
	'texto-dark',
	'objeto-dark',
	'texto-dark',
	'texto-dark',
	'header-color-dark',
	'texto-dark',
	'texto-dark',
	'active-dark',
	'active-darkH',
	'textContent-dark',
	'btn-colorDark'
	];

	const darkMode = localStorage.getItem('darkMode');

	if(darkMode){
		for (var i = 0; i < el.length; i++) {
			$(el[i]).removeClass(classe[i]);
			$(el[i]).addClass(classeD[i]);
			$('#switch').prop('checked', true);
		}
	}

	$('#switch').click(function(){
		for (var i = 0; i < el.length; i++) {
			$(el[i]).removeClass(classe[i]);
			$(el[i]).addClass(classeD[i]);
			if(el[i] != classe[i] && $('#switch').is(':checked')){
				localStorage.setItem('darkMode',true);
			}else{
				localStorage.removeItem('darkMode');
				$(el[i]).removeClass(classeD[i]);
				$(el[i]).addClass(classe[i]);
			}
		}

	});/*aqui termina click*/
}/*aqui termina a function*/

/*modo dark fim*/
	
	
})