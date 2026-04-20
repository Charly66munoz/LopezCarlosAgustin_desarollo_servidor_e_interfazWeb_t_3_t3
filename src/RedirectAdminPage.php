<?php

session_start();

class RedirectAdminPage{
    public static function redirectLogin(){
        if (!isset($_SESSION['name'])){
            $_SESSION['error'] = "Debe estar logeado para poder ingresar a esta ruta";
            header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/login.php");
            exit();
            }
    }
    public static function redirectHome(){
        if (isset($_SESSION['name'])){
            header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/index.php");
            exit();
        }
        return;
    }
}