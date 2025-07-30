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
        <h5 class="modal-title">Nuevo usuario asociado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <label>Nombre:</label>
        <input type="text" name="nombre" class="form-control" required>

        <label class="mt-2">Email:</label>
        <input type="email" name="email" class="form-control" required>

        <label class="mt-2">Contraseña:</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Crear usuario</button>
      </div>
    </form>
  </div>
</div>
