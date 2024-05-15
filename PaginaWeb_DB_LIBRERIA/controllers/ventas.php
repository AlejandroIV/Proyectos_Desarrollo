<?php

// Registrar ventas
class Ventas extends Controller{
    function __construct(){
        parent::__construct();
    }
    
    function render($params = null){
        $libros = $this->model->get();
        $this->view->datos = $libros;
        
        // Para evitar modificaciones desde la vista
        session_start();
        $_SESSION['ids_libros_seleccionados'] = $params;
        $this->view->elegidos = isset($_SESSION['ids_libros_seleccionados']) ? $_SESSION['ids_libros_seleccionados'] : null;
        
        $this->view->render('ventas/index');
    }
    
    function verResumenVenta($params = null){
        // Para evitar modificaciones desde la vista
        session_start();
        $_SESSION['ids_libros_seleccionados'] = $params;
        
        $libros = $this->model->get();
        $this->view->datos = $libros;
        $this->view->render('ventas/resumen');
    }
    
    function registrarVenta($params = null){
        $items = [];
        
        foreach($params as $item){
            $datos = explode("_", $item);
            $idStock = $datos[0];
            $idLibroVenta = $datos[1];
            $cantidad = $datos[2];
            
            array_push($items, ['idStock' => $idStock, 'idLibroVenta' => $idLibroVenta, 'cantidad' => $cantidad]);
        }
        
        // Si la ejecucion fue exitosa
        if($this->model->insert($items)){
            $mensaje = "Venta registrada";
            $exito = true;
        }
        else{
            $mensaje = "Ha ocurrido un error";
            $exito = false;
        }
        
        $this->view->mensaje = $mensaje;
        $this->view->exito = $exito;
        $this->render(null);
    }
}

?>