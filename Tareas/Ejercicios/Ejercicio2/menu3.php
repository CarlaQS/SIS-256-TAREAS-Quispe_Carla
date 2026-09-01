<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php
    require_once 'pizarra.php';
    session_start();
    if (isset($_POST['palabra'])) {
        $pizarra = new Pizarra($_POST['palabra'], $_POST['color'], $_POST['color_fondo']);
        $_SESSION['pizarra'] = $pizarra;
    }
?>
<?php if (isset($_SESSION['pizarra'])): ?>
    <form action="menu3.php" method="GET">
    <button type="submit" name="accion" value="triangulo">Triangulo</button>
    </form>
    <?php
    if (isset($_GET['accion']) && $_GET['accion'] == 'triangulo') {
    echo "<h2>Resultado</h2>";
    $_SESSION['pizarra']->triangulo();
    }
?>
</body>
</html>
