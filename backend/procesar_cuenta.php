<?php
session_start();
require_once '../config/conexion.php';

// Verificar que el usuario haya iniciado sesion.
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Cambiar nombre de usuario
if (isset($_POST['nuevo_nombre'])) {
    $nuevo_nombre = mysqli_real_escape_string($conexion, $_POST['nuevo_nombre']);

    $res_actual = $conexion->query("SELECT nombre FROM usuarios WHERE id_usuario = $id_usuario");
    $user_actual = $res_actual->fetch_assoc();

    if ($nuevo_nombre === $user_actual['nombre']) {
        header("Location: ../cuenta.php?error=same_name");
        exit();
    } else {
        $sql = "UPDATE usuarios SET nombre = '$nuevo_nombre' WHERE id_usuario = $id_usuario";
        if ($conexion->query($sql)) {
            header("Location: ../cuenta.php?success=nombre");
        } else {
            header("Location: ../cuenta.php?error=db_error");
        }
        exit();
    }
}

// Cambiar correo electronico
if (isset($_POST['email_nuevo'])) {
    $email_nuevo = mysqli_real_escape_string($conexion, $_POST['email_nuevo']);
    $email_repita = mysqli_real_escape_string($conexion, $_POST['email_repita']);

    // Consultamos correo actual
    $res_actual = $conexion->query("SELECT correo FROM usuarios WHERE id_usuario = $id_usuario");
    $user_actual = $res_actual->fetch_assoc();

    // Validar si es el mismo correo
    if ($email_nuevo === $user_actual['correo']) {
        header("Location: ../cuenta.php?error=same_email");
        exit();
    }

    // Validar si coinciden los campos
    if ($email_nuevo !== $email_repita) {
        header("Location: ../cuenta.php?error=email_mismatch");
        exit();
    }

    try {
        // Verificar si el correo ya está registrado por otro usuario
        $check_sql = "SELECT id_usuario FROM usuarios WHERE correo = ? AND id_usuario != ?";
        $stmt = $conexion->prepare($check_sql);
        $stmt->bind_param("si", $email_nuevo, $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // El correo ya esta en uso por otro usuario
            header("Location: ../cuenta.php?error=email_exists");
            exit();
        }

        $sql = "UPDATE usuarios SET correo = '$email_nuevo' WHERE id_usuario = $id_usuario";
        $conexion->query($sql);
        
        // Cierra sesion obligatoriamente
        session_unset();
        session_destroy();

        header("Location: ../login.php?success=correo");
        exit();

    } catch (mysqli_sql_exception $e) {
        // En caso de que falle la base de datos, redirige de forma controlada.
        header("Location: ../cuenta.php?error=db_error");
        exit();
    }
}

// Cambiar la contraseña
if (isset($_POST['pass_nueva'])) {
    $pass_actual = $_POST['pass_actual'];
    $pass_nueva = $_POST['pass_nueva'];
    $pass_repita = $_POST['pass_repita'];

    // Verificamos la contraseña actual
    $res = $conexion->query("SELECT contrasena FROM usuarios WHERE id_usuario = $id_usuario");
    $user = $res->fetch_assoc();

    if (password_verify($pass_actual, $user['contrasena'])) {
        
        // Validar si la contraseña nueva es la misma a la actual
        if (password_verify($pass_nueva, $user['contrasena'])) {
            header("Location: ../cuenta.php?error=same_password");
            exit();
        }

        if ($pass_nueva === $pass_repita) {
            $pass_encriptada = password_hash($pass_nueva, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET contrasena = '$pass_encriptada' WHERE id_usuario = $id_usuario";
            $conexion->query($sql);

            // Cierra sesion obligatoriamente
            session_unset();
            session_destroy();

            header("Location: ../login.php?success=password");
            exit();
        } else {
            header("Location: ../cuenta.php?error=pass_mismatch");
            exit();
        }
    } else {
        header("Location: ../cuenta.php?error=wrong_current_pass");
        exit();
    }
}

// Cambiar Avatar
if (isset($_FILES['nuevo_avatar'])) {
    $file = $_FILES['nuevo_avatar'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $nombre_archivo = "avatar_" . $id_usuario . "_" . time() . "." . $ext;
    
    // Crear la carpeta avatares si no existe
    $directorio = "../assets/images/avatares/";
    if (!file_exists($directorio)) {
        mkdir($directorio, 0755, true);
    }

    $ruta_destino = $directorio . $nombre_archivo;
    $url_bd = "assets/images/avatares/" . $nombre_archivo;

    if (move_uploaded_file($file['tmp_name'], $ruta_destino)) {
        $conexion->query("UPDATE usuarios SET avatar_url = '$url_bd' WHERE id_usuario = $id_usuario");
        header("Location: ../cuenta.php?success=avatar");
    } else {
        header("Location: ../cuenta.php?error=upload");
    }
    exit();
}

if (isset($_POST['id_resena_edit'])) {
    $id_resena = (int)$_POST['id_resena_edit'];
    $calificacion = (int)$_POST['rating'];
    $comentario = mysqli_real_escape_string($conexion, $_POST['resena_texto_edit']);

    $sql = "UPDATE resenas SET calificacion = $calificacion, comentario = '$comentario' 
            WHERE id_resena = $id_resena AND id_usuario = $id_usuario";
    
    if ($conexion->query($sql)) {
        header("Location: ../cuenta.php?success=edit");
    } else {
        header("Location: ../cuenta.php?error=db");
    }
    exit();
}
// Eliminar Cuenta
if (isset($_POST['accion']) && $_POST['accion'] == 'eliminar_cuenta') {
    $pass_actual = $_POST['pass_actual'];
    $pass_repita = $_POST['pass_repita'];

    if ($pass_actual !== $pass_repita) {
        header("Location: ../cuenta.php?error=pass_mismatch");
        exit();
    }

    $res = $conexion->query("SELECT contrasena FROM usuarios WHERE id_usuario = $id_usuario");
    $user = $res->fetch_assoc();

    if (password_verify($pass_actual, $user['contrasena'])) {
        // Marcamos el usuario como eliminado (eliminado=1)
        $sql = "UPDATE usuarios SET eliminado = 1 WHERE id_usuario = $id_usuario";
        $conexion->query($sql);

        // Destruimos la sesion actual
        session_unset();
        session_destroy();

        header("Location: ../login.php?success=cuenta_eliminada");
        exit();
    } else {
        header("Location: ../cuenta.php?error=wrong_current_pass");
        exit();
    }
}
?>