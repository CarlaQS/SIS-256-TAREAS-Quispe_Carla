<?php
require_once "conexion.php";
$id=$_GET["id"];
$sql = "DELETE FROM recetas WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
echo "Receta eliminada";
?>
