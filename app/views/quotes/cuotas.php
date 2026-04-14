<div class="container mt-4">
    <div class="card border-success">
        <div class="card-header bg-success text-white">
            <h3>Cotización Generada: <?php echo $cuota->getCodigo(); ?></h3>
        </div>
        <div class="card-body">
            <h5>Resumen de Costos:</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item d-flex justify-content-between">
                    Subtotal: <span>$<?php echo number_format($cuota->getSubtotal(), 2); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between text-danger">
                    Descuento Aplicado: <span>-$<?php echo number_format($cuota->getDescuento(), 2); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between">
                    IVA (13%): <span>$<?php echo number_format($cuota->getIva(), 2); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between list-group-item-dark">
                    <strong>TOTAL FINAL:</strong> <strong>$<?php echo number_format($cuota->getTotal(), 2); ?></strong>
                </li>
            </ul>
            <p class="text-muted small">* Los descuentos se aplican según el monto total del subtotal.</p>
        </div>
        <div class="card-footer">
            <button onclick="window.print()" class="btn btn-secondary">Imprimir PDF</button>
            <a href="index.php?action=services" class="btn btn-link">Volver al catálogo</a>
        </div>
    </div>
</div>