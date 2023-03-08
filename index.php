<?php
require_once "./conexion.php";

ini_set('display_errors', true);
error_reporting(E_ALL);

$carga_clase = fn ($clase) => require("$clase.php");
spl_autoload_register($carga_clase);

session_start();

//miro si estoy loggeado
if (isset($_SESSION['user'])) {
    header("location:./sitio.php");
    exit();
}

$msj = $_GET['msj'] ?? "";

if (isset($_POST['submit'])) {
    //leer usuario y password
    $user = $_POST['nombre'];
    $pass = $_POST['pass'];

    //conctar con la base de datos
    $db = new DB();

    //validar si usuario y password existe
    //si OK: enviar a sitio.php y guardar usuario en sesion
    if ($db->validar_usuario($user, $pass)) {
        $_SESSION['user'] = $user;
        header("location:./sitio.php");
        exit();
    } else {
        //si noOK: mensaje 'error de autentificación'
        $msj = "Datos incorrectos.";
    }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda On Line</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body class="bg-secondary">
    <header class="text-warning bg-dark py-3">
        <div class="container">
            <h1>Tienda On Line</h1>
        </div>
    </header>
    <div class="container">
        <p><span class="bg-dark text-danger m-3 px-2"><?= $msj ?? "" ?></span></p>

        <fieldset class="col-4">
            <legend>Introducir datos</legend>
            <form action="./index.php" method="post">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre">
                <label for="pass" class="form-label">Password</label>
                <input type="text" class="form-control" name="pass" id="pass">
                <button type="submit" class="btn btn-light my-3" name="submit" value="conect">Enviar</button>
            </form>
        </fieldset>
    </div>
</body>

</html>