<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('America/Bogota');

class Connection {
    static public function connect() {
        $db = [
            'server' => 'localhost',
            'user'   => 'root',
            'pass'   => '',
            'datab'  => 'db_biblioteca',
        ];

        try {
            $conn = new mysqli($db['server'], $db['user'], $db['pass'], $db['datab']);
            $conn->set_charset("utf8");

            if ($conn->connect_error) {
                throw new Exception("Fallo de conexión: " . $conn->connect_error);
            }
            
            return $conn;

        } catch (Exception $er) {
            die('Error de Conexión: ' . $er->getMessage());
        }
    }
}
$conexion = Connection::connect();
?>