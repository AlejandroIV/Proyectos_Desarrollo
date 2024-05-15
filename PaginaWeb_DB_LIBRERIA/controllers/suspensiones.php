<?php

// Registrar prestamos
class Suspensiones extends Controller{
    function __construct(){
        parent::__construct();
    }
    
    function render(){
        $this->view->render('suspensiones/index');
    }
    
    function verUsuariosHabilitados(){
        $usuarios = $this->model->get();
        $this->view->datos = $usuarios;
        $this->view->exito = true;
        $this->view->render('suspensiones/usuarios');
    }
    
    function verUsuariosSuspendidos(){
        $usuarios = $this->model->get();
        $this->view->datos = $usuarios;
        $this->view->render('suspensiones/usuarios');
    }
    
    function registrarSuspension($param){
        // Si la ejecucion fue exitosa
        if($this->model->insert($param[0])){
            $mensaje = "Suspensión aplicada";
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
    
    function cancelarSuspension($param){
        // Si la ejecucion fue exitosa
        if($this->model->update($param[0])){
            $mensaje = "Suspensión cancelada";
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