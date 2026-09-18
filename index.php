<?php
  session_start();
  if( !isset( $_SESSION['email'])){
    header('Location: login.php');
    exit;
  }

  require_once('template/header.php');
  require_once('conexion.php');

  $sql = "SELECT * FROM trabajos INNER JOIN usuarios
          ON usuarios.id_usuario = trabajos.id_usuario";

  $trabajos = mysqli_query($conexion, $sql);
?>

<main>
  <section class="container my-4">
    <img src="img/portada.jpeg" alt="Portada" class="hero-banner shadow">
  </section>

  <h1 class="text-center text-light p-3">Portfolio</h1>
  <p class="text-center text-light fs-5 pb-4">Algunos de los trabajos realizados por la agencia. Haga clic en uno para más información.</p>

  <div class="container my-5">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

      <?php
        while ( $array = mysqli_fetch_assoc($trabajos)) {
          $id_trabajos = (int) $array['id_trabajos'];
          $titulo = htmlspecialchars($array['titulo'], ENT_QUOTES, 'UTF-8');
          $foto_url = htmlspecialchars($array['foto_url'], ENT_QUOTES, 'UTF-8');
          $fechas = htmlspecialchars($array['fechas'], ENT_QUOTES, 'UTF-8');

          if (empty($foto_url) || $foto_url === 'img/') {
            $imagen = "<div class='img-placeholder d-flex align-items-center justify-content-center w-100 h-100'>
                         <svg xmlns='http://www.w3.org/2000/svg' width='40' height='40' fill='currentColor' viewBox='0 0 16 16'>
                           <path d='M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z'/>
                           <path d='M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z'/>
                         </svg>
                       </div>";
          } else {
            $imagen = "<img src='$foto_url' class='card-img-top w-100 h-100' style='object-fit:cover;' alt='$titulo'>";
          }

          echo "
          <div class='col'>
            <div class='card h-100 border-0 shadow-sm'>
              <div class='card-img-wrap'>
                $imagen
              </div>
              <div class='card-body d-flex flex-column justify-content-between'>
                <div>
                  <h5 class='card-title'>$titulo</h5>
                  <p class='card-text text-muted small mb-3'>Publicado el $fechas</p>
                </div>
                <a href='trabajo.php?id_trabajos=$id_trabajos' class='btn btn-warning w-100'>Ver trabajo</a>
              </div>
            </div>
          </div>";
        }
      ?>

    </div>
  </div>
</main>

<?php
  require_once('template/footer.php');
?>
