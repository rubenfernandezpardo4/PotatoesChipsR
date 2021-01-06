$(document).ready(function(){


// _____________________________________________
// Imagenes que se cargan en los inputs type 'file'
// ____________________________________________________
// Ahora inicializaremos la LIBRERÍA bsCustomFileInput de la siguiente forma:
  bsCustomFileInput.init();//input plugin bsCustomFileInput

  // y aquí nos ejecutará:
  $('#inputGroupFile0, #inputGroupFile1').on('change',function(){
      var input = $(this)[0];

      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) { $('#preview0, #preview1').attr('src', e.target.result).fadeIn('slow');  }
          reader.readAsDataURL(input.files[0]);
      }
  });

  // LIBRERIA VALIDATE______________________________________________________________________
  // addImage

      $('#addImageForm').validate({
          // Normas campos requeridos
          rules: {
                titleAddImage: {
                    required: true
                },
                categoryAddImage: {
                    required: true
                },
                // descAddImage: {
                //     required: true
                // },

                addImage: {
                    required: true
                }


          },
          // Mensajes
          messages:  {
              titleAddImage:  {
                  required: "Por favor, introduce un título de imagen"
              },
              categoryAddImage: {
                  required: '<br>' + "Por favor, elija una categoría"
              },
              // descAddImage: {
              //     required: "Por favor, introduce una descripción"
              // },
              addImage: {
                  required: "<br>" + "Por favor, añade una imagen"
              }
          },

          submitHandler: function() {
              // SUBMIT
             // El serialize()(que recoge los inputs), no nos funciona en este caso para enviar a través de ajax, ya que estamos usando IMAGENES y al usar imágenes habrá que utilizar la clase FormData()
              var data = new FormData($('#addImageForm')[0]);

              // Envío de datos sin recargar la página a través de AJAX
              $.ajax({

                  type: 'POST',
                  url: 'addImage',
                  dataType: 'json',
                  data: data,  //variable data que creamos para recoger las imagenes

                  // obligatorio para subir imagenes al server
                  contentType: false,
                  processData: false,
                  // control de acciones en el envio y respuesta del server
                  success: function(res){
                      $(".response").html(res);

                      // FILTRO DE SI TITULO EXISTE O NO, EN CASO DE QUE SI EXISTA QUE NO NOS HAGA RELOAD
                      // Si title ya existe enviamos alert(Sin reload)
                      if (res == 'Este título ya existe') {

                          alert ("Este título ya esta registrado, por favor introduzca otro diferente");

                      // Si el title no existe hacemos un reload
                      } else {
                          setTimeout(function(){
                              $(".response").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>' + '<br>' + 'Se ha añadido la imagen correctamente');
                              // alert(res);
                              location.reload();
                                    
                          }, 500);

                      }


                  },
                  beforeSend: function(){
                      $(".response").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>' + '<br>' + 'Subiendo imagen...');
                  },
                  error: function(jqXHR ,textStatus, errorThrown){
                      $(".response").html(textStatus + '' + jqXHR.status + '' + errorThrown);
                  }
              });
          }

      });
// ____________________________________________________________________________________________________

    // BORRAR IMAGEN (DELETE)
        $('.delImageLink').click(function(event){

            var delConfirm = confirm("¿Estas seguro, que deseas eliminar esta imagen?");

            if(delConfirm){
                var deleteLink = $(event.target).attr('id');
                var deleteLinkTitle = $(event.target).attr('title');


                $.ajax({
                    type: 'post',
                    url: 'deleteImage',
                    dataType: 'json',
                    // el dato en formato clave:valor
                    data: {id:deleteLink, title:deleteLinkTitle},
                    success: function(res){

                        setTimeout(function(){
                            alert(res);
                            location.reload();
                        }, 500);

                    },
                    beforeSend: function(){ $('.response').html('Borrando imagen...'); },
                    error: function(jqXHR, textStatus, errorThrown){ $('.response').html(textStatus + ' ' + jqXHR.status + ' ' + errorThrown); }
                });
            }

        });
    // ____________________________________________________________________________________________________


        // EDICION DE IMAGEN (EDITAR)

             $('.editImageLink').click(function(event){
                 var id = $(event.target).attr('id');
                 var title = $(event.target).attr('title');
                 var categoria = $(event.target).attr('categ');
                 var descr = $(event.target).attr('descr');
                 var image = $(event.target).attr('image');



                // Ahora inyectamos los valores a los campos del MODAL
                 $("input[name=titleEditImage]").val(title);
                 $("input[name=categoryEditImage]").val(categoria);
                 $("textarea[name=descEditImage]").val(descr);
                 // Para añadir la imagen cogemos el #preview1 que es la id de la imagen del form, y le añadimos al attr(atributo) la variable image
                 $('#preview1').attr("src", image);
                 $('#editImageLink').modal();


                 // inyectamos la info de las variables en los inputs hidden(que no se ven)
                 $("input[name=idImage]").val(id);
                 $("input[name=titleEditImageOld]").val(title);
                 $("input[name=descEditImageOld]").val(descr);
                 $("input[name=EditImageOld]").val(image);


             });

             // SUBMIT Y VALIDATE
             $('#editImageForm').validate({
                 rules: {
                     titleEditImage: {
                         required: true
                     }
                     // descEditImage: {
                     //     required: true
                     // },
                     // La imagen no la requerimos
                     // editImage: {
                     //     required: true
                     // }
                 },
                 messages: {
                     titleEditImage: {
                         required: 'Por favor, introduce un título de imagen'
                     }
                     // descEditImage: {
                     //     required: 'Por favor, introduce una descripción de imagen'
                     // },
                     // Más arriba no requerimos la imagen
                     // editImage: {
                     //     required: 'Por favor, añade una imagen'
                     // }
                 },
                 submitHandler: function() {
                     var data = new FormData($('#editImageForm')[0]);
                     // submit
                     $.ajax({
                         type: 'post',
                         url: 'editImage',
                         dataType: 'json',
                         data: data,
                         // obligatorio para subir imagenes al server
                         contentType: false,
                         processData: false,
                         success: function(res){
                             $('.editresponse').html(res);

                             setTimeout(function(){
                                 location.reload();
                             }, 1000);

                         },
                         beforeSend: function(){ $('.response').html('Guardando cambios...'); },
                         error: function(jqXHR, textStatus, errorThrown){ $('.response').html(textStatus + ' ' + jqXHR.status + ' ' + errorThrown); }
                     });
                 }
             });

 // ____________________________________________________________________________________________________


    // ENVIO DE ANUNCIO DE ADMIN A 'TODOS' LOS EMAILS SUSCRITOS
    $('#btn_anuncio').click(function(){

        // alert();
        $.ajax({
            type: 'POST',
            url: 'SuscripcionAnuncio',
            dataType: 'json',
            data: $('#btn_anuncio'),
            // data: data,
            // control de acciones en el envio y respuesta del server
            success: function(res){
                $(".response").html(res);
                // alert();

            },
            beforeSend: function(){
                $(".response").html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>' + '<br>' + 'Enviando anuncio...');
            },
            error: function(jqXHR ,textStatus, errorThrown){
                $(".response").html(textStatus + '' + jqXHR.status + '' + errorThrown);
            }
        });


    });

});
