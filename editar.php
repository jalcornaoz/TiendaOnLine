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

$codigo = $_POST['codigo'] ?? "";
$producto = $db->get_producto($codigo);

$usuario = $_SESSION['user'];

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
        <fieldset class="mt-5">
            <legend>Producto</legend>
            <div>
                <form action="./sitio.php" method="post">
                    <label for="name" class="form-label mt-2">Nombre</label>
                    <input type="text" class="form-control" id="name" name="nombre_corto" value="<?= $producto['nombre_corto'] ?>">
                    <label for="pvp" class="form-label mt-2">P.V.P.</label>
                    <input type="text" class="form-control" id="pvp" name="pvp" value="<?= $producto['pvp'] ?>">
                    <label for="descripcion" class="form-label mt-2">Descripción</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="5"><?= $producto['descripcion'] ?></textarea>
                    <input type="hidden" name="familia" value="<?= $producto['familia'] ?>">
                    <input type="hidden" name="cod" value="<?= $producto['cod'] ?>">
                    <button type="submit" class="btn btn-light m-3" name="submit" value="cancel">Cancelar</button>
                    <button type="submit" class="btn btn-light m-3" name="submit" value="update">Actualizar</button>
                </form>
            </div>
        </fieldset>
    </div>
</body>

</html>