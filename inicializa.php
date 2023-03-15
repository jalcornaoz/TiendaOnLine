<?php
require_once "./conexion.php";

ini_set('display_errors', true);
error_reporting(E_ALL);

$carga_clase = fn ($clase) => require("$clase.php");
spl_autoload_register($carga_clase);

session_start();
