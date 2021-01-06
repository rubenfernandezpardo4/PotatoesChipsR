<?php
namespace App\Controllers;
// use: va unido a los namespaces. Funciona como un require, include...
use Core\Controller;
use Core\View;
use App\Models\CrudModel;


class StaticController extends Controller{

    public function renderIndexAction(){

        //RENDERIZA EN INDEX LOS PRODUCTOS
        $model = new CrudModel;
        $dataProducts = $model->dataProductsDB();

        // var_dump($dataProducts);

        if ($dataProducts == 0) {
            echo 'Error en la base de datos';
        } else {
            // AQUÍ IRÁ EL ARRAY DE LOS PRODUCTOS DEL 'Crud'
            // Pintado de productos en index($dataproducts)
            View::renderTwig('Static/index.html', array('dataProducts'=>$dataProducts));

        }
        // var_dump($dataProducts);
    }

    public function renderSliderAction(){
        View::renderTwig('Static/slider.html');
    }

    public function renderCuriosidadesAction(){
        View::renderTwig('Static/curiosidades.html');
    }

    public function renderDondeestamosAction(){
        View::renderTwig('Static/dondeestamos.html');
    }
}
