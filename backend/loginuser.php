<?php
session_start();
require_once '../config/conexion.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    // Captura la contraseña del formulario
    $password_candidata = trim($_POST['contrasena']); 

    $sql = "SELECT id_usuario, nombre, contrasena, id_rol, eliminado FROM usuarios WHERE correo = '$correo' LIMIT 1";
    $resultado = $conexion->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        // Defino $user aqui (antes de intentar usarlo).
        $user = $resultado->fetch_assoc();
        
        /*BLOQUE DE PRUEBA*/    
            /*
          $longitud_escrita = strlen($password_candidata);
          $longitud_hash = strlen($user['contrasena']);
          echo "<h3>Diagnóstico de Seguridad:</h3>";
          echo "1. Password escrita: [" . $password_candidata . "] (Longitud: $longitud_escrita caracteres)<br>";
          echo "2. Hash en BD: [" . $user['contrasena'] . "] (Longitud: $longitud_hash caracteres)<br>";
if (password_verify($password_candidata, $user['contrasena'])) {
    echo "<h4 style='color:green'>RESULTADO: ¡COINCIDEN!</h4>";
} else {
    echo "<h4 style='color:red'>RESULTADO: NO COINCIDEN</h4>";
    
    // Prueba manual: ¿Qué hash generaría PHP ahora mismo para esa clave?
    echo "<br>3. Hash generado por PHP en este instante para '$password_candidata':<br>";
    echo password_hash($password_candidata, PASSWORD_BCRYPT);
}
exit();
          */
      /*FIN DEL BLOQUE DE PRUEBA*/

        // Verificacion real
        if (password_verify($password_candidata, $user['contrasena'])) {
            // Verificar si el usuario está marcado como eliminado
            if (isset($user['eliminado']) && $user['eliminado'] == 1) {
                $_SESSION['error_login'] = "La cuenta a la cual se intenta ingresar ha sido eliminada de la base de datos.";
                header("Location: ../login.php");
                exit();
            }    
            $_SESSION['id_usuario'] = $user['id_usuario'];
            $_SESSION['nombre'] = $user['nombre'];
            $_SESSION['id_rol'] = $user['id_rol'];

            header("Location: ../index.php");
            exit();
        } else {
            $_SESSION['error_login'] = "La contraseña es incorrecta.";
        }
    } 
    header("Location: ../login.php"); 
    exit();
} else {
    header("Location: ../index.php");
    exit();
}