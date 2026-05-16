<?php
if (isset($_SESSION['id_usuario'])) {
    $usuario_id = $_SESSION['id_usuario']; 

    try {
        require_once 'config/conexion.php';
        
        //Verificamos que la variable de conexion exista
        if (isset($conexion)) {
            $sql = "SELECT eliminado FROM usuarios WHERE id_usuario = ?";
            $stmt = $conexion->prepare($sql);
            
            if ($stmt) {
                //i: Indica que el parámetro es un entero.
                $stmt->bind_param("i", $usuario_id);
                $stmt->execute();
                
                $result = $stmt->get_result();
                $usuario_db = $result->fetch_assoc();
                
                $stmt->close(); //Cerramos la consulta
                
                // Si el usuario esta marcado como eliminado en la base de datos
                if ($usuario_db && $usuario_db['eliminado'] == 1) {
                    
                    // Destruir la sesion actual
                    $_SESSION = array(); // Limpiar el arreglo de la sesion
                    if (ini_get("session.use_cookies")) {
                        $params = session_get_cookie_params();
                        setcookie(session_name(), '', time() - 42000,
                            $params["path"], $params["domain"],
                            $params["secure"], $params["httponly"]
                        );
                    }
                    session_destroy(); // Destruir el archivo de sesion

                    // Redirige al login con un mensaje de advertencia
                    header('Location: ' . base_url . 'login.php?success=cuenta_eliminada');
                    exit();
                }
            }
        }
    } catch (Exception $e) {
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Biblioteca</title>
    <link rel="stylesheet" href="/biblioteca/assets/css/style.css">
    <link rel="shortcut icon" href="assets/images/logo.png">
    <style>
       /* Estilo para que el cursor cambie a mano al pasar por el boton */
        .clic-nav {
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        /* Eliminar puntos de la lista del menu */
        #menu ul {
            display: flex;
            list-style: none;
            gap: 20px;
            margin: 0;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
  <header style="background: #ffffff56; display: flex; justify-content: space-between; align-items: center; padding: 10px; flex-direction: row; flex-wrap: nowrap;">
  <div style="display: flex; align-items: center; flex-wrap: nowrap;">
    <div style="width: 20px"></div>
    <img class="ImgLogo50" src="assets/images/logo.png" style="width: 50px; height: auto;" alt="Logo">
    <h3 style="margin-left: 20px; white-space: nowrap; margin-bottom: 0;">Biblioteca</h3>
  </div>
  <div style="display: flex; align-items: center; flex-shrink: 0;">
    <h4 style="margin-right: 40px; margin-bottom: 0;"><a href="<?=base_url?>logout.php" class="Bt-Cerrar" style="color: #ff4d4d; white-space: nowrap;">Cerrar sesión</a></h4>
  </div>
</header>
  <nav id="menu" class="Conthcl" style="background: #f4f4f4; border-bottom: 1px solid #ddd;">
    <ul>
      <li><a href="index.php" style="text-decoration: none; color: inherit; font-weight: bold;">Inicio</a></li>
      <li>
        <a href="javascript:void(0)" 
           onclick="document.getElementById('catalogo').scrollIntoView({behavior: 'smooth'})" 
           class="clic-nav" 
           style="font-weight: bold;">
           Catálogo
        </a>
      </li>
      <li>
        <a href="cuenta.php"style="text-decoration: none; color: inherit; font-weight: bold;">Cuenta</a>
      </li>
    </ul>
  </nav>
</body>
</html>