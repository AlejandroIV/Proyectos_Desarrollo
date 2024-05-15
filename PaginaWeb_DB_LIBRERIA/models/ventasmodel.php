<?php

include_once 'models/libroventa.php';

class VentasModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function get(){
        $items = [];
        
        // Consulta datos de la tabla 'TBL_LIBRO_VENTA' de la base de datos
        try{
            $query = $this->db->connect()->query("SELECT * FROM FN_CONSULTAR_LIBROS_VENTAS();");
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new LibroVenta();

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
                $item->cIdLibroVenta = $row['cidlibroventa'];
                $item->siCantidadParaVenta = $row['sicantidadparaventa'];
                $item->decPrecioUnitario = $row['decpreciounitario'];
                $item->siCantidadTotal = $row['sicantidadtotal'];

                array_push($items, $item);
            }
            
            return $items;
        }
        catch(PDOException $e){
            //print_r("Error en get de ventasmodel: " . $e->getMessage());
            return [];
        }
    }
    
    function insert($items){
        $idStocks = [];
        $idLibrosVenta = [];
        $cantidades = [];
        
        foreach($items as $item){
            array_push($idStocks, $item['idStock']);
            array_push($idLibrosVenta, $item['idLibroVenta']);
            array_push($cantidades, $item['cantidad']);
        }
        
        // Generar cadena con el formato adecuado para poder pasarlo como argumentos para el procedimiento
        $argsIdStocks = str_replace(array('"', '\\'), '', json_encode($idStocks));  // Elimina los " y \\
        $argsIdLibrosVenta = str_replace(array('"'), "'", json_encode($idLibrosVenta)); // Usa comillas simples
        $argsCantidades = str_replace(array('"', '\\'), '', json_encode($cantidades));
        
        // Insertar datos en la tabla 'TBL_VENTAS' de la base de datos
        try{
            // Convertir arrays en cadenas separadas por comas, formar consulta y ejecutar
            $query = $this->db->connect()->prepare("
                CALL SPD_INSERTAR_VENTAS(
                    ARRAY" . $argsIdStocks . "::INT[],
                    ARRAY" . $argsIdLibrosVenta . "::CHAR(4)[],
                    ARRAY" . $argsCantidades . "::SMALLINT[]
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            print_r("Error en insert de ventasmodel: " . $e->getMessage());
            return false;
        }
    }
}

?>