<?php
class Estante {
    public $nivel1 = [];
    public $nivel2 = [];
    public $nivel3 = [];
    public $capacidad;

    function __construct($capacidad) {
        $this->capacidad = $capacidad;
    }

    function insertar($nivel, $elemento) {
        $prop = "nivel" . $nivel;
        if (count($this->$prop) >= $this->capacidad) {
            echo "Nivel $nivel lleno";
        } else {
            $this->$prop[] = $elemento;
        }
    }

    function quitar($nivel) {
        $prop = "nivel" . $nivel;
        if (count($this->$prop) == 0) {
            echo "Nivel $nivel vacio";
        } else {
            array_pop($this->$prop);
        }
    }

    function mostrarEstante() {
        echo "<table style='border-collapse:collapse;'>";
        for ($n = 3; $n >= 1; $n--) {
            $prop = "nivel" . $n;
            echo "<tr>";
            echo "<td style='background-color:#D9D9D9; font-weight:bold; padding:6px; border:1px solid black;'>Nivel $n</td>";
            foreach ($this->$prop as $item) {
                echo "<td style='padding:6px; border:1px solid black;'>$item</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
}
?>

