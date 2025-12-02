<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
require 'config.php';

// Traer autores y cuántos libros tienen en el catálogo
$sql = "
    SELECT 
        a.id_autor,
        a.nombre,
        a.apellido,
        COUNT(ta.id_titulo) AS num_libros
    FROM autores a
    LEFT JOIN titulo_autor ta ON a.id_autor = ta.id_autor
    GROUP BY 
        a.id_autor,
        a.nombre,
        a.apellido
    ORDER BY a.apellido, a.nombre;
";

$stmt    = $pdo->query($sql);
$autores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Librería Online - Autores</title>

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous"
    >

    <!-- Tus estilos personalizados -->
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Librería Online</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="libros.php">Libros</a></li>
                <li class="nav-item"><a class="nav-link active" href="autores.php">Autores</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h1 class="mb-1">Autores</h1>
            <p class="text-muted mb-0">
                Explora los autores disponibles en el catálogo de <strong>dblibreria</strong>.
            </p>
        </div>
        <span class="badge bg-primary-subtle text-primary-emphasis px-3 py-2 rounded-pill">
            <?= count($autores) ?> autores registrados
        </span>
    </div>

    <?php if (count($autores) === 0): ?>
        <div class="alert alert-info">
            No hay autores registrados en la base de datos.
        </div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($autores as $index => $autor): ?>
                <?php
                    // 🔁 Rotar entre 3 fotos: autor1, autor2, autor3
                    $imgIndex = ($index % 3) + 1; // 1,2,3,1,2,3...
                    $rutaFoto = "img/autores/autor{$imgIndex}.jpg";
                ?>
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0 author-card">
                        <div class="card-img-top d-flex justify-content-center pt-3">
                            <div class="author-avatar">
                                <img 
                                    src="<?= htmlspecialchars($rutaFoto) ?>" 
                                    alt="Foto de <?= htmlspecialchars($autor['nombre'] . ' ' . $autor['apellido']) ?>"
                                    class="img-fluid rounded-circle"
                                >
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars($autor['nombre'] . ' ' . $autor['apellido']) ?>
                            </h5>
                            <p class="text-muted small mb-2">
                                Código: <?= htmlspecialchars($autor['id_autor']) ?>
                            </p>
                            <span class="badge bg-gradient-primary mb-2">
                                <?= (int)$autor['num_libros'] ?> libro<?= $autor['num_libros'] == 1 ? '' : 's' ?> en el catálogo
                            </span>
                            <p class="card-text small text-muted mt-2">
                                Autor registrado en nuestra base de datos.  
                                Contribuye al catálogo de la librería con títulos de distintas temáticas.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>

<footer class="site-footer mt-5">
    <div class="container d-flex justify-content-between flex-wrap gap-2">
        <span>© <?= date('Y'); ?> Librería Online · Proyecto Final Programación Web</span>
        <span>Desarrollado en PHP · MySQL · Bootstrap</span>
    </div>
</footer>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>
</body>
</html>
