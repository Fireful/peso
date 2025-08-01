<?php
require_once '../db/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validar entrada
    if ($email === '' || $password === '') {
        die('Debes completar todos los campos.');
    }

    // Buscar usuario
	$stmt = $pdo->prepare("SELECT id, nombre, password_hash, altura FROM usuarios WHERE email = ? AND puede_login = TRUE");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if (!$usuario || !password_verify($password, $usuario['password_hash'])) {
        die('Correo o contraseña incorrectos.');
    }

    // Guardar sesión
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nombre'] = $usuario['nombre'];
    $_SESSION['altura'] = $usuario['altura'];

    header('Location: ../index.php');
    exit;
}

echo 'Acceso no válido';
