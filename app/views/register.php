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

    $dao = new Usuarios();

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
<link href="styles.css" rel="stylesheet">
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