<?php
if (!isset($_SESSION['usuario_id'])) {
  echo "<p class='text-danger'>Acceso no autorizado.</p>";
  return;
}
require_once 'db/db.php';

$usuario_id = $_SESSION['usuario_id'];

// Obtener usuarios añadidos por el actual
$stmt = $pdo->prepare("SELECT id, nombre, email, altura FROM usuarios WHERE creado_por = ? or id = ?");
$stmt->execute([$usuario_id, $usuario_id]);
$usuarios = $stmt->fetchAll();
?>

<h3>Usuarios asociados</h3>

<table class="table table-striped">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th>Altura</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($usuarios as $u): ?>
      <tr>
        <td><?= htmlspecialchars($u['nombre']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['altura']) ?></td>
        <td>
          <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario" data-usuario-id="<?= $u['id'] ?>">Eliminar</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Botón para añadir usuario -->
<button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#modalNuevoUsuario">
  + Añadir usuario
</button>

<?php include 'includes/modales.php'; ?>
