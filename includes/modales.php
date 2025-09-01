<div class="modal fade" id="modalAuth" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Acceso a la cuenta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <div class="modal-body">
        <ul class="nav nav-tabs mb-3" id="authTabs" role="tablist">
          <li class="nav-item">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Iniciar sesión</button>
          </li>
          <li class="nav-item">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Registrarse</button>
          </li>
        </ul>

        <div class="tab-content">
          <!-- LOGIN -->
          <div class="tab-pane fade show active" id="login" role="tabpanel">
            <form action="auth/login.php" method="POST">
              <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-primary w-100">Entrar</button>
            </form>
          </div>

          <!-- REGISTRO -->
          <div class="tab-pane fade" id="register" role="tabpanel">
            <form action="auth/register.php" method="POST">
              <div class="mb-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Email:</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Contraseña:</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-success w-100">Registrarse</button>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalNuevoUsuario" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" action="auth/crear_usuario_asociado.php">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo usuario asociado </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>

        <label class="mt-2">Email:</label>
        <input type="email" name="email" class="form-control" required>

        <label class="mt-2">Contraseña:</label>
        <input type="password" name="password" class="form-control" required>

        <label class="mt-2">Altura (en metros):</label>
        <input type="number" name="altura" step="0.01" class="form-control">
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Crear usuario</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal peso -->
  

<div class="modal fade" id="modalPeso" tabindex="-1">
  <div class="modal-dialog">
    <form method="post" action="includes/guardar_peso.php" class="modal-content">
      <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($_GET['usuario_id'] ?? '') ?>">
      <div class="modal-header">
        <h5 class="modal-title">Nuevo Registro de Peso Usuario: <?=  $_GET['usuario_id']; ?> altura: <?= $alturas[0]['altura'] ?? '' ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="fecha" class="form-label">Fecha:</label>
        <input type="date" name="fecha" class="form-control" required>

        <label for="peso" class="form-label mt-3">Peso (kg):</label>
        <input type="number" name="peso" step="0.1" class="form-control" required>

        <label for="grasa_corporal" class="form-label mt-3">Grasa Corporal (%):</label>
        <input type="number" name="grasa_corporal" step="0.1" class="form-control">
        <label for="musculo" class="form-label mt-3">Músculo (%):</label>
        <input type="number" name="musculo" step="0.1" class="form-control">
        <small class="form-text text-muted">Estos campos son opcionales.</small>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal: Crear nuevo objetivo -->
<div class="modal fade" id="modalCrearObjetivo" tabindex="-1" aria-labelledby="modalCrearObjetivoLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="includes/crear_objetivo.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="modalCrearObjetivoLabel">Crear nuevo objetivo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="usuario_id" value="<?= $_GET['usuario_id'] ?? '' ?>">

          <input type="hidden" name="tipo" value="Peso">


          <div class="mb-3">
            <label for="valor_objetivo" class="form-label">Valor objetivo</label>
            <input type="number" step="any" class="form-control" id="valor_objetivo" name="valor_objetivo" required>
          </div>

          <div class="mb-3">
            <label for="fecha_limite" class="form-label">Fecha límite</label>
            <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" required>
          </div>

          <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones (opcional)</label>
            <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar objetivo</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
