<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registrar Usuario</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href=../styles.css rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<!-- BOTON VOLVER -->
<a href="javascript:history.back()" 
class="btn btn-outline-secondary mb-3 d-inline-flex align-items-center gap-2 back-btn">
<i class="bi bi-arrow-left"></i>
Volver
</a>

<div class="card shadow-sm col-md-6 mx-auto">

<div class="card-header bg-primary text-white d-flex align-items-center gap-2">
<i class="bi bi-person-plus"></i>
<h5 class="mb-0">Registrar Nuevo Usuario</h5>
</div>

<div class="card-body p-4">

<form action="../controllers/UserController.php?action=store" method="POST">

<div class="mb-3">
<label class="form-label">Nombre completo</label>
<input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre del usuario" required>
</div>

<div class="mb-3">
<label class="form-label">Usuario</label>
<input type="text" name="usuario" class="form-control" placeholder="Nombre de usuario para iniciar sesión" required>
</div>

<div class="mb-3">
<label class="form-label">Correo electrónico</label>
<input type="email" name="email" class="form-control" placeholder="correo@empresa.com" required>
</div>

<div class="mb-3">
<label class="form-label">Contraseña</label>
<input type="password" name="password" class="form-control" placeholder="Ingrese una contraseña segura" required>
</div>

<div class="mb-4">
<label class="form-label">Rol del usuario</label>

<select name="rol" class="form-select">

<option value="admin">Administrador</option>
<option value="empleado">Empleado</option>

</select>

</div>

<button class="btn btn-success w-100 d-flex justify-content-center align-items-center gap-2">
<i class="bi bi-save"></i>
Guardar Usuario
</button>

</form>

</div>
</div>
</div>

</body>
</html>