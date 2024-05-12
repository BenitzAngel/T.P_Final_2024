<?php
// Inicia la sesión si no está iniciada
session_start();

// Destruye todas las variables de sesión
session_destroy();

// Agrega las cabeceras HTTP para evitar caché
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

// Redirige al usuario a la página de inicio o a donde desees después de cerrar sesión
header("location:../../index.php"); // Cambia "index.php" por la ruta de tu página de inicio o a donde quieras redirigir al usuario

?>
