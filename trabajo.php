<?php
  session_start();

  if( !isset( $_SESSION['email'])){
    header('Location: login.php');
    exit;
  }

  require_once('conexion.php');

  if( empty( $_GET['id_trabajos'] ) ){
      header('Location: index.php');
      exit;
  }

  $id_trabajos = (int) $_GET['id_trabajos'];

  if( $id_trabajos <= 0 ){
      header('Location: index.php');
      exit;
  }

  $sql = "SELECT id_trabajos,titulo, contenido, foto_detalle, fechas
          FROM trabajos
          WHERE id_trabajos = $id_trabajos";

  $resultado = mysqli_query($conexion, $sql);

  if( !$resultado || mysqli_num_rows($resultado) === 0 ){
      header('Location: index.php');
      exit;
  }

  $array =  mysqli_fetch_assoc( $resultado );
  $id_trabajos = $array['id_trabajos'];
  $titulo = $array['titulo'];
  $foto_detalle = $array['foto_detalle'];
  $contenido = $array['contenido'];
  $fechas = $array['fechas'];

  require_once('template/header.php');

$sql2 = "SELECT C.id_comentarios, C.id_usuario, U.email AS emailUsuario,  C.likes, C.respuestas, C.id_trabajos, C.fechas
        FROM comentarios C
        INNER JOIN usuarios U ON U.id_usuario = C.id_usuario
        WHERE id_trabajos = $id_trabajos";

  $resultado2 = mysqli_query($conexion, $sql2);

?>
<main>
    <div class="container">
        <h1>Detalle del Post</h1>
      
        <div class="row mx-auto">
      
            <div class="col-md-10 card p-4 mx-auto">
                <h2 class = "bg-warning p-2 enable-rounded text-center py-3 fs-1"><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></h2>
                <div class="pb-3 pt-3 row row-cols-1 row-cols-md-2 p-auto">
                    <img class="" src="<?php echo $foto_detalle; ?>"  width="" height="" alt="">
                    <p class = "fs-4"><?php echo htmlspecialchars($contenido, ENT_QUOTES, 'UTF-8'); ?></p>
                    <p >Fecha de publicación: <?php echo $fechas; ?></p>
                </div>
      
                <a class='btn btn-dark mt-2' href="index.php">Regresar al Inicio</a>
            </div>
        </div>
    </div>
</main>

<div class="row">
    <div class=""></div>
    <div class="col-md-7 my-5 mx-auto">
        <form action="guardar.php?id_trabajos=<?php echo"$id_trabajos"?>" method="post">
                
            <textarea name="respuestas" placeholder="Agrega un comentario" class="form-control fs-4" name="comentario"  cols="8" rows="3"></textarea>
            <button class="mt-2 btn btn-warning fs-5" type="submit">Publicar</button>
        </form>
    </div>
</div>
    <h2 class='p-4 text-center text-white'> Qué dicen los usuarios sobre este posteo: </h2> 
<?php

    while ($array = mysqli_fetch_assoc($resultado2)) {
      
        $emailUsuario = htmlspecialchars($array['emailUsuario'], ENT_QUOTES, 'UTF-8');
        $fechas = $array['fechas'];
        $respuestas = htmlspecialchars($array['respuestas'], ENT_QUOTES, 'UTF-8');

        echo "
                       
        <div class='row'>
            <div class='card col-md-6 mx-auto mt-3'>
                <div class='card-header fs-5'>
                    <p class=' mt-3 mx-0'> $emailUsuario dice:</p>
                </div>
                <div class='card-body'>
                    <blockquote class='blockquote mb-0'>
                    <p>  $respuestas </p>
                    <footer class='blockquote-footer'> $fechas </footer></blockquote>
                </div>
            </div>
        </div>
        ";

    }

?>

<?php
  require_once('template/footer.php');
?>