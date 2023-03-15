<?php

class Plantilla
{

    public static function html_select_familias($familias, $cod_familia)
    {
        $html_select = "<select class=\"form-select\" name=\"familia\">\n";
        $html_select .= "<option>Productos</option>\n";
        foreach ($familias as $familia) {
            if ($cod_familia == $familia['cod'])
                $html_select .= "<option value=$familia[cod] selected>$familia[nombre]</option>\n";
            else
                $html_select .= "<option value=$familia[cod]>$familia[nombre]</option>\n";
        }
        $html_select .= "</select>";
        return $html_select;
    }

    public static function html_table_productos($productos)
    {
        $html_table = "<table class=\"table\">\n";
        foreach ($productos as $producto) {
            $html_table .= "<tr>\n<th>$producto[nombre_corto]</th>\n<td>$producto[descripcion]</td>\n<td>$producto[pvp]</td>\n";
            $html_table .= "<td>" . self::boton_editar_producto($producto['cod']) . "</td></tr>\n";
        }
        $html_table .= "</table>\n";
        return $html_table;
    }

    private static function boton_editar_producto($codigo)
    {
        $html_boton = "<form action=\"./editar.php\" method=\"post\">\n";
        $html_boton .= "<input type=\"hidden\" name=\"codigo\" value=\"$codigo\">\n";
        $html_boton .= "<button type=\"submit\" class=\"btn btn-light\" name=\"submit\" value=\"edit\">Editar producto</button>\n";
        $html_boton .= "</form>";
        return $html_boton;
    }
}
