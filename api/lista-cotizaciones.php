<?php
$cotizaciones = file_exists('cotizaciones.json') ? json_decode(file_get_contents('cotizaciones.json'), true) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cotizaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 768px) {
            .table-responsive-desktop { display: none; }
            .cards-mobile { display: block; }
        }
        @media (min-width: 769px) {
            .table-responsive-desktop { display: block; }
            .cards-mobile { display: none; }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Historial de Cotizaciones</h2>
            <a href="../pages/services-catalog.php" class="btn btn-outline-primary">← Volver al Catálogo</a>
        </div>

        <div class="table-responsive-desktop card shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Servicios</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cotizaciones as $c): ?>
                    <tr>
                        <td><strong><?php echo $c['codigo']; ?></strong></td>
                        <td><?php echo $c['cliente']; ?></td>
                        <td><?php echo $c['fecha']; ?></td>
                        <td><?php echo $c['cantidad_servicios']; ?></td>
                        <td>$<?php echo number_format($c['total'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
        </div>

        <div class="cards-mobile">
            <?php foreach ($cotizaciones as $c): ?>
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-title text-primary"><?php echo $c['codigo']; ?></h5>
                        <span class="text-muted small"><?php echo $c['fecha']; ?></span>
                    </div>
                    <p class="mb-1"><strong>Cliente:</strong> <?php echo $c['cliente']; ?></p>
                    <p class="mb-1"><strong>Servicios:</strong> <?php echo $c['cantidad_servicios']; ?></p>
                    <h6 class="mt-2 text-end">Total: $<?php echo number_format($c['total'], 2); ?></h6>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>