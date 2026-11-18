<?php 
require "conexion.php";

$resultado = $conn->query("SELECT id, nombre FROM categorias ORDER BY id");

$categorias = [];
while ($fila = $resultado->fetch_assoc()) {
    $categorias[] = [
        "id" => (int)$fila["id"],
        "nombre" => $fila["nombre"]
    ];
}

responder(200, $categorias);
