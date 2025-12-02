<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'config.php';  



// Traer libros con autores y editorial (misma consulta que en libros.php)
$sql = "
    SELECT 
        t.id_titulo,
        t.titulo,
        t.tipo AS tipo,
        t.precio,
        t.total_ventas,
        p.nombre_pub AS editorial,
        GROUP_CONCAT(CONCAT(a.nombre, ' ', a.apellido) SEPARATOR ', ') AS autores
    FROM titulos t
    LEFT JOIN titulo_autor ta ON t.id_titulo = ta.id_titulo
    LEFT JOIN autores a ON ta.id_autor = a.id_autor
    LEFT JOIN publicadores p ON t.id_pub = p.id_pub
    GROUP BY 
        t.id_titulo,
        t.titulo,
        tipo,
        t.precio,
        t.total_ventas,
        editorial
    ORDER BY t.titulo;
";
$stmt   = $pdo->query($sql);
$libros = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Primeros 10 para el carrusel
$librosCarousel = array_slice($libros, 0, 10);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Librería Online</title>

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
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="libros.php">Libros</a></li>
                <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- HERO PRINCIPAL -->
<div class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-md-7">
                <h1>Bienvenido a la Librería Online</h1>
                <p>
                    Explora el catálogo de libros y autores de la base de datos
                    <strong>dblibreria</strong> usando PHP, MySQL y PDO.
                    Este portal forma parte de tu proyecto final de Programación Web.
                </p>
                <div class="d-flex gap-2 mt-3">
                    <a href="libros.php" class="btn btn-light">
                        Ver libros
                    </a>
                    <a href="autores.php" class="btn btn-outline-light">
                        Ver autores
                    </a>
                </div>
            </div>
            <div class="col-md-5">
                <div class="bg-white p-4 rounded-4 shadow">
                    <h5 class="mb-3">¿Qué incluye el sitio?</h5>
                    <ul class="list-unstyled mb-0 text-dark">
                        <li>✔ Listado de libros desde MySQL</li>
                        <li>✔ Listado de autores</li>
                        <li>✔ Formulario de contacto guardando en la tabla <code>contacto</code></li>
                        <li>✔ Conexión con PDO (<code>config.php</code>)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CARRUSEL DESTACADOS -->
<?php if (!empty($librosCarousel)): ?>
<section class="py-5 bg-light">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Libros destacados</h2>
            <a href="libros.php" class="btn btn-sm btn-outline-primary">Ver todo el catálogo</a>
        </div>

        <div id="carouselLibrosHome" class="carousel slide book-carousel" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($librosCarousel as $index => $libro): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="row align-items-center g-4">
                            <div class="col-md-4 text-center">
                                <div class="book-cover-wrapper-lg mx-auto">
                                    <!-- Cambia la ruta si luego agregas portadas reales -->
                                    <img src="img/libro-default.png"
                                         class="d-block w-100 book-cover-lg"
                                         alt="Portada de <?= htmlspecialchars($libro['titulo']) ?>">
                                </div>
                            </div>
                            <div class="col-md-8">
                                <span class="badge rounded-pill bg-gradient-primary mb-2">
                                    <?= htmlspecialchars($libro['tipo']) ?>
                                </span>
                                <h3 class="mb-2">
                                    <?= htmlspecialchars($libro['titulo']) ?>
                                </h3>
                                <p class="mb-1 text-muted">
                                    <?= htmlspecialchars($libro['autores'] ?? 'Autor desconocido') ?>
                                </p>
                                <p class="mb-3 text-muted">
                                    <?= htmlspecialchars($libro['editorial'] ?? '') ?>
                                </p>
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="book-price-lg">
                                        $ <?= number_format($libro['precio'], 2) ?>
                                    </span>
                                    <span class="text-muted small">
                                        <?= (int)($libro['total_ventas'] ?? 0) ?> ventas
                                    </span>
                                </div>
                                <a href="libros.php" class="btn btn-primary btn-sm">
                                    Ver en listado
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselLibrosHome" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselLibrosHome" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Siguiente</span>
            </button>
        </div>
    </div>
</section>
<?php endif; ?>

<footer class="site-footer">
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
