<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        .resultado {
            border: 2px solid black;
            width: 250px;
            padding: 15px;
        }
    </style>
</head>
<body>

    <?php
        $numeros = $_POST['numeros'];
        $suma = 0;
        foreach ($numeros as $num) {
            $suma = $suma + $num;
        }
    ?>
    <div class="resultado">
        <p>La Suma es: <?php echo $suma; ?></p>
    </div>
</body>
</html>
