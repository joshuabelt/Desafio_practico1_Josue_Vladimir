<?php
session_start();
require_once "../models/User.php";

// Inicializar mensaje de error
$error = "";

// Procesar login si viene POST
if($_SERVER["REQUEST_METHOD"] === "POST"){

    $usuario = $_POST["usuario"];
    $password = $_POST["password"];

    $dao = new User();
    $user = $dao->buscarUsuario($usuario);

    if($user && password_verify($password,$user["password"])){

        session_regenerate_id(true);
        $_SESSION["usuario"] = $user["usuario"];
        $_SESSION["rol"] = $user["rol"];
        $_SESSION["nombre"] = $user["nombre"];
        $_SESSION["id"] = $user["id"];

        header("Location: services/index.php");
        exit();

    } else {
        $error = "Credenciales incorrectas";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>--Servicio de Cotizaciones--</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="styles.css" rel="stylesheet">
</head>
<body>

<div class="login-card">

    <h2>Bienvenido</h2>
    <p class="subtitle">Inicia sesión para continuar</p>

    <?php if(!empty($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="">

        <!-- Usuario -->
        <div class="mb-4 form-control-icon">
            <i class="fa fa-user"></i>
            <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
        </div>

        <!-- Contraseña -->
        <div class="mb-4 form-control-icon">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
        </div>

        <!-- Botón Login -->
        <div class="d-grid mb-3">
            <button class="btn btn-gradient btn-lg">Ingresar</button>
         
        </div>

        <!-- Olvido Contraseña -->
        <div class="forgot-password">
            <a href="forgot_password.php">¿Olvidaste tu contraseña?</a>
        </div>

        <!-- Registrar Usuario -->
        <div class="text-center mt-2">
            ¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>
        </div>

    </form>

</div>

</body>
</html>