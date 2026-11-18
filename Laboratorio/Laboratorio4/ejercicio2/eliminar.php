<?php 
require "conexion.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    responder(405, ["exito" => false, "mensaje" => "Método no permitido"]);
}
$id = isset($_POST["id"]) ? (int)$_POST["id"] : 0;
$stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
if ($stmt->affected_rows === 0) {
    responder(404, ["exito" => false, "mensaje" => "Producto no encontrado"]);
}
responder(200, ["exito" => true, "mensaje" => "Producto eliminado"]);
