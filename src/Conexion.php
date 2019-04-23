<?php 
/** 
 * Clase singleton conexion 
 */ 

class Conexion 
{ 

    public static $conexion; 

    public static function getConnection() 
    { 
        include "config.php"; 
        if (empty(self::$conexion)) { 
            try { 
                self::$conexion = new PDO('mysql:host=' . $dbhost . ';dbname=' . $dbname, $dbuser, $dbpass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")); 
            } catch (PDOException $e) { 
                echo "ERROR: " . $e->getMessage(); 
            } 
        } 
        return self::$conexion; 
    } 
} 