<?php
// Nombre Apellido: Marco Antonio Sanchez Galarza y Quispe Serrano Carla
session_start();
require_once "inc/catalogo.php";
require_once "inc/Carrito.php";
require_once "inc/funciones.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nombre"])) {
    $nombreCliente = trim($_POST["nombre"]);
    if ($nombreCliente != "") {
        setcookie("cliente", $nombreCliente, time() + (86400 * 7), "/");
        header("Location: tienda.php");
        exit();
    }
}
if (isset($_GET["tema"])) {
    if ($_GET["tema"] == "oscuro") {
        setcookie("tema", "oscuro", time() + (86400 * 30), "/");
    } else {
        setcookie("tema", "claro", time() + (86400 * 30), "/");
    }
    header("Location: tienda.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo"])) {
    $codigo = $_POST["codigo"];

    if (isset($_POST["cantidad"])) {
        $cantidad = intval($_POST["cantidad"]);
    } else {
        $cantidad = 1;
    }
    $catalogo = obtenerCatalogo();
    $producto = buscarProducto($codigo, $catalogo);
    $carrito = obtenerCarrito();
    if ($producto != null) {
        $carrito->agregar($codigo, $cantidad);
        guardarCarrito($carrito);
        $_SESSION["mensaje"] = "Se agrego \"" . $producto->getNombre() . "\" al carrito.";
    }
    header("Location: tienda.php");
    exit();
}
if (isset($_COOKIE["cliente"])) {
    $clienteCookie = $_COOKIE["cliente"];
} else {
    $clienteCookie = "";
}
if (isset($_COOKIE["tema"])) {
    $temaCookie = $_COOKIE["tema"];
} else {
    $temaCookie = "claro";
}
if ($temaCookie == "oscuro") {
    $claseTema = "tema-oscuro";
} else {
    $claseTema = "tema-claro";
}
$cantidadCarrito = 0;
if ($clienteCookie != "") {
    $carritoActual = obtenerCarrito();
    $cantidadCarrito = $carritoActual->cantidadTotal();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Tienda</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?= $claseTema ?>">

<header class="cabecera">
    <div>
        <h1>TecnoStore USFX - Tienda</h1>
        <p>Ejercicio 2 - Cookies y sesiones en PHP</p>
    </div>
    <?php if ($clienteCookie != ""): ?>
        <div>
            <a href="carrito.php" class="boton">Carrito (<?= $cantidadCarrito ?>)</a>
            <?php if ($temaCookie == "oscuro"): ?>
                <a href="tienda.php?tema=claro" class="boton">Tema claro</a>
            <?php else: ?>
                <a href="tienda.php?tema=oscuro" class="boton">Tema oscuro</a>
            <?php endif; ?>
            <a href="salir.php" class="boton">Salir</a>
        </div>
    <?php endif; ?>
</header>
<main class="contenido">
<?php if ($clienteCookie == ""): ?>
    <section>
        <h2>Identificacion del cliente</h2>
        <p>Introduzca su nombre se guarda en una cookie durante 7 dias</p>
        <form method="post" class="formulario">
            <label for="nombre">Nombre del cliente</label>
            <input type="text" name="nombre" id="nombre" placeholder="Ej: Ana Perez" required>
            <button type="submit">Ingresar a la tienda</button>
        </form>
    </section>
<?php else: ?>
    <?php $numeroVisita = registrarVisita(); ?>
    <?php if (isset($_SESSION["mensaje"])): ?>
        <p class="mensaje"><?= htmlspecialchars($_SESSION["mensaje"]) ?></p>
        <?php unset($_SESSION["mensaje"]); ?>
    <?php endif; ?>
    <h2>Hola <?= htmlspecialchars($clienteCookie) ?></h2>
    <section class="info-sesion">
        <p>Esta es su <strong>visita numero <?= $numeroVisita ?></strong> (dato guardado en la cookie <code>visitas</code>).</p>
        <p>Su carrito tiene <strong><?= $cantidadCarrito ?></strong> articulo(s) y vive en la sesion <?= session_id() ?>.</p>
    </section>
    <section>
        <h2>Productos disponibles</h2>
        <?php $catalogo = obtenerCatalogo(); ?>
        <div class="galeria">
        <?php foreach ($catalogo as $p): ?>
        <div class="tarjeta">
        <h3><?= htmlspecialchars($p->getCodigo()) ?></h3>
        <span class="categoria"><?= htmlspecialchars($p->getCategoria()) ?></span>
            <p class="nombre-producto"><?= htmlspecialchars($p->getNombre()) ?></p>
            <p class="precio">Bs <?= number_format($p->getPrecio(), 2) ?></p>
        <form method="post" class="formulario-agregar">
            <input type="hidden" name="codigo" value="<?= htmlspecialchars($p->getCodigo()) ?>">
             <input type="number" name="cantidad" value="1" min="1">
            <button type="submit">Agregar</button>
        </form>
        </div>
         <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
</main>
<footer class="pie">
    SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga
</footer>
</body>
</html>