<?php
// Nombre Apellido: Marco Antonio Sanchez Galarza y Quispe Serrano Carla
session_start();
require_once "inc/catalogo.php";
require_once "inc/Carrito.php";
require_once "inc/funciones.php";
if (!isset($_COOKIE["cliente"])) {
    header("Location: tienda.php");
    exit();
}
if (isset($_GET["quitar"])) {
    $carrito = obtenerCarrito();
    $carrito->quitar($_GET["quitar"]);
    guardarCarrito($carrito);
    $_SESSION["mensaje"] = "Producto quitado del carrito.";
    header("Location: carrito.php");
    exit();
}
if (isset($_POST["vaciar"])) {
    $carrito = obtenerCarrito();
    $carrito->vaciar();
    guardarCarrito($carrito);
    $_SESSION["mensaje"] = "El carrito quedo vacio.";
    header("Location: carrito.php");
    exit();
}
$clienteCookie = $_COOKIE["cliente"];
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
$catalogo = obtenerCatalogo();
$carrito = obtenerCarrito();
$items = $carrito->getItems();
$total = $carrito->total($catalogo);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Carrito</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body class="<?= $claseTema ?>">
<header class="cabecera">
    <div>
        <h1>TecnoStore USFX - Carrito</h1>
        <p>Contenido guardado en $_SESSION</p>
    </div>
    <div>
        <a href="tienda.php" class="boton">Seguir comprando</a>
        <a href="salir.php" class="boton">Salir</a>
    </div>
</header>
<main class="contenido">
    <?php if (isset($_SESSION["mensaje"])): ?>
        <p class="mensaje"><?= htmlspecialchars($_SESSION["mensaje"]) ?></p>
        <?php unset($_SESSION["mensaje"]); ?>
    <?php endif; ?>
    <h2>Compra de <?= htmlspecialchars($clienteCookie) ?></h2>
    <section>
        <h3>Detalle del carrito</h3>
    <?php if ($carrito->estaVacio()): ?>
    <p class="aviso">El carrito vacio</p>
     <?php else: ?>
    <table class="tabla">
    <tr>
        <th>Codigo</th>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
        <th>Accion</th>
</tr>
<?php foreach ($items as $codigo => $cantidad): ?>
<?php $producto = buscarProducto($codigo, $catalogo); ?>
<?php if ($producto != null): ?>
<tr>
    <td><?= htmlspecialchars($producto->getCodigo()) ?></td>
    <td><?= htmlspecialchars($producto->getNombre()) ?></td>
    <td>Bs <?= number_format($producto->getPrecio(), 2) ?></td>
    <td><?= $cantidad ?></td>
    <td>Bs <?= number_format($producto->getPrecio() * $cantidad, 2) ?></td>
    <td><a href="carrito.php?quitar=<?= htmlspecialchars($codigo) ?>" class="boton-quitar">Quitar</a></td>
    </tr>
    <?php endif; ?>
    <?php endforeach; ?>
    <tr class="fila-destacada">
    <td colspan="4">TOTAL A PAGAR (<?= $carrito->cantidadTotal() ?> articulos)</td>
    <td colspan="2">Bs <?= number_format($total, 2) ?></td>
     </tr>
</table>
<form method="post" class="formulario" style="margin-top: 15px;">
    <button type="submit" name="vaciar" value="1" class="boton-quitar">Vaciar carrito</button>
    </form>
<?php endif; ?>
</section>

<section>
    <h3>Comprobacion de sesiones y cookies</h3>
    <h4>Identificador de la sesion</h4>
    <pre class="caja-codigo"><?= session_id() ?></pre>
    <h4>Contenido de $_SESSION</h4>
    <pre class="caja-codigo"><?php print_r($_SESSION); ?></pre>
    <h4>Contenido de $_COOKIE</h4>
    <pre class="caja-codigo"><?php print_r($_COOKIE); ?></pre>
    </section>
</main>
<footer class="pie">
    SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga
</footer>
</body>
</html>