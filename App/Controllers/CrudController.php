<?php
namespace App\Controllers;
// use: va unido a los namespaces. Funciona como un require, include...
use Core\Controller;
use Core\View;
use App\Models\CrudModel;
use Core\Security;
use FilesystemIterator;

class CrudController extends Controller{
    // Si no existe sesion, y SI hay cookie, entonces vuelve a crear sesión.
    public function checkCookie(){
        if(!isset($_SESSION['SESSEMAIL']) && isset($_COOKIE['USER'])){
            // desencriptamos el valor de  la cookie ($email)
            $email = Security::en_de_cryptIt($_COOKIE['USER'], 'de');
            // vuelvo a crear la sesion
            $_SESSION['SESSEMAIL'] = $email;
        }
    }

    public function renderCrudAction(){

        // mira si existe la cookie
        $this->checkCookie();

        if(!isset($_SESSION['SESSEMAIL'])){

            header('location: index');

        } else{


            // RENDERIZA EN CRUD LAS PATATAS
            $model = new CrudModel;
            $dataUser = $model->datauserDB($_SESSION['SESSEMAIL']);

            View::renderTwig('Crud/crud.html', array('dataUser'=>$dataUser[0], 'dataImgUser'=>$dataUser[1]));
            // var_dump($dataUser[1]);

        }

    }

    // AÑADIR IMAGEN CRUD
    public function addImageAction($params){
        sleep(2);
        // echo json_encode("soy el addimage");
        // var_dump($params);
         if (!isset($params['addSubmitForm'])){
            // header — Enviar encabezado sin formato HTTP
            header('location: index');
         }else{


             $title = Security::secure_input($params['titleAddImage']);
             // reemplazamos los espacios por quiones para que no de error al hacer inserts en la BBDD
             $title = str_replace(' ', '-', $title);
             $categor = Security::secure_input($params['categoryAddImage']);
             $descr = Security::secure_input($params['descAddImage']);


             // Hacemos una lllamada al Crud model a la funcion titleDB para comprobar si title ya existe en la BBDD
             $model = new CrudModel;
             $Datatitle = $model->titleDB($params['titleAddImage']);

             // var_dump($dataUserImg[1]['title']);

            if ($Datatitle == $title){
                    echo json_encode('Este título ya existe');

            // EN CASO DE QUE EL TITULO NO EXISTA..
            }else{
                    // echo('titulo disponible');
                     // LIBRERIA "VEROT"-> para la carga de imagenes
                     $handle = new \Verot\Upload\Upload($_FILES['addImage']);
                     if($handle->uploaded){


                         $handle->dir_chmod = 0777; // PERMISOS PARA MAC de lectura y escritura carpeta
                         // $handle->file_overwrite = true;
                         $handle->file_new_name_body = $title;
                         $handle->process('../uploads/products/'); //Aquí crearemos las carpetas para losdiferentes emails que se registren en uploads/user
                         if($handle->processed){ // imagen SI subida a la  carpeta del servidor OK
                             $handle->clean();
                             $image = 'uploads/products/' . $title  . '.' . $handle->file_src_name_ext;

                             $model = new CrudModel;
                             $check = $model->addImageDB($title, $categor, $descr, $image);


                             switch ($check) {
                                 case 0:
                                        echo json_encode('Error en la carga de imagen');
                                     break;
                                 case 1:
                                        echo json_encode('Se ha añadido la imagen correctamente ');
                                     break;
                                 default:
                                        echo json_encode('Error al cargar ');
                                     break;
                             }
                         }

                    }else{echo json_encode('Error: ' . $handle->error); }//imagen NO SUBIDA a la carpeta del servidor

            }


         }
       }


