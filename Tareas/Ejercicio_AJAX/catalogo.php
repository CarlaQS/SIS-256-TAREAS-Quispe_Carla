<?php
require_once "conexion.php";
$sql = "SELECT recetas.id, recetas.fotografia, recetas.titulo, tiporeceta.tiporeceta
        FROM recetas
        JOIN tiporeceta ON recetas.idtiporeceta = tiporeceta.id";
$resultado = $conn->query($sql);
if ($resultado->num_rows > 0) {
?><div class="grilla">
        <?php
        while ($fila = $resultado->fetch_assoc()) {
        ?><div class="tarjeta" onclick="abrirmodal('<?php echo $fila["id"]; ?>')">
                <img class="receta" src="images/<?php echo $fila["fotografia"]; ?>">
                <div><?php echo $fila["titulo"]; ?></div>
                <div class="tipo"><?php echo $fila["tiporeceta"]; ?></div>
        </div>
        <?php
        } ?>
    </div>
<?php
} else {
    echo "No hay registros";
}
$conn->close();
?>
