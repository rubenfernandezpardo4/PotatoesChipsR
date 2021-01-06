<?php
namespace App\Controllers;
// use: va unido a los namespaces. Funciona como un require, include...
use Core\Controller;
use Core\View;
use App\Models\UserModel;
use Core\Security;


class UserController extends Controller{

    // renderiza el html de formulario Suscripcion
    public function renderSuscripcionAction(){
        View::renderTwig('User/suscripcion.html');
    }

    // AQUÍ pintaremos con el twig la vista del LOGIN únicamente para el admin (previamente insertado en la bbdd)
    public function renderLoginAdminAction(){
        View::renderTwig('User/loginAdmin.html');
    }

    // LOGIN ADMIN
    public function adminLoginAction($params){
        sleep(5);

        $user = Security::secure_input($params['lg_user']);
        $pass = Security::secure_input($params['lg_pass']);

        $logearse = new UserModel();
        $check = $logearse->adminLoginDB($user, $pass);

        switch ($check) {
            case 0:
            echo json_encode('Datos erróneos');
            break;
            case 1:
            echo json_encode('Falta dar permiso al ADMIN en la Base de datos');
            break;
            case 2:
            echo json_encode('Error en el login');
            break;
            case 3:
            $_SESSION['SESSEMAIL'] = $user; // email user
            echo json_encode('Login correcto');

            break;
            default:
            echo json_encode('Error en la base de datos');
            break;
        }

    }

    // SUSCRIPCION_____________________________________________________________________________________________
    public function SuscripcionAction($params){

        sleep(2);
        // recogemos info del formulario
        $nombre = Security::secure_input($params['nombre']);
        $apellidos = Security::secure_input($params['apellidos']);
        $email = Security::secure_input($params['email']);

        // hacemos insert
        $model = new UserModel();
        $Suscrip = $model->SuscripcionInsertDB($nombre, $apellidos, $email);
        // var_dump($Suscrip);

        switch ($Suscrip) {
            case 0:
                   echo json_encode('Error');
                break;
            case 1:
                   echo json_encode('Se han añadido correctamente sus datos');
                break;
            default:
                   echo json_encode('Error en la base de datos');
                break;
        }

    }




    // CERRAR SESION
    public function closeAction(){
        // session_destroy() — Destruye toda la información registrada de una sesión(cerramos sesión)
        session_destroy();
        // SI CERRAMOS SESION BORRAREMOS LA COOKIE TAMBIEN
        $time = time() - 1; //cualquier fecha anterior a la actual(-1)
        setcookie('USER', '', $time, '/');
        // Que me redireccione al index al cerrar la sesion
        header('location: index');

    }

}
