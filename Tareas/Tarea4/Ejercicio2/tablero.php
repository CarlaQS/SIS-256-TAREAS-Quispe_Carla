<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <style>
        .casilla {
            background-color: black;
        }
        table {
            border-collapse: collapse;
        }
        td {
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>

    <?php
        $filas = $_GET["filas"];
        $columnas = $_GET["columnas"];
    ?>

    <table border="1">
        <?php
            for ($i = 0; $i < $filas; $i++) {

                echo "<tr>";
                for ($j = 0; $j < $columnas; $j++) {

                    if (($i + $j) % 2 == 1) {
                        echo '<td class="casilla">&nbsp;</td>';
                    } else {
                        echo "<td>&nbsp;</td>";
                    }

                }

                echo "</tr>";
            }
        ?>
    </table> 
</body>
</html>
