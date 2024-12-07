<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
} elseif ($_SESSION['rol'] == 'cliente') {
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ripley - Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css'>

    <link rel="icon" type="image/x-icon" href="../img/logo/favicon.ico">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-md">
            <span class="navbar-brand mb-0 h1">Administración</span>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./admin.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="registrar.php">Registrar</a>
                </li>
            </ul>
            <ul class="navbar-nav nav justify-content-end">
                <li class="nav-item">
                    <span class="nav-link" aria-current="page" href="#">
                        <?php echo "¡Bienvenido, " . htmlspecialchars($_SESSION['nombre']) . "!"; ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="logout.php"><span class="h6">Cerrar Sesión</span></a>
                </li>
            </ul>
        </div>
    </nav>