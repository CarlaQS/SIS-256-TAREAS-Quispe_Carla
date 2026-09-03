<?php
// Nombre Apellido: Marco Antonio Sanchez Galarza y Quispe Serrano Carla

class Producto {
    private $codigo;
    private $nombre;
    private $categoria;
    private $precio;
    private $stock;
    public function __construct($codigo, $nombre, $categoria, $precio, $stock) {
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->categoria = $categoria;
        $this->precio = $precio;
        $this->stock = $stock;
    }
    public function getCodigo() {
        return $this->codigo;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getCategoria() {
        return $this->categoria;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function getStock() {
        return $this->stock;
    }
    public function getPrecioConDescuento($porcentaje = 10) {
        $descuento = $this->precio * ($porcentaje / 100);
        $precioFinal = $this->precio - $descuento;
        return round($precioFinal, 2);
    }
    public function hayStock() {
        if ($this->stock > 0) {
            return true;
        } else {
            return false;
        }
    }
    public function mostrarTarjeta() {
        $html = "<div class='tarjeta'>";
        $html .= "<h3>" . htmlspecialchars($this->codigo) . "</h3>";
        $html .= "<span class='categoria'>" . htmlspecialchars($this->categoria) . "</span>";
        $html .= "<p class='nombre-producto'>" . htmlspecialchars($this->nombre) . "</p>";
        $html .= "<p class='precio'>Bs " . number_format($this->precio, 2) . "</p>";
        $html .= "<p class='descuento'>Con 10% de descuento: Bs " . number_format($this->getPrecioConDescuento(), 2) . "</p>";
    if ($this->hayStock()) {
        $html .= "<p class='stock'>Stock disponible: " . $this->stock . " unidades</p>";
    } else {
         $html .= "<span class='agotado'>AGOTADO</span>";
    }
    $html .= "</div>";
    return $html;
    }
}
?>