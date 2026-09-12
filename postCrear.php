<?php
    session_start();
    require_once('conexion.php');
    if( !isset( $_SESSION['email'])){
        header('Location: login.php');
        return;
    }

    
    $titulo = mysqli_real_escape_string($conexion, trim($_POST['titulo']));
    $contenido = mysqli_real_escape_string($conexion, trim($_POST['contenido']));
    $fecha = date('Y-m-d');
    $foto_nombre = $_FILES['foto']['name'];
    $ruta_temporal = $_FILES['foto']['tmp_name'];
    $foto_url = 'img/'.$foto_nombre;
    $foto_detalle = 'img/'.$foto_nombre;
    $id_usuario = $_SESSION['id_usuario'];
    move_uploaded_file($ruta_temporal, 'img/'.$foto_nombre );


   
    $sql = "INSERT INTO trabajos( titulo, contenido, foto_url, foto_detalle, id_usuario, fechas)
            VALUES('$titulo', '$contenido', '$foto_url', '$foto_detalle', $id_usuario, '$fecha')";

    mysqli_query($conexion, $sql);

    header('Location: index.php');
    exit;

?>