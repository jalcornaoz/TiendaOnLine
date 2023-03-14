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

    private function ejecutar_consulta(string $sentencia, array $valores = []): PDOStatement
    {
        //consulta preparada 
        $rtdo = $this->conexion->prepare($sentencia);
        $rtdo->execute($valores);
        return $rtdo;
    }

    public function validar_usuario($nombre, $pass)
    {
        $sql_query = "select nombre, pass from usuarios where nombre=? and pass=?";
        $valores = [$nombre, $pass];
        $resultado = $this->ejecutar_consulta($sql_query, $valores);

        if ($resultado->rowCount() > 0)
            return true;
        else
            return false;
    }

    public function mostrar_familias(): array
    {
        $sql_query = "select cod, nombre from familia";
        $resultado = $this->ejecutar_consulta($sql_query);
        $familias = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $familias;
    }

    public function mostrar_producto($familia): array
    {
        $sql_query = "select nombre_corto, pvp, descripcion, cod from producto where familia=?";
        $valores = [$familia];
        $resultado = $this->ejecutar_consulta($sql_query, $valores);
        $productos = $resultado->fetchAll(PDO::FETCH_ASSOC);
        return $productos;
    }

    public function producto($codigo): array
    {
        $sql_query = "SELECT nombre_corto, pvp, descripcion, cod, familia FROM producto WHERE cod=?";
        $valores = [$codigo];
        $resultado = $this->ejecutar_consulta($sql_query, $valores);
        $producto = $resultado->fetch(PDO::FETCH_ASSOC);
        return $producto;
    }

    public function actualizar_producto($producto)
    {
        if (!is_numeric($producto['pvp'])) return -1;
        $sql_update = "UPDATE producto SET nombre_corto=?, pvp=?, descripcion=? WHERE cod=?";
        $valores = [$producto['nombre_corto'], $producto['pvp'], $producto['descripcion'], $producto['cod']];
        $resultado = $this->ejecutar_consulta($sql_update, $valores);
        return $resultado->rowCount();
    }
}
