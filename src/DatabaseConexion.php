<?php
class DatabaseConexion{
    private $conexion;

    public function __construct()
    {
        $host = "db";
        $port = "3306";
        $dbname = "db";
        $user = "root";
        $password = "root";

        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

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
            echo "Conexion exitosa";
        } catch (PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}