<?php
require_once __DIR__ . "/../src/DatabaseConexion.php";
require_once __DIR__  . "/../src/RedirectAdminPage.php";

$conexion = new DatabaseConexion();
$conexion = $conexion->getConexion();

RedirectAdminPage::redirectLogin();

$alert = $_GET['alert'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST["name"];
    $date = $_POST["date"];
    $capacity = $_POST["capacity"];
    $place = $_POST["place"];
    $description = $_POST["description"];
    try {
        $sql = "insert into eventos_tech.eventos (nombre, fecha, descripcion, lugar ,capacidad)
        values (:nombre, :fecha, :descripcion, :lugar, :capacidad);
        ";
        $sentencia = $conexion->prepare($sql);
        $resultado = $sentencia->execute(['nombre' => $name, 'fecha' => $date, 'lugar' => $place, 'descripcion' => $description, 'capacidad' => $capacity]);

        header("Location: /EventosTech-CarlosAgustinLopez/public/creatEvent.php?alert=Evento creado correctamente");
        exit;

    } catch (PDOException $e) {
        $alertError = "Ha habido un error al guardar el evento. Error: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>

<head lang="es">
    <meta charset="utf-8">
    <title>CreateEvent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/index.css">
</head>

<body style="background-image: url('img/TechcTivityBaground.png')" class="bg-prop">
    <div class="d-flex flex-column vh-100">
        <?php if (isset($alertError)) : ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <div>
                    <?php echo $alertError ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>
        <?php if (isset($alert)) : ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <div>
                    <?php echo $alert ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        <?php endif; ?>

        <div class="d-flex flex-column flex-lg-row flex-grow-1 overflow-auto">
            <div class="order-last order-lg-first aside-sticky col-12 col-lg-2
            p-3 py-lg-5 rounded-top rounded-lg-start 
            text-light flex-shrink-0 my-lg-2"
            style="background-color: #31312fb9;">
            <nav class="navbar navbar-dark px-2">
                <div class="flex-column d-flex w-100 justify-content-around">
                    <h5>TechcTivity</h5>
                    <hr>
                    <a class="btn btn-success mt-3" href="/EventosTech-CarlosAgustinLopez/public/home.php">
                        Inicio
                    </a>
                    <a class="btn btn-danger mt-3" href="/EventosTech-CarlosAgustinLopez/public/logout.php">Salir</a>
                </div>
            </nav>
        </div>
        <div class="order-first order-lg-last col-12 col-lg-10
        d-flex justify-content-center py-2">
        <div class="col-12 col-sm-10 d-flex justify-content-center align-items-center">
            <form method="post" class=" px-3 py-4 rounded" style="background-color: #31312f9c ">
                        <div class="mb-3">
                            <h4 class="w-75 text-white">Rellene los datos crear el evento</h4>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del evento</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp" required>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-6">
                                <label for="date" class="form-label">Fecha</label>
                                <input type="date" name="date" class="form-control" id="date" required>
                            </div>
                            <div class="mb-3  col-6">
                                <label class="form-label" for="capacity">Capacidad</label>
                                <input type="number" name="capacity" min="20" class="form-control" id="capacity" required>
                            </div>
                            <div class="mb-3  col-6">
                                <label class="form-label" for="place">Lugar</label>
                                <input type="text" name="place" class="form-control" id="place" required>
                            </div>
                        </div>
                        <div class="mb-3 px-5 row">
                            <label class="form-label" for="description">Descripcion</label>
                            <textarea id="description" name="description" rows="3" cols="30">
                                </textarea>
                        </div>
                        <button type="submit" class="btn btn-outline-dark w-100">Confirmar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-none d-lg-block flex-shrink-0">
            <img src="img/TechcTivityBanner.png" class="w-100"
                style="max-height: 150px; object-fit: cover;" alt="">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>