<?php
namespace App\Models;

use Core\Model;
use PDO;

class CrudModel extends Model{

    private $db;

    public function __construct(){
        $this->db = Model::getInstanceDB();
    }

    // Comprueba si el email(user) ya está registrado
    public function datauserDB($user){
        // datos de USERS
        $sql = "select * from users where user = :user";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $dataUser =  $stmt->fetch(PDO::FETCH_ASSOC);


        // datos de PRODUCTOS
        $sql = "select * from productos";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $dataImgUser =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        // var_dump($dataUser['id']);
        // var_dump($dataImgUser);

        return array($dataUser, $dataImgUser);
        // var_dump($dataImgUser[1]);

    }

    // recogemos la informacion de productos
    public function dataProductsDB(){

        $sql = "select * from productos order by categorias_idcategorias";
        $stmt = $this->db->prepare($sql);
        // $stmt->bindParam(':categorias_idcategorias', $categor);
        $stmt->execute();
        $dataProducts =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($dataProducts);
        return $dataProducts;
    }


    // funcion para seleccionar titulo y comprobar si existe
    public function titleDB($title){

        $sql = "select title from productos where title = :title";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $title);

        if($stmt->execute()){

            $rows = $stmt->rowCount();

            if ($rows == 1) {
                return true; //titulo ya existe
            } else {
                return false; //titulo no existe
            }
        }else{
            return false; //Ha habido algun problema con la bbdd

        }
    }


    // AÑADIR IMAGEN
    public function addImageDB($title, $categor, $descr, $image){

        // $dataUser = $this->datauserDB($user);
        $sql = "insert into productos values (null, :title, :descr, :image, :categorias_idcategorias)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':categorias_idcategorias', $categor);
        $stmt->bindParam(':descr', $descr);
        $stmt->bindParam(':image', $image);

        // echo($categorias_idcategorias);

        if($stmt->execute()){
            return 1; //INSERT DE IMAGEN OK

        }else{
            return 0; //INSERT KO

        }
    }

    // BORRAR IMAGEN
    public function deleteImageDB($idproductos){

        $sql = 'delete from productos where idproductos = :idproductos';
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(":idproductos", $idproductos);
        // $stmt->bindParam(':title', $title);

        if($stmt->execute()){
            return 1; // delete OK
        }else{
            return 0; // delete KO
        }
    }

    // EDITAR IMAGEN
    public function editImageDB($id, $title, $categor, $descr, $image){

        $sql = 'update productos set title = :title, descr = :descr, image = :image, categorias_idcategorias = :categorias_idcategorias where idproductos = :idproductos';

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':idproductos', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':descr', $descr);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':categorias_idcategorias', $categor);


        if($stmt->execute()){
            return 1; //Se ha actualizado la imagen correctamente
        }else{
            return 0; //Ha habido un error en la actualización
        }

    }


    // Seleccionamos los emails de Suscripciones, donde además el newsletter = 1 (esten dados de alta)
    public function SuscripcionAnuncioDB(){

        $sql = "select email from suscripciones where newsletter = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $suscripEmail =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        // var_dump($suscripEmail);

        return $suscripEmail;
    }


}
