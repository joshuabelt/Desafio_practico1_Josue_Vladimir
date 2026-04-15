<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (empty($_SESSION['usuario']) && empty($_SESSION['user_nombre'])) {
    header('Location: ../login.php');
    exit();
}

$userName = $_SESSION['nombre'] ?? $_SESSION['user_nombre'] ?? 'Usuario';
$userRole = $_SESSION['rol'] ?? $_SESSION['user_rol'] ?? 'Empleado';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Cotizaciones Profesionales</title>
    <link rel="stylesheet" href="assets/services-catalog.css">    
</head>
<body>

<header class="catalog-header">
    <div class="catalog-header-left">
        <div class="catalog-title">
            <h1>Generador de Cotizaciones</h1>
        </div>
        <p class="catalog-subtitle">Elige los servicios ideales para tu proyecto y genera cotizaciones profesionales.</p>
    </div>
    <div class="catalog-header-right">
        <div class="catalog-user-info">
            <span>Usuario: <strong><?php echo htmlspecialchars($userName); ?></strong></span>
            <span>Rol: <strong><?php echo htmlspecialchars($userRole); ?></strong></span>
        </div>
        <a href="../logout.php" class="logout-link">Cerrar sesión</a>
    </div>
</header>

<div class="container">
    <section>
        <div class="section-header">
            <h2>Servicios Disponibles</h2>
            <p>Elige los servicios que necesitas para tu proyecto.</p>
        </div>
        <div class="services-grid">
            <?php include '../datos.php'; foreach($catalogo as $s): ?>
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
      <button type="button" class="btn btn-outline-secondary" onclick="verCarrito()">
    🛒 Ver Carrito <span id="carrito-count" class="badge bg-primary">0</span>
</button>

<div id="servicios-seleccionados">
    </div>

<button id="btn-vaciar" class="btn btn-sm btn-danger mt-2" style="display:none;" onclick="vaciarCarrito()">
    Vaciar Carrito
</button>

        <h3>Datos del Cliente</h3>
        <form action="../procesar.php" method="POST" onsubmit="return validarEnvio(event)">
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

<?php if ($userRole === 'admin'): ?>
    <div class="text-end mb-3">
        <a href="../../api/lista-cotizaciones.php" class="btn btn-info text-white shadow-sm">
            📋 Ver Todas las Cotizaciones
        </a>
    </div>
<?php endif; ?>




<input type="hidden" name="items_json" id="items_json">

<div id="miModalCarrito" class="modal-personalizado">
    <div class="modal-contenido">
        <div class="modal-header">
            <h3>Resumen de Cotización</h3>
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
        </div>
        <div id="detalle-carrito-modal">
            </div>
        <div class="modal-footer">

            <button class="btn-secundario" onclick="cerrarModal()">Seguir agregando</button>
        </div>
    </div>
</div>


<script src="assets/services-catalog.js"></script>
</body>
</html>