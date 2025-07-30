<?php
session_start();
$pagina = $_GET['p'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mi Salud</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<main class="container mt-4">
  <?php
    $ruta = "includes/$pagina.php";
    if (file_exists($ruta)) {
        include $ruta;
    } else {
        echo "<p class='text-danger'>Página no encontrada.</p>";
    }
  ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
