<?php
// Nombre Apellido: Marco Antonio Sanchez Galarzay Quispe Serrano Carla
require_once "Producto.php";
function obtenerCatalogo() {
    $productos = array();
    $productos[] = new Producto("P01", "Teclado mecanico RGB", "Perifericos", 320.00, 12);
    $productos[] = new Producto("P02", "Mouse inalambrico", "Perifericos", 145.50, 8);
    $productos[] = new Producto("P03", "Monitor 24 pulgadas", "Pantallas", 1250.00, 5);
    $productos[] = new Producto("P05", "Disco solido 480 GB", "Almacenamiento", 380.00, 20);
    $productos[] = new Producto("P06", "Memoria USB 64 GB", "Almacenamiento", 75.00, 35);
    $productos[] = new Producto("P08", "Disco externo 1 TB", "Almacenamiento", 640.00, 6);
    return $productos;
}
function buscarProducto($codigo, $productos) {
    foreach ($productos as $p) {
        if ($p->getCodigo() == $codigo) {
        return $p;
        }
    }
    return null;
}
?>