<?php
class Pizarra {
    public $palabra;
    public $color;
    public $color_fondo;
function __construct($palabra, $color, $color_fondo) {
    $this->palabra = $palabra;
    $this->color = $color;
    $this->color_fondo = $color_fondo;
}
function triangulo() {
  $letras = str_split($this->palabra);
  $total = count($letras);
  echo "<table style='border-collapse: collapse;'>";
            for ($fila = 1; $fila <= $total; $fila++) {
                echo "<tr>";
                for ($col = 0; $col < $total; $col++) {
                    if ($col < $fila) {
                        echo "<td style='width:30px; height:30px; text-align:center;
                              border:1px solid black;
                              background-color:" . $this->color_fondo . ";
                              color:" . $this->color . ";'>"
                              . $letras[$col] .
                              "</td>";
                    } else {
                        echo "<td style='width:30px; height:30px; border:1px solid black;'></td>";
                    }
                }

                echo "</tr>";
            }

            echo "</table>";
        }
    }
?>
