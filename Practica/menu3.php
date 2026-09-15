<?php
    require_once 'estante.php';
    session_start();

    if (isset($_POST['capacidad'])) {
        $_SESSION['estante'] = new Estante($_POST['capacidad']);
    }
    if (isset($_POST['nivel']) && isset($_POST['elemento'])) {
        $_SESSION['estante']->insertar($_POST['nivel'], $_POST['elemento']);
    }
    if (isset($_POST['nivel_quitar'])) {
        $_SESSION['estante']->quitar($_POST['nivel_quitar']);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Menu Estante</title></head>
<body>

    <h3>Crear Estante</h3>
    <form method="POST">
        Capacidad: <input type="number" name="capacidad" required>
        <button type="submit">Crear</button>
    </form>

    <h3>Insertar</h3>
    <form method="POST">
        <select name="nivel">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <input type="text" name="elemento" placeholder="Elemento" required>
        <button type="submit">Insertar</button>
    </form>

    <h3>Quitar</h3>
    <form method="POST">
        <select name="nivel_quitar">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
        </select>
        <button type="submit">Quitar</button>
    </form>

    <h3>Mostrar Estante</h3>
    <?php
        if (isset($_SESSION['estante'])) {
            $_SESSION['estante']->mostrarEstante();
        }
    ?>

</body>
</html>
