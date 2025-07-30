<?php
require_once '../db.php';
session_start();

$creado_por = $_SESSION['usuario_id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $creado_por) {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nombre === '' || $email === '' || $password === '') {
        die('Todos los campos son obligatorios.');
    }

    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die('Ese email ya está registrado.');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password_hash, creado_por, puede_login) VALUES (?, ?, ?, ?, FALSE)");
    $stmt->execute([$nombre, $email, $hash, $creado_por]);

    header('Location: ../index.php?p=usuarios');
    exit;
}
echo 'Acceso no válido';
