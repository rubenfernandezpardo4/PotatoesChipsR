<?php
/**
* namespace:
* https://www.php.net/manual/es/language.namespaces.rationale.php
*/
namespace Core;

class FrontController{
    /*
    * componente de enrutamiento
    */
    protected $routing;
    /*
    * ruta que se carga después del dominio de la URL
    */
    public $request_uri;
    /*
    * información recibidad a través de los parámetros de la URL
    * ó de los datos enviados mediante el formulario
    */
    public $params;
    /*
    * Constructor:
    * Crea el componente de "Router" que permitirá averiguar
    * el controller y la acción que se ejecutará para dar una respuesta
    * a la petición '$_REQUEST'
    */
    public function __construct(){
        $this->routing = new Router;
        // CHECK
        // var_dump($this->routing);
    }
    // Método que se ejecuta para dar una respuesta a la petición.
    // Se ejecuta desde "index.php"
    public function run(){
        // URL que se emplea para acceder a la página
        $this->request_uri = $_SERVER['REQUEST_URI'];
        // CHECK
        // echo $this->request_uri;
        // parse_url: analiza una URL y devuelve un array asociativo que contiene aquellos componentes presentes en la URL (path)
        $this->request_uri = parse_url($this->request_uri);
        // CHECK
        // var_dump($this->request_uri);
        $this->request_uri = $this->request_uri['path'];
        // CHECK
        // var_dump($this->request_uri);

        // Se combina en 'params' todos los datos recibidos por 'GET' y 'POST'
        $this->params = array_merge($_GET, $_POST);
        // CHECK
        // var_dump($this->params);

        // Obtenemos el controlador (clase) solicitado mediante un método del Router 'getController()'
        // $this->routing: Objeto creado de Router (contruct)
        $controller = $this->routing->getController($this->request_uri);
        // $controller->index();
        // CHECK
        // var_dump($controller);

        // TODO Challenge 4: Añadir el código PHP que se indica en el ejercicio del Challenge 4
        $action = $this->routing->getAction($this->request_uri);
        // $controller->$action();
        // Final TODO Challenge 4

        // método que se ejecuta en el Controller
        $controller->callAction($action, $this->params);
        // exit: para la ejecución del programa (FrontController ya ha realizado todas sus tareas)
        exit;
    }
}
