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

// Nota: esta versión antigua ya no utiliza JSON para guardar cotizaciones.
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Confirmación de Cotización</title>
    <link rel="stylesheet" href="../services/assets/services-catalog.css">
    <style>
        body { min-height: 100vh; background: linear-gradient(180deg, #eef2ff 0%, #f8fafc 100%); display: flex; align-items: center; justify-content: center; padding: 30px; }
        .quote-card { width: min(920px, 100%); background: white; border-radius: 30px; box-shadow: 0 28px 80px rgba(15, 23, 42, 0.1); border: 1px solid rgba(148, 163, 184, 0.18); padding: 35px; }
        .quote-header { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 20px; align-items: flex-start; border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 24px; }
        .quote-header .badge { background: #eff6ff; color: #1d4ed8; padding: 10px 16px; border-radius: 999px; font-size: 0.9rem; display: inline-flex; align-items: center; }
        .quote-header h2 { margin: 0 0 10px; font-size: 2rem; color: var(--secondary); }
        .quote-header p { margin: 0; color: var(--muted); }
        .details p { margin: 0 0 12px; color: var(--text); }
        .quote-table { width: 100%; border-collapse: collapse; margin: 24px 0; }
        .quote-table th,
        .quote-table td { padding: 14px 12px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .quote-table thead tr { background: #f8fafc; }
        .quote-table th { color: var(--secondary); font-weight: 700; }
        .quote-summary { display: grid; gap: 12px; margin-top: 18px; }
        .quote-summary .row { display: flex; justify-content: space-between; gap: 12px; color: var(--text); }
        .quote-summary .row.total-row { color: var(--primary); font-size: 1.15rem; font-weight: 700; border-top: 1px solid #e2e8f0; padding-top: 16px; }
        .quote-actions { display: flex; flex-wrap: wrap; gap: 14px; justify-content: flex-end; margin-top: 28px; }
        .quote-actions .btn { min-width: 160px; padding: 12px 24px; border-radius: 999px; }
        .quote-actions .btn-secondary { background: #64748b; color: white; border: none; }
        .quote-actions .btn-secondary:hover { background: #475569; }
        .quote-actions .btn-primary { background: var(--primary); color: white; border: none; }
        .quote-actions .btn-primary:hover { background: var(--primary-dark); }
    </style>
</head>
<body>

<div class="quote-card">
    <div class="quote-header">
        <div>
            <span class="badge">Cotización Generada</span>
            <h2>Código: <?php echo $codigoUnico; ?></h2>
            <p><strong>Cliente:</strong> <?php echo $nombre; ?> (<?php echo $empresa; ?>)</p>
        </div>
        <div>
            <p><strong>Fecha emisión:</strong> <?php echo $miCotizacion->getFechaGeneracion(); ?></p>
            <p><strong>Válida hasta:</strong> <span style="color: #dc2626;"><?php echo $miCotizacion->getFechaValidez(); ?></span></p>
        </div>
    </div>

    <table class="quote-table">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Cant.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resumen['items'] as $it): ?>
            <tr>
                <td><?php echo $it['servicio']->getNombre(); ?></td>
                <td><?php echo $it['cantidad']; ?></td>
                <td>$<?php echo number_format($it['servicio']->getPrecio() * $it['cantidad'], 2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="quote-summary">
        <div class="row"><span>Subtotal:</span> <span>$<?php echo number_format($resumen['subtotal'], 2); ?></span></div>
        <div class="row" style="color: #16a34a;"><span>Descuento:</span> <span>-$<?php echo number_format($resumen['descuento'], 2); ?></span></div>
        <div class="row"><span>IVA (15%):</span> <span>$<?php echo number_format($resumen['iva'], 2); ?></span></div>
        <div class="row total-row"><span>Total:</span> <span>$<?php echo number_format($resumen['total'], 2); ?></span></div>
    </div>

    <div class="quote-actions">
        <button onclick="window.location.href='services-catalog.php'" class="btn btn-secondary">Cerrar y Volver</button>
        <button onclick="window.print()" class="btn btn-primary">Imprimir PDF</button>
    </div>
</div>

</body>
</html>