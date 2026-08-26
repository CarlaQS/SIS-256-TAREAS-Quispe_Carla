<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Operaciones</title>
    <style>
        select, input, button {
            background-color: orange;
        }
        table {
            border-collapse: collapse;
            margin-top: 15px;
        }
        td, th {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid black;
        }
    </style>
</head>
<body>

    <form action="tabla.php" method="POST">

        <label for="operacion">Operacion</label>
        <select id="operacion" name="operacion">
            <option value="Suma">Suma</option>
            <option value="Resta">Resta</option>
            <option value="Multiplicacion">Multiplicacion</option>
            <option value="Division">Division</option>
        </select>

        &nbsp;&nbsp;

        <label for="n">n</label>
        <input type="number" id="n" name="n">

        <br><br>

        <button type="submit">Generar</button>

    </form>

    <?php
        if (isset($_POST["operacion"]) && isset($_POST["n"])) {

            $operacion = $_POST["operacion"];
            $n = $_POST["n"];
    ?>

    <h2>Tabla de <?php echo $operacion; ?></h2>

    <table>
        <?php
            echo "<tr>";
            echo "<td></td>";
            for ($col = 1; $col <= $n; $col++) {
                echo "<td><strong>$col</strong></td>";
            }
            echo "</tr>";

            for ($fila = 1; $fila <= $n; $fila++) {

                echo "<tr>";
                echo "<td><strong>$fila</strong></td>";

                for ($col = 1; $col <= $n; $col++) {

                    if ($operacion == "Suma") {
                        $resultado = $fila + $col;
                    } else if ($operacion == "Resta") {
                        $resultado = $fila - $col;
                    } else if ($operacion == "Multiplicacion") {
                        $resultado = $fila * $col;
                    } else if ($operacion == "Division") {
                        $resultado = $fila / $col;
                    }

                    echo "<td>$resultado</td>";
                }

                echo "</tr>";
            }
        ?>
    </table>

    <?php
        }
    ?>

</body>
</html>
