<?php
session_start();
class CloseSession{
    public static function closeSession(){
        unset($_SESSION['name']);
        if(isset($_SESSION['name'])){
            unset($_SESSION['error']);
        }
        session_destroy();
        header("Location: /EventosTech-CarlosAgustinLopez/public/login.php");
        exit();
    }
}