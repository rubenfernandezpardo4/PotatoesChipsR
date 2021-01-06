
$(document).ready(function(){

    $("button").click(function(){

    // VARIABLES
    var mensajes = "";
    var nombre = document.getElementById("nombre");
    var apellido = document.getElementById("apellido");
    var email = $("input[id='email']");
    // var tlf = $("input[id='tlf']");
    // var dni = $("input[id='dni']");
    // var any = $("input[id='any']");
    // var provincias = $("select");
    // var mensaje = document.getElementById("mensaje");


           if(nombre.value == ""){
               mensajes = "Rellena el campo Nombre<br>";
               nombre.classList.add("placeholder_val_ko");
               nombre.classList.remove("placeholder_val_ok");
               document.getElementById("nombre_val").innerHTML = mensajes;
           }else{
               nombre.removeAttribute("style");
               nombre.classList.add("placeholder_val_ok");
               nombre.classList.remove("placeholder_val_ko");
               mensajes = "";
               document.getElementById("nombre_val").innerHTML = mensajes;
           }

           if(apellidos.value == ""){
               mensajes = "Rellena el campo Apellido<br>";
               apellidos.classList.add("placeholder_val_ko");
               apellidos.classList.remove("placeholder_val_ok");
               document.getElementById("apellido_val").innerHTML = mensajes;
           }else{
               apellidos.removeAttribute("style");
               apellidos.classList.add("placeholder_val_ok");
               apellidos.classList.remove("placeholder_val_ko");
               mensajes = "";
               document.getElementById("apellido_val").innerHTML = mensajes;
           }

          if(email.val() == ""){
              mensajes = "Rellena el campo Email<br>";
              email.addClass("placeholder_val_ko");
              email.removeClass("placeholder_val_ok");
              $("#email_val").html(mensajes);

          }else if(!email_validar(email.val())){
              mensajes = "El email no cumple el formato nombre@dominio.ext)<br>";
              email.css("color","red");
              $("#email_val").html(mensajes);
          }else{
              email.removeAttr("style");
              email.addClass("placeholder_val_ok");
              email.removeClass("placeholder_val_ko");
              mensajes = "";
              $("#email_val").html(mensajes);
          }

          // ESTOS CAMPOS ESTAN COMENTADOS, ESTAN CREADOS Y VALIDADOS CON JQUERY (NO BORRAR)
          // if(tlf.val() == ""){
          //     mensajes = "*Rellena el campo Teléfono<br>";
          //     tlf.addClass("placeholder_val_ko");
          //     tlf.removeClass("placeholder_val_ok");
          //     $("#tlf_val").html(mensajes);
          //
          // }else if(!telefono_validar(tlf.val())){
          //     mensajes = "*El teléfono no tiene el formato (9/7/6xxxxxxxx)<br>";
          //     tlf.css("color","red");
          //     $("#tlf_val").html(mensajes);
          // }else{
          //     tlf.removeAttr("style");
          //     tlf.addClass("placeholder_val_ok");
          //     tlf.removeClass("placeholder_val_ko");
          //     mensajes = "";
          //     $("#tlf_val").html(mensajes);
          // }
          //
          // if(dni.val() == ""){
          //     mensajes = "*Rellena el campo DNI<br>";
          //     dni.addClass("placeholder_val_ko");
          //     dni.removeClass("placeholder_val_ok");
          //     $("#dni_val").html(mensajes);
          //
          // }else if(!dni_validar(dni.val())){
          //     mensajes = "*El DNI introducido no es correcto<br>";
          //     dni.css("color","red");
          //     $("#dni_val").html(mensajes);
          // }else{
          //     dni.removeAttr("style");
          //     dni.addClass("placeholder_val_ok");
          //     dni.removeClass("placeholder_val_ko");
          //     mensajes = "";
          //     $("#dni_val").html(mensajes);
          // }
          //
          //  if(any.val() == ""){
          //      mensajes = "*Rellena el campo Año de Nacimiento<br>";
          //      any.addClass("placeholder_val_ko");
          //      any.removeClass("placeholder_val_ok");
          //      $("#any_val").html(mensajes);
          //
          //  }else if(any.val()>2002){
          //      mensajes = "*Eres menor de edad<br>";
          //      any.css("color","red");
          //      $("#any_val").html(mensajes);
          //  }else{
          //      any.removeAttr("style");
          //      any.addClass("placeholder_val_ok");
          //      any.removeClass("placeholder_val_ko");
          //      mensajes = "";
          //      $("#any_val").html(mensajes);
          //  }
          //
          //  if(provincias.val() == "0"){
          //      mensajes = "*Elige una de las provincias<br>";
          //      provincias.addClass("placeholder_val_ko");
          //      provincias.removeClass("placeholder_val_ok");
          //      $("#provincias_val").html(mensajes);
          //
          //  }else{
          //      provincias.removeAttr("style");
          //      provincias.addClass("placeholder_val_ok");
          //      provincias.removeClass("placeholder_val_ko");
          //      mensajes = "";
          //      $("#provincias_val").html(mensajes);
          //  }
          //
          //  if(mensaje.value == ""){
          //      mensajes = "*Rellena el campo Mensaje<br>";
          //      mensaje.classList.add("placeholder_val_ko");
          //      mensaje.classList.remove("placeholder_val_ok");
          //      document.getElementById("mensaje_val").innerHTML = mensajes;
          //  }else{
          //      mensaje.removeAttribute("style");
          //      mensaje.classList.add("placeholder_val_ok");
          //      mensaje.classList.remove("placeholder_val_ko");
          //      mensajes = "";
          //      document.getElementById("mensaje_val").innerHTML = mensajes;
          //  }

           // Envío de datos del formulario suscripción por AJAX(con ajax enviamos datos sin recargar la pagina)
           if (
           $(nombre_val).html() == ""
           && $(apellido_val).html() == ""
           && $(email_val).html() == ""
           // && $(tlf_val).html() == ""
           // && $(dni_val).html() == ""
           // && $(any_val).html() == ""
           // && $(provincias_val).html() == ""
           // && $(mensaje_val).html() == ""
            ){
               // alert("El usuario ha entrado correctamente");


                   // método AJAX de jQuery________________________________________________________________________________

                   // El prevent default lo ponemos aquí para que pare la acción del SUBMIT y envíe los datos sin recargar
                   event.preventDefault();

                   $.ajax({
                       // config. de datos de envío
                       type: 'POST',
                       url: 'formulariosuscripcion',
                       dataType: 'json',
                       data: $("#suscripcion").serialize(),
                       // control de acciones en el envio y respuesta del server
                       success: function(dataSuscrip){
                           $("#dataSuscrip").html(dataSuscrip);
                       },
                       beforeSend: function(){
                           $("#dataSuscrip").css("text-align", "center");
                           $("#dataSuscrip").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>');
                       },
                       error: function(){
                           $("#dataSuscrip").html('*Error en la comunicación con el servidor');
                       }
                   });
           }

    });
});

