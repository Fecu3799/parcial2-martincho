<?php
    session_start();

    if( !isset( $_SESSION['email'])){
        header('Location: login.php');
        exit;
    }

    require_once('conexion.php');

    if( $_SERVER['REQUEST_METHOD'] !== 'POST' ){
        header('Location: perfil.php');
        exit;
    }

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

    // Si el borrado se dispara desde la vista global del administrador, se vuelve a ella.
    $volver = ($es_administrador && ($_POST['ver'] ?? '') === 'todas') ? '&ver=todas' : '';

    // Se verifica la propiedad ANTES de tocar los comentarios: si no, un usuario
    // ajeno podria borrar los comentarios de un trabajo que no le pertenece
    // aunque despues el DELETE del trabajo no afecte ninguna fila.
    $sql_verificar = "SELECT id_trabajos
                      FROM trabajos
                      WHERE id_trabajos = $id" . $condicion_dueno;

    $resultado_verificar = mysqli_query($conexion, $sql_verificar);

    if( !$resultado_verificar || mysqli_num_rows($resultado_verificar) === 0 ){
        header('Location: perfil.php?msg=error' . $volver);
        exit;
    }

    // La base no define FOREIGN KEY, asi que la cascada se hace a mano.
    $sql_comentarios = "DELETE FROM comentarios
                        WHERE id_trabajos = $id";

    mysqli_query($conexion, $sql_comentarios);

    $sql = "DELETE FROM trabajos
            WHERE id_trabajos = $id" . $condicion_dueno;

    mysqli_query($conexion, $sql);

    if( mysqli_affected_rows($conexion) > 0 ){
        header('Location: perfil.php?msg=deleted' . $volver);
        exit;
    }

    header('Location: perfil.php?msg=error' . $volver);
    exit;
