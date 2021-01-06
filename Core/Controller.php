<?php

namespace Core;



abstract class Controller extends Security{
    // método que se llama desde el FrontController y comprueba si existe el metodo del controlador de la APP (ya que hereda de éste)
    public function callAction($action, $params = []){
        // Concateno el string 'Action' en la acción para nombrarlo en los controladores de la App
        $method = $action . 'Action';
        // En $this tengo el objeto del controlador ($controller) que llama a este método en 'FrontController'
        if(method_exists($this, $method)){

            $array_params = [$params];
            // llamada al método de una clase enviando parámetros a dicho método
            // analogía: $controller->$method([$params]);
            // $controller = new HomeController;
            // $controller->indexAction($array_params);
            call_user_func_array([$this, $method], $array_params);

        } else { echo 'Acción (método): "' . $method . '" no encontrada en el controlador'; }
    }
}
