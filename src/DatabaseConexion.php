<?php
class DatabaseConexion{
    private $conexion;

    public function __construct()
    {
        $host = "localhost";
        $dbname = "eventos_tech";
        $user = "root";
        $password = "";

        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";

        try {
            $this->conexion = new PDO(
                $dsn, 
                $user, 
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}