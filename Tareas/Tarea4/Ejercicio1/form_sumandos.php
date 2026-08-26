<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        $n = $_GET["n"];
    ?>
    <form action="resultado.php" method="POST">
        <?php
            for ($i = 1; $i <= $n; $i++) {
                echo "<label>Numero $i: </label>";
                echo "<input type='number' name='numeros[]'>";
                echo "<br>";
            }
        ?>
        <br>
        <button type="submit">Sumar</button>
    </form>
</body>
</html>
