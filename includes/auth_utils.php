<?php
function verificarLogin() {
    if (!isset($_SESSION['usuario_id'])) {
        // Si no ha iniciado sesión, redirige al login
        header("Location: ../index.php");
        exit();
    }
}
