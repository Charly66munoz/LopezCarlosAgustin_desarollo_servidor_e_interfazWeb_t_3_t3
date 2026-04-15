<?php
require_once "../src/DatabaseConexion.php";

$conexion = new DatabaseConexion();
$conexion = $conexion->getConexion();

session_start();

if (!isset($_SESSION['name'])){
    header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/login.php");
    exit();
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
    <title>Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./index.css">
</head>
<body >
    <div class="d-flex row  row h-100 w-100 m-0 bg-dark text-light ">
      <div class="col-12 col-sm-3 vh-100 " style="background-color: #31312f ;">
        <nav class="navbar navbar-expand-lg navbar-light px-2 ">
          <div class="flex-column d-flex h-100 w-100">
            <h5>Gestor de eventos </h5>
            <hr>
              <a class="nav-link " aria-current="page" href="https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/creatEvent.php">Crear evento</a>
        
            <a class="btn btn-outline-danger mt-3" href="logout.php">salir</a>
          </div>
        </nav>
      </div>
      <div class="col-12 col-sm-9">
        <?php if (isset($alertError)) :?>
          <div class="alert alert-danger" role="alert">
            <?php echo $alertError ;?>
          </div>
        <?php endif ; ?>
        <?php if (isset($error)) :?>
          <div class="alert alert-warning" role="alert">
            <?php echo $error ;?>
          </div>
          <div class="overflow-auto " style="max-height: 600px ; min-width: 0;">
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
            </table>
          <div class="d-flex justify-content-center">
            <a href="https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/creatEvent.php" class="btn btn-outline-success w-75">Crear primer evento...</a>
          </div>
          <?php else : ?>
          <div class="overflow-auto " style="max-height: 600px ; min-width: 0;">
            <h1>Lista de eventos</h1>
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
                    <td class="text-white "><?php echo $event['id'] ?></td>
                    <td class="text-white opacity-100 d-none "><?php echo $event['id'] ?></td>
                    
                    <td class="text-white"><?php echo $event['nombre'] ?></td>
                    <td class="text-white d-none"><input class="formControl" type="text" value="<?php echo $event['nombre'] ?>"></td>

                    <td class="text-white"><?php echo $event['fecha'] ?></td>
                    <td class="text-white d-none"><input class="formControl" type="date" value="<?php echo $event['fecha'] ?>"></td>

                    <td class="text-white view-mode"><?php echo $event['descripcion'] ?></td>
                    <td class="text-white d-none"><input class="formControl" type="text" value="<?php echo $event['descripcion'] ?>"></td>

                    <td class="text-white view-mode"><?php echo $event['lugar'] ?></td>
                    <td class="text-white d-none"><input class="formControl" type="text" value="<?php echo $event['lugar'] ?>"></td>

                    <td class="text-white view-mode"><?php echo $event['capacidad'] ?></td>
                    <td class="text-white d-none"><input class="formControl" type="number" value="<?php echo $event['capacidad'] ?>"></td>

                    <div class="edit">
                      <td class="text-white"><button class="btn btn-outline-warning editButton btnSize">Modificar</button> <button class="btn btn-outline-danger mt-1 btnSize">Eliminar</button> </td>
                    </div>
                  </tr>
                <?php endforeach ; ?>
                <?php endif ; ?>
              </tbody>
            </table>
          </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./index.js"></script>
</body>
</html>