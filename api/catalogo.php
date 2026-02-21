<?php
/**
 * GET /api/catalogo.php
 * Devuelve el catálogo de servicios agrupados por categoría
 */
require_once 'init.php';

$catalogo = Service::obtenerCatalogo();
$agrupado = [];

foreach ($catalogo as $servicio) {
    $cat = $servicio->getCategoria();
    if (!isset($agrupado[$cat])) {
        $agrupado[$cat] = [];
    }
    $agrupado[$cat][] = $servicio->toArray();
}

echo json_encode([
    'exito' => true,
    'categorias' => $agrupado
]);
?>
