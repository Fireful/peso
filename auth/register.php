<?php
require_once '../db/db.php';
session_start();

// Validación simple
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nombre === '' || $email === '' || $password === '') {
        die('Todos los campos son obligatorios.');
    }

    // Comprobar si ya existe el email
    $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die('El correo ya está registrado.');
    }

    // Crear usuario
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password_hash) VALUES (?, ?, ?)");
    $stmt->execute([$nombre, $email, $password_hash]);

    // Autologin tras registro
    $_SESSION['usuario_id'] = $pdo->lastInsertId();
    $_SESSION['usuario_nombre'] = $nombre;

    header('Location: ../index.php');
    exit;
}

echo 'Acceso no válido';
