<?php
  session_start();

  if( !isset( $_SESSION['email'])){
    header('Location: login.php');
    exit;
  }

  require_once('template/header.php');
  require_once('conexion.php');

  $email = $_SESSION['email'];
  $sql = "SELECT usuarios.id_usuario, usuarios.nombre_de_usuario, usuarios.email, niveles.rol
                 FROM usuarios
                 INNER JOIN niveles ON niveles.id_niveles = usuarios.id_niveles
                 WHERE usuarios.email = '$email'";

  $respuesta = mysqli_query($conexion, $sql);
  $array = mysqli_fetch_assoc($respuesta);

  $id_usuario = (int) ($array['id_usuario'] ?? 0);
  $nombre_usuario = htmlspecialchars($array['nombre_de_usuario'] ?? '', ENT_QUOTES, 'UTF-8');
  $email_usuario = htmlspecialchars($array['email'] ?? '', ENT_QUOTES, 'UTF-8');
  $rol_usuario = htmlspecialchars($array['rol'] ?? '', ENT_QUOTES, 'UTF-8');
  $inicial = $nombre_usuario !== '' ? strtoupper(mb_substr($nombre_usuario, 0, 1)) : '?';

  $es_administrador = ($array['rol'] ?? '') === 'Administrador';

  // Solo un administrador puede pedir la vista global; para el resto se ignora el parametro.
  $vista_todas = $es_administrador && ($_GET['ver'] ?? '') === 'todas';

  if( $vista_todas ){
    $sql_trabajos = "SELECT trabajos.id_trabajos, trabajos.titulo, trabajos.foto_url, trabajos.fechas,
                            usuarios.nombre_de_usuario
                     FROM trabajos
                     LEFT JOIN usuarios ON usuarios.id_usuario = trabajos.id_usuario
                     ORDER BY trabajos.id_trabajos DESC";
  } else {
    $sql_trabajos = "SELECT id_trabajos, titulo, foto_url, fechas
                     FROM trabajos
                     WHERE id_usuario = $id_usuario
                     ORDER BY id_trabajos DESC";
  }

  $resultado_trabajos = mysqli_query($conexion, $sql_trabajos);
  $total_listados = $resultado_trabajos ? mysqli_num_rows($resultado_trabajos) : 0;

  // El contador de la tarjeta siempre refleja las publicaciones propias.
  if( $vista_todas ){
    $sql_propios = "SELECT id_trabajos FROM trabajos WHERE id_usuario = $id_usuario";
    $resultado_propios = mysqli_query($conexion, $sql_propios);
    $total_trabajos = $resultado_propios ? mysqli_num_rows($resultado_propios) : 0;
  } else {
    $total_trabajos = $total_listados;
  }

  $msg = $_GET['msg'] ?? '';
  $alertas = array(
    'deleted' => 'Trabajo eliminado correctamente.',
    'updated' => 'Trabajo actualizado.',
    'error'   => 'No se pudo eliminar el trabajo.',
  );
  $alerta = $alertas[$msg] ?? '';
  $alerta_clase = $msg === 'error' ? 'alert-warning' : 'alert-info';
?>

