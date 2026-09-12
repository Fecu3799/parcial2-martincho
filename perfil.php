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

$array = mysqli_fetch_row($respuesta);



?>

<div class="bg-white card col-md-6 mx-auto mt-5">
  <?php
  
  echo("
  <h2 class='p-4 text-center'> Bienvenido a tu perfil " . htmlspecialchars($array[(0)], ENT_QUOTES, 'UTF-8') . "</h2>
  <p class='px-3 fs-5'> Tu email es: " . htmlspecialchars($array[(1)], ENT_QUOTES, 'UTF-8') . " </p>
  <p class='px-3 fs-5'> Tu rol: " . htmlspecialchars($array[(2)], ENT_QUOTES, 'UTF-8') . " </p>
  ");

  ?>
</div>

<?php
  require_once('template/footer.php');
?>