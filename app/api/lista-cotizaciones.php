<?php
session_start();

if (empty($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../views/login.php');
    exit();
}

require_once __DIR__ . '/../config/database.php';
$db = Database::getInstance()->getConnection();

$query = "SELECT q.codigo, q.cliente, q.fecha, q.total, COALESCE(SUM(qi.cantidad), 0) AS cantidad_servicios
          FROM quotes q
          LEFT JOIN quote_items qi ON qi.quote_id = q.id
          GROUP BY q.id, q.codigo, q.cliente, q.fecha, q.total
          ORDER BY q.fecha DESC";
$stmt = $db->query($query);
$cotizaciones = $stmt ? $stmt->fetchAll(PDO::FETCH_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historial de Cotizaciones</title>
    <link rel="stylesheet" href="../views/services/assets/services-catalog.css">
    <style>
        body { background: linear-gradient(180deg, #eef2ff 0%, #f8fafc 100%); }
        .page-wrapper { max-width: 1200px; margin: 0 auto; padding: 36px 20px 60px; }
        .history-header { display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 18px; margin-bottom: 28px; background: white; border-radius: 24px; padding: 24px; border: 1px solid rgba(148, 163, 184, 0.18); box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); }
        .history-header h2 { margin: 0; font-size: clamp(1.85rem, 2.2vw, 2.4rem); color: var(--secondary); }
        .history-header .subtitle { color: var(--muted); margin: 6px 0 0; max-width: 560px; line-height: 1.6; }
        .history-header .btn-back { display: inline-flex; align-items: center; justify-content: center; gap: 8px; background: var(--primary); color: white; border-radius: 999px; padding: 12px 22px; text-decoration: none; font-weight: 700; box-shadow: 0 12px 25px rgba(37, 99, 235, 0.18); }
        .history-header .btn-back:hover { background: var(--primary-dark); }
        .history-table { width: 100%; border-collapse: collapse; margin: 0; }
        .history-table thead tr { background: #f8fafc; }
        .history-table th, .history-table td { padding: 18px 16px; text-align: left; border-bottom: 1px solid #e2e8f0; color: var(--text); }
        .history-table th { color: var(--secondary); font-weight: 700; }
        .history-card { background: white; border-radius: 24px; padding: 24px; box-shadow: 0 18px 40px rgba(15, 23, 42, 0.06); border: 1px solid rgba(148, 163, 184, 0.18); }
        .history-card h3 { margin: 0 0 8px; color: var(--secondary); }
        .history-card p { margin: 8px 0; color: var(--muted); }
        .table-wrapper { overflow-x: auto; }
        .no-data { padding: 40px; text-align: center; color: var(--muted); }
        @media (max-width: 880px) {
            .history-header { flex-direction: column; align-items: stretch; }
            .history-table th, .history-table td { padding: 14px 12px; }
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <header class="history-header">
            <div>
                <h2>Historial de Cotizaciones</h2>
                <p class="subtitle">Todas las cotizaciones generadas están aquí. Navega fácilmente entre registros y revisa totales rápidamente.</p>
            </div>
            <a href="../views/services/services-catalog.php" class="btn-back">← Volver al Catálogo</a>
        </header>

        <div class="history-card">
            <?php if (empty($cotizaciones)): ?>
                <div class="no-data">No hay cotizaciones registradas todavía.</div>
            <?php else: ?>
                <div class="table-wrapper">
                    <table class="history-table">
                        <thead>
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
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
