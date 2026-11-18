<?php 
require "conexion.php";
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    responder(405, ["exito" => false, "mensaje" => "Método no permitido"]);
}

$nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
$categoria_id = isset($_POST["categoria_id"]) ? (int)$_POST["categoria_id"] : 0;
$precio = isset($_POST["precio"]) ? (float)$_POST["precio"] : 0;
$descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
$disponible = (isset($_POST["disponible"]) && $_POST["disponible"] === "0") ? 0 : 1;
$errores = [];
if (strlen($nombre) < 3 || strlen($nombre) > 60) {
    $errores[] = "El nombre debe tener entre 3 y 60 caracteres.";
}
if ($precio <= 0) {
    $errores[] = "El precio debe ser mayor a cero.";
}
if (strlen($descripcion) > 255) {
    $errores[] = "La descripción no puede pasar de 255 caracteres.";
}

$stmt = $conn->prepare("SELECT id FROM categorias WHERE id = ?");
$stmt->bind_param("i", $categoria_id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    $errores[] = "La categoría no existe.";
}

$nombreImagen = "";
$tieneFoto = isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] !== UPLOAD_ERR_NO_FILE;
if ($tieneFoto) {
    $extension = strtolower(pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION));
    $permitidas = ["jpg", "jpeg", "png", "webp"];

    if ($_FILES["imagen"]["error"] !== UPLOAD_ERR_OK) {
        $errores[] = "No se pudo subir la fotografía.";
    } elseif (!in_array($extension, $permitidas)) {
        $errores[] = "La fotografía debe ser jpg, jpeg, png o webp.";
    } elseif ($_FILES["imagen"]["size"] > 2 * 1024 * 1024) {
        $errores[] = "La fotografía no puede pesar más de 2 MB.";
    } else {
        $nombreImagen = uniqid() . "." . $extension;
    }
}

if (count($errores) > 0) {
    responder(422, ["exito" => false, "errores" => $errores]);
}

if ($nombreImagen !== "") {
    $destino = __DIR__ . "/../images/" . $nombreImagen;
    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino)) {
        responder(500, ["exito" => false, "mensaje" => "No se pudo guardar la fotografía"]);
    }
}
$stmt = $conn->prepare("INSERT INTO productos (nombre, categoria_id, precio, descripcion, imagen, disponible) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sidssi", $nombre, $categoria_id, $precio, $descripcion, $nombreImagen, $disponible);

if (!$stmt->execute()) {
    responder(500, ["exito" => false, "mensaje" => "No se pudo guardar el producto"]);
}

responder(201, ["exito" => true, "id" => $conn->insert_id, "mensaje" => "Producto guardado correctamente"]);
