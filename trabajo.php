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

  $sql = "SELECT trabajos.id_trabajos, trabajos.titulo, trabajos.contenido, trabajos.foto_detalle, trabajos.fechas,
                 usuarios.nombre_de_usuario
          FROM trabajos
          LEFT JOIN usuarios ON usuarios.id_usuario = trabajos.id_usuario
          WHERE trabajos.id_trabajos = $id_trabajos";

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
  $autor = $array['nombre_de_usuario'];

  require_once('template/header.php');

$sql2 = "SELECT C.id_comentarios, C.id_usuario, U.email AS emailUsuario,  C.likes, C.respuestas, C.id_trabajos, C.fechas
        FROM comentarios C
        INNER JOIN usuarios U ON U.id_usuario = C.id_usuario
        WHERE id_trabajos = $id_trabajos";

  $resultado2 = mysqli_query($conexion, $sql2);

?>
<div class="container my-5" style="max-width: 900px;">

  <a href="index.php" class="btn btn-outline-light btn-sm mb-4">&larr; Volver al portfolio</a>

  <article class="card-dark rounded-4 border-0 shadow-lg p-4 p-md-5 mb-5">

    <h1 class="fw-bold text-white mb-2"><?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?></h1>

    <p class="text-white-50 small mb-4">
      <?php echo $fechas ? date('d/m/Y', strtotime($fechas)) : ''; ?>
      <?php if( !empty($autor) ): ?>
        &middot; por <?php echo htmlspecialchars($autor, ENT_QUOTES, 'UTF-8'); ?>
      <?php endif; ?>
    </p>

    <div class="rounded-3 overflow-hidden shadow mb-4 text-center bg-dark">
      <img src="<?php echo htmlspecialchars($foto_detalle, ENT_QUOTES, 'UTF-8'); ?>"
           alt="<?php echo htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8'); ?>"
           class="img-fluid w-100" style="max-height: 520px; object-fit: contain;">
    </div>

    <p class="lead text-light mb-4" style="white-space: pre-line;"><?php echo htmlspecialchars($contenido, ENT_QUOTES, 'UTF-8'); ?></p>

  </article>

  <section>
    <h3 class="fw-semibold text-white mb-3">Comentarios y Feedback</h3>

    <div class="p-3 rounded-3 mb-4" style="background-color:#26292d;">
      <form action="guardar.php?id_trabajos=<?php echo $id_trabajos; ?>" method="post">
        <textarea name="respuestas" rows="3"
                  class="form-control bg-dark text-white border-secondary mb-3"
                  placeholder="Escribí una devolución o feedback para este trabajo..."></textarea>
        <button class="btn btn-warning fw-semibold px-4" type="submit">Publicar comentario</button>
      </form>
    </div>

    <?php if( !$resultado2 || mysqli_num_rows($resultado2) === 0 ): ?>

      <p class="text-white-50 small">Aún no hay comentarios. ¡Sé el primero en dejar un feedback!</p>

    <?php else: ?>

      <?php while ($array = mysqli_fetch_assoc($resultado2)): ?>
        <?php
            $emailUsuario = htmlspecialchars($array['emailUsuario'], ENT_QUOTES, 'UTF-8');
            $fechas = $array['fechas'];
            $respuestas = htmlspecialchars($array['respuestas'], ENT_QUOTES, 'UTF-8');
            $inicial_autor = $emailUsuario !== '' ? strtoupper(mb_substr($emailUsuario, 0, 1)) : '?';
        ?>
        <div class="card bg-transparent border border-secondary rounded-3 p-3 mb-3 text-light">
          <div class="d-flex align-items-center gap-2">
            <span class="avatar-circle avatar-sm"><?php echo $inicial_autor; ?></span>
            <span class="fw-semibold text-warning"><?php echo $emailUsuario; ?></span>
            <span class="text-white-50 small ms-auto"><?php echo $fechas ? date('d/m/Y', strtotime($fechas)) : ''; ?></span>
          </div>
          <p class="text-light mb-0 mt-2"><?php echo $respuestas; ?></p>
        </div>
      <?php endwhile; ?>

    <?php endif; ?>
  </section>

</div>

<?php
  require_once('template/footer.php');
?>