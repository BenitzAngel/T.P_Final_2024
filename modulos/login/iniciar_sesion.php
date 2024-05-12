<?php
session_start();

// Obtén los datos del formulario
$usuario = $_POST['usuario'];
$contrasenia = $_POST['contrasenia'];





// Conexión a la base de datos (reemplaza con tus propios datos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "panaderia_reina";



// Completa el código para verificar la autenticación
// Realiza una consulta en la base de datos y verifica si las credenciales son válidas

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error en la conexión a la base de datos: " . $conn->connect_error);
}

$sql = "SELECT * FROM usuario where usuario='$usuario' and contrasena='$contrasenia'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $_SESSION['usuario'] = $usuario;
    echo "success";
} else {
    echo 
    "Inicio de sesión fallido. Verifica tus credenciales.";
    
}

// Libera el resultado y cierra la conexión
mysqli_free_result($result);
$conn->close();

?>