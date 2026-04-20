<?php
session_start();
class CloseSession{

    public static function closeSession(){
        unset($_SESSION['name']);
        if(isset($_SESSION['name'])){
            unset($_SESSION['error']);
        }
        session_destroy();
        header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/login.php");
        exit();
    }
}