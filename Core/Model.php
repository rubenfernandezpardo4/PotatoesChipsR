<?php

namespace Core;

use PDO;

class Model{
    // incializamos a null (cerrar conexión en PDO) y declaramos como static Se puede acceder sin instancia
    private static $instanceDB = null;

    public function __construct(){

            $DB_HOST = $GLOBALS['config']['app']['db']['host'];
            $DB_PORT = $GLOBALS['config']['app']['db']['port'];
            $DB_NAME = $GLOBALS['config']['app']['db']['dbname'];
            $DB_USER = $GLOBALS['config']['app']['db']['user'];
            $DB_PASS = $GLOBALS['config']['app']['db']['pass'];

            self::$instanceDB = new PDO("mysql:host=$DB_HOST;port=$DB_PORT;dbname=$DB_NAME;charset=UTF8",$DB_USER,$DB_PASS);
        }
    // PATRÓN SINGLETON: Sirve para devolver la conexión dependiendo si ya existe o no. En el caso de que exista, sólo devuelve y en lo contrario,
    // crea nueva instancia. Así no se generan múltiples peticiones de conexión en la APPD
    public static function getInstanceDB(){
        if(!self::$instanceDB){
            new self();
        }
        return self::$instanceDB;
    }
    // cierra la conexión
    public static function closeDB(){
        self::$instanceDB = null;
    }

}
