<?php

class Plantilla
{

    public static function html_select_familias($familias, $codigo)
    {
        $html_select = "<select class=\"form-select\" name=\"familia\">\n";
        $html_select .= "<option>Productos</option>\n";
        foreach ($familias as $familia) {
            if ($codigo == $familia['cod'])
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
            $html_table .= "<tr>\n<th>$producto[nombre_corto]</th><td>$producto[descripcion]</td><td>$producto[pvp]</td></tr>\n";
        }
        $html_table .= "</table>\n";
        return $html_table;
    }
}
