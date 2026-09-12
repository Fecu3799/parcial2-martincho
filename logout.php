<?php

    session_start();
    unset($_SESSION['materia']);
    session_unset();
    session_destroy();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Sesión Cerrada</title>
</head>
<body class="bg-dark">
    <div class="card position-absolute top-50 start-50 translate-middle" style="width: 25rem;">
  
        <div class="card-body mx-auto">
            <h5 class="card-title">Sesión Cerrada</h5>
            <p class="card-text">La sesión se ha cerrado exitosamente.</p>
            <a href="registro.php" class="btn btn-warning">Volver a iniciar sesión</a>
        </div>
    </div>    


</body>
</html>