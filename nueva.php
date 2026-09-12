<?php
    session_start();

    if( !isset( $_SESSION['email'])){
        header('Location: login.php');
        exit;
    }

    require_once('template/header.php');
    require_once('conexion.php');
?>

<div class="container">
        <h1 class="text-center text-light">Nuevo post</h1>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="postCrear.php" method="post" enctype="multipart/form-data" class="card p-4">
                    <label for="titulo">Titulo</label>
                    <input name="titulo" type="text" class="form-control">

                    <label for="contenido">Detalle</label>
                    <input name="contenido" type="text" class="form-control">

                    <label for="foto">Foto</label>
                    <input name="foto" type="file" class="form-control">

                    <button type="submit" class="btn btn-warning mt-2">Guardar</button>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

<?php
    require_once('template/footer.php');
?>