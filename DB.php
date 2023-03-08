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

    public function mostrar_familia(): array
    {
        $sql_query = "select cod, nombre from familia";
        $resultado = $this->conexion->query($sql_query);
        $familias = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $familias;
    }

    public function mostrar_producto($codigo): array
    {
        $sql_query = "select nombre_corto, pvp, descripcion from producto where familia='$codigo'";
        $resultado = $this->conexion->query($sql_query);
        $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }
}
