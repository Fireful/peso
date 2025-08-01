<?php
require_once 'db/db.php';

$usuario_principal = $_SESSION['usuario_id'] ?? null;
if (!$usuario_principal) {
  echo "<p class='text-danger'>Acceso no autorizado.</p>";
  return;
}
$user=$_GET['usuario_id'] ?? null;

// Obtener usuarios asociados
$stmt = $pdo->prepare("SELECT id, nombre FROM usuarios WHERE creado_por = ? OR id=? ORDER BY nombre");
$stmt->execute([$usuario_principal, $usuario_principal]);
$usuarios = $stmt->fetchAll();

$seleccionado = intval($_GET['usuario_id'] ?? 0);
?>

<h3>Seguimiento de peso</h3>

<form method="GET" class="mb-4">
  <input type="hidden" name="p" value="peso">
  <label for="usuario_id">Selecciona un usuario:</label>
  <select name="usuario_id" id="usuario_id" class="form-select w-auto d-inline" onchange="this.form.submit()">
    <option value="">-- Selecciona --</option>
    <?php foreach ($usuarios as $u): ?>
      <option value="<?= $u['id'] ?>" <?= $u['id'] == $seleccionado ? 'selected' : '' ?>>
        <?= htmlspecialchars($u['nombre']) ?>
      </option>
    <?php endforeach; ?>
  </select>
</form>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPeso">Añadir Registro</button>
    


<?php
if ($seleccionado) {


  $usuario_id = $_SESSION['usuario_id']; // O como tengas guardado el ID
  $stmt = $pdo->prepare("SELECT fecha, peso, imc FROM peso WHERE usuario_id = ? ORDER BY fecha ASC");
  $stmt->execute([$usuario_id]);
  $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $fechas = [];
  $pesos = [];
  $imcs = [];

  foreach ($registros as $registro) {
      $fechas[] = $registro['fecha'];
      $pesos[] = $registro['peso'];
      $imcs[] = $registro['imc'];
  }

  if (count($registros) > 0):
?>
<div class="mb-4 row">
  <h4>Gráfico de Peso</h4>
  Usuario: <?= $user; ?>
  <p>Datos de <?= htmlspecialchars($usuarios[array_search($seleccionado, array_column($usuarios, 'id'))]['nombre']) ?></p>
  <div class="col-md-6">
    <h5>Peso (kg)</h5>
  <canvas id="graficoPeso" height="200"></canvas>
  </div>
  <div class="col-md-6">
    <h5>IMC</h5>  
  <canvas id="graficoIMC" height="200"></canvas>
</div>
<?php include 'includes/modales.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('graficoPeso').getContext('2d');
const grafico = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($fechas) ?>,
        datasets: [
            {
                label: 'Peso (kg)',
                data: <?= json_encode($pesos) ?>,
                borderColor: 'blue',
                backgroundColor: 'rgba(0,0,255,0.1)',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>

<script>
const ctximc = document.getElementById('graficoIMC').getContext('2d');
const graficoIMC = new Chart(ctximc, {
    type: 'line',
    data: {
        labels: <?= json_encode($fechas) ?>,
        datasets: [
            {
                label: 'IMC',
                data: <?= json_encode($imcs) ?>,
                borderColor: 'green',
                backgroundColor: 'rgba(0,255,0,0.1)',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
</script>

<?php
  else:
    echo "<p>No hay datos de peso para este usuario.</p>";
  endif;
}
?>
