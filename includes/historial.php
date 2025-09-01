<?php

use BcMath\Number;

require_once 'db/db.php';
$usuario_logado=$_SESSION['usuario_id'] ?? null;
$usuario_elegido = $_GET['usuario_id'] ?? null;

if (!$usuario_logado) {
  echo "<p class='alert alert-danger'>Acceso no autorizado.</p>";
  return;
}


$stmt = $pdo->prepare("SELECT * FROM peso WHERE usuario_id = ? ORDER BY fecha DESC");
$stmt->execute([$usuario_elegido]);
$registros = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="container mt-5">
    <?php
    require_once 'db/db.php';

    $usuario_principal = $_SESSION['usuario_id'] ?? null;
    

    // Obtener usuarios asociados
    $stmt = $pdo->prepare("SELECT id, nombre FROM usuarios WHERE creado_por = ? OR id=? ORDER BY nombre");
    $stmt->execute([$usuario_principal, $usuario_principal]);
    $usuarios = $stmt->fetchAll();

    $seleccion = intval($_GET['usuario_id'] ?? 0);
    ?>
    <h2 class="mb-4">Historial de Registros</h2>
    <form method="GET" class="mb-4">
      <input type="hidden" name="p" value="historial">
      <label for="usuario_id">Selecciona un usuario:</label>
      <select name="usuario_id" id="usuario_id" class="form-select w-auto d-inline" onchange="this.form.submit()">
        <option value="">-- Selecciona --</option>
        <?php foreach ($usuarios as $u): ?>
          <option value="<?= $u['id'] ?>" <?= $u['id'] == $seleccion ? 'selected' : '' ?>>
            <?= htmlspecialchars($u['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </form>
<?php if($usuario_elegido){

 ?>
    <p>Datos de <?= htmlspecialchars($usuarios[array_search($seleccion, array_column($usuarios, 'id'))]['nombre']) ?></p>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Fecha</th>
                <th>Peso (kg)</th>
                <th>IMC</th>
                <th>Grasa Corporal (%)</th>
                <th>Músculo (%)</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($registros as $r): ?>
                <tr>
                    <td><?= date('d/m/Y H:i', strtotime($r['fecha'])) ?></td>
                    <td><?= number_format($r['peso'], 2) ?></td>
                    <td><?= number_format($r['imc'], 2) ?></td>
                    <td><?= $r['grasa_corporal']!== null ? number_format($r['grasa_corporal'], 2) : '0.00' ?>%</td>
                    <td><?= $r['musculo']!== null ? number_format($r['musculo'], 2) : '0.00' ?>%</td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
<?php } else{
  echo "<p class='alert alert-warning'>Por favor, selecciona un usuario para ver su historial de peso.</p>";
} ?>

</div>
