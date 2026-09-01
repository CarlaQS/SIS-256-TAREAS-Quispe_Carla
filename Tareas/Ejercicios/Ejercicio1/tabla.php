<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Operacion</title>
    <style>
        table {
         border-collapse: collapse;
        }
        td {
         width: 40px;
         height: 30px;
         text-align: center;
         border: 1px solid black;
        }
        .encabezado {
         background-color: white;
         font-weight: bold;
        }
    </style>
</head>
<body>
    <?php
        $operacion = $_POST["operacion"];
        $n = $_POST["n"];
        $titulos = [
        "Suma" => "Suma",
        "Resta"=> "Resta",
        "Multiplicacion" => "Multiplicacion",
        "Division" => "Division"
        ];
        $simbolos = [
        "Suma" => "+",
        "Resta" => "-",
        "Multiplicacion" => "*",
        "Division" => "/"
        ];
    ?>
<h1>Tabla de <?php echo $titulos[$operacion]; ?></h1>
<table>
<?php
    for ($fila = 0; $fila <= $n; $fila++) {
    echo "<tr>";
    for ($col = 0; $col <= $n; $col++) {
    if ($fila == 0 && $col == 0) {
    echo "<td class='encabezado'>" . $simbolos[$operacion] . "</td>";
    } else if ($fila == 0) {
    echo "<td class='encabezado'>$col</td>";
    } else if ($col == 0) {
    echo "<td class='encabezado'>$fila</td>";
    } else {
    if ($operacion == "Suma") {
    $resultado = $fila + $col;
    } else if ($operacion == "Resta") {
    $resultado = $fila - $col;
    } else if ($operacion == "Multiplicacion") {
    $resultado = $fila * $col;
    } else if ($operacion == "Division") {
    $resultado = number_format($fila / $col, 2);
    }
    echo "<td>$resultado</td>";
    }
    }
    echo "</tr>";
    }
?>
</table>
</body>
</html>
