<?php

require_once 'controllers/errores.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class App{
    function __construct(){
        $url = isset($_GET['url']) ? $_GET['url']: null;
        $url = rtrim($url, '/');
        $url = explode('/', $url);
        
        // Cuando se ingresa sin definir controlador
        if(empty($url[0])){
            $archivoController = 'controllers/main.php';
            require_once $archivoController;
            $controller = new Main();
            $controller->loadModel('main');
            $controller->render();
            return false;
        }
        
        $archivoController = 'controllers/' . $url[0] . '.php';
        
        // Si el archivo del controlador existe
        if(file_exists($archivoController)){
            require_once $archivoController;
            
            // Inicializar el controlador
            $controller = new $url[0];
            $controller->loadModel($url[0]);
            
            /* Numero de elementos del arreglo 'url'
             * 1 - Solamente se crea el controlador
             * 2 - Se llama un metodo del controlador
             * 3 o mas - Se estan pasando argumentos a un metodo /*
             */
            $nparam = sizeof($url);
            
            if($nparam > 1){
                if($nparam > 2){
                    $param = [];
                    for($i = 2; $i < $nparam; $i++){
                        array_push($param, $url[$i]);
                    }
                    $controller->{$url[1]}($param);
                }
                // Si no hay argumentos que pasar a un metodo
                else{
                    $controller->{$url[1]}();  // Llamar metodo
                }
            }
            // Si no se ha llamado a un metodo
            else{
                $controller->render();  // Cargar la vista del controlador
            }
        }
        else{
            $controller = new Errores();
        }
    }
}

?>