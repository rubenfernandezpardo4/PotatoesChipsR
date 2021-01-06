<?php
// Bootstrap.php: Requiere del archivo de configuración inicial con la que funcionará la aplicación
require dirname(__DIR__) . '/Core/Bootstrap.php';
// dirname(__DIR__): Devuelve la ruta de la carpeta raiz del proyecto
// CHECK
// echo dirname(__DIR__);

// La clase ReflectionClass devuelve la información sobre una clase 'FrontController'
// https://www.php.net/manual/es/class.reflectionclass.php
$reflector = new ReflectionClass(APP);
$app = $reflector->newInstance();
$app->run();
