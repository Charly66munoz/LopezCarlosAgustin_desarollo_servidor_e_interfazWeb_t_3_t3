<?php
session_start();
class CloseSession{

    public static function closeSession(){
        unset($_SESSION['name']);
        session_destroy();
        header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/login.php");
        exit();
    }
}