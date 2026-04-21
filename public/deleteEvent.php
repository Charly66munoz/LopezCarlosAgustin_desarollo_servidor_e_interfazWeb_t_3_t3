<?php
require_once "../src/RedirectAdminPage.php";
require_once "../src/DatabaseConexion.php";

RedirectAdminPage::redirectLogin();

$db = new DatabaseConexion();
$conexion = $db->getConexion();

try{
    $id = $_GET['id'];   
    $sql = "delete from eventos_tech.eventos where id = :id";
    
    $snte = $conexion->prepare($sql);
    $resultado = $snte->execute(['id' => $id]);
    header("Location: home.php?alert=Elemento eliminado correctamente&color=danger");
    exit();
} catch (PDOException $e){
    header("Location: home.php?alert='Error al eliminar evento'");
    exit();
}



