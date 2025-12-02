<?php
// contacto.php
require_once 'config.php'; // usa la conexión PDO que ya hicimos

$mensajeEnviado = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $nombre     = trim($_POST['nombre']  ?? '');
    $correo     = trim($_POST['correo']  ?? '');
    $comentario = trim($_POST['mensaje'] ?? '');

    // Asunto fijo para todos los mensajes
    $asunto = 'Mensaje desde formulario de contacto';

    // Validación básica
    if ($nombre === '' || $correo === '' || $comentario === '') {
        $error = 'Por favor completa todos los campos.';
    } else {
        try {
            $sql = "INSERT INTO contacto (correo, nombre, asunto, comentario)
                    VALUES (:correo, :nombre, :asunto, :comentario)";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':correo'     => $correo,
                ':nombre'     => $nombre,
                ':asunto'     => $asunto,
                ':comentario' => $comentario
            ]);

            $mensajeEnviado = true;
        } catch (PDOException $e) {
            $error = 'Error al guardar el mensaje: ' . $e->getMessage();
        }
    }
}
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
                <li class="nav-item"><a class="nav-link" href="libros.php">Libros</a></li>
                <li class="nav-item"><a class="nav-link" href="autores.php">Autores</a></li>
                <li class="nav-item"><a class="nav-link active" href="contacto.php">Contacto</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-4">
    <h1 class="mb-3">Contacto</h1>
    <p class="mb-4">
        Esta es una página de ejemplo para el proyecto de la librería.  
        Aquí podrías colocar los datos de contacto de la empresa o un formulario.
    </p>

    <?php if ($mensajeEnviado): ?>
        <div class="alert alert-success">
            ✅ Tu mensaje se guardó correctamente en la base de datos.
        </div>
    <?php elseif ($error !== ''): ?>
        <div class="alert alert-danger">
            ⚠️ <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6 mb-4">
            <h4>Información</h4>
            <ul class="list-unstyled">
                <li><strong>Nombre:</strong> Librería Online</li>
                <li><strong>Correo:</strong> contacto@libreria.test</li>
                <li><strong>Teléfono:</strong> (809) 000-0000</li>
                <li><strong>Dirección:</strong> Calle Ficticia #123, Santo Domingo</li>
            </ul>
        </div>
        <div class="col-md-6">
            <h4>Formulario</h4>
            <!-- IMPORTANTE: method="post" y names en los campos -->
            <form method="post" action="contacto.php">
                <div class="mb-3">
                    <label class="form-label" for="nombre">Nombre</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        id="nombre" 
                        name="nombre" 
                        placeholder="Tu nombre"
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label" for="correo">Correo</label>
                    <input 
                        type="email" 
                        class="form-control" 
                        id="correo" 
                        name="correo" 
                        placeholder="tucorreo@example.com"
                    >
                </div>
                <div class="mb-3">
                    <label class="form-label" for="mensaje">Mensaje</label>
                    <textarea 
                        class="form-control" 
                        id="mensaje" 
                        name="mensaje" 
                        rows="4" 
                        placeholder="Escribe tu mensaje"
                    ></textarea>
                </div>
                <button type="submit" class="btn btn-primary">
                    Enviar
                </button>
            </form>
        </div>
    </div>
</div>


    <!-- Bootstrap JS (para el menú responsive, etc.) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
    ></script>
</body>
</html>

