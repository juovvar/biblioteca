<?php
session_start();
require_once 'usuarios.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conexion = new mysqli("localhost", "root", "", "db_biblioteca");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $password_ingresada = $_POST['contrasena'];
    $password_reingresada = $_POST['contrasena2'];

    //Validar la longitud de la contraseña
    if (strlen($password_ingresada) < 12 || strlen($password_ingresada) > 64) {
        $_SESSION['error_registro'] = "La contraseña debe tener entre 12 y 64 caracteres.";
        $conexion->close();
        header("Location: ../registro.php");
        exit();
    }

    //Validar que las contraseñas coincidan
    if ($password_ingresada !== $password_reingresada) {
        $_SESSION['error_registro'] = "Las contraseñas no coinciden.";
        $conexion->close();
        header("Location: ../registro.php");
        exit();
    }

    //Validar si el correo ya esta registrado
    $check_email = $conexion->prepare("SELECT eliminado FROM usuarios WHERE correo = ?");
    $check_email->bind_param("s", $correo);
    $check_email->execute();
    $result = $check_email->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['eliminado'] == 1) {
            $_SESSION['error_registro'] = "El correo electrónico asociado a una cuenta eliminada no puede volver a ser utilizado.";
        } else {
            $_SESSION['error_registro'] = "El correo electrónico ya se encuentra registrado.";
        }
        $check_email->close();
        $conexion->close();
        header("Location: ../registro.php");
        exit();
    }
    $check_email->close();

    //Procesar el registro en la base de datos
    $password_hash = password_hash($password_ingresada, PASSWORD_BCRYPT);
    $id_rol = 2; //Rol del usuario por defecto

    $sql = "INSERT INTO usuarios (id_rol, nombre, correo, contrasena) VALUES ('$id_rol', '$nombre', '$correo', '$password_hash')";

    if ($conexion->query($sql)) {
        echo "<script>alert('Registro exitoso. Ya puedes iniciar sesión.'); window.location.href='../login.php';</script>";
    } else {
        echo "Error: " . $conexion->error;
    }

    $conexion->close();
}
?>