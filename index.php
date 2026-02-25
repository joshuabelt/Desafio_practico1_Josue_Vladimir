<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cotizaciones | Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; height: 100vh; display: flex; align-items: center; }
        .welcome-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-custom { padding: 15px 30px; border-radius: 10px; font-weight: 600; transition: all 0.3s; }
        .btn-custom:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="card welcome-card p-5">
                <h1 class="display-4 mb-4">Gestor de Cotizaciones</h1>
                <p class="lead text-muted mb-5">Bienvenido al sistema profesional de servicios IT. ¿Qué deseas hacer hoy?</p>
                
                <div class="d-grid gap-3 d-sm-flex justify-content-sm-center">
                    <a href="pages/services-catalog.php" class="btn btn-primary btn-custom btn-lg">
                      🛠️ Ver Catálogo
                    </a>
                </div>

                <?php 
                $archivo = 'cotizaciones.json';
                if (file_exists($archivo)): 
                    $data = json_decode(file_get_contents($archivo), true);
                    $total_cots = is_array($data) ? count($data) : 0;
                ?>
                <div class="mt-5 pt-4 border-top">
                    <span class="badge bg-light text-dark p-2">
                        Resumen: <?php echo $total_cots; ?> cotizaciones registradas
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>