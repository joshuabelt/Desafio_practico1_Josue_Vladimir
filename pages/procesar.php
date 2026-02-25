<?php
require_once '../classes/service.class.php';
require_once '../classes/quote.class.php';
require_once 'datos.php'; // Para buscar los servicios por ID

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? 'Cliente';
    $empresa = $_POST['empresa'] ?? 'N/A';
    $items_json = $_POST['items_json'] ?? '[]';
    $items_seleccionados = json_decode($items_json, true);

    // 1. Instanciar la cotización
    // Usamos un número aleatorio para el consecutivo por ahora
    $consecutivo = rand(1, 999); 
    $miCotizacion = new Quote($nombre);
    $miCotizacion->establecerFechas();
    
    // Sobrescribimos el código con el formato solicitado: COT-YYYY-####
    $codigoUnico = Quote::generarCodigo($consecutivo);

    // 2. Mapear items del JSON a objetos Service y agregarlos
    foreach ($items_seleccionados as $item) {
        // Buscamos el objeto Service original en nuestro "catálogo" por ID
        foreach ($catalogo as $servicioOriginal) {
            if ($servicioOriginal->getId() == $item['id']) {
                $miCotizacion->agregarItem($servicioOriginal, $item['cantidad']);
            }
        }
    }

    $resumen = $miCotizacion->generar();

    // ... después de $resumen = $miCotizacion->generar();

// --- LÓGICA DE GUARDADO EN JSON ---
$archivo = dirname(__DIR__) . '/cotizaciones.json';
$cotizacionesExistentes = [];

// 1. Leer lo que ya existe
if (file_exists($archivo)) {
    $contenido = file_get_contents($archivo);
    $cotizacionesExistentes = json_decode($contenido, true) ?? [];
}

// 2. Preparar la nueva entrada (asegurando que coincida con lo que pide lista-cotizaciones.php)
$nuevaEntrada = [
    'codigo'             => $codigoUnico,
    'cliente'            => htmlspecialchars($nombre),
    'fecha'              => date('d/m/Y H:i'),
    'cantidad_servicios' => count($resumen['items']),
    'total'              => $resumen['total']
];

// 3. Añadir al array y guardar
$cotizacionesExistentes[] = $nuevaEntrada;
file_put_contents($archivo, json_encode($cotizacionesExistentes, JSON_PRETTY_PRINT));
// ----------------------------------
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Cotización</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .modal-overlay { background: rgba(0,0,0,0.5); position: fixed; top:0; left:0; width:100%; height:100%; display: flex; align-items: center; justify-content: center; }
        .modal-content { background: white; padding: 30px; border-radius: 12px; max-width: 600px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2); }
        .header-quote { border-bottom: 2px solid #eee; margin-bottom: 20px; padding-bottom: 10px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .total-row { font-size: 1.4em; font-weight: bold; color: #2563eb; border-top: 2px solid #eee; padding-top: 10px; }
        .badge { background: #e0e7ff; color: #4338ca; padding: 4px 12px; border-radius: 20px; font-size: 0.8em; }
    </style>
</head>
<body>

<div class="modal-overlay">
    <div class="modal-content">
        <div class="header-quote">
            <span class="badge">Cotización Generada</span>
            <h2>Código: <?php echo $codigoUnico; ?></h2>
            <p><strong>Cliente:</strong> <?php echo $nombre; ?> (<?php echo $empresa; ?>)</p>
        </div>

        <div class="details">
            <p><strong>Fecha emisión:</strong> <?php echo $miCotizacion->getFechaGeneracion(); ?></p>
            <p><strong>Válida hasta:</strong> <span style="color: #dc2626;"><?php echo $miCotizacion->getFechaValidez(); ?></span></p>
            
            <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
                <thead>
                    <tr style="background: #f8fafc; text-align: left;">
                        <th style="padding: 8px;">Servicio</th>
                        <th>Cant.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resumen['items'] as $it): ?>
                    <tr>
                        <td style="padding: 8px; border-bottom: 1px solid #eee;"><?php echo $it['servicio']->getNombre(); ?></td>
                        <td style="border-bottom: 1px solid #eee;"><?php echo $it['cantidad']; ?></td>
                        <td style="border-bottom: 1px solid #eee;">$<?php echo number_format($it['servicio']->getPrecio() * $it['cantidad'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="row"><span>Subtotal:</span> <span>$<?php echo number_format($resumen['subtotal'], 2); ?></span></div>
            <div class="row" style="color: #16a34a;"><span>Descuento:</span> <span>-$<?php echo number_format($resumen['descuento'], 2); ?></span></div>
            <div class="row"><span>IVA (15%):</span> <span>$<?php echo number_format($resumen['iva'], 2); ?></span></div>
            <div class="row total-row"><span>Total:</span> <span>$<?php echo number_format($resumen['total'], 2); ?></span></div>
        </div>

        <div style="margin-top: 30px; text-align: center;">
            <button onclick="window.location.href='services-catalog.php'" class="btn" style="background: #64748b; width: auto; padding: 10px 30px;">Cerrar y Volver</button>
            <button onclick="window.print()" class="btn" style="background: #2563eb; width: auto; padding: 10px 30px; margin-left: 10px;">Imprimir PDF</button>
        </div>
    </div>
</div>

</body>
</html>