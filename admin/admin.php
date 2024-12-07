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

include_once '../util/conexionMysql.php';

conectar();

$sql = "SELECT id, nombre, correo, dni, direccion, user_rol FROM usuarios";
$sql2 = "SELECT id, nombre, precio, stock, imagen_url FROM productos";
$usuarios = []; // Para almacenar los usuarios obtenidos
$productos = []; // Para almacenar los productos obtenidos

// Para los usuarios
if ($stmt = mysqli_prepare($cnx, $sql)) {
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  while ($usuario = mysqli_fetch_assoc($result)) {
    $usuarios[] = $usuario;
  }
  mysqli_stmt_close($stmt);
} else {
  echo "Error al obtener datos de los usuarios.";
  exit();
}

// Para los productos
if ($stmt = mysqli_prepare($cnx, $sql2)) {
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  while ($producto = mysqli_fetch_assoc($result)) {
    $productos[] = $producto;
  }
  mysqli_stmt_close($stmt);
} else {
  echo "Error al obtener datos de los productos.";
  exit();
}


desconectar();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ripley - Administración</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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

  <main class="container-fluid mt-4 mb-4">
    <div class="container-md overflow-hidden text-center">
      <p class="mb-4 h3">Tabla de Usuarios</p>
      <table class="table table table-striped mb-4">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombres</th>
            <th scope="col">Correo</th>
            <th scope="col">DNI</th>
            <th scope="col">Dirección</th>
            <th scope="col">Rol</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($usuarios as $usuario): ?>
            <tr>
              <td><?= htmlspecialchars($usuario['id']) ?></td>
              <td><?= htmlspecialchars($usuario['nombre']) ?></td>
              <td><?= htmlspecialchars($usuario['correo']) ?></td>
              <td><?= htmlspecialchars($usuario['dni']) ?></td>
              <td><?= htmlspecialchars($usuario['direccion']) ?></td>
              <td><?= htmlspecialchars($usuario['user_rol']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

      <hr />

      <p class="mt-4 mb-4 h3">Tabla de Productos</p>
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Nombre</th>
            <th scope="col">Precio</th>
            <th scope="col">Stock</th>
            <th scope="col">Imagen</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($productos as $producto): ?>
            <tr>
              <td><?= htmlspecialchars($producto['id']) ?></td>
              <td><?= htmlspecialchars($producto['nombre']) ?></td>
              <td><?= htmlspecialchars($producto['precio']) ?></td>
              <td><?= htmlspecialchars($producto['stock']) ?></td>
              <td>
                <img src="../<?= htmlspecialchars($producto['imagen_url']) ?>" width="100px" alt="">
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>