// FUNCIONES QUE USAREMOS PARA VALIDAR

// FUNCION QUE VALIDA EL TELEFONO
// /*
// * @name: telefono_validar
// * @author: Clase CIFO VIOLETA
// * @versio: 1.0
// * @description: Valida un formato de teléfono mediante RegExp
// * @date: 08/1/20
// * @params: tlf.val()
// * @return: true/false
// */
// function telefono_validar(tlf){
//     var patt = new RegExp(/^[9|7|6]{1}([\d]{2}[-]*){3}[\d]{2}$/);
//     return patt.test(tlf);
// }
//

// FUNCION QUE VALIDA EL EMAIL
/*
* @name: email_validar
* @author: Clase CIFO VIOLETA
* @versio: 1.0
* @description: Valida un formato de un email mediante RegExp
* @date: 08/1/20
* @params: email.val()
* @return: true/false
*/
function email_validar(email){
    var patt = new RegExp(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    return patt.test(email);
}

// FUNCION QUE VALIDA EL DNI
// /*
// * @name: dni_validar
// * @author: Clase CIFO VIOLETA
// * @versio: 1.0
// * @description: Valida un formato de DNI mediante RegExp
// * @date: 09/1/20
// * @params: dni.val()
// * @return: true/false
// */
// function dni_validar(dni){
//     var patt = new RegExp(/^\d{8}[a-zA-Z]$/);
//     var numero;
//     var letr;
//     var letra;
//
//     if(patt.test(dni)){
//         numero = dni.substr(0,dni.length-1);
//         letr = dni.substr(dni.length-1,1);
//         numero = numero % 23;
//         letra='TRWAGMYFPDXBNJZSQVHLCKET';
//         letra=letra.substring(numero,numero+1);
//
//
//         if (letra!=letr.toUpperCase()) {
//             return false;
//         }else{
//             return true;
//         }
//         }else{
//             return false;
//         }
// }
