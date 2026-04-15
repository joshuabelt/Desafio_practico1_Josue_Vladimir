<?php
session_start();

if (empty($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["rol"] !== "admin") {
    header("Location: ./services/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h3 class="mb-0">Panel de Administrador</h3>
                </div>
                <div class="card-body">
                    <p>Hola <strong><?php echo htmlspecialchars($_SESSION["nombre"]); ?></strong>, has iniciado sesión como <strong>Administrador</strong>.</p>
                    <p>Desde aquí puedes gestionar el sistema y revisar cotizaciones.</p>

                    <div class="list-group">
                        <a href="services/index.php" class="list-group-item list-group-item-action">Ver página principal de cotizaciones</a>
                        <a href="services/services-catalog.php" class="list-group-item list-group-item-action">Ver catálogo de servicios</a>
                        <a href="../controllers/UserController.php?action=index" class="list-group-item list-group-item-action">Gestionar usuarios</a>
                        <a href="../api/lista-cotizaciones.php" class="list-group-item list-group-item-action">Ver cotizaciones registradas</a>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="./logout.php" class="btn btn-outline-secondary">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
