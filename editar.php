<?php
    session_start();

    if( !isset( $_SESSION['email'])){
        header('Location: login.php');
        exit;
    }

    require_once('conexion.php');

    if( empty( $_GET['id_trabajos'] ) ){
        header('Location: perfil.php');
        exit;
    }

    $id = (int) $_GET['id_trabajos'];

    if( $id <= 0 ){
        header('Location: perfil.php');
        exit;
    }

    $id_usuario = (int) $_SESSION['id_usuario'];

    $email = mysqli_real_escape_string($conexion, $_SESSION['email']);
    $sql_rol = "SELECT niveles.rol
                FROM usuarios
                INNER JOIN niveles ON niveles.id_niveles = usuarios.id_niveles
                WHERE usuarios.email = '$email'";

    $resultado_rol = mysqli_query($conexion, $sql_rol);
    $array_rol = mysqli_fetch_assoc($resultado_rol);
    $es_administrador = ($array_rol['rol'] ?? '') === 'Administrador';

    if( $es_administrador ){
        $sql = "SELECT id_trabajos, titulo, contenido, foto_url
                FROM trabajos
                WHERE id_trabajos = $id";
    } else {
        $sql = "SELECT id_trabajos, titulo, contenido, foto_url
                FROM trabajos
                WHERE id_trabajos = $id AND id_usuario = $id_usuario";
    }

    $resultado = mysqli_query($conexion, $sql);

    if( !$resultado || mysqli_num_rows($resultado) === 0 ){
        header('Location: perfil.php');
        exit;
    }

    $trabajo = mysqli_fetch_assoc($resultado);

    $titulo = htmlspecialchars($trabajo['titulo'], ENT_QUOTES, 'UTF-8');
    $contenido = htmlspecialchars($trabajo['contenido'], ENT_QUOTES, 'UTF-8');
    $foto_url = htmlspecialchars($trabajo['foto_url'], ENT_QUOTES, 'UTF-8');

    require_once('template/header.php');
?>

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="card-dark p-4 p-md-5 w-100" style="max-width:560px;">
        <h1 class="h3 text-center mb-4">Editar post</h1>

        <form action="postEditar.php" method="post" enctype="multipart/form-data">
            <input name="id_trabajos" type="hidden" value="<?php echo $id; ?>">

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input name="titulo" id="titulo" type="text" class="form-control bg-dark text-white border-secondary" value="<?php echo $titulo; ?>" required>
            </div>

            <div class="mb-3">
                <label for="contenido" class="form-label">Detalle</label>
                <textarea name="contenido" id="contenido" class="form-control bg-dark text-white border-secondary" rows="4" placeholder="Describe tu proyecto..." required><?php echo $contenido; ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto actual</label>
                <div>
                    <img src="<?php echo $foto_url; ?>" alt="<?php echo $titulo; ?>"
                         width="96" height="96" style="object-fit: cover; border-radius: 6px;">
                </div>
            </div>

            <div class="mb-3">
                <label for="foto" class="form-label">Reemplazar foto</label>
                <input name="foto" id="foto" type="file" class="form-control bg-dark text-white border-secondary">
                <span class="text-white-50 small">Dejalo vacío para conservar la foto actual.</span>
            </div>

            <button type="submit" class="btn btn-warning w-100 mt-2">Guardar cambios</button>
            <a href="perfil.php" class="btn btn-outline-light w-100 mt-2">Cancelar</a>
        </form>
    </div>
</div>

<?php
    require_once('template/footer.php');
?>
