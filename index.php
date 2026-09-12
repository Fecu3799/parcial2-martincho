 <?php
  session_start();
  if( !isset( $_SESSION['email'])){
    header('Location: login.php');
    exit;
  }

  require_once('template/header.php');
  require_once('conexion.php');

  
  
  
  $sql = "SELECT * FROM trabajos  INNER JOIN usuarios
  
  ON usuarios . id_usuario = trabajos . id_usuario";
 

  $trabajos = mysqli_query($conexion, $sql);
  $usuarios = mysqli_query($conexion, $sql);
  
  
?>



<main class="bg-dark">
  <section>
    <div class = "container-fluid">
      <img src="img/portada.jpeg" alt="" class = "img-fluid" id="fotoportada">
    </div>
  </section>
  <h1 class="text-center text-light p-3">Portfolio</h1>
  <p class="text-center text-light fs-5 pb-5">Algunos de los trabajos realizados por la agencia. Haga clic en uno para más información.</p>

  <div class="row">
    
      <ol class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mx-auto">
        
    

        <?php
          while ( $array =  mysqli_fetch_assoc($trabajos)) {
            $id_trabajos = $array['id_trabajos'];
            $titulo = htmlspecialchars($array['titulo'], ENT_QUOTES, 'UTF-8');
            $foto_url= $array['foto_url'];
            $fechas= htmlspecialchars($array['fechas'], ENT_QUOTES, 'UTF-8');
            $id_usuario = $array['nombre_de_usuario'];

            echo "
            <div class='card m-auto mb-5 p-2' style='width: 22rem;'>
              <img src='$foto_url' class='card-img-top' >
              <div class='card-body'>
                <h5 class='text-dark'>$titulo</h5>
                <p class=''>Fecha de publicación: $fechas</p>
                <a href='trabajo.php?id_trabajos=$id_trabajos' class='btn btn-warning'>Ver Trabajo</a>
              </div>
            </div>";
            
      
          }
          
        ?>

      </ol>
             
  </div>      
</main>
<?php
  require_once('template/footer.php');
?>
