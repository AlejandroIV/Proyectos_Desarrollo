<?php

include_once 'models/usuario.php';
include_once 'models/librostock.php';
include_once 'models/usuariocontacto.php';
include_once 'models/prestamo.php';

class PrestamosModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getUsers(){
        $items = [];
        
        // Consulta datos de la tabla 'TBL_USUARIO' de la base de datos
        try{
            $query = $this->db->connect()->query("SELECT * FROM FN_CONSULTAR_USUARIOS_HABILITADOS();");
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new Usuario();

                $item->vcIdUsuario = $row['vcidusuario'];
                $item->vcNombreCompleto = $row['vcnombrecompleto'];
                array_push($items, $item);
            }
            
            return $items;
        }
        catch(PDOException $e){
            //print_r("Error en getUsers de prestamosmodel: " . $e->getMessage());
            return [];
        }
    }
    
    public function getBooks(){
        $items = [];
        
        // Consulta datos de la tabla 'TBL_STOCK' de la base de datos
        try{
            $query = $this->db->connect()->query("SELECT * FROM FN_CONSULTAR_LIBROS_STOCK();");
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new LibroStock();

                $item->vcIdLibro = $row['vcidlibro'];
                $item->vcTitulo = $row['vctitulo'];
                $item->vcCategoria = $row['vccategoria'];
                $item->vcAutores = $row['vcautores'];
                $item->siAnhoPublicacion = $row['sianhopublicacion'];
                $item->vcCiudadPublicacion = $row['vcciudadpublicacion'];
                $item->vcEditorial = $row['vceditorial'];
                $item->tiEdicion = $row['tiedicion'];
                $item->cIsbn = $row['cisbn'];
                $item->iIdStock = $row['iidstock'];
                $item->siCantidadDisponible = $row['sicantidaddisponible'];
                $item->vcIdUbicacion = $row['vcidubicacion'];
                $item->vcDescripcionUbicacion = $row['vcdescripcionubicacion'];
                $item->siCantidadTotal = $row['sicantidadtotal'];

                array_push($items, $item);
            }
            
            return $items;
        }
        catch(PDOException $e){
            //print_r("Error en getBooks de prestamosmodel: " . $e->getMessage());
            return [];
        }
    }
    
    public function getUser($param){
        $items = [];
        
        // Consulta datos de la tabla 'TBL_PERSONA' de la base de datos
        try{
            $query = $this->db->connect()->prepare("
                SELECT * FROM FN_CONSULTAR_USUARIO_CONTACTO(
                    '" . $param . "'::VARCHAR(7)
                );
            ");
            $query->execute();
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new UsuarioContacto();

                $item->vcNombreCompleto = $row['vcnombrecompleto'];
                $item->vcIdUsuario = $param;
                $item->vcTelefono = $row['vctelefono'];
                $item->vcCorreoElectronico = $row['vccorreoelectronico'];

                array_push($items, $item);
            }
            
            return $items;
        }
        catch(PDOException $e){
            //print_r("Error en getUser de prestamosmodel: " . $e->getMessage());
            return [];
        }
    }
    
    public function insert($param){
        $idsPrestamos = [];
        
        // Generar IDs unicos
        for($i = 0; $i < count($param['idsStock']); $i++){
            // Generar un ID unico
            do{
                $vcIdPrestamo = $this->generateUniqueID(rand(1, 6));
                $query = $this->db->connect()->prepare("SELECT COUNT(vcIdPrestamo) AS iCantidadIdsPrestamos FROM TBL_PRESTAMO WHERE vcIdPrestamo = :vcIdPrestamo");
                try{
                    $query->execute(['vcIdPrestamo' => $vcIdPrestamo]);
                    $existenRegistros = $query->fetch(PDO::FETCH_ASSOC)['icantidadidsprestamos'];
                }
                catch(PDOException $e){
                    //print_r("Error en insert de prestamosmodel: " . $e->getMessage());
                    return false;
                }
            } while($existenRegistros > 0 || in_array($vcIdPrestamo, $idsPrestamos));
            array_push($idsPrestamos, $vcIdPrestamo);
        }
        // Actualizar datos de las tablas 'TBL_STOCK' y 'TBL_LIBRO_VENTA' de la base de datos
        try{
            $query = $this->db->connect()->prepare("
                CALL SPD_INSERTAR_PRESTAMO(
                    ARRAY['" . implode("','", $idsPrestamos) . "']::VARCHAR(6)[],
                    '" . $param['idUsuario'] . "'::VARCHAR(7),
                    ARRAY[" . implode(",", $param['idsStock']) . "]::INT[]
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            //echo ("Error en insert de prestamosmodel: " . $e->getMessage());
            return false;
        }
    }
    
    public function getLoans(){
        $items = [];
        
        // Consulta datos de la tabla 'TBL_PRESTAMO' de la base de datos
        try{
            $query = $this->db->connect()->query("SELECT * FROM FN_CONSULTAR_PRESTAMOS();");
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new Prestamo();

                $item->vcIdPrestamo = $row['vcidprestamo'];
                $item->dFechaPrestamo = $row['dfechaprestamo'];
                $item->dFechaDevolucion = $row['dfechadevolucion'];
                $item->vcNombreCompleto = $row['vcnombrecompleto'];
                $item->vcTelefono = $row['vctelefono'];
                $item->vcCorreoElectronico = $row['vccorreoelectronico'];
                $item->vcEstado = $row['vcestado'];
                $item->vcTitulo = $row['vctitulo'];
                $item->vcCategoria = $row['vccategoria'];
                $item->vcAutores = $row['vcautores'];
                $item->siAnhoPublicacion = $row['sianhopublicacion'];
                $item->vcCiudadPublicacion = $row['vcciudadpublicacion'];
                $item->vcEditorial = $row['vceditorial'];
                $item->tiEdicion = $row['tiedicion'];
                $item->cIsbn = $row['cisbn'];

                array_push($items, $item);
            }
            
            return $items;
        }
        catch(PDOException $e){
            //print_r("Error en getLoans de prestamosmodel: " . $e->getMessage());
            return [];
        }
    }
    
    public function update($param){
        // Actualizar datos de las tablas 'TBL_PRESTAMO' de la base de datos
        try{
            $query = $this->db->connect()->prepare("
                CALL SPD_REALIZAR_DEVOLUCION(
                    ARRAY['" . implode("','", $param['idsPrestamos']) . "']::VARCHAR(6)[]
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            //echo ("Error en update de prestamosmodel: " . $e->getMessage());
            return false;
        }
    }
}

?>
   