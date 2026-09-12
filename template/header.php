<?php
  require_once('template/header.php');
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
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <title>Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body class=" bg-dark">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

    <div class="container-fluid">
      <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="" width="64" height="64" class="img-fluid"> </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
       <span class="navbar-toggler-icon"></span>
      </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- NAVBAR -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="perfil.php">Perfil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item ms-2">
     
          <a href="nueva.php" class="btn btn-warning  ">Crear Post</a>
        
        </li>
      </ul>
      <div class="text-white">

        <?php  echo("<h2 class='fs-5 ms-6'> ¡Hola " . htmlspecialchars($array[0], ENT_QUOTES, 'UTF-8') . "!</h2>"); ?>

        
      </div>
         
    </div>
</nav>

