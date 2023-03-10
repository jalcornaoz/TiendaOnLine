<?php

class DB
{
    private $conexion;

    public function __construct()
    {
        try {
            $this->conexion = new PDO(DSN, USER, PASS);
        } catch (PDOException $e) {
            die("No se ha podido conectar: " . $e->getMessage());
        }
    }

    public function validar_usuario($nombre, $pass)
    {
        $sql_query = "select nombre, pass from usuarios where nombre='$nombre' and pass='$pass'";
        $resultado = $this->conexion->query($sql_query);

        if ($resultado->rowCount() > 0)
            return true;
        else
            return false;
    }

    public function mostrar_familias(): array
    {
        $sql_query = "select cod, nombre from familia";
        $resultado = $this->conexion->query($sql_query);
        $familias = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $familias;
    }

    public function mostrar_producto($familia): array
    {
        $sql_query = "select nombre_corto, pvp, descripcion, cod from producto where familia='$familia'";
        $resultado = $this->conexion->query($sql_query);
        $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    public function producto($codigo): array
    {
        $sql_query = "select nombre_corto, pvp, descripcion, cod, familia from producto where cod='$codigo'";
        $resultado = $this->conexion->query($sql_query);
        $producto = $resultado->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }

    public function actualizar_producto($producto)
    {
        var_dump($producto);
        $sql_update = $this->conexion->prepare("UPDATE producto SET nombre_corto=:codNombre, pvp=:codPvp, descripcion=:codDescripcion WHERE cod=:codCodigo");
        $sql_update->bindParam(":codNombre", $producto['nombre_corto']);
        $sql_update->bindParam(":codPvp", $producto['pvp']);
        $sql_update->bindParam(":codDescripcion", $producto['descripcion']);
        $sql_update->bindParam(":codCodigo", $producto['cod']);
        $sql_update->execute();
    }
}
