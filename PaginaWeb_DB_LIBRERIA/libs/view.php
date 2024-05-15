<?php

class View{
    public $mensaje;
    public $datos;
    public $exito;
    public $elegidos;
    public $seleccion;
    
    function __construct(){
        
    }
    
    function render($nombre){
        require 'views/' . $nombre . '.php';
    }
}

?>