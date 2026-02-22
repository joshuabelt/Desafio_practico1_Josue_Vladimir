<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Cotizaciones Profesionales</title>
    <link rel="stylesheet" href="../assets/services-catalog.css">    
</head>
<body>

<h1>Generador de Cotizaciones</h1>

<div class="container">
    <section>
        <h2>Servicios Disponibles</h2>
        <div class="services-grid">
            <?php include 'datos.php'; foreach($catalogo as $s): ?>
                <div class="card">
                    <small><?php echo $s->getCategoria(); ?></small>
                    <h3><?php echo $s->getNombre(); ?></h3>
                    <p><?php echo $s->getDescripcion(); ?></p>
                    <span class="price">$<?php echo number_format($s->getPrecio(), 2); ?></span>
                    <button class="btn" onclick="agregarAlCarrito(<?php echo $s->getId(); ?>, '<?php echo $s->getNombre(); ?>', <?php echo $s->getPrecio(); ?>)">
                        Agregar +
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <aside class="quote-panel">
        <h3>Datos del Cliente</h3>
        <form action="procesar.php" method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="empresa" placeholder="Empresa">
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" name="tel" placeholder="Teléfono">
            
            <hr>
            <h4>Servicios Seleccionados</h4>
            <div id="carrito-lista">
                <p style="color: #666;">No hay servicios seleccionados</p>
            </div>
            
            <input type="hidden" name="items_json" id="items_json">
            
            <button type="submit" class="btn" style="background: #10b981; margin-top: 15px;">Generar Cotización</button>
        </form>
    </aside>
</div>

<script src="../assets/services-catalog.js"></script>
</body>
</html>