<?php
require 'config.php';

try {
    echo "<h1>Conexión exitosa a dblibreria 🎉</h1>";

    // Probamos un SELECT sencillo
    $stmt = $pdo->query("SELECT * FROM autores LIMIT 5");

    echo "<h2>Primeros autores:</h2>";
    echo "<ul>";
    while ($row = $stmt->fetch()) {
        echo "<li>{$row['id_autor']} - {$row['nombre']} {$row['apellido']}</li>";
    }
    echo "</ul>";

} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}