       // BORRAR IMAGEN CRUD
       public function deleteImageAction($params){
           // var_dump($params);
           $model = new CrudModel;
           $check = $model->deleteImageDB($params['id']);

           switch ($check) {
               case 0:
                   echo json_encode('Error en el borrado de imagen');
                   break;
               case 1:
                   // borra imagen del proyecto
                   // ruta de la imagen
                   $path = '../uploads/products';
                   $it = new FilesystemIterator($path);
                   foreach ($it as $fileinfo) {
                       $image = explode('.', $fileinfo->getFilename());
                       if($image[0] === $params['title']){
                           $ext = $fileinfo->getExtension();
                       }
                   }
                   unlink($path . '/' . $params['title'] . '.' . $ext);
                   echo json_encode('Se ha borrado la imagen correctamente');
                   break;

               default:
                    echo json_encode('Error en la base de datos');
                    break;

           }

       }


       // EDITAR IMAGEN Crud


           public function editImageAction($params){

               // // RECOGEMOS LOS INPUTS DEL MODAL
               $id = Security::secure_input($params['idImage']);
               $title = Security::secure_input($params['titleEditImage']);
               $oldTitle = Security::secure_input($params['titleEditImageOld']);
               $categor = Security::secure_input($params['categoryEditImage']);
               $oldCategor = Security::secure_input($params['categoryEditImageOld']);
               $descr = Security::secure_input($params['descEditImage']);

               // RUTA DE LA IMAGEN - con el pathinfo — Devuelve en un array información acerca de la ruta de un fichero
               // Aquí cogeremos la info de la imagen antigua EditImageOld(hidden) que emos cargado en html con jquery
               $rutaImagen = pathinfo(($params['EditImageOld']));
               // var_dump($rutaImagen);
               // ARRAY:
                // array(4) { ["dirname"]=> string(50) "uploads/user/rubenfernandezpardo4@gmail.com/images" ["basename"]=> string(7) "111.jpg" ["extension"]=> string(3) "jpg" ["filename"]=> string(3) "111" }

               $oldextension = $rutaImagen['extension'];// Elegimos del array $rutaimagen la extension de la img (JPG)
               $path = '../uploads/products'; // ruta de la imagen nueva
               $handle = new \Verot\Upload\Upload($_FILES['EditImage']);  // cargamos la imagen nueva
               $extension = $handle->file_src_name_ext;// extension de img (si la imagen se ha cargado a la carpeta)
               $nombreImagen = $rutaImagen['dirname'] . '/' . $rutaImagen['basename']; //variable donde construimos el path de la img Aquí seleccionamos la ubicacion de la imagen y el nombre
               // var_dump($extension);

               if($oldTitle != $title  && $extension == ""){
                   // echo json_encode("Titulo diferente y no hay imagen seleccionada");
                   // // RENOMBRAR IMAGEN
                   sleep(1);
                   $oldfile = $path.'/'.$oldTitle.'.'.$oldextension;
                   $newfile = $path.'/'.$title.'.'.$oldextension;
                   rename($oldfile, $newfile);
                   // rename($path.'/'.$oldTitle.'.'.$oldextension, $path.'/'.$title.'.'.$oldextension);
                   // echo($path.'/'.$oldTitle.'.'.$oldextension, $path.'/'.$title.'.'.$oldextension);
                   $nombreImagen = $rutaImagen['dirname'].'/'.$title.'.'.$oldextension;


               }else if ($oldTitle == $title  && $extension != "") {
                   // echo json_encode("titulo no editado y imagen cargada diferente");
                   // BORRAMOS LA IMAGEN ANTIGUA
                   unlink($path . '/' . $oldTitle . '.' . $oldextension);
                   // CARGAMOS LA IMAGEN NUEVA
                   if($handle->uploaded){
                       $handle->dir_chmod = 0777; // permisos de lectura/escritura carpeta para Mac
                       $handle->file_new_name_body   = $title;
                       $handle->process('../uploads/products');
                       $nombreImagen = $rutaImagen['dirname'] . '/' . $title . '.' . $handle->file_src_name_ext;
                   }

               }

               // Haremos una llamada  al metodo editimageDB() a traves del Objeto CrudModel, allí recogera los parametros  y que nos devolverá un mensaje que mediante un switch  nos dirá si el UPDATE está OK o NO OK
               $model = new CrudModel;
               // Enviamos los parametros para hacer UPDATE( El $nombreImagen lo recoge el $image en el crudModel, no es necesario que se llame igual)
               $check = $model->editImageDB($id, $title, $categor, $descr, $nombreImagen);

               switch ($check) {
                   case 0:
                       echo json_encode('Ha habido un error en la actualización');
                       break;
                   case 1:
                       echo json_encode('Se ha actualizado correctamente');
                       break;
               }


           }


