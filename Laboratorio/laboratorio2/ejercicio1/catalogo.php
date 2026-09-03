<?php
// Nombre Apellido: Marco Antonio Sanchez Galarza y Quispe Serrano Carla
require_once "Producto.php";
function obtenerCatalogo() {
    $productos=array();
    $productos[]=new Producto("P01","Teclado mecanico RGB","Perifericos",320.00,12);
    $productos[]=new Producto("P02","Mouse inalambrico","Perifericos",145.50,8);
    $productos[]=new Producto("P03","Monitor 24 pulgadas","Pantallas",1250.00,5);
    $productos[]=new Producto("P04","Monitor curvo 27 pulg.","Pantallas",2100.00,0);
    $productos[]=new Producto("P05","Disco solido 480 GB","Almacenamiento",380.00,20);
    $productos[]=new Producto("P06","Memoria USB 64 GB","Almacenamiento",75.00,35);
    $productos[]=new Producto("P07","Audifonos con microfono","Perifericos",210.00,0);
    $productos[]=new Producto("P08","Disco externo 1 TB","Almacenamiento",640.00,6);
    return $productos;
}
function obtenerCategorias() {
    $categorias = array(
        "Perifericos"=>"Perifericos",
        "Pantallas"=>"Pantallas",
        "Almacenamiento"=>"Almacenamiento"
    );
    return $categorias;
}
function filtrarPorCategoria($productos, $categoria) {
    if (empty($categoria)) {
        return $productos;
    }
    $resultado = array();
    foreach ($productos as $prod) {
        if ($prod->getCategoria() == $categoria) {
            $resultado[] = $prod;
        }
    }
    return $resultado;
}
function obtenerPrecio($prod) {
    return $prod->getPrecio();
}
function obtenerStock($prod) {
    return $prod->getStock();
}
function estadisticas($productos) {
    $stats = array();
    $stats["total"] =count($productos);
    $precios = array_map("obtenerPrecio", $productos);
    $stocks = array_map("obtenerStock", $productos);
    $stats["stock"] = array_sum($stocks);
    if ($stats["total"] > 0) {
        $stats["promedio"] = array_sum($precios) / $stats["total"];
        $stats["mayor"] = max($precios);
        $stats["menor"] = min($precios);
    } else {
        $stats["promedio"] = 0;
        $stats["mayor"] = 0;
        $stats["menor"] = 0;
    }
    return $stats;
}
function contarPorCategoria($productos) {
    $conteo = array();
    foreach ($productos as $prod) {
        $cat = $prod->getCategoria();
        if (isset($conteo[$cat])) {
            $conteo[$cat] = $conteo[$cat] + 1;
        } else {
            $conteo[$cat] = 1;
        }
    }
    return $conteo;
}
?>