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

        if ($_SESSION["rol"] === "admin") {
            header("Location: user_dashboard.php");
            exit();
        }

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
<style>
:root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --secondary: #0f172a;
    --bg: #f8fafc;
    --card: #ffffff;
    --border: #e2e8f0;
    --text: #111827;
    --muted: #6b7280;
}

* {
    box-sizing: border-box;
}

body {
    min-height: 100vh;
    margin: 0;
    font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    background: linear-gradient(180deg, #eef2ff 0%, #f8fafc 100%);
    color: var(--text);
    display: grid;
    place-items: center;
    padding: 24px;
}

.login-card {
    width: min(460px, 100%);
    background: var(--card);
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 28px;
    padding: 36px 32px;
    box-shadow: 0 28px 80px rgba(15, 23, 42, 0.08);
}

.login-card h2 {
    margin: 0;
    font-size: clamp(2rem, 2.4vw, 2.2rem);
    color: var(--secondary);
}

.subtitle {
    margin: 10px 0 24px;
    color: var(--muted);
    line-height: 1.6;
}

.form-control-icon {
    position: relative;
}

.form-control-icon i {
    position: absolute;
    top: 50%;
    left: 16px;
    transform: translateY(-50%);
    color: var(--muted);
}

.form-control-icon input {
    padding-left: 48px;
    height: 56px;
    border-radius: 16px;
    border: 1px solid rgba(148, 163, 184, 0.5);
    background: #f8fafc;
}

.form-control-icon input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
}

.btn-gradient {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    border: none;
    padding: 14px 22px;
    border-radius: 999px;
    font-weight: 700;
    box-shadow: 0 16px 34px rgba(37, 99, 235, 0.18);
}

.btn-gradient:hover {
    background: linear-gradient(135deg, var(--primary-dark), var(--primary));
}

.error-message {
    margin-bottom: 20px;
    padding: 14px 18px;
    background: #f8d7da;
    color: #7f1d1d;
    border: 1px solid #f1a6b5;
    border-radius: 16px;
}

.forgot-password,
.text-center a {
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
}

.forgot-password a:hover,
.text-center a:hover {
    text-decoration: underline;
}
</style>
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