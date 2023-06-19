$(function(){

//mascara telefone---------
$('[name=telefone]').mask('(00) 0 0000-0000');
//scroll Links-------------
menuScroll();
function menuScroll(){
	var links = $('header a,footer a,.sobre a');
	$(links).click(function(){
		//pegando o attr dos links
		let href = $(this).attr('href');
		//dando scroll do topo par abaxio nos links
		let scrollTop = $(href).offset().top - 20;
		//animando o scroll
		$('html, body').animate({'scrollTop':scrollTop});
		return fasle;
	})
};
//fancybox
$('.cardapio #imgComida').fancybox({
	'openEffect':'elastic'
});

//slide das descrcieos de divs
$('[data-id="show"], .close').on('click', function() {
    $(this).closest('.produtoSingle').find('.descricao').slideToggle();
});

//fechar overlayCarro
$('.carroWraper i').click(function(){
	let carrinhoOver = $('.carrinho');
	if(carrinhoOver.is(":visible")){
		carrinhoOver.fadeOut();
	}else{
		carrinhoOver.fadeIn();
	}
})

$('i.fa-cart-shopping').click(function(e){
	e.preventDefault();
	let carrinhoOver = $('.carrinho');
	if(carrinhoOver.is(":hidden")){
		carrinhoOver.fadeIn();
	}
})

//input moeda
$('select').change(function(){
	var opcao = $('option:selected').text();
	var trocoInput = $('.troco');
	if(opcao == 'Dinheiro'){
		trocoInput.fadeIn();
		$('[name=troco]').attr('required',true);
	}else{
		trocoInput.css('display','none');
		$('[name=troco]').attr('required',false);
	}
})

//////////////////

//slide
	/*slideServicos();
	function slideServicos(){
		var delay = 2000;
		var curentIndex = 0;
		var amt;

		initSlider();
		autoplay();


		function initSlider(){
			amt = $('.servicos-single').length;
			var sizeContainer = 100 * amt;
			var sizeBoxSingle = 100 / amt;
			$('.servicos-single').css('width',sizeBoxSingle+'%');
			$('.scrollWraper').css('width',sizeContainer+'%');

			for(var i = 0;i<amt;i++){
				if(i==0){
					$('.servicos .dots').append('<span style="background-color: red;"></span>');
					$('.servicos-single').eq(curentIndex).css('border','1px solid white');
				}else{
					$('.servicos .dots').append('<span></span>')
				}
			}
		}

		function autoplay(){
			setInterval(function(){
				curentIndex++;
				if(curentIndex == amt){
					curentIndex = 0;
				}
				goToSlider(curentIndex);
			},delay)
		}

		function goToSlider(curentIndex){
			var offsetX = $('.servicos-single').eq(curentIndex).offset().left - $('.scrollWraper').offset().left;
			$('.servicos .dots span').css('background-color','white');
			$('.servicos .dots span').eq(curentIndex).css('background-color','red');
			$('.servicos-single').css('border','0');
			$('.servicos-single').eq(curentIndex).css('border','1px solid white');
			$('.scrollServico').animate({'scrollLeft':offsetX});
		}

		$(window).resize(function(){
			$('.scrollServico').stop().animate({'scrollLeft':0});
		})

		$('.servicos-single').click(function(){
			$('.servicos-single').css('border','0');
			$(this).css('border','1px solid white');
		});

	}

	slideTrabalhos();
	function slideTrabalhos(){
		var delay = 2000;
		var curentIndex = 0;
		var amt;

		initSlider();
		autoplay();


		function initSlider(){
			amt = $('.trabalho-single').length;
			var sizeContainer = 100 * amt;
			var sizeBoxSingle = 100 / amt;
			$('.trabalho-single').css('width',sizeBoxSingle+'%');
			$('.scrollWraperT').css('width',sizeContainer+'%');

			for(var i = 0;i<amt;i++){
				if(i==0){
					$('.projetos .dots').append('<span style="background-color: red;"></span>');
					$('.trabalho-single').eq(curentIndex).css('border','3px solid white');
				}else{
					$('.projetos .dots').append('<span></span>')
				}
			}
		}

		function autoplay(){
			setInterval(function(){
				curentIndex++;
				if(curentIndex == amt){
					curentIndex = 0;
				}
				goToSlider(curentIndex);
			},delay)
		}

		function goToSlider(curentIndex){
			var offsetX = $('.trabalho-single').eq(curentIndex).offset().left - $('.scrollWraperT').offset().left;
			$('.projetos .dots span').css('background-color','white');
			$('.projetos .dots span').eq(curentIndex).css('background-color','red');
			$('.trabalho-single').css('border','0');
			$('.trabalho-single').eq(curentIndex).css('border','3px solid white');
			$('.scrollTrabalhos').animate({'scrollLeft':offsetX});
		}

		$(window).resize(function(){
			$('.scrollTrabalhos').stop().animate({'scrollLeft':0});
		})

		$('.trabalho-single').click(function(){
			$('.trabalho-single').css('border','0');
			$(this).css('border','3px solid white');
		});

	}

	slideDepoimentos();
	function slideDepoimentos(){
		var delay = 2000;
		var curentIndex = 0;
		var amt;

		initSlider();
		autoplay();


		function initSlider(){
			amt = $('.depoimento-single').length;
			var sizeContainer = 100 * amt;
			var sizeBoxSingle = 100 / amt;
			$('.depoimento-single').css('width',sizeBoxSingle+'%');
			$('.scrollWraperD').css('width',sizeContainer+'%');

			for(var i = 0;i<amt;i++){
				if(i==0){
					$('.depoimentos .dots').append('<span style="background-color: red;"></span>');
				}else{
					$('.depoimentos .dots').append('<span></span>')
				}
			}
		}

		function autoplay(){
			setInterval(function(){
				curentIndex++;
				if(curentIndex == amt){
					curentIndex = 0;
				}
				goToSlider(curentIndex);
			},delay)
		}

		function goToSlider(curentIndex){
			var offsetX = $('.depoimento-single').eq(curentIndex).offset().left - $('.scrollWraperD').offset().left;
			$('.depoimentos .dots span').css('background-color','white');
			$('.depoimentos .dots span').eq(curentIndex).css('background-color','red');
			$('.scrollDepoimentos').animate({'scrollLeft':offsetX});
		}

		$(window).resize(function(){
			$('.scrollDepoimentos').stop().animate({'scrollLeft':0});
		})

		$('.depoimento-single').click(function(){
			$('.depoimento-single').css('border','0');
			$(this).css('border','1px solid white');
		});
	}*/


});