<?php
require_once 'db/db.php';

$usuario_principal = $_SESSION['usuario_id'] ?? null;
if (!$usuario_principal) {
  echo "<p class='alert alert-danger'>Acceso no autorizado.</p>";
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

<?php if ($seleccionado) { ?>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalPeso">Añadir Registro</button>
<!-- Botón para abrir el modal -->
<button class="btn btn-outline-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalCrearObjetivo">Añadir objetivo</button>

  


<?php
$alturas = $alturas ?? [];
$alt = $pdo->prepare("SELECT altura FROM usuarios WHERE id = ? ");
$alt->execute([$user]);
$alturas = $alt->fetchAll(PDO::FETCH_ASSOC);



  // Obtener el objetivo más reciente
  $consulta = $pdo->prepare("SELECT valor_objetivo, imc_objetivo FROM objetivos WHERE usuario_id = ? ORDER BY fecha_creacion DESC LIMIT 1");
  $consulta->execute([$user]);
  $objetivo = $consulta->fetch(PDO::FETCH_ASSOC);
  $imc_objetivo = $objetivo['imc_objetivo'] ?? null;
  $valor_objetivo = $objetivo['valor_objetivo'] ?? null;


  $usuario_id = $_SESSION['usuario_id']; // O como tengas guardado el ID
  $stmt = $pdo->prepare("SELECT fecha, peso, imc FROM peso WHERE usuario_id = ? ORDER BY fecha ASC");
  $stmt->execute([$user]);
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


<?php
  // Generar array del objetivo para cada fecha
  $objetivoArray = array_fill(0, count($fechas), $objetivo);
?>
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
            },
            {
              label: 'Peso Objetivo',
              data: <?= $valor_objetivo ? json_encode(array_fill(0, count($fechas), $valor_objetivo)) : '[]' ?>,
              borderColor: 'rgba(255, 99, 132, 0.5)',
              borderWidth: 2,
              borderDash: [5, 5],
              pointRadius: 1,
              fill: false,
              tension: 0
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
            },
            {
                label: 'Objetivo',
                data: <?= $imc_objetivo ? json_encode(array_fill(0, count($fechas), $imc_objetivo)) : '[]' ?>,
                borderColor: 'rgba(255, 99, 132, 0.5)',
                borderWidth: 2,
                borderDash: [5, 5],
                pointRadius: 1,
                fill: false,
                tension: 0
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
} else{
  echo "<p class='alert alert-warning'>Por favor, selecciona un usuario para ver los gráficos.</p>";
}
?>
