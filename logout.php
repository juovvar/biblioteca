<?php
session_start();
require_once 'config/parameters.php';

// Elimina todas las variables de sesion
session_unset();

// Destruye la sesion por completo
session_destroy();

// Redirige al index (que ahora mostrara el header publico)
header("Location: " . base_url . "index.php");
exit();
?>