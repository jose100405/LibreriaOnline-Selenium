<?php
// config.php
// Configuración de conexión a la base de datos con PDO

$host    = '127.0.0.1';
$port    = '3307';          // IMPORTANTE: el puerto que usa tu MySQL en XAMPP
$dbname  = 'dblibreria';    // nombre de la base de datos que importaste
$username = 'root';         // usuario por defecto de XAMPP
$password = '';             // en XAMPP normalmente el root no tiene contraseña
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
