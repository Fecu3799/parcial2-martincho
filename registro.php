<?php
    session_start();

    $registro_error = '';

    if(  isset( $_POST['email'] ) && isset( $_POST['password'] )){
        require_once('conexion.php');
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['password_confirm'];

        $nombre = mysqli_real_escape_string($conexion, trim($nombre));
        $email = mysqli_real_escape_string($conexion, trim($email));
        $password = mysqli_real_escape_string($conexion, $password);

        if($password != $cpassword){
            $registro_error = '¡Ups! Las contraseñas no coinciden.';
        } else {

            $sql_existe = "SELECT id_usuario
                           FROM usuarios
                           WHERE email = '$email'";

            $resultado_existe = mysqli_query($conexion, $sql_existe);

            if( $resultado_existe && mysqli_num_rows($resultado_existe) > 0 ){
                $registro_error = 'El correo electrónico ya se encuentra registrado.';
            } else {
                $sql = "INSERT INTO usuarios (id_niveles, nombre_de_usuario, clave_de_acceso, email) VALUES (1, '$nombre', '$password', '$email')";
                mysqli_query($conexion, $sql);
                header('Location: login.php?status=registered');
                exit;
            }
        }
    }
?>




<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">

    
</head>
<body class="bg-primary">
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
  
</div>
    <main class="container">
        <div class="row mt-3">
            <div class="col"></div>
            <div class="col">
            <h1 class="text-center text-white">Registrarme</h1>

                <form action="registro.php" method="post" class="card p-4 m-1">

                    <?php if(!empty($registro_error)): ?>
                      <div class="alert alert-danger py-2 small text-center mb-3"><?php echo htmlspecialchars($registro_error, ENT_QUOTES, 'UTF-8'); ?></div>
                    <?php endif; ?>

                    <label for="nombre">Nombre</label>
                    <input name="nombre" class="form-control" type="text">

                    <label for="email">Email</label>
                    <input name="email" class="form-control" type="email">

                    <label for="password">Contraseña</label>
                    <input name="password" class="form-control" type="password">
                  
                    <label for="password">Confirmar contraseña</label>
                    <input name="password_confirm" class="form-control" type="password">

                    <button class="btn btn-warning mt-2 mb-4" type="submit">Registrarme</button>

                    <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </main>

</body>
</html>