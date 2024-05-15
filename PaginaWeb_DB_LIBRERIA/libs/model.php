<?php

class Model{
    public $db;
    
    function __construct(){
        $this->db = new Database();
    }
    
    // Generar ID unico de cierta longitud y con ciertor caracteres
    function generateUniqueID($length, $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'){
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>