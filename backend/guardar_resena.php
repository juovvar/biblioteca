<?php
session_start();
require_once '../config/conexion.php';

if ($_POST && isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];
    $id_libro = (int)$_POST['id_libro'];
    $calificacion = (int)$_POST['rating'];
    $comentario = mysqli_real_escape_string($conexion, $_POST['comentario']);

    // Insertar la reseña en la base de datos
    $sql = "INSERT INTO resenas (id_libro, id_usuario, calificacion, comentario, fecha) 
            VALUES ($id_libro, $id_usuario, $calificacion, '$comentario', CURDATE())";

    if ($conexion->query($sql)) {
        header("Location: ../libros.php?id=" . $id_libro . "&status=success");
    } else {
        header("Location: ../libros.php?id=" . $id_libro . "&status=error");
    }
}
?>