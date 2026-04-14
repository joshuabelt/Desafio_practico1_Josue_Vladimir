<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Usuarios</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


</head>
<body class="bg-light">

<div class="container mt-5">
    <!-- BOTON VOLVER -->
<a href="javascript:history.back()" 
class="btn btn-outline-secondary mb-3 d-inline-flex align-items-center gap-2 back-btn">
<i class="bi bi-arrow-left"></i>
Volver
</a>

<div class="d-flex justify-content-between mb-3">
<h2>Gestión de Usuarios</h2>

<a href="../../controllers/UserController.php?action=create" class="btn btn-primary">
Registrar Usuario
</a>

</div>

<div class="card shadow">
<div class="card-body">

<table class="table table-bordered table-hover">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Nombre</th>
<th>Usuario</th>
<th>Rol</th>
<th>Estado</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>

<?php foreach($usuarios as $u): ?>

<tr>
<td><?= $u["id"] ?></td>
<td><?= htmlspecialchars($u["nombre"]) ?></td>
<td><?= htmlspecialchars($u["usuario"]) ?></td>
<td><?= htmlspecialchars($u["rol"]) ?></td>
<td><?= $u["estado"] ? "Activo" : "Inactivo" ?></td>

<td>

<a href="../../controllers/UserController.php?action=delete&id=<?= $u["id"] ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('¿Eliminar usuario?')">

Eliminar

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>
</div>

</div>

</body>
</html>