<?php
/**
 * POST /api/cotizar.php
 * Genera una cotización a partir del carrito actual
 * Parámetros: cliente (nombre del cliente)
 */
require_once 'init.php';

$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
$cliente = trim($data['cliente'] ?? '');

if (!$cliente) {
    echo json_encode(['exito' => false, 'mensaje' => 'Por favor ingrese el nombre del cliente']);
    exit;
}

if (empty($_SESSION['carrito'])) {
    echo json_encode(['exito' => false, 'mensaje' => 'El carrito está vacío']);
    exit;
}

// Crear una quote basada en el carrito
$quote = new Quote();
$quote->setCliente($cliente);

// Agregar items del carrito a la quote
foreach ($_SESSION['carrito'] as $item) {
    $servicio = Service::obtenerPorId($item['servicio_id']);
    if ($servicio) {
        $quote->agregarItem($servicio, $item['cantidad']);
    }
}

// Generar y guardar en sesión
$resultado = $quote->generar();

if ($resultado['exito']) {
    // Limpiar carrito después de generar cotización
    $_SESSION['carrito'] = [];
    
    echo json_encode([
        'exito' => true,
        'mensaje' => 'Cotización generada exitosamente',
        'codigo' => $resultado['codigo'],
        'cotizacion' => $quote->toArray()
    ]);
} else {
    echo json_encode(['exito' => false, 'mensaje' => $resultado['mensaje']]);
}
?>
