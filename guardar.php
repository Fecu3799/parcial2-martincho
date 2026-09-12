<?php
    session_start();
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

    $id_usuario = $_SESSION['id_usuario'];
    $respuestas = mysqli_real_escape_string($conexion, $_POST['respuestas']);
    $fecha = date('Y-m-d');

  $sql = "INSERT INTO comentarios( id_usuario, respuestas, id_trabajos, fechas)
            VALUES('$id_usuario', '$respuestas', '$id_trabajos', '$fecha')";

    mysqli_query($conexion, $sql);

    header('Location: index.php');
    exit;
?>

