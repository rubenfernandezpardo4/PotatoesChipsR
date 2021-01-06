<?php
// Carga del sistema de Autoloading
// autoload.php: Carga a través del "composer" todas las clases necesarias de 'requires' ó 'includes' para poder instanciar desde otro archivo
require dirname(__DIR__) . '/vendor/autoload.php';
// session_start — Iniciar una nueva sesión o reanudar la existente
session_start();

// Activación del reporte de todos los errores y mensajes informativos
error_reporting(E_ALL);
// pendiente
// Error and Exceptions Handling
set_exception_handler('Core\Error::exceptionHandler');//método que dice cual va a ser el manejador de excepciones

// Se define la constante 'CONFIG_DIR'
// Contiene la ruta hacia la carpeta de archivos de configuración
define('CONFIG_DIR', dirname(__DIR__) . '/Core/Config/');
// CHECK
// echo CONFIG_DIR;

// Se prepara una entrada en "$_GLOBALS['config']" para almacenar la configuración general de la app
$GLOBALS['config'] = array();

// opendir: crea un recurso que accede a la carpeta que apunta por medio de CONFIG_DIR
$dh = opendir(CONFIG_DIR);
// lee el contenido de los archivos "JSON" dentro de "CONFIG_DIR" mientras el recurso ó la lectura NO devuelva "FALSE"
while (FALSE !== ($file = readdir($dh))) {
    // para evitar los archivos ocultos './../'
    if($file != '.' && $file != '..'){
        // CHECK
        // echo $file;
        $file_name = pathinfo(CONFIG_DIR . $file, PATHINFO_FILENAME);
        $file_ext = pathinfo(CONFIG_DIR . $file, PATHINFO_EXTENSION);
        // CHECK
        // echo $file_name . "." . $file_ext . " ";

        // $config_key: Se eliminan los caracteres que no sean alfabéticos, tales como signos de puntuación y caracteres especiales
        $config_key = preg_replace("/[^\w]/","", $file_name);
        // CHECK
        // echo $config_key;

        // si el nombre del archivo de config. (app) es el correcto (.json)
        // filtrado a minúsculas
        if(strtolower($file_name) == 'app' && strtolower($file_ext) == 'json'){
            // Se procesa y almacena en la configuración "$_GLOBALS['config']" en la posición que marca el index '$config_key'
            // Entra en el IF, en el caso que en la variable "$_GLOBALS['config']" no exista una "key" con nombre "app" (Sobreescritura)
            if(!array_key_exists($config_key, $GLOBALS['config'])){
                $content = file_get_contents(CONFIG_DIR . $file);
                // si hay contenido
                if(FALSE !== $content){
                    // json_decode (true): recoje el contenido del .json como un objeto predefinido (stdClass)
                    // y añadiendo este 'true' este objeto será convertido a array asociativo.
                    $GLOBALS['config'][$config_key] = json_decode($content, true);
                }
            }
        }
        // CHECK
        // var_dump($_GLOBALS['config']);
    }
}
// Eliminamos el recurso que lista el contenido de 'CONFIG_DIR'
closedir($dh);
// Definición de la clase que representará la aplicación (frontcontroler)
// Se define también la constante 'APP' que contiene el nombre de la clase que representa la aplicación
// y que se instancia en 'index.php'
$app = $GLOBALS['config']['app']['front']['namespace'] . $GLOBALS['config']['app']['front']['class'];
// CHECK
// echo $app;
define('APP', $app);
// destruye la variable que contiene la config. inicial
unset($app);
