
// El "document ready" nos cargará la pagina aunque no se hayan cargado imagenes, etc..
$(document).ready(function(){


	// AQUÍ HACEMOS CON JS QUE EL NAVBAR CUANDO BAJEMOS (SCROLL) EL MENÚ SEA PEGUE ARRIBA

	var altura = $('.menu').offset().top;



	if(screen.width > 768) {

			$(window).on('scroll', function(){
				if ( $(window).scrollTop() > altura ){
					$('.menu').addClass('menu-fixed');
				} else {
					$('.menu').removeClass('menu-fixed');
				}
			});

	}
	// else{
	//
	// 	console.log('Responsive: pantalla de menos de 768px');
	// }


	// $(window).on('scroll', function(){
	// 	if ( $(window).scrollTop() > altura ){
	// 		$('.menu_hamburguesa').addClass('menu-fixed');
	// 	} else {
	// 		$('.menu_hamburguesa').removeClass('menu-fixed');
	// 	}
	// });

});

// __________________________________________________________________
