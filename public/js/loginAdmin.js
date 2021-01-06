
// VALIDACION CON JQUERY FORMULARIO LOGIN ADMIN

$(document).ready(function(){
    // validació del formulari de login amb jQuery
    // Esto son variables generales

    var boto = $("input[type=button]");
    var lg_user = $("#lg_user");
    var lg_pass = $("#lg_pass");
    var errorEmail = $(".error").get(0);
    var errorPass = $(".error").get(1);

    // validació del correu electrònic
    lg_user.on("keyup", function(){
        if(lg_user.val() != "" && email_validar(lg_user.val())){
            $(errorEmail).html("");
            lg_user.removeClass("invalid");
        }
    });

    // validació de la paraula de pas
    lg_pass.on("keyup", function(){
        if(lg_pass.val() != "" && lg_pass.val().length > 5){
            $(errorPass).html("");
            lg_pass.removeClass("invalid");
        }
    });

    boto.on("click", function(){

        // alert();
        if(lg_user.val() == ""){
            $(errorEmail).html("Rellena el campo email");
            lg_user.addClass("invalid");
        } else if(!email_validar(lg_user.val())){
            $(errorEmail).html("El email tiene un formato incorrecto");
            lg_user.addClass("invalid");
        }

        if(lg_pass.val() == ""){
            $(errorPass).html("Rellena el campo contraseña");
            lg_pass.addClass("invalid");
        } else if(lg_pass.val().length < 6){
            $(errorPass).html("La contraseña es demasiado corta");
            lg_pass.addClass("invalid");
        }
        //
        if ($(errorEmail).html() == ""
        &&  $(errorPass).html() == ""){
            // alert("El usuario ha entrado correctamente");

                // método AJAX de jQuery________________________________________________________________________________
                // El prevent default lo ponemos aquí para que pare la acción del SUBMIT y envíe los datos sin recargar
                event.preventDefault();

                $.ajax({
                    // config. de datos de envío
                    type: 'POST',
                    url: 'adminLogin',
                    dataType: 'json',
                    data: $("#login").serialize(),
                    // control de acciones en el envio y respuesta del server
                    success: function(dataResp_log){
                        $("#dataResp_log").html(dataResp_log);
                        // Si el login es correcto mándame a 'crud' con el location.href
                        if(dataResp_log == "Login correcto"){
                            location.href = 'crud';
                        }
                    },
                    beforeSend: function(){
                        $("#dataResp_log").css("text-align", "center");
                        $("#dataResp_log").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>');
                    },
                    error: function(){
                        $("#dataResp_log").html('Error en la comunicación con el servidor');
                    }
                });
        }

    });

});

// FUNCION QUE VALIDA EL EMAIL Y LO RETORNA
function email_validar(email){
    var patt = new RegExp(/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/);
    return patt.test(email);
}
