<?php
require_once "../src/DatabaseConexion.php";

$conexion = new DatabaseConexion();
$conexion = $conexion->getConexion();

session_start();

if (!isset($_SESSION['name'])){
    header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/login.php");
    exit();
}

$sql = "
        select * from eventos_tech.eventos; 
";

$sentencia = $conexion->prepare($sql);
$sentencia->execute();
$events = $sentencia->fetchAll(PDO::FETCH_ASSOC);

if (empty($events)){ 
  $error = "Aun no existen eventos, crea uno nuevo.";
}


?>
<!DOCTYPE html>
<head lang="es">
    <meta charset="utf-8">
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./index.css">
</head>
<body class="m-0 p-0 text-light h-100" style="background-color: #1a1a19">
    <div class="flex row h-100">
      <div class="col-2 vh-100 " style="background-color: #31312f ;">
        <nav class="navbar navbar-expand-lg navbar-light ">
          <div class="flex-column d-flex h-100 w-100">
            <h5>Gestor de eventos </h5>
              <ul class="navbar-nav flex-column flex-grow-1">
                <li class="nav-item">
                  <a class="nav-link " aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " href="#">Features</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link " href="#">Pricing</a>
                </li>
                <!-- <li class="nav-item dropdown  ">
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown link
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </li> -->
              </ul>
            <a class="btn btn-outline-danger " href="logout.php">salir</a>
          </div>
        </nav>
      </div>
      <div class="col-10">
        <div class="d-flex justify-content-end ">
          <button class="btn btn-outline-danger ">Modificar</button> 
        </div>
          <?php if (isset($error)) :?>
            <div class="alert alert-success" role="alert">
              <?php echo $error ;?>
          </div>
        <?php else : ?>
          <div class="overflow-auto " style="max-height: 600px;">

            <table class="table table-dark table-striped">
              <thead>
              <tr>
                <th class="text-white" scope="col"></th>
                <th class="text-white" scope="col">Id</th>
                <th class="text-white" scope="col">Nombre</th>
                <th class="text-white" scope="col">Fecha</th>
                <th class="text-white" scope="col">Descripcion</th>
                <th class="text-white" scope="col">Lugar</th>
                <th class="text-white" scope="col">Capacidad</th>
                <th class="text-white" scope="col"></th>
              </tr>
            </thead>
            <tbody>
                <?php foreach($events as  $event) : ?>
                  <tr>
                    <th scope="row"></th>
                    <td class="text-white"><?php echo $event['id'] ?></td>
                    <td class="text-white"><?php echo $event['nombre'] ?></td>
                    <td class="text-white"><?php echo $event['fecha'] ?></td>
                    <td class="text-white"><?php echo $event['descripcion'] ?></td>
                    <td class="text-white"><?php echo $event['lugar'] ?></td>
                    <td class="text-white"><?php echo $event['capacidad'] ?></td>
                    <td class="text-white"><button class="btn btn-outline-danger">Modificar</button> </td>
                  </tr>
                  <?php endforeach ; ?>
                  <?php endif ;?>
            </tbody>
          </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>