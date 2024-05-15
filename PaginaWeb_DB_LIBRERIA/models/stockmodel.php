<?php

include_once 'models/libro.php';

class StockModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function get(){
        $items = [];
        
        // Consulta datos de la tabla 'CTLG_LIBRO' de la base de datos
        try{
            $query = $this->db->connect()->query("SELECT * FROM FN_CONSULTAR_LIBROS();");
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new Libro();

                $item->vcIdLibro = $row['vcidlibro'];
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
            //print_r("Error en get de stockmodel: " . $e->getMessage());
            return [];
        }
    }
    
    public function insert($datos){
        // Insertar datos en la tabla 'TBL_STOCK' de la base de datos
        try{
            // Convertir arrays en cadenas separadas por comas, formar consulta y ejecutar
            $query = $this->db->connect()->prepare("
                CALL SPD_INSERTAR_STOCK(
                    ARRAY['" . implode("', '", $datos['libros']) . "']::VARCHAR(4)[],
                    ARRAY['" . implode("', '", $datos['ubicaciones']) . "']::VARCHAR(3)[],
                    ARRAY[" . implode(", ", $datos['cantidades']) . "]::SMALLINT[]
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            //print_r("Error en insert de stockmodel: " . $e->getMessage());
            return false;
        }
    }
}

?>