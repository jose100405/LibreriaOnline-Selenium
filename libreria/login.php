<?php
session_start();

// Si viene un mensaje de error por GET (login_procesar.php)
$mensaje = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Librería Online</title>

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

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="index.php">Librería Online</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Inicio</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="libros.php">Libros</a></li>
                <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENIDO PRINCIPAL LOGIN -->
<main class="login-hero">
    <div class="container">
        <div class="row align-items-center g-4 justify-content-center">
            <!-- Texto de bienvenida (lado izquierdo, solo pantallas grandes) -->
            <div class="col-lg-6 d-none d-lg-block">
                <h1 class="login-hero-title">Bienvenido de nuevo</h1>
                <p class="login-hero-text">
                    Inicia sesión para gestionar el catálogo de libros y autores de la
                    <strong>Librería Online</strong>, construida con PHP, MySQL y PDO.
                </p>
            </div>

            <!-- Tarjeta de login -->
            <div class="col-md-8 col-lg-4">
                <section class="login-card shadow">
                    <h2 class="login-title text-center mb-2">Iniciar sesión</h2>
                    <p class="login-subtitle text-center mb-3">
                        Usa las credenciales asignadas para acceder al sistema.
                    </p>

                    <?php if ($mensaje): ?>
                        <div id="errorMessage" class="alert alert-danger py-2 mb-3">
                            <?php echo htmlspecialchars($mensaje); ?>
                        </div>
                    <?php endif; ?>

                    <form action="login_procesar.php" method="post" class="login-form">
                        <div class="mb-3">
                            <label for="txtUsername" class="form-label">Usuario</label>
                            <input
                                id="txtUsername"
                                type="text"
                                name="username"
                                class="form-control"
                                placeholder="Ingresa tu usuario"
                                
                            >
                        </div>

                        <div class="mb-3">
                            <label for="txtPassword" class="form-label">Contraseña</label>
                            <input
                                id="txtPassword"
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Ingresa tu contraseña"
                                
                            >
                        </div>

                        <div class="d-grid">
                            <button id="btnLogin" type="submit" class="btn btn-primary">
                                Entrar
                            </button>
                        </div>
                    </form>
                </section>

                <p class="login-footer text-muted text-center mt-3 mb-0">
                    © <?php echo date('Y'); ?> Librería Online · Proyecto Final Programación Web
                </p>
            </div>
        </div>
    </div>
</main>

<!-- FOOTER IGUAL QUE EN INDEX -->
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
