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
</head>
<body class="bg-dark m-0 p-0">
  <nav class=" bg-danger opacity-75 navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid d-flex justify-content-end gap-2">
      <h1>Gestor de eventos </h1>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Pricing</a>
          </li>
          <li class="nav-item dropdown  ">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Dropdown link
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
              <li><a class="dropdown-item" href="#">Action</a></li>
              <li><a class="dropdown-item" href="#">Another action</a></li>
              <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
          </li>
        </ul>
      </div>
      <a class="btn btn-outline-danger" href="logout.php">salir</a>
    </div>
  </nav>
    <div>
      <?php if (isset($error)) :?>
        <div class="alert alert-success" role="alert">
          <?php echo $error ;?>
        </div>
      <?php else : ?>
        <?php foreach($events as  $event) : ?>
          <?php echo "<p>". $event['nombre'] ."</p>" ?>
        <?php endforeach ; ?>
      <?php endif ;?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>