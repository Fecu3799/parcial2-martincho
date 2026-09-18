<?php
  require_once('conexion.php');

  if (session_status() === PHP_SESSION_NONE) {
    session_start();
  }
  $email = $_SESSION['email'];
  $sql = "SELECT nombre_de_usuario
                 FROM usuarios
                 WHERE email = '$email'";

 $respuesta = mysqli_query($conexion, $sql);

 $array = mysqli_fetch_row($respuesta);
 $nombre_usuario = htmlspecialchars($array[0] ?? '', ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous" defer></script>
    <title>Tareas</title>
</head>
<body class="bg-dark d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary-subtle sticky-top">
  <div class="container d-flex flex-wrap justify-content-between align-items-center py-2">

    <div class="d-flex align-items-center gap-3">
      <a class="navbar-brand d-flex align-items-center m-0" href="index.php">
        <img src="img/logo.png" alt="Logo" width="48" height="48" class="rounded">
      </a>
      <p class="mb-0 text-white-50 small text-nowrap">¡Hola, <span class="text-white fw-semibold"><?php echo $nombre_usuario; ?></span>!</p>
    </div>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-lg-end" id="navbarSupportedContent">
      <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3 mt-3 mt-lg-0">
        <a class="nav-link active text-white p-0" aria-current="page" href="index.php">Inicio</a>
        <a class="nav-link text-white p-0" href="perfil.php">Perfil</a>
        <a href="nueva.php" class="btn btn-warning fw-semibold px-3">+ Crear Post</a>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
      </div>
    </div>

  </div>
</nav>

<div class="flex-grow-1 d-flex flex-column">
