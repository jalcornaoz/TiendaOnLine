<?php
require_once "./conexion.php";

ini_set('display_errors', true);
error_reporting(E_ALL);

$carga_clase = fn ($clase) => require("$clase.php");
spl_autoload_register($carga_clase);

session_start();


//miro si no estoy loggeado
if (!isset($_SESSION['user'])) {
    header("location:./index.php?msj=Debes conectarte para acceder.");
    exit();
}

$db = new DB();

$familia = $_POST['familia'] ?? "";
$familias = $db->get_familias();
$mostrar_select_familias = Plantilla::html_select_familias($familias, $familia);
$usuario = $_SESSION['user'];

$opcion_submit = $_POST['submit'] ?? "";
switch ($opcion_submit) {
    case "logout":
        session_destroy();
        header("location:./index.php?msj=Te has desconectado correctamente.");
        exit();
    case "update":
        $producto = $_POST;
        $filas = $db->actualizar_producto($producto);
        if ($filas < 0)
            $msj = "Datos incorrectos. No se ha actualizado ninguna fila.";
        else
            $msj = "Se han actualizado $filas filas.<br>";
    case "cancel":
    case "list":
        $codigo = $_POST['familia'];
        $productos = $db->get_productos($codigo);
        $mostrar_tabla_productos = Plantilla::html_table_productos($productos);
        break;

    default:
        $mostrar_tabla_productos = "";
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
            <div class="row">
                <div class="col-4 ms-auto">
                    <h2>Usuario: <?= $usuario ?></h2>
                </div>
                <div class="col-2">
                    <form action="./sitio.php" method="post">
                        <button type="submit" class="btn btn-light" name="submit" value="logout">Desconectarse</button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <p><span class="bg-dark text-danger m-3"><?= $msj ?? "" ?></span></p>
        <fieldset class="mt-5">
            <legend>Familias de productos</legend>
            <form action="./sitio.php" method="post">
                <div class="row">
                    <div class="col-9">
                        <?= $mostrar_select_familias ?>
                    </div>
                    <div class="col-3 ms-auto">
                        <button type="submit" class="btn btn-light" name="submit" value="list">Mostrar producto</button>
                    </div>
                </div>
            </form>
        </fieldset>
        <fieldset class="my-3">
            <legend>Productos</legend>
            <div>
                <?= $mostrar_tabla_productos ?>
            </div>
        </fieldset>
    </div>
</body>

</html>