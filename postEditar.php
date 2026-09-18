<?php
    session_start();

    if( !isset( $_SESSION['email'])){
        header('Location: login.php');
        exit;
    }

    require_once('conexion.php');

    if( empty( $_POST['id_trabajos'] ) ){
        header('Location: perfil.php');
        exit;
    }

    $id = (int) $_POST['id_trabajos'];

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

    $condicion_dueno = $es_administrador ? '' : " AND id_usuario = $id_usuario";

    $sql_verificar = "SELECT id_trabajos
                      FROM trabajos
                      WHERE id_trabajos = $id" . $condicion_dueno;

    $resultado_verificar = mysqli_query($conexion, $sql_verificar);

    if( !$resultado_verificar || mysqli_num_rows($resultado_verificar) === 0 ){
        header('Location: perfil.php');
        exit;
    }

    $titulo = mysqli_real_escape_string($conexion, trim($_POST['titulo']));
    $contenido = mysqli_real_escape_string($conexion, trim($_POST['contenido']));

    $sql = "UPDATE trabajos
            SET titulo = '$titulo', contenido = '$contenido'
            WHERE id_trabajos = $id" . $condicion_dueno;

    mysqli_query($conexion, $sql);

    if( isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK ){
        $foto_nombre = basename($_FILES['foto']['name']);
        $ruta_temporal = $_FILES['foto']['tmp_name'];

        if( move_uploaded_file($ruta_temporal, 'img/'.$foto_nombre) ){
            $foto_url = mysqli_real_escape_string($conexion, 'img/'.$foto_nombre);

            $sql_foto = "UPDATE trabajos
                         SET foto_url = '$foto_url', foto_detalle = '$foto_url'
                         WHERE id_trabajos = $id" . $condicion_dueno;

            mysqli_query($conexion, $sql_foto);
        }
    }

    header('Location: perfil.php?msg=updated');
    exit;
