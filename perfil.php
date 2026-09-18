<?php
  session_start();

  if( !isset( $_SESSION['email'])){
    header('Location: login.php');
    exit;
  }

  require_once('template/header.php');
  require_once('conexion.php');

  $email = $_SESSION['email'];
  $sql = "SELECT usuarios.nombre_de_usuario, usuarios.email, niveles.rol
                 FROM usuarios
                 INNER JOIN niveles ON niveles.id_niveles = usuarios.id_niveles
                 WHERE usuarios.email = '$email'";

  $respuesta = mysqli_query($conexion, $sql);
  $array = mysqli_fetch_assoc($respuesta);

  $nombre_usuario = htmlspecialchars($array['nombre_de_usuario'] ?? '', ENT_QUOTES, 'UTF-8');
  $email_usuario = htmlspecialchars($array['email'] ?? '', ENT_QUOTES, 'UTF-8');
  $rol_usuario = htmlspecialchars($array['rol'] ?? '', ENT_QUOTES, 'UTF-8');
  $inicial = $nombre_usuario !== '' ? strtoupper(mb_substr($nombre_usuario, 0, 1)) : '?';
?>

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
  <div class="card-dark p-4 p-md-5 text-center w-100" style="max-width:420px;">
    <div class="avatar-circle mx-auto mb-3"><?php echo $inicial; ?></div>

    <h2 class="h4 mb-1">Bienvenido a tu perfil</h2>
    <p class="text-warning fw-semibold mb-4"><?php echo $nombre_usuario; ?></p>

    <ul class="list-unstyled text-start mb-0">
      <li class="mb-3">
        <span class="text-white-50 small d-block">Email</span>
        <?php echo $email_usuario; ?>
      </li>
      <li>
        <span class="text-white-50 small d-block mb-1">Rol</span>
        <span class="badge bg-warning text-dark"><?php echo $rol_usuario; ?></span>
      </li>
    </ul>
  </div>
</div>

<?php
  require_once('template/footer.php');
?>
