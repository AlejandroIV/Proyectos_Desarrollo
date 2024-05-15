<?php

include_once 'models/librodetalle.php';

class LibrosModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function get(){
        $items = [];
        
        // Consulta datos de la tabla 'CTLG_LIBRO' de la base de datos con detalles
        try{
            $query = $this->db->connect()->query("SELECT * FROM FN_CONSULTAR_DETALLES_LIBROS();");
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new LibroDetalle();

                $item->vcIdLibro = $row['vcidlibro'];
                $item->vcTitulo = $row['vctitulo'];
                $item->vcCategoria = $row['vccategoria'];
                $item->vcAutores = $row['vcautores'];
                $item->siAnhoPublicacion = $row['sianhopublicacion'];
                $item->vcCiudadPublicacion = $row['vcciudadpublicacion'];
                $item->vcEditorial = $row['vceditorial'];
                $item->tiEdicion = $row['tiedicion'];
                $item->cIsbn = $row['cisbn'];
                $item->siCantidadDisponible = $row['sicantidaddisponible'];
                $item->vcIdUbicacion = $row['vcidubicacion'];
                $item->vcDescripcionUbicacion = $row['vcdescripcionubicacion'];
                $item->siCantidadParaVenta = $row['sicantidadparaventa'];
                $item->decPrecioUnitario = $row['decpreciounitario'];
                $item->siCantidadTotal = $row['sicantidadtotal'];

                array_push($items, $item);
            }
            
            return $items;
        }
        catch(PDOException $e){
            //print_r("Error en get de librosmodel: " . $e->getMessage());
            return [];
        }
    }
    
    public function update($item){
        // Generar un ID unico
        do{
            $cIdLibroVenta = $this->generateUniqueID(4);
            $query = $this->db->connect()->prepare("SELECT COUNT(cIdLibroVenta) AS iCantidadIdsLibrosVentas FROM TBL_LIBRO_VENTA WHERE cIdLibroVenta = :cIdLibroVenta");
            try{
                $query->execute(['cIdLibroVenta' => $cIdLibroVenta]);
                $existenRegistros = $query->fetch(PDO::FETCH_ASSOC)['icantidadidslibrosventas'];
            }
            catch(PDOException $e){
                //print_r("Error en update de librosmodel: " . $e->getMessage());
                return false;
            }
        } while($existenRegistros > 0);
        // Actualizar datos de las tablas 'TBL_STOCK' y 'TBL_LIBRO_VENTA' de la base de datos
        try{
            $query = $this->db->connect()->prepare("
                CALL SPD_ACTUALIZAR_STOCK_VENTA_LIBRO(
                    '" . $item['idLibro'] . "'::VARCHAR(4),
                    '" . $item['idUbicacion'] . "'::VARCHAR(3),
                    " . $item['cantidadDisponible'] . "::SMALLINT,
                    '" . $cIdLibroVenta . "'::VARCHAR(4),
                    " . $item['cantidadVenta'] . "::SMALLINT,
                    " . $item['precio'] . "::DECIMAL(7, 2)
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            //echo ("Error en update de librosmodel: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete($item){
        // Elimina registro de la tabla 'TBL_STOCK' y (si existe) de la tabla 'TBL_LIBRO_VENTA'
        try{
            $query = $this->db->connect()->prepare("
                CALL SPD_ELIMINAR_STOCK_VENTA_LIBRO(
                    '" . $item['idLibro'] . "'::VARCHAR(4),
                    '" . $item['idUbicacion'] . "'::VARCHAR(3)
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            //echo ("Error en delete de librosmodel: " . $e->getMessage());
            return false;
        }
    }
}

?>