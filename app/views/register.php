<?php
session_start();
require_once "../models/User.php";

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $nombre = trim($_POST["nombre"]);
    $usuario = trim($_POST["usuario"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $rol = "empleado"; // por defecto

    $dao = new User();

    // Validar contraseñas iguales
    if($password !== $password2){
        $error = "Las contraseñas no coinciden";
    }
    // Verificar si usuario o email existen
    elseif($dao->existeUsuarioEmail($usuario,$email)){
        $error = "El usuario o correo ya existe";
    } else {
        if($dao->crearUsuario($nombre,$usuario,$email,$password,$rol)){
            $success = "Usuario registrado correctamente";
        } else {
            $error = "Error al registrar usuario";
        }
    }

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrar Usuario</title>
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

.register-card {
    width: min(520px, 100%);
    background: var(--card);
    border: 1px solid rgba(148, 163, 184, 0.24);
    border-radius: 28px;
    padding: 38px 34px;
    box-shadow: 0 28px 80px rgba(15, 23, 42, 0.08);
}

.register-card h2 {
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

.alert {
    border-radius: 16px;
    padding: 16px 18px;
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

<div class="register-card">

<h2>Registrar Usuario</h2>
<p class="subtitle">Complete los datos para crear una cuenta</p>

<?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php elseif(!empty($success)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST" action="">

    <div class="mb-3 form-control-icon">
        <i class="fa fa-user"></i>
        <input type="text" name="nombre" class="form-control" placeholder="Nombre completo" required>
    </div>

    <div class="mb-3 form-control-icon">
        <i class="fa fa-user-circle"></i>
        <input type="text" name="usuario" class="form-control" placeholder="Usuario" required>
    </div>

    <div class="mb-3 form-control-icon">
        <i class="fa fa-envelope"></i>
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>

    <div class="mb-3 form-control-icon">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
    </div>

    <div class="mb-3 form-control-icon">
        <i class="fa fa-lock"></i>
        <input type="password" name="password2" class="form-control" placeholder="Repetir contraseña" required>
    </div>

    <div class="d-grid mb-3">
        <button class="btn btn-gradient btn-lg">Registrar</button>
    </div>

    <div class="text-center">
        <a href="login.php">Volver al login</a>
    </div>

</form>

</div>
</body>
</html>