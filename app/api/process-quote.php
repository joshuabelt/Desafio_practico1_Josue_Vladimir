<?php
header('Content-Type: application/json');

// Recibimos los datos de la petición Fetch
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if ($data && !empty($data['items'])) {
    $archivo = 'cotizaciones.json';
    
    // 1. Leer cotizaciones existentes
    $cotizaciones = [];
    if (file_exists($archivo)) {
        $cotizaciones = json_decode(file_get_contents($archivo), true);
    }

    // 2. Crear la nueva cotización con los campos requeridos
    $nuevaCotizacion = [
        'codigo'   => 'COT-' . strtoupper(substr(uniqid(), -5)), // Genera código único
        'cliente'  => htmlspecialchars($data['cliente']['nombre']),
        'fecha'    => date('d/m/Y H:i'),
        'total'    => $data['total'],
        'servicios'=> count($data['items']) // Cantidad de servicios
    ];

    // 3. Guardar en el archivo
    $cotizaciones[] = $nuevaCotizacion;
    if (file_put_contents($archivo, json_encode($cotizaciones, JSON_PRETTY_PRINT))) {
        echo json_encode(['success' => true, 'codigo' => $nuevaCotizacion['codigo']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al escribir el archivo']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
}
?>