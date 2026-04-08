<?php
require_once '../src/Auth.php';


if (isset($_SESSION['name'])){
    header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/index.php");
        exit;
}

if ($_SERVER['REQUEST_METHOD'] === "POST"){
    $userName = strtolower(trim($_POST['userName'])) ?? '';
    $ps = $_POST['ps'] ?? '';
    
    $resultado = Auth::verificarUser($userName,  $ps);
    
    if($resultado){
        session_start();
        $_SESSION['name'] = $userName;

        header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/index.php");
        exit;
    }else{
        $alert = "Contraseña o usuario incorrecto/a, intentelo nuevamente";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-dark text-light ">
        <div class="container mt-5">
            <?php if (isset($alert)) : ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <div>
                        <?php echo $alert ?>
                    </div>
                    </div>
                    
            <?php endif ; ?>
        <div class="">
            <form  method="post" autocomplete="off" novalidate>
                <div class="mb-3">
                <label for="exampleInputUser" class="form-label">Nombre</label>
                <input type="text" name="userName" class="form-control" id="exampleInputUser"  aria-describedby="emailHelp">
                <div id="userHelp" class="form-text" ><p class="text-light">We'll never share your name with anyone else.</p></div>
                
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" name="ps" class="form-control" id="exampleInputPassword1">
            </div>
            <button class="btn btn-primary">Submit</button>
        </form>
        
            <?php if(isset($txt)) {
                echo $txt;
            } 
            ?>
        
        
        </div>
        </div>


</body>
</html>