           // public function SuscripcionAnuncioAction($params){
           //     // Seleccionamos los emails de 'suscripciones'
           //     $model = new CrudModel();
           //     $suscripEmail = $model->SuscripcionAnuncioDB();
           //     // var_dump($suscripEmail);
           //
           //     // FOR para recorrer emails de array->  envío de html(anuncio)  por email a todos los emails suscritos
           //     for ($i=0; $i < count($suscripEmail); $i++) {
           //
           //         // echo $suscripEmail[$i]['email'];
           //         $emailUsuario = $suscripEmail[$i]['email'];
           //
           //         // GESTION DEL ENVIO DE EMAIL
           //
           //         // $href = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
           //         // $href = substr($href, 0, -9) . '/SuscripcionAnuncio';
           //         // OB_START Y OB END CLEAN meten esa vista con el twig dentro del body en App/Views/Email/registro.html
           //         ob_start();
           //         View::renderTwig('Email/SuscripcionAnuncio.html');
           //         $body = ob_get_contents();
           //         ob_end_clean();
           //         // SUBJECT = es el asunto del email
           //         $subject = '¡Nuevas patatas, ya a la venta!';
           //
           //         if(!Security::email($emailUsuario, $subject, $body)){
           //             echo json_encode('No se ha podido enviar el email');
           //         }else{
           //             echo json_encode('El email se ha enviado correctamente a todos los suscriptores');
           //         }
           //         break;
           //    }

           public function SuscripcionAnuncioAction($params){
               // Seleccionamos los emails de 'suscripciones'
               $model = new CrudModel();
               $suscripEmail = $model->SuscripcionAnuncioDB();
               // var_dump($suscripEmail);

               // GESTION DEL ENVIO DE EMAIL
               // $href = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
               // $href = substr($href, 0, -9) . '/SuscripcionAnuncio';
               // OB_START Y OB END CLEAN meten esa vista con el twig dentro del body en App/Views/Email/registro.html
               ob_start();
               View::renderTwig('Email/SuscripcionAnuncio.html');
               $body = ob_get_contents();
               ob_end_clean();
               // SUBJECT = es el asunto del email
               $subject = '¡Nuevas patatas, ya a la venta!';

               if(count($suscripEmail) == 1){
                   //  le pasaremos un párametro a la funcion email(), llamado $lista
                   //FALSE = 1 EMAIL UNICAMENTE
                   //TRUE = MAS DE 1 EMAIL

                   // le pasamos el email -> $suscripEmail[0]['email'];
                   if(!Security::email($suscripEmail[0]['email'], $subject, $body, false)){
                       echo json_encode('No se ha podido enviar el email');
                   }else{
                       echo json_encode('El email se ha enviado correctamente al suscriptor');
                   }


               }else if(count($suscripEmail) > 1){
                   //  $lista FALSE = HAY MAS DE UN EMAIL
                   if(!Security::email($suscripEmail, $subject, $body, true)){
                       echo json_encode('No se ha podido enviar el email');
                   }else{
                       echo json_encode('El email se ha enviado correctamente a todos los suscriptores');
                   }
               }else{
                   echo json_encode('Ha ocurrido un problema');
               }


         }

}
