<?php

namespace Core;


class Error{

    public static function exceptionHandler($exception){

        $code = $exception->getCode();

        http_response_code($code);

        if($GLOBALS['config'] ['app'] ['show_errors'] ['display']  == 'true'){

            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace: <pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' online " . $exception->getLine() . "</p>";

        }else{
            // echo $code;
            View::renderTwig("$code.html");
        }

    }

}


?>
