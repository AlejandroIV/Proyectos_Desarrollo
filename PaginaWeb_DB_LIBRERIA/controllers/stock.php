<?php

// Registrar stock
class Stock extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->mensaje = "";
    }
    
    function render(){
        $libros = $this->model->get();
        $this->view->datos = $libros;
        $this->view->render('stock/index');
    }
    
    function registrarStock(){
        $libros = $_POST['libros'];
        $ubicaciones = $_POST['ubicaciones'];
        $cantidades = $_POST['cantidades'];
        
        $mensaje = "";
        
        // Si la ejecucion fue exitosa
        if($this->model->insert(['libros' => $libros, 'ubicaciones' => $ubicaciones, 'cantidades' => $cantidades])){
            $mensaje = "Stock registrado";
            $exito = true;
        }
        else{
            $mensaje = "Ha ocurrido un error";
            $exito = false;
        }
        
        $this->view->mensaje = $mensaje;
        $this->view->exito = $exito;
        $this->render();
    }
}

?>