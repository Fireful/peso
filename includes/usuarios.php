<?php
if (!isset($_SESSION['usuario_id'])) {
  echo "<p class='text-danger'>Acceso no autorizado.</p>";
  return;
}
require_once 'db.php';

$usuario_id = $_SESSION['usuario_id'];

// Obtener usuarios añadidos por el actual
$stmt = $pdo->prepare("SELECT id, nombre, email FROM usuarios WHERE creado_por = ?");
$stmt->execute([$usuario_id]);
$usuarios = $stmt->fetchAll();
?>

<h3>Usuarios asociados</h3>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($usuarios as $u): ?>
      <tr>
        <td><?= htmlspecialchars($u['nombre']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Botón para añadir usuario -->
<button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
  + Añadir usuario
</button>

<?php include 'includes/modales.php'; ?>
