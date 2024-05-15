<?php

// Registrar libros para venta
class Libros extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->datos = [];
    }
    
    function render(){
        $libros = $this->model->get();
        $this->view->datos = $libros;
        $this->view->render('libros/index');
    }
    
    function verDetallesLibro($param){
        // Para evitar modificaciones desde la vista
        session_start();
        $_SESSION['id_libro'] = $param[2];
        $_SESSION['id_ubicacion'] = $param[3];
        
        $this->view->datos = $param;
        $this->view->render('libros/detalle');
    }
    
    function actualizarDetallesLibro($param = null){
        // Para evitar modificaciones desde la vista
        session_start();
        $idLibro = isset($_SESSION['id_libro']) ? $_SESSION['id_libro'] : null;
        $idUbicacion = isset($_SESSION['id_ubicacion']) ? $_SESSION['id_ubicacion'] : null;

        
        $cantidadDisponible = $_POST['cantidadDisponible'];
        $cantidadVenta = $_POST['cantidadVenta'];
        $precio = $_POST['precio'];
        
        unset($_SESSION['id_libro']);
        unset($_SESSION['id_ubicacion']);
        
        // Si la ejecucion fue exitosa
        if($this->model->update(['idLibro' => $idLibro, 'idUbicacion' => $idUbicacion, 'cantidadDisponible' => $cantidadDisponible, 'cantidadVenta' => $cantidadVenta, 'precio' => $precio])){
            $mensaje = "Cambios realizados";
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
    
    function eliminarDetallesLibro($param = null){
        $idLibro = $param[0];
        $idUbicacion = $param[1];
        
        // Si la ejecucion fue exitosa
        if($this->model->delete(['idLibro' => $idLibro, 'idUbicacion' => $idUbicacion])){
            $mensaje = "Eliminación realizada";
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