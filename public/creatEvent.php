<?php
require_once "../src/DatabaseConexion.php";

$conexion = new DatabaseConexion();
$conexion = $conexion->getConexion();

session_start();

if (!isset($_SESSION['name'])){
    header("Location: https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    
    $name = $_REQUEST["name"];
    $date = $_REQUEST["date"];
    $capacity = $_REQUEST["capacity"];
    $place = $_REQUEST["place"];
    $description = $_REQUEST["description"];
    try{
        $sql = "insert into eventos_tech.eventos (nombre, fecha, descripcion, lugar ,capacidad)
        values (:nombre, :fecha, :descripcion, :lugar, :capacidad);
        ";
        $sentencia = $conexion->prepare($sql);
        $resultado = $sentencia-> execute(['nombre'=> $name ,'fecha'=>$date ,'lugar'=>$place ,'descripcion' => $description, 'capacidad' => $capacity]);
    

        }catch (PDOException $e){
        $alertError = "Ha habido un error al guardar el evento. Error: ". $e->getMessage();
    }

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
        <?php if (isset($alertError)) : ?>
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div>
                            <?php echo $alertError ?>
                        </div>
                    </div>       
            <?php endif ; ?>
      <div class="col-12 col-sm-3 vh-100 " style="background-color: #31312f ;">
        <nav class="navbar navbar-expand-lg navbar-light px-2 ">
          <div class="flex-column d-flex h-100 w-100">
            <h5>Gestor de eventos </h5>
            <hr>
              <a class="nav-link " aria-current="page" href="https://lopezcarlosagustin-desarollo-servidor-t-3-t3.ddev.site/index.php">Home</a>
            <a class="btn btn-outline-danger mt-3" href="logout.php">salir</a>
          </div>
        </nav>
      </div>
      <div class="col-12 col-sm-9 d-flex justify-content-center align-items-center">
          <form method="post" class="bg-success px-3 py-4 rounded">
            <div class="mb-3">
                <p class="w-75">Rellene los datos necesario para crear el evento</p>
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
            <label class="form-label" for="description">Descripcion</label>
            <div class="mb-3">
                    <textarea id="description" name="description" rows="5" cols="30">
                    </textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Confirmar</button>
        </form>
          
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="./index.js"></script>
</body>
</html>