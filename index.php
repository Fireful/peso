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
  <script>
  document.addEventListener('DOMContentLoaded', function () {
      const form = document.getElementById('formCrearObjetivo');

      form.addEventListener('submit', function (e) {
          e.preventDefault();

          const formData = new FormData(form);

          fetch('crear_objetivo.php', {
              method: 'POST',
              body: formData
          })
          .then(res => res.json())
          .then(data => {
              if (data.success) {
                  alert('✅ Objetivo creado correctamente');
                  form.reset();
                  const modal = bootstrap.Modal.getInstance(document.getElementById('modalCrearObjetivo'));
                  modal.hide();
                  // Si tienes una función para refrescar la lista de objetivos, puedes llamarla aquí.
              } else {
                  alert('⚠️ Error: ' + data.message);
              }
          })
          .catch(err => {
              console.error('Error en la petición AJAX:', err);
              alert('❌ Ha ocurrido un error al enviar el formulario.');
          });
      });
  });
  </script>

</body>
</html>
