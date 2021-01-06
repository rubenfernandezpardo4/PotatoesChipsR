<?php
namespace App\Models;

use Core\Model;
use PDO;

class UserModel extends Model{

    private $db;

    public function __construct(){
        $this->db = Model::getInstanceDB();
    }

    // Comprueba si el email ya está registrado
    public function dataUser($user){

        $sql = "select * from users where user = :user";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user', $user);
        // Retorna un false si no hay lectura de usuario (email no registrado)
        if ($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_ASSOC) ?? false;
        } else {
            return false;
        }

    }

    // LOGIN  ADMIN
    public function adminLoginDB($user, $pass){

        $data = $this->dataUser($user);


        if(!$data){
            return 0; // user incorrecto
        }else{
            if ($data['IsAdmin'] == 0) {  // IsAdmin == 0(false)  -> No esta insertado en la BBDD
                return 1;  //'Falta insertar(poner un true o un 1) IsAdmin en la BBDD'

            } else if ($data['IsAdmin'] == 1){

                $sql = "select * from users where user = :user and pass = :pass";
                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':user', $user);
                $stmt->bindParam(':pass', $pass);

                if(!$stmt->execute()){
                    return 2; //Error en el login
                }else{
                    $rows = $stmt->rowCount();

                    if ($rows == 1) {
                        return 3; //Login correcto
                    } else {
                        return 0; //pass incorrecto
                    }

                }
            }
        }
    }

    // Hacemos un insert de datos de suscripciones
    public function SuscripcionInsertDB($nombre, $apellidos, $email){

        // En el insert pondremos en 1 el campo newsletter(como que ya está suscrito)
        $sql = "insert into suscripciones values(null, :nombre, :apellidos, :email, 1, default)";
        $stmt = $this->db->prepare($sql);

        $id = null;
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':email', $email);

        if($stmt->execute()){
            return 1; //INSERT DE IMAGEN OK

        }else{
            return 0; //INSERT KO

        }

    }




}
