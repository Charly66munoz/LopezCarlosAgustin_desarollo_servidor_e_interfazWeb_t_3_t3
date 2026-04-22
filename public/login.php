<?php
require_once __DIR__ .  '/../src/Auth.php';
require_once __DIR__ . "/../src/RedirectAdminPage.php";

RedirectAdminPage::redirectHome();

if (isset($_SESSION['error'])) {
    $alert = $_SESSION['error'];
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $userName = strtolower(trim($_POST['userName'])) ?? '';
    $ps = $_POST['ps'] ?? '';

    $resultado = Auth::verificarUser($userName,  $ps);

    if ($resultado) {
        session_start();
        $_SESSION['name'] = $userName;

        header("Location: /EventosTech-CarlosAgustinLopez/public/home.php");
        exit;
    } else {
        $alert = "Contraseña o usuario incorrecto/a, intentelo nuevamente";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="./img/iconlogo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/index.css">

</head>

<body style="background-image: url('img/TechcTivityBaground.png')" class="bg-prop text-white">
    <div class="container mt-5 d-flex">
        <div class="container w-25 m-auto rounded py-3" style="background-color: #31312fe8;">
            <form method="post" class="w-75 m-auto" autocomplete="off" novalidate>

                <?php if (isset($alert)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                        <div><?php echo $alert ?></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="m-auto mb-lg-4 d-flex justify-content-center">

                    <img src="./img/logo.png" width="80px" alt="logo_techctivity" style="border-radius: 50%;">
                </div>
                <h5>Inicio de sesion</h5>
                <div class="my-3">
                    <label for="exampleInputUser" class="form-label">Nombre</label>
                    <input type="text" name="userName" class="form-control" id="exampleInputUser" aria-describedby="emailHelp">
                </div>
                <div class="mb-3 pb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="ps" class="form-control" id="exampleInputPassword1">
                </div>
                <button class="btn btn-outline-primary w-100 ">Submit</button>
            </form>

            <?php if (isset($txt)) {
                echo $txt;
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>