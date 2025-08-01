<?php
session_start();
require_once __DIR__ . '/../includes/auth_utils.php';
verificarLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("No se ha enviado el formulario.");
}

// Comprobamos que los campos estén presentes
if (empty($_POST['fecha']) || empty($_POST['peso'])) {
    die("Faltan campos obligatorios.");
}

require_once __DIR__ . '/../db/db.php'; // Asegúrate de que este archivo existe y conecta bien

$usuario_id = $_SESSION['usuario_id'];
$fecha = $_POST['fecha'];
$peso = floatval($_POST['peso']);
$altura = floatval($_SESSION['altura'] ?? 1.73); // Altura por defecto si no se guarda aún

// Cálculo IMC
$imc = round($peso / ($altura * $altura), 2);

// Guardamos
$stmt = $pdo->prepare("INSERT INTO peso (usuario_id, fecha, peso, altura, imc, grasa_corporal, musculo) VALUES (:usuario_id, :fecha, :peso, :altura, :imc, :grasa_corporal, :musculo)");
if (!$stmt) {
    die("Error preparando la consulta: " . $pdo->error);
}
$ok = $stmt->execute([
    ':usuario_id' => $usuario_id,
    ':fecha' => $fecha,
    ':peso' => $peso,
    ':altura' => $altura,
    ':imc' => $imc,
    ':grasa_corporal' => isset($_POST['grasa_corporal']) ? floatval($_POST['grasa_corporal']) : 0,
    ':musculo' => isset($_POST['musculo']) ? floatval($_POST['musculo']) : 0
]);
if ($ok) {
    header("Location: ../index.php");
    exit();
} else {
    die("Error al guardar el registro: " . $stmt->error);
}