<div class="container my-5">

  <?php if( $alerta !== '' ): ?>
    <div class="alert <?php echo $alerta_clase; ?> py-2 small text-center mb-4"><?php echo $alerta; ?></div>
  <?php endif; ?>

  <div class="row g-4">

    <div class="col-12 col-lg-4">
      <div class="card-dark p-4 text-center">
        <div class="avatar-circle mx-auto mb-3"><?php echo $inicial; ?></div>

        <h2 class="h4 mb-1">Bienvenido a tu perfil</h2>
        <p class="text-warning fw-semibold mb-4"><?php echo $nombre_usuario; ?></p>

        <ul class="list-unstyled text-start mb-4">
          <li class="mb-3">
            <span class="text-white-50 small d-block">Email</span>
            <?php echo $email_usuario; ?>
          </li>
          <li class="mb-3">
            <span class="text-white-50 small d-block mb-1">Rol</span>
            <span class="badge bg-warning text-dark"><?php echo $rol_usuario; ?></span>
          </li>
          <li>
            <span class="text-white-50 small d-block">Publicaciones</span>
            <span class="fs-4 fw-semibold"><?php echo $total_trabajos; ?></span>
          </li>
        </ul>

        <a href="nueva.php" class="btn btn-warning fw-semibold w-100">+ Crear Nuevo Post</a>
      </div>
    </div>

    <div class="col-12 col-lg-8">
      <div class="card-dark p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-4">
          <div>
            <h2 class="h4 mb-1"><?php echo $vista_todas ? 'Todas las Publicaciones' : 'Mis Publicaciones'; ?></h2>
            <p class="text-white-50 small mb-0">
              <?php echo $vista_todas
                ? 'Vista de administrador: podés editar o purgar cualquier trabajo del sistema.'
                : 'Gestioná los trabajos que subiste a tu portfolio.'; ?>
            </p>
          </div>

          <?php if( $es_administrador ): ?>
            <div class="btn-group btn-group-sm" role="group" aria-label="Seleccionar vista">
              <a href="perfil.php" class="btn <?php echo $vista_todas ? 'btn-outline-light' : 'btn-warning'; ?>">Mis publicaciones</a>
              <a href="perfil.php?ver=todas" class="btn <?php echo $vista_todas ? 'btn-warning' : 'btn-outline-light'; ?>">Todas</a>
            </div>
          <?php endif; ?>
        </div>

        <?php if( $total_listados === 0 ): ?>

          <div class="text-center py-5">
            <?php if( $vista_todas ): ?>
              <p class="text-white-50 mb-1">Todavía no hay publicaciones en el sistema.</p>
              <p class="text-white-50 small mb-4">Cuando alguien suba un trabajo, va a aparecer acá.</p>
            <?php else: ?>
              <p class="text-white-50 mb-1">Todavía no publicaste ningún trabajo.</p>
              <p class="text-white-50 small mb-4">Cuando subas el primero, va a aparecer en esta lista.</p>
            <?php endif; ?>
            <a href="nueva.php" class="btn btn-warning fw-semibold px-4">Subir mi primer post</a>
          </div>

        <?php else: ?>

          <div class="table-responsive">
            <table class="table table-dark table-hover align-middle mb-0">
              <thead>
                <tr class="text-white-50 small">
                  <th scope="col" style="width:64px;">Foto</th>
                  <th scope="col">Publicación</th>
                  <?php if( $vista_todas ): ?>
                    <th scope="col">Autor</th>
                  <?php endif; ?>
                  <th scope="col" class="text-end">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php while( $trabajo = mysqli_fetch_assoc($resultado_trabajos) ): ?>
                  <?php
                    $id_trabajo = (int) $trabajo['id_trabajos'];
                    $titulo_trabajo = htmlspecialchars($trabajo['titulo'], ENT_QUOTES, 'UTF-8');
                    $foto_trabajo = htmlspecialchars($trabajo['foto_url'], ENT_QUOTES, 'UTF-8');
                    $fecha_trabajo = $trabajo['fechas'] ? date('d/m/Y', strtotime($trabajo['fechas'])) : '';
                    $autor_trabajo = htmlspecialchars($trabajo['nombre_de_usuario'] ?? '', ENT_QUOTES, 'UTF-8');
                  ?>
                  <tr>
                    <td>
                      <img src="<?php echo $foto_trabajo; ?>" alt="<?php echo $titulo_trabajo; ?>"
                           width="48" height="48" style="object-fit: cover; border-radius: 6px;">
                    </td>
                    <td>
                      <span class="d-block fw-semibold"><?php echo $titulo_trabajo; ?></span>
                      <span class="text-white-50 small"><?php echo $fecha_trabajo; ?></span>
                    </td>
                    <?php if( $vista_todas ): ?>
                      <td class="text-white-50 small"><?php echo $autor_trabajo !== '' ? $autor_trabajo : '—'; ?></td>
                    <?php endif; ?>
                    <td class="text-end text-nowrap">
                      <a href="trabajo.php?id_trabajos=<?php echo $id_trabajo; ?>" class="btn btn-sm btn-outline-light">Ver</a>
                      <a href="editar.php?id_trabajos=<?php echo $id_trabajo; ?>" class="btn btn-sm btn-outline-warning">Editar</a>
                      <form method="POST" action="postEliminar.php" class="d-inline">
                        <input type="hidden" name="id_trabajos" value="<?php echo $id_trabajo; ?>">
                        <?php if( $vista_todas ): ?>
                          <input type="hidden" name="ver" value="todas">
                        <?php endif; ?>
                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('¿Seguro que deseas eliminar este trabajo?');">Eliminar</button>
                      </form>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>

        <?php endif; ?>
      </div>
    </div>

  </div>
</div>

<?php
  require_once('template/footer.php');
?>
