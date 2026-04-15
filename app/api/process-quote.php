<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data && !empty($data['items']) && !empty($data['cliente']['nombre'])) {
    $db = Database::getInstance()->getConnection();
    $codigo = 'COT-' . strtoupper(substr(uniqid(), -5));
    $cliente = htmlspecialchars($data['cliente']['nombre']);
    $subtotal = 0;

    foreach ($data['items'] as $item) {
        $subtotal += ($item['precio'] ?? 0) * ($item['cantidad'] ?? 1);
    }

    $descuento = 0;
    $iva = 0;
    $total = $data['total'] ?? $subtotal;

    try {
        $db->beginTransaction();
        $query = "INSERT INTO quotes (codigo, cliente, usuario_id, subtotal, descuento, iva, total, fecha) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $db->prepare($query);
        $stmt->execute([$codigo, $cliente, null, $subtotal, $descuento, $iva, $total]);

        $quoteId = $db->lastInsertId();
        foreach ($data['items'] as $item) {
            $queryDetalle = "INSERT INTO quote_items (quote_id, service_id, cantidad, precio_unitario, subtotal) 
                             VALUES (?, ?, ?, ?, ?)";
            $stmtDetalle = $db->prepare($queryDetalle);
            $cantidad = $item['cantidad'] ?? 1;
            $precioUnitario = $item['precio'] ?? 0;
            $stmtDetalle->execute([
                $quoteId,
                $item['id'] ?? null,
                $cantidad,
                $precioUnitario,
                $cantidad * $precioUnitario
            ]);
        }

        $db->commit();
        echo json_encode(['success' => true, 'codigo' => $codigo]);
    } catch (Exception $e) {
        $db->rollBack();
        error_log('Error process-quote.php: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al guardar la cotización en la base de datos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
}
?>