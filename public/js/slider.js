
// JAVASCRIPT DE SLIDER 2 (USUARIO INTERACCIONA)

// $(document).ready(function(){
// 	// llama funcion (abajo)
// 	chargeBullets();
//
// 	$(".arrow").on("click", function(){
// 		// nos proporciona la longitud de cada diapositiva (tira) por la izquierda en px (ej. 600px)
// 		var actual_left = $("div#tira").css("left");
// 		// quita los dos últimos caracteres de la variable anterior, es decir, "px" (ej. 600)
// 		var only_numbers = parseInt(actual_left.substring(0, actual_left.length-2));
// 		// nos proporciona en % el total del ancho de la caja de "mask"
// 		var width_equal_to_100_percent = Math.round($("#mask").width());
// 		// nos proporciona la maxima logitud por la izquierda
// 		var max_left_position = ($(".image").length-1)*width_equal_to_100_percent;
// 		// nos proporciona la mínima logitud por la izquierda
// 		var min_left_position = 0;
// 		// si se ha clicado a la flecha de la izquierda
// 		if($(this).hasClass("left")){
// 			if(only_numbers!=min_left_position){
// 				// en el caso que se ha llegado a la última diapositiva, empieza por la primera
// 				$("div#tira").css("left", (only_numbers + width_equal_to_100_percent)+"px");
// 			}else{
// 				$("div#tira").css("left", "-"+max_left_position+"px");
// 			}
// 		// si se ha clicado a la flecha de la derecha
// 		}else{
// 			if((only_numbers*-1)!=max_left_position){
// 				// en el caso que se ha llegado a la última diapositiva, empieza por la primera
// 				$("div#tira").css("left", (only_numbers - width_equal_to_100_percent)+"px");
// 			}else{
// 				$("div#tira").css("left", min_left_position+"px");
// 			}
// 		}
// 		//hay que hacer settimeout porque, como se vuelve a capturar la posicion left actual para saber que bullet accionar, al estar desplazandose en transicion
// 		//hasta que no acaba no se hace efectivo el nuevo left
// 		setTimeout(function(){
// 			actual_left = $("div#tira").css("left");
// 			only_numbers = parseInt(actual_left.substring(0, actual_left.length-2));
// 			var position_bullet = (Math.round(only_numbers/width_equal_to_100_percent)*-1);
// 			$(".bullet").removeClass("selected");
// 			$(".bullet:nth-child("+(position_bullet+1)+")").addClass("selected");
// 		}, 500);
//
// 	});
//
// 	//lo mismo que con las flechas, lo hacemos con los bullets
// 	$(".bullet").on("click", function(){
// 		var width_equal_to_100_percent = Math.round($("#mask").width());
// 		var bullet_position = $(this).attr("bullet");
// 		$(".bullet").removeClass("selected");
// 		$(this).addClass("selected");
// 		$("div#tira").css("left", ((bullet_position*width_equal_to_100_percent)*-1)+"px");
// 	});
//
// });
// // carga los bullets en el documento (en linea y centrado abajo)
// function chargeBullets(){
// 	var total_images = $(".image").length;
// 	var divContent = "";
// 	for(var i=0; i<total_images; i++){
// 		if(i==0){
// 			divContent+="<span class='bullet selected' bullet="+i+"></span>";
// 		}else{
// 			divContent+="<span class='bullet' bullet="+i+"></span>";
// 		}
// 	}
// 	$(".bullets").html(divContent);
// }
