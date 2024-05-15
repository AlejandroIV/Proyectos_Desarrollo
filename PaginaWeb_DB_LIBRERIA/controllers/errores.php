<?php

// Manejar errores
class Errores extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->mensaje = "Ha ocurrido un error";
        $this->view->render('errores/index');
    }
}

?>