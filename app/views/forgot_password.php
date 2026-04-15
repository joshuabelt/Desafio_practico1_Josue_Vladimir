<?php
session_start();
require_once "../models/User.php";

$error = "";
$success = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){

    $email = $_POST["email"];
    $dao = new User();
    $user = $dao->buscarUsuarioPorEmail($email);

    if($user){
        // Generar token temporal
        $token = bin2hex(random_bytes(16));
        // Aquí enviar correo con enlace
        $success = "Correo de reestablecimiento enviado a $email";
    } else {
        $error = "No se encontró un usuario con ese correo";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reestablecer Contraseña</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="style.css" rel="stylesheet">
</head>
<body>

<div class="reset-card">

<h2>Reestablecer Contraseña</h2>
<p class="subtitle">Ingresa tu correo para recibir instrucciones</p>

<?php if(!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
<?php elseif(!empty($success)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
<?php endif; ?>

<form method="POST" action="">

    <div class="mb-4 form-control-icon">
        <i class="fa fa-envelope"></i>
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required>
    </div>

    <div class="d-grid mb-3">
        <button class="btn btn-gradient btn-lg">Enviar correo</button>
    </div>

    <div class="text-center">
        <a href="login.php">Volver al login</a>
    </div>

</form>

</div>

</body>
</html>