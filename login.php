<?php
     session_start();

     $login_error = '';
     $status = $_GET['status'] ?? '';
     $status_mensajes = array(
         'logout'     => 'Has cerrado sesión correctamente.',
         'registered' => '¡Cuenta creada con éxito! Ya podés iniciar sesión.',
     );
     $status_msg = $status_mensajes[$status] ?? '';
     $status_clase = $status === 'registered' ? 'alert-success' : 'alert-info';

     if(  isset( $_POST['email'] ) && isset( $_POST['clave_de_acceso'] )){
         require_once('conexion.php');
         $email = mysqli_real_escape_string($conexion, trim($_POST['email']));
         $password = mysqli_real_escape_string($conexion, trim($_POST['clave_de_acceso']));

         $sql = "SELECT id_usuario, clave_de_acceso, email, nombre_de_usuario
                 FROM usuarios
                 WHERE email = '$email' AND clave_de_acceso = '$password'";

         $resultado = mysqli_query($conexion, $sql);


         $array = mysqli_fetch_assoc($resultado);

         if(  $array ){
             $email = $array['email'];
             $password = $array['clave_de_acceso'];
             $id_usuario = $array['id_usuario'];
             $nombre = $array['nombre_de_usuario'];



             $_SESSION['email'] = $email;
             $_SESSION['clave_de_acceso'] = $password;
             $_SESSION['id_usuario'] = $id_usuario;
             $_SESSION['nombre'] = $nombre;



             header('Location: index.php');

         } else {
             $login_error = 'Usuario o contraseña incorrectos';
         }

     }

?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>

    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>

    <main class="container">
        <div class="row mt-4">
            <div class="col"></div>
            <div class="col">
            <h1 class="text-center text-white">Inicio de sesión</h1>

                <form action="login.php" method="post" class="card p-4 m-1">

                    <?php if(!empty($status_msg)): ?>
                      <div class="alert <?php echo $status_clase; ?> py-2 small text-center mb-3"><?php echo $status_msg; ?></div>
                    <?php endif; ?>

                    <?php if(!empty($login_error)): ?>
                      <div class="alert alert-danger py-2 mt-2"><?php echo $login_error; ?></div>
                    <?php endif; ?>

                    <label for="email">Email</label>
                    <input name="email" class="form-control" type="email">

                    <label for="password">Contraseña</label>
                    <input name="clave_de_acceso" class="form-control" type="password">
                    <button class="btn btn-warning mt-2 mb-4" type="submit">Aceptar</button>

                    <span>o <a href="registro.php">registrarse por primera vez</a></span>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </main>



  </body>
</html>
