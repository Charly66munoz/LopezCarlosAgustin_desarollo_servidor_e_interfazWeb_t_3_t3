<?php

session_start();

class RedirectAdminPage{
    public static function redirectLogin(){
        if (!isset($_SESSION['name'])){
            $_SESSION['error'] = "Debe estar logeado para poder ingresar a esta ruta";
            
            header("Location: /EventosTech-CarlosAgustinLopez/public/login.php");
            exit();
            }
    }
    public static function redirectHome(){
        if (isset($_SESSION['name'])){
            header("Location: /EventosTech-CarlosAgustinLopez/public/home.php");
            exit();
        }
        return;
    }
}