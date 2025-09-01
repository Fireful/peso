<?php
require '../db/db.php';
session_start();

// Verificamos que el usuario esté autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado.']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$tipo = $_POST['tipo'] ?? '';
$valor_objetivo = floatval($_POST['valor_objetivo'] ?? 0);
$fecha_limite = $_POST['fecha_limite'] ?? null;
$usuario=$_POST['usuario_id'] ?? $usuario_id;

// Validación básica
if ($tipo === '' || $valor_objetivo <= 0) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
    exit;
}
$altura = $pdo->prepare("SELECT altura FROM usuarios WHERE id = ? ");
$altura->execute([$usuario]);
$altura = $altura->fetchColumn();

$imc_objetivo=round($valor_objetivo / ($altura * $altura), 2);

// Insertar objetivo
$stmt = $pdo->prepare("INSERT INTO objetivos (usuario_id, tipo, valor_objetivo, imc_objetivo, fecha_limite)
                      VALUES (?, ?, ?, ?, ?)");
$result = $stmt->execute([$usuario, $tipo, $valor_objetivo, $imc_objetivo, $fecha_limite]);

if ($result) {
    header("Location: ../index.php?p=peso&usuario_id=" . urlencode($usuario));
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'Error al crear el objetivo.']);
}
