<?php
session_start();
require_once '../config/conexion.php'; // Ajustado el path para que encuentre el archivo

if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_resena = isset($_GET['id']) ? intval($_GET['id']) : 0;
$id_usuario = $_SESSION['id_usuario'];

if ($id_resena > 0) {
    // Usamos sentencia preparada por seguridad
    $stmt = $conexion->prepare("DELETE FROM resenas WHERE id_resena = ? AND id_usuario = ?");
    $stmt->bind_param("ii", $id_resena, $id_usuario);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            header("Location: ../cuenta.php?success=deleted");
        } else {
            header("Location: ../cuenta.php?error=no_permission");
        }
    } else {
        header("Location: ../cuenta.php?error=db_error");
    }
    $stmt->close();
} else {
    header("Location: ../cuenta.php");
}

$conexion->close();
exit();