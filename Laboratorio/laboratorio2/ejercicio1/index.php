<?php
// Nombre Apellido: Marco Antonio Sanchez Galarza y Quispe Serrano Carla
require_once "catalogo.php";
if (isset($_GET["categoria"])) {
    $categoriaSeleccionada = $_GET["categoria"];
} else {
    $categoriaSeleccionada = "";
}
$catalogoCompleto = obtenerCatalogo();
$categorias = obtenerCategorias();
if ($categoriaSeleccionada != "" && !isset($categorias[$categoriaSeleccionada])) {
    $categoriaSeleccionada = "";
}
$productosFiltrados = filtrarPorCategoria($catalogoCompleto, $categoriaSeleccionada);
$stats = estadisticas($productosFiltrados);
$porCategoria = contarPorCategoria($catalogoCompleto);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TecnoStore USFX - Catalogo</title>
    <link rel="stylesheet" href="../estilos.css">
</head>
<body>
<header class="cabecera">
    <div>
        <h1>TecnoStore USFX - Catalogo</h1>
        <p>Ejercicio 1 - Clases, objetos y arreglos en PHP</p>
    </div>
    <div>
        <a href="index.php" class="boton">Ver todo</a>
        <a href="../ejercicio2/tienda.php" class="boton">Ir a la tienda</a>
    </div>
</header>
<main class="contenido">
    <section>
    <h2>1. Filtro de productos</h2>
    <form method="get" class="formulario">
        <label for="categoria">Categoria</label>
        <select name="categoria" id="categoria">
        <option value="">-- Todas las categorias --</option>
<?php foreach ($categorias as $clave => $texto): 
?>
<?php
if (isset($porCategoria[$clave])) {
     $cantidad = $porCategoria[$clave];
} else {
 $cantidad = 0;
}
?>
<option value="<?= htmlspecialchars($clave) ?>"
<?php if ($categoriaSeleccionada == $clave): ?> selected <?php endif; ?>>
<?= htmlspecialchars($texto) ?> (<?= $cantidad ?>)
</option>
<?php endforeach; ?>
</select>
<button type="submit">Filtrar</button>
</form>
<p class="url-generada">URL generada: <?= htmlspecialchars($_SERVER["REQUEST_URI"]) ?></p>
</section>
<section>
    <h2>2. Productos (<?= count($productosFiltrados) ?> encontrados)</h2>
    <?php if (count($productosFiltrados) == 0): ?>
        <p class="aviso">No se encontraron productos para esta categoria.</p>
    <?php else: ?>
    <div class="galeria">
    <?php foreach ($productosFiltrados as $p): ?>
    <?= $p->mostrarTarjeta() ?>
    <?php endforeach; ?>
     </div>
    <?php endif; ?>
</section>
<section>
    <h2>3. Resumen calculado con funciones de arreglo</h2>
    <h3>Estadisticas de los productos mostrados</h3>
    <table class="tabla">
        <tr><th>Indicador</th><th>Valor</th></tr>
        <tr><td>Productos listados</td><td><?= $stats["total"] ?></td></tr>
        <tr><td>Unidades en stock</td><td><?= $stats["stock"] ?></td></tr>
        <tr><td>Precio promedio</td><td>Bs <?= number_format($stats["promedio"], 2) ?></td></tr>
        <tr><td>Precio mas alto</td><td>Bs <?= number_format($stats["mayor"], 2) ?></td></tr>
        <tr><td>Precio mas bajo</td><td>Bs <?= number_format($stats["menor"], 2) ?></td></tr>
        <tr class="fila-destacada">
            <td>Categorias del catalogo completo</td>
            <td><?= count($categorias) ?></td>
        </tr>
    </table>
<h3>Contenido del arreglo $_GET</h3>
    <pre class="caja-codigo"><?php print_r($_GET); ?></pre>
</section>
</main>
<footer class="pie">
    SIS 256 - Tecnologia y Desarrollo Web - Ing. Carlos David Montellano Barriga
</footer>
</body>
</html>