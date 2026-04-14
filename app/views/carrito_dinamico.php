<div class="container mt-4">
    <h2>Tu Carrito de Cotización</h2>
    <table class="table table-hover mt-3">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Cantidad</th>
                <th>Precio Unit.</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($_SESSION['carrito'])): ?>
                <?php foreach($_SESSION['carrito'] as $item): ?>
                <tr>
                    <td><?php echo $item['nombre']; ?></td>
                    <td><?php echo $item['cantidad']; ?></td>
                    <td>$<?php echo number_format($item['precio'], 2); ?></td>
                    <td>$<?php echo number_format($item['precio'] * $item['cantidad'], 2); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">El carrito está vacío</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-end gap-2">
        <a href="index.php?action=clear_cart" class="btn btn-danger">Vaciar Carrito</a>
        <a href="index.php?action=checkout" class="btn btn-primary">Generar Cotización</a>
    </div>
</div>