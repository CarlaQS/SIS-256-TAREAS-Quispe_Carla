<?php
// Nombre Apellido: Marco Antonio Sanchez Galarza y Quispe Serrano Carla
function registrarVisita() {
    if (isset($_COOKIE["visitas"])) {
        $numeroVisita = $_COOKIE["visitas"];
    } else {
        $numeroVisita = 0;
    }
    if (!isset($_SESSION["visita_contada"])) {
        $numeroVisita = $numeroVisita + 1;
        setcookie("visitas", $numeroVisita, time() + (86400 * 30), "/");
        $_SESSION["visita_contada"] = 1;
    }
    return $numeroVisita;
}
function obtenerCarrito() {
    if (isset($_SESSION["carrito"])) {
    return unserialize($_SESSION["carrito"]);
    } else {
    return new Carrito();
    }
}
function guardarCarrito($carrito) {
    $_SESSION["carrito"] = serialize($carrito);
}
?>