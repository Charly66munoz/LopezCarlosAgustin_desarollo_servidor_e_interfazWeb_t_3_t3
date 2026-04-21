<?php
require_once __DIR__ . "/../src/DatabaseConexion.php";
require_once __DIR__ . "/../src/RedirectAdminPage.php";

$conexion = new DatabaseConexion();
$conexion = $conexion->getConexion();

RedirectAdminPage::redirectLogin();

if (isset($_GET['alert'])) {
    $alert = $_GET['alert'];
}
if (isset($_GET['color'])) {
    $color = $_GET['color'];
}

try {
    $sql = "
          select * from eventos_tech.eventos ORDER BY fecha; 
  ";
    $sentencia = $conexion->prepare($sql);
    $sentencia->execute();
    $events = $sentencia->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $alertError = "Ha habido un error pdo el evento. Error: " . $e->getMessage();
} catch (Error $e) {
    $alertError = "Ha habido un error.Error: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? "";
    $nombre = $_POST['nombre'] ?? "";
    $fecha = $_POST['fecha'] ?? "";
    $descripcion = $_POST['descripcion'] ?? "";
    $lugar = $_POST['lugar'] ?? "";
    $capacidad = $_POST['capacidad'] ?? "";

    try {
        $sql = "update eventos_tech.eventos set nombre = :nombre, fecha = :fecha , descripcion = :descripcion , lugar = :lugar , capacidad = :capacidad where id = :id";
        $sentencia = $conexion->prepare($sql);
        $sentencia->execute([
            'nombre' => $nombre,
            'fecha' => $fecha,
            'descripcion' => $descripcion,
            'lugar' => $lugar,
            'capacidad' => $capacidad,
            'id' => intval($id),
        ]);
        header("Location: /EventosTech-CarlosAgustinLopez/public/home.php?alert=Evento modificado correctamente&color=success");
        exit();
    } catch (PDOException $e) {
        header("Location: /EventosTech-CarlosAgustinLopez/public/home.php?color=danger&alert=No se a podido actulizar los datos");
        exit();
    }
}

if (empty($events) && !isset($alertError)) {
    $error = "Aun no existen eventos.";
}

?>
<!DOCTYPE html>

<head lang="es">
    <meta charset="utf-8">
    <title>TechcTivity</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./style/index.css">
</head>

<body style="background-image: url('img/TechcTivityBaground.png')" class="bg-prop">
    <div class="d-flex flex-column vh-100">
        <div class="d-flex flex-column flex-lg-row flex-grow-1 overflow-auto">

            <!-- con order-first and last, manejo la posicion segun el tamaño de la pantalla -->
            <div class="order-last order-lg-first aside-sticky col-12 col-lg-2
                p-3 py-lg-5 rounded-top rounded-lg-start 
                text-light flex-shrink-0 my-lg-2"
                style="background-color: #31312fb9;">
                <nav class="navbar navbar-dark px-2">
                    <div class="flex-column d-flex w-100 justify-content-between">
                        <h5>TechcTivity</h5>
                        <hr>
                        <a class="btn btn-success mt-3" href="/EventosTech-CarlosAgustinLopez/public/creatEvent.php">
                            Crear evento
                        </a>
                        <a class="btn btn-outline-danger mt-3" href="/EventosTech-CarlosAgustinLopez/public/logout.php">Salir</a>
                    </div>
                </nav>
            </div>
            <div class="order-first order-lg-last col-12 col-lg-10
            d-flex flex-column p-2 ">

                <?php if (isset($alertError)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $alertError; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($alert)) : ?>
                    <div class="alert alert-<?php echo $color ?> alert-dismissible fade show" role="alert">
                        <?php echo $alert; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($error)) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped rounded">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>Descripcion</th>
                                    <th>Lugar</th>
                                    <th>Capacidad</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        <a href="/EventosTech-CarlosAgustinLopez/public/creatEvent.php"
                            class="btn btn-outline-success w-75">Crear primer evento...</a>
                    </div>

                <?php else : ?>
                    <div class="table-responsive">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Fecha</th>
                                    <th>Descripcion</th>
                                    <th>Lugar</th>
                                    <th style="width: 1%;">Capacidad</th>
                                    <th style=" width: 1%;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event) : ?>
                                    <form method="post">
                                        <tr>
                                            <td><?php echo $event['id'] ?></td>
                                            <td class="d-none"><?php echo $event['id'] ?>
                                                <input class="no_change" type="hidden" name="<?php echo $event['id'] ?>" value="<?php echo $event['id'] ?>">
                                            </td>

                                            <td><?php echo $event['nombre'] ?></td>
                                            <td class="d-none"><input class="formControl w-100" name="<?php echo $event['nombre'] ?>" type="text" value="<?php echo $event['nombre'] ?>"></td>

                                            <td><?php echo $event['fecha'] ?></td>
                                            <td class="d-none"><input class="formControl" type="date" name="<?php echo $event['fecha'] ?>" value="<?php echo $event['fecha'] ?>"></td>

                                            <td class="view-mode"><?php echo $event['descripcion'] ?></td>
                                            <td class="d-none"><input class="formControl" type="text" name="<?php echo $event['descripcion'] ?>" value="<?php echo $event['descripcion'] ?>"></td>

                                            <td class="view-mode"><?php echo $event['lugar'] ?></td>
                                            <td class="d-none"><input class="formControl w-100" type="text" name="<?php echo $event['lugar'] ?>" value="<?php echo $event['lugar'] ?>"></td>

                                            <td class="view-mode"><?php echo $event['capacidad'] ?></td>
                                            <td class="d-none"><input class="formControl w-75" type="number" name="<?php echo $event['capacidad'] ?>" value="<?php echo $event['capacidad'] ?>"></td>

                                            <td style="width: 1%;">
                                                <button type="submit " class=" d-none btn btn-success btnSize mt-1 saveButton">Guardar</button>
                                                <button type="button" class="btn btn-outline-warning mt-1 editButton btnSize ">Modificar</button>
                                                <a href="deleteEvent.php?id=<?= $event['id'] ?>" class="btn btn-outline-danger mt-1 btnSize">Eliminar</a>
                                            </td>
                                        </tr>
                                    </form>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="d-none d-lg-block flex-shrink-0">
            <img src="img/TechcTivityBanner.png" class="w-100"
                style="max-height: 150px; object-fit: cover;" alt="">
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./action/index.js"></script>

</body>

</html>