 <?php

// Inicio
class Main extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->mensaje = "Bienvenido al sistema de administración de la Librería";
    }
    
    function render(){
        $this->view->render('main/index');
    }
    
    function otro(){
        echo "<p>Se ejecutó el método otro</p>";
    }
}

?>