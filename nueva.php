<?php
    session_start();

    if( !isset( $_SESSION['email'])){
        header('Location: login.php');
        exit;
    }

    require_once('template/header.php');
    require_once('conexion.php');
?>

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card-dark p-4 p-md-5 w-100" style="max-width:560px;">
        <h1 class="h3 text-center mb-4">Nuevo post</h1>

        <form action="postCrear.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input name="titulo" id="titulo" type="text" class="form-control bg-dark text-white border-secondary" required>
            </div>

            <div class="mb-3">
                <label for="contenido" class="form-label">Detalle</label>
                <textarea name="contenido" id="contenido" class="form-control bg-dark text-white border-secondary" rows="4" placeholder="Describe tu proyecto..." required></textarea>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input name="foto" id="foto" type="file" class="form-control bg-dark text-white border-secondary">
            </div>

            <button type="submit" class="btn btn-warning w-100 mt-2">Guardar</button>
        </form>
    </div>
</div>

<?php
    require_once('template/footer.php');
?>
