<?php
require_once "../src/DatabaseConexion.php";
require_once "../src/RedirectAdminPage.php";

$conexion = new DatabaseConexion();
$conexion = $conexion->getConexion();

RedirectAdminPage::redirectLogin();

if(isset($_GET['alert'])){
    $alert = $_GET['alert'];
}

try{
  $sql = "
          select * from eventos_tech.eventos ORDER BY fecha; 
  ";
  $sentencia = $conexion->prepare($sql);
  $sentencia->execute();
  $events = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e){
    $alertError = "Ha habido un error pdo el evento. Error: ". $e->getMessage();
}catch (Error $e){
    $alertError = "Ha habido un error.Error: ". $e->getMessage();
}

if (empty($events) && !isset($alertError)){ 
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
<body style="background-image: url('/img/TechcTivityBaground.png')" class="bg-prop">
  
  <!--
    ESTRUCTURA BOOTSTRAP PARA AYUDARME:
    Desktop  → título | [aside col-2 + tabla col-10] | banner
    Tablet/Móvil → título | tabla | aside sticky bottom (banner oculto)
    -->
    <div class="d-flex flex-column vh-100">
      
      <?php if (!isset($error)) : ?>
        <div class="d-flex justify-content-center header-title py-2 flex-shrink-0">
          <h1 class="m-0 text-dark">Lista de eventos</h1>
        </div>
        <?php endif ?>
        <?php if (isset($alert)) : ?>
            <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert">
              <div><?php echo $alert ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>                             
        <?php endif ; ?>
        <?php if (isset($alertError)) : ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
              <div> <?php echo $alertError ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              
            </div>                             
        <?php endif ; ?>
        <div class="d-flex flex-column flex-lg-row flex-grow-1 overflow-auto">

            <!-- con order-first and last, manejo la posicion segun el tamaño de la pantalla -->
            <div class="order-last order-lg-first aside-sticky col-12 col-lg-2
                        p-3 py-lg-5 rounded-0 rounded-lg-start-0 align-self-lg-center
                        text-light flex-shrink-0"
                 style="background-color: #31312f;">
                <nav class="navbar navbar-dark px-2">
                    <div class="flex-column d-flex w-100 justify-content-between">
                        <h5>TechcTivity</h5>
                        <hr>
                        <a class="btn btn-success mt-3" href="https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/creatEvent.php">
                            Crear evento
                        </a>
                        <a class="btn btn-outline-danger mt-3" href="logout.php">Salir</a>
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

                <?php if (isset($error)) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $error; ?>
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
                        <a href="https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/creatEvent.php"
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
                                    <th>Capacidad</th>
                                    <th ></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event) : ?>
                                    <tr>
                                        <td><?php echo $event['id'] ?></td>
                                        <td class="d-none"><?php echo $event['id'] ?></td>

                                        <td><?php echo $event['nombre'] ?></td>
                                        <td class="d-none"><input class="formControl" type="text" value="<?php echo $event['nombre'] ?>"></td>

                                        <td><?php echo $event['fecha'] ?></td>
                                        <td class="d-none"><input class="formControl" type="date" value="<?php echo $event['fecha'] ?>"></td>

                                        <td class="view-mode"><?php echo $event['descripcion'] ?></td>
                                        <td class="d-none"><input class="formControl" type="text" value="<?php echo $event['descripcion'] ?>"></td>

                                        <td class="view-mode"><?php echo $event['lugar'] ?></td>
                                        <td class="d-none"><input class="formControl" type="text" value="<?php echo $event['lugar'] ?>"></td>

                                        <td class="view-mode"><?php echo $event['capacidad'] ?></td>
                                        <td class="d-none"><input class="formControl" type="number" value="<?php echo $event['capacidad'] ?>"></td>

                                        <td>
                                            <button class="btn btn-outline-warning mt-1 editButton btnSize">Modificar</button>
                                            <a href="deleteEvent.php?id=<?= $event['id']?>"
                                               class="btn btn-outline-danger mt-1 btnSize">Eliminar</a>
                                        </td>
                                    </tr>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./index.js"></script>
</body>
</html>


