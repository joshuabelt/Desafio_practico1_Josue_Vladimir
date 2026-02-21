<?php
/**
 * GET /api/historial.php
 * Devuelve el historial de cotizaciones generadas
 */
require_once 'init.php';

$historial = $_SESSION['cotizaciones'] ?? [];

// Ordenar por fecha descendente (más recientes primero)
usort($historial, function($a, $b) {
    return strtotime($b['fecha']) - strtotime($a['fecha']);
});

echo json_encode([
    'exito' => true,
    'total' => count($historial),
    'cotizaciones' => $historial
]);
?>
