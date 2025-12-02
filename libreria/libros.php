<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}
require 'config.php'; // usamos la conexión PDO que ya creaste

// Consulta: todos los títulos con sus autores y editorial
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

/* -------- Carrusel: primeros 10 libros -------- */
$librosCarousel = array_slice($libros, 0, 10);

/* -------- Buscador y filtros -------- */
$q          = trim($_GET['q'] ?? '');
$tipoFiltro = trim($_GET['tipo'] ?? '');

/* Tipos distintos para el combo */
$tipos = [];
foreach ($libros as $libro) {
    if (!in_array($libro['tipo'], $tipos, true)) {
        $tipos[] = $libro['tipo'];
    }
}

/* Aplicar filtros a la lista completa */
$librosFiltrados = array_filter($libros, function ($libro) use ($q, $tipoFiltro) {
    // Filtrar por tipo
    if ($tipoFiltro !== '' && $libro['tipo'] !== $tipoFiltro) {
        return false;
    }

    // Si no hay texto de búsqueda, pasa el filtro
    if ($q === '') {
        return true;
    }

    $texto = ($libro['titulo'] ?? '')   . ' ' .
             ($libro['autores'] ?? '')  . ' ' .
             ($libro['editorial'] ?? '') . ' ' .
             ($libro['id_titulo'] ?? '');

    // stripos = búsqueda case-insensitive
    return stripos($texto, $q) !== false;
});
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
                <li class="nav-item"><a class="nav-link active" href="libros.php">Libros</a></li>
                <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h1 class="mb-3">Listado de libros</h1>

    <?php if (count($libros) === 0): ?>
        <div class="alert alert-info">
            No hay libros registrados en la base de datos.
        </div>
    <?php else: ?>

        <!-- 🔍 Buscador + filtro por tipo -->
        <form class="row g-3 align-items-end mb-4" method="get" action="libros.php">
            <div class="col-md-6">
                <label class="form-label">Buscar</label>
                <input
                    type="text"
                    name="q"
                    class="form-control"
                    placeholder="Título, autor, editorial, código..."
                    value="<?= htmlspecialchars($q) ?>">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tipo</label>
                <select name="tipo" class="form-select">
                    <option value="">Todos</option>
                    <?php foreach ($tipos as $tipo): ?>
                        <option
                            value="<?= htmlspecialchars($tipo) ?>"
                            <?= ($tipo === $tipoFiltro) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($tipo) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    Aplicar filtros
                </button>
            </div>
        </form>

        <!-- 🎠 Carrusel de los primeros 10 libros -->
        <?php if (!empty($librosCarousel)): ?>
            <div id="carouselLibros" class="carousel slide mb-5 book-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php foreach ($librosCarousel as $index => $libro): ?>
                        <?php
                            // 🔁 Rotar entre libro1.jpg, libro2.jpg, libro3.jpg
                            $imgIndex    = ($index % 3) + 1;  // 1,2,3,1,2,3...
                            $rutaPortada = "img/libros/libro{$imgIndex}.jpg";
                        ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <div class="row align-items-center g-4">
                                <div class="col-md-4 text-center">
                                    <div class="book-cover-wrapper-lg mx-auto">
                                        <img src="<?= htmlspecialchars($rutaPortada) ?>"
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
                                    <div class="d-flex align-items-center gap-3">
                                        <span class="book-price-lg">
                                            $ <?= number_format($libro['precio'], 2) ?>
                                        </span>
                                        <span class="text-muted small">
                                            <?= (int)($libro['total_ventas'] ?? 0) ?> ventas
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselLibros" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselLibros" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- 📋 Tabla de libros (con filtros aplicados) -->
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle bg-white shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Autores</th>
                        <th>Editorial</th>
                        <th>Precio</th>
                        <th>Total ventas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($librosFiltrados)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                No se encontraron libros para los filtros seleccionados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($librosFiltrados as $libro): ?>
                            <tr>
                                <td><?= htmlspecialchars($libro['id_titulo']) ?></td>
                                <td><?= htmlspecialchars($libro['titulo']) ?></td>
                                <td><?= htmlspecialchars($libro['tipo']) ?></td>
                                <td><?= htmlspecialchars($libro['autores']) ?></td>
                                <td><?= htmlspecialchars($libro['editorial']) ?></td>
                                <td>$ <?= number_format($libro['precio'], 2) ?></td>
                                <td><?= (int)$libro['total_ventas'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"
></script>
</body>
</html>
