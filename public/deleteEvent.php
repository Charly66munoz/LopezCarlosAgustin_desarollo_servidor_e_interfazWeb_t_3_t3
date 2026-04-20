<?php
require_once "../src/RedirectAdminPage.php";
require_once "../src/DatabaseConexion.php";

RedirectAdminPage::redirectLogin();

$db = new DatabaseConexion();
$conexion = $db->getConexion();

if(!isset($_GET['id'])){
    header("Location: index.php?error='No se ha podido eliminar el evento'");
}
try{
    $id = $_GET['id'];   
    $sql = "delete from eventos_tech.eventos where id = :id";
    
    $snte = $conexion->prepare($sql);
    $resultado = $snte->execute(['id' => $id]);
    header("Location: index.php?alert='Elemento eliminado correctamente'");
    exit();
} catch (PDOException $e){
    header("Location: index.php?alert='Error al eliminar evento'");
    exit();
}



