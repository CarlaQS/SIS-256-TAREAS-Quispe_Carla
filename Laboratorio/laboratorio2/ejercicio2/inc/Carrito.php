<?php
// Nombre Apellido: Marco Antonio Sanchez Galarza y Quispe Serrano Carla
class Carrito {
    private $items;

public function __construct() {
        $this->items = array();
    }
public function agregar($codigo, $cantidad = 1) {
        if ($cantidad < 1) {
            $cantidad = 1;
        }
        if (isset($this->items[$codigo])) {
            $this->items[$codigo] = $this->items[$codigo] + $cantidad;
        } else {
            $this->items[$codigo] = $cantidad;
        }
    }
public function quitar($codigo) {
        unset($this->items[$codigo]);
    }
public function vaciar() {
        $this->items = array();
    }
public function getItems() {
        return $this->items;
    }
public function estaVacio() {
        if (count($this->items) == 0) {
            return true;
        } else {
            return false;
        }
    }
public function cantidadTotal() {
        return array_sum($this->items);
    }
public function total($catalogo) {
     $totalCarrito = 0;
    foreach ($this->items as $codigo => $cantidad) {
    $producto = buscarProducto($codigo, $catalogo);
    if ($producto != null) {
        $totalCarrito = $totalCarrito + ($producto->getPrecio() * $cantidad);
    }
}
return round($totalCarrito, 2);
    }
}
?>