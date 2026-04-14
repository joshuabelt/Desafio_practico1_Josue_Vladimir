<div class="container mt-4">
    <h2 class="mb-4">Catálogo de Servicios Informáticos</h2>
    <div class="row">
        <?php foreach ($servicios as $s): ?>
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <span class="badge bg-info text-dark"><?php echo $s['categoria']; ?></span>
                    <h5 class="card-title mt-2"><?php echo $s['nombre']; ?></h5>
                    <p class="card-text text-muted"><?php echo $s['descripcion']; ?></p>
                    <h4 class="text-primary">$<?php echo number_format($s['precio'], 2); ?></h4>
                </div>
                <div class="card-footer">
                    <a href="index.php?action=add_to_cart&id=<?php echo $s['id']; ?>" 
                       class="btn btn-outline-success w-100">Agregar al Carrito</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>