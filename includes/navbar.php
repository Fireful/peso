<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Mi Salud</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link<?= ($pagina === 'home') ? ' active' : '' ?>" href="index.php?p=home">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link<?= ($pagina === 'peso') ? ' active' : '' ?>" href="index.php?p=peso">Gráfico de peso</a>
        </li>
        <!-- Añadiremos más pestañas después -->
         <?php if (isset($_SESSION['usuario_id'])): ?>
        <li class="nav-item">
          <a class="nav-link<?= ($pagina === 'usuarios') ? ' active' : '' ?>" href="index.php?p=usuarios">Usuarios</a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a class="nav-link<?= ($pagina === 'historial') ? ' active' : '' ?>" href="index.php?p=historial">Historial</a>
      </ul>

      <?php if (isset($_SESSION['usuario_id'])): ?>
  <div class="d-flex align-items-center text-white">
    <span class="me-3">Hola, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></span>
    <a href="auth/logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
  </div>
<?php else: ?>
  <button class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#modalAuth">
    Login / Registro
  </button>
<?php endif; ?>


    </div>
  </div>
</nav>

<?php include 'modales.php' ?>
