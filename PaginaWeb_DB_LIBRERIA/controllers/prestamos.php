<?php

// Registrar prestamos
class Prestamos extends Controller{
    function __construct(){
        parent::__construct();
    }
    
    function render(){
        $this->view->render('prestamos/index');
    }
    
    function verUsuariosHabilitados(){
        $usuarios = $this->model->getUsers();
        $this->view->datos = $usuarios;
        $this->view->render('prestamos/usuarios');
    }
    
    function verLibrosStock($params = null){
        // Si el parametro no es nulo
        if($params){
            // Para evitar modificaciones desde la vista
            session_start();
            $_SESSION['id_usuario'] = $params[0];  // Siempre se debe elegir un usuario antes
            $this->view->seleccion = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
            // Si ya se han elegido libros
            if(count($params) > 1){
                $librosSeleccionados = [];
                for($i = 1; $i <= (count($params) - 1); $i++){
                    array_push($librosSeleccionados, $params[$i]);
                }
                $_SESSION['ids_libros_seleccionados'] = $librosSeleccionados;
                $this->view->elegidos = isset($_SESSION['ids_libros_seleccionados']) ? $_SESSION['ids_libros_seleccionados'] : null;
            }
        }
        
        $libros = $this->model->getBooks();
        $this->view->datos = $libros;
        $this->view->render('prestamos/libros');
    }
    
    function verResumenPrestamo($params = null){
        // Si el parametro no es nulo
        if($params){
            // Para evitar modificaciones desde la vista
            session_start();
            $_SESSION['id_usuario'] = $params[0];  // Siempre se debe elegir un usuario antes
            $this->view->seleccion = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
            // Si ya se han elegido libros
            if(count($params) > 1){
                $librosSeleccionados = [];
                for($i = 1; $i <= (count($params) - 1); $i++){
                    array_push($librosSeleccionados, $params[$i]);
                }
                $_SESSION['ids_libros_seleccionados'] = $librosSeleccionados;
                $this->view->elegidos = isset($_SESSION['ids_libros_seleccionados']) ? $_SESSION['ids_libros_seleccionados'] : null;
            }
        }
        
        $libros = $this->model->getBooks();
        $this->view->datos = $libros;
        $usuario = $this->model->getUser($this->view->seleccion);
        $this->view->seleccion = $usuario;
        
        $this->view->render('prestamos/resumen');
    }
    
    function registrarPrestamo($params = null){
        // Si el parametro no es nulo
        if($params){
            // Para evitar modificaciones desde la vista
            session_start();
            $_SESSION['id_usuario'] = $params[0];  // Siempre se debe elegir un usuario antes
            $idUsuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
            // Si ya se han elegido libros
            if(count($params) > 1){
                $librosSeleccionados = [];
                for($i = 1; $i <= (count($params) - 1); $i++){
                    array_push($librosSeleccionados, $params[$i]);
                }
                $_SESSION['ids_libros_seleccionados'] = $librosSeleccionados;
                $idsStock = isset($_SESSION['ids_libros_seleccionados']) ? $_SESSION['ids_libros_seleccionados'] : null;
            }
        }
        
        // Si la ejecucion fue exitosa
        if($this->model->insert(['idUsuario' => $idUsuario, 'idsStock' => $idsStock])){
            $mensaje = "Prestamo realizado";
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
    
    function verPrestamosActivos(){
        $prestamos = $this->model->getLoans();
        $this->view->datos = $prestamos;
        $this->view->render('prestamos/prestamos');
    }
    
    function realizarDevolucion($params = null){
        // Si la ejecucion fue exitosa
        if($this->model->update(['idsPrestamos' => $params])){
            $mensaje = "Devolución realizada";
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