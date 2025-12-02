<?php
session_start();
require 'config.php';

// Tomar datos del formulario
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// Validar campos vacíos
if ($username === '' || $password === '') {
    header('Location: login.php?error=Debes completar todos los campos');
    exit;
}

// Consulta a la tabla usuarios
$sql = "SELECT id, username 
        FROM usuarios 
        WHERE username = :user 
          AND password = :pass";   // En tu BD ahora mismo la clave está en texto plano

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'user' => $username,
    'pass' => $password
]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Login correcto: guardar datos en sesión
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario']    = $user['username'];

    // Redirigir a la página principal
    header('Location: index.php');
    exit;
} else {
    // Credenciales incorrectas
    header('Location: login.php?error=Usuario o contraseña incorrectos');
    exit;
}
