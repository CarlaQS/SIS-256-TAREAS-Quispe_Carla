<?php 
require "conexion.php";

$id = isset($_GET["id"]) ? (int)$_GET["id"] : 0;

$sql = "SELECT p.id, p.nombre, p.precio, p.descripcion, p.imagen, p.disponible, c.nombre AS categoria
        FROM productos p
        INNER JOIN categorias c ON p.categoria_id = c.id
        WHERE p.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    responder(404, ["exito" => false, "mensaje" => "Producto no encontrado"]);
}

$fila = $resultado->fetch_assoc();
responder(200, [
    "id" => (int)$fila["id"],
    "nombre" => $fila["nombre"],
    "precio" => (float)$fila["precio"],
    "descripcion" => $fila["descripcion"],
    "imagen" => $fila["imagen"],
    "disponible" => (bool)$fila["disponible"],
    "categoria" => $fila["categoria"]
]);
