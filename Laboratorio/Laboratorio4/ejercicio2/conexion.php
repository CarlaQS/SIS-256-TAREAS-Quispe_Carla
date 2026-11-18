<?php 
header("Content-Type: application/json; charset=utf-8");

function responder($codigo, $datos) {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit();
}

mysqli_report(MYSQLI_REPORT_OFF);

$conn = @new mysqli("localhost", "root", "", "bd_cafeteria26");
if ($conn->connect_errno) {
    responder(500, ["exito" => false, "mensaje" => "No se pudo conectar a la base de datos"]);
}
$conn->set_charset("utf8mb4");
