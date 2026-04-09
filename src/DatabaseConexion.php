<?php
class DatabaseConexion{
    private $conexion;

    public function __construct()
    {
        $host = "localhost";
        $port = "3306";
        $dbname = "db";
        $user = "root";
        $password = "db";

        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

        try {
            $this -> conexion= new PDO($dsn, $user, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}