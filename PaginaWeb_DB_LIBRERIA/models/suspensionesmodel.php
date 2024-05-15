<?php

include_once 'models/usuarioestado.php';

class SuspensionesModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    
    public function get(){
        $items = [];
        
        // Consulta datos de la tabla 'TBL_PERSONA' de la base de datos
        try{
            $query = $this->db->connect()->query("SELECT * FROM FN_CONSULTAR_USUARIOS_CONTACTOS();");
            
            // Recorre el resultado de la consulta
            while ($row = $query->fetch()) {
                $item = new UsuarioEstado();

                $item->vcNombreCompleto = $row['vcnombrecompleto'];
                $item->vcTelefono = $row['vctelefono'];
                $item->vcCorreoElectronico = $row['vccorreoelectronico'];
                $item->vcIdUsuario = $row['vcidusuario'];
                $item->iIdEstado = $row['iidestado'];
                $item->vcEstado = $row['vcestado'];
                $item->vcIdSuspension = $row['vcidsuspension'];
                
                array_push($items, $item);
            }
            
            return $items;
        }
        catch(PDOException $e){
            //print_r("Error en get de suspensionesmodel: " . $e->getMessage());
            return [];
        }
    }
    
    public function insert($item){
        // Generar un ID unico
        do{
            $vcIdSuspension = $this->generateUniqueID(rand(1, 5));
            $query = $this->db->connect()->prepare("SELECT COUNT(vcIdSuspension) AS iCantidadIdsSuspensiones FROM TBL_SUSPENSION WHERE vcIdSuspension = :vcIdSuspension");
            try{
                $query->execute(['vcIdSuspension' => $vcIdSuspension]);
                $existenRegistros = $query->fetch(PDO::FETCH_ASSOC)['icantidadidssuspensiones'];
            }
            catch(PDOException $e){
                //print_r("Error en insert de suspensionesmodel: " . $e->getMessage());
                return false;
            }
        } while($existenRegistros > 0);
        // Insertar datos en la tabla 'TBL_SUSPENSION' de la base de datos
        try{
            $query = $this->db->connect()->prepare("
                CALL SPD_APLICAR_SUSPENSION(
                    '" . $vcIdSuspension . "',
                    '" . $item . "'
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            //echo ("Error en insert de suspensionesmodel: " . $e->getMessage());
            return false;
        }
    }
    
    public function update($item){
        // Actualizar datos de las tablas 'TBL_SUSPENSION' y 'TBL_USUARIO' de la base de datos
        try{
            $query = $this->db->connect()->prepare("
                CALL SPD_CANCELAR_SUSPENSION(
                    '" . $item . "'
                );
            ");
            $query->execute();
            // Si la ejecucion fue exitosa
            return true;
        }
        catch(PDOException $e){
            //echo ("Error en update de suspensionesmodel: " . $e->getMessage());
            return false;
        }
    }
}

